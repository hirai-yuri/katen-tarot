<?php

// タロット占いに関する処理を管理します。
// 占い結果を保存し、画像の生成と保存を行い、占い結果のページを表示する機能を提供します。

namespace App\Controllers;

use App\Models\TarotResult;
use App\Services\TarotService;
use App\Services\ImageService;
use App\Services\LogService;

class TarotController
{
  private $tarotService;
  private $imageService;
  private $logService;

  public function __construct()
  {
    $this->tarotService = new TarotService();
    $this->imageService = new ImageService();
    $this->logService = new LogService();
  }

  // タロット占いの表示
  public function showTarotPage()
  {
    include_once '../app/views/tarot/tarot.php';
  }

  // 占い結果の保存
  public function saveResult($userId, $tarotResult, $tarotType, $imgData)
  {
    $filename = $this->imageService->saveImage($imgData);
    if ($filename && $this->tarotService->saveResult($userId, $tarotResult, $tarotType, $filename)) {
      $this->logService->logInfo('Tarot result saved successfully');
      return true;
    } else {
      $this->logService->logError('Failed to save tarot result');
      return false;
    }
  }

  // 占い結果の表示
  public function showResult($userId)
  {
    $results = $this->tarotService->getResultsByUserId($userId);
    include_once '../app/views/tarot/tarotresult.php';
  }
}
