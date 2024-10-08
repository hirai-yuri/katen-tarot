<?php
// // POSTリクエスト以外をブロック
// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//   http_response_code(405); // メソッドが許可されていない場合に405エラーを返す
//   exit('Method Not Allowed');
// }
// session_start(); // セッションを開始

// // JavaScriptから送信されたJSONデータを受け取る
// $data = json_decode(file_get_contents('php://input'), true);

// // ユーザーの名前が送信されているかチェックし、セッションに保存
// if (isset($data['name'])) {
//   $_SESSION['user_name'] = $data['name'];
// }

// // タロットの結果が送信されているかチェックし、セッションに保存
// if (isset($data['tarot_result'])) {
//   $_SESSION['tarot_result'] = $data['tarot_result'];
// }

// // 成功したことをJSONで返す
// echo json_encode(['status' => 'success']);
