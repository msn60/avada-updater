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
	const UPDATER_TEMPLATE_PATH = SITE_ROOT_PATH  . 'template' . DIRECTORY_SEPARATOR;
	const UPDATER_INC_PATH = SITE_ROOT_PATH  . 'inc' . DIRECTORY_SEPARATOR;

	/*
	 * Define all url constants
	 * */
	const UPDATER_PUBLIC_ASSETS_URL = SITE_ROOT_URL  . 'assets/';
	const UPDATER_PUBLIC_CSS_URL = self::UPDATER_PUBLIC_ASSETS_URL  . 'css/';
	const UPDATER_PUBLIC_JS_URL = self::UPDATER_PUBLIC_ASSETS_URL  . 'js/';
	const UPDATER_PUBLIC_IMAGES_URL = self::UPDATER_PUBLIC_ASSETS_URL  . 'images/';
	const UPDATER_FONTS_IMAGES_URL = self::UPDATER_PUBLIC_ASSETS_URL  . 'fonts/';

}


