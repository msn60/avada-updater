<?php
/**
 * Utility Class File
 *
 * This file contains Utility class and includes all of useful methods which is
 * needed during script running.
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Updater\Inc\Functions;


/**
 * Class Utility
 *
 * This file contains Utility class and includes all of useful methods which is
 * needed during script running.
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 */
trait Utility {

	public function set_time_zone( $area ) {
		date_default_timezone_set( $area );
	}

	/**
	 * Appends a trailing slash.
	 *
	 * Will remove trailing forward and backslashes if it exists already before adding
	 * a trailing forward slash. This prevents double slashing a string or path.
	 *
	 * The primary use of this is for paths and thus should be used for paths. It is
	 * not restricted to paths and offers no specific path support.
	 *
	 * @since 1.2.0
	 *
	 * @param string $string What to add the trailing slash to.
	 *
	 * @return string String with trailing slash added.
	 */
	public function trailingslashit( $string ) {
		return untrailingslashit( $string ) . '/';
	}

	/**
	 * Removes trailing forward slashes and backslashes if they exist.
	 *
	 * The primary use of this is for paths and thus should be used for paths. It is
	 * not restricted to paths and offers no specific path support.
	 *
	 * @since 2.2.0
	 *
	 * @param string $string What to remove the trailing slashes from.
	 *
	 * @return string String without the trailing slashes.
	 */
	public function untrailingslashit( $string ) {
		return rtrim( $string, '/\\' );
	}

	/*
	 * Change max_execution_time
	 * Change memory_limit
	 * Change max_input_time
	 * */
	public function change_ini_settings() {
		//ini_set( 'max_input_vars', '10000' );
		set_time_limit( - 1 );
		/*var_dump( (int) ini_get( 'max_input_time' ) );
		var_dump( (int) ini_get( 'max_execution_time' ) );
		var_dump( (int) ini_get( 'memory_limit' ) );
		var_dump( (int) ini_get( 'max_input_vars' ) );*/
	}

	/*
	 * get type of webserver
	 * */
	public function check_server_type() {
		$server_type = $_SERVER['SERVER_SOFTWARE'];

		if ( preg_match( "/apache/i", $server_type ) ) {
			return 'apache';
		} elseif ( preg_match( "/litespeed/i", $server_type ) ) {

			return 'litespeed';
		} else {
			return 'nginx';
		}

	}

}


