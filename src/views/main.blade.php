<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Uploading images in Laravel with DropZone</title>

    <link rel="stylesheet" href="{{ url('/filemanager/assets/css/bootstrap.css') }}">

    @yield(Config::get('filemanager.yields.head'))
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url(Config::get('filemanager.filemanager_path')) }}">File manager</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url(Config::get('filemanager.filemanager_path').'/create') }}">Upload Images</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url(Config::get('filemanager.filemanager_path').'/showfiles') }}">View Uploaded Files</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid filemanager-main">
        @yield(Config::get('filemanager.yields.filemanager-content'))
    </div>
    <script type="text/javascript">
      var filemanagerPath = "<?php echo Config::get("filemanager.filemanager_path") ?>";
    </script>
    @yield(Config::get('filemanager.yields.footer'))


</body>
</html>
