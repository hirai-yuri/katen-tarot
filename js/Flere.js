'use strict';



document.getElementById('Flere210').onclick=function(event){
  event.preventDefault();//タグの動作をキャンセルするメソッド。
  let ele = document.getElementById('loading');
  ele.style.display = 'block';
  document.form.submit();


}
