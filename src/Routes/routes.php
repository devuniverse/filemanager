<?php

$filemanagerPath = Config::get('filemanager.mode')=='multi' ? '{global_entity?}/'.Config::get('filemanager.filemanager_url') : Config::get('filemanager.filemanager_url');

Route::group(['prefix' => $filemanagerPath,  'middleware' => ['web','auth']], function()
{

  include('web.php');

});
