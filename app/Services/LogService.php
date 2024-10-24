<?php

// ログ出力に関する処理をまとめたサービスです。
// logError() でエラーログを記録し、logDebug() でデバッグ情報を記録します。どちらもログファイルとして ../storage/logs/php.errors.log に書き込まれます。

namespace App\Services;

class LogService
{
  // エラーログを記録するメソッド
  public function logError($message)
  {
    $logFile = '../storage/logs/php.errors.log';

    // 現在時刻とエラーメッセージをログファイルに書き込む
    $timestamp = date('Y-m-d H:i:s');
    error_log("[$timestamp] ERROR: $message" . PHP_EOL, 3, $logFile);
  }

  // デバッグ用のメッセージをログに記録するメソッド
  public function logDebug($message)
  {
    $logFile = '../storage/logs/php.errors.log';

    // 現在時刻とデバッグメッセージをログファイルに書き込む
    $timestamp = date('Y-m-d H:i:s');
    error_log("[$timestamp] DEBUG: $message" . PHP_EOL, 3, $logFile);
  }
}
