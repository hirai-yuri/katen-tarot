<?php

// タロット結果を管理するモデルです。データベースに保存、取得、削除などの操作を行います。
// saveResult()で占い結果をデータベースに保存し、getResultsByUserId()でユーザーごとの結果を取得します。

namespace App\Models;

class TarotResult
{
    private $conn;

    public function __construct()
    {
        // データベース接続を読み込む
        $this->conn = include '../config/db.php';
    }

    // タロット結果を保存するメソッド
    public function saveResult($userId, $tarotResult, $imagePath, $tarotType)
    {
        $stmt = $this->conn->prepare("INSERT INTO tarot_results (user_id, tarot_result, image_path, tarot_type, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("isss", $userId, $tarotResult, $imagePath, $tarotType);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("SQLエラー: " . $stmt->error);
            return false;
        }
    }

    // 指定ユーザーのタロット結果を取得するメソッド
    public function getResultsByUserId($userId)
    {
        $stmt = $this->conn->prepare("SELECT id, tarot_result, image_path, tarot_type, created_at FROM tarot_results WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_r
