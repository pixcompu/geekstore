<?php
/**
 * Path Information
 */
define('PROJECT_FOLDER_NAME', 'store');
define('BASE_SERVER_PATH', $_SERVER['DOCUMENT_ROOT'] . '/'. PROJECT_FOLDER_NAME . '/server/');
define('BASE_SERVER_CLASS_PÁTH', BASE_SERVER_PATH . 'class/');
define('BASE_SERVER_LIBRARY_PATH', BASE_SERVER_PATH . 'lib/');

/**
 * Session Information
 */
define('TYPE_ADMIN', "admin");
define('TYPE_USER', "user");

/**
 * Database Information
 */
define('DIRECCION', 'localhost');
define('USER', 'root');
define('PASSWORD', '');
define('DATABASE', 'geekstore');