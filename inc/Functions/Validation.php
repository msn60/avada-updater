<?php
/**
 * Validation Class File
 *
 * This file contains Validation class to validate values
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.2.0
 */

namespace Updater\Functions;


/**
 * Class Validation
 *
 * This file contains Validation class to validate values
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 */
trait Validation {
	/**
	 * validate data presence
	 * uses trim() so empty spaces don't count
	 * uses === to avoid false positives
	 * better than empty() which considers "0" to be empty
	 *
	 * @param $value
	 *
	 * @return bool
	 */
	public function is_blank( $data ) {
		return !isset( $data ) || trim($data) === '';
	}

	public function sanitize_with_trim( $data ) {
		$data = trim( $data);
		$data = stripslashes($data);
		$data = htmlspecialchars( $data ) ;
		return $data;
	}

}


