"use strict";

// チェックボックスがクリックされたときに、他のチェックボックスを無効化する関数
function chbx(obj) {
  let that = obj;

  // クリックされたチェックボックスが選択されている場合
  if (document.getElementById(that.id).checked == true) {
    // すべてのチェックボックスを取得
    let boxes = document.querySelectorAll('input[type="checkbox"]');

    // すべてのチェックボックスを無効化
    for (let i = 0; i < boxes.length; i++) {
      boxes[i].checked = false;
    }

    // クリックされたチェックボックスだけを有効化
    document.getElementById(that.id).checked = true;
  }
}
