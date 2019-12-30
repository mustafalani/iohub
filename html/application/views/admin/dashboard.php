<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<?php
	$liveChannels =0;
	$targets = array();
	$userdata = $this->session->userdata('user_data');
	$channels = $this->common_model->getAllChannels($userdata['userid']);
	if(sizeof($channels)>0)
	{
		foreach($channels as $channel)
		{
			if($channel['channel_status'] == 1)
			{
				$liveChannels++;
			}
		}
	}
	if($userdata['user_type'] == 1)
	{
		$apps = $this->common_model->getAllApplications(0);
		$targets = $this->common_model->getAllTargets(0);
	}
	else{
		$apps = $this->common_model->getAllApplications($userdata['userid']);
		$targets = $this->common_model->getAllTargets($userdata['userid']);
	}
	$liveTargets =0;
	if(sizeof($targets)>0)
	{
		foreach($targets as $target)
		{
			$application = $this->common_model->getAppbyId($target['wowzaengin']);
			$wowza = $this->common_model->getWovzData($application[0]['live_source']);
			//http://IP:Port/api/v1/getStreamTargetStatus/{appName}
			$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['java_api_port'].'/api/v1/getStreamTargetStatus/'.$application[0]['application_name'];

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, FALSE);   // we want headers
			    // we don't need body
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	    	$data = json_decode($result,TRUE);
	    	if(sizeof($data['status'])>0)
	    	{
				foreach($data['status'] as $key=>$value)
				{
					if(array_key_exists($target['target_name'],$value))
					{
						switch($value[$target['target_name']])
						{
							case "Active":
							$liveTargets++;
							break;
						}
					}
				}
			}
		}
	}
	?>
	<style type="text/css">
		.hidden{
			display:none;
		}
	</style>
 <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-primary">
                  <div class="card-body pb-0">
                    <div class="btn-group float-right">
                     <!-- <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-settings"></i>
                      </button>-->
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                      </div>
                    </div>
                    <div class="text-value"><?php echo $liveChannels;?>/<?php echo sizeof($channels);?></div>
                    <div>Live Channels</div>
                  </div>
                  <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart1" height="70"></canvas>
                  </div>
                </div>
              </div>
              <!-- /.col-->
              <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-info">
                  <div class="card-body pb-0">
                    <div class="text-value"><?php echo sizeof($apps);?>/<?php echo sizeof($apps);?></div>
                    <div>Applications</div>
                  </div>
                  <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart2" height="70"></canvas>
                  </div>
                </div>
              </div>

              <!-- /.col-->
              <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-warning">
                  <div class="card-body pb-0">
                    <div class="btn-group float-right">
                    <!--  <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-settings"></i>
                      </button>-->
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                      </div>
                    </div>
                    <div class="text-value"><?php echo $liveTargets;?><?php echo sizeof($targets);?></div>
                    <div>Online Targets</div>
                  </div>
                 <div class="chart-wrapper mt-3" style="height:70px;">
                    <canvas class="chart" id="card-chart3" height="70"></canvas>
                  </div>
                </div>
              </div>
              <!-- /.col-->

                 <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-info">
                  <div class="card-body pb-0">
                   <!-- <button class="btn btn-transparent p-0 float-right" type="button">
                      <i class="icon-location-pin"></i>
                    </button>-->
                    <div class="text-value"><?php echo sizeof($apps);?>/<?php echo sizeof($apps);?></div>
                    <div> Events</div>
                  </div>
                  <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart4" height="70"></canvas>
                  </div>
                </div>
              </div>
              <!-- /.col-->
            </div>
            <!-- /.row-->
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-5">
                    <h4 class="card-title mb-0">Traffic</h4>
                    <div class="small text-muted">November 2017</div>
                  </div>
                  <!-- /.col-->
                  <div class="col-sm-7 d-none d-md-block">
                    <button class="btn btn-primary float-right" type="button">
                      <i class="icon-cloud-download"></i>
                    </button>
                    <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                      <label class="btn btn-outline-secondary">
                        <input id="option1" type="radio" name="options" autocomplete="off"> Day
                      </label>
                      <label class="btn btn-outline-secondary active">
                        <input id="option2" type="radio" name="options" autocomplete="off" checked=""> Month
                      </label>
                      <label class="btn btn-outline-secondary">
                        <input id="option3" type="radio" name="options" autocomplete="off"> Year
                      </label>
                    </div>
                  </div>
                  <!-- /.col-->
                </div>
                <!-- /.row-->
                <div class="chart-wrapper" style="height:300px;margin-top:40px;">
                  <canvas class="chart" id="main-chart" height="300"></canvas>
                </div>
              </div>
              <div class="card-footer">
                <div class="row text-center">
                  <div class="col-sm-12 col-md mb-sm-2 mb-0">
                    <div class="text-muted">Visits</div>
                    <strong>29.703 Users (40%)</strong>
                    <div class="progress progress-xs mt-2">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md mb-sm-2 mb-0">
                    <div class="text-muted">Unique</div>
                    <strong>24.093 Users (20%)</strong>
                    <div class="progress progress-xs mt-2">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md mb-sm-2 mb-0">
                    <div class="text-muted">Pageviews</div>
                    <strong>78.706 Views (60%)</strong>
                    <div class="progress progress-xs mt-2">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md mb-sm-2 mb-0">
                    <div class="text-muted">New Users</div>
                    <strong>22.123 Users (80%)</strong>
                    <div class="progress progress-xs mt-2">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md mb-sm-2 mb-0">
                    <div class="text-muted">Bounce Rate</div>
                    <strong>40.15%</strong>
                    <div class="progress progress-xs mt-2">
                      <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-->

            <!-- /.row-->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">Publishers & Encoders</div>
                  <div class="card-body">

                    <h1> System Resources </h1>

                   Overview of the system resources e.g encoders & publisher<br><br>
                   <h1> Publishers </h1>
                   <br/>
                    <div id="accordion" role="tablist">
                    <!--<a class="add-btn" id="add_wowza" href="<?php echo site_url();?>createwowza" style="float:left;margin:0;">
                                    <span><i class="fa fa-plus"></i> Publisher</span>
								</a>-->
               <?php
                    		$userdata = $this->session->userdata('user_data');
							if($userdata['user_type'] == 1)
							{
								$wowza = $this->common_model->getConfigurationsDetails(0,0);
							}
							else
							{
								$wowza = $this->Groupadmin_model->getConfigurationsDetails($userdata['userid'],$userdata['group_id']);
							}
                    		if(sizeof($wowza)>0)
                    		{

								foreach($wowza as $wowa)
								{
									if($wowa['status'] == 1)
									{
										$host = "http://".$wowa['ip_address'].":19999";
										$url = $host."/api/v1/charts";
										$ch = curl_init();
									    $headers = array(
									    'Content-Type: application/json'
									    );
									    curl_setopt($ch, CURLOPT_URL, $url);
									    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
									    curl_setopt($ch, CURLOPT_HEADER, 0);
									    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
									    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
									    $result = curl_exec($ch);
									    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


										if($httpcode == 200)
										{

									?>
									 <div class="card mb-0">
                        <div class="card-header" id="headingPUB<?php echo $wowa['id'];?>" role="tab">
                          <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" href="#wowza_accordion_<?php echo $wowa['id'];?>" aria-expanded="false" aria-controls="wowza_accordion_<?php echo $wowa['id'];?>"><?php echo $wowa['wse_instance_name'];?></a>
                          </h5>
                        </div>
                        <div class="collapse" id="wowza_accordion_<?php echo $wowa['id'];?>" role="tabpanel" aria-labelledby="headingPUB<?php echo $wowa['id'];?>" data-parent="#accordion">
                          <div class="card-body">
                          	<div class="row">
	                           <div class="col-xs-6 col-md-12 text-center">
	                              <div style="width: 100%; max-height: calc(100% - 15px); text-align: center; display: inline-block;">
						            <div style="width: 100%; height:100%; align: center; display: inline-block;">
	                <br/>
									<div class="netdata-container-easypiechart"style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.io" data-host="<?php echo $host;?>"
									    data-dimensions="in"
									    data-chart-library="easypiechart"
									    data-title="Disk Read"
									    data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.io.mainhead"
									    role="application">
									</div>
									<div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.io" data-host="<?php echo $host;?>"
									    data-dimensions="out"
									    data-chart-library="easypiechart"
									    data-title="Disk Write"
									    data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.io.mainhead"
									    role="application">
									</div>
									<div data-netdata="disk_space._"
									data-host="<?php echo $host;?>"
									    data-decimal-digits="0"
									    data-title="Available Disk"
									    data-dimensions="avail"
									    data-chart-library="easypiechart"
									    data-easypiechart-max-value="100"
									    data-common-max"avail"
									    data-width="11%"
									    data-height="100%"
									    data-after="-420"
									    data-points="420"
									    role="application">
									    </div>
									<div class="netdata-container-gauge" style="margin-right: 10px; width: 20%; will-change: transform;" data-netdata="system.cpu"  data-host="<?php echo $host;?>"
									    data-chart-library="gauge"
									    data-title="CPU"
									    data-units="%"
									    data-gauge-max-value="100"
									    data-width="20%"
									    data-after="-420"
									    data-points="420"
									    data-colors="#22AA99"
									    role="application">
									</div>
									<div class="netdata-container-easypiechart" style="margin-right: 10px; width: 9%; will-change: transform;" data-netdata="system.ram" data-host="<?php echo $host;?>"
									    data-dimensions="used|buffers|active|wired"
									    data-append-options="percentage"
									    data-chart-library="easypiechart"
									    data-title="Used RAM"
									    data-units="%"
									    data-easypiechart-max-value="100"
									    data-width="11%"
									    data-after="-420"
									    data-points="420"
									    data-colors="#EE9911"
									    role="application">
									</div>
									<div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>"
									    data-dimensions="received"
									    data-chart-library="easypiechart"
									    data-title="Net Inbound"
									    data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.net.mainhead"
									    role="application">
									</div>
									<div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>"
									    data-dimensions="sent"
									    data-chart-library="easypiechart"
									    data-title="Net
									    Outbound" data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.net.mainhead"
									    role="application">
									</div>

	            </div>
						          </div>
	                           </div>
	                        </div>
                          </div>
                        </div>
                      </div>

									<?php
										}
										else
										{
											?>
												 <div class="card mb-0">
								                        <div class="card-header" id="headingTwo" role="tab">
								                          <h5 class="mb-0">
								                            <a class="collapsed" data-toggle="collapse" href="#wowza_accordion_<?php echo $wowa['id'];?>" aria-expanded="false" aria-controls="collapseTwo"><?php echo $wowa['wse_instance_name'];?></a>
								                          </h5>
								                        </div>
								                        <div class="collapse" id="wowza_accordion_<?php echo $wowa['id'];?>" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
								                          <div class="card-body"><h1>No Data Found</h1></div>
								                        </div>
								                      </div>

										<?php
										}
									}
									elseif($wowa['status'] == 2)
									{
										?>
										<div class="col-xs-12" id="wowza_accordion_<?php echo $wowa['id'];?>">
					                    	  <div class="box box-solid collapsed-box">
					                     <div class="box-header with-border">
					                        <h3 class="box-title"><?php echo $wowa['wse_instance_name'];?></h3>
					                        <div class="box-tools pull-right">
					                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-plus"></i>
					                           </button>
					                           <button id="<?php echo $wowa['id'];?>" type="button" class="btn btn-default btn-sm wowzashowhide"><i class="fa fa-times"></i>
					                           </button>
					                        </div>
					                     </div>
					                     <!-- /.box-header -->
					                     <div class="box-body" style="display:none;">
					                        <div class="row">
					                           <div class="col-xs-6 col-md-12 text-center">
					                              <h1>No Data Found</h1>
					                           </div>
					                        </div>
					                     </div>
					                  </div>
											</div>
										<?php
									}
								}
							}
							else
							{
							?> <h3>Publishers not added yet!</h3>
							<?php
							}
                    		?>
                    		<br/>
                    		<h1> Encoders </h1>
                    		<br/>

                			<?php
                    		$userdata = $this->session->userdata('user_data');
							if($userdata['user_type'] == 1)
							{
								$encoders = $this->common_model->getAllEncoders(0,0);
							}
							else
							{
								$encoders = $this->Groupadmin_model->getAllEncodersbyUserIdAndGroupId($userdata['userid'],$userdata['group_id']);
							}

                    		if(sizeof($encoders)>0)
                    		{
								foreach($encoders as $encode)
								{
									if($encode['status'] == 1)
									{
										$host = "http://".$encode['encoder_ip'].":19999";

										$url = $host."/api/v1/charts";
										$ch = curl_init();
									    $headers = array(
									    'Content-Type: application/json'
									    );
									    curl_setopt($ch, CURLOPT_URL, $url);
									    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
									    curl_setopt($ch, CURLOPT_HEADER, 0);
									    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
									    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
									    $result = curl_exec($ch);
									    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

										$res = json_decode($result);

										if (json_last_error() === JSON_ERROR_NONE) {
											//echo "valid";	    // JSON is valid
										}

										if($httpcode == "200")
										{
											?>
												 <div class="card mb-0">
                        <div class="card-header" id="heading<?php echo $encode['id'];?>" role="tab">
                          <h5 class="mb-0">
                            <a class="collapsed" data-toggle="collapse" href="#encoder_accordion_<?php echo $encode['id'];?>" aria-expanded="false" aria-controls="encoder_accordion_<?php echo $encode['id'];?>"><?php echo $encode['encoder_name'];?></a>
                          </h5>
                        </div>
                        <div class="collapse" id="encoder_accordion_<?php echo $encode['id'];?>" role="tabpanel" aria-labelledby="heading<?php echo $encode['id'];?>" data-parent="#accordion">
                          <div class="card-body">
                          	<div class="row">
	                           <div class="col-xs-6 col-md-12 text-center">
	                            <div style="width: 100%; max-height: calc(100% - 15px); text-align: center; display: inline-block;">
						            <div style="width: 100%; height:100%; align: center; display: inline-block;">
	                <br/>
									<div class="netdata-container-easypiechart"style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.io" data-host="<?php echo $host;?>"
									    data-dimensions="in"
									    data-chart-library="easypiechart"
									    data-title="Disk Read"
									    data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.io.mainhead"
									    role="application">
									</div>
									<div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.io" data-host="<?php echo $host;?>"
									    data-dimensions="out"
									    data-chart-library="easypiechart"
									    data-title="Disk Write"
									    data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.io.mainhead"
									    role="application">
									</div>
									<div data-netdata="disk_space._"
									data-host="<?php echo $host;?>"
									    data-decimal-digits="0"
									    data-title="Available Disk"
									    data-dimensions="avail"
									    data-chart-library="easypiechart"
									    data-easypiechart-max-value="100"
									    data-common-max"avail"
									    data-width="11%"
									    data-height="100%"
									    data-after="-420"
									    data-points="420"
									    role="application">
									    </div>
									<div class="netdata-container-gauge" style="margin-right: 10px; width: 20%; will-change: transform;" data-netdata="system.cpu"  data-host="<?php echo $host;?>"
									    data-chart-library="gauge"
									    data-title="CPU"
									    data-units="%"
									    data-gauge-max-value="100"
									    data-width="20%"
									    data-after="-420"
									    data-points="420"
									    data-colors="#22AA99"
									    role="application">
									</div>
									<div class="netdata-container-easypiechart" style="margin-right: 10px; width: 9%; will-change: transform;" data-netdata="system.ram" data-host="<?php echo $host;?>"
									    data-dimensions="used|buffers|active|wired"
									    data-append-options="percentage"
									    data-chart-library="easypiechart"
									    data-title="Used RAM"
									    data-units="%"
									    data-easypiechart-max-value="100"
									    data-width="11%"
									    data-after="-420"
									    data-points="420"
									    data-colors="#EE9911"
									    role="application">
									</div>
									<div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>"
									    data-dimensions="received"
									    data-chart-library="easypiechart"
									    data-title="Net Inbound"
									    data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.net.mainhead"
									    role="application">
									</div>
									<div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>"
									    data-dimensions="sent"
									    data-chart-library="easypiechart"
									    data-title="Net
									    Outbound" data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.net.mainhead"
									    role="application">
									</div>

	            </div>
						          </div>
	                           </div>
	                        </div>
                          </div>
                        </div>
                      </div>
									<?php
										}
										else
										{
											?>

											 <div class="card mb-0">
								                        <div class="card-header" id="headingTwo" role="tab">
								                          <h5 class="mb-0">
								                            <a class="collapsed" data-toggle="collapse" href="#encoder_accordion_<?php echo $encode['id'];?>" aria-expanded="false" aria-controls="collapseTwo"><?php echo $encode['encoder_name'];?></a>
								                          </h5>
								                        </div>
								                        <div class="collapse" id="encoder_accordion_<?php echo $encode['id'];?>" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
								                          <div class="card-body"><h1>No Data Found</h1></div>
								                        </div>
								                      </div>
									<?php
										}
									}
									elseif($encode['status'] == 2)
									{
										?>
										<div class="col-xs-12">
										<div class="box box-solid collapsed-box">
					                     <div class="box-header with-border">
					                        <h3 class="box-title"><?php echo $encode['encoder_name'];?></h3>
					                        <div class="box-tools pull-right">
					                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-plus"></i>
					                           </button>
					                           <button  type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
					                           </button>
					                        </div>
					                     </div>
	                     <!-- /.box-header -->
	                     <div class="box-body" style="display:none;">
	                       <div class="row">
					                           <div class="col-xs-6 col-md-12 text-center">
					                              <h1>No Data Found</h1>
					                           </div>
					                        </div>
	                     </div>
	                  </div>
										</div>
									<?php
									}
								}
							}
							else
							{
							?>
			                        <div class="row">
			                           <div class="col-xs-6 col-md-12 text-center">
			                      	     	<h3>Encoders not added yet!</h3>
			                           </div>
			                        </div>
							<?php
							}
                    	?>
                    	</div>
                  </div>
                </div>
              </div>
              <!-- /.col-->
            </div>
            <!-- /.row-->
            <div class="row">


            	<!-- TEST-->
            	<div class="col">
				   <div class="card">
				      <div class="card-body">
				         <div class="row">
				            <div class="col-sm-2">
				               <h5 class="mb-0 card-title"><button class="btn btn-secondary netdatabutton" style="background: rgb(58, 65, 73) none repeat scroll 0% 0%; border: medium none; color: rgb(115, 129, 143);">System</button></h5>
				            </div>
				            <div class="col-sm-2">
				               <h5 class="mb-0 card-title"><button class="btn btn-secondary netdatabutton" style="background: rgb(58, 65, 73) none repeat scroll 0% 0%; border: medium none; color: rgb(115, 129, 143);">CPUs</button></h5>
				            </div>
				            <div class="col-sm-2">
				               <h5 class="mb-0 card-title"><button class="btn btn-secondary netdatabutton" style="background: rgb(58, 65, 73) none repeat scroll 0% 0%; border: medium none; color: rgb(115, 129, 143);">Memory</button></h5>
				            </div>
				            <div class="col-sm-2">
				               <h5 class="mb-0 card-title"><button class="btn btn-secondary netdatabutton" style="background: rgb(58, 65, 73) none repeat scroll 0% 0%; border: medium none; color: rgb(115, 129, 143);">Disks</button></h5>
				            </div>
				            <div class="col-sm-2">
				               <h5 class="mb-0 card-title"><button class="btn btn-secondary netdatabutton" style="background: rgb(58, 65, 73) none repeat scroll 0% 0%; border: medium none; color: rgb(115, 129, 143);">Networking Stack</button></h5>
				            </div>
				            <div class="col-sm-2">
				               <h5 class="mb-0 card-title"><button class="btn btn-secondary netdatabutton" style="background: rgb(58, 65, 73) none repeat scroll 0% 0%; border: medium none; color: rgb(115, 129, 143);">Services</button></h5>
				            </div>
				         </div>
				      </div>
				      <div style="background: rgb(58, 65, 73) none repeat scroll 0% 0%;" class="card-footer">
				         <div class="text-center row">
				            <div style="width: 100%; max-height: calc(100% - 15px); text-align: center; display: inline-block;">
				               <div id="divsystem" style="width: 100%; height: 100%;" class="">
				                  <div class="dygraph-label dygraph-title" style="position: relative;">Overview of the key system metrics</div>
				                  <div className="netdata-container-easypiechart" style="marginRight:11px;" data-netdata="system.io" data-host="<?php echo $this->config->item('ServerIP');?>:19999"
					               		data-dimensions="in"
									    data-chart-library="easypiechart"
									    data-title="Disk Read"
									    data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.io.mainhead"
									    role="application">
									</div>
									<div className="netdata-container-easypiechart" style="marginRight:11px;" data-netdata="system.io" data-host="<?php echo $this->config->item('ServerIP');?>:19999"
									    data-dimensions="out"
									    data-chart-library="easypiechart"
									    data-title="Disk Write"
									    data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.io.mainhead"
									    role="application">
									</div>
									<div data-netdata="disk_space._"
									data-host="<?php echo $this->config->item('ServerIP');?>:19999"
									    data-decimal-digits="0"
									    data-title="Available Disk"
									    data-dimensions="avail"
									    data-chart-library="easypiechart"
									    data-easypiechart-max-value="100"
									    data-common-max="avail"
									    data-width="11%"
									    data-height="100%"
									    data-after="-420"
									    data-points="420"
									    role="application">
									    </div>
									<div className="netdata-container-gauge" style="marginRight:11px;" data-netdata="system.cpu"  data-host="<?php echo $this->config->item('ServerIP');?>:19999"
									    data-chart-library="gauge"
									    data-title="CPU"
									    data-units="%"
									    data-gauge-max-value="100"
									    data-width="20%"
									    data-after="-420"
									    data-points="420"
									    data-colors="#22AA99"
									    role="application">
									</div>
									<div className="netdata-container-easypiechart" style="marginRight:10px;width:11%;willchange:transform;" data-netdata="system.ram" data-host="http://iohub.tv:19999"
									    data-dimensions="used|buffers|active|wired"
									    data-append-options="percentage"
									    data-chart-library="easypiechart"
									    data-title="Used RAM"
									    data-units="%"
									    data-easypiechart-max-value="100"
									    data-width="11%"
									    data-after="-420"
									    data-points="420"
									    data-colors="#EE9911"
									    role="application">
									</div>
									<div className="netdata-container-easypiechart" style="marginRight:10px;width:11%;willchange:transform;" data-netdata="system.net" data-host="<?php echo $this->config->item('ServerIP');?>:19999"
									    data-dimensions="received"
									    data-chart-library="easypiechart"
									    data-title="Net Inbound"
									    data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.net.mainhead"
									    role="application">
									</div>
									<div className="netdata-container-easypiechart" style="marginRight:10px;width:11%;willchange:transform;" data-netdata="system.net" data-host="<?php echo $this->config->item('ServerIP');?>:19999"
									    data-dimensions="sent"
									    data-chart-library="easypiechart"
									    data-title="Net Outbound" data-width="10%"
									    data-before="0"
									    data-after="-420"
									    data-points="420"
									    data-common-units="system.net.mainhead"
									    role="application">
									</div>
				               </div>
				               <div id="divcpu" style="width: 100%; height: 100%;" class="divcharts hidden">
				                 <div data-host="<?php echo $this->config->item('ServerIP');?>:19999" className="netdata-container-with-legend" id="chart_system_cpu" data-netdata="system.cpu" data-width="100%" data-height="250px" data-dygraph-valuerange="[0, 100]" data-before="0" data-after="-420" data-id="neb-cor-01_system_cpu" data-colors="" data-decimal-digits="-1" role="application" style="width:100%;height:250px;">
						</div>
				               </div>
				               <div id="divmemory" style="width: 100%; height: 100%;" class="divcharts hidden">
				                  <div data-host="<?php echo $this->config->item('ServerIP');?>:19999" className="netdata-container-with-legend" id="chart_system_ram" data-netdata="system.ram" data-width="100%" data-height="250px" data-dygraph-valuerange="[null, null]" data-before="0" data-after="-420" data-id="neb-cor-01_system_ram" data-colors="" data-decimal-digits="-1" role="application" style="width:100%;height:250px;">
						</div>
				               </div>
				               <div id="divdisks" style="width: 100%; height: 100%;" class="divcharts hidden">
				                  <div data-host="<?php echo $this->config->item('ServerIP');?>:19999" className="netdata-container-with-legend" id="chart_system_io" data-netdata="system.io" data-width="100%" data-height="250px" data-dygraph-valuerange="[null, null]" data-before="0" data-after="-420" data-id="neb-cor-01_system_io" data-colors="" data-decimal-digits="-1" role="application" style="width:100%;height:250px;">
						</div>
				               </div>
				               <div id="divnetworkstack" style="width: 100%; height: 100%;" class="divcharts hidden">
				                  <div data-host="<?php echo $this->config->item('ServerIP');?>:19999" className="netdata-container-with-legend" id="chart_system_net" data-netdata="system.net" data-width="100%" data-height="250px" data-dygraph-valuerange="[null, null]" data-before="0" data-after="-420" data-id="neb-cor-01_system_net" data-colors="" data-decimal-digits="-1" role="application" style="width:100%;height:250px;">
						</div>
				               </div>
				               <div id="divservices" style="width: 100%; height: 100%;" class="divcharts hidden">
				                  <div data-host="<?php echo $this->config->item('ServerIP');?>:19999" className="netdata-container-with-legend" id="chart_services_cpu" data-netdata="services.cpu" data-width="100%" data-height="250px" data-dygraph-valuerange="[null, null]" data-before="0" data-after="-420" data-id="neb-cor-01_services_cpu" data-colors="" data-decimal-digits="-1" role="application" style="width:100%;height:250px;">
						</div>
				               </div>
				            </div>
				         </div>
				      </div>
				   </div>
				</div>


            	<!-- TEST -->



            </div>
          </div>
        </div>
      </main>

  <!-- ========= Content Wrapper Start ========= -->


        <!-- ========= Content Wrapper End ========= -->
