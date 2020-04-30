<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo site_url();?>">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>applications">Apps</a></li>
        <li class="breadcrumb-item active"><?php echo $application[0]['application_name'];?></li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
             <form class="form-only form-one" method="post" action="<?php echo site_url();?>admin/updateApplication/<?php echo $this->uri->segment(2);?>" enctype="multipart/form-data">
             <div class="card-header">Edit Application</div>
				<div class="card-body">
				<?php if($this->session->flashdata('success')){ ?>
					<div class="alert alert-success">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php }else if($this->session->flashdata('error')){  ?>
					<div class="alert alert-danger">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
					</div>
					<?php }else if($this->session->flashdata('warning')){  ?>
					<div class="alert alert-warning">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
					</div>
					<?php }else if($this->session->flashdata('info')){  ?>
					<div class="alert alert-info">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Info!</strong> <?php echo $this->session->flashdata('info'); ?>
					</div>
				<?php } ?>
				  <div class="row">
                     <div class="col-lg-12 wowza-form" id="wowza_form">
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                      <div class="wowza-form col-lg-12 conf " id="wowza_form ">
			</div>
                               <div class="row">
                               	  <div class="col-lg-6 col-md-12">
                                    <div class="form-group col-lg-12">
                                       <div class="row">
                                          <label>Application Name <span class="mndtry">*</span></label>
                                          <input type="text" class="form-control" placeholder="" name="application_name" id="application_name" required="true" value="<?php echo $application[0]['application_name'];?>"readonly="true">
                                       </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                       <div class="row">
                                          <label>Live Source <span class="mndtry">*</span></label>
                                          <select id="live_source" name="live_source" class="form-control selectpicker" onchange="showAddress(this.value);" required="true">
                                             <option value="0">-- Select --</option>
                                             <?php

                                                if(sizeof($wowzaz)>0)
                                                {
                                                	foreach($wowzaz as $wowza)
                                                	{
                                                		if($application[0]['live_source'] == $wowza['id'])
                                                		{
															echo '<option selected="selected" value="'.$wowza['id'].'">'.$wowza['wse_instance_name'].'</option>';
														}
														else
														{
														echo '<option value="'.$wowza['id'].'">'.$wowza['wse_instance_name'].'</option>';
														}
                                                	}
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group col-lg-12">

                                       <div class="row">
                                       <?php
                                       $path = $application[0]['wowza_path'];
                                       $path = str_replace("http","rtmp",$path);
                                       ?>
                                          <input type="text" readonly="true" class="form-control" name="wowza_path" id="block" value="<?php echo $path;?>"<i type="button" class="fa fa-edit btn btedit" onclick="enableAppEdit();"></i></input>
                                       </div>
                                    </div>

                                    <div class="form-group col-lg-12" style="padding: 0;">
                                    <div class="box box-info">
                                        <div class="box-header">
                                            <h3 class="box-title" style="color: #fff;">Incoming Streams</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>

                                            </div>
                                        </div>
                                        <!-- /.box-header -->

										<div class="box-body" style="">
										   <div class="table-responsive">

										      <table class="table no-margin">
										         <tbody>
										         	  	 <?php
										         	  	 $status ="";

					                                        if(sizeof($incomingStreams)> 0)
					                                        {
																if($incomingStreamsCount > 1)
																{
																	foreach($incomingStreams['InstanceList']['IncomingStreams']['IncomingStream'] as $key=>$value)
																	{
																		?>
																		<tr>
															               <td><a href=""><?php echo $value['Name'];?></a></td>
															               <td class="status">
															               	<?php
															               		if($value['IsConnected'] == 'true' && $value['IsRecordingSet'] == 'false')
															               		{
															               			$status = "active";
																					echo '<span id="status" class="label label-success">Active</span>';
																				}
																				if($value['IsConnected'] == 'true' && $value['IsRecordingSet'] == 'true')
															               		{
																					if($recordersCount > 1)
																					{
																						foreach($incomingStreams['InstanceList']['Recorders']['StreamRecorder'] as $rkey=>$rvalue)
																						{
																							if($rvalue['RecorderName']==$value['Name']){
																								if($rvalue['RecorderState'] == "Recording in Progress"){
																									$status = "Recording";
																									echo '<span id="status" class="label label-danger">Recording</span>';
																								}
																								else if($rvalue['RecorderState'] == "Waiting for Stream"){

							$status = "Waiting";																		echo '<span id="status" class="label label-danger">Waiting</span>';
																								}
																							}
																						}
																					}
																					else
																					{
																						if($recordersCount == 1)
																						{
																							$rvalue = $incomingStreams['InstanceList']['Recorders']['StreamRecorder'];
																						if($rvalue['RecorderName']==$value['Name']){
																								if($rvalue['RecorderState'] == "Recording in Progress"){
																									$status = "Recording";
																									echo '<span id="status" class="label label-danger">Recording</span>';
																								}
																								else if($rvalue['RecorderState'] == "Waiting for Stream"){
																									$status = "Waiting";
																									echo '<span id="status" class="label label-danger">Waiting</span>';
																								}
																							}
																						}

																					}
																				}
															               	?>
															               </td>
															               <?php
															               switch($status)
															               {
																		   		case "active":
																		   		$wowza = $this->common_model->getWovzData($application[0]['live_source']);
										                                       $pathinfo = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$application[0]['application_name'].'/'.$value['Name'];
                                                           $startrecurl = 'http://'.$wowza[0]['ip_address'].':8086/livestreamrecord?app='.$application[0]['application_name'].'&streamname='.$value['Name'].'&action=startRecording&outputPath='.$wowza[0]['vod_directory'];
                                                           $stoprecurl = 'http://'.$wowza[0]['ip_address'].':8086/livestreamrecord?app='.$application[0]['application_name'].'&streamname='.$value['Name'].'&action=stopRecording';
																		   		?>
																		   		<td><a class="recordstream" data-toggle="tooltip" title="Record Stream" data-placement="bottom" href="javascript:void(0);" startrecurl="<?php echo $startrecurl;?>" stoprecurl="<?php echo $stoprecurl;?>"><i class="fa fa-circle fa-2x" style="color:red;"></i><a class="plapp" data-toggle="tooltip" title="Preview" data-placement="bottom" href="javascript:void(0);" aria-label="<?php echo $pathinfo;?>"><i class="fa fa-play fa-2x" style="padding-left:12px;"></i></a></td>
																               <td>
																                  <div class=" pull-right">
																                     <button type="button" class="btn btn-box-tool appstat" id="<?php echo $application[0]['id'];?>_<?php echo $value['Name'];?>">
																                     <i class="fa fa-plus"></i>
																                     </button>
																                  </div>
																               </td>
																		   		<?php
																		   		break;
																		   		case "Recording": case "Waiting":
																		   		$wowza = $this->common_model->getWovzData($application[0]['live_source']);
										                                       $pathinfo = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$application[0]['application_name'].'/'.$value['Name'];
                                                           $startrecurl = 'http://'.$wowza[0]['ip_address'].':8086/livestreamrecord?app='.$application[0]['application_name'].'&streamname='.$value['Name'].'&action=startRecording&outputPath='.$wowza[0]['vod_directory'];
                                                           $stoprecurl = 'http://'.$wowza[0]['ip_address'].':8086/livestreamrecord?app='.$application[0]['application_name'].'&streamname='.$value['Name'].'&action=stopRecording';
																		   		?>
																		   		 <td><a class="recordstream" data-toggle="tooltip" title="Stop Recoding" data-placement="bottom" href="javascript:void(0);" startrecurl="<?php echo $startrecurl;?>" stoprecurl="<?php echo $stoprecurl;?>"><i class="fa fa-stop fa-2x" style="color:red;"></i><a class="plapp" data-toggle="tooltip" title="Preview" data-placement="bottom" href="javascript:void(0);" aria-label="<?php echo $pathinfo;?>"><i class="fa fa-play fa-2x" style="padding-left: 12px;"></i></a></td>
										               <td>
										                  <div class="box-tools pull-right">
										                     <button type="button" class="btn appstat" id="<?php echo $application[0]['id'];?>_<?php echo $value['Name'];?>">
										                     <i class="fa fa-plus"></i>
										                     </button>
										                  </div>
										               </td>
																		   		<?php
																		   		break;
																		   }
															               ?>

															            </tr>
															          	<tr>
															            	<td colspan="5" style="padding:0;">
															            	 <div class="app_stat">
															            	 <?php
										                                       $wowza = $this->common_model->getWovzData($application[0]['live_source']);
										                                       $pathinfo = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$application[0]['application_name'].'/'.$value['Name'];
										                                       ?>
															            	 <input class="pathinfo" type="hidden" value="<?php echo $pathinfo;?>"/>
															            	 <h4>Connections Per Protocol <span>outgoing  <button type="button" class="btn appstatrefresh btnrfr" id="<?php echo $application[0]['id'];?>_<?php echo $value['Name'];?>">
										                     <i class="fa fa-refresh"></i>
										                     </button></span> </h4>
															               <table class="table no-margin" style="width:30%;float: left;">
										         							<tbody>
										         							</tbody>
										         							</table>
										         							<div id="charts_<?php echo $value['Name']; ?>" style="width:30%;float: left;padding:5px;height:250px;"></div>
										         							<div style="padding:5px;">
										         								<h4>Stream Uptime</h4>
										         								<div class="form-group">
										         									<p class="streamname"></p>
										         								</div>
										         								<div class="form-group">
										         									<p class="streamuptime"></p>
										         								</div>
										         								<h4>Network Throughput</h4>
										         								<div class="form-group">
										         									<p class="bytesIn" style="display: inline-block;padding-right: 5px;"></p><i class="fa fa-arrow-circle-down" style="color: #00a65a;"></i>
										         								</div>
										         								<div class="form-group">
										         									<p class="bytesOut" style="display: inline-block;padding-right: 5px;"></p><i class="fa fa-arrow-circle-up" style="color: #FF9800;"></i>
										         								</div>
										         							</div>
															               </div>
																			</td>
															            </tr>

																		<?php
																	}
																}
																else
																{

																	$value = $incomingStreams['InstanceList']['IncomingStreams']['IncomingStream'];
																	?>
																		<tr>
															               <td><a href=""><?php echo $value['Name'];?></a></td>
															               <td class="status">
															               	<?php

															               		if($value['IsConnected'] == 'true' && $value['IsRecordingSet'] == 'false')
															               		{
															               			$status = "active";
																					echo '<span id="status" class="label label-success">Active</span>';
																				}
																				if($value['IsConnected'] == 'true' && $value['IsRecordingSet'] == 'true')
															               		{
																					if($recordersCount > 1)
																					{
																						foreach($incomingStreams['InstanceList']['Recorders']['StreamRecorder'] as $rkey=>$rvalue)
																						{
																							if($rvalue['RecorderName']==$value['Name']){
																								if($rvalue['RecorderState'] == "Recording in Progress"){

					$status = "Recording";																				echo '<span id="status" class="label label-danger">Recording</span>';
																								}
																								else if($rvalue['RecorderState'] == "Waiting for Stream"){
																									$status = "Waiting";
																									echo '<span id="status" class="label label-danger">Waiting</span>';
																								}
																							}
																						}
																					}
																					else
																					{
																						if($recordersCount == 1)
																						{
																							$rvalue = $incomingStreams['InstanceList']['Recorders']['StreamRecorder'];
																							if($rvalue['RecorderName']==$value['Name']){
																									if($rvalue['RecorderState'] == "Recording in Progress"){
																										$status = "Recording";
																										echo '<span id="status" class="label label-danger">Recording</span>';
																									}
																									else if($rvalue['RecorderState'] == "Waiting for Stream"){
																										$status = "Waiting";
																										echo '<span id="status" class="label label-danger">Waiting</span>';
																									}
																								}
																						}
																					}
																				}
															               	?>
															               </td>
															               <?php
															               switch($status)
															               {
																		   		case "active":

										                                       $wowza = $this->common_model->getWovzData($application[0]['live_source']);
										                                       $pathinfo = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$application[0]['application_name'].'/'.$value['Name'];
                                                           $startrecurl = 'http://'.$wowza[0]['ip_address'].':8086/livestreamrecord?app='.$application[0]['application_name'].'&streamname='.$value['Name'].'&action=startRecording&outputPath='.$wowza[0]['vod_directory'];
                                                           $stoprecurl = 'http://'.$wowza[0]['ip_address'].':8086/livestreamrecord?app='.$application[0]['application_name'].'&streamname='.$value['Name'].'&action=stopRecording';
										                                       ?>

																		   		<td><a class="recordstream" data-toggle="tooltip" title="Record Stream" data-placement="bottom" href="javascript:void(0);" startrecurl="<?php echo $startrecurl;?>" stoprecurl="<?php echo $stoprecurl;?>"><i class="fa fa-circle fa-2x" style="color:red;"></i><a class="plapp" data-toggle="tooltip" title="Preview" data-placement="bottom" href="javascript:void(0);" aria-label="<?php echo $pathinfo;?>"><i class="fa fa-play fa-2x" style="padding-left: 12px;"></i></a></td>
																               <td>
																                  <div class="box-tools pull-right">
																                     <button type="button" class="btn btn-box-tool appstat" id="<?php echo $application[0]['id'];?>_<?php echo $value['Name'];?>">
																                     <i class="fa fa-plus"></i>
																                     </button>
																                  </div>
																               </td>
																		   		<?php
																		   		break;
																		   		case "Recording": case "Waiting":
																		   		$wowza = $this->common_model->getWovzData($application[0]['live_source']);
										                                       $pathinfo = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$application[0]['application_name'].'/'.$value['Name'];
                                                           $startrecurl = 'http://'.$wowza[0]['ip_address'].':8086/livestreamrecord?app='.$application[0]['application_name'].'&streamname='.$value['Name'].'&action=startRecording&outputPath='.$wowza[0]['vod_directory'];
                                                           $stoprecurl = 'http://'.$wowza[0]['ip_address'].':8086/livestreamrecord?app='.$application[0]['application_name'].'&streamname='.$value['Name'].'&action=stopRecording';
																		   		?>
																		   		 <td>
																		   		 <td><a class="recordstream" data-toggle="tooltip" title="Stop Recording" data-placement="bottom" href="javascript:void(0);" startrecurl="<?php echo $startrecurl;?>" stoprecurl="<?php echo $stoprecurl;?>"><i class="fa fa-stop fa-2x" style="color:red;"></i><a class="plapp" data-toggle="tooltip" title="Preview" data-placement="bottom" href="javascript:void(0);" aria-label="<?php echo $pathinfo;?>"><i class="fa fa-play fa-2x" style="padding-left: 12px;"></i></a>
																		   		 </td>
																               <td>
																                  <div class="box-tools pull-right">

																                     <button type="button" class="btn  appstat"  id="<?php echo $application[0]['id'];?>_<?php echo $value['Name'];?>">
																                     <i class="fa fa-plus"></i>
																                     </button>
																                  </div>
																               </td>
																		   		<?php
																		   		break;
																		   }
															               ?>

															            </tr>
															            <tr>
															            	<td colspan="5" style="padding:0;">
															            	 <div class="app_stat">


															            	 <h4>Connections Per Protocol <span>outgoing  <button type="button" class="btn appstatrefresh btnrfr" id="<?php echo $application[0]['id'];?>_<?php echo $value['Name'];?>">
										                     <i class="fa fa-refresh"></i>
										                     </button> </span>  </h4>
															               <table class="table no-margin" style="width:30%;float: left;">
										         							<tbody>
										         							</tbody>
										         							</table>
										         							<div id="charts_<?php echo $value['Name']; ?>" style="width:30%;float: left;padding:5px;height:250px;"></div>
                                          <div style="padding:5px;">
  										         								<h4>Stream Uptime</h4>
  										         								<div class="form-group">
  										         									<p class="streamname"></p>
  										         								</div>
  										         								<div class="form-group">
  										         									<p class="streamuptime"></p>
  										         								</div>
  										         								<h4>Network Throughput</h4>
  										         								<div class="form-group">
  										         									<p class="bytesIn" style="display: inline-block;padding-right: 5px;"></p><i class="fa fa-arrow-circle-down" style="color: #00a65a;"></i>
  										         								</div>
  										         								<div class="form-group">
  										         									<p class="bytesOut" style="display: inline-block;padding-right: 5px;"></p><i class="fa fa-arrow-circle-up" style="color: #FF9800;"></i>
										         								</div>
										         							</div>
															               </div>
																			</td>
															            </tr>

																		<?php
																}
															}
															else
															{
																?>
																<tr>
																	<td colspan="5">
<p style="color: #fff;">No incoming streams are available for this application. Click Refresh to update status.</p></td>
																</tr>
																<?php
															}
					                                        ?>


										         </tbody>
										      </table>
										   </div>
										   <!-- /.table-responsive -->
										</div>


                                        <!-- /.box-body -->

                                        <!-- /.box-footer -->
                                    </div>
                                    </div>


                                 </div>
                             <div class="col-lg-6">

                                 <div id="player-container" style="border:1px solid #fff;height:270px;width:480px;" class="pull-right">
										<div  style="width:480px;height:270px;" id="player_apps" title="<?php echo $application[0]['wowza_path'];?>"></div>
										<div id="player-tip"></div>
									</div>


                             </div>
                               </div>

                             <div class="col-lg-6 text-center pull-right" style="margin-top:20px;">
								<button type="button" id="playappp" class="btn btn-sm btn-success"><i class="fa fa-play"></i> Play</button>
							</div>
                     </div>
                  </div>
				</div>
        <div class="card-footer">
          <button class="btn btn-sm btn-primary" type="submit">Update</button>
            <button class="btn btn-sm btn-danger" type="reset">Reset</button>
            </div>
            </form>
			</div>
		</div>
	</div>
</main>
