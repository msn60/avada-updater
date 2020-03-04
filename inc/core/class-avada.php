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

use Updater\Inc\Functions\Files_Process;
use Updater\Inc\Functions\Path;

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

	/**
	 * backup from mo & po language files from fusion core and fusion builder
	 */
	public function backup_language_files(
		Files_Process $files_process_obj,
		$main_log_file
	) {
		/*
		 * Copy Farsi language files
		 * */
		$lang_list_items = [
			[
				'source_path'           => $this->current_avada_fusion_builder_mo_file,
				'destination_file_name' => $this->backup_avada_fusion_builder_mo_file,
			],
			[
				'source_path'           => $this->current_avada_fusion_builder_po_file,
				'destination_file_name' => $this->backup_avada_fusion_builder_po_file,
			],
			[
				'source_path'           => $this->current_avada_fusion_core_mo_file,
				'destination_file_name' => $this->backup_avada_fusion_core_mo_file,
			],
			[
				'source_path'           => $this->current_avada_fusion_core_po_file,
				'destination_file_name' => $this->backup_avada_fusion_core_po_file,
			],

		];

		$results = $files_process_obj->files_bulk_copy( $lang_list_items );
		$files_process_obj->several_appends( $results, $main_log_file, true, 'Start to backup lang files',
			'End of backup lang files' );

	}

	/**
	 * Archive current version of Avada theme, fusion builder and core
	 *
	 * @param Files_Process $files_process_obj
	 * @param string        $main_log_file
	 */
	public function archive_avada_last_version_files(
		Files_Process $files_process_obj,
		$main_log_file
	) {
		// TODO: Check that copy_list_items exist
		$copy_list_items = [
			[
				'source'      => $this->current_avada_theme_path,
				'destination' => $this->last_version_avada_theme_path,
			],
			[
				'source'      => $this->current_avada_fusion_builder_path,
				'destination' => $this->last_version_avada_fusion_builder_path,
			],
			[
				'source'      => $this->current_avada_fusion_core_path,
				'destination' => $this->last_version_avada_fusion_core_path,
			],
		];
		$archive_results = $files_process_obj->directories_bulk_copy( $copy_list_items );
		$files_process_obj->several_appends( $archive_results, $main_log_file, false,
			'Start to Archiving last version of Avada files' );

		$removing_list_items = [];
		foreach ( $copy_list_items as $copy_list_item ) {
			$removing_list_items[] = $copy_list_item['source'];
		}
		$removing_results = $files_process_obj->directories_bulk_remove( $removing_list_items );
		$files_process_obj->several_appends( $removing_results, $main_log_file, true, null,
			'End of Archiving last version of Avada files' );
	}

	/**
	 * Unzipped Avada theme & fusion core & fusion builder
	 *
	 * @param Files_Process $files_process_obj
	 * @param Path          $path_obj
	 * @param string        $main_log_file
	 */
	public function unzip_avada_last_version_files(
		Files_Process $files_process_obj,
		Path $path_obj,
		$main_log_file
	) {
		$msn_new_theme_items = [
			[
				'source_file'      => $this->avada_new_theme_file,
				'destination_path' => $path_obj->main_theme_path,
				'check_directory'  => $this->current_avada_theme_path,
			],
			[
				'source_file'      => $this->avada_new_fusion_builder_file,
				'destination_path' => $path_obj->main_plugin_path,
				'check_directory'  => $this->current_avada_fusion_builder_path,
			],
			[
				'source_file'      => $this->avada_new_fusion_core_file,
				'destination_path' => $path_obj->main_plugin_path,
				'check_directory'  => $this->current_avada_fusion_core_path,
			],
		];

		foreach ( $msn_new_theme_items as $msn_new_theme_item ) {
			if ( ! file_exists( $msn_new_theme_item['check_directory'] ) ) {
				$msn_unzipping_result = $files_process_obj->unzip_data( $msn_new_theme_item['source_file'],
					$msn_new_theme_item['destination_path'] );
				$files_process_obj->append( $msn_unzipping_result['message'], $main_log_file );
			} else {
				$msn_unzipping_unsuccessful_message
					= "We did not extract << {$msn_new_theme_item['source_file']} >> due to existing << {$msn_new_theme_item['destination_path']} >> directory!!!";
				$files_process_obj->append( $msn_unzipping_unsuccessful_message, $main_log_file );
			}

		}
		$files_process_obj->append_section_separator( $main_log_file );
	}

	/**
	 * Move lang file to related original directories
	 *
	 * @param Files_Process $files_process_obj
	 * @param string        $main_log_file
	 */
	public function move_lang_files(
		Files_Process $files_process_obj,
		$main_log_file
	) {
		$lang_list_items = [
			[
				'destination_file_name' => $this->current_avada_fusion_builder_mo_file,
				'source_path'           => $this->backup_avada_fusion_builder_mo_file,
			],
			[
				'destination_file_name' => $this->current_avada_fusion_builder_po_file,
				'source_path'           => $this->backup_avada_fusion_builder_po_file,
			],
			[
				'destination_file_name' => $this->current_avada_fusion_core_mo_file,
				'source_path'           => $this->backup_avada_fusion_core_mo_file,
			],
			[
				'destination_file_name' => $this->current_avada_fusion_core_po_file,
				'source_path'           => $this->backup_avada_fusion_core_po_file,
			],

		];

		// TODO : Check if translation files are exists or not, then move files

		$results = $files_process_obj->files_bulk_move( $lang_list_items );
		$files_process_obj->several_appends( $results, $main_log_file, true, 'Start to backup lang files',
			'End of backup lang files' );

	}

	/**
	 * copy new avada.pot file in child theme
	 *
	 * @param Files_Process $files_process_obj
	 * @param string        $main_log_file
	 */
	public function copy_new_avada_pot(
		Files_Process $files_process_obj,
		$main_log_file
	) {
		$remove_pot_file_result = $files_process_obj->remove_file( $this->avada_child_theme_lang_pot_file_path );
		$files_process_obj->append( $remove_pot_file_result ['message'], $main_log_file );
		$copy_original_pot_file_result = $files_process_obj->copy_file( $this->avada_new_lang_pot_file_path,
			$this->avada_child_theme_lang_pot_file_path );
		$files_process_obj->append( $copy_original_pot_file_result ['message'], $main_log_file );
		$files_process_obj->append_section_separator( $main_log_file );
	}


}


