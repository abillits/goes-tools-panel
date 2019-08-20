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
define('VERSION', '1.0.0');
###########################################
/*
source-dir
output-dir
crop-x
crop-y
crop-w
crop-h
output-w
output-h
*/
$custom_products = array();
function custom_product($src_dir,$dst_dir,$crop_x,$crop_y,$crop_w,$crop_h,$dst_w,$dst_h) {
  global $custom_products;

  $src_dir = str_replace("/data/","",$src_dir);
  $src_dir = str_replace("data/","",$src_dir);
  $src_dir = ltrim($src_dir,"/");
  $src_dir = rtrim($src_dir,"/");
  $src_dir = $src_dir . "/";
  $dst_dir = str_replace("/data/","",$dst_dir);
  $dst_dir = str_replace("data/","",$dst_dir);
  $dst_dir = ltrim($dst_dir,"/");
  $dst_dir = rtrim($dst_dir,"/");
  $dst_dir = $dst_dir . "/";

  $new_custom_product = array();
  $new_custom_product['src-dir'] = BASE_DIR . "data/" . $src_dir;
  $new_custom_product['dst-dir'] = BASE_DIR . "data/custom/" . $dst_dir;
  $new_custom_product['crop-x'] = $crop_x;
  $new_custom_product['crop-y'] = $crop_y;
  $new_custom_product['crop-w'] = $crop_w;
  $new_custom_product['crop-h'] = $crop_h;
  $new_custom_product['dst-w'] = $dst_w;
  $new_custom_product['dst-h'] = $dst_h;

  $custom_products[] = $new_custom_product;
}
###########################################
require_once(BASE_DIR . 'config.php');
require_once(BASE_DIR . 'functions.php');
###########################################
?>
