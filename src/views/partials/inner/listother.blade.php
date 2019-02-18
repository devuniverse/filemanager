					@if($file->file_extension == "doc" || $file -> file_extension =="docx")
                        <div class="fainner">
                            <i class="fa fa-file" aria-hidden="true"></i>
						</div>

					
					@elseif($file->file_extension == "jpeg" || $file -> file_extension =="jpg" || $file -> file_extension =="png" || $file -> file_extension =="gif" )
						
                        <img src="<?php

                        $url = Storage::disk('public')->url(Config::get('filemanager.files_upload_thumb_path').'/'.$file->resized_name);
                        if(isset($file->file_url_thumb)){
                            echo $url;
                        }else{
                            echo asset('filemanager/assets/images/default-post.jpg');
                        }
                        ?>" width="150">

					@elseif($file->file_extension == "pdf")
						<div class="fainner">
                            <i class="fa fa-file" aria-hidden="true"></i>
						</div>
					@else
						<div class="fainner">
                            <i class="fa fa-file" aria-hidden="true"></i>
						</div>
					@endif