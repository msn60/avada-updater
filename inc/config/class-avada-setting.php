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

namespace Updater\Inc\Config;

use Updater\Inc\Config\Primary_Setting;


/**
 * Class Avada_Setting
 *
 * This file contains Avada_Setting class which can set Avada settings for script
 *
 * @package    Updater\Inc\Config
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 */
class Avada_Setting extends Primary_Setting {

	#put count of update site here:
	protected $update_site_count;
	#put last version of avada here:
	protected $avada_last_version;
	#put new version of avada here:
	protected $avada_new_version;

	public function __construct(
		$script_path,
		$update_site_count = 1,
		$avada_last_version = '6.0.3',
		$avada_new_version = '6.1.2',
		$has_backup_zip = false,
		$script_directory = 'updater',
		$domain_name = 'spec',
		$main_path = '../temp-source/'
	) {
		parent::__construct( $script_path, $has_backup_zip, $script_directory, $domain_name, $main_path );
		$this->update_site_count  = $update_site_count;
		$this->avada_last_version = $avada_last_version;
		$this->avada_new_version  = $avada_new_version;
	}

	public function update_site_count(  ) {
		return $this->update_site_count;
	}

	public function avada_last_version() {
		return $this->avada_last_version;
	}

	public function avada_new_version() {
		return $this->avada_new_version;
	}


}


