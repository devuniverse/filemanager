(function($){
  function emptyModal(){
    var pa = $(document).find('.modal-uploads');
    pa.addClass('hidden');
    pa.find('innerest').html('');
  }
  function revealModal(){
    $('.modal-uploads').removeClass('hidden').find('.uploads-frame-inner .innerest').html('<i class="fas fa-spinner fa-spin"></i>');
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

    revealModal();
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
    var togoID = $('.chosenone').data('id');
    $('.beingprocessed').val(toGo).closest('.custominput-container');
    $('.beingprocessed').closest('.custominput-container').find('img').remove();
    $('.beingprocessed').closest('.custominput-container').append('<img src="'+ toGo +'" />');
    emptyModal();
  });
  $(document).on('click', '*[data-id]', function(event){
    event.preventDefault();
    if( $(this).data('id') !='' ){
      var token = $('[name="csrf-token"]').prop('content');
      var chosen= $(this);
      var imgId= $(this).data('id');
      var url = chosen.prop('src');
      revealModal();
      $('.modal-uploads').removeClass('hidden').find('.uploads-frame-inner .innerest').html('<iframe src="/'+filemanagerUrl+'/modalcropper?img='+url+'&identifier='+imgId+'" width="100%" height="750" style="border:0"></iframe>');
    }

  });

  $(document).on('change', 'input[name="uploaded-files"]', function(){
    $('.file-inner img').removeClass('chosenone');
    $(this).closest('.file-inner').find('img').addClass('chosenone');
    var theUrl = $(this).closest('.file-inner').find('img').prop('src');
    $('.cta-caller-container').html('<div class="return-input">'+
    '<input class="returnurl" name="returnurl" readonly value="'+theUrl+'" />'+
    '<button type="button" class="btn btn-primary insert-cta" disabled>Insert</button>'+
    '</div>');
    $('.insert-cta').prop('disabled', false);
  });
})(jQuery);
