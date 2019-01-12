@extends(Config::get('filemanager.master_file_extend'))
@section(Config::get('filemanager.yields.head'))
    @if(Config::get('filemanager.includes.fontawesome'))
      <link rel="stylesheet" href="{{ url('/filemanager/assets/fontawesome/css/all.css') }}">
    @endif
    @if(Config::get('filemanager.includes.animate'))
      <link rel="stylesheet" href="{{ url('/filemanager/assets/css/animate.css') }}">
    @endif
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/nexus.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/styled.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/custom.css') }}">
@endsection

@section(Config::get('filemanager.yields.filemanager-content'))
    <div class="table-responsive-sm">
      @include('filemanager::partials.nav')

      @include('filemanager::partials.itemlist')
    </div>
@endsection

@section(Config::get('filemanager.yields.footer'))
@if( Config::get('filemanager.includes.jquery'))
  <script src="{{ url('/filemanager/assets/js/jquery.js') }}"></script>
@endif
<!-- <script src="{{ url('/filemanager/assets/js/dropzone.js') }}"></script> -->
<script src="{{ url('/filemanager/assets/js/dropzone-config.js') }}"></script>
@endsection
