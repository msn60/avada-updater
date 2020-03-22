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
	$primary_setting_obj->has_backup_zip,
	$primary_setting_obj->script_directory
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

/**
 *
 * TODO: Change zip method to decrease using physical memory usage
 * TODO: create database backup & move to backup directory
 * TODO: move logfile to temp-source
 * TODO: update a plugin like advance custom fields
 * TODO: remove avada lang from languages directory if it exists
 * TODO: only backup from sites
 * TODO: GUI for this script
 * TODO: Remove older directory which are archived older versions of avada files
 *
 */

//$updater_obj->init_for_local_test();
$updater_obj->init();

unset($updater_obj);
unset($files_process_obj);
unset($updraft_obj);
unset($backup_obj);
unset($avada_obj);
unset($path_obj);
unset($primary_setting_obj);

gc_collect_cycles();

/*
$updater_obj->test_init();
echo 'The script is now using: <strong>' . round(memory_get_usage() / (1024*1024)) . 'MB</strong> of memory.<br>';
echo 'Peak usage: <strong>' . round(memory_get_peak_usage() / (1024*1024)) . 'MB</strong> of memory.<br><br>';

*/

/*
 * ==================
 * End of script
 * ==================
 * */



