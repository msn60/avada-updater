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
 * @property string $avada_last_version                    Points to current version of Avada at the moment in your WordPress site.
 * @property string $avada_new_version                     Points to new version of Avada for update.
 * @property string $avada_new_files_temp_path
 * @property string $avada_new_theme_file
 * @property string $avada_new_fusion_builder_file
 * @property string $avada_new_fusion_core_file
 * @property string $avada_older_version_path
 * @property string $avada_new_version_path
 * @property string $avada_lang_path
 * @property string $current_avada_theme_path
 * @property string $current_avada_fusion_builder_path
 * @property string $current_avada_fusion_core_path
 * @property string $last_version_avada_path
 * @property string $last_version_avada_theme_path
 * @property string $last_version_avada_fusion_builder_path
 * @property string $last_version_avada_fusion_core_path
 * @property string $current_avada_fusion_builder_mo_file
 * @property string $current_avada_fusion_builder_po_file
 * @property string $current_avada_fusion_core_mo_file
 * @property string $current_avada_fusion_core_po_file
 * @property string $backup_avada_fusion_builder_mo_file
 * @property string $backup_avada_fusion_builder_po_file
 * @property string $backup_avada_fusion_core_mo_file
 * @property string $backup_avada_fusion_core_po_file
 * @property string $avada_child_theme_lang_path
 * @property string $avada_child_theme_lang_pot_file_path
 * @property string $avada_new_lang_pot_file_path
 *
 * @see        https://manual.phpdoc.org/HTMLSmartyConverter/PHP/phpDocumentor/tutorial_tags.property.pkg.html
 * @see        https://intellij-support.jetbrains.com/hc/en-us/community/posts/206372839-Detecting-variables-using-set-and-get
 *
 */
class Avada {

	private $avada_last_version;
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
	private $last_version_avada_path;
	private $last_version_avada_theme_path;
	private $last_version_avada_fusion_builder_path;
	private $last_version_avada_fusion_core_path;
	private $current_avada_fusion_builder_mo_file;
	private $current_avada_fusion_builder_po_file;
	private $current_avada_fusion_core_mo_file;
	private $current_avada_fusion_core_po_file;
	private $backup_avada_fusion_builder_mo_file;
	private $backup_avada_fusion_builder_po_file;
	private $backup_avada_fusion_core_mo_file;
	private $backup_avada_fusion_core_po_file;
	private $avada_child_theme_lang_path;
	private $avada_child_theme_lang_pot_file_path;
	private $avada_new_lang_pot_file_path;


	/**
	 * Main constructor.
	 * This is constructor of Main class and you can use it for hooking your file
	 * inside it like actions or filters
	 *
	 * @access public
	 * @since  1.0.1
	 */
	public function __construct( $main_path, $host_path, $avada_last_version, $avada_new_version, $host_name, $main_theme_path ) {
		$this->avada_last_version                     = $avada_last_version;
		$this->avada_new_version                      = $avada_new_version;
		$this->avada_new_files_temp_path              = $main_path . '01-temp-new-version-files/';
		$this->avada_new_theme_file                   = $this->avada_new_files_temp_path . 'avada-new.zip';
		$this->avada_new_fusion_builder_file          = $this->avada_new_files_temp_path . 'fusion-builder-new.zip';
		$this->avada_new_fusion_core_file             = $this->avada_new_files_temp_path . 'fusion-core-new.zip';
		$this->avada_older_version_path               = $main_path . '02-avada-older-versions/';
		$this->avada_new_version_path                 = $main_path . '03-avada-new-version-files/';
		$this->avada_lang_path                        = $main_path . '04-avada-lang-bak/';
		$this->current_avada_theme_path               = '../' . $host_path . 'wp-content/themes/Avada/';
		$this->current_avada_fusion_builder_path      = '../' . $host_path . 'wp-content/plugins/fusion-builder/';
		$this->current_avada_fusion_core_path         = '../' . $host_path . 'wp-content/plugins/fusion-core/';
		$this->last_version_avada_path                = $this->avada_older_version_path . $this->avada_last_version . '-' . $host_name . '/';
		$this->last_version_avada_theme_path          = $this->last_version_avada_path . 'Avada/';
		$this->last_version_avada_fusion_builder_path = $this->last_version_avada_path . 'fusion-builder/';
		$this->last_version_avada_fusion_core_path    = $this->last_version_avada_path . 'fusion-core/';
		$this->current_avada_fusion_builder_mo_file   = $this->current_avada_fusion_builder_path . 'languages/fusion-builder-fa_IR.mo';
		$this->current_avada_fusion_builder_po_file   = $this->current_avada_fusion_builder_path . 'languages/fusion-builder-fa_IR.po';
		$this->current_avada_fusion_core_mo_file      = $this->current_avada_fusion_core_path . 'languages/fusion-core-fa_IR.mo';
		$this->current_avada_fusion_core_po_file      = $this->current_avada_fusion_core_path . 'languages/fusion-core-fa_IR.po';
		$this->backup_avada_fusion_builder_mo_file    = $this->avada_lang_path . 'fusion-builder-fa_IR.mo';
		$this->backup_avada_fusion_builder_po_file    = $this->avada_lang_path . 'fusion-builder-fa_IR.po';
		$this->backup_avada_fusion_core_mo_file       = $this->avada_lang_path . 'fusion-core-fa_IR.mo';
		$this->backup_avada_fusion_core_po_file       = $this->avada_lang_path . 'fusion-core-fa_IR.po';
		$this->avada_child_theme_lang_path            = $main_theme_path . 'Avada-Child-Theme/languages/';
		$this->avada_child_theme_lang_pot_file_path   = $this->avada_child_theme_lang_path . 'Avada.pot';
		$this->avada_new_lang_pot_file_path           = $this->current_avada_theme_path . 'languages/Avada.pot';

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


