<div class="table">

  <form class="mass-actions-form" action="/{{ Config::get('filemanager.filemanager_url').'/delete-files' }}" method="post">
	<input type="hidden" name="backto" value="{{ url()->full() }}">
	<input type="hidden" name="page" value="@if(isset($_GET['page']) && $_GET['page']!=''){{ $_GET['page'] }}@else 1 @endif">
	  @if(isset($_GET['post_id']) && $_GET['post_id']!='')
		<input type="hidden" name="post_id" value="{{ $_GET['post_id'] }}">
	  @endif
	@csrf

	<div class="actions-menu">
	  <div class="list-actions vertimiddle">
		<select class="chooseaction" name="chooseaction">
		  <option value="0">Choose one</option>
		  <option value="1">Delete</option>
		  <option value="2">Archive</option>
		  <option value="3" disabled>Update</option>
		</select>
	  </div><div class="apply-action vertimiddle">
		<button type="submit" name="button" class="btn btn-primary btn-apply-action">{{ __("Apply") }}</button>
	  </div>
	</div>
    <div class="pagination-container">
        {{ $files->links() }}
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

				@if(\Config::get('filemanager.filemanager_default_disk') == "s3")
          <?php if($file->amazon_thumb_url != ""): ?>
            <img src="<?php echo $file->amazon_thumb_url; ?>">
          <?php else: ?>
            <img src="<?php echo asset('filemanager/assets/images/default-post.jpg'); ?>" width="150">
          <?php endif ?>
				@else

				  <img src="<?php

				  $url = Storage::disk('public')->url(Config::get('filemanager.files_upload_thumb_path').'/'.$file->resized_name);
				  if(isset($file->file_url_thumb)){
					echo $url;
				  }else{
					echo asset('filemanager/assets/images/default-post.jpg');
				  }
				  ?>" width="150">

				@endif
				<div class="checkboxcontainer">
				  <input type="checkbox" name="posts[]" id="checkbox-{{ $file->id }}" class="regular-checkbox big-checkbox" value="{{ $file->id }}"><label for="checkbox-{{ $file->id }}"></label>
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
