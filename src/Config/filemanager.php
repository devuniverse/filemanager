<?php
return [

  "files_upload_path"      => "uploads",

  "filemanager_url"      => "file-manager",

  "master_file_extend" => "filemanager::main",

  "files_per_page" => 25,

  "filemanager_storage_disk" => "public",

  // "default_file_system" => "public",

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
