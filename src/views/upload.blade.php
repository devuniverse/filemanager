@extends(Config::get('filemanager.master_file_extend'))

@section(Config::get('filemanager.yields.head'))
    @if(Config::get('filemanager.includes.fontawesome'))
      <link rel="stylesheet" href="{{ url('/filemanager/assets/fontawesome/css/all.css') }}">
    @endif
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/dropzone.css') }}">
    @if(Config::get('filemanager.includes.animate'))
      <link rel="stylesheet" href="{{ url('/filemanager/assets/css/animate.css') }}">
    @endif
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/nexus.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/styled.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/custom.css') }}">
@endsection

@section(Config::get('filemanager.yields.footer'))
  @if( Config::get('filemanager.includes.jquery'))
    <script src="{{ url('/filemanager/assets/js/jquery.js') }}"></script>
  @endif
    <script src="{{ url('/filemanager/assets/js/dropzone.js') }}"></script>
    <script type="text/javascript">
    var total_photos_counter = 0;
    var name = "";
    var filemanagerDropzone = new Dropzone("#filemanager-dropzone", {
      autoProcessQueue: false,
      uploadMultiple: true,
      parallelUploads: 20,
      maxFilesize: 16,
      acceptedFiles: ".jpeg,.jpg,.png,.gif,.zip, .tar, .doc, .docx",
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
          total_photos_counter++;
          $("#counter").text("# " + total_photos_counter);
          file["customName"] = name;
          setTimeout(function(){
            $('.btn-primary.start').find('i').remove();
          }, 1000);
          $('.btn-primary.start').prop("disabled", true);
      }
    });
    $('.btn-primary.start').on("click", function(event){
      event.preventDefault();
      $(this).prepend('<i class="fas fa-circle-notch fa-spin"></i>');
      filemanagerDropzone.processQueue()
    });

    </script>
    <script src="{{ url('/filemanager/assets/js/dropzone-config.js') }}"></script>
@endsection

@section(Config::get('filemanager.yields.filemanager-content'))
@include('filemanager::partials.nav')

    <div class="row">
        <div class="col-sm-10 offset-sm-1">
            <h2 class="page-heading">Upload your Images <span id="counter"></span></h2>
            <form method="post" action="{{ url(Config::get('filemanager.filemanager_url').'/file-save') }}"
                  enctype="multipart/form-data" class="dropzone" id="filemanager-dropzone">
                {{ csrf_field() }}
                <div class="dz-message">
                    <div class="col-xs-8">
                        <div class="message">
                            <p><i class="fas fa-plus-circle"></i></p>
                        </div>
                    </div>
                </div>
                <div class="fallback">
                    <input type="file" name="file" multiple>
                </div>
                <div class="cta-caller-container">
                  <button type="button" name="button" class="btn-primary start" disabled>Process Upload</button>
                </div>
            </form>
        </div>
    </div>

    {{--Dropzone Preview Template--}}
    <div id="preview" style="display: none;">

        <div class="dz-preview dz-file-preview">
            <div class="dz-image"><img data-dz-thumbnail /></div>

            <div class="dz-details">
                <div class="dz-size"><span data-dz-size></span></div>
                <div class="dz-filename"><span data-dz-name></span></div>
            </div>
            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            <div class="dz-error-message"><span data-dz-errormessage></span></div>



            <div class="dz-success-mark">

                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                    <title>Check</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                    </g>
                </svg>

            </div>
            <div class="dz-error-mark">

                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                    <title>error</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                            <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                        </g>
                    </g>
                </svg>
            </div>
        </div>
    </div>
    {{--End of Dropzone Preview Template--}}
@endsection
