(function($){
  function emptyModal(){
    var pa = $(document).find('.modal-uploads');
    pa.addClass('hidden');
    pa.find('innerest').html('');
  }
  $("#checkbox-all").change(function () {
    if ($(this).is(':checked')){
       $("input:checkbox").each(function (){
          $(this).prop("checked", true);
          });
       }else{
          $("input:checkbox").each(function (){
               $(this).prop("checked", false);
          });
       }
  });
  $(document).on("submit",".mass-actions-form", function(event){
    var optionText = $(".chooseaction option:selected").val();
    if(optionText=='0'){
      event.preventDefault();
    }else{
      $('.btn-primary.btn-apply-action').prepend('<i class="fa fa-spinner fa-spin"></i>');
    }
  });

  $(document).on('click', 'input.uploadunique', function(event){
    $('input').removeClass('beingprocessed');
    $(this).addClass('beingprocessed');

    var token = $('[name="csrf-token"]').prop('content');
    var chosen= $(this);
    var modulex= $(this).data('module');

    $('.modal-uploads').removeClass('hidden').find('.uploads-frame-inner .innerest').html('<i class="fas fa-spinner fa-spin"></i>');
      $.ajax({
        url: '/'+filemanagerUrl+'/modaluploader',
        type: 'POST',
        crossDomain: false,
        data: { _token: token, module:modulex},
        success: function (response) {
          $('.uploads-frame-inner').find('.innerest').html(response.html);
        },
        error: function (errors) {
          alert(JSON.stringify(errors));
        }
      });
      event.stopImmediatePropagation();
  });
  $(document).on('click', '.closemodal', function(e){
    emptyModal();
  });
  $(document).on('click', '.insert-cta', function(e){
    var toGo = $('.returnurl').val();
    $('.beingprocessed').val(toGo);
    emptyModal();
  });
})(jQuery);
