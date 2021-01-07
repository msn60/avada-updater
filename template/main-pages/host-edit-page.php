<?php

require_once '../main-init.php';

use Updater\Functions\UsableFunctions;
use Updater\Config\Constant;
use Updater\Database\DatabaseObject;
use Updater\Database\DatabaseFunctions;
use Updater\Functions\RequestFunctions;
use Updater\Config\Host;
use Updater\ViewHandler\PageRender;
use Updater\Functions\Validation;
$request_object = new RequestFunctions();

$database = DatabaseFunctions::connect_to_database(
	Constant::DB_SERVER,
	Constant::DB_USER,
	Constant::DB_PASS,
	Constant::DB_NAME
);
DatabaseObject::set_database( $database );

$page_title = 'آپدیت کردن هاست';
/*include_once Constant::TEMPLATE_PATH . 'header/head-section.php';
include_once Constant::TEMPLATE_PATH . 'header/header-section.php';*/
PageRender::load_template( 'header.head-section', [$page_title] );
PageRender::load_template( 'header.header-section' );

if ( ! isset( $_GET['id'] ) ) {
  $request_object->redirect_to(Constant::TEMPLATE_URL . 'main-pages/host-all-records-page.php');
}

$id = stripslashes($_GET['id']);
$id = htmlspecialchars( $id ) ;
$host = Host::find_by_id($id);
if ( false == $host ) {
	$request_object->redirect_to(Constant::TEMPLATE_URL . 'main-pages/host-all-records-page.php');
}

if ( $request_object->is_post_request() ) {
	$args = $_POST['host'];
	$host->merge_attributes($args);
	$host_edit_result = $host->save();
	PageRender::load_template(
		'section.host-show-crud-result',
		[
			'edited_host'      => $host,
			'host_edit_result' => $host_edit_result,
		]
	);
	PageRender::load_template( 'footer.main-footer' );
	DatabaseFunctions::disconnect_database( $database );
	exit();
}

PageRender::load_template('section.host-add-section', [$host]);

//include_once Constant::TEMPLATE_PATH . 'footer/main-footer.php';
PageRender::load_template( 'footer.main-footer' );

DatabaseFunctions::disconnect_database( $database );
?>