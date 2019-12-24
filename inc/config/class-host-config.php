<?php
/**
 * Host_config class
 *
 * This file contains Host_config class which can set host_name, host_path and is_check_updraft
 *
 * @package    Updater\Inc\Config
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://wpwebmaster.ir
 * @since      1.0.1
 */

namespace Updater\Inc\Config;


/**
 * Class Host_config
 *
 * This file contains Host_config class which can set host_name, host_path and is_check_updraft
 *
 * @package    Updater\Inc\Config
 * @author     Mehdi Soltani <soltani.n.mehdi@gmail.com>
 */
trait Host_config {

	function set_host_config( $domain_name ) {
		switch ( $domain_name ) {
			case 'anyl':
				$host_name        = 'anyl';
				$host_path        = 'anyl.wpwebmaster.ir/';
				$is_check_updraft = true;
				break;
			case 'aitanrehab':
				$host_name        = 'aitan';
				$host_path        = 'aitanrehab/';
				$is_check_updraft = false;
				break;
			case 'hekmat':
				$host_name        = 'hekmat';
				$host_path        = 'hco.wpwebmaster.ir/';
				$is_check_updraft = false;
				break;
			case 'novinbazsazi':
				$host_name        = 'novinbazsazi';
				$host_path        = 'novinbazsazi.com/';
				$is_check_updraft = true;
				break;
			case 'test-academy':
				$host_name        = 'test-academy';
				$host_path        = 'academy.wpwebmaster.ir/';
				$is_check_updraft = false;
				break;
			case 'stargaz':
				$host_name        = 'stargaz';
				$host_path        = 'stargazetrading.com/';
				$is_check_updraft = true;
				break;
			case 'jesmoravan':
				$host_name        = 'jesmoravan';
				$host_path        = 'jesmoravan.com/';
				$is_check_updraft = true;
				break;
			case 'wpwebmaster':
				$host_name        = 'wpwebmaster';
				$host_path        = 'public_html/';
				$is_check_updraft = true;
				break;
			case 'firstsite.com':
				$host_name        = 'firstsite';
				$host_path        = 'firstsite.com/';
				$is_check_updraft = true;
				break;
			case 'secondsite.com':
				$host_name        = 'secondsite';
				$host_path        = 'secondsite.com/';
				$is_check_updraft = true;
				break;
			case 'webmaster':
				$host_name        = 'webmaster';
				$host_path        = 'webmaster/';
				$is_check_updraft = false;
				break;
			case 'spec':
				$host_name        = 'spec';
				$host_path        = 'spec/';
				$is_check_updraft = true;
				break;
			default:
				$host_name        = 'spec';
				$host_path        = 'spec/';
				$is_check_updraft = true;

		}

		return [
			'host_name'        => $host_name,
			'host_path'        => $host_path,
			'is_check_updraft' => $is_check_updraft,
		];
	}


}


