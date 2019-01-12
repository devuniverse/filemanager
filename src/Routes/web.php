<?php

$filemanagerPath = Config::get('filemanager.filemanager_path');

Route::group(['prefix' => $filemanagerPath,  'middleware' => ['web','auth']], function()
{
  /**
   * GET ROUTES
   */
  Route::get('/', 'Devuniverse\Filemanager\Controllers\FilemanagerController@loadIndex');
  Route::get('create', 'Devuniverse\Filemanager\Controllers\FilemanagerController@create')->name('filemanager.create');
  Route::get('showfiles', 'Devuniverse\Filemanager\Controllers\FilemanagerController@index')->name('load.filemanager.index');

  Route::post('/file-save', 'Devuniverse\Filemanager\Controllers\FilemanagerController@store');
  Route::post('/file-delete', 'Devuniverse\Filemanager\Controllers\FilemanagerController@destroy');

  /**
   * POST ROUTES
   */

});
