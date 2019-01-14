<div class="table">
  <form class="mass-actions-form" action="{{ Config::get('filemanager.filemanager_url').'/file-delete' }}" method="post">
    <input type="hidden" name="backto" value="{{ url()->full() }}">
    @csrf

    <div class="actions-menu">
      <div class="list-actions vertimiddle">
        <select class="choose-action" name="choose-action">
          <option value="0">Choose one</option>
          <option value="1">Delete</option>
          <option value="2">Archive</option>
          <option value="3" disabled>Update</option>
        </select>
      </div><div class="apply-action vertimiddle">
        <button type="submit" name="button" class="btn btn-primary btn-apply-action">{{ __("Apply") }}</button>
      </div>
    </div>
    <div class='thead'>
      <div class="tr row">
          <div class="th cell lap--1-2 nexus--1-4" scope="col">
            <div class="checkboxcontainer">
              <input type="checkbox" id="checkbox-all" class="regular-checkbox big-checkbox"><label for="checkbox-all"></label>
            </div>
            Image
          </div><!--
          --><div class="th cell lap--1-2 nexus--1-4" scope="col">Filename</div><!--
          --><div class="th cell lap--1-2 nexus--1-4" scope="col">Original Filename</div><!--
          --><div class="th cell lap--1-2 nexus--1-4" scope="col">Resized Filename</div>
      </div>
    </div>
    <div class="tbody">
    @foreach($files as $file)
          <div class="tr row animated fadeInDown">
            <div class="td cell lap--1-2 nexus--1-4 listing-list-item">
              <div class="col-inner">
                <?php
                    $filemanagerDisk = Config::get('filemanager.filemanager_storage_disk');
                ?>
                @if($filemanagerDisk=='s3')
                  <img src="{{ $file->amazon_url }}">
                @else
                  <img src="<?php
                  $url = Storage::disk(Config::get('filemanager.filemanager_storage_disk'))->url($file->resized_name);
                  echo $url;
                  ?>">
                @endif
                <div class="checkboxcontainer">
                  <input type="checkbox" id="checkbox-{{ $file->id }}" class="regular-checkbox big-checkbox" value="{{ $file->id }}"><label for="checkbox-{{ $file->id }}"></label>
                </div>
              </div>
            </div><!--
            --><div class="td cell lap--1-2 nexus--1-4"><div class="col-inner">{{ $file->filename }}</div></div><!--
            --><div class="td cell lap--1-2 nexus--1-4"><div class="col-inner">{{ $file->original_name }}</div></div><!--
            --><div class="td cell lap--1-2 nexus--1-4"><div class="col-inner">{{ $file->resized_name }}</div></div>
        </div>@endforeach
    </div>
  </form>
</div>
<div class="pagination-container">
  {{ $files->links() }}
</div>
