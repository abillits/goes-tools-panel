<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
//date_default_timezone_set('Etc/UTC');
$start = time();
if ( !defined('BASE_DIR') ) {
 define('BASE_DIR', dirname(__FILE__) . '/');
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('VERSION', '0.0.1');
###########################################
require_once(BASE_DIR . 'config.php');
require_once(BASE_DIR . 'functions.php');
###########################################
?>
