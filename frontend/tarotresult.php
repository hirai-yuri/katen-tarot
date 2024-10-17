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
                    <th>結果</th>
                    <th>画像</th>
                    <!-- <th>日時</th> -->
                </tr>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($result['tarot_type'], ENT_QUOTES, 'UTF-8'); ?><br>
                            <div class="tarot_result_text"><?php echo nl2br(htmlspecialchars(str_replace(array('\\n', '\\r'), "\n", $result['tarot_result']), ENT_QUOTES, 'UTF-8')); ?></div>

                            <div class="created_at"><?php echo htmlspecialchars($result['created_at'], ENT_QUOTES, 'UTF-8'); ?></div>
                        </td>



                        <td><img src="<?php echo htmlspecialchars($result['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="Tarot result" width="100"></td>
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

    <img src="../img/占い結果猫画像.png" alt="" id="neko">
    <div class="return"><a href="./index.php">トップページに戻る</a></div>

</body>

</html>