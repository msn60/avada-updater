<?php
namespace Updater;
ob_start();
/**
 * Define main site root
 */
define( 'SITE_ROOT_PATH', str_replace( 'template', '', __DIR__ ) );
/**
 * Define main site url
 */
$main_protocol = isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
define( 'SITE_ROOT_URL', $main_protocol . '://' . $_SERVER['SERVER_NAME'] . '/');
/*
 * Include autoloader
 * */
require_once SITE_ROOT_PATH . '/vendor/autoload.php';

?>
