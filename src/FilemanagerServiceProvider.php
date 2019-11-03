<?php

namespace Devuniverse\Filemanager;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Config;

class FilemanagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      //
      include __DIR__.'/Routes/routes.php';
      $this->publishes([
        __DIR__.'/Config/filemanager.php' => config_path('filemanager.php'),
        __DIR__.'/public' => public_path('filemanager/assets'),
      ]);
      // $this->publishes([
      //     __DIR__.'/database/' => database_path(),
      // ], 'filemanager');
      $this->loadMigrationsFrom(__DIR__.'/database/migrations');

      /************************  TO VIEWS ***************************/

      view()->composer('*', function ($view){
       $request =  Request();
       if(\Auth::check()){
         if(Config::get('filemanager.mode')=="multi"){
           $request = Request();
           $uniqueTo = $request->global_entity;
           $module = $request->module;
           $files =  \Devuniverse\Filemanager\Models\Upload::where('uniqueto',$uniqueTo)->orderBy('created_at', 'desc')->where('module', $module)->paginate(18);
         }else{
           $files =  \Devuniverse\Filemanager\Models\Upload::orderBy('created_at', 'desc')->where('module', $module)->paginate(18);
         }
         $view->with('gallerylitefiles', $files);

       };
       $filemanager = new Models\Filemanager();
       $view->with('filemanager', $filemanager );
       $view->with('unique', true );

       $filemanagerPath = Config::get('filemanager.mode')==='multi' ? \Request()->global_entity.'/'.Config::get('filemanager.filemanager_url') : Config::get('filemanager.filemanager_url');
       $view->with('filemanagerUrl', $filemanagerPath );

      });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      // register our controller
      $this->app->make('Devuniverse\Filemanager\Controllers\FilemanagerController');
      $this->loadViewsFrom(__DIR__.'/views', 'filemanager');

      $this->mergeConfigFrom(
          __DIR__.'/Config/filemanager.php', 'filemanager'
      );

    }
}
