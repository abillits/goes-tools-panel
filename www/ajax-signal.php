<?php
require_once('load.php');
###########################################
if (!check_ajax_key()) {
  die("invalid ajax key");
}
###########################################
$lines = get_goesrecv_log_lines(SIGNAL_STATUS_CHART_MINUTES * 6);
foreach ($lines as $pos => $line) {
  $line_exploded = explode(" [monitor] ", $line);
  $line_exploded_again = explode(",", $line_exploded[1]);
  $processed_line = array();
  //$processed_line['time'] = str_replace("T", " ", str_replace("Z", "", $line_exploded[0]));
  $processed_line['time'] = strtotime($line_exploded[0])*1000;
  //$processed_line['gain'] = preg_replace('/\s+/', '',str_replace("gain:","",$line_exploded_again[0]));
  //$processed_line['freq'] = preg_replace('/\s+/', '',str_replace("freq:","",$line_exploded_again[1]));
  //$processed_line['omega'] = preg_replace('/\s+/', '',str_replace("omega:","",$line_exploded_again[2]));
  $processed_line['vit'] = preg_replace('/\s+/', '',str_replace("vit(avg):","",$line_exploded_again[3]));
  //$processed_line['rs'] = preg_replace('/\s+/', '',str_replace("rs(sum):","",$line_exploded_again[4]));
  $processed_line['packets'] = preg_replace('/\s+/', '',str_replace("packets:","",$line_exploded_again[5]));
  $processed_line['drops'] = preg_replace('/\s+/', '',str_replace("drops:","",$line_exploded_again[6]));
  $lines[$pos] = $processed_line;
}
###########################################
$result = array();
$result['viterbi'] = array();
$result['packets'] = array();
$result['drops'] = array();
foreach ($lines as $line) {
  $viterbi = array('x' => $line['time'], 'y' => $line['vit']);
  $packets = array('x' => $line['time'], 'y' => $line['packets']);
  $drops = array('x' => $line['time'], 'y' => $line['drops']);
  //array_push($result['time'], $line['time']);
  array_push($result['viterbi'], $viterbi);
  array_push($result['packets'], $packets);
  array_push($result['drops'], $drops);
}
###########################################
//print_r($result);
echo json_encode($result)."\n";
?>
