'use strict';
$(document).ready(function () {

  var close = $('.modal-close'),
    container = $('.modal-container');

  var error = "";
  $('#entry_conf').click(function () {
    if (error != "") {
      return false;
    } else {
      container.addClass('active');
      $('#entry_send').attr("type", "submit");
      return false;
    }
  });

  close.on('click', function () {
    container.removeClass('active');
  });

  $(document).on('click', function (e) {
    if (!$(e.target).closest('.modal-body').length) {
      container.removeClass('active');
    }
  });

});
// var modal = document.getElementById('demo-modal');
// var btn = document.getElementById('open-modal');
// var close = modal.getElementsByClassName('close')[0];

// // When the user clicks the button, open the modal.
// btn.onclick = function() {
//   modal.style.display = 'block';
// };

// // When the user clicks on 'X', close the modal
// close.onclick = function() {
//   modal.style.display = 'none';
// };

// // When the user clicks outside the modal -- close it.
// window.onclick = function(event) {
//   if (event.target == modal) {
//     // Which means he clicked somewhere in the modal (background area), but not target = modal-content
//     modal.style.display = 'none';
//   }
// };
// $(function() {
//   $('#exampleModal').on('show.bs.modal', function () {
//     var title = $('#formTitle').val()
//     var body = $('#formBody').val()
//     var modal = $(this)
//     modal.find('#modalTitle').text(title)
//     modal.find('#modalBody').text(body)
//   })
// })
// $(document).ready(function() {				
//   const $body = $('body');				
//   const $modal = $('#modal');				
//   const $modalOpenButton = $('.js-modal-open');				
//   const $modalCloseButton = $('.js-modal-close');				
          
//   const openModal = () => {				
//   $modal.fadeIn();				
//   $body.css('overflow', 'hidden');				
//   };				
          
//   const closeModal = () => {				
//   $modal.fadeOut();				
//   $body.css('overflow', 'auto');				
//   };				
          
//   const onClickOutside = (event) => {				
//   if ($modal.is(event.target)) closeModal();				
//   }				
          
//   $modalOpenButton.on('click', openModal);				
//   $modalCloseButton.on('click', closeModal);				
//   $modal.on('click', onClickOutside);				
//   });				