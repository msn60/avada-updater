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

	private function set_updraft_state( $domain_name ) {
		switch ( $domain_name ) {
			case 'anyl':
				$host_name        = 'anyl';
				$host_path        = 'anyl.wpwebmaster.ir/';
				$is_check_updraft = true;
				break;
			case 'aitanrehab':
				$host_name        = 'aitan';
				$host_path        = 'aitanrehab/';
				$is_check_updraft = false;
				break;
			case 'hekmat':
				$host_name        = 'hekmat';
				$host_path        = 'hco.wpwebmaster.ir/';
				$is_check_updraft = false;
				break;
			case 'novinbazsazi':
				$host_name        = 'novinbazsazi';
				$host_path        = 'novinbazsazi.com/';
				$is_check_updraft = true;
				break;
			case 'test-academy':
				$host_name        = 'test-academy';
				$host_path        = 'academy.wpwebmaster.ir/';
				$is_check_updraft = false;
				break;
			case 'stargaz':
				$host_name        = 'stargaz';
				$host_path        = 'stargazetrading.com/';
				$is_check_updraft = true;
				break;
			case 'jesmoravan':
				$host_name        = 'jesmoravan';
				$host_path        = 'jesmoravan.com/';
				$is_check_updraft = true;
				break;
			case 'wpwebmaster':
				$host_name        = 'wpwebmaster';
				$host_path        = 'public_html/';
				$is_check_updraft = true;
				break;
			case 'firstsite.com':
				$host_name        = 'firstsite';
				$host_path        = 'firstsite.com/';
				$is_check_updraft = true;
				break;
			case 'secondsite.com':
				$host_name        = 'secondsite';
				$host_path        = 'secondsite.com/';
				$is_check_updraft = true;
				break;
			case 'webmaster':
				$host_name        = 'webmaster';
				$host_path        = 'webmaster/';
				$is_check_updraft = false;
				break;
			case 'spec':
				$host_name        = 'spec';
				$host_path        = 'spec/';
				$is_check_updraft = true;
				break;
			default:
				$host_name        = 'spec';
				$host_path        = 'spec/';
				$is_check_updraft = true;

		}

		return [
			'host_name'        => $host_name,
			'host_path'        => $host_path,
			'is_check_updraft' => $is_check_updraft,
		];
	}


}


