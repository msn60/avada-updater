<?php
/**
 * Host class
 *
 * This file contains Host class which can set host_name, host_path and is_check_updraft
 *
 * @package    Updater\Inc\Config
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.2.0
 */

namespace Updater\Config;

use Updater\Database\DatabaseObject;
use Updater\Functions\Validation;

/**
 * Class Host
 *
 * This file contains Host class which can set host_name, host_path and is_check_updraft
 *
 * @package    Updater\Inc\Config
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @property int    $id
 * @property string $host_name
 * @property string $host_path
 * @property bool   $is_check_updraft
 */
class Host extends DatabaseObject {

	use Validation;

	static protected $table_name = 'host_config';
	static protected $db_columns = [ 'id', 'host_name', 'host_path', 'is_check_updraft' ];

	public $id;
	public $host_name;
	public $host_path;
	public $is_check_updraft;


	/**
	 * Host constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = [] ) {
		if ( count($args) > 0 ) {
			$this->host_name        = $this->sanitize_with_trim($args['host_name']) ?? '';
			$this->host_path        = $this->sanitize_with_trim($args['host_path']) ?? '';
			$this->is_check_updraft = isset($args['is_check_updraft']) ? 1 : 0;
		}

		/*
		 //Caution: allows private/protected properties to be set
		 foreach($args as $k => $v) {
		   if(property_exists($this, $k)) {
		     $this->$k = $v;
		   }
		 }
		*/
	}

	/**
	 * Method to validate values
	 *
	 * @return array
	 */
	protected function validate() {
		$this->errors = [];
		if ( $this->is_blank( $this->host_name ) ) {
			$this->errors[] = "نام هاست نباید خالی باشد";
		}

		if ( $this->is_blank( $this->host_path ) ) {
			$this->errors[] = "مسیر هاست نباید خالی باشد";
		}

		return $this->errors;
	}

	/**
	 * @param array $args
	 */
	public function merge_attributes( $args = [] ) {
		foreach ( $args as $key => $value ) {
			if ( property_exists( $this, $key ) && ! is_null( $value ) ) {
				if ( $value == 'on' ) {
					$this->$key = true;
				}  else {
					$this->$key = $value;
				}
			}
		}
	}

	public function show_errors( $errors ) {
		$output = '';
		if ( ! empty( $errors ) ) {
			$output .= "<div class=\"errors\">";
			$output .= "Please fix the following errors:";
			$output .= "<ul>";
			foreach ( $errors as $error ) {
				$output .= "<li>" . htmlspecialchars( $error ) . "</li>";
			}
			$output .= "</ul>";
			$output .= "</div>";
		}

		return $output;
	}

}


