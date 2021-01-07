<?php
use Updater\Config\Constant;
/*TODO: Refactor this section*/
?>
<section class="mt-2">
	<div class="container  mt-2">
		<div class="row">
			<div class="col-md-8 bg-white  msn-shadow-light rounded-lg p-4 mx-auto ">
				<?php if ( @$params['host_creation_result'] === true || @$params['host_edit_result'] === true ): ?>
					<h4 class="mb-3 text-center">
						<span>عملیات </span>
						<?php
              if ( @$params['new_host']->crud_type === 'create') {
	              echo Constant::TRANSLATION_STRINGS[$params['new_host']->crud_type];
              }
							if ( @$params['edited_host']->crud_type === 'update' ) {
								echo Constant::TRANSLATION_STRINGS[$params['edited_host']->crud_type];
              }
						?>
						<span> هاست به درستی انجام شد</span>
					</h4>
					<ul class="p-4">
						<li>نام هاست:
							<?php
							if ( @$params['new_host']->crud_type === 'create') {
								echo $params['new_host']->host_name;
							}
							if ( @$params['edited_host']->crud_type === 'update' ) {
								echo $params['edited_host']->host_name;
              }
              ?>
						</li>
						<li>آدرس هاست:
							<?php
							if ( @$params['new_host']->crud_type === 'create') {
								echo $params['new_host']->host_path;
							}
							if ( @$params['edited_host']->crud_type === 'update' ) {
								echo $params['edited_host']->host_path;
							}

              ?>
						</li>
					</ul>
				<?php elseif( @count($params['new_host']->errors) > 0) : ?>
          <ul class="p-4">
						<?php
						foreach ( $params['new_host']->errors as $error) {
							echo "<li class='p-1'> {$error}</li>";
						}
						?>
          </ul>
				<?php elseif( @count($params['edited_host']->errors) > 0) : ?>
          <ul class="p-4">
						<?php
						foreach ( $params['edited_host']->errors as $error) {
							echo "<li class='p-1'> {$error}</li>";
						}
						?>
          </ul>
				<?php else: ?>
          <h4 class="mb-3 text-center">
            <span>متاسفانه عملیات </span>
						<?php
						if ( @$params['new_host']->crud_type === 'create') {
							echo Constant::TRANSLATION_STRINGS[$params['new_host']->crud_type];
						}
						if ( @$params['edited_host']->crud_type === 'update' ) {
							echo Constant::TRANSLATION_STRINGS[$params['edited_host']->crud_type];
						}
						?>
            <span> هاست به درستی انجام نشد!</span>
          </h4>
					<p>لطفا با مدیر سایت تماس گرفته و مشکل را اعلام نمایید</p>
				<?php endif; ?>
			</div>
		</div>

	</div>
</section>