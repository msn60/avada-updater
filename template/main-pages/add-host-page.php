<?php

require_once '../main-init.php';
use Updater\Functions\UsableFunctions;
use Updater\Config\Constant;
use Updater\Database\DatabaseFunctions;
use Updater\Functions\RequestFunctions;
$request_object = new RequestFunctions();


$database = DatabaseFunctions::connect_to_database(
	Constant::DB_SERVER,
	Constant::DB_USER,
	Constant::DB_PASS,
	Constant::DB_NAME
);


include_once Constant::TEMPLATE_PATH . 'header/head-section.php';
include_once Constant::TEMPLATE_PATH . 'header/header-section.php';


if ( isset($_POST) && ! empty($_POST)) {
	var_dump($_POST);

}

include_once Constant::TEMPLATE_PATH . 'section/add-host-section.php';
?>



<?php
include_once Constant::TEMPLATE_PATH . 'footer/main-footer.php';
?>