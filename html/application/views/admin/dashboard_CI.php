<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<style type="text/css">
	.box{background:#303030;}
	.box-title{color:#6a6c6f;}
	.box-header{border-bottom: 1px solid #6a6c6f;}
	.row{color: #ccc;}
</style>
  <!-- ========= Content Wrapper Start ========= -->
        <section class="content-wrapper db-page" id="main">
            <!-- ========= Main Content Start ========= -->
            <div class="content">
				 <div class="content-container" style="margin-top: -30px;">
            <div class="col-xs-12" style="padding-bottom: 15px;">
                <div class="row">
                    <h1> Main Dashboard </h1>
                    Overview of Production Server
                </div>
            </div>
        </div>
              <div class="content-container">
              	<div class="row">
               <div class="col-xs-12" id="wowza_accordion_production">
                  <!-- Production Information -->
                  <div class="box box-solid">
                     <div class="box-header with-border">
                        <h3 class="box-title">Production</h3>
                        <div class="box-tools pull-right">
                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                           </button>
                           <button type="button" id="production" class="btn btn-default btn-sm wowzashowhide"><i class="fa fa-times"></i>
                           </button>
                        </div>
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="row">
                           <div class="col-xs-6 col-md-12 text-center">

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
                           		<div class="production-box">
                           			<span class="chart" data-percent="<?php echo sizeof($channels);?>">
										<span class="percent"><?php echo sizeof($channels);?></span>
									</span>
									<span>Channels</span>
                           		</div>
                           		<div class="production-box">
                           			<h2><?php echo $liveChannels;?></h2>
                           			<h3>Live<br/>Channels</h3>
                           		</div>
                           		<div class="production-box">
                           			<span class="chart" data-percent="<?php echo sizeof($apps);?>">
										<span class="percent"><?php echo sizeof($apps);?></span>
									</span>
									<span>Applications</span>
                           		</div>
                           		<div class="production-box">
                           			<h2><?php echo sizeof($apps);?></h2>
                           			<h3>Enabled<br/>Applications</h3>
                           		</div>
                           		<div class="production-box">
                           			<span class="chart" data-percent="<?php echo sizeof($targets);?>">
										<span class="percent"><?php echo sizeof($targets);?></span>
									</span>
									<span>Targets</span>
                           		</div>
                           		<div class="production-box">
                           			<h2><?php echo $liveTargets;?></h2>
                           			<h3>Online<br/>Targets</h3>
                           		</div>
                           		<div class="production-box">
                           			<span class="chart" data-percent="0">
										<span class="percent">0</span>
									</span>
									<span>Playlists</span>
                           		</div>
                           		<div class="production-box">
                           			<h2>0</h2>
                           			<h3>Running<br/>Playlist</h3>
                           		</div>
                           		<div class="production-box">
                           			<span class="chart" data-percent="0">
										<span class="percent">0</span>
									</span>
									<span>Events</span>
                           		</div>
              					<div class="production-box">
                           			<h2>0</h2>
                           			<h3>Scheduled<br/>Events</h3>
                           		</div>


                           </div>
                     </div>
                  </div>
               </div>
            </div>
            </div>
              </div>
              <?php
              $userdata = $userdata = $this->session->userdata('user_data');
              if($userdata['user_type'] == 1)
              {
			  	?>
			  	 <div class="content-container">
              	<div class="row">
              		<div class="col-xs-12" style="padding-bottom: 15px;" id="wowza_accordion_hosting">
              			<div class="box box-solid collapsed-box">
                     <div class="box-header with-border">
                        <h3 class="box-title">Hosting</h3>
                        <div class="box-tools pull-right">
                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-plus"></i>
                           </button>
                           <button type="button" id="hosting" class="btn btn-default btn-sm wowzashowhide"><i class="fa fa-times"></i>
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
              	</div>
              </div>
              <div class="content-container">
              		<div class="row">
	              		<div class="col-xs-12" id="wowza_accordion_network">
	              			<div class="box box-solid collapsed-box">
                     <div class="box-header with-border">
                        <h3 class="box-title">Network</h3>
                        <div class="box-tools pull-right">
                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-plus"></i>
                           </button>
                           <button type="button" id="network" class="btn btn-default btn-sm wowzashowhide"><i class="fa fa-times"></i>
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
              		</div>
              	</div>
			  	<?php
			  }
              ?>



					 <div class="content-container" style="margin-top: -30px;">
            <div class="col-xs-12" style="padding-bottom: 15px;">
                <div class="row">
                    <h1> System Resources </h1>

                   Overview of the system resources e.g encoders & publisher<br><br>
                    <a class="add-btn" id="add_wowza" href="<?php echo site_url();?>createwowza" style="float:left;margin:0;">
                                    <span><i class="fa fa-plus"></i> Publisher</span>
								</a>
                </div>
            </div>
        </div>

               <div class="content-container">
                    <div class="row">
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
							?>
								  <div class="box-body">
			                        <div class="row">
			                           <div class="col-xs-6 col-md-12 text-center">
			                      	     	<h3>Publishers not added yet!</h3>
			                           </div>
			                        </div>
                           		  </div>

							<?php
							}
                    		?>
                    </div>
               </div>
                <div class="content-container">
                	<div class="col-xs-12" style="padding-bottom: 15px;">
                		<div class="row">
                			 <a href="<?php echo site_url();?>addEncoderes" class="add-btn" style="float:left;margin:0;">
		                    <span><i class="fa fa-plus"></i> Encoder</span>
		                </a>
                		</div>
                	</div>
                    <div class="row">

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
										<div class="col-xs-12" id="wowza_accordion_<?php echo $encode['id'];?>">
										<div class="box box-solid collapsed-box">
					                     <div class="box-header with-border">
					                        <h3 class="box-title"><?php echo $encode['encoder_name'];?></h3>
					                        <div class="box-tools pull-right">
					                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-plus"></i>
					                           </button>
					                           <button  type="button" id="<?php echo $encode['id'];?>" class="btn btn-default btn-sm wowzashowhide"><i class="fa fa-times"></i>
					                           </button>
					                        </div>
					                     </div>
	                     <!-- /.box-header -->
	                     <div class="box-body" style="display:none;">
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
								<div class="box-body">
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
            <!-- ========= Main Content End ========= -->
        </section>
        <span class="sidelink" onclick="openNav()">&#9776;</span>
 <div id="mySidenav" class="sidenav">
 <span class="sidelinkheader" onclick="openNav()">&#9776;</span>
  <!--<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>-->
  	<ul id="resourcesUL">
  		<h3>Production Server</h3>
      <li id="liwowza_production" class="lirightside"><input type="checkbox" checked="true"/> <span>Production</span></li>
      <h3>Network Server</h3>
      <li id="liwowza_network" class="lirightside"><input type="checkbox" checked="true"/> <span>Network</span></li>
      <h3>Hosting</h3>
      <li id="liwowza_hosting" class="lirightside"><input type="checkbox" checked="true"/> <span>Hosting</span></li>
  		<h3>System Resources</h3>
  			<h4>Wowza</h4>
  		<?php
  		if(sizeof($wowza)>0)
	    {
			foreach($wowza as $wowa)
			{
				?>
				<li id="liwowza_<?php echo $wowa['id'];?>" class="lirightside"><input type="checkbox" checked="true"/> <span><?php echo $wowa['wse_instance_name'];?></span></li>
				<?php
			}
		}
		else
		{
			?>
			<h4>0 Wowza</h4>
			<?php
		}
  		?>
  			<h4>Encoders</h4>
  		<?php
  		if(sizeof($encoders)>0)
	    {
			foreach($encoders as $encode)
			{
				?>
				<li id="liwowza_<?php echo $encode['id'];?>" class="lirightside" class="lirightside"><input type="checkbox" checked="true"/> <span><?php echo $encode['encoder_name'];?></span></li>
				<?php
			}
		}
		else
		{
			?>
			<h4>0 Encoders</h4>
			<?php
		}
  		?>
  	</ul>
</div>

        <!-- ========= Content Wrapper End ========= -->
