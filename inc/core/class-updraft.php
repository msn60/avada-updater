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


/**
 * Class Updraft
 *
 * This file contains main class which can check Updraft directory in backup process
 *
 * @package    Updater\Inc\Core
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
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

	public function updraft_bak_path() {
		return $this->updraft_bak_path;
	}

	public function updraft_path() {
		return $this->updraft_path;
	}

	public function is_check_updraft() {
		return $this->is_check_updraft;
	}

	public function updraft_unwanted_files() {
		return $this->updraft_unwanted_files;
	}


}


