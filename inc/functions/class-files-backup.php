<?php
/**
 * Files_Backup Class File
 *
 * This file contains Files_Backup class which can backup from whole of your WordPress site
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Updater\Inc\Functions;

use Updater\Inc\Functions\Files_Process;


/**
 * Class Files_Backup
 *
 * This file contains Files_Backup class which can backup from whole of your WordPress site
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @property  string $whole_site_backup_path
 * @property  string $backup_zip_file_name
 * @property  string $backup_zip_file_path
 */
class Files_Backup {
	use Utility;
	private $whole_site_backup_path;
	private $backup_zip_file_name;
	private $backup_zip_file_path;

	public function __construct( $main_path, $host_name, $host_path, $has_file_backup, $primary_script_path, $script_directory) {
		/**
		 * set time zone
		 */
		$this->set_time_zone( 'Asia/Tehran' );
		$this->whole_site_backup_path = $main_path . '05-whole-site-backup/';
		if ( $has_file_backup === false ) {
			$this->backup_zip_file_name = $host_name . '-files-backup-' . date( 'Ymd-Hi' ) . '.zip';
		} else {
			$this->backup_zip_file_name = $host_name . '-files-backup-' . date( 'Ymd' ) . '.zip';
		}
		$temp_script_path           = str_replace( $script_directory, '',$primary_script_path );
		$this->backup_zip_file_path = $temp_script_path . $host_path . $this->backup_zip_file_name;

	}


	/**
	 * @param $property
	 *
	 * @return mixed
	 */
	public function __get( $property ) {
		return $this->$property;
	}

	/**
	 * @param $name
	 * @param $value
	 */
	public function __set( $name, $value ) {
		$this->$name = $value;
	}

	/**
	 * Method to get whole site backup in zipped archive file
	 *
	 * @param Files_Process $files_process_obj
	 * @param boolean       $has_backup_zip
	 * @param string        $log_file
	 * @param string        $wordpress_path
	 */
	public function backup_whole_site(
		Files_Process $files_process_obj,
		$has_backup_zip,
		$log_file,
		$wordpress_path
	) {
		if ( $has_backup_zip ) {
			$zipping_message = 'No need to zip Data! The Date for checking is : ' . date( 'Y-m-d  H:i:s' );
			$files_process_obj->append( $zipping_message, $log_file );
			if ( file_exists( $this->backup_zip_file_path ) ) {
				$backup_moving_result = $files_process_obj->move_file(
					$this->backup_zip_file_path,
					$this->whole_site_backup_path . $this->backup_zip_file_name,
					$type = 'zipped-site-backup'
				);
				$files_process_obj->append( $backup_moving_result['message'], $log_file );

			} else {
				$file_existing_message = 'There is no Zip file to move!!! The Date for checking is :' . date( 'Y-m-d  H:i:s' );
				$files_process_obj->append( $file_existing_message, $log_file );
			}
		} else {

			//$result_of_zipping = msn_zip_data( $main_wordpress_path, $whole_site_backup_path . 'backup.zip', 'windows' );
			$result_of_zipping = $files_process_obj->zip_data( $wordpress_path,
				$this->whole_site_backup_path . $this->backup_zip_file_name );
			if ( $result_of_zipping['result'] === false ) {
				$files_process_obj->append( $result_of_zipping['message'], $log_file );
			} else {
				$files_process_obj->append( $result_of_zipping['message'], $log_file );
			}
		}
		$files_process_obj->append_section_separator( $log_file );
	}
}
