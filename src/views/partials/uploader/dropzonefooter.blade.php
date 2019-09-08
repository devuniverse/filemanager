
@if($unique)
  @if( Config::get('filemanager.includes.jquery'))
    <script src="{{ url('/filemanager/assets/js/jquery.js') }}"></script>
  @endif
@else
<script src="{{ url('/filemanager/assets/js/jquery.js') }}"></script>
@endif
<script src="{{ url('/filemanager/assets/js/dropzone.js') }}"></script>
<script type="text/javascript">
function processCustom(){
  filemanagerDropzone.processQueue();
}
var total_photos_counter = 0;
var name = "";
var filemanagerDropzone = new Dropzone("#filemanager-dropzone", {
  autoProcessQueue: false,
  <?php if($unique){?>
    uploadMultiple: false,
  <?php } ?>
  parallelUploads: 1,
  <?php if($unique){?>
  maxFilesize: 1,
  maxFiles:1,
  <?php }else{ ?>
    maxFilesize: 16,
  <?php } ?>
  acceptedFiles: ".jpeg,.jpg,.png,.gif,.zip, .tar, .doc, .docx, .mp3, .pdf",
  previewTemplate: document.querySelector('#preview').innerHTML,
  addRemoveLinks: true,
  dictRemoveFile: 'Remove file',
  dictFileTooBig: 'Image is larger than 16MB',
  timeout: 10000,
  renameFile: function (file) {
    name = new Date().getTime() + Math.floor((Math.random() * 100) + 1) + '_' + file.name;
    return name;
  },

  init: function () {
    this.on("addedfile", function(file) {
      var count= filemanagerDropzone.files.length;
      if(count < 1){
        $('.btn-primary.start').prop("disabled", true);
      }else{
        $('.btn-primary.start').prop("disabled", false);
      }
      <?php if($unique){?>
        $('.cta-caller-container').prepend('<div class="return-input">'+
        '<input class="returnurl" name="returnurl" readonly value="" />'+
        '<button type="button" class="btn btn-primary insert-cta" disabled>Insert</button>'+
        '</div>');
      <?php } ?>

    });
    this.on("removedfile", function (file) {
      var count= filemanagerDropzone.files.length;
      $.post({
        url: '/'+filemanagerPath+'/file-delete',
        data: {id: file.customName, _token: $('[name="_token"]').val()},
        dataType: 'json',
        success: function (data) {
          total_photos_counter--;
          $("#counter").text("# " + total_photos_counter);
        }
      });
      if(count < 1){
        $('.btn-primary.start').prop("disabled", true);
      }else{
        $('.btn-primary.start').prop("disabled", false);
      }
    });
  },
  success: function (file, done) {
    console.log(file);
    total_photos_counter++;
    $("#counter").text("#" + total_photos_counter);
    file["customName"] = name;
    setTimeout(function(){
      $('.btn-primary.start').find('i').remove();
      $('.btn-primary.start').prop("disabled", true);
      $('.insert-cta').prop('disabled',false);
    }, 1000);

    <?php if($unique){?>
      var byaje = JSON.parse(file.xhr.response);
      $('.cta-caller-container').find('.returnurl').val(byaje.uploadedfile);
    <?php } ?>
    processCustom();
  },
  error:function(errors){
    console.log(errors);

    processCustom();
  }
});
$('.btn-primary.start').on("click", function(event){
  event.preventDefault();
  $(this).prepend('<i class="fas fa-circle-notch fa-spin"></i>');
  processCustom();
});

$(document).on('click','.uniqueuploader-menu li', function(e){
  e.preventDefault();
  $('.uniqueuploader-menu li').removeClass('btn-success');
  $(this).addClass('btn-success');
  var cont = $(this).data('content');
  $('.content-main .content').addClass('hidden');
  $('.content-main .content-' + cont).removeClass('hidden');
});

$(document).on('click', '.thepagination .page-item', function(e){
  e.preventDefault();
  if( ! $(this).hasClass('active') ){
    $('.thepagination .page-item').removeClass('active');
    $(this).addClass('active');
    var whereTo = $(this).find('a').attr('href');
    $.ajax({
      type: 'GET', //THIS NEEDS TO BE GET
      url: whereTo,
      dataType: 'json',
      success: function (data) {
          // console.log(JSON.stringify(data));
          $('.content-2').html(data);
      },error:function(){
           // console.log(data);
      }
    });
  }
});
</script>
<script src="{{ url('/filemanager/assets/js/dropzone-config.js') }}"></script>
