<div class="existing-files">
  <div class="thelist">
    <div class="row">
      @foreach($files as $file)
      <?php $toStore = \Storage::disk(Config::get('filemanager.filemanager_default_disk')); ?>
      <div class="col col-md-2 file-unique">
        <div class="file-inner">
          <input type="radio" name="chosen-file" value="{{ $file->id }}" id="chosen-file" class="form-radio styledradio"><label for="chosen-file"></label>
          <img src="{{ $toStore->url(Config::get('filemanager.files_upload_path')).'/'.$file->filename }}" alt="" style="max-width:100%">
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="thepagination">
    {{ $files->links() }}
  </div>
</div>
