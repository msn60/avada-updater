<?php
/**
 * PageHandler Interface File
 *
 * This file contains interface which you must implement whenever you want
 * to load a page.
 *
 * @package    UpdUpdater\ViewHandler\Contract
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.2.0
 */

namespace Updater\ViewHandler\Contract;

/**
 * Interface PageHandler
 *
 * @package    Updater\ViewHandler\Contract
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 */
interface PageHandler {

	/**
	 * Render method to render a page with router
	 *
	 * This method must be implement by children who implement this interface.
	 *
	 * @since   1.2.0
	 * @access  public
	 */
	public function render();
}
