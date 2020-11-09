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

namespace Updater\Functions;


/**
 * Class Files_Process
 *
 * This file contains Files_Process class which can use to processing on file
 *
 * @package    Updater\Inc\Functions
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 */
class FilesProcess {
	use Utility;

	/**
	 * Add a string in the beginning of a file
	 *
	 * @param $string
	 * @param $filename
	 *
	 * @return bool
	 */
	public function prepend( $string, $filename ) {
		$fileContent = file_get_contents( $filename );
		$result      = file_put_contents( $filename, $string . "\n" . $fileContent );
		if ( $result === false ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Prepend to htaccess file
	 *
	 * @param $string
	 * @param $filename
	 *
	 * @return string
	 */
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

	/**
	 * Several appends to append several messages in a file recursively
	 *
	 * @param      $items
	 * @param      $log_file
	 * @param bool $is_need_separator
	 * @param null $starting_message
	 * @param null $ending_message
	 */
	public function several_appends( $items, $log_file, $is_need_separator = true, $starting_message = null, $ending_message = null ) {
		if ( $starting_message !== null ) {
			echo "<h2>{$starting_message}</h2>";
		}
		foreach ( $items as $item ) {
			$this->append( $item['message'], $log_file );
		}
		if ( $ending_message !== null ) {
			echo "<h2>{$ending_message}</h2>";
		}
		if ( $is_need_separator ) {
			$this->append_section_separator( $log_file );
		}


	}

	/**
	 * Append a message into a file
	 *
	 * @param      $string
	 * @param      $file_name
	 * @param bool $show_on_screen
	 */
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

	/**
	 * Append section separator into a file
	 *
	 * @param $file_name
	 */
	public function append_section_separator( $file_name ) {
		$this->append( PHP_EOL . '****************************' . PHP_EOL, $file_name );
	}

	/**
	 * check directory exists and if not, it will create
	 *
	 * @param $path
	 * @param $type
	 *
	 * @return array
	 */
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

	/**
	 * Check is directory empty or not
	 *
	 * @param $dir_name
	 *
	 * @return array
	 */
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

	/**
	 * Bulk move for files
	 *
	 * @param array $list_items
	 *
	 * @return array
	 */
	public function files_bulk_move( $list_items ) {
		$results = [];
		foreach ( $list_items as $list_item ) {
			$results[] = $this->move_file( $list_item['source_path'], $list_item['destination_file_name'] );
		}

		return $results;
	}

	/**
	 * Move file method
	 *
	 * @param string $old_path
	 * @param string $new_path
	 * @param string $type
	 *
	 * @return array
	 */
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

	/**
	 * Bulk copy for directories
	 *
	 * @param $list_items
	 *
	 * @return array
	 */
	public function directories_bulk_copy( $list_items ) {
		$results = [];
		foreach ( $list_items as $list_item ) {
			$results[] = $this->copy_directory( $list_item['source'], $list_item['destination'] );
		}

		return $results;
	}

	/**
	 * Function to Copy all folders and files in a directory
	 *
	 * @param $source
	 * @param $destination
	 *
	 * @return array
	 */
	public function copy_directory( $source, $destination ) {
		if ( is_dir( $source ) ) {
			@mkdir( $destination );
			$files = scandir( $source );
			foreach ( $files as $file ) {
				if ( $file != "." && $file != ".." ) {
					$this->copy_directory( "$source/$file", "$destination/$file" );
				}
			}
		} else if ( file_exists( $source ) ) {
			$result = copy( $source, $destination );
			if ( ! $result ) {
				return [
					'type'    => false,
					'message' => "We can not copy directory from << {$source} >> to << {$destination} >>  on: " . date( 'Y-m-d  H:i:s' ) . '!!!',
				];
			}
		}

		return [
			'type'    => true,
			'message' => "The copy of directory from << {$source} >> to << {$destination} >> was successful on: " . date( 'Y-m-d  H:i:s' ) . '.',
		];
	}

	/**
	 * Bulk remove for directories
	 *
	 * @param $list_items
	 *
	 * @return array
	 */
	public function directories_bulk_remove( $list_items ) {
		$results = [];
		foreach ( $list_items as $list_item ) {
			$results[] = $this->remove_directory( $list_item );
		}

		return $results;
	}

	/**
	 * Remove directory method
	 *
	 * @param $dir
	 *
	 * @return array
	 */
	public function remove_directory( $dir ) {
		$successful_message   = "Removing of << {$dir} >>  was successful on: " . date( 'Y-m-d  H:i:s' ) . '.';
		$unsuccessful_message = "We can not remove << {$dir} >>   on: " . date( 'Y-m-d  H:i:s' ) . '!!!';
		if ( is_dir( $dir ) ) {
			$files = scandir( $dir );
			foreach ( $files as $file ) {
				if ( $file != "." && $file != ".." ) {
					$this->remove_directory( "$dir/$file" );
				}
			}
			$result = rmdir( $dir );
			if ( ! $result ) {
				return [
					'type'    => false,
					'message' => $unsuccessful_message,
				];

			}
		} else if ( file_exists( $dir ) ) {
			$result = unlink( $dir );
			if ( ! $result ) {
				return [
					'type'    => false,
					'message' => $unsuccessful_message,
				];
			}
		}

		return [
			'type'    => true,
			'message' => $successful_message,
		];
	}

	/**
	 * Remove file method
	 *
	 * @param $source
	 *
	 * @return array
	 */
	public function remove_file( $source ) {
		if ( file_exists( $source ) ) {
			$success_message = "Removing << {$source} >> file was successful on: " . date( 'Y-m-d  H:i:s' ) . '.';
			$failed_message  = "We can not remove << {$source} >> file on: " . date( 'Y-m-d  H:i:s' ) . '!!!';
			$result          = unlink( $source );
			if ( $result ) {
				return [
					'type'    => true,
					'message' => $success_message,
				];
			} else {
				return [
					'type'    => false,
					'message' => $failed_message,
				];
			}
		} else {
			return [
				'type'    => false,
				'message' => "Unfortunately << {$source} >> file is not exist. So we can not remove it on: " . date( 'Y-m-d  H:i:s' ) . '!!!',
			];
		}
	}

	/**
	 * Bulk copy function for copying many files in one process
	 *
	 * @param $list_items
	 *
	 * @return array
	 */
	public function files_bulk_copy( $list_items ) {
		$results = [];
		foreach ( $list_items as $list_item ) {
			$results[] = $this->copy_file( $list_item['source_path'], $list_item['destination_file_name'] );
		}

		return $results;
	}

	/**
	 * Copy file method
	 *
	 * @param $source
	 * @param $destination
	 *
	 * @return array
	 */
	public function copy_file( $source, $destination ) {
		//check source directory is exists
		if ( file_exists( $source ) ) {
			// TODO: Check if destination directory is exists
			$success_message = "The copy from << {$source} >> to << {$destination} >> was successful on: " . date( 'Y-m-d  H:i:s' ) . '.';
			$failed_message  = "We can not copy from << {$source} >> to << {$destination} >> on: " . date( 'Y-m-d  H:i:s' ) . '!!!';
			$result          = copy( $source, $destination );
			if ( $result ) {
				return [
					'type'    => true,
					'message' => $success_message,
				];
			} else {
				return [
					'type'    => false,
					'message' => $failed_message,
				];
			}
		} else {
			return [
				'type'    => false,
				'message' => "Unfortunately << {$source} >> file is not exist. So we can not copy it on: " . date( 'Y-m-d  H:i:s' ) . '!!!',
			];

		}
	}


	/**
	 * Zip data method
	 *
	 * @param        $source
	 * @param        $destination
	 * @param string $os
	 *
	 * @return array
	 */
	public function zip_data( $source, $destination, $os = 'linux' ) {

		$successful_zipping_message   = 'Zipping whole site files backup was successfully done on: ' . date( 'Y-m-d  H:i:s' ) . '.';
		$unsuccessful_zipping_message = 'Unfortunately we can not zip whole of site file! The Date for this message: ' . date( 'Y-m-d  H:i:s' )
		                                . '!!!';
		$unsuccessful_extension_load  = 'Unfortunately we can not load zip extension! The Date for this message: ' . date( 'Y-m-d  H:i:s' )
		                                . '!!!';
		if ( $os == 'windows' ) {
			if ( extension_loaded( 'zip' ) ) {
				if ( file_exists( $source ) ) {
					$zip = new \ZipArchive();
					if ( $zip->open( $destination, \ZIPARCHIVE::CREATE ) ) {
						$source = realpath( $source );
						if ( is_dir( $source ) ) {
							$iterator = new \RecursiveDirectoryIterator( $source );
							// skip dot files while iterating
							$iterator->setFlags( \RecursiveDirectoryIterator::SKIP_DOTS );
							$files = new \RecursiveIteratorIterator( $iterator, \RecursiveIteratorIterator::SELF_FIRST );
							foreach ( $files as $file ) {
								$file = realpath( $file );
								if ( is_dir( $file ) ) {
									$zip->addEmptyDir( str_replace( $source . '', '', $file . '' ) );
								} else if ( is_file( $file ) ) {
									$zip->addFromString( str_replace( $source . '', '', $file ), file_get_contents( $file ) );
								}
							}
						} else if ( is_file( $source ) ) {
							$zip->addFromString( basename( $source ), file_get_contents( $source ) );
						}
					}

					$result = $zip->close();
					if ( $result ) {
						return [
							'result'  => $result,
							'message' => $successful_zipping_message,
						];
					} else {
						return [
							'result'  => $result,
							'message' => $unsuccessful_zipping_message,
						];
					}
				}
			}

			return [
				'result'  => false,
				'message' => $unsuccessful_extension_load,
			];

		} else {
			if ( extension_loaded( 'zip' ) ) {
				if ( file_exists( $source ) ) {

					$templateArchive = new \ZipArchive();
					$templateArchive->open( $destination,
						\ZipArchive::CREATE | \ZipArchive::OVERWRITE );

					$files = new \RecursiveIteratorIterator(
						new \RecursiveDirectoryIterator( $source ),
						\RecursiveIteratorIterator::LEAVES_ONLY
					);

					foreach ( $files as $name => $file ) {

						// Get real and relative path for current file
						$filePath = $file->getRealPath();

						// relative path is full path, reduced with length of templateDir string and 11 more chars for /templates/
						$relativePath = substr( $filePath, strlen( $source ) );

						// Add regular files
						if ( ! $file->isDir() ) {
							// Add current file to archive
							$templateArchive->addFile( $filePath, $relativePath );
						} elseif ( substr( $relativePath, - 2 ) === "/." ) {
							// Remove the dot representing the current directory
							$relativePath = substr( $relativePath, 0, - 1 );
							// Add current directory to archive
							$templateArchive->addEmptyDir( $relativePath );
						} else {
							continue;
						}

						$templateArchive->setExternalAttributesName( $relativePath,
							\ZipArchive::OPSYS_UNIX,
							fileperms( $filePath ) << 16 );
					}

					// Template Zip archive will be created only after closing object
					$result          = $templateArchive->close();
					$files           = null;
					$templateArchive = null;
					unset( $files );
					unset( $templateArchive );
					if ( $result ) {
						return [
							'result'  => $result,
							'message' => $successful_zipping_message,
						];
					} else {
						return [
							'result'  => $result,
							'message' => $unsuccessful_zipping_message,
						];
					}
					//return $zip->close();
				}

			}

			return [
				'result'  => false,
				'message' => $unsuccessful_extension_load,
			];

		}
	}

	/**
	 * Unzip data method
	 *
	 * @param $file
	 * @param $destination_path
	 *
	 * @return array
	 */
	function unzip_data( $file, $destination_path ) {
		$zip = new \ZipArchive;
		$res = $zip->open( $file );
		if ( $res === true ) {
			// extract it to the path we determined above
			$zip->extractTo( $destination_path );
			$zip->close();

			return [
				'result'  => true,
				'message' => "Unzipping from << {$file} >> to << {$destination_path} >> was successful on: " . date( 'Y-m-d  H:i:s' ) . '.',
			];

		} else {
			return [
				'result'  => false,
				'message' => "Unfortunately, we can not unzip from << {$file} >> to << {$destination_path} >> on: " . date( 'Y-m-d  H:i:s' ) . '!!!',
			];
		}

	}

	/**
	 * Move all file helper method
	 *
	 * @param      $dir
	 * @param      $new_dir
	 * @param      $log_file
	 * @param bool $need_separator
	 * @param null $unwanted_files
	 */
	public function help_to_move_all_files( $dir, $new_dir, $log_file, $need_separator = false, $unwanted_files = null ) {
		$results = $this->move_all_files_in_directory( $dir, $new_dir, $unwanted_files );
		foreach ( $results as $result ) {
			$this->append( $result['message'], $log_file );
		}
		if ( $need_separator ) {
			$this->append_section_separator( $log_file );
		}
	}

	/**
	 * Move all files in a directory
	 *
	 * @param       $dir
	 * @param       $new_dir
	 * @param array $unwanted_files
	 *
	 * @return array
	 */
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


	/**
	 * Bulk search and replace function for replacing content in many files in one process
	 *
	 * @param $list_items
	 *
	 * @return array
	 */
	public function files_bulk_search_and_replace( $list_items ) {
		$results = [];
		foreach ( $list_items as $list_item ) {
			$results[] = $this->do_search_and_replace( $list_item['file_name'], $list_item['search_items'] );
		}

		return $results;
	}


	/**
	 * Search and replace method
	 *
	 * @param $file_name
	 * @param $search_and_replace_items
	 */
	public function do_search_and_replace( $file_name, $search_and_replace_items ) {
		$str = file_get_contents( $file_name );
		foreach ( $search_and_replace_items as $search_and_replace_item ) {
			$str = str_replace( $search_and_replace_item['search'], $search_and_replace_item['replace'], $str );
		}
		$result = file_put_contents( $file_name, $str );
		if ( $result === false ) {
			return [
				'type'    => false,
				'message' => "Doing Search and Replace in {$file_name} was not successful at: " . date( 'Y-m-d H:i:s' ) . '!!!',
			];
		} else {
			return [
				'type'    => true,
				'message' => "Doing Search and Replace in {$file_name} was successful at: " . date( 'Y-m-d H:i:s' ) . '.',
			];
		}
	}

	/**
	 * Bulk rename function for renaming many files in one process
	 *
	 * @param $list_items
	 *
	 * @return array
	 */
	public function files_bulk_rename( $list_items ) {
		$results = [];
		foreach ( $list_items as $list_item ) {
			$results[] = $this->rename_file( $list_item['old_name'], $list_item['new_name'] );
		}

		return $results;
	}

	/**
	 * Rename file method
	 *
	 * @param $old_name
	 * @param $new_name
	 *
	 * @return array
	 */
	public function rename_file( $old_name, $new_name ) {
		$result = rename( $old_name, $new_name );
		if ( $result ) {
			return [
				'type'    => true,
				'message' => "Changing name of << {$old_name} >> to << {$new_name} >>  was successful at: " . date( 'Y-m-d H:i:s' ) . '.',
			];
		} else {
			return [
				'type'    => false,
				'message' => "Changing name of << {$old_name} >> to << {$new_name} >>  was not successful at: " . date( 'Y-m-d H:i:s' ) . '!!!',
			];
		}
	}

}
