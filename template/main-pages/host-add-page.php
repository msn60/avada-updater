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
DatabaseObject::set_database( $database );

$page_title = 'اضافه کردن هاست';
/*include_once Constant::TEMPLATE_PATH . 'header/head-section.php';
include_once Constant::TEMPLATE_PATH . 'header/header-section.php';*/
PageRender::load_template( 'header.head-section', [$page_title]  );
PageRender::load_template( 'header.header-section' );

if ( $request_object->is_post_request() && isset( $_POST ) && ! empty( $_POST ) ) {
	$args                 = $_POST['host'];
	$new_host             = new Host( $args );
	$host_creation_result = $new_host->save();
	?>
  <hr>
	<?php
	PageRender::load_template(
		'section.host-show-crud-result',
		[
			'new_host'             => $new_host,
			'host_creation_result' => $host_creation_result,
		]
	);

} else {
	//include_once Constant::TEMPLATE_PATH . 'section/host-add-section.php';
	PageRender::load_template( 'section.host-add-section' );
}

//include_once Constant::TEMPLATE_PATH . 'footer/main-footer.php';
PageRender::load_template( 'footer.main-footer' );

DatabaseFunctions::disconnect_database( $database );
?>