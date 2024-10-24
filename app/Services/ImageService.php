<?php

// 画像の保存や削除を行うサービスです。
// saveImage()でBase64エンコードされた画像をデコードしてファイルとして保存し、deleteImage()で指定された画像ファイルを削除します。
// 画像のパスを ../public/images/tarot_results/ に保存するように設計しています。

namespace App\Services;

class ImageService
{
  // 画像を保存するメソッド
  public function saveImage($base64Image, $filename)
  {
    // Base64からデコード
    $imgData = str_replace('data:image/jpeg;base64,', '', $base64Image);
    $imgData = str_replace(' ', '+', $imgData);
    $decodedData = base64_decode($imgData);

    // 画像を保存するパス
    $filePath = "../public/images/tarot_results/" . $filename;

    // 画像を保存し、成功/失敗を返す
    if (file_put_contents($filePath, $decodedData)) {
      return $filePath;
    } else {
      error_log("Failed to save image: " . $filename);
      return false;
    }
  }

  // 画像を削除するメソッド
  public function deleteImage($filePath)
  {
    if (file_exists($filePath)) {
      unlink($filePath);
      return true;
    } else {
      error_log("File does not exist: " . $filePath);
      return false;
    }
  }
}
