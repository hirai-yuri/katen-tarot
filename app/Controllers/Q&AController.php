<?php


// Q&A関連のページの表示と問い合わせ処理を行います。
// sendInquiry()メソッドで、ユーザーからの問い合わせを処理し、保存やメール送信を行います。


namespace App\Controllers;

use App\Models\QAModel;
use App\Services\LogService;

class QAController
{
  private $qaModel;
  private $logService;

  public function __construct()
  {
    $this->qaModel = new QAModel();
    $this->logService = new LogService();
  }

  // Q&Aのページ表示
  public function showQA()
  {
    include_once '../app/views/q&a/Q&A.php';
  }

  // 確認ページの表示
  public function showConfirm()
  {
    include_once '../app/views/q&a/confirm.php';
  }

  // メール送信処理
  public function sendInquiry($data)
  {
    if ($this->qaModel->saveInquiry($data)) {
      // メール送信処理（例: mb_send_mailなど）
      $this->logService->logInfo('Inquiry sent successfully');
      return true;
    } else {
      $this->logService->logError('Failed to send inquiry');
      return false;
    }
  }
}
