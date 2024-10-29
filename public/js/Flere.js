'use strict';
document.getElementById('Flere210').onclick=function(event){
  event.preventDefault();//タグの動作をキャンセルするメソッド。
  let ele = document.getElementById('loading');
  ele.style.display = 'block';
  document.form.submit();
}
$(window).on('load',function(){
  $("#loading").delay(17300);
  //ローディング画面を1.2秒（1200ms）待機してからフェードアウト
});
var bar = new ProgressBar.Line(loading_text, {//id名を指定
  strokeWidth: 0,//進捗ゲージの太さ
  duration: 5100,//時間指定(1000＝5秒)
  trailWidth: 0,//線の太さ
  text: {//テキストの形状を直接指定 
    style: {
      position:'absolute',
      left:'50%',
      top:'80%',
      margin:'0',
      transform:'translate(-50%,-50%)',
      'font-family':'sans-serif',
      'font-size':'1.5rem',
      color:'#333',
    },
    autoStyleContainer: false //自動付与のスタイルを切る
  },
  step: function(state, bar) {
    bar.setText(Math.round(bar.value() * 100) + ' %'); //テキストの数値
  }
});
bar.animate(1.0, function () {});
  //バーを描画する割合を指定します 1.0 なら100%まで描画
