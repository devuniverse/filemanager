@extends('filemanager::main')
@section('head')
    <link rel="stylesheet" href="{{ url('/filemanager/assets/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/nexus.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/styled.css') }}">
    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/custom.css') }}">
@endsection

@section('js')
    <script src="{{ url('/filemanager/assets/js/jquery.js') }}"></script>
    <!-- <script src="{{ url('/filemanager/assets/js/dropzone.js') }}"></script> -->
    <script src="{{ url('/filemanager/assets/js/dropzone-config.js') }}"></script>
@endsection
@section('filemanager-content')
    <div class="table-responsive-sm">
        @include('filemanager::partials.itemlist')
    </div>
@endsection
