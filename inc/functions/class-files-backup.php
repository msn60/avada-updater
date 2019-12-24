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
 */
class Files_Backup {

	private $whole_site_backup_path;
	private $backup_zip_file_name;
	private $backup_zip_file_path;

	public function __construct( $main_path, $host_name, $host_path ) {
		$this->whole_site_backup_path = $main_path . '05-whole-site-backup/';
		$this->backup_zip_file_name   = $host_name . '-files-backup-' . date( 'Ymd-Hi' ) . '.zip';
		$this->backup_zip_file_path   = '../' . $host_path . $this->backup_zip_file_name;

	}

	public function whole_site_backup_path() {
		return $this->whole_site_backup_path;
	}

	public function backup_zip_file_name() {
		return $this->backup_zip_file_name;
	}

	public function backup_zip_file_path() {
		return $this->backup_zip_file_path;
	}
}
