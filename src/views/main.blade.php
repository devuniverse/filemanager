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
    <div class="container-fluid filemanager-main">
        @yield(Config::get('filemanager.yields.filemanager-content'))
    </div>
    <script type="text/javascript">
      var filemanagerPath = "<?php echo Config::get("filemanager.filemanager_path") ?>";
    </script>
    @yield(Config::get('filemanager.yields.footer'))


</body>
</html>
