<?php

// 過去のタロット占い結果を表示するページ。ユーザーがログインしている場合、占い結果の一覧とその画像が表示されます。ページネーションも含まれています。

session_start();
require '../../config/db.php';

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
  header("Location: /views/user/login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 3;
$offset = ($page - 1) * $limit;

// タロット結果の取得
$sql = "SELECT id, tarot_result, image_path, tarot_type, created_at FROM tarot_results WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $limit, $offset);
$stmt->execute();
$stmt->bind_result($id, $tarot_result, $image_path, $tarot_type, $created_at);
$results = [];

while ($stmt->fetch()) {
  $results[] = [
    'id' => $id,
    'tarot_result' => $tarot_result,
    'image_path' => $image_path,
    'tarot_type' => $tarot_type,
    'created_at' => $created_at
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
  <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>
  <div class="tarot-results-container">
    <h1>占い結果</h1>

    <?php if (empty($results)): ?>
      <p>まだ占い結果はありません。</p>
    <?php else: ?>
      <table border="1">
        <tr>
          <th>結果</th>
          <th>画像</th>
        </tr>
        <?php foreach ($results as $result): ?>
          <tr>
            <td><?php echo htmlspecialchars($result['tarot_result'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><img src="<?php echo htmlspecialchars($result['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="Tarot result" width="100"></td>
          </tr>
        <?php endforeach; ?>
      </table>

      <!-- ページネーション -->
      <div class="pagination">
        <?php if ($page > 1): ?>
          <a href="?page=<?php echo $page - 1; ?>">前のページ</a>
        <?php endif; ?>
        <?php if (count($results) == $limit): ?>
          <a href="?page=<?php echo $page + 1; ?>">次のページ</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="return">
    <a href="/public/index.php">トップページに戻る</a>
  </div>
</body>

</html>