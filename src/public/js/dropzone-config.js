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

})(jQuery);
