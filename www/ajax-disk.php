<?php
require_once('load.php');
###########################################
if (!check_ajax_key()) {
  die("invalid ajax key");
}
###########################################
$disk_used_percent = round(get_disk_used_percent());
$result = array();
$result[0] = $disk_used_percent;
$result[1] = 100 - $disk_used_percent;
###########################################
//print_r($result); //Debug only
echo json_encode($result)."\n";
?>
