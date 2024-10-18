<?php
session_start();
require '../backend/db_connection.php';

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// 現在のページを取得（デフォルトは1ページ目）
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 3; // 1ページあたりに表示する行数
$offset = ($page - 1) * $limit;


// 全行数を取得してページ数を計算
$count_sql = "SELECT COUNT(*) FROM tarot_results WHERE user_id = ?";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("i", $user_id);
$count_stmt->execute();
$count_stmt->bind_result($total_results);
$count_stmt->fetch();
$count_stmt->close();

$total_pages = ceil($total_results / $limit); // 総ページ数を計算



// ユーザーの占い結果を取得（LIMITとOFFSETを追加）
$sql = "SELECT tarot_result, image_path, tarot_type, created_at FROM tarot_results WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $limit, $offset); // 3つのパラメータを設定（user_id, limit, offset）
$stmt->execute();
$stmt->bind_result($tarotResult, $imagePath, $tarotType, $createdAt);
$results = [];

while ($stmt->fetch()) {
    $results[] = [
        'tarot_result' => $tarotResult,
        'image_path' => $imagePath,
        'tarot_type' => $tarotType,
        'created_at' => $createdAt
    ];
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>占い結果</title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/pc-style.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&display=swap"
        rel="stylesheet" />

</head>

<body class="tarot-result">

    <div class="page">
        <!-- <h1>占い結果</h1> -->

        <?php if (empty($results)): ?>
            <p>まだ占い結果はありません。</p>
        <?php else: ?>
            <table border="1">
                <tr>
                    <th colspan="2">結果</th>
                    <!-- <th>画像</th> -->
                    <!-- <th>日時</th> -->
                </tr>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td>
                            <div class="created_at"><?php
                                                    // データベースの created_at の値を取得
                                                    $created_at = $result['created_at'];

                                                    // DateTime オブジェクトを作成
                                                    $date = new DateTime($created_at);

                                                    // 指定の形式に変換して表示 (例: 2024年5月10日)
                                                    echo htmlspecialchars($date->format('Y年n月j日'), ENT_QUOTES, 'UTF-8');
                                                    ?></div>
                        </td>



                        <td><img src="<?php echo htmlspecialchars($result['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="Tarot result" width="100" class="tarot-image"></td>
                        <!-- <td></td> -->
                    </tr>
                <?php endforeach; ?>
            </table>

            <!-- ページネーション -->
            <div class="pagination <?php echo ($page == 1 || $page == $total_pages) ? 'single-button' : ''; ?>">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">前のページ</a>
                <?php endif; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">次のページ</a>
                <?php endif; ?>
            </div>

        <?php endif; ?>
    </div>

    <!-- モーダルの構造 -->
    <div id="imgModal" class="modal">
        <div class="modal-content">
            <img id="modal-tarot-image">
            <div class="close">とじる</div> <!-- 閉じるボタン -->
            <div class="delete">削除</div> <!-- 削除ボタン -->
        </div>
    </div>

    <img src="../img/占い結果猫画像.png" alt="" id="neko">
    <div class="return"><a href="./index.php">トップページに戻る</a></div>


    <script>
        // JavaScriptによるモーダル表示処理
        var modal = document.getElementById("imgModal");
        var modalImg = document.getElementById("modal-tarot-image");
        var closeBtn = document.getElementsByClassName("close")[0];

        // すべてのtarot-imageクラスの画像に対してクリックイベントを追加
        var images = document.getElementsByClassName("tarot-image");
        for (var i = 0; i < images.length; i++) {
            images[i].onclick = function() {
                modal.style.display = "block"; // モーダルを表示
                modalImg.src = this.src; // クリックした画像のソースをモーダル内の画像に設定
            };
        }

        // 閉じるボタンをクリックしたとき
        closeBtn.onclick = function() {
            modal.style.display = "none"; // モーダルを閉じる
        }

        // モーダルの外側をクリックしたときに閉じる
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>