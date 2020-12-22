<?php

require_once '../main-init.php';
use Updater\Functions\UsableFunctions;
use Updater\Config\Constant;

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