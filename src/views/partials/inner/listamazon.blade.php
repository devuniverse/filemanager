					@if($file->file_extension == "doc" || $file -> file_extension =="docx")
						<div class="fainner">
							<i class="fa fa-file" aria-hidden="true"></i>
						</div>
					@elseif($file->file_extension == "jpeg" || $file -> file_extension =="jpg" || $file -> file_extension =="png" || $file -> file_extension =="gif" )
						
						<?php if($file->amazon_thumb_url != ""): ?>
							<img src="<?php echo $file->amazon_thumb_url; ?>">
						<?php else: ?>
							<img src="<?php echo asset('filemanager/assets/images/default-post.jpg'); ?>" width="150">
						<?php endif ?>

					@elseif($file->file_extension == "pdf")
						<div class="fainner">
							<i class="fa fa-file" aria-hidden="true"></i>
						</div>
					@else
						<div class="fainner">
							<i class="fa fa-file" aria-hidden="true"></i>
						</div>

					@endif