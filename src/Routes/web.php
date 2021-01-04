<?php

/**
 * GET ROUTES
 */
Route::get('/', 'Devuniverse\Filemanager\Controller\FilemanagerController@loadIndex');
Route::get('create', 'Devuniverse\Filemanager\Controller\FilemanagerController@create')->name('filemanager.create');
Route::get('showfiles', 'Devuniverse\Filemanager\Controller\FilemanagerController@index')->name('load.filemanager.index');
Route::get('modaluploader', 'Devuniverse\Filemanager\Controller\FilemanagerController@loadGallery')->name('load.filemanager.gallery');
Route::get('modalcropper', 'Devuniverse\Filemanager\Controller\FilemanagerController@getModalCropper');


Route::post('/file-save', 'Devuniverse\Filemanager\Controller\FilemanagerController@store');
Route::post('/file-delete', 'Devuniverse\Filemanager\Controller\FilemanagerController@destroy');
Route::post('/delete-files', 'Devuniverse\Filemanager\Controller\FilemanagerController@deleteFiles');

/**
 * POST ROUTES
 */
 Route::post('/modaluploader', 'Devuniverse\Filemanager\Controller\FilemanagerController@modalUploader');
 Route::post('/modalcropper', 'Devuniverse\Filemanager\Controller\FilemanagerController@modalCropper');
