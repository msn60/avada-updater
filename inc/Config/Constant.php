<?php
/**
 * Constant class
 *
 * This file contains Constant class which can set all of constant for script
 *
 * @package    Updater\Inc\Config
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Updater\Config;
/**
 * Class Constant
 *
 * This file contains Constant class which can set all of constant for script
 *
 * @package    Updater\Inc\Config
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @since      1.0.1
 */
class Constant {
	/*
	 * Define all path constants
	 * */
	const TEMPLATE_PATH = SITE_ROOT_PATH . 'template' . DIRECTORY_SEPARATOR;
	const INC_PATH = SITE_ROOT_PATH . 'inc' . DIRECTORY_SEPARATOR;
	/*
	 * Define all url constants
	 * */
	const PUBLIC_ASSETS_URL = SITE_ROOT_URL . 'assets/';
	const PUBLIC_CSS_URL = self::PUBLIC_ASSETS_URL . 'css/';
	const PUBLIC_JS_URL = self::PUBLIC_ASSETS_URL . 'js/';
	const PUBLIC_IMAGES_URL = self::PUBLIC_ASSETS_URL . 'images/';
	const FONTS_URL = self::PUBLIC_ASSETS_URL . 'fonts/';
	const TEMPLATE_URL = SITE_ROOT_URL . 'template/';
	/*
	 * Define Database connections
	 * */
	const DB_SERVER = 'localhost';
	const DB_USER = 'mehdi';
	const DB_PASS = 'mznx9182';
	const DB_NAME = 'helper_db';
}


