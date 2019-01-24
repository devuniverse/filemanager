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

  private $files_upload_path;
  private $files_upload_thumb_path;

    public function __construct()
    {
        // $this->files_upload_path = storage_path(Config::get('filemanager.files_upload_path'));
        $this->default_disk           = Config::get('filemanager.filemanager_default_disk');
        $this->files_upload_path      = Storage::disk(Config::get('filemanager.filemanager_default_disk'))->getAdapter()->getPathPrefix().Config::get('filemanager.files_upload_path');
        $this->files_upload_thumb_path= Storage::disk(Config::get('filemanager.filemanager_default_disk'))->getAdapter()->getPathPrefix().Config::get('filemanager.files_upload_thumb_path');
        $this->image_extensions       = ['jpeg','jpg', 'png', 'gif'];
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
        $files = $request->file('file');

        if (!is_array($files)) {
            $files = [$files];
        }

        if (!is_dir($this->files_upload_path)) {
            mkdir($this->files_upload_path, 0775);
        }

        for ($i = 0; $i < count($files); $i++) {
            $file = $files[$i];
            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $file->getClientOriginalExtension();
            $resize_name = $name . str_random(2) . '.' . $file->getClientOriginalExtension();

            $extension = $file->getClientOriginalExtension();

            $filemanagerDisk = Config::get('filemanager.filemanager_storage_disk');

            $thumbsPath = Config::get('filemanager.files_upload_thumb_path');

            $resized  = $this->files_upload_thumb_path.'/'. $resize_name;

            if(in_array($extension, $this->image_extensions)){
              $thumbUploaded = Image::make($file)
              ->resize(150, null, function ($constraints) {
                $constraints->aspectRatio();
              });
              if($this->default_disk == 's3'){
                $streamed = $thumbUploaded->stream();
                Storage::disk('s3')->put('uploads/imgs/thumbnails/'.$resize_name , $streamed->__toString(), 'public');
              }else{
                $thumbUploaded->save($resized);
              }
            }

            if($this->default_disk == "s3"){
              $bucket  = env('AWS_BUCKET');
              // $thumbUploaded->save($resized);
              // url('storage/').$resize_name;
              //Config::get('filemanager.files_upload_path')
              // $file->move($this->files_upload_path, $save_name);
              // $s3 = Storage::disk('s3');
              // $s3->put('your/s3/path/file.jpg', file_get_contents($uploadedFile));

              if(in_array($extension, $this->image_extensions)){
                $filePath = 'uploads/imgs/' . $save_name;
                $filePathThumbs = 'uploads/imgs/thumbnails/' . $resize_name;
              }elseif($extension=="zip"){
                $filePath = 'uploads/zips/' . $save_name;
              }else{
                $filePath = 'uploads/other/' . $save_name;
              }
              $path = 'https://s3.amazonaws.com/'.$bucket.'/'.$filePath;
              $pathUrl = $filemanagerDisk['s3']['cname_url'] != '' ? $filemanagerDisk['s3']['cname_url'].'/'.$filePath : 'https://'.$bucket.'.s3.amazonaws.com/'.$filePath;
              $pathThumbs = 'https://s3.amazonaws.com/'.$bucket.'/'.$filePathThumbs;
              $pathUrlThumbs = $filemanagerDisk['s3']['cname_url'] != '' ? $filemanagerDisk['s3']['cname_url'].'/'.$filePathThumbs : 'https://'.$bucket.'.s3.amazonaws.com/'.$filePathThumbs;

              $s3 = \Storage::disk('s3');
              $imageAmazoned = $s3->put($filePath, file_get_contents($file), 'public');
              // $thumbAmazoned = $s3->put($filePathThumbs, file_get_contents($resized), 'public');

              $fileurl = $pathUrl;
              $fileurlThumb = $pathUrlThumbs;
            }else{

              //$this->files_upload_thumb_path
              $toStore = \Storage::disk($this->default_disk);
              // $stored = $toStore->put($save_name, file_get_contents($file));
              // $file->move($this->files_upload_path, $save_name);
              // $file->move($this->files_upload_thumb_path, $resize_name);
              $stored = $toStore->put(Config::get('filemanager.files_upload_path').'/'.$save_name, file_get_contents($file));
              $fileurl = $toStore->url($this->files_upload_path.'/'.$save_name);

              if(in_array($extension, $this->image_extensions)){
                $fileurlThumb = $toStore->url($this->files_upload_path.'/'.$resize_name);
              }else{
                $fileurlThumb = '';
              }
            }

            // $file->move($this->files_upload_path, $save_name);


            $upload = new Upload();
            $upload->filename = $save_name;
            $upload->object_id = isset($request->post_id)? $request->post_id : null;
            $upload->user_id   = \Auth::user()->id;
            $upload->resized_name = $resize_name;
            $upload->original_name = basename($file->getClientOriginalName());
            if($this->default_disk == "s3"){
              $upload->amazon_url = $fileurl;
              $upload->amazon_thumb_url = $fileurlThumb;
            }else{
              $upload->file_url = $fileurl;
              $upload->file_url_thumb = $fileurlThumb;
            }
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

        $file_path = $this->files_upload_path . '/' . $uploaded_image->filename;
        $resized_file = $this->files_upload_thumb_path . '/' . $uploaded_image->resized_name;

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
