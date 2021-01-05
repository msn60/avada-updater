<?php

require_once '../main-init.php';
use Updater\Functions\UsableFunctions;
use Updater\Config\Constant;
use Updater\Database\DatabaseObject;
use Updater\Database\DatabaseFunctions;
use Updater\Functions\RequestFunctions;
use Updater\Config\Host;
use Updater\ViewHandler\PageRender;
$request_object = new RequestFunctions();


$database = DatabaseFunctions::connect_to_database(
	Constant::DB_SERVER,
	Constant::DB_USER,
	Constant::DB_PASS,
	Constant::DB_NAME
);
DatabaseObject::set_database($database);

$page_title = 'اضافه کردن هاست';
/*include_once Constant::TEMPLATE_PATH . 'header/head-section.php';
include_once Constant::TEMPLATE_PATH . 'header/header-section.php';*/
PageRender::load_template('header.head-section');
PageRender::load_template('header.header-section');


if ( $request_object->is_post_request() && isset($_POST) && ! empty($_POST)) {
	$args = $_POST['host'];
	$new_host = new Host( $args);
	$host_creation_result = $new_host->save();
?>
<hr>
<section class="mt-2">
  <div class="container  mt-2">
    <div class="row">
      <div class="col-md-8 bg-white  msn-shadow-light rounded-lg p-4 mx-auto ">
				<?php if ( $host_creation_result === true ): ?>
          <h4 class="mb-3 text-center">مشخصات هاست به درستی ثبت شد</h4>
          <ul class="p-4">
            <li>نام هاست:
							<?php echo $new_host->host_name ?>
            </li>
            <li>آدرس هاست:
							<?php echo $new_host->host_path ?>
            </li>
          </ul>
        <!--TODO: Show errors-->
        <?php elseif( count($new_host->errors) > 0) : ?>
        <?php var_dump($new_host->errors); ?>
				<?php else: ?>
          <h4 class="mb-3 text-center">مشخصات هاست به درستی ثبت نشد</h4>
          <p>لطفا با مدیر سایت تماس گرفته و مشکل را اعلام نمایید</p>
				<?php endif; ?>
      </div>
    </div>

  </div>
</section>
<?php

} else {
	//include_once Constant::TEMPLATE_PATH . 'section/host-add-section.php';
  PageRender::load_template('section.host-add-section');
}

//include_once Constant::TEMPLATE_PATH . 'footer/main-footer.php';
PageRender::load_template('footer.main-footer');

DatabaseFunctions::disconnect_database( $database );
?>