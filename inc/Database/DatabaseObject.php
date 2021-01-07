<?php
/**
 * DatabaseObject class
 *
 * This file contains all of things which is needed for CRUD operation
 *
 * @package    Updater\Inc\Database
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.2.0
 */

namespace Updater\Database;
/**
 * DatabaseObject class
 *
 * This file contains all of things which is needed for CRUD operation
 *
 * @package    Updater\Inc\Database
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @since      1.2.0
 * @property array $errors
 * @property string $crud_type
 */
class DatabaseObject {
	/**
	 * @var \mysqli $database
	 */
	static protected $database;
	/**
	 * @staticvar string $table_name
	 */
	static protected $table_name = "";
	/**
	 * @var array $columns
	 */
	static protected $db_columns = [];
	/**
	 * @var array $errors
	 */
	public $errors = [];
	/**
	 * @var string $crud_type
	 */
	public $crud_type;

	/**
	 * To set database connection for a class
	 *
	 * @param \mysqli $database
	 */
	public static function set_database( $database ) {
		self::$database = $database;
	}

	/**
	 * Method to query to database and return result in array of object format
	 *
	 * @param string $sql
	 *
	 * @return array $object_array
	 */
	public static function find_by_sql( $sql ) {
		$result = self::$database->query( $sql );
		if ( ! $result ) {
			exit( "Database query failed!" );
		}
		// result into objects
		$object_array = [];
		while ( $record = $result->fetch_assoc() ) {
			$object_array[] = static::instantiate( $record );
		}
		$result->free();

		return $object_array;
	}

	/**
	 * Return all records from a table
	 *
	 * @return array
	 */
	public static function find_all() {
		$sql = "SELECT * FROM " . static::$table_name;

		return static::find_by_sql( $sql );
	}

	/**
	 * Method to find a record by id
	 *
	 * @param $id
	 *
	 * @return bool|mixed
	 */
	public static function find_by_id( $id ) {
		$sql          = "SELECT * FROM " . static::$table_name . " ";
		$sql          .= "WHERE id='" . self::$database->escape_string( $id ) . "'";
		$object_array = static::find_by_sql( $sql );
		if ( ! empty( $object_array ) ) {
			return array_shift( $object_array );
		} else {
			return false;
		}
	}

	/**
	 * Method to instantiate an object by passing an associative record
	 *
	 * @param array $record
	 *
	 * @return object
	 */
	public static function instantiate( $record ) {
		$object = new static;
		// Could manually assign values to properties
		// but automatically assignment is easier and re-usable
		foreach ( $record as $property => $value ) {
			if ( property_exists( $object, $property ) ) {
				$object->$property = $value;
			}
		}

		return $object;
	}

	/**
	 * Properties which have database columns except id
	 *
	 * @return array
	 */
	public function attributes() {
		$attributes = [];
		foreach ( static::$db_columns as $column ) {
			if ( 'id' == $column ) {
				continue;
			}
			$attributes[ $column ] = $this->$column;
		}

		return $attributes;
	}

	/**
	 * Method to sanitize attributes value
	 *
	 * @return array
	 */
	protected function sanitize_attributes() {
		$sanitized = [];
		foreach ( $this->attributes() as $key => $value ) {
			$sanitized[ $key ] = self::$database->escape_string( $value );
		}

		return $sanitized;
	}

	public function merge_attributes( $args = [] ) {
		foreach ( $args as $key => $value ) {
			if ( property_exists( $this, $key ) && ! is_null( $value ) ) {
				$this->$key = $value;
			}
		}
	}

	/**
	 * Method to add custom validation
	 *
	 * @return array
	 */
	protected function validate() {
		$this->errors = [];
		// Add custom validations here
		// You can override it in child class
		return $this->errors;
	}

	/**
	 * Method to create a record in database
	 * @return bool|\mysqli_result
	 */
	protected function create() {
		$this->crud_type = 'create';
		$this->validate();
		if ( ! empty( $this->errors ) ) {
			return false;
		}
		$attributes = $this->sanitize_attributes();

		$sql        = "INSERT INTO " . static::$table_name . " ( ";
		$sql        .= join( ', ', array_keys( $attributes ) );
		$sql        .= " ) VALUES ('";
		$sql        .= join( "', '", array_values( $attributes ) );
		$sql        .= "')";
		$result     = self::$database->query( $sql );
		if ( $result ) {
			$this->id = self::$database->insert_id;
		}

		return $result;
	}

	/**
	 * Method to update a record in database
	 * @return bool|\mysqli_result
	 */
	protected function update() {
		$this->crud_type = 'update';
		$this->validate();
		if ( ! empty( $this->errors ) ) {
			return false;
		}

		$attributes = $this->sanitize_attributes();
		foreach ( $attributes as $key => $value ) {
			$attributes_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ". static::$table_name . " SET ";
		$sql .= join(', ', $attributes_pairs);
		$sql .= " WHERE id='" . self::$database->escape_string($this->id) . "' ";
		$sql .= " LIMIT 1";
		$result = self::$database->query($sql);
		return $result;
	}


	public function save(  ) {
		if(isset($this->id)) {
			return $this->update();
		} else {
			return $this->create();
		}
	}
}


