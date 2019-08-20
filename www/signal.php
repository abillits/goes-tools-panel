<?php require_once('load.php'); ?>
<?php
$title = "Signal Status";

?>
<?php require_once('header.php'); ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="card ">
                              <div class="card-header " style="margin-left:1px; margin-right:1px;">
                                  <h4 class="card-title">Signal</h4>
                                  <p class="card-category">Past <?php echo SIGNAL_STATUS_CHART_MINUTES; ?> Minutes</p>
                              </div>
                              <div class="card-body">
                                  <div id="signal" class="ct-chart"></div>
                              </div>
                              <div class="card-footer ">
                                  <div class="legend">
                                      <i class="fa fa-circle text-info"></i> Viterbi
                                      <i class="fa fa-circle text-purple"></i> Packets
                                      <i class="fa fa-circle text-danger"></i> Drops
                                  </div>
                                  <hr>
                                  <div class="stats">
                                      <i class="fa fa-history"></i> Updated <time class="timeagoSignal" datetime="2008-07-17T09:24:17Z">Never</time>
                                  </div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                          <div class="card ">
                              <div class="card-header " style="margin-left:1px; margin-right:1px;">
                                  <h4 class="card-title">Files Received</h4>
                                  <p class="card-category">Last <?php echo SIGNAL_STATUS_FILES_NUM; ?> Files</p>
                              </div>
                              <div class="card-body table-full-width table-responsive">
                                  <table class="table table-hover table-striped" id="files">
                                    <!--
                                      <thead>
                                          <th>Type</th>
                                          <th>File</th>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td>GOES 16/td>
                                              <td>somefile.png</td>
                                          </tr>
                                      </tbody>
                                        -->
                                  </table>
                              </div>
                              <div class="card-footer ">
                                  <hr>
                                  <div class="stats">
                                      <i class="fa fa-history"></i> Updated <time class="timeagoFiles" datetime="2008-07-17T09:24:17Z">Never</time>
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
            <script src="./assets/js/plugins/moment.min.js"></script>
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
              var chartSignalData ={
              series: [
              {
              name: 'viterbi',
              data: []
              },
              {
              name: 'packets',
              data: []
              },
              {
              name: 'drops',
              data: []
              }
              ]
              }

              var chartSignalOptions = {
              lineSmooth: false,
              axisX: {
              type: Chartist.FixedScaleAxis,
              divisor: 5,
              labelInterpolationFnc: function(value) {
              return moment(value).format('h:mm A');
              }
              }
              }

              var chartSignal = new Chartist.Line('#signal', chartSignalData, chartSignalOptions);

              loadSignal();
              var tmrSignal = setInterval(loadSignal, 10000);
              function loadSignal() {
              $.ajax({
              url : "ajax-signal.php",
              dataType: "json",
              success : function (data) {
                var dataViterbi = data.viterbi,
                    dataPackets = data.packets,
                    dataDrops = data.drops;

                var chartSignalData = {
                  series: [
                    {
                      name: 'viterbi',
                      data: dataViterbi
                    },
                    {
                      name: 'packets',
                      data: dataPackets
                    },
                    {
                      name: 'drops',
                      data: dataDrops
                    }
                  ]
                };
                chartSignal.update(chartSignalData);
                var d = new Date();
                $("time.timeagoSignal").attr('datetime',d.toISOString());
                $("time.timeagoSignal").timeago();
              }
              });
              }
            //=======================================//
              loadFiles();
              var tmrFiles = setInterval(loadFiles, 10000);
              function loadFiles() {
              $.ajax({
              url : "ajax-files.php",
              dataType: "text",
              success : function (data) {
                  $("#files").html(data);
                  var d = new Date();
                  $("time.timeagoFiles").attr('datetime',d.toISOString());
                  $("time.timeagoFiles").timeago();
              }
              });
              }
            //=======================================//
            });
            </script>
<?php require_once('footer.php'); ?>
