<?php

namespace Devuniverse\Filemanager;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


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
      include __DIR__.'/Routes/web.php';
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
       $view->with('alluploads', Models\Upload::paginate(20));

       if(\Auth::check()){



       };
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
      $this->app->make('Devuniverse\Filemanager\Controller\FilemanagerController');
      $this->loadViewsFrom(__DIR__.'/views', 'filemanager');

      $this->mergeConfigFrom(
          __DIR__.'/Config/filemanager.php', 'filemanager'
      );

    }
}
