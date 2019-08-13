<?php
require_once('load.php');
###########################################
if (!check_ajax_key()) {
  die("invalid ajax key");
}
###########################################
$memory_usage = round(get_server_memory_usage(true));
$result = array();
$result[0] = $memory_usage;
$result[1] = 100 - $memory_usage;
###########################################
//print_r($result); //Debug only
echo json_encode($result)."\n";
?>
