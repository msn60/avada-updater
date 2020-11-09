<?php

include_once 'main-init.php';
use Updater\Functions\UsableFunctions;
include_once 'template/header/head-section.php';
include_once 'template/header/header-section.php';

UsableFunctions::test();

if ( isset($_POST) && ! empty($_POST)) {
	var_dump($_POST);

}

include_once 'template/section/add-host-section.php';
?>



<?php
include_once 'template/footer/main-footer.php';
?>