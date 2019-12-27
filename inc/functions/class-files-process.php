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

	public function append_section_separator( $file_name ) {
		$this->append( PHP_EOL . '****************************' . PHP_EOL, $file_name );
	}

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

	/*
	 * check directory exists and if not, it will create
	 * */
	public function make_directory_if_not_exist( $path, $type ) {
		if ( ! file_exists( $path ) ) {
			$result = mkdir( $path, 0755 );
			if ( $result === true ) {
				return [
					'message' => "The directory for {$type} was created succesfully at: " . date( 'Y-m-d H:i:s' ) . '.',
					'type'    => 'successful',
				];
			} else {
				return [
					'message' => "The directory for {$type} was not succesfully at: " . date( 'Y-m-d H:i:s' ) . '!!!',
					'type'    => 'un-successful',
				];

			}
		} else {
			return [
				'message' => "The directory {$type} was already existed.",
				'type'    => 'already-exist',
			];
		}

	}


	/*
	 * Check is directory empty or not
	 * */
	public function is_dir_empty( $dir_name ) {
		if ( ! is_dir( $dir_name ) ) {
			return [
				'type' => 'is-file',
			];
		}
		foreach ( scandir( $dir_name ) as $file ) {
			if ( ! in_array( $file, array( '.', '..', '.svn', '.git' ) ) ) {
				return [
					'type' => 'not-empty-dir',
				];
			}
		}

		return [
			'type' => 'is-empty-dir',
		];
	}

	public function move_all_files_in_directory( $dir, $new_dir, $unwanted_files = [] ) {
		// Open a known directory, and proceed to read its contents
		if ( is_dir( $dir ) ) {
			if ( $dh = opendir( $dir ) ) {
				$results[] = null;
				while ( ( $file = readdir( $dh ) ) !== false ) {
					//exclude unwanted
					if ( $file == "." ) {
						continue;
					}
					if ( $file == ".." ) {
						continue;
					}
					if ( ! empty( $unwanted_files ) ) {
						foreach ( $unwanted_files as $unwanted_file ) {
							if ( $file == $unwanted_file ) {
								continue 2;
							}
						}
					}

					//if ($file=="index.php") continue; for example if you have index.php in the folder
					if ( rename( $dir . '/' . $file, $new_dir . '/' . $file ) ) {
						$message   = "{$file} is copied in {$new_dir} successfully at: " . date( 'Y-m-d H:i:s' ) . '.';
						$results[] = [
							'type'    => 'successful',
							'message' => $message,
						];

						//if files you are moving are images you can print it from
						//new folder to be sure they are there
					} else {
						$message   = "{$file} was successfully copied in {$new_dir}  at: " . date( 'Y-m-d H:i:s' ) . '.';
						$results[] = [
							'type'    => 'un-successful',
							'message' => $message,
						];
					}
				}
				closedir( $dh );

				return $results;
			}
		}

		return [
			[
				'type'    => 'un-successful',
				'message' => "<< {$dir}  >> is not a valid dir!!!"
			]
		];
	}

	/*
	* Move file to another directory
	* */
	public function move_file( $old_path, $new_path, $type = 'normal' ) {
		$moving_message = [];
		if ( $type == 'zipped-site-backup' ) {
			$moving_message = [
				'successful'   => 'Zipped whole site backeup file is successfully move to backup directory on : ',
				'unsuccessful' => 'Unfortunately we can not move zipped whole site backup file to backup directory!!! The Date for this message is : ',
			];
		} else {
			$moving_message = [
				'successful'   => "File: << {$old_path} >> is successfully move to << {$new_path} >>  on : ",
				'unsuccessful' => "Unfortunately we can not move << {$old_path} >> to << {$new_path} >> !!! The Date for this message is : ",
			];
		}

		$temp = rename( $old_path, $new_path );
		if ( $temp ) {
			return [
				'type'    => 'successful',
				'message' => $moving_message['successful'] . date( 'Y-m-d H:i:s' ) . '.',
			];
		} else {
			return [
				'type'    => 'un-successful',
				'message' => $moving_message['unsuccessful'] . date( 'Y-m-d H:i:s' ) . '.',
			];
		}

	}

}
