<?php require_once('load.php'); ?>
<?php
$title = "Product Viewer";
$selected_product = false;
$products = array();
$data_dir = BASE_DIR . "data/";
$data_url = "/data/";

$directory = new \RecursiveDirectoryIterator($data_dir);
$iterator = new \RecursiveIteratorIterator($directory);
$products = array();
$raw_products = array();
foreach ($iterator as $info) {
  if (contains("png", $info->getPathname()) && !contains("nws", $info->getPathname())) {
    $product_path = str_replace($data_dir,"",str_replace($info->getfileName(),"",$info->getPathname()));
    $products[md5($product_path)] = $product_path;
  }
}
unset($iterator);
unset($directory);
if (count($products) > 0) {
  asort($products);
}
$product_count = count($products);
if ($product_count > 0 && isset($_GET['p'])) {
  if (array_key_exists($_GET['p'], $products)) {
    $selected_product = $products[$_GET['p']];
    $selected_product_files = glob($data_dir . $selected_product . "*.png");
    usort($selected_product_files, function($a, $b) {
        return get_timestamp_from_imagery_file($a) < get_timestamp_from_imagery_file($b);
    });
  }
}
?>
<?php require_once('header.php'); ?>
            <div class="content">
                <div class="container-fluid">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="card ">
                              <div class="card-body" style="min-height:75px;">
                                <select name="product" class="selectpicker" data-title="CHOOSE PRODUCT" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                  <?php
                                  if ($product_count > 0) {
                                    foreach ($products as $hash => $product) {
                                      ?>
                                      <option <?php if (isset($_GET['p']) && $_GET['p'] == $hash) { echo 'selected="selected"'; } ?> value="<?php echo $hash; ?>"><?php echo strtoupper(str_replace("/"," ",str_replace("_enhanced", " (enhanced)", $product))); ?></option>
                                      <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="card ">
                              <div class="card-body" style="min-height:75px;text-align:center;">
                                <table style="width:100%">
                                  <tbody style="width:100%">
                                    <tr style="width:100%">
                                      <td style="width:75%">
                                        <select <?php //if (!$selected_product) { echo 'disabled="disabled"'; } ?> name="type" class="selectpicker" data-style="btn-default btn-outline" data-menu-style="dropdown-blue" style="width:100%;">
                                            <option <?php if (isset($_GET['t']) && $_GET['t'] == "latest") { echo 'selected="selected"'; } ?><?php if (!isset($_GET['t'])) { echo 'selected="selected"'; } ?> value="latest">LATEST</option>
                                            <option <?php if (isset($_GET['t']) && $_GET['t'] == "past-1") { echo 'selected="selected"'; } ?> value="past-1">PAST HOUR</option>
                                            <option <?php if (isset($_GET['t']) && $_GET['t'] == "past-2") { echo 'selected="selected"'; } ?> value="past-2">PAST 2 HOURS</option>
                                            <option <?php if (isset($_GET['t']) && $_GET['t'] == "past-3") { echo 'selected="selected"'; } ?> value="past-3">PAST 3 HOURS</option>
                                            <option <?php if (isset($_GET['t']) && $_GET['t'] == "past-4") { echo 'selected="selected"'; } ?> value="past-4">PAST 4 HOURS</option>
                                            <option <?php if (isset($_GET['t']) && $_GET['t'] == "past-6") { echo 'selected="selected"'; } ?> value="past-6">PAST 6 HOURS</option>
                                            <option <?php if (isset($_GET['t']) && $_GET['t'] == "past-12") { echo 'selected="selected"'; } ?> value="past-12">PAST 12 HOURS</option>
                                            <?php if (ANIMATION_GEN == "server") { ?>
                                            <option <?php if (isset($_GET['t']) && $_GET['t'] == "past-18") { echo 'selected="selected"'; } ?> value="past-18">PAST 18 HOURS</option>
                                            <option <?php if (isset($_GET['t']) && $_GET['t'] == "past-24") { echo 'selected="selected"'; } ?> value="past-24">PAST DAY</option>
                                            <!--<option <?php if (isset($_GET['t']) && $_GET['t'] == "past-48") { echo 'selected="selected"'; } ?> value="past-48">PAST 2 DAYS</option>-->
                                            <!--<option <?php if (isset($_GET['t']) && $_GET['t'] == "past-72") { echo 'selected="selected"'; } ?> value="past-72">PAST 3 DAYS</option>-->
                                            <?php } ?>
                                        </select>
                                      </td>
                                      <td style="width:1%"></td>
                                      <td style="width:24%">
                                        <a id="load" <?php //if (!$selected_product) { echo 'disabled="disabled"'; } ?> class="btn btn<?php if ($product) { echo '-info'; } ?> btn-fill" style="margin-top:3px;width:100%;" href="#">Load</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="card ">
                              <div id="viewer" class="card-body">
                                <?php
                                if (!$selected_product) {
                                  echo "<center>Please choose a product...</center>";
                                } else {
                                  if (!isset($_GET['t'])) {
                                    echo "<center>Invalid selection...</center>";
                                  } else {
                                    if (isset($_GET['t']) && $_GET['t'] == "latest") {
                                      $path_parts = pathinfo($selected_product_files[0]);
                                      ?>
                                      <center>
                                        <img id="product-image" src="<?php echo str_replace($data_dir,$data_url,$selected_product_files[0]); ?>" alt="<?php echo $path_parts['basename']; ?>" style="max-width:100%;max-height:100%;">
                                      </center>
                                      <?php
                                    } else {
                                      ?>
                                      <center id="product-container">
                                        <img id="product-image" src="/assets/img/loader.gif" style="max-width:100%;max-height:100%;">
                                        <div id="progress"></div>
                                      </center>
                                      <?php
                                    }
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
            <script src="../assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
            <script src="../assets/js/gifshot.min.js" type="text/javascript"></script>
            <script type="text/javascript">
            $(document).ready(function() {
              //=======================================//
              $.ajaxSetup( {
                  cache : false,
                  timeout: 300000,
                  headers: {
                      'AJAXKEY': '<?php echo get_ajax_key(); ?>'
                  }
              } );
              //=======================================//
              vph = $(window).height();
              vph = (vph / 100) * 95;
              $('#product-image').css({'max-height': vph + 'px'});
            //=======================================//
            $( "#load" ).click(function() {
              if ($('select[name=product]').val()) {
                window.location.replace("product-viewer.php?p=" + $('select[name=product]').val() + "&t=" + $('select[name=type]').val())
              }
            });
            //=======================================//
            <?php
              if ($selected_product && isset($_GET['t']) && contains("past",$_GET['t']) && isset($selected_product_files) && count($selected_product_files) > 0) {
                $hours = str_replace("past-","",$_GET['t']);
                $frames = array();
                $then = time() - ($hours * 3600) - 900;
                foreach($selected_product_files as $selected_product_file) {
                  //we should REALLY do this by the date/time in the file name... but I'm tired and it's 3AM.
                  $stamp = get_timestamp_from_imagery_file($selected_product_file);
                  if ($stamp > $then) {
                    $new_frame = array();
                    $new_frame['url'] = str_replace($data_dir,$data_url,$selected_product_file);
                    //$new_frame['time'] = $stamp;
                    $new_frame['time'] = "";
                    $frames[] = $new_frame;
                    unset($new_frame);
                  }
                }
                $frames = array_reverse($frames);
                list($width, $height) = getimagesize($selected_product_files[0]);
                if (ANIMATION_MAX_HEIGHT) {
                  if ($height > ANIMATION_MAX_HEIGHT) {
                    $percent = (100 / $height) * ANIMATION_MAX_HEIGHT;
                    $height = ANIMATION_MAX_HEIGHT;
                    $width = ($width / 100) * $percent;
                  }
                }
                if (ANIMATION_MAX_WIDTH) {
                  if ($width > ANIMATION_MAX_WIDTH) {
                    $percent = (100 / $width) * ANIMATION_MAX_WIDTH;
                    $width = ANIMATION_MAX_WIDTH;
                    $height = ($height / 100) * $percent;
                  }
                }
                $image_file_name = str_replace("/","-",$selected_product) . md5(json_encode($frames)) . ".gif";
                if (count($frames) < 1) {
                  ?>
                  animatedImage = document.getElementById("product-image");
                  animatedImage.style.visibility = "hidden";
                  imageProgress = document.getElementById("progress");
                  imageProgress.innerHTML = 'No frames available for selected timeframe...';
                  <?php
                } else if (file_exists($data_dir . "animations/" . $image_file_name)) {
                  //image already exists - no need to generate it
                  ?>
                  imageProgress = document.getElementById("progress");
                  imageProgress.innerHTML = 'Loading...';
                  animatedImage = document.getElementById("product-image");
                  animatedImage.src = '/data/animations/<?php echo $image_file_name; ?>?<?php echo time(); ?>';
                  animatedImage.alt = '<?php echo $image_file_name; ?>';
                  imageProgress.innerHTML = '';
                  <?php
                } else {
                  if (ANIMATION_GEN == "server") {
                    //generate animation on server
                    ?>
                    imageProgress = document.getElementById("progress");
                    imageProgress.innerHTML = 'Generating...';
                    $.post("ajax-generate-animation.php",
                    {
                      name: '<?php echo $image_file_name; ?>',
                      frames: '<?php echo serialize($frames); ?>'
                    },
                    function(data, status){
                      if (data != "success") {
                        imageProgress = document.getElementById("progress");
                        imageProgress.innerHTML = 'Error generating animation: ' + data;
                      } else {
                        imageProgress = document.getElementById("progress");
                        imageProgress.innerHTML = 'Loading...';
                        animatedImage = document.getElementById("product-image");
                        animatedImage.src = '/data/animations/<?php echo $image_file_name; ?>?<?php echo time(); ?>';
                        animatedImage.alt = '<?php echo $image_file_name; ?>';
                        imageProgress.innerHTML = '';
                      }
                      //alert("Data: " + data + "\nStatus: " + status);
                    });
                    <?php
                  } else {
                    //generate animation on client
                    ?>
                    imageProgress = document.getElementById("progress");
                    document.getElementById("progress").innerHTML = 'Generating: 1%';
                    gifshot.createGIF({
                      'gifWidth': <?php echo $width; ?>,
                      'gifHeight': <?php echo $height; ?>,
                      'frameDuration': <?php if (count($frames) < 5) { echo "10"; } else { echo "5"; } ?>,
                      'sampleInterval': 10,
                      'saveRenderingContexts': false,
                      'progressCallback': function(captureProgress) { document.getElementById("progress").innerHTML = 'Generating: ' + Math.round(captureProgress * 100) + '%'; },
                      //'completeCallback': function() {},
                      'images': [
                        <?php
                        $i = 0;
                        $frames_count_minus = count($frames) - 1;
                        while($i <= $frames_count_minus) {
                          echo "{ src:'" . $frames[$i]['url'] . "', text:'" . $frames[$i]['time'] . "' }";
                          if ($i != $frames_count_minus) {
                            echo ",";
                          }
                          $i++;
                        }
                        ?>
                      ]
                    },function(obj) {
                      if(!obj.error) {
                        var image = obj.image;
                        if (image == "") {
                          imageProgress = document.getElementById("progress");
                          imageProgress.innerHTML = 'Could not generate animation...';
                        } else {
                          imageProgress = document.getElementById("progress");
                          imageProgress.innerHTML = 'Loading...';
                          imageProgress.innerHTML = '';
                          animatedImage = document.getElementById("product-image");
                          animatedImage.src = image;
                          animatedImage.alt = '<?php echo $image_file_name; ?>';
                        }
                      }
                    });
                    <?php
                  }
                }
              }
            ?>
            //=======================================//
            });
            </script>
<?php require_once('footer.php'); ?>
