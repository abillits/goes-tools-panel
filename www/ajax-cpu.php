<?php
require_once('load.php');
###########################################
if (!check_ajax_key()) {
  die("invalid ajax key");
}
###########################################
$cpu_loads = get_server_cpu_loads();
$cpu_free = round($cpu_loads['idle']);
$result = array();
$result[0] = 100 - $cpu_free;
$result[1] = $cpu_free;
###########################################
//print_r($result);
echo json_encode($result)."\n";
?>
