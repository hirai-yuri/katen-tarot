'use strict';
$(function() {
  $('#exampleModal').on('show.bs.modal', function () {
    var title = $('#formTitle').val()
    var body = $('#formBody').val()
    var modal = $(this)
    modal.find('#modalTitle').text(title)
    modal.find('#modalBody').text(body)
  })
})
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