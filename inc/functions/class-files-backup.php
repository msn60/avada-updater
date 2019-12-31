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

	private $whole_site_backup_path;
	private $backup_zip_file_name;
	private $backup_zip_file_path;

	public function __construct( $main_path, $host_name, $host_path, $has_file_backup ) {
		$this->whole_site_backup_path = $main_path . '05-whole-site-backup/';
		if ($has_file_backup === false ) {
			$this->backup_zip_file_name   = $host_name . '-files-backup-' . date( 'Ymd-Hi' ) . '.zip';
		} else {
			$this->backup_zip_file_name   = $host_name . '-files-backup-' . date( 'Ymd' ) . '.zip';
		}
		$this->backup_zip_file_path   = '../' . $host_path . $this->backup_zip_file_name;

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
	public function __set( $name , $value ) {
		$this->$name = $value;
	}
}
