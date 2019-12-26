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
	public $important_directories;

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
				$this->check_critical_files_exists( $critical_file['path'], $critical_file['type'] );
			}
		}
		/*
		 * =================================================================
		 * Checking directory or files that we need to continue this script.
		 * If they don't exist, we will create theme.
		 * =================================================================
		 * */
		$this->check_important_directory_exist( $this->important_directories );
		/*
		 * =====================================================
		 * moving old avada files and change them with new files
		 * =====================================================
		 * */
		$this->transfer_avada_new_files();
		/*
		 * ===============================
		 * Assign new path for Avada files
		 * ===============================
		 * */
		$this->set_new_path_for_Avada_files();


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
		$this->avada_obj                  = new Avada(
			$this->path_obj->main_path(),
			$this->path_obj->host_path(),
			$this->primary_setting_obj->avada_last_version(),
			$this->primary_setting_obj->avada_new_version(),
			$this->path_obj->host_name()
		);
		$this->backup_obj                 = new Files_Backup(
			$this->path_obj->main_path(),
			$this->path_obj->host_name(),
			$this->path_obj->host_path()
		);
		$this->updraft_obj                = new Updraft(
			$this->path_obj->main_path(),
			$this->path_obj->host_path(),
			$this->primary_setting_obj->domain_name()
		);
		$this->files_process_obj          = new Files_Process();
		$this->htaccess_lite_speed_config = $primary_values['htaccess_lite_speed_config'];
		/*
		 * critical files
		 * */
		$this->critical_files = $this->set_critical_files();
		/*
		 * Important directories inside temp-source
		 * */
		$this->important_directories = $this->set_important_directories();
	}

	public function set_critical_files() {
		return
			[
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

	public function set_important_directories() {
		return
			[
				[
					'path' => $this->avada_obj->avada_new_version_path(),
					'type' => 'keeping new versions of Avada files',
				],
				[
					'path' => $this->avada_obj->avada_older_version_path(),
					'type' => 'keeping older versions of Avada files',
				],
				[
					'path' => $this->avada_obj->avada_lang_path(),
					'type' => 'keeping language files of Avada',
				],
				[
					'path' => $this->updraft_obj->updraft_bak_path(),
					'type' => 'keeping extra updraft files',
				],
				[
					'path' => $this->backup_obj->whole_site_backup_path(),
					'type' => 'keeping whole site files for update process',
				],
				[
					'path' => $this->path_obj->log_files_path(),
					'type' => 'keeping log files of update process',
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

	public function check_critical_files_exists( $path, $type, $logfile = null ) {
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

	public function check_important_directory_exist( $important_directories ) {
		foreach ( $important_directories as $important_directory ) {
			$temp_result = $this->files_process_obj->make_directory_if_not_exist( $important_directory ['path'], $important_directory ['type'] );
			if ( $temp_result['type'] == 'successful' ) {
				$this->files_process_obj->append( $temp_result['message'], $this->path_obj->main_log_file() );
			}
		}
		$this->files_process_obj->append( 'End of checking to be existing important directories', $this->path_obj->main_log_file() );
		$this->files_process_obj->append_section_separator( $this->path_obj->main_log_file() );

	}

	public function transfer_avada_new_files() {
		$temp_result = $this->files_process_obj->make_directory_if_not_exist( $this->avada_obj->last_version_avada_path(),
			'keep older files of avada' );
		$this->files_process_obj->append( $temp_result['message'], $this->path_obj->main_log_file() );
		if ( $temp_result['type'] == 'un-successful' ) {
			die( '<h2>You can not continue!!!</h2>' );
		}

		if ( $this->primary_setting_obj->update_site_count() == 1 ) {
			if ( $this->files_process_obj->is_dir_empty( $this->avada_obj->avada_new_version_path() )['type'] == 'not-empty-dir' ) {
				$first_moving_results = $this->files_process_obj->move_all_files_in_directory(
					$this->avada_obj->avada_new_version_path(), $this->avada_obj->last_version_avada_path()
				);
				foreach ( $first_moving_results as $first_moving_result ) {
					$this->files_process_obj->append( $first_moving_result['message'], $this->path_obj->main_log_file() );
				}

			} else {
				$message_for_empty_dir = 'There is nothing to archive last Avada files: ' . date( 'Y-m-d  H:i:s' );
				$this->files_process_obj->append( $message_for_empty_dir, $this->path_obj->main_log_file() );
			}
			$second_moving_results = $this->files_process_obj->move_all_files_in_directory(
				$this->avada_obj->avada_new_files_temp_path(), $this->avada_obj->avada_new_version_path()
			);
			foreach ( $second_moving_results as $second_moving_result ) {
				$this->files_process_obj->append( $second_moving_result['message'], $this->path_obj->main_log_file() );
			}

			$this->files_process_obj->append_section_separator( $this->path_obj->main_log_file() );
		}
	}

	public function set_new_path_for_Avada_files() {
		$this->avada_obj->set_avada_new_theme_file( $this->avada_obj->avada_new_version_path() . 'avada-new.zip' );
		$this->avada_obj->set_avada_new_fusion_builder_file( $this->avada_obj->avada_new_version_path() . 'fusion-builder-new.zip' );
		$this->avada_obj->set_avada_new_fusion_core_file( $this->avada_obj->avada_new_version_path() . 'fusion-core-new.zip' );
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
var_dump( $updater_obj->critical_files );
var_dump( $updater_obj->important_directories );

/*

*/



