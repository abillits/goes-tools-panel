<?php require_once('load.php'); ?>
<?php
$title = "Server Status";
?>
<?php require_once('header.php'); ?>
<style>
.ct-series-a .ct-point,
.ct-series-a .ct-line,
.ct-series-a .ct-bar,
.ct-series-a .ct-slice-donut {
    stroke: #9368E9;
}
.ct-series-a .ct-slice-pie,
.ct-series-a .ct-slice-donut,
.ct-series-a .ct-area {
    fill: #9368E9;
}
.ct-series-b .ct-point,
.ct-series-b .ct-line,
.ct-series-b .ct-bar,
.ct-series-b .ct-slice-donut {
    stroke: #1DC7EA;
}
.ct-series-b .ct-slice-pie,
.ct-series-a .ct-slice-donut,
.ct-series-b .ct-area {
    fill: #1DC7EA;
}
.ct-series-o .ct-point,
.ct-series-o .ct-line,
.ct-series-o .ct-bar,
.ct-series-o .ct-slice-donut {
    fill: #fff;
}
.ct-series-o .ct-slice-pie,
.ct-series-a .ct-slice-donut,
.ct-series-o .ct-area {
    fill: #fff;
}
</style>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                          <div class="card ">
                              <div class="card-header " style="margin-left:1px; margin-right:1px;">
                                  <h4 class="card-title">CPU</h4>
                                  <!--<p class="card-category">Past 10 Minutes</p>-->
                              </div>
                              <div class="card-body">
                                  <div id="cpu" class="ct-chart"></div>
                              </div>
                              <div class="card-footer ">
                                  <div class="legend">
                                      <i class="fa fa-circle text-purple"></i> Used %
                                      <i class="fa fa-circle text-info"></i> Available %
                                  </div>
                                  <hr>
                                  <div class="stats">
                                      <i class="fa fa-history"></i> Updated <time class="timeagoCPU" datetime="2008-07-17T09:24:17Z">Never</time>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="card ">
                              <div class="card-header " style="margin-left:1px; margin-right:1px;">
                                  <h4 class="card-title">Memory</h4>
                                  <!--<p class="card-category">Past 10 Minutes</p>-->
                              </div>
                              <div class="card-body">
                                  <div id="memory" class="ct-chart"></div>
                              </div>
                              <div class="card-footer ">
                                  <div class="legend">
                                    <i class="fa fa-circle text-purple"></i> Used %
                                    <i class="fa fa-circle text-info"></i> Available %
                                  </div>
                                  <hr>
                                  <div class="stats">
                                      <i class="fa fa-history"></i> Updated <time class="timeagoMemory" datetime="2008-07-17T09:24:17Z">Never</time>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="card ">
                              <div class="card-header " style="margin-left:1px; margin-right:1px;">
                                  <h4 class="card-title">Disk</h4>
                                  <!--<p class="card-category">Past 10 Minutes</p>-->
                              </div>
                              <div class="card-body">
                                  <div id="disk" class="ct-chart"></div>
                              </div>
                              <div class="card-footer ">
                                  <div class="legend">
                                    <i class="fa fa-circle text-purple"></i> Used %
                                    <i class="fa fa-circle text-info"></i> Available %
                                  </div>
                                  <hr>
                                  <div class="stats">
                                      <i class="fa fa-history"></i> Updated <time class="timeagoDisk" datetime="2008-07-17T09:24:17Z">Never</time>
                                  </div>
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
            <script src="./assets/js/plugins/chartist.new.js"></script>
            <!--<script src="./assets/js/plugins/moment.min.js"></script>-->
            <script src="./assets/js/plugins/jquery.timeago.js"></script>
            <script type="text/javascript">
            $(document).ready(function() {
            //=======================================//
            $.ajaxSetup( {
                cache : false,
                headers: {
                    'AJAXKEY': '<?php echo get_ajax_key(); ?>'
                }
            } );
            //=======================================//
            var chartCPU = new Chartist.Pie('#cpu', {
              series: [50, 50]
            }, {
              donut: true,
              donutWidth: 60,
              startAngle: 225,
              total: 133.3,
              width: '100%',
              height: '100%',
              padding: '0',
              margin: '0',
              chartPadding: 0,
              showLabel: true
            });
            var chartMemory = new Chartist.Pie('#memory', {
              series: [50, 50]
            }, {
              donut: true,
              donutWidth: 60,
              startAngle: 225,
              total: 133.3,
              width: '100%',
              height: '100%',
              padding: '0',
              margin: '0',
              chartPadding: 0,
              showLabel: true
            });
            var chartDisk = new Chartist.Pie('#disk', {
              series: [50, 50]
            }, {
              donut: true,
              donutWidth: 60,
              startAngle: 225,
              total: 133.3,
              width: '100%',
              height: '100%',
              padding: '0',
              margin: '0',
              chartPadding: 0,
              showLabel: true
            });

            loadCPU();
            var tmrCPU = setInterval(loadCPU, 5000);
            function loadCPU() {
              $.ajax({
              url : "ajax-cpu.php",
              dataType: "json",
              success : function (data) {
                var chartCPUData = {
                  series: data
                };
                chartCPU.update(chartCPUData);
                var d = new Date();
                $("time.timeagoCPU").attr('datetime',d.toISOString());
                $("time.timeagoCPU").timeago();
              }
              });
            }

            loadMemory();
            var tmrMemory = setInterval(loadMemory, 10000);
            function loadMemory() {
              $.ajax({
              url : "ajax-memory.php",
              dataType: "json",
              success : function (data) {
                var chartMemoryData = {
                  series: data
                };
                chartMemory.update(chartMemoryData);
                var d = new Date();
                $("time.timeagoMemory").attr('datetime',d.toISOString());
                $("time.timeagoMemory").timeago();
              }
              });
            }

            loadDisk();
            var tmrDisk = setInterval(loadDisk, 90000);
            function loadDisk() {
              $.ajax({
              url : "ajax-disk.php",
              dataType: "json",
              success : function (data) {
                var chartDiskData = {
                  series: data
                };
                chartDisk.update(chartDiskData);
                var d = new Date();
                $("time.timeagoDisk").attr('datetime',d.toISOString());
                $("time.timeagoDisk").timeago();
              }
              });
            }
            //=======================================//
            });
            </script>
<?php require_once('footer.php'); ?>
