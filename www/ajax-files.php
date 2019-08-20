<?php
require_once('load.php');
###########################################
if (!check_ajax_key()) {
  die("invalid ajax key");
}
###########################################
//$lines = get_goesproc_log_lines(SIGNAL_STATUS_FILES_NUM);
$files = get_latest_data_files(SIGNAL_STATUS_FILES_NUM);
###########################################
?>
<thead>
    <th>Type</th>
    <th>Received</th>
    <th>File</th>
</thead>
<tbody>
<?php
foreach ($files as $file) {
?>
<tr>
    <td><?php echo get_file_type_from_path($file); ?></td>
    <td><?php echo date ("g:i A", filemtime(BASE_DIR . $file)); ?></td>
    <td><a target="_blank" href="<?php echo $file; ?>"><?php echo get_file_name_from_path($file); ?></a></td>
</tr>
<?php
}
?>
</tbody>
