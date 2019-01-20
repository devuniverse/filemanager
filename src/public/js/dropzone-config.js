(function($){

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
    var optionText = $(".choose-action option:selected").val();
    if(optionText=='0'){
      event.preventDefault();
    }
    $('.btn-primary.btn-apply-action').prepend('<i class="fa fa-spinner fa-spin"></i>');
  });

})(jQuery);
