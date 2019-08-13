<?php
//===================================================================//
function imagery_copy_resize($original_file, $target_file) {
  list($width, $height) = getimagesize($original_file);
  $new_width = $width;
  $new_height = $height;
  if (ANIMATION_MAX_HEIGHT) {
    if ($height > ANIMATION_MAX_HEIGHT) {
      $percent = (100 / $height) * ANIMATION_MAX_HEIGHT;
      $new_height = ANIMATION_MAX_HEIGHT;
      $new_width = ($width / 100) * $percent;
    }
  }
  if (ANIMATION_MAX_WIDTH) {
    if ($width > ANIMATION_MAX_WIDTH) {
      $percent = (100 / $width) * ANIMATION_MAX_WIDTH;
      $new_width = ANIMATION_MAX_WIDTH;
      $new_height = ($height / 100) * $percent;
    }
  }
  if ($width != $new_width || $height != $new_height) {
    $img = imagecreatefrompng($original_file);
    $new_image = imagecreatetruecolor($new_width, $new_height);
    imagealphablending($new_image, false);
    imagesavealpha($new_image,true);
    $transparency = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
    imagefilledrectangle($new_image, 0, 0, $new_height, $new_height, $transparency);
    imagecopyresampled($new_image, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    imagepng($new_image,$target_file);
  } else {
    copy($original_file, $target_file);
  }
}

function get_timestamp_from_imagery_file($file) {
  $file_exploded = explode("_", $file);
  return strtotime(str_replace(".png","",$file_exploded[count($file_exploded) - 1]));
}

function save_base64_image_to_file($base64_image, $path) {
  $base64_image = trim($base64_image);
  $base64_image = str_replace('data:image/png;base64,', '', $base64_image);
  $base64_image = str_replace('data:image/jpg;base64,', '', $base64_image);
  $base64_image = str_replace('data:image/jpeg;base64,', '', $base64_image);
  $base64_image = str_replace('data:image/gif;base64,', '', $base64_image);
  $base64_image = str_replace(' ', '+', $base64_image);
  $image_data = base64_decode($base64_image);
  file_put_contents($path, $image_data);
}

function check_ajax_key($key = null){
  if (!isset($key)) {
    foreach (apache_request_headers() as $name => $value) {
        if (strtolower($name) == "ajaxkey") {
          $key = $value;
        }
    }
    if (!isset($key)) {
      return false;
    }
  }
  if (md5(date("YmdH") . AJAX_KEY_SALT) == $key) {
    return true;
  } else if (md5(date("YmdH", time() - 360) . AJAX_KEY_SALT) == $key) {
    //an hour may have rolled over since the request was sent
    return true;
  } else {
    return false;
  }
}

function get_ajax_key() {
  $key = md5(date("YmdH") . AJAX_KEY_SALT);
  return $key;
}

function get_goesrecv_log_lines($lines_to_get) {
  $lines=array();

  $fp = fopen("/var/log/goestools/goesrecv.log", "r");
  while(!feof($fp)) {
    $line = fgets($fp, 4096);
    if (strpos($line, 'Skipping') !== false) {
      continue;
    }
    $line = preg_replace( "/\r|\n/", "",$line);
    if (empty($line)) {
      continue;
    }
    array_push($lines, $line);
    if (count($lines)>$lines_to_get) {
      array_shift($lines);
    }
  }
  fclose($fp);
  return $lines;
}

function get_goesproc_log_lines($lines_to_get) {
  $lines=array();
  $fp = fopen("/var/log/goestools/goesproc.log", "r");
  while(!feof($fp)) {
    $line = fgets($fp, 4096);
    if (strpos($line, 'Skipping') !== false) {
      continue;
    }
    $line = preg_replace( "/\r|\n/", "",$line);
    if (empty($line)) {
      continue;
    }
    array_push($lines, $line);
    if (count($lines)>$lines_to_get) {
      array_shift($lines);
    }
  }
  fclose($fp);
  foreach ($lines as $pos => $line) {
    $lines[$pos] = explode(" ", str_replace("Writing: ./", "", $line))[0];
  }
  return $lines;
}

function get_file_type_from_goesproc_log_line($line) {
  if (strpos($line, 'goes16') !== false) {
    return "GOES 16";
  } else if (strpos(strtolower($line), 'goes17') !== false) {
      return "GOES 17";
  } else if (strpos(strtolower($line), 'nws') !== false) {
      return "NWS";
  } else if (strpos(strtolower($line), 'text') !== false) {
      return "TEXT";
  } else {
    return "?";
  }
}

function get_file_name_from_goesproc_log_line($line) {
  $line_exploded = explode("/", $line);
  return $line_exploded[count($line_exploded) - 1];
}

function get_disk_used_percent() {
  $disk_total = disk_total_space(BASE_DIR);
  $disk_free = disk_free_space(BASE_DIR);
  $disk_used = $disk_total - $disk_free;
  $disk_used_percent = (100 / $disk_total) * $disk_used;
  return $disk_used_percent;
}

function log_error($raw_msg) {
  if (strpos(strtolower($raw_msg), 'notice') !== false) {
    //notice
    $max = 50;
    $notice_log = get_server_meta("notice-log", array());
    $new_notice_log = array();
    krsort($notice_log);
    if (count($notice_log) >= $max) {
      $i = 0;
      foreach ($notice_log as $time => $notice) {
        $i = $i + 1;
        if ($i == $max) {
          break;
        } else {
          $new_notice_log[$time] = $notice;
        }
      }
    } else {
      $new_notice_log = $notice_log;
    }
    $new_notice_log[time()] = str_replace("Notice: ", "",$raw_msg);
    ksort($new_notice_log);
    update_server_meta("notice-log-count", count($new_notice_log));
    update_server_meta("notice-log", $new_notice_log);
  } else if (strpos(strtolower($raw_msg), 'warning') !== false) {
    //warning
    $max = 50;
    $warning_log = get_server_meta("warning-log", array());
    $new_warning_log = array();
    krsort($warning_log);
    if (count($warning_log) >= $max) {
      $i = 0;
      foreach ($warning_log as $time => $warning) {
        $i = $i + 1;
        if ($i == $max) {
          break;
        } else {
          $new_warning_log[$time] = $warning;
        }
      }
    } else {
      $new_warning_log = $warning_log;
    }
    $new_warning_log[time()] = str_replace("Warning: ", "",$raw_msg);
    ksort($new_warning_log);
    update_server_meta("warning-log-count", count($new_warning_log));
    update_server_meta("warning-log", $new_warning_log);
  } else {
    //error
    $max = 50;
    $error_log = get_server_meta("error-log", array());
    $new_error_log = array();
    krsort($error_log);
    if (count($error_log) >= $max) {
      $i = 0;
      foreach ($error_log as $time => $error) {
        $i = $i + 1;
        if ($i == $max) {
          break;
        } else {
          $new_error_log[$time] = $error;
        }
      }
    } else {
      $new_error_log = $error_log;
    }
    $new_error_log[time()] = str_replace("Error: ", "",$raw_msg);
    ksort($new_error_log);
    update_server_meta("error-log-count", count($new_error_log));
    update_server_meta("error-log", $new_error_log);
  }
}

function log_continue($raw_msg) {
  log_error($raw_msg);
}

function log_die($raw_msg) {
  log_error($raw_msg);
  die($raw_msg);
}

function exec_timeout($cmd, $timeout) {
  // File descriptors passed to the process.
  $descriptors = array(
    0 => array('pipe', 'r'),  // stdin
    1 => array('pipe', 'w'),  // stdout
    2 => array('pipe', 'w')   // stderr
  );

  // Start the process.
  $process = proc_open('exec ' . $cmd, $descriptors, $pipes);

  if (!is_resource($process)) {
    throw new \Exception('Could not execute process');
  }

  // Set the stdout stream to none-blocking.
  stream_set_blocking($pipes[1], 0);

  // Turn the timeout into microseconds.
  $timeout = $timeout * 1000000;

  // Output buffer.
  $buffer = '';

  // While we have time to wait.
  while ($timeout > 0) {
    $start = microtime(true);

    // Wait until we have output or the timer expired.
    $read  = array($pipes[1]);
    $other = array();
    stream_select($read, $other, $other, 0, $timeout);

    // Get the status of the process.
    // Do this before we read from the stream,
    // this way we can't lose the last bit of output if the process dies between these functions.
    $status = proc_get_status($process);

    // Read the contents from the buffer.
    // This function will always return immediately as the stream is none-blocking.
    $buffer .= stream_get_contents($pipes[1]);

    if (!$status['running']) {
      // Break from this loop if the process exited before the timeout.
      break;
    }

    // Subtract the number of microseconds that we waited.
    $timeout -= (microtime(true) - $start) * 1000000;
  }

  // Check if there were any errors.
  $errors = stream_get_contents($pipes[2]);

  if (!empty($errors)) {
    throw new \Exception($errors);
  }

  // Kill the process in case the timeout expired and it's still running.
  // If the process already exited this won't do anything.
  proc_terminate($process, 9);

  // Close all streams.
  fclose($pipes[0]);
  fclose($pipes[1]);
  fclose($pipes[2]);

  proc_close($process);

  return $buffer;
}

function get_server_meta($meta_key, $default){
	if (file_exists(BASE_DIR . 'server-meta/' . meta_filename($meta_key) .'.txt')) {
    $meta_value = file_get_contents(BASE_DIR . 'server-meta/' . meta_filename($meta_key) .'.txt', true);
		return maybe_unserialize($meta_value);
	} else {
    return $default;
  }
}

function update_server_meta($meta_key, $meta_value){
  $meta_value = maybe_serialize($meta_value);
  $file = BASE_DIR . 'server-meta/' . meta_filename($meta_key) .'.txt';
	file_put_contents($file, $meta_value);
  @chmod($file, 0777);
}

function remove_server_meta($meta_key){
	if (file_exists(BASE_DIR . 'server-meta/' . meta_filename($meta_key) .'.txt')) {
    $file = BASE_DIR . 'server-meta/' . meta_filename($meta_key) .'.txt';
    chmod($file, 0777);
		unlink($file);
	}
}

function maybe_serialize($data){
    if (is_array($data) || is_object($data))
            return serialize($data);

    return $data;
}

function maybe_unserialize($data){
    if (is_serialized($data))
            return @unserialize($data);
    return $data;
}

function is_serialized($data) {
    if (!is_string($data))
            return false;
    $data = trim($data);
    if ('N;' == $data)
            return true;
    $length = strlen($data);
    if ($length < 4)
            return false;
    if (':' !== $data[1])
            return false;
    $lastc = $data[$length-1];
    if (';' !== $lastc && '}' !== $lastc)
            return false;
    $token = $data[0];
    switch ($token) {
            case 's' :
                    if ('"' !== $data[$length-2])
                            return false;
            case 'a' :
            case 'O' :
                    return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b' :
            case 'i' :
            case 'd' :
                    return (bool) preg_match("/^{$token}:[0-9.E-]+;\$/", $data);
    }
    return false;
}

function convert_byte($size) {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

function rrmdir($path){
	if (is_dir($path)) {
		array_map( "rrmdir", glob($path . DIRECTORY_SEPARATOR . '{,.[!.]}*', GLOB_BRACE) );
		@rmdir($path);
	}
	else {
		@unlink($path);
	}
}

function clean_work_dir($min = 60) {
  $directories = glob(BASE_DIR . '/data/work/*');
  $now   = time();
  foreach ($directories as $directory) {
    if (is_dir($directory)) {
      if ($now - filemtime($directory) >= 60 * $min) {
        rrmdir($directory);
      }
    }
  }
}

function valid_timezone($timezone) {
  return in_array($timezone, timezone_identifiers_list());
}

function get_server_cpu_loads() {
  $stat1 = file('/proc/stat');
  sleep(1);
  $stat2 = file('/proc/stat');
  $info1 = explode(" ", preg_replace("!cpu +!", "", $stat1[0]));
  $info2 = explode(" ", preg_replace("!cpu +!", "", $stat2[0]));
  $dif = array();
  $dif['user'] = $info2[0] - $info1[0];
  $dif['nice'] = $info2[1] - $info1[1];
  $dif['sys'] = $info2[2] - $info1[2];
  $dif['idle'] = $info2[3] - $info1[3];
  $total = array_sum($dif);
  $cpu = array();
  foreach($dif as $x=>$y) $cpu[$x] = round($y / $total * 100, 1);

  return $cpu;
}

/*
function get_server_load_array() {
    if (is_readable("/proc/stat"))
    {
        $stats = @file_get_contents("/proc/stat");

        if ($stats !== false)
        {
            // Remove double spaces to make it easier to extract values with explode()
            $stats = preg_replace("/[[:blank:]]+/", " ", $stats);

            // Separate lines
            $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
            $stats = explode("\n", $stats);

            // Separate values and find line for main CPU load
            foreach ($stats as $statLine)
            {
                $statLineData = explode(" ", trim($statLine));

                // Found!
                if
                (
                    (count($statLineData) >= 5) &&
                    ($statLineData[0] == "cpu")
                )
                {
                    return array(
                        $statLineData[1],
                        $statLineData[2],
                        $statLineData[3],
                        $statLineData[4],
                    );
                }
            }
        }
    }

    return null;
}

function get_server_load_percentage() {
    $load = null;

    if (stristr(PHP_OS, "win"))
    {
        $cmd = "wmic cpu get loadpercentage /all";
        @exec($cmd, $output);

        if ($output)
        {
            foreach ($output as $line)
            {
                if ($line && preg_match("/^[0-9]+\$/", $line))
                {
                    $load = $line;
                    break;
                }
            }
        }
    }
    else
    {
        if (is_readable("/proc/stat"))
        {
            // Collect 2 samples - each with 1 second period
            // See: https://de.wikipedia.org/wiki/Load#Der_Load_Average_auf_Unix-Systemen
            $statData1 = get_server_load_array();
            sleep(1);
            $statData2 = get_server_load_array();

            if
            (
                (!is_null($statData1)) &&
                (!is_null($statData2))
            )
            {
                // Get difference
                $statData2[0] -= $statData1[0];
                $statData2[1] -= $statData1[1];
                $statData2[2] -= $statData1[2];
                $statData2[3] -= $statData1[3];

                // Sum up the 4 values for User, Nice, System and Idle and calculate
                // the percentage of idle time (which is part of the 4 values!)
                $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];

                // Invert percentage to get CPU time, not idle time
                $load = 100 - ($statData2[3] * 100 / $cpuTime);
            }
        }
    }

    return $load;
}
*/
function get_server_memory_usage($getPercentage = true) {
    $memoryTotal = null;
    $memoryFree = null;

    if (stristr(PHP_OS, "win")) {
        // Get total physical memory (this is in bytes)
        $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
        @exec($cmd, $outputTotalPhysicalMemory);

        // Get free physical memory (this is in kibibytes!)
        $cmd = "wmic OS get FreePhysicalMemory";
        @exec($cmd, $outputFreePhysicalMemory);

        if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
            // Find total value
            foreach ($outputTotalPhysicalMemory as $line) {
                if ($line && preg_match("/^[0-9]+\$/", $line)) {
                    $memoryTotal = $line;
                    break;
                }
            }

            // Find free value
            foreach ($outputFreePhysicalMemory as $line) {
                if ($line && preg_match("/^[0-9]+\$/", $line)) {
                    $memoryFree = $line;
                    $memoryFree *= 1024;  // convert from kibibytes to bytes
                    break;
                }
            }
        }
    }
    else
    {
        if (is_readable("/proc/meminfo"))
        {
            $stats = @file_get_contents("/proc/meminfo");

            if ($stats !== false) {
                // Separate lines
                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                $stats = explode("\n", $stats);

                // Separate values and find correct lines for total and free mem
                foreach ($stats as $statLine) {
                    $statLineData = explode(":", trim($statLine));

                    //
                    // Extract size (TODO: It seems that (at least) the two values for total and free memory have the unit "kB" always. Is this correct?
                    //

                    // Total memory
                    if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                        $memoryTotal = trim($statLineData[1]);
                        $memoryTotal = explode(" ", $memoryTotal);
                        $memoryTotal = $memoryTotal[0];
                        $memoryTotal *= 1024;  // convert from kibibytes to bytes
                    }

                    // Free memory
                    if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                        $memoryFree = trim($statLineData[1]);
                        $memoryFree = explode(" ", $memoryFree);
                        $memoryFree = $memoryFree[0];
                        $memoryFree *= 1024;  // convert from kibibytes to bytes
                    }
                }
            }
        }
    }

    if (is_null($memoryTotal) || is_null($memoryFree)) {
        return null;
    } else {
        if ($getPercentage) {
            return (100 - ($memoryFree * 100 / $memoryTotal));
        } else {
            return array(
                "total" => $memoryTotal,
                "free" => $memoryFree,
            );
        }
    }
}

function slugify($string){
  $slug = strtolower($string);
  $slug = str_replace(" -","",$slug);
  $slug = str_replace("- ","",$slug);
  $slug = str_replace("&","",$slug);
  $slug = str_replace("+","",$slug);
  $slug = str_replace("/","",$slug);
  $slug = str_replace("","",$slug);
  $slug = str_replace(".","",$slug);
  $slug = str_replace("?","",$slug);
  $slug = str_replace(")","",$slug);
  $slug = str_replace("(","",$slug);
  $slug = str_replace("[","",$slug);
  $slug = str_replace("]","",$slug);
  $slug = str_replace("|","",$slug);
  $slug = str_replace("<","",$slug);
  $slug = str_replace(">","",$slug);
  $slug = str_replace(";","",$slug);
  $slug = str_replace('"',"",$slug);
  $slug = str_replace("'","",$slug);
  $slug = str_replace(":","",$slug);
  $slug = str_replace("!","",$slug);
  $slug = str_replace("@","",$slug);
  $slug = str_replace("#","",$slug);
  $slug = str_replace("$","",$slug);
  $slug = str_replace("%","",$slug);
  $slug = str_replace("^","",$slug);
  $slug = str_replace("*","",$slug);
  $slug = str_replace("=","",$slug);
  $slug = str_replace(" ","-",$slug);
  $slug = str_replace("--","-",$slug);
  return $slug;
}

function get_directory_size($dir) {
    $size = 0;
    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
        $size += is_file($each) ? filesize($each) : get_directory_size($each);
    }
    return $size;
}

function get_pretty_file_size($bytes, $binaryPrefix = false) {
    if ($binaryPrefix) {
        $unit=array('B','KiB','MiB','GiB','TiB','PiB');
        if ($bytes==0) return '0 ' . $unit[0];
        return @round($bytes/pow(1024,($i=floor(log($bytes,1024)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
    } else {
        $unit=array('B','KB','MB','GB','TB','PB');
        if ($bytes==0) return '0 ' . $unit[0];
        return @round($bytes/pow(1000,($i=floor(log($bytes,1000)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
    }
}

function get_end_time() {
  global $start;
  return time() - $start;
}

function get_end_time_micro() {
  global $start_micro;
  return microtime(true) - $start_micro;
}

function convert_f_to_k($val) {
  return round(convert_f_to_c($val)+273.15);
}

function convert_k_to_f($val) {
  return round((($val - 273.15) * 1.8) + 32);
}

function convert_c_to_k($val) {
	return round(($val + 273.15));
}

function convert_k_to_c($val) {
	return round(($val - 273.15));
}

function convert_m_to_cm($val) {
	return $val*100;
}

function convert_cm_to_m($val) {
	return $val/100;
}

function convert_m_to_in($val) {
	return $val*39.37;
}

function convert_m_to_mm($val) {
	return $val*1000;
}

function convert_m_to_ft($val) {
	return $val*3.281;
}

function convert_in_to_m($val) {
	return $val/39.37;
}

function convert_mm_to_in($val) {
	return $val/25.4;
}

function convert_mm_to_cm($val) {
	return $val/10;
}

function convert_mms_to_inh($val) {
	return $val*141.732;
}

function convert_inh_to_mms($val) {
	return $val/141.732;
}

function convert_mms_to_mmh($val) {
	return $val*3600;
}

function convert_mmh_to_mms($val) {
	return $val/3600;
}

function convert_in_to_mm($val) {
	return $val*25.4;
}

function convert_c_to_f($val) {
	return $val*9/5+32;
}

function convert_f_to_c($val) {
	return ($val-32)/1.8;
}

function dater($date = null, $format = null) {
      if(is_null($format))
          $format = 'Y-m-d H:i:s';

      if(is_null($date))
          $date = time();

  if(is_int($date))
    return date($format, $date);
  if(is_float($date))
    return date($format, $date);
  if(is_string($date)) {
        if(ctype_digit($date) === true)
            return date($format, $date);
    if((preg_match('/[^0-9.]/', $date) == 0) && (substr_count($date, '.') <= 1))
      return date($format, floatval($date));
    return date($format, strtotime($date));
  }

  // If $date is anything else, you're doing something wrong,
  // so just let PHP error out however it wants.
  return date($format, $date);
  }

  function valid_time_stamp($timestamp){
      return ((string) (int) $timestamp === $timestamp)
          && ($timestamp <= PHP_INT_MAX)
          && ($timestamp >= ~PHP_INT_MAX);
  }

  function mysql_time($stamp){
    return date("Y-m-d H:i:s", $stamp);
  }

  function contains($needle, $haystack) {
      return strpos($haystack, $needle) !== false;
  }

  //echo get_nearest_timezone(33.524755, -90.81274, "US");
  //echo get_nearest_timezone(33.524755, -90.81274, "");
  function get_nearest_timezone($cur_lat, $cur_long, $country_code = '') {
      $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
                                      : DateTimeZone::listIdentifiers();

      if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

          $time_zone = '';
          $tz_distance = 0;

          //only one identifier?
          if (count($timezone_ids) == 1) {
              $time_zone = $timezone_ids[0];
          } else {

              foreach($timezone_ids as $timezone_id) {
                  $timezone = new DateTimeZone($timezone_id);
                  $location = $timezone->getLocation();
                  $tz_lat   = $location['latitude'];
                  $tz_long  = $location['longitude'];

                  $theta    = $cur_long - $tz_long;
                  $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat)))
                  + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                  $distance = acos($distance);
                  $distance = abs(rad2deg($distance));
                  // echo '<br />'.$timezone_id.' '.$distance;

                  if (!$time_zone || $tz_distance > $distance) {
                      $time_zone   = $timezone_id;
                      $tz_distance = $distance;
                  }

              }
          }
          return  $time_zone;
      }
      return 'unknown';
  }

  function auto_xy($value, $width, $height) {
    global $field_calculator;
    $value = str_replace("MAPWIDTH",$width,$value);
    $value = str_replace("MAPHEIGHT",$height,$value);
    $value = str_replace("WIDTH",$width,$value);
    $value = str_replace("HEIGHT",$height,$value);
    $value = str_replace(" ","",$value);
    $value = $field_calculator->calculate($value);
    if (!is_numeric($value)) {
      $value = 50;
    }
    return $value;
  }

  class Field_calculate {
      const PATTERN = '/(?:\-?\d+(?:\.?\d+)?[\+\-\*\/])+\-?\d+(?:\.?\d+)?/';

      const PARENTHESIS_DEPTH = 10;

      public function calculate($input){
          if(strpos($input, '+') != null || strpos($input, '-') != null || strpos($input, '/') != null || strpos($input, '*') != null){
              //  Remove white spaces and invalid math chars
              $input = str_replace(',', '.', $input);
              $input = preg_replace('[^0-9\.\+\-\*\/\(\)]', '', $input);

              //  Calculate each of the parenthesis from the top
              $i = 0;
              while(strpos($input, '(') || strpos($input, ')')){
                  $input = preg_replace_callback('/\(([^\(\)]+)\)/', 'self::callback', $input);

                  $i++;
                  if($i > self::PARENTHESIS_DEPTH){
                      break;
                  }
              }

              //  Calculate the result
              if(preg_match(self::PATTERN, $input, $match)){
                  return $this->compute($match[0]);
              }
              // To handle the special case of expressions surrounded by global parenthesis like "(1+1)"
              if(is_numeric($input)){
                  return $input;
              }

              return 0;
          }

          return $input;
      }

      private function compute($input){
          $compute = @create_function('', 'return '.$input.';');

          return 0 + $compute();
      }

      private function callback($input){
          if(is_numeric($input[1])){
              return $input[1];
          }
          elseif(preg_match(self::PATTERN, $input[1], $match)){
              return $this->compute($match[0]);
          }

          return 0;
      }
  }

  function closest_number($search, $arr) {
     $closest = null;
     foreach ($arr as $item) {
        if ($closest === null || abs($search - $closest) > abs($item - $search)) {
           $closest = $item;
        }
     }
     return $closest;
  }
  function greater_number($num1, $num2){
    if ($num1 > $num2) {
      return $num1;
    } else {
      return $num2;
    }
  }
?>
