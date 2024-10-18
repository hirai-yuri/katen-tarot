<?php
session_start();
require '../backend/db_connection.php';

// ユーザーがログインしているか確認
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// リクエストのデータを受け取る
$data = json_decode(file_get_contents("php://input"), true);

// デバッグ用に受け取ったデータを確認
if ($data === null) {
  header('Content-Type: application/json');
  echo json_encode(["success" => false, "error" => "データが受信されていないか、JSONのデコードに失敗しました"]);
  exit();
}

if (isset($data['result_id'])) {
  $result_id = $data['result_id'];

  // データベースから占い結果を削除
  $sql = "DELETE FROM tarot_results WHERE id = ? AND user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $result_id, $user_id);

  if ($stmt->execute()) {
    header('Content-Type: application/json');
    echo json_encode(["success" => true]);
  } else {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "error" => $stmt->error]);
  }

  $stmt->close();
  $conn->close();
} else {
  header('Content-Type: application/json');
  echo json_encode(["success" => false, "error" => "無効なリクエストです"]);
}
