<?php
/**
 * Files_Process Class File
 *
 * This file contains Files_Process class which can use to processing on file
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.0
 */

namespace Updater\Inc\Functions;


/**
 * Class Files_Process
 *
 * This file contains Files_Process class which can use to processing on file
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 */
class Files_Process {

	protected $first;

	public function __construct() {

	}

	/*
	 * Add a string in the beginning of a file
	 * */
	public function prepend( $string, $filename ) {
		$fileContent = file_get_contents( $filename );
		$result      = file_put_contents( $filename, $string . "\n" . $fileContent );
		if ( $result === false ) {
			return false;
		} else {
			return true;
		}
	}

	public function check_prepend_htaccess_for_litespeed( $string, $filename ) {

		$fileContent = @file_get_contents( $filename );
		if ( preg_match( "/E=noabort:1/", $fileContent )
		     && preg_match( "/E=noconntimeout:1/", $fileContent )
		) {

			return 'htaccess file was overwritten already. You do not to need extra actions on it. Date of checking: '
			       . date( 'Y-m-d  H:i:s' ) . '!!!';
		}
		$result = @file_put_contents( $filename, $string . "\n" . $fileContent );
		if ( $result === false ) {
			return 'Error when Writing on htaccess file!!! It was at: ' . date( 'Y-m-d  H:i:s' ) . '!!!';
		} else {
			return 'Writing on htaccess file was successful on: ' . date( 'Y-m-d  H:i:s' ) . '.';
		}

	}

	/*
	 * Write on log file
	 * */
	public function append( $string, $file_name, $show_on_screen = true ) {

		$string = $string . PHP_EOL;
		if ( file_exists( $file_name ) ) {
			$file_content = file_get_contents( $file_name );
			file_put_contents( $file_name, $string, FILE_APPEND | LOCK_EX );

		} else {
			file_put_contents( $file_name, $string );
		}
		if ( $show_on_screen ) {
			$string = str_replace( '*', '', $string );
			echo "<p style='font-size: 20px;font-weight: bold;'>$string</p>";
			echo '<hr>';
		}
	}

	public function append_section_separator($file_name) {
		$this->append(PHP_EOL . '****************************' . PHP_EOL,$file_name);
	}

}
