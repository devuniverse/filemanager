<?php
return [
  /**
   *|
   */
  "mode" => 'multi',
  /**
   *|
   */
  "filemanager_default_disk" => "public",
  /**
   *|
   */
  "files_upload_path"       => "uploads",
  /**
   *|
   */
  "files_upload_thumb_path" => "uploads/thumbnails",
  /**
   *|
   */
  "filemanager_url_protocol"      => "https",
  /**
   *|
   */
  "filemanager_url"      => "{lang}/media",
  /**
   *|
   */
  "master_file_extend" => "layouts.backend",
  /**
   *|
   */
  "files_per_page" => 20,

  /**
  *|  #1  : defaults to public. Like Laravel
  *|  #2  : File systems in this setting MUST be mutually exclusive.
  *|        That is, Only one can have the default value to true
  *|
   */
  "filemanager_storage_disk" => [

      "public"  => [

      ],
      "s3" => [
        "cname_path" => "", //  s3.amazonaws.com/bucket
        "cname_url"  => "",  //  bucket.s3.amazonaws.com
      ]
    ],

  // "default_file_system" => "public",
  /**
   *|
   */
  'yields' => [
      'head'   => 'css',
      'footer' => 'js',
      'filemanager-content'=>'content'
  ],
  /**
   *|
   */
  'includes' => [
      'jquery'   => true,
      'animate' => true,
      'fontawesome' => true
  ],

  /**
   *|
   */
  'separate_uploads' => [

  ]
];
