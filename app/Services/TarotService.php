<?php

// タロット占いのビジネスロジックをまとめたサービスです。TarotResult モデルを使用して、結果の保存、取得、削除を行います。
// ユーザーIDに基づいてタロット結果を取得する getUserTarotResults() や、結果を削除する deleteTarotResult() などのメソッドがあります。

namespace App\Services;

use App\Models\TarotResult;

class TarotService
{
  private $tarotResult;

  public function __construct()
  {
    $this->tarotResult = new TarotResult();
  }

  // タロット結果を保存する処理
  public function saveTarotResult($userId, $tarotResult, $imagePath, $tarotType)
  {
    return $this->tarotResult->saveResult($userId, $tarotResult, $imagePath, $tarotType);
  }

  // ユーザーIDに基づいてタロット結果を取得する処理
  public function getUserTarotResults($userId)
  {
    return $this->tarotResult->getResultsByUserId($userId);
  }

  // タロット結果を削除する処理
  public function deleteTarotResult($resultId, $userId)
  {
    return $this->tarotResult->deleteResult($resultId, $userId);
  }
}
