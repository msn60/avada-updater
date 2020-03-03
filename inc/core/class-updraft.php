<?php
/**
 * Updraft class
 *
 * This file contains main class which can check Updraft directory in backup process
 *
 * @package    Updater\Inc\Core
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Updater\Inc\Core;

use Updater\Inc\Config\Host_config;
use Updater\Inc\Functions\Files_Process;
use Updater\Inc\Functions\Path;


/**
 * Class Updraft
 *
 * This file contains main class which can check Updraft directory in backup process
 *
 * @package    Updater\Inc\Core
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 *
 * @property string  $updraft_bak_path
 * @property boolean $is_check_updraft
 * @property array   $updraft_unwanted_files
 * @property string  $updraft_path
 */
class Updraft {

	use Host_config;

	/**
	 * Points to updraft path in your WordPress site
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string $updraft_path Points to updraft path in your WordPress site.
	 */
	private $updraft_path;

	/**
	 * Points to updraft backup path that you want to use as a swap directory
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string $updraft_bak_path updraft backup path .
	 */
	private $updraft_bak_path;
	private $is_check_updraft;
	private $updraft_unwanted_files = [ ".htaccess", "index.html", "web.config" ];


	/**
	 * Main constructor.
	 * This is constructor of Main class and you can use it for hooking your file
	 * inside it like actions or filters
	 *
	 * @access public
	 * @since  1.0.1
	 */
	public function __construct( $main_path, $host_path, $domain_name ) {
		$this->updraft_path     = '../' . $host_path . 'wp-content/updraft/';
		$this->updraft_bak_path = $main_path . '07-updraft-bak/';
		$this->is_check_updraft = $this->set_host_config( $domain_name )['is_check_updraft'];
		//$this->is_check_updraft = $this->set_updraft_state( $domain_name )['is_check_updraft'];

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
	 * Move extra files of updraft to avoid zipping them in backup files
	 * @param string $type
	 */
	public function move_updraft_extra_files(
		Files_Process $file_process_obj,
		string $main_log_file,
		string $type = 'move-to-temp'
	) {

		if ( $type == 'move-to-temp' ) {
			echo '<h2>back up results for updraft files</h2>';
			$file_process_obj->help_to_move_all_files(
				$this->updraft_path,
				$this->updraft_bak_path,
				$main_log_file,
				true,
				$this->updraft_unwanted_files
			);
		} else {
			echo '<h2>Results for moving updraft files to original directory</h2>';
			$file_process_obj->help_to_move_all_files(
				$this->updraft_bak_path,
				$this->updraft_path,
				$main_log_file,
				true
			);
		}

	}


}


