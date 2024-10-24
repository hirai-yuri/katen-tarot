<?php

use PHPUnit\Framework\TestCase;
use app\Services\TarotService;

class TarotTest extends TestCase
{
  protected $tarotService;

  protected function setUp(): void
  {
    // TarotService のインスタンスを作成
    $this->tarotService = new TarotService();
  }

  public function testShuffleCards(): void
  {
    // テスト対象のメソッドを実行
    $cards = range(1, 22); // 22枚のカードを想定
    $shuffledCards = $this->tarotService->shuffleCards($cards);

    // カードがシャッフルされていることを確認（順番が異なることを確認）
    $this->assertNotEquals($cards, $shuffledCards);

    // シャッフル後のカードも22枚であることを確認
    $this->assertCount(22, $shuffledCards);
  }

  public function testSplitCardsIntoBundles(): void
  {
    // 22枚のカードを3つの束に分ける
    $cards = range(1, 22);
    $bundles = $this->tarotService->splitCardsIntoBundles($cards, 3);

    // 3つの束に分かれていることを確認
    $this->assertCount(3, $bundles);

    // 各束がカードを含んでいることを確認
    $this->assertGreaterThan(0, count($bundles[0]));
    $this->assertGreaterThan(0, count($bundles[1]));
    $this->assertGreaterThan(0, count($bundles[2]));
  }

  public function testSaveTarotResult(): void
  {
    // モックのデータベース接続
    $mockDb = $this->createMock(mysqli::class);

    // TarotService にモックのDB接続を設定
    $this->tarotService->setDbConnection($mockDb);

    // モックのDB接続での期待される動作を定義
    $mockDb->expects($this->once())
      ->method('prepare')
      ->willReturn(true); // ダミーのprepareメソッド

    // タロット結果の保存をテスト
    $result = $this->tarotService->saveTarotResult(1, '成功', '/path/to/image.jpg', '今日の運勢');

    // 結果が保存されたことを確認
    $this->assertTrue($result);
  }
}
