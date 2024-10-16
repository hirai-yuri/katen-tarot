<?php
session_start();
require './backend/db_connection.php';

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ユーザーの占い結果を取得
$sql = "SELECT tarot_result, image_path, tarot_type, created_at FROM tarot_results WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
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
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/pc-style.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&display=swap"
        rel="stylesheet" />

</head>

<body class="tarot-result">
    <h1>占い結果</h1>

    <?php if (empty($results)): ?>
        <p>まだ占い結果はありません。</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <!-- <th>占いの種類</th> -->
                <th>結果</th>
                <th>画像</th>
                <th>日時</th>
            </tr>
            <?php foreach ($results as $result): ?>
                <tr>
                    <!-- <td><?php echo htmlspecialchars($result['tarot_type'], ENT_QUOTES, 'UTF-8'); ?></td> -->
                    <td><?php echo nl2br(htmlspecialchars($result['tarot_result'], ENT_QUOTES, 'UTF-8')); ?></td>
                    <td><img src="<?php echo htmlspecialchars($result['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="Tarot result" width="100"></td>
                    <td><?php echo htmlspecialchars($result['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <p><a href="./index.php">トップページに戻る</a></p>
</body>

</html>