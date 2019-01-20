<?php

namespace Devuniverse\Filemanager\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Devuniverse\Filemanager\Models\Upload;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Config;
use Illuminate\Support\Facades\Storage;


class FilemanagerController extends Controller
{

    private $photos_path;

    public function __construct()
    {
        $this->photos_path = storage_path(Config::get('filemanager.files_upload_path'));
    }
    public function loadIndex(){
      $files = Upload::paginate(Config::get('filemanager.files_per_page'));
      return view('filemanager::index', compact('files'));
    }
    /**
     * Display all of the images.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = Upload::paginate(Config::get('filemanager.files_per_page'));
        return view('filemanager::uploaded-images', compact('files'));
    }

    /**
     * Show the form for creating uploading new images.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('filemanager::upload');
    }

    /**
     * Saving images uploaded through XHR Request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photos = $request->file('file');

        if (!is_array($photos)) {
            $photos = [$photos];
        }

        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0775);
        }

        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $photo->getClientOriginalExtension();
            $resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();

            $extension = $photo->getClientOriginalExtension();

            $filemanagerDisk = Config::get('filemanager.filemanager_storage_disk');

            $resized  = storage_path('app/public/') . $resize_name;
            $thumbUploaded = Image::make($photo)
            ->resize(150, null, function ($constraints) {
              $constraints->aspectRatio();
            })->save($resized);

            if($filemanagerDisk["s3"]["default"]){
              $bucket  = env('AWS_BUCKET');
              // $thumbUploaded->save($resized);
              // url('storage/').$resize_name;
              //Config::get('filemanager.files_upload_path')
              // $photo->move($this->photos_path, $save_name);
              // $s3 = Storage::disk('s3');
              // $s3->put('your/s3/path/photo.jpg', file_get_contents($uploadedFile));
              if($extension=="zip"){
                $filePath = 'uploads/zips/' . $save_name;
              }else{
                $filePath = 'uploads/imgs/' . $save_name;
                $filePathThumbs = 'uploads/imgs/thumbnails/' . $resize_name;
              }
              $path = 'https://s3.amazonaws.com/'.$bucket.'/'.$filePath;
              $pathUrl = $filemanagerDisk['s3']['cname_url'] != '' ? $filemanagerDisk['s3']['cname_url'].'/'.$filePath : 'https://'.$bucket.'.s3.amazonaws.com/'.$filePath;
              $pathThumbs = 'https://s3.amazonaws.com/'.$bucket.'/'.$filePathThumbs;
              $pathUrlThumbs = $filemanagerDisk['s3']['cname_url'] != '' ? $filemanagerDisk['s3']['cname_url'].'/'.$filePathThumbs : 'https://'.$bucket.'.s3.amazonaws.com/'.$filePathThumbs;

              $s3 = \Storage::disk('s3');
              $imageAmazoned = $s3->put($filePath, file_get_contents($photo), 'public');
              $thumbAmazoned = $s3->put($filePathThumbs, file_get_contents($resized), 'public');

              $fileurl = $pathUrl;
              $fileurlThumb = $pathUrlThumbs;
            }else{

              // $toStore = \Storage::disk('public');
              // $stored = $toStore->put($save_name, file_get_contents($photo));
              $photo->move($this->photos_path, $save_name);
              $fileurl = url('storage/'. $resize_name) ;
            }

            // $photo->move($this->photos_path, $save_name);


            $upload = new Upload();
            $upload->filename = $save_name;
            $upload->object_id = isset($request->post_id)? $request->post_id : null;
            $upload->user_id   = \Auth::user()->id;
            $upload->resized_name = $resize_name;
            $upload->original_name = basename($photo->getClientOriginalName());
            if($filemanagerDisk["s3"]["default"]){
              $upload->amazon_url = $fileurl;
              $upload->amazon_thumb_url = $fileurlThumb;
            }
            $upload->file_url = $fileurl;
            $upload->save();
        }
        return Response::json([
            'message' => 'Image saved Successfully'
        ], 200);
    }

    /**
     * Remove the images from the storage.
     *
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $filename = $request->id;
        $uploaded_image = Upload::where('original_name', basename($filename))->first();

        if (empty($uploaded_image)) {
            return Response::json(['message' => 'Sorry file does not exist'], 400);
        }

        $file_path = $this->photos_path . '/' . $uploaded_image->filename;
        $resized_file = $this->photos_path . '/' . $uploaded_image->resized_name;

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        if (file_exists($resized_file)) {
            unlink($resized_file);
        }

        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }

        return Response::json(['message' => 'File successfully delete'], 200);
    }
    public function deleteFiles(Request $request){
      $requested = $request->POST;
      $page      = $request->page;

      $action   = $request->chooseaction; //1 for delete, 2 for archive,...
      if($action=='1' && !empty($request->posts)){
        foreach ($request->posts as $key => $value) {
          $upload         = Upload::find($value);
          $theFile        = $upload->filename;
          $theFileThumb   = $upload->resized_name;
          $deleteFile = Storage::disk('s3')->delete('/uploads/imgs/'.$theFile);
          $deleteFileThumb = Storage::disk('s3')->delete('/uploads/imgs/thumbnails/'.$theFileThumb);
          $upload->delete();
        }
        $message  = "Posts deleted successfully";
        $msgtype  = 1;
      }
      return redirect('/'.Config::get('filemanager.filemanager_url').'/showfiles?page='.$request->page)->with( ['page' => $page, 'theresponse'=>["message"=> $message, "msgtype"=>$msgtype]] );
    }
}
