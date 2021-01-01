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
	static protected $columns = [];
	/**
	 * @var array $errors
	 */
	public $errors = [];

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
	 * @return array
	 */
	public static function find_all() {
		$sql = "SELECT * FROM " . static::$table_name;

		return static::find_by_sql( $sql );
	}
}


