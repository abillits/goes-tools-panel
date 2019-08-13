<?php
require_once('load.php');
###########################################
if (!check_ajax_key()) {
  die("invalid ajax key");
}
###########################################
$lines = get_goesproc_log_lines(SIGNAL_STATUS_FILES_NUM);
###########################################
?>
<thead>
    <th>Type</th>
    <th>File</th>
</thead>
<tbody>
<?php
foreach ($lines as $line) {
?>
<tr>
    <td><?php echo get_file_type_from_goesproc_log_line($line); ?></td>
    <td><a target="_blank" href="/data/<?php echo $line; ?>"><?php echo get_file_name_from_goesproc_log_line($line); ?></a></td>
</tr>
<?php
}
?>
</tbody>
