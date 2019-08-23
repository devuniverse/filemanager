<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="{{ url('/filemanager/assets/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/nexus.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/styled.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/custom.css') }}">
    <style media="screen">
    .form-radio
    {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      display: inline-block;
      position: absolute;
      background-color: #f1f1f1;
      color: #fff;
      top: 20%;
      height: 35px;
      width: 35px;
      border: 0;
      border-radius: 50px;
      cursor: pointer;
      margin-right: 7px;
      outline: none;
      left: 6.8%;
    }
    .form-radio:checked::before {
        position: absolute;
        font: 22px/0.4em 'Open Sans', sans-serif;
        left: 5px;
        top: 0px;
        content: '\02143';
        transform: rotate(40deg);
    }
    .form-radio:hover
    {
       background-color: #f7f7f7;
    }
    .form-radio:checked {
        background-color: #28b779;
        border: 10px solid #7460ee;
    }
    label
    {
       font: 15px/1.7 'Open Sans', sans-serif;
       color: #333;
       -webkit-font-smoothing: antialiased;
       -moz-osx-font-smoothing: grayscale;
       cursor: pointer;
    }
    </style>
  </head>
  <body>
    <div class="unique-uploader-main">
      <ul class="uniqueuploader-menu">
        <li class="btn btn-primary btn-lg" data-content="1">Upload</li>
        <li class="btn btn-primary btn-success btn-lg"  data-content="2">Existing File</li>
      </ul>
      <div class="content-main">
        <div class="content content-1 hidden">
          <div class="row">
            <div class="col-sm-12">
              <h2 class="page-heading">Upload your Files <span id="counter"></span></h2>
              <form method="post" action="{{ url(Config::get('filemanager.filemanager_url').'/file-save') }}"
              enctype="multipart/form-data" class="dropzone" id="filemanager-dropzone">
              {{ csrf_field() }}
              <input type="hidden" name="module" value="{{ $module }}">
              <div class="dz-message">
                <div class="col-xs-12">
                  <div class="message">
                    <p><i class="fas fa-plus-circle"></i></p>
                  </div>
                </div>
              </div>
              <div class="fallback">
                <input type="file" name="file" multiple>
              </div>
            </form>
            <div class="cta-caller-container">
              <button type="button" name="button" class="btn-primary start" disabled>Process Upload</button>
            </div>
          </div>
          </div>


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
        </div>
        <div class="content content-2" data-content="2">
          @include('filemanager::partials.galleryeditor', ['files' => \Devuniverse\Filemanager\Models\Upload::where('module', $module)->paginate(18)])
        </div>
      </div>

    </div>

  </body>
  @include('filemanager::partials.uploader.dropzonefooter', ['unique' => true ])
</html>
