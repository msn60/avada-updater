<?php
/**
 * Avada_Updater class
 *
 * This file contains main class which can handle whole script process
 *
 * @package    Updater
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Updater\Inc\Core;


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

	public function __construct(
		string $primary_script_path,
		string $htaccess_lite_speed_config,
		Avada_Setting $primary_setting_obj,
		Path $path_obj,
		Avada $avada_obj,
		Files_Backup $backup_obj,
		Updraft $updraft_obj,
		Files_Process $files_process_obj

	) {
		/**
		 * set time zone
		 */
		$this->set_time_zone( 'Asia/Tehran' );
		/*
		 * sample of dependency injection
		 * */
		$this->script_path                = $primary_script_path;
		$this->primary_setting_obj        = $primary_setting_obj;
		$this->path_obj                   = $path_obj;
		$this->avada_obj                  = $avada_obj;
		$this->backup_obj                 = $backup_obj;
		$this->updraft_obj                = $updraft_obj;
		$this->files_process_obj          = $files_process_obj;
		$this->htaccess_lite_speed_config = $htaccess_lite_speed_config;
		/*
		 * critical files
		 * */
		$this->critical_files = $this->set_critical_files();
		/*
		 * Important directories inside temp-source
		 * */
		$this->important_directories = $this->set_important_directories();
		//$this->set_primary_config( $primary_values );
	}

	public function set_critical_files() {
		return
			[
				[
					'path' => $this->path_obj->main_path,
					'type' => 'main_path',
				],
				[
					'path' => $this->avada_obj->avada_new_files_temp_path,
					'type' => 'avada_file_path',
				],
				[
					'path' => $this->avada_obj->avada_new_theme_file,
					'type' => 'avada_theme_file',
				],
				[
					'path' => $this->avada_obj->avada_new_fusion_builder_file,
					'type' => 'avada_fusion_builder_file',
				],
				[
					'path' => $this->avada_obj->avada_new_fusion_core_file,
					'type' => 'avada_fusion_core_file',
				],
			];
	}

	public function set_important_directories() {
		return
			[
				[
					'path' => $this->avada_obj->avada_new_version_path,
					'type' => 'keeping new versions of Avada files',
				],
				[
					'path' => $this->avada_obj->avada_older_version_path,
					'type' => 'keeping older versions of Avada files',
				],
				[
					'path' => $this->avada_obj->avada_lang_path,
					'type' => 'keeping language files of Avada',
				],
				[
					'path' => $this->updraft_obj->updraft_bak_path,
					'type' => 'keeping extra updraft files',
				],
				[
					'path' => $this->backup_obj->whole_site_backup_path,
					'type' => 'keeping whole site files for update process',
				],
				[
					'path' => $this->path_obj->log_files_path,
					'type' => 'keeping log files of update process',
				],
			];
	}

	/**
	 * Initialize Avada update process
	 */
	public function init() {
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
		if ( $this->primary_setting_obj->update_site_count == 1 ) {
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
		$this->set_new_path_for_avada_files();
		/*
		 * ==================================
		 * move updraft files (if it's exist)
		 * ==================================
		 * */
		if ( $this->updraft_obj->is_check_updraft ) {
			$this->updraft_obj->move_updraft_extra_files(
				$this->files_process_obj,
				$this->path_obj->main_log_file
			);
		}
		/*
		 * ===========================================
		 * Zip whole site and move to backup directory
		 * ===========================================
		 * */
		$this->backup_obj->backup_whole_site(
			$this->files_process_obj,
			$this->primary_setting_obj->has_backup_zip,
			$this->path_obj->main_log_file,
			$this->path_obj->wordpress_path
		);
		/*
		 * ===========================
		 * First: backup language file
		 * ===========================
		 * */
		$this->avada_obj->backup_language_files(
			$this->files_process_obj,
			$this->path_obj->main_log_file
		);

		/*
		 * ===================================================================
		 * Second: Move current Avada theme, fusion builder and fusion core to
		 * last version avada directory (for backup them)
		 * ===================================================================
		 * */
		$this->avada_obj->archive_avada_last_version_files(
			$this->files_process_obj,
			$this->path_obj->main_log_file
		);

		/*
		 * ===================================================
		 * Unzipped Avada theme & fusion core & fusion builder
		 * ===================================================
		 * */
		$this->unzip_avada_last_version_files();

		/*
		 * ===============================================
		 * Move lang file to related original directories
		 * ===============================================
		 * */
		$this->move_lang_files();

		/*
		 * =======================================
		 * Copy new avada.pot to Avada child theme
		 * =======================================
		 * */
		$this->copy_new_avada_pot();


		/*
		 * =====================================================
		 * Return updraft files to its directory in WordPress site
		 * =====================================================
		 * */
		if ( $this->updraft_obj->is_check_updraft ) {
			$this->updraft_obj->move_updraft_extra_files(
				$this->files_process_obj,
				$this->path_obj->main_log_file,
				'move-to-wp-directory'
			);
		}


	}

	public function htaccess_litespeed_check() {

		if ( 'litespeed' === $this->check_server_type() ) {
			$msn_writing_message = $this->files_process_obj->check_prepend_htaccess_for_litespeed( $this->htaccess_lite_speed_config,
				$this->path_obj->htaccess_file_path );
		} else {
			$msn_writing_message = 'It is not LiteSpeed Server. So nothing write on htaccess file. Date is : ' . date( 'Y-m-d  H:i:s' ) . '.';
		}
		$this->files_process_obj->append( $msn_writing_message, $this->path_obj->main_log_file );
		$this->files_process_obj->append_section_separator( $this->path_obj->main_log_file );


	}

	/**
	 * Check critical directory or files
	 *
	 * @param      $path
	 * @param      $type
	 * @param null $logfile
	 */
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

			$this->files_process_obj->append( $error_message, $this->path_obj->main_log_file );
			$this->files_process_obj->append_section_separator( $this->path_obj->main_log_file );
			die( '<h2>You can not continue!!!</h2>' );
		}

	}

	public function check_important_directory_exist( $important_directories ) {
		foreach ( $important_directories as $important_directory ) {
			$temp_result = $this->files_process_obj->make_directory_if_not_exist( $important_directory ['path'], $important_directory ['type'] );
			if ( 'successful' === $temp_result['type'] ) {
				$this->files_process_obj->append( $temp_result['message'], $this->path_obj->main_log_file );
			}
		}
		$this->files_process_obj->append( 'End of checking to be existing important directories', $this->path_obj->main_log_file );
		$this->files_process_obj->append_section_separator( $this->path_obj->main_log_file );

	}

	public function transfer_avada_new_files() {
		$temp_result = $this->files_process_obj->make_directory_if_not_exist( $this->avada_obj->last_version_avada_path,
			'keep older files of avada' );
		$this->files_process_obj->append( $temp_result['message'], $this->path_obj->main_log_file );
		if ( 'un-successful' === $temp_result['type'] ) {
			die( '<h2>You can not continue!!!</h2>' );
		}

		if ( 1 === $this->primary_setting_obj->update_site_count ) {
			if ( 'not-empty-dir' === $this->files_process_obj->is_dir_empty( $this->avada_obj->avada_new_version_path )['type'] ) {
				$this->files_process_obj->help_to_move_all_files(
					$this->avada_obj->avada_new_version_path,
					$this->avada_obj->last_version_avada_path,
					$this->path_obj->main_log_file
				);

			} else {
				$message_for_empty_dir = 'There is nothing to archive last Avada files: ' . date( 'Y-m-d  H:i:s' );
				$this->files_process_obj->append( $message_for_empty_dir, $this->path_obj->main_log_file );
			}
			$this->files_process_obj->help_to_move_all_files(
				$this->avada_obj->avada_new_files_temp_path,
				$this->avada_obj->avada_new_version_path,
				$this->path_obj->main_log_file,
				true
			);
		}
	}

	public function set_new_path_for_avada_files() {
		$this->avada_obj->avada_new_theme_file          = $this->avada_obj->avada_new_version_path . 'avada-new.zip';
		$this->avada_obj->avada_new_fusion_builder_file = $this->avada_obj->avada_new_version_path . 'fusion-builder-new.zip';
		$this->avada_obj->avada_new_fusion_core_file    = $this->avada_obj->avada_new_version_path . 'fusion-core-new.zip';
	}

	public function unzip_avada_last_version_files() {
		$msn_new_theme_items = [
			[
				'source_file'      => $this->avada_obj->avada_new_theme_file,
				'destination_path' => $this->path_obj->main_theme_path,
				'check_directory'  => $this->avada_obj->current_avada_theme_path,
			],
			[
				'source_file'      => $this->avada_obj->avada_new_fusion_builder_file,
				'destination_path' => $this->path_obj->main_plugin_path,
				'check_directory'  => $this->avada_obj->current_avada_fusion_builder_path,
			],
			[
				'source_file'      => $this->avada_obj->avada_new_fusion_core_file,
				'destination_path' => $this->path_obj->main_plugin_path,
				'check_directory'  => $this->avada_obj->current_avada_fusion_core_path,
			],
		];

		foreach ( $msn_new_theme_items as $msn_new_theme_item ) {
			if ( ! file_exists( $msn_new_theme_item['check_directory'] ) ) {
				$msn_unzipping_result = $this->files_process_obj->unzip_data( $msn_new_theme_item['source_file'],
					$msn_new_theme_item['destination_path'] );
				$this->files_process_obj->append( $msn_unzipping_result['message'], $this->path_obj->main_log_file );
			} else {
				$msn_unzipping_unsuccessful_message
					= "We did not extract << {$msn_new_theme_item['source_file']} >> due to existing << {$msn_new_theme_item['destination_path']} >> directory!!!";
				$this->files_process_obj->append( $msn_unzipping_unsuccessful_message, $this->path_obj->main_log_file );
			}

		}
		$this->files_process_obj->append_section_separator( $this->path_obj->main_log_file );
	}

	public function move_lang_files() {
		$lang_list_items = [
			[
				'destination_file_name' => $this->avada_obj->current_avada_fusion_builder_mo_file,
				'source_path'           => $this->avada_obj->backup_avada_fusion_builder_mo_file,
			],
			[
				'destination_file_name' => $this->avada_obj->current_avada_fusion_builder_po_file,
				'source_path'           => $this->avada_obj->backup_avada_fusion_builder_po_file,
			],
			[
				'destination_file_name' => $this->avada_obj->current_avada_fusion_core_mo_file,
				'source_path'           => $this->avada_obj->backup_avada_fusion_core_mo_file,
			],
			[
				'destination_file_name' => $this->avada_obj->current_avada_fusion_core_po_file,
				'source_path'           => $this->avada_obj->backup_avada_fusion_core_po_file,
			],

		];

		$results = $this->files_process_obj->files_bulk_move( $lang_list_items );
		$this->files_process_obj->several_appends( $results, $this->path_obj->main_log_file, true, 'Start to backup lang files',
			'End of backup lang files' );

	}

	/**
	 * copy new avada.pot file in child theme
	 */
	public function copy_new_avada_pot() {
		$remove_pot_file_result = $this->files_process_obj->remove_file( $this->avada_obj->avada_child_theme_lang_pot_file_path );
		$this->files_process_obj->append( $remove_pot_file_result ['message'], $this->path_obj->main_log_file );
		$copy_original_pot_file_result = $this->files_process_obj->copy_file( $this->avada_obj->avada_new_lang_pot_file_path,
			$this->avada_obj->avada_child_theme_lang_pot_file_path );
		$this->files_process_obj->append( $copy_original_pot_file_result ['message'], $this->path_obj->main_log_file );
		$this->files_process_obj->append_section_separator( $this->path_obj->main_log_file );
	}

	/**
	 * Initialize Avada update process 2
	 */
	public function init2() {


		/*
		 * ===============================
		 * Assign new path for Avada files
		 * ===============================
		 * */
		$this->set_new_path_for_avada_files();



	}


}

