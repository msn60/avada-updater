<?php
/**
 * RequestFunctions Class File
 *
 * This file contains methods to handle types of requests
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Updater\Functions;


/**
 * Class RequestFunctions
 *
 * This file contains methods to handle types of requests
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 */
class RequestFunctions {
	/**
	 * Generate 404 status code
	 *
	 * @since  1.2.0
	 */
	public function set_404_error() {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}

	/**
	 * Generate 500 status code
	 *
	 * @since  1.2.0
	 */
	public function set_500_error() {
		header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
		exit();
	}

	/**
	 * To check post request
	 *
	 * @return bool If it is post request it will return true
	 */
	function is_post_request() {
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	/**
	 * To check get request
	 *
	 * @return bool If it is get request it will return true
	 */
	function is_get_request() {
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}


}


