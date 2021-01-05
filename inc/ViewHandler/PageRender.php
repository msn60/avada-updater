<?php
/**
 * PageRender Interface File
 *
 * This file contains interface which you must implement whenever you want
 * to load a page.
 *
 * @package    UpdUpdater\ViewHandler
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.2.0
 */

namespace Updater\ViewHandler;

use Updater\Config\Constant;
/**
 * Interface PageRender
 *
 * @package    Updater\ViewHandler
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 */
class PageRender {
	/**
	 * Method load_template in Template_Builder Class
	 *
	 * This method calls to render Admin or Front HTML templates from templates/admin
	 * or templates/front directories. You can use from dot (.) to separate nested
	 * directories and this method will include your desire file for your plugin.
	 *
	 * @access  public
	 * @static
	 *
	 * @param string $template Path of template file which  is separated by dot.
	 * @param array  $params   Related parameters that must be extracted to use inside your template.
	 * @param string $type     To detect admin or front directory to use related constant path.
	 */
	public static function load_template( $template, $params = array(), $type = '' ) {
		$template       = str_replace( '.', '/', $template );
		$base_path      = '' === $type ? Constant::TEMPLATE_PATH : Constant::TEMPLATE_PATH . 'admin/';
		$view_file_path = $base_path . $template . '.php';
		if ( file_exists( $view_file_path ) && is_readable( $view_file_path ) ) {
			! empty( $params ) ? extract( $params ) : null;
			/**
			 * Include template file path which will be rendered by your plugin.
			 */
			include $view_file_path;
		} else {
			echo '<h1>Your file does not exist. </h1>';
			echo '<h3>Check this file: ' . $view_file_path . '</h3>';
			exit;
		}
	}

}
