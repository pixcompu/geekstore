<?php
define('BASE_SERVER_PATH', $_SERVER['DOCUMENT_ROOT'] . '/geekstore/server/');
define('BASE_SERVER_CLASS_PÁTH', BASE_SERVER_PATH . 'class/');
define('BASE_SERVER_LIBRARY_PATH', BASE_SERVER_PATH . 'lib/');
require_once(BASE_SERVER_CLASS_PÁTH . 'Executor.php');
require_once(BASE_SERVER_CLASS_PÁTH . 'FileUploader.php');
require_once(BASE_SERVER_CLASS_PÁTH . 'SystemException.php');
require_once(BASE_SERVER_CLASS_PÁTH . 'Session.php');
require_once(BASE_SERVER_CLASS_PÁTH . 'Model.php');
require_once(BASE_SERVER_LIBRARY_PATH . 'helpers.php');