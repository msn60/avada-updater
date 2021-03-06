<?php
/**
 * Primary_Setting class
 *
 * This file contains Primary_Setting class which can set Primary settings for script
 *
 * @package    Updater\Inc\Config
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Updater\Config;


/**
 * Class Primary_Setting
 *
 * This file contains Primary_Setting class which can set Primary settings for script
 *
 * @package    Updater\Inc\Config
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @property string  $script_path
 * @property boolean $has_backup_zip
 * @property string  $script_directory
 * @property string  $domain_name
 * @property string  $main_path Define paths and files for updater script
 */
class PrimarySettings {


	protected $script_path;
	#put state of checking zip backup file here:
	protected $has_backup_zip;
	//$msn_script_directory = 'update.wpwebmaster.ir';
	#put your script directory here:
	protected $script_directory;
	#put your main domain name here:
	/*
	 * Note: for new domain name you must set host_name and host_path in Path class
	 * and is_check_updraft in Updraft class
	 * */
	//$domain_name = 'novinbazsazi';
	//$domain_name = 'jesmoravan';
	//$domain_name = 'test-academy';
	//$msn_domain_name = 'anyl';
	//$domain_name = 'aitanrehab';
	//$domain_name = 'hekmat';
	//$domain_name = 'stargaz';
	//$domain_name = 'wpwebmaster';
	//$domain_name = 'firstsite.com';
	//$domain_name = 'secondsite.com';
	protected $domain_name;
	/*
	 * Define paths and files for updater script
	 * */
	protected $main_path;

	public function __construct(
		$script_path,
		$has_backup_zip = false,
		$script_directory = 'updater',
		$domain_name = 'wpweb',
		$main_path = '../temp-source/'
	) {
		$this->script_path      = $script_path;
		$this->has_backup_zip   = $has_backup_zip;
		$this->script_directory = $script_directory;
		$this->domain_name      = $domain_name;
		$this->main_path        = $main_path;
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
}


