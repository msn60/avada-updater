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

	public static function connect_to_database( $db_server, $db_user, $db_pass, $db_name) {
		$connection = new \mysqli($db_server, $db_user, $db_pass, $db_name);
		self::confirm_db_connect($connection);
		return $connection;
	}

	public static function confirm_db_connect( \mysqli $connection ) {
		if ( $connection->connect_errno ) {
			$message = "Database connection failed: ";
			$message .= $connection->connect_error;
			$message .= " (" . $connection->connect_errno . ")";
			exit($message);
		}
	}

	public static function  disconnect_database( \mysqli $connection ) {
		if ( isset( $connection )) {
			$connection->close();
		}
	}

}


