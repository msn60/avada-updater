<?php
/**
 * DatabaseFunctions class
 *
 * This file contains functions which are needed to connect to database
 *
 * @package    Updater\Inc\Database
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Updater\Database;

/**
 * DatabaseFunctions class
 *
 * This file contains functions which are needed to connect to database
 *
 * @package    Updater\Inc\Database
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @since      1.0.1
 */
class DatabaseFunctions {
	/**
	 * Method to create connection to database with mysqli type
	 * @param string $db_server
	 * @param string $db_user
	 * @param string $db_pass
	 * @param string $db_name
	 *
	 * @return \mysqli
	 */
	public static function connect_to_database( $db_server, $db_user, $db_pass, $db_name) {
		$connection = new \mysqli($db_server, $db_user, $db_pass, $db_name);
		self::confirm_db_connect($connection);
		return $connection;
	}

	/**
	 * To confirm that database is connected
	 *
	 * @param \mysqli $connection Database connection
	 */
	public static function confirm_db_connect( \mysqli $connection ) {
		if ( $connection->connect_errno ) {
			$message = "Database connection failed: ";
			$message .= $connection->connect_error;
			$message .= " (" . $connection->connect_errno . ")";
			exit($message);
		}
	}

	/**
	 * Disconnect connection to database
	 *
	 * @param \mysqli $connection Database connection
	 */
	public static function  disconnect_database( \mysqli $connection ) {
		if ( isset( $connection )) {
			$connection->close();
		}
	}

}


