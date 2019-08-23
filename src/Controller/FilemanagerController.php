<?php

namespace Devuniverse\Filemanager\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Devuniverse\Filemanager\Models\Upload;
use Devuniverse\Permissions\Models\User;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Config;
use Illuminate\Support\Facades\Storage;


class FilemanagerController extends Controller
{

  private $files_upload_path;
  private $files_upload_thumb_path;
  private $images_path;
  private $images_thumb_path;
  private $zips_folder;
  private $others_folder;
  private $permissions;
    public function __construct()
    {
        // $this->files_upload_path = storage_path(Config::get('filemanager.files_upload_path'));
        $this->default_disk            = Config::get('filemanager.filemanager_default_disk');
        $this->filemanager_url_protocol=Config::get('filemanager.filemanager_url_protocol');
        $this->files_upload_path       = Storage::disk(Config::get('filemanager.filemanager_default_disk'))->getAdapter()->getPathPrefix().Config::get('filemanager.files_upload_path');
        $this->files_upload_thumb_path = Storage::disk(Config::get('filemanager.filemanager_default_disk'))->getAdapter()->getPathPrefix().Config::get('filemanager.files_upload_thumb_path');
        $this->image_extensions        = ['jpeg','jpg', 'png', 'gif'];

        $this->images_path             = 'imgs';
        $this->images_thumb_path       = 'imgs/thumbnails';
        $this->zips_folder             = 'zips';
        $this->others_folder           = 'others';
        $this->permissions             = new User();
    }
    public function loadIndex(){
      $files = Upload::orderBy('created_at', 'desc')->paginate(Config::get('filemanager.files_per_page'));
      return view('filemanager::index', compact('files'));
    }
    private function isImage($extension){
      if(in_array($extension, $this->image_extensions)){
        return true;
      }else{
        return false;
      }
    }
    private function isZip($extension){
      if( $extension =='zip'){
        return true;
      }else{
        return false;
      }
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
        return view('filemanager::upload', ['uniqueupload'=>false]);
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
        $module = isset($request->module) ? $request->module : '';

        for ($i = 0; $i < count($files); $i++) {
            $file = $files[$i];
            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $file->getClientOriginalExtension();
            $resize_name = $name . str_random(2) . '.' . $file->getClientOriginalExtension();

            $extension = $file->getClientOriginalExtension();

            $filemanagerDisk = Config::get('filemanager.filemanager_storage_disk');

            $thumbsPath = Config::get('filemanager.files_upload_thumb_path');

            $resized  = $this->files_upload_thumb_path.'/'. $resize_name;

            if(self::isImage($extension)){
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

              if(self::isImage($extension)){

                $filePath       = $this->images_path.'/'. $save_name;
                $filePathThumbs = $this->images_thumb_path.'/' . $resize_name;

              }elseif(self::isZip($extension)){


                $filePath = $this->files_upload_path.'/'.$this->zips_folder.'/'. $save_name;

              }else{

                $filePath = $this->files_upload_path.'/'.$this->others_folder.'/'. $save_name;

              }
              $path = 'https://s3.amazonaws.com/'.$bucket.'/'.$filePath;
              $pathUrl = $filemanagerDisk['s3']['cname_url'] != '' ? $filemanagerDisk['s3']['cname_url'].'/'.$filePath : 'https://'.$bucket.'.s3.amazonaws.com/'.$filePath;
              $pathThumbs = 'https://s3.amazonaws.com/'.$bucket.'/'.$filePathThumbs;
              $pathUrlThumbs = $filemanagerDisk['s3']['cname_url'] != '' ? $filemanagerDisk['s3']['cname_url'].'/'.$filePathThumbs : 'https://'.$bucket.'.s3.amazonaws.com/'.$filePathThumbs;

              $s3 = \Storage::disk('s3');
              $imageAmazoned = $s3->put($filePath, file_get_contents($file), 'public');

              $fileurl = $this->filemanager_url_protocol.'://'.$pathUrl;
              $fileurlThumb = $this->filemanager_url_protocol.'://'.$pathUrlThumbs;
            }else{

              //$this->files_upload_thumb_path
              $toStore = \Storage::disk($this->default_disk);
              // $stored = $toStore->put($save_name, file_get_contents($file));
              // $file->move($this->files_upload_path, $save_name);
              // $file->move($this->files_upload_thumb_path, $resize_name);
              $stored = $toStore->put(Config::get('filemanager.files_upload_path').'/'.$save_name, file_get_contents($file));
              $fileurl = $toStore->url(Config::get('filemanager.files_upload_path')).'/'.$save_name;

              if(self::isImage($extension)){
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
            $upload->module = $module;
            if($this->default_disk == "s3"){
              $upload->amazon_url = $fileurl;
              $upload->amazon_thumb_url = $fileurlThumb;
            }else{
              $upload->file_url = $fileurl;
              $upload->file_url_thumb = $fileurlThumb;
            }
            $upload->file_extension = $extension;
            $upload->save();
        }
        return Response::json([
            'message' => 'Image saved Successfully',
            'uploadedfile' => $fileurl
        ], 200);
    }

    /**
     * @method destroy
     * @param $request
     * Remove the images from the storage.
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
    /**
     * @method deleteFiles
     * @param object mixed $request
     * @return redirect
     */
    public function deleteFiles(Request $request){
      $requested = $request->POST;
      $page      = $request->page;

      $action   = $request->chooseaction; //1 for delete, 2 for archive,...
      if($action=='1' && !empty($request->posts)){
        foreach ($request->posts as $key => $value) {
          $upload         = Upload::find($value);
          $theFile        = $upload->filename;
          $theFileThumb   = $upload->resized_name;
          if(Config::get('filemanager.filemanager_default_disk') =='s3'){
            $theDisk = Storage::disk('s3');
            $mainUploads = Config::get('filemanager.files_upload_path');
            $thumbsUploads = Config::get('filemanager.files_upload_thumb_path');
          }else{
            $theDisk = Storage::disk(Config::get('filemanager.filemanager_default_disk'));
            $mainUploads = Config::get('filemanager.files_upload_path');
            $thumbsUploads = Config::get('filemanager.files_upload_thumb_path');
          }
          //uploads/imgs
          //uploads/imgs/thumbnails

          $deleteFile = $theDisk->delete($mainUploads.'/'.$theFile);
          $deleteFileThumb = $theDisk->delete($thumbsUploads.'/'.$theFileThumb);
          $upload->delete();
        }
        $message  = "Posts deleted successfully";
        $msgtype  = 1;
      }
      return redirect('/'.Config::get('filemanager.filemanager_url').'/showfiles?page='.$request->page)->with( ['page' => $page, 'theresponse'=>["message"=> $message, "msgtype"=>$msgtype]] );
    }
    public function modalUploader(Request $request){
      $module = $request->module;
      $returnHTML = view('filemanager::uploadlite', ['uniqueupload' => true, 'module' => $module ])->render();
      return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
    public function modalCropper(Request $request){
      $imageUrl = $request->url;
      $returnHTML = view('filemanager::cropper', ['url' => $imageUrl])->render();
      return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
    public function getModalCropper(Request $request){
      $pxs = $this->permissions;
      if( ! $pxs->userCan('update_media')){
        return 'You are not authorized to do that';
      }else{
        return view('filemanager::cropper', ['url'=>$request->img, 'identifier'=> $request->identifier]);
      }
    }
    public function loadGallery(Request $request){
      $files = \Devuniverse\Filemanager\Models\Upload::orderBy('created_at', 'desc')->paginate(18);

      $returnHTML = view('filemanager::partials.galleryeditor', ['files' => $files])->render();
      return response()->json($returnHTML);
    }




}
