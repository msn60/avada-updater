<?php
/**
 * Path Class File
 *
 * This file contains Path class which can related paths for running script
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Updater\Inc\Functions;

use Updater\Inc\Config\Host_config;
use Updater\Inc\Config\Primary_Setting;


/**
 * Class Path
 *
 * This file contains Path class which can related paths for running script
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @property string $script_directory
 * @property string $script_path
 * @property string $domain_name
 * @property string $main_path
 * @property string $main_start_path
 * @property string $host_name
 * @property string $host_path
 * @property string $wordpress_path
 * @property string $main_theme_path
 * @property string $main_plugin_path
 * @property string $log_files_path
 * @property string $main_log_file
 * @property string $htaccess_file_path
 * @property string $wordpress_htaccess_file_path
 */
class Path {

	use Host_config;
	private $script_directory;
	private $script_path;
	private $domain_name;
	private $main_path;

	private $main_start_path;
	private $host_name;
	private $host_path;

	private $wordpress_path;
	private $main_theme_path;
	private $main_plugin_path;
	private $log_files_path;
	private $main_log_file;
	private $htaccess_file_path;
	private $wordpress_htaccess_file_path;

	public function __construct(
		Primary_Setting $primary_setting_obj
	) {
		$this->script_directory = $primary_setting_obj->script_directory;
		$this->script_path      = $primary_setting_obj->script_path;
		$this->domain_name      = $primary_setting_obj->domain_name;
		$this->main_path        = $primary_setting_obj->main_path;
		$this->main_start_path  = $this->set_main_start_path();
		$this->host_name        = $this->set_host_config( $this->domain_name )['host_name'];
		$this->host_path        = $this->set_host_config( $this->domain_name )['host_path'];
		/*		$this->host_name        = $this->set_host_name_path( $domain_name )['host_name'];
				$this->host_path        = $this->set_host_name_path( $domain_name )['host_path'];*/

		$this->wordpress_path               = $this->set_wordpress_path();
		$this->main_theme_path              = '../' . $this->host_path . 'wp-content/themes/';
		$this->main_plugin_path             = '../' . $this->host_path . 'wp-content/plugins/';
		$this->log_files_path               = $this->main_path . '06-log-files/';
		$this->main_log_file                = 'logs/' . "{$this->host_name}-update-log-file-" . date( 'Ymd' ) . '.log';
		$this->wordpress_htaccess_file_path = '../' . $this->host_path . '.htaccess';
		$this->htaccess_file_path           =  './.htaccess';

	}

	/**
	 * @param mixed $main_start_path
	 */
	private function set_main_start_path() {
		$main_start_path = str_replace( $this->script_directory, '', $this->script_path );
		/*
		 * For linux OS
		 * */
		$main_start_path = str_replace( '//', '', $main_start_path );
		/*
		 * For Windows OS
		 * */
		$main_start_path = str_replace( '\/', '', $main_start_path );

		return $main_start_path;

	}

	private function set_wordpress_path() {
		//$has_host_name = true;
		if ( PHP_OS == 'WINNT' ) {
			return str_replace( '/', '\\', $this->main_start_path . $this->host_path );
		} else {
			return $this->main_start_path . $this->host_path;
		}

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


