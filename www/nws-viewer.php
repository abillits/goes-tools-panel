<?php require_once('load.php'); ?>
<?php
$title = "NWS Viewer";
$selected_file = false;
$files = array();
$data_dir = BASE_DIR . "data/nws/";
$data_url = "/data/nws/";
if (file_exists($data_dir)) {
  $raw_files = glob($data_dir . '*');
  usort($raw_files, function($a, $b) {
      return filemtime($a) < filemtime($b);
  });
  foreach ($raw_files as $raw_file) {
    $path_parts = pathinfo($raw_file);
    $new_file = array();
    $new_file['extension'] = $path_parts['extension'];
    $new_file['name'] = $path_parts['filename'];
    $new_file['path'] = $raw_file;
    $new_file['url'] = $data_url . $path_parts['basename'];
    $new_file['received'] = filemtime($raw_file);
    $new_file['hash'] = md5($raw_file);
    $files[$new_file['hash']] = $new_file;
    unset($new_file);
    unset($path_parts);
  }
}
$file_count = count($files);
if ($file_count > 0 && isset($_GET['f'])) {
  if (array_key_exists($_GET['f'], $files)) {
    $selected_file = $files[$_GET['f']];
  }
}
?>
<?php require_once('header.php'); ?>
            <div class="content">
                <div class="container-fluid">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="card ">
                              <div class="card-body" style="min-height:75px;">
                                <select name="cities" class="selectpicker" data-title="<?php if ($file_count < 1) { echo "NONE AVAILABLE"; } else { echo "CHOOSE FILE"; } ?>" data-style="btn-default btn-outline" data-menu-style="dropdown-blue" onchange="window.location.replace(this.options[this.selectedIndex].value)">
                                  <?php
                                  if ($file_count > 0) {
                                    foreach ($files as $file) {
                                      ?>
                                      <option <?php if (isset($_GET['f']) && $_GET['f'] == $file['hash']) { echo 'selected="selected"'; } ?> value="nws-viewer.php?f=<?php echo $file['hash']; ?>"><?php echo strtoupper($file['name']); ?> - <?php echo strtoupper($file['extension']); ?></option>
                                      <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="card ">
                              <div id="viewer" class="card-body">
                                <?php
                                if ($file_count < 1) {
                                  echo "<center>No files available...</center>";
                                } else if (!$selected_file) {
                                  echo "<center>Please choose a file...</center>";
                                } else {
                                  if ($selected_file['extension'] == "txt") {
                                    //text file
                                    $fh = fopen($selected_file['path'], 'r');
                                    $file_contents = fread($fh, 25000);
                                    echo nl2br($file_contents);
                                  } else {
                                    //image
                                    ?>
                                    <center>
                                      <img src="<?php echo $selected_file['url']; ?>" alt="<?php echo $selected_file['name']; ?>" style="max-width:100%;">
                                    </center>
                                    <?php
                                  }
                                }
                                ?>
                              </div>
                          </div>
                      </div>
                  </div>
                    <!--
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header " style="margin-left:1px; margin-right:1px;">
                                    <h4 class="card-title">Card Title</h4>
                                    <p class="card-category">Card Tag Line</p>
                                </div>
                                <div class="card-body ">
                                </div>
                                <div class="card-footer ">
                                    <div class="legend">

                                        <i class="fa fa-circle text-info"></i> Tesla Model S
                                        <i class="fa fa-circle text-danger"></i> BMW 5 Series
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-check"></i> Data information certified
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
            <script src="../../assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
<?php require_once('footer.php'); ?>
