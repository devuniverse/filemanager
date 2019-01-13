<?php
return [

  "files_upload_path"      => "uploads",

  "filemanager_url"      => "file-manager",

  "master_file_extend" => "filemanager::main",

  'yields' => [
      'head'   => 'css',
      'footer' => 'js',
      'filemanager-content'=>'filemanager-content'
  ],

  'includes' => [
      'jquery'   => true,
      'animate' => true,
      'fontawesome' => true
  ],


];
