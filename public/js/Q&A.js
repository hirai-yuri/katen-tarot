'use strict';
  function chbx(obj) {
  let that = obj;
  if (document.getElementById(that.id).checked == true) {
    let boxes = document.querySelectorAll('input[type="checkbox"]');

    for (let i = 0; i < boxes.length; i++) {
      boxes[i].checked = false;
    }
    document.getElementById(that.id).checked = true;
  }
}