<?php
set_time_limit(0);
require_once('load.php');
###########################################
if (!check_ajax_key()) {
  //die("invalid ajax key");
}
###########################################
/*
$name = 'goes16-fd-ch13_enhanced-77698ebe4f2f41bc2b690821f4df177c.gif';
$frames = maybe_unserialize('a:4:{i:0;a:2:{s:3:"url";s:74:"/data/goes16/fd/ch13_enhanced/GOES16_FD_CH13_enhanced_20190812T133056Z.png";s:4:"time";s:0:"";}i:1;a:2:{s:3:"url";s:74:"/data/goes16/fd/ch13_enhanced/GOES16_FD_CH13_enhanced_20190812T230056Z.png";s:4:"time";s:0:"";}i:2;a:2:{s:3:"url";s:74:"/data/goes16/fd/ch13_enhanced/GOES16_FD_CH13_enhanced_20190813T000056Z.png";s:4:"time";s:0:"";}i:3;a:2:{s:3:"url";s:74:"/data/goes16/fd/ch13_enhanced/GOES16_FD_CH13_enhanced_20190813T010056Z.png";s:4:"time";s:0:"";}}');
*/
$name = $_POST['name'];
$frames = maybe_unserialize($_POST['frames']);

$animations_dir = BASE_DIR . 'data/animations/';
$working_dir = BASE_DIR . 'work/' . md5($start . rand(1, 1000));
$animation_path = $animations_dir . $name;

if (!file_exists($animations_dir)) {
  mkdir($animations_dir, 0755);
}
if (!file_exists($animations_dir)) {
  die("directory /data/animations/ does not exist and could not be created");
}
if (!file_exists($animations_dir)) {
  mkdir($animations_dir, 0755);
}
if (!file_exists($animations_dir)) {
  die("directory /data/animations/ does not exist and could not be created");
}
if (!file_exists(BASE_DIR . 'work')) {
  mkdir(BASE_DIR . 'work', 0755);
}
if (!file_exists(BASE_DIR . 'work')) {
  die("directory /work/ does not exist and could not be created");
}
mkdir($working_dir, 0755);
if (!file_exists($working_dir)) {
  die("could not create working directory");
}
###########################################
//Copy images to work directory
$frame_count = count($frames);
$frames_count_minus = $frame_count - 1;

$i = 0;
while($i <= $frames_count_minus) {
  if ($i == $frames_count_minus) {
    imagery_copy_resize(BASE_DIR . ltrim($frames[$i]['url'],"/"), $working_dir .  '/temp-' . $i . '.png');
    copy($working_dir .  '/temp-' . $i . '.png', $working_dir .  '/temp-' . ($i + 1) . '.png');
    copy($working_dir .  '/temp-' . $i . '.png', $working_dir .  '/temp-' . ($i + 2) . '.png');
  } else {
    imagery_copy_resize(BASE_DIR . ltrim($frames[$i]['url'],"/"), $working_dir .  '/temp-' . $i . '.png');
  }
  $i++;
}
###########################################
if ($frame_count < 5){
  $frame_rate = 1;
} else {
  $frame_rate = 3;
}

$start_number = "0";
$pattern = "temp-%d.png";
//$start_number = "-" . $frames_count_minus;
//$pattern = "temp%d.png";

$cmd = "/usr/bin/ffmpeg -v 0 -threads " . FFMPEG_THREADS . " -framerate " . $frame_rate . "  -start_number " . $start_number . " -i " . $working_dir . "/" . $pattern . " -vf palettegen -y " . $working_dir . "/palette.png";
shell_exec($cmd);

if (file_exists($working_dir . "/palette.png")) {
  chmod($working_dir . "/palette.png", 0755);
} else {
  die("could not create gif pallete");
}

$cmd = "/usr/bin/ffmpeg -v 0 -threads " . FFMPEG_THREADS . " -framerate " . $frame_rate . " -start_number " . $start_number . " -i " . $working_dir . "/" . $pattern . " -i " . $working_dir . "/palette.png -lavfi paletteuse -y " . $animation_path;
shell_exec($cmd);
###########################################
rrmdir($working_dir);
if (file_exists($working_dir)) {
  rrmdir($working_dir);
}
if (file_exists($working_dir)) {
  die("could not remove working directory");
}
if (file_exists($animation_path)) {
  chmod($animation_path, 0755);
} else {
  die("could not create animation");
}
###########################################
echo "success";
?>
