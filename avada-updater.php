<?php

namespace Updater;
require_once __DIR__ . '/vendor/autoload.php';

namespace Updater\Inc;

use Updater\Inc\Core\{
	Avada, Updraft
};
use Updater\Inc\Functions\{
	Files_Backup, Utility, Path, Files_Process
};
use Updater\Inc\Config\{
	Primary_Setting, Avada_Setting
};


class  Avada_Updater {
	use Utility;
	public $script_path;
	/**
	 * @var Avada_Setting class an object for primary settings
	 */
	public $primary_setting_obj;
	/**
	 * @var Path class an object to define all path in script
	 */
	public $path_obj;
	/**
	 * @var Avada class an object to define avada path in script
	 */
	public $avada_obj;
	/**
	 * @var Files_Backup class an object to define file backup settings and methods in script
	 */
	public $backup_obj;
	/**
	 * @var Updraft class an object to define updraft settings and methods in script
	 */
	public $updraft_obj;
	/**
	 * @var Files_Process class an object to process on a file
	 */
	public $files_process_obj;
	public $htaccess_lite_speed_config;
	public $critical_files;

	public function __construct( $primary_values ) {
		$this->set_primary_config( $primary_values );
		/*
		 * =================
		 * set ini settings
		 * =================
		 * */
		$this->change_ini_settings();
		/*
		 * ==================================================
		 * Check type of webserver and put related code on it
		 * ==================================================
		 * */
		$this->htaccess_litespeed_check();
		/*
		 * ============================================================
		 * Checking critical directory and file before executing script
		 * =============================================================
		 * */
		if ( $this->primary_setting_obj->update_site_count() == 1 ) {
			foreach ( $this->critical_files as $critical_file ) {
				$this->check_critical_files_exists( $critical_file['path'], $critical_file['type'], $this->path_obj->main_log_file() );
			}
		}
	}

	public function set_primary_config( $primary_values ) {
		/*
		 * set time zone
		 * */
		$this->set_time_zone( 'Asia/Tehran' );
		/*
		 * sample of dependency injection
		 * */
		$this->script_path                = $primary_values['script_path'];
		$this->primary_setting_obj        = new Avada_Setting( $this->script_path );
		$this->path_obj                   = new Path( $this->primary_setting_obj );
		$this->avada_obj                  = new Avada( $this->path_obj->main_path(), $this->path_obj->host_path(),
			$this->primary_setting_obj->avada_last_version(),
			$this->primary_setting_obj->avada_new_version() );
		$this->backup_obj                 = new Files_Backup( $this->path_obj->main_path(), $this->path_obj->host_name(),
			$this->path_obj->host_path() );
		$this->updraft_obj                = new Updraft( $this->path_obj->main_path(), $this->path_obj->host_path(),
			$this->primary_setting_obj->domain_name() );
		$this->files_process_obj          = new Files_Process();
		$this->htaccess_lite_speed_config = $primary_values['htaccess_lite_speed_config'];
		/*
		 * critical files
		 * */
		$this->set_critical_files();
	}

	public function set_critical_files() {
		$this->critical_files = [
			[
				'path' => $this->path_obj->main_path(),
				'type' => 'main_path',
			],
			[
				'path' => $this->avada_obj->avada_new_files_temp_path(),
				'type' => 'avada_file_path',
			],
			[
				'path' => $this->avada_obj->avada_new_theme_file(),
				'type' => 'avada_theme_file',
			],
			[
				'path' => $this->avada_obj->avada_new_fusion_builder_file(),
				'type' => 'avada_fusion_builder_file',
			],
			[
				'path' => $this->avada_obj->avada_new_fusion_core_file(),
				'type' => 'avada_fusion_core_file',
			],
		];
	}

	public function htaccess_litespeed_check() {

		if ( $this->check_server_type() == 'litespeed' ) {
			$msn_writing_message = $this->files_process_obj->check_prepend_htaccess_for_litespeed( $this->htaccess_lite_speed_config,
				$this->path_obj->htaccess_file_path() );
		} else {
			$msn_writing_message = 'It is not LiteSpeed Server. So nothing write on htaccess file. Date is : ' . date( 'Y-m-d  H:i:s' ) . '.';
		}
		$this->files_process_obj->append( $msn_writing_message, $this->path_obj->main_log_file() );
		$this->files_process_obj->append_section_separator( $this->path_obj->main_log_file() );


	}

	/*
	 * Check critical directory or files
	 * */
	public function check_critical_files_exists( $path, $type, $logfile ) {
		$error_message = 'Error message created on: ' . date( 'Y-m-d  H:i:s' ) . '.' . PHP_EOL;
		if ( ! file_exists( $path ) ) {
			switch ( $type ) {
				case 'main_path':
					$error_message .= 'You must define correct main path!';
					break;
				case 'avada_file_path':
					$error_message .= 'You must define correct avada file path!';
					break;
				case 'avada_theme_file':
					$error_message .= 'You must put theme zip file in 01-temp-new-version-files directory!';
					break;
				case 'avada_fusion_builder_file':
					$error_message .= 'You must put fusion builder zip file in 01-temp-new-version-files directory!';
					break;
				case 'avada_fusion_core_file':
					$error_message .= 'You must put fusion core zip file in 01-temp-new-version-files directory!';
					break;
			}

			$this->files_process_obj->append( $error_message, $this->path_obj->main_log_file() );
			$this->files_process_obj->append_section_separator( $this->path_obj->main_log_file() );
			die( '<h2>You can not continue!!!</h2>' );
		}

	}
}


$primary_values['script_path'] = dirname( __FILE__ );
$primary_values['htaccess_lite_speed_config']
                               = <<< HTACCESS
<IfModule Litespeed>
RewriteEngine On
RewriteRule .* - [E=noabort:1]
RewriteRule .* - [E=noconntimeout:1]
</IfModule>
HTACCESS;

$updater_obj = new Avada_Updater( $primary_values );
var_dump( $updater_obj->primary_setting_obj );
var_dump( $updater_obj->path_obj );
var_dump( $updater_obj->avada_obj );
var_dump( $updater_obj->backup_obj );
var_dump( $updater_obj->updraft_obj );

/*

*/



