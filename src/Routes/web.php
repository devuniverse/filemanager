<?php

/**
 * GET ROUTES
 */
Route::get('/', 'Devuniverse\Filemanager\Controllers\FilemanagerController@loadIndex');
Route::get('create', 'Devuniverse\Filemanager\Controllers\FilemanagerController@create')->name('filemanager.create');
Route::get('showfiles', 'Devuniverse\Filemanager\Controllers\FilemanagerController@index')->name('load.filemanager.index');
Route::get('modaluploader', 'Devuniverse\Filemanager\Controllers\FilemanagerController@loadGallery')->name('load.filemanager.gallery');
Route::get('modalcropper', 'Devuniverse\Filemanager\Controllers\FilemanagerController@getModalCropper');


Route::post('/file-save', 'Devuniverse\Filemanager\Controllers\FilemanagerController@store');
Route::post('/file-delete', 'Devuniverse\Filemanager\Controllers\FilemanagerController@destroy');
Route::post('/delete-files', 'Devuniverse\Filemanager\Controllers\FilemanagerController@deleteFiles');

/**
 * POST ROUTES
 */
 Route::post('/modaluploader', 'Devuniverse\Filemanager\Controllers\FilemanagerController@modalUploader');
 Route::post('/modalcropper', 'Devuniverse\Filemanager\Controllers\FilemanagerController@modalCropper');
