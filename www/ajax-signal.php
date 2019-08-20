<?php
require_once('load.php');
###########################################
if (!check_ajax_key()) {
  die("invalid ajax key");
}
###########################################
$signal_data = get_meta("signal-data", array());
###########################################
$result = array();
$result['viterbi'] = array();
$result['packets'] = array();
$result['drops'] = array();
foreach ($signal_data as $signal_data_time => $signal_data_item) {
  $signal_data_time = $signal_data_time * 1000;
  $viterbi = array('x' => $signal_data_time, 'y' => $signal_data_item['vit']);
  $packets = array('x' => $signal_data_time, 'y' => $signal_data_item['ok']);
  $drops = array('x' => $signal_data_time, 'y' => $signal_data_item['drop']);
  //array_push($result['time'], $line['time']);
  array_push($result['viterbi'], $viterbi);
  array_push($result['packets'], $packets);
  array_push($result['drops'], $drops);
}
###########################################
//print_r($result);
echo json_encode($result)."\n";
?>
