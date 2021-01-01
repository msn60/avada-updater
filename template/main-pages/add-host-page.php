<?php

require_once '../main-init.php';
use Updater\Functions\UsableFunctions;
use Updater\Config\Constant;
use Updater\Database\DatabaseObject;
use Updater\Database\DatabaseFunctions;
use Updater\Functions\RequestFunctions;
use Updater\Config\Host;
$request_object = new RequestFunctions();


$database = DatabaseFunctions::connect_to_database(
	Constant::DB_SERVER,
	Constant::DB_USER,
	Constant::DB_PASS,
	Constant::DB_NAME
);
DatabaseObject::set_database($database);


include_once Constant::TEMPLATE_PATH . 'header/head-section.php';
include_once Constant::TEMPLATE_PATH . 'header/header-section.php';


if ( $request_object->is_post_request() && isset($_POST) && ! empty($_POST)) {
	$args = $_POST['host'];
	$new_host = new Host( $args);
	$host_creation_result = $new_host->save();
	if ($host_creation_result === true ) {
		echo '<h2>به مولا غلام</h2>';
	} else {
		echo '<h2>به چخ رفت غلام</h2>';
	}


} else {
	include_once Constant::TEMPLATE_PATH . 'section/add-host-section.php';
}


?>



<?php
include_once Constant::TEMPLATE_PATH . 'footer/main-footer.php';

DatabaseFunctions::disconnect_database( $database );
?>