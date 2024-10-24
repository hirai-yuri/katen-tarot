<?php

# タロット結果のデータベース操作

namespace App\Models;

use PDO;
use PDOException;

class TarotResult
{
    private $pdo;

    public function __construct($db)
    {
        $this->pdo = $db;
    }

    // タロット占いの結果を保存
    public function saveResult($userId, $tarotResult, $tarotType, $imagePath)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO tarot_results (user_id, result, tarot_type, image_path, created_at) VALUES (:user_id, :result, :tarot_type, :image_path, NOW())");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':result', $tarotResult, PDO::PARAM_STR);
            $stmt->bindParam(':tarot_type', $tarotType, PDO::PARAM_STR);
            $stmt->bindParam(':image_path', $imagePath, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            // エラーログなどを追加するとよい
            return false;
        }
    }

    // ユーザーIDに基づくタロット結果を取得
    public function getResultsByUserId($userId)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tarot_results WHERE user_id = :user_id ORDER BY created_at DESC");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // エラーハンドリング
            return [];
        }
    }
}
