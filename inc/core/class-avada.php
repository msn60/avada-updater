<?php
/**
 * Avada class
 *
 * This file contains main class which can manage and handle Avada update process
 *
 * @package    Updater\Inc\Core
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Updater\Inc\Core;


/**
 * Class Avada
 *
 * This file contains main class which can manage and handle Avada update process
 *
 * @package    Updater\Inc\Core
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 */
class Avada {

	/**
	 * Points to current version of Avada at the moment in your WordPress site
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string $avada_last_version current version of Avada.
	 */
	private $avada_last_version;

	/**
	 * Points to new version of Avada that wants to update
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string $avada_last_version current version of Avada.
	 */
	private $avada_new_version;
	private $avada_new_files_temp_path;
	private $avada_new_theme_file;
	private $avada_new_fusion_builder_file;
	private $avada_new_fusion_core_file;
	private $avada_older_version_path;
	private $avada_new_version_path;
	private $avada_lang_path;
	private $current_avada_theme_path;
	private $current_avada_fusion_builder_path;
	private $current_avada_fusion_core_path;

	/**
	 * Main constructor.
	 * This is constructor of Main class and you can use it for hooking your file
	 * inside it like actions or filters
	 *
	 * @access public
	 * @since  1.0.1
	 */
	public function __construct( $main_path, $host_path, $avada_last_version, $avada_new_version ) {
		$this->avada_last_version                = $avada_last_version;
		$this->avada_new_version                 = $avada_new_version;
		$this->avada_new_files_temp_path         = $main_path . '01-temp-new-version-files/';
		$this->avada_new_theme_file              = $this->avada_new_files_temp_path . 'avada-new.zip';
		$this->avada_new_fusion_builder_file     = $this->avada_new_files_temp_path . 'fusion-builder-new.zip';
		$this->avada_new_fusion_core_file        = $this->avada_new_files_temp_path . 'fusion-core-new.zip';
		$this->avada_older_version_path          = $main_path . '02-avada-older-versions/';
		$this->avada_new_version_path            = $main_path . '03-avada-new-version-files/';
		$this->avada_lang_path                   = $main_path . '04-avada-lang-bak/';
		$this->current_avada_theme_path          = '../' . $host_path . 'wp-content/themes/Avada/';
		$this->current_avada_fusion_builder_path = '../' . $host_path . 'wp-content/plugins/fusion-builder/';
		$this->current_avada_fusion_core_path    = '../' . $host_path . 'wp-content/plugins/fusion-core/';

	}

	public function avada_last_version(  ) {
		return $this->avada_last_version;
	}

	public function avada_new_version(  ) {
		return $this->avada_new_version;
	}

	public function avada_new_files_temp_path() {
		return $this->avada_new_files_temp_path;
	}

	public function avada_new_theme_file() {
		return $this->avada_new_theme_file;
	}

	public function avada_new_fusion_builder_file() {
		return $this->avada_new_fusion_builder_file;
	}

	public function avada_new_fusion_core_file() {
		return $this->avada_new_fusion_core_file;
	}

	public function avada_older_version_path() {
		return $this->avada_older_version_path;
	}

	public function avada_new_version_path() {
		return $this->avada_new_version_path;
	}

	public function avada_lang_path() {
		return $this->avada_lang_path;
	}

	public function current_avada_theme_path() {
		return $this->current_avada_theme_path;
	}

	public function current_avada_fusion_builder_path() {
		return $this->current_avada_theme_path;
	}

	public function current_avada_fusion_core_path() {
		return $this->current_avada_fusion_core_path;
	}


}


