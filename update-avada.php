<?php

namespace Updater;
require_once __DIR__ . '/vendor/autoload.php';

use Updater\Inc\Core\{
	Avada, Avada_Updater, Updraft
};
use Updater\Inc\Functions\{
	Files_Backup, Utility, Path, Files_Process
};
use Updater\Inc\Config\{
	Primary_Setting, Avada_Setting
};


/**
 * Initial values
 */
$primary_script_path = dirname( __FILE__ );
$htaccess_lite_speed_config
                     = <<< HTACCESS
<IfModule Litespeed>
RewriteEngine On
RewriteRule .* - [E=noabort:1]
RewriteRule .* - [E=noconntimeout:1]
</IfModule>
HTACCESS;

$primary_setting_obj = new Avada_Setting( $primary_script_path );
$path_obj            = new Path( $primary_setting_obj );
$avada_obj           = new Avada(
	$path_obj->main_path,
	$path_obj->host_path,
	$primary_setting_obj->avada_last_version,
	$primary_setting_obj->avada_new_version,
	$path_obj->host_name,
	$path_obj->main_theme_path
);
$backup_obj          = new Files_Backup(
	$path_obj->main_path,
	$path_obj->host_name,
	$path_obj->host_path,
	$primary_setting_obj->has_backup_zip
);
$updraft_obj         = new Updraft(
	$path_obj->main_path,
	$path_obj->host_path,
	$primary_setting_obj->domain_name
);
$files_process_obj   = new Files_Process();
$updater_obj         = new Avada_Updater(
	$primary_script_path,
	$htaccess_lite_speed_config,
	$primary_setting_obj,
	$path_obj,
	$avada_obj,
	$backup_obj,
	$updraft_obj,
	$files_process_obj
);
//var_dump($updater_obj);

$updater_obj->init2();
/*var_dump( $updater_obj->primary_setting_obj );
var_dump( $updater_obj->path_obj );
var_dump( $updater_obj->avada_obj );
var_dump( $updater_obj->backup_obj );
var_dump( $updater_obj->updraft_obj );
var_dump( $updater_obj->critical_files );
var_dump( $updater_obj->important_directories );*/

/*
 * ==================
 * End of script
 * ==================
 * */



