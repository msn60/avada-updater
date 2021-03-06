<?php
/**
 * Avada_Setting class
 *
 * This file contains Avada_Setting class which can set Avada settings for script
 *
 * @package    Updater\Inc\Config
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Updater\Config;

use Updater\Config\PrimarySettings;


/**
 * Class Avada_Setting
 *
 * This file contains Avada_Setting class which can set Avada settings for script
 *
 * @package    Updater\Inc\Config
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @property string $test
 * @since      1.0.1
 * @property string $avada_new_version
 * @property int    $update_site_count
 * @property string $avada_last_version
 */
class AvadaSetting extends PrimarySettings {

	#put count of update site here:
	protected $update_site_count;
	#put last version of avada here:
	protected $avada_last_version;
	#put new version of avada here:
	protected $avada_new_version;

	public function __construct(
		$script_path,
		$update_site_count = 2,
		$avada_last_version = '6.2.1',
		$avada_new_version = '6.2.2',
		$has_backup_zip = true,
		//$script_directory = 'update.wpwebmaster.ir',
		$script_directory = 'updater',
		$domain_name = 'spec',
		$main_path = '../temp-source/'
	) {
		parent::__construct( $script_path, $has_backup_zip, $script_directory, $domain_name, $main_path );
		$this->update_site_count  = $update_site_count;
		$this->avada_last_version = $avada_last_version;
		$this->avada_new_version  = $avada_new_version;
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


