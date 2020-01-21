<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>

<script type="text/javascript">
	var channelLocks = [];
</script>
<?php
if(sizeof($channelsLock)>0)
{
	foreach($channelsLock as $key=>$chanl)
	{
		if($chanl == NULL)
		{
			echo '<script type="text/javascript">channelLocks['.$key.']=0;</script>';
		}
		else
		{
			echo '<script type="text/javascript">channelLocks['.$key.']='.$chanl.';</script>';
		}
	}
}

?>
<style type="text/css">
	.clr{
		color:#747474;
	}

	#create_channel_group .config-container {

		width: 100%;
		margin: 0 auto;
		padding: 0;

	}
	#create_channel_group .content-box {
		width: 100%;
		margin: auto;
		margin-bottom: auto;
		padding: 20px;
		min-height: 100px;
		background-color: #2f353a;
		display: flex;
		color: #fff !important;
		border-radius: 10px;
		text-align: center;
	}
</style>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Channels</li>
        </ol>
        <div class="container-fluid">
        <div class="animated fadeIn">
        	<div class="card">
        		<div class="card-body">
        			<?php if($this->session->flashdata('success')){ ?>
					<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					 <?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php }else if($this->session->flashdata('error')){  ?>
					<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					 <?php echo $this->session->flashdata('error'); ?>
					</div>
					<?php }else if($this->session->flashdata('warning')){  ?>
					<div class="alert alert-warning">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					 <?php echo $this->session->flashdata('warning'); ?>
					</div>
					<?php }else if($this->session->flashdata('info')){  ?>
					<div class="alert alert-info">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					 <?php echo $this->session->flashdata('info'); ?>
					</div>
				<?php } ?>
					<div class="row">
                        <!-- ========= Section One Start ========= -->
                        <div class="col-lg-12 col-12-12">
                            <div class="content-box config-contentonly">
                                <div class="config-container">
                                    <!-- === Nav tabs === -->
                                        <ul class="nav nav-tabs channeltabs" role="tablist">
                                            <li class="nav-item" role="presentation" class="active">
                                            	<a class="nav-link active" href="#Channels" aria-controls="channels" role="tab" data-toggle="tab">Channels</a></li>
                                          <?php
										  if (sizeof($channelTabs)>0) {
											  foreach ($channelTabs as $tab){
											  	?>
												<li class="nav-item" role="presentation">
											<a class="nav-link" href="#channelgid_<?php echo $tab['id'] ?>" aria-controls="channelgid_<?php echo $tab['id'] ?>" role="tab" data-toggle="tab"><?php echo $tab['groupname'] ?></a></li>
											  	<?php
											  }
										  }
                                          ?>  	
                                          <li  class="nav-item" role="presentation" >
											<a class="nav-link createChannelGroup" href="javascript:void(0);" aria-controls="channels" role="tab" data-toggle="tab">+</a></li>
                                        </ul>


                                    <!-- === Tab panes === -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="Channels">
                                        	<div class="card-body">
                                        		<div class="row">
            										<div class="col-12" style="padding: 0;">
									                <div class="box-header">
									                    <!-- Single button -->
									                    <div class="btn-group">

																<select class="form-control actionsel" id="actionChannels">
																	<option value="0">Action</option>
																	<option value="Lock">Lock</option>
																	<option value="UnLock">Un-Lock</option>
																	<option value="Restart">Restart</option>
																	<option value ="Archive">Archive</option>
																	<option value="Delete">Delete</option>
																</select>

									                    </div>
									                    <!-- Standard button -->
									                    <button type="button" class="btn btn-primary submit" onclick="submitChannels();">Submit</button>
									                    <a href="<?php echo site_url();?>createchannel" class="add-btn btn btn-primary float-right">
									                        <span><i class="fa fa-plus"></i> Channel</span>
									                    </a>
									                </div>
                <br/>
                    <div class="table-responsive no-padding">
                        <table  class="table table-hover check-input cstmtable channeltable channelTable">
                            <tr>
                                <th width="60px">
                                    <div class="boxes">
                                        <input type="checkbox" id="allChannels" >
                                        <label for="allChannels"></label>
                                    </div>
                                </th>
                                <th width="40px">ID</th>
                                <th width="300px">Channel Name</th>
                                <th width="260px">Input</th>
                                <th width="260px">Output</th>
                                <th>Status</th>
                                <th width="150px"> &nbsp; </th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>

                            </tr>
                            <?php
                            $counter=1;
                           if(sizeof($channels)>0)
                           {
							
																
						   	foreach($channels as $channel)
						   	{
						   		
								?>
								<tr id="row_<?php echo $channel['id'];?>">
                                <td>
                                    <div class="boxes">
                                        <input type="checkbox" id="channel_<?php echo $channel['id'];?>" class="channelActions">
                                        <label for="channel_<?php echo $channel['id'];?>"></label>
                                    </div>
                                </td>
                            	<td><?php echo $counter;?></td>
                                <td><a class="channels_status" onclick="openEditPage('<?php echo site_url();?>updatechannel/<?php echo $channel['id'];?>',this);" href="javascript:void(0);"><?php echo $channel['channel_name'];?></a></td>
                                <td>


                                <?php

                                $channelInput = $channel['channelInput'];
                                 $channelInputid=explode("_",$channelInput);
                                 switch($channelInputid[0])
                                 {
								 	case "phyinput":
								 		$id = $channel['encoder_id'];
								 		$encoder = $this->common_model->getAllEncoders($id,0);
								 		if(sizeof($encoder) > 0)
								 		{
								 			$input = $this->common_model->getEncoderInpOutbyEncid($encoder[0]['id']);
											if(sizeof($input)>0)
											{
												foreach($input as $inp)
												{
													$inputname = $inp['inp_source'];
													$inpname =  $inp['inp_name'];
													if($inputname == $channelInputid[1])
													{
														echo '<label class="label label-input lblinputtext">'.$encoder[0]['encoder_name'].'</label> <label class="label label-input lblinputtext">'. $inpname.'</label>';
													}
												}
											}
											else
											{
												echo '<label class="label label-input lblinputtext">'.$encoder[0]['encoder_name'].'</label> <label class="label label-input lblinputtext">'. $channelInputid[1].'</label>';
											}

										}
										else
										{
											echo "NA";
										}

								 	break;
								 	case "virinput":
								 		$virInput = $this->common_model->channelInput($channelInputid[1]);
								 		$encoderInput = $this->common_model->getEncoderInputbyId($channelInputid[1]);
								 		$id = $channel['encoderid'];
								 		$encoder = $this->common_model->getAllEncoders($id,0);
								 		echo '<label class="label label-input lblinputtext">'.$encoder[0]['encoder_name'].'</label>';
								 		switch($channelInputid[1])
								 		{
											case 3:
											echo '<label class="label label-input lblinputtext">'.$virInput[0]['item'].'</label> ';
											echo  '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['channel_ndi_source'].'</span>';
											break;
											case 4:
											echo '<label class="label label-input lblinputtext">'.$virInput[0]['item'].'</label> ';
											echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['input_rtmp_url'].'</span> ';
											break;
											case 5:
											echo '<label class="label label-input lblinputtext">RTP</label> ';
											echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['input_mpeg_rtp'].'</span> ';
											break;
											case 6:
											echo '<label class="label label-input lblinputtext">UDP</label> ';
											echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['input_mpeg_udp'].'</span> ';
											break;
											case 7:
											echo '<label class="label label-input lblinputtext">SRT</label> ';
											echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['input_mpeg_srt'].'</span> ';
											break;
											case 8:
											echo '<label class="label label-input lblinputtext">HLS</label> ';
											echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.substr($channel['input_hls_url'],0,50).'...</span> ';
										}

								 	break;
								 }
                                  ?></td>
                                <td><?php $channelOutpue= $channel['channelOutpue'];
                                $channelOutpueid=explode("_",$channelOutpue);

                                 switch($channelOutpueid[0])
                                 {
								 	case "phyoutput":
								 		$id = $channel['encoder_id'];
								 		$encoder = $this->common_model->getAllEncoders($id,0);
								 		//$encoderOutput = $this->common_model->getOutputName($channelOutpueid[1]);
								 		if(sizeof($encoder)>0)
								 		{
								 			$outputs = $this->common_model->getEncoderOutbyEncid($encoder[0]['id']);
											if(sizeof($outputs)>0)
											{
												foreach($outputs as $out)
												{
													$outputname = $out['out_destination'];
													$outname = $out['out_name'];
													if($channelOutpueid[1] == $out['out_destination'])
													{
														//echo '<label class="label label-output lbloutputtext">'.$encoder[0]['encoder_name'].'</label> <label class="label label-output lbloutputtext">'. $outname.'</label>';
														echo '<label class="label label-output lbloutputtext">'. $outname.'</label>';
													}
												}
											}
											else
											{
												//echo '<label class="label label-output lbloutputtext">'.$encoder[0]['encoder_name'].'</label> <label class="label label-output lbloutputtext">'. $channelOutpueid[1].'</label>';
												echo ' <label class="label label-output lbloutputtext">'. $channelOutpueid[1].'</label>';
											}
										}
										else{
											echo "NA";
										}

								 	break;
								 	case "viroutput":
								 		$virOutput = $this->common_model->channelOutput($channelOutpueid[1]);
								 		switch($channelOutpueid[1])
								 		{
											case 3:
											if($channel['is_record_channel'] == 1 && $channel['record_file'] != "")
											{
												echo '<label class="label label-output lbloutputtext">'.$virOutput[0]['item'].'</label> <label class="label label-output lblrecordtext">File</label> ';
												echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['ndi_name'].'</span>   <span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" class="copyrecordfile">./recordings/'.$channel['record_file'].'</span>';
											}
											else
											{
												echo '<label class="label label-output lbloutputtext">'.$virOutput[0]['item'].'</label> ';
												echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['ndi_name'].'</span>  ';
											}


											break;
											case 4:
											if($channel['is_record_channel'] == 1 && $channel['record_file'] != "")
											{
												echo '<label class="label label-output lbloutputtext">'.$virOutput[0]['item'].'</label> <label class="label label-output lblrecordtext">File</label> ';
												echo ' <span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_rtmp_url'].'/'.$channel['output_rtmp_key'].'</span>   <span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" class="copyrecordfile">./recordings/'.$channel['record_file'].'</span>';
										}
											else
											{
												echo '<label class="label label-output lbloutputtext">'.$virOutput[0]['item'].'</label>  ';
												echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_rtmp_url'].'/'.$channel['output_rtmp_key'].'</span> ';
											}

											break;
											case 5:
											if($channel['is_record_channel'] == 1 && $channel['record_file'] != "")
											{
												echo '<label class="label label-output lbloutputtext">RTP</label> <label class="label label-output lblrecordtext">File</label> ';
												echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_rtp'].'</span>   <span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" class="copyrecordfile">./recordings/'.$channel['record_file'].'</span>';
											}
											else
											{
												echo '<label class="label label-output lbloutputtext">RTP</label>  ';
												echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_rtp'].'</span> ';
											}

											break;
											case 6:
											if($channel['is_record_channel'] == 1 && $channel['record_file'] != "")
											{
												echo '<label class="label label-output lbloutputtext">UDP</label> <label class="label label-output lblrecordtext">File</label> ';
												echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_udp'].'</span>   <span class="copyrecordfile" data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true">./recordings/'.$channel['record_file'].'</span>';
											}
											else
											{
												echo '<label class="label label-output lbloutputtext">UDP</label>  ';
												echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_udp'].'</span> ';
											}

											break;
											case 7:
											if($channel['is_record_channel'] == 1 && $channel['record_file'] != "")
											{
												echo '<label class="label label-output lbloutputtext">SRT</label> <label class="label label-output lblrecordtext">File</label> ';
												echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_srt'].'</span>   <span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" class="copyrecordfile">./recordings/'.$channel['record_file'].'</span>';
											}
											else
											{
												echo '<label class="label label-output lbloutputtext">SRT</label> ';
												echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_srt'].'</span> ';
											}

											break;
										}

								 	break;} ?></td>

                                <td>
                                <?php
                                	if($channel['channel_status'] == 0)
                                	{
										?>
										 <span id="status" class="label label-gray">Offline</span>
										<?php
									}
									elseif($channel['channel_status'] == 1)
                                	{
										?>
										 <span id="status" class="label label-live">Online</span>
										<?php
									}
                                ?>
                               </td>
                                <td>
                               <?php
                               if($channel['uptime'] !="" && $channel['uptime'] !="00:00:00")
                               {
                               	$d = date('Y-m-d\TH:i:sP',strtotime($channel['uptime']));
							   	?>
							   	<p class="counter" title="<?php echo $d;?>"></p>
							   	<?php
							   }
							   else
							   {
							   	?>
							   	<p class="counter clr" title="">00:00:00</p>
							   	<?php
							   }
                               ?>

                                </td>
                                <td><a data-container="body" id="ss_<?php echo $channel['id'];?>" data-toggle="tooltip" title="Refresh" data-placement="bottom" data-html="true" class="refreshchannelsStatus" href="javascript:void(0);"><i class="fa fa-refresh"></i></a></td>
                                <td><a data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id'];?>" class="channelscopy" href="javascript:void(0);"><i class="fa fa-copy"></i></a></td>
                                <td>
                                <?php
                                	if($channel['channel_status'] == 0)
                                	{
										?>
										 <a data-container="body" data-toggle="tooltip" title="Start/Stop" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id'];?>" class="channelsstartstop" href="javascript:void(0);"><i class="fa fa-play"></i></a>
										<?php
									}
									elseif($channel['channel_status'] == 1)
                                	{
										?>
										 <a data-container="body" data-toggle="tooltip" title="Start/Stop" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id'];?>" class="channelsstartstop" href="javascript:void(0);"><i class="fa fa-pause"></i></a>
										<?php
									}
                                ?>
                                </td>
                                <td>
                                	<?php
                                	if($channel['isLocked'] == 0)
                                	{
								?>
								<a data-container="body" data-toggle="tooltip" title="Lock/Un-Lock" data-placement="bottom" id="ss_<?php echo $channel['id'];?>" data-html="true" class="channellocs" href="javascript:void(0);"><i class="fa fa-unlock"></i></a>
								<?php
									}
									elseif($channel['isLocked'] == 1)
                                	{
								?>
								<a data-container="body" data-toggle="tooltip" title="Lock/Un-Lock" data-placement="bottom" id="ss_<?php echo $channel['id'];?>" data-html="true" class="channellocs" href="javascript:void(0);"><i class="fa fa-lock"></i></a>
								<?php
									}
                                	?>
                                </td>
                                <td><a data-container="body" data-toggle="tooltip" title="Delete" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id'];?>"  class="channelsDelete" href="javascript:void(0);"><i class="fa fa-trash"></i></a></td>
                            </tr>
								<?php
								$counter++;
							}
						   }
						   else
						   {
						   	?>
						   	 <tr>
                            	<td colspan="12">No Channels Found!</td>
                            </tr>
						   	<?php
						   }
                            ?>

                        </table>
                    </div>

            </div>
        </div>
                                        	</div>

										</div>
										<?php
										if (sizeof($channelTabs)>0) {										
											foreach ($channelTabs as $tab) {
											
										?>
										<div role="tabpanel" class="tab-pane" id="channelgid_<?php echo $tab['id'] ?>">
											<div class="card-body">
												<div class="row">
													<div class="col-12" style="padding: 0;">
														<div class="box-header">
															<!-- Single button -->
															<div class="btn-group">

																<select class="form-control actionsel" id="actionChannels">
																	<option value="0">Action</option>
																	<option value="Lock">Lock</option>
																	<option value="UnLock">Un-Lock</option>
																	<option value="Restart">Restart</option>
																	<option value ="Archive">Archive</option>
																	<option value="Delete">Delete</option>
																</select>

															</div>
															<!-- Standard button -->
															<button type="button" class="btn btn-primary submit" onclick="submitChannels();">Submit</button>
															
															<a href="<?php echo site_url(); ?>createchannel" class="add-btn btn btn-primary float-right">
																<span>
																	<i class="fa fa-plus"></i> Channel</span>
															</a>
															
															
																								<a href="javascript:void(0);" class="add-btn btn btn-danger float-right mr-2 chnlGrp_delete" accesskey="<?php echo $tab['id'] ?>"><span><i class="fa fa-trash"></i> Delete</span></a>
														</div>
														<br/>
														<div class="table-responsive no-padding">
															<table  class="table table-hover check-input cstmtable channeltable channelTable">
																<tr>
																	<th width="60px">
																		<div class="boxes">
																			<input type="checkbox" id="allChannels" >
																			<label for="allChannels"></label>
																		</div>
																	</th>
																	<th width="40px">ID</th>
																	<th width="300px">Channel Name</th>
																	<th width="260px">Input</th>
																	<th width="260px">Output</th>
																	<th>Status</th>
																	<th width="150px"> &nbsp; </th>
																	<th> &nbsp; </th>
																	<th> &nbsp; </th>
																	<th> &nbsp; </th>
																	<th> &nbsp; </th>
																	<th> &nbsp; </th>

																</tr>
																<?php
																$channelIds = $this->common_model->getChannelIdsbyMappingGroupId($tab['id'],$tab['uid']);
																if (sizeof($channelIds)>0) 
																{
																	$counter=1;
																	foreach ($channelIds as $chid) {
																		foreach($channels as $channel){
																if ($chid['channelId'] == $channel['id']) {
																?>

																<tr id="row_<?php echo $channel['id']; ?>">
																	<td>
																		<div class="boxes">
																			<input type="checkbox" id="channel_<?php echo $channel['id']; ?>" class="channelActions">
																			<label for="channel_<?php echo $channel['id']; ?>"></label>
																		</div>
																	</td>
																	<td><?php echo $counter; ?></td>
																	<td>
																		<a class="channels_status" onclick="openEditPage('<?php echo site_url(); ?>updatechannel/<?php echo $channel['id']; ?>',this);" href="javascript:void(0);"><?php echo $channel['channel_name']; ?></a></td>
																	<td>


																		<?php

																$channelInput = $channel['channelInput'];
																$channelInputid=explode("_",$channelInput);
																switch ($channelInputid[0]) {
																	case "phyinput":
																		$id = $channel['encoder_id'];
																		$encoder = $this->common_model->getAllEncoders($id,0);
																		if (sizeof($encoder) > 0) {
																			$input = $this->common_model->getEncoderInpOutbyEncid($encoder[0]['id']);
																			if (sizeof($input)>0) {
																				foreach ($input as $inp) {
																					$inputname = $inp['inp_source'];
																					$inpname =  $inp['inp_name'];
																					if ($inputname == $channelInputid[1]) {
																						echo '<label class="label label-input lblinputtext">'.$encoder[0]['encoder_name'].'</label> <label class="label label-input lblinputtext">'. $inpname.'</label>';
																					}
																				}
																			} else {
																				echo '<label class="label label-input lblinputtext">'.$encoder[0]['encoder_name'].'</label> <label class="label label-input lblinputtext">'. $channelInputid[1].'</label>';
																			}

																		} else {
																			echo "NA";
																		}

																		break;
																	case "virinput":
																		$virInput = $this->common_model->channelInput($channelInputid[1]);
																		$encoderInput = $this->common_model->getEncoderInputbyId($channelInputid[1]);
																		$id = $channel['encoderid'];
																		$encoder = $this->common_model->getAllEncoders($id,0);
																		echo '<label class="label label-input lblinputtext">'.$encoder[0]['encoder_name'].'</label>';
																		switch ($channelInputid[1]) {
																			case 3:
																				echo '<label class="label label-input lblinputtext">'.$virInput[0]['item'].'</label> ';
																				echo  '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['channel_ndi_source'].'</span>';
																				break;
																			case 4:
																				echo '<label class="label label-input lblinputtext">'.$virInput[0]['item'].'</label> ';
																				echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['input_rtmp_url'].'</span> ';
																				break;
																			case 5:
																				echo '<label class="label label-input lblinputtext">RTP</label> ';
																				echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['input_mpeg_rtp'].'</span> ';
																				break;
																			case 6:
																				echo '<label class="label label-input lblinputtext">UDP</label> ';
																				echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['input_mpeg_udp'].'</span> ';
																				break;
																			case 7:
																				echo '<label class="label label-input lblinputtext">SRT</label> ';
																				echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['input_mpeg_srt'].'</span> ';
																				break;
																			case 8:
																				echo '<label class="label label-input lblinputtext">HLS</label> ';
																				echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.substr($channel['input_hls_url'],0,50).'...</span> ';
																		}

																		break;
																}
																?></td>
																	<td><?php $channelOutpue= $channel['channelOutpue'];
																$channelOutpueid=explode("_",$channelOutpue);

																switch ($channelOutpueid[0]) {
																	case "phyoutput":
																		$id = $channel['encoder_id'];
																		$encoder = $this->common_model->getAllEncoders($id,0);
																		//$encoderOutput = $this->common_model->getOutputName($channelOutpueid[1]);
																		if (sizeof($encoder)>0) {
																			$outputs = $this->common_model->getEncoderOutbyEncid($encoder[0]['id']);
																			if (sizeof($outputs)>0) {
																				foreach ($outputs as $out) {
																					$outputname = $out['out_destination'];
																					$outname = $out['out_name'];
																					if ($channelOutpueid[1] == $out['out_destination']) {
																						//echo '<label class="label label-output lbloutputtext">'.$encoder[0]['encoder_name'].'</label> <label class="label label-output lbloutputtext">'. $outname.'</label>';
																						echo '<label class="label label-output lbloutputtext">'. $outname.'</label>';
																					}
																				}
																			} else {
																				//echo '<label class="label label-output lbloutputtext">'.$encoder[0]['encoder_name'].'</label> <label class="label label-output lbloutputtext">'. $channelOutpueid[1].'</label>';
																				echo ' <label class="label label-output lbloutputtext">'. $channelOutpueid[1].'</label>';
																			}
																		} else {
																			echo "NA";
																		}

																		break;
																	case "viroutput":
																		$virOutput = $this->common_model->channelOutput($channelOutpueid[1]);
																		switch ($channelOutpueid[1]) {
																			case 3:
																				if ($channel['is_record_channel'] == 1 && $channel['record_file'] != "") {
																					echo '<label class="label label-output lbloutputtext">'.$virOutput[0]['item'].'</label> <label class="label label-output lblrecordtext">File</label> ';
																					echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['ndi_name'].'</span>   <span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" class="copyrecordfile">./recordings/'.$channel['record_file'].'</span>';
																				} else {
																					echo '<label class="label label-output lbloutputtext">'.$virOutput[0]['item'].'</label> ';
																					echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['ndi_name'].'</span>  ';
																				}


																				break;
																			case 4:
																				if ($channel['is_record_channel'] == 1 && $channel['record_file'] != "") {
																					echo '<label class="label label-output lbloutputtext">'.$virOutput[0]['item'].'</label> <label class="label label-output lblrecordtext">File</label> ';
																					echo ' <span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_rtmp_url'].'/'.$channel['output_rtmp_key'].'</span>   <span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" class="copyrecordfile">./recordings/'.$channel['record_file'].'</span>';
																				} else {
																					echo '<label class="label label-output lbloutputtext">'.$virOutput[0]['item'].'</label>  ';
																					echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_rtmp_url'].'/'.$channel['output_rtmp_key'].'</span> ';
																				}

																				break;
																			case 5:
																				if ($channel['is_record_channel'] == 1 && $channel['record_file'] != "") {
																					echo '<label class="label label-output lbloutputtext">RTP</label> <label class="label label-output lblrecordtext">File</label> ';
																					echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_rtp'].'</span>   <span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" class="copyrecordfile">./recordings/'.$channel['record_file'].'</span>';
																				} else {
																					echo '<label class="label label-output lbloutputtext">RTP</label>  ';
																					echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_rtp'].'</span> ';
																				}

																				break;
																			case 6:
																				if ($channel['is_record_channel'] == 1 && $channel['record_file'] != "") {
																					echo '<label class="label label-output lbloutputtext">UDP</label> <label class="label label-output lblrecordtext">File</label> ';
																					echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_udp'].'</span>   <span class="copyrecordfile" data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true">./recordings/'.$channel['record_file'].'</span>';
																				} else {
																					echo '<label class="label label-output lbloutputtext">UDP</label>  ';
																					echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_udp'].'</span> ';
																				}

																				break;
																			case 7:
																				if ($channel['is_record_channel'] == 1 && $channel['record_file'] != "") {
																					echo '<label class="label label-output lbloutputtext">SRT</label> <label class="label label-output lblrecordtext">File</label> ';
																					echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_srt'].'</span>   <span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" class="copyrecordfile">./recordings/'.$channel['record_file'].'</span>';
																				} else {
																					echo '<label class="label label-output lbloutputtext">SRT</label> ';
																					echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$channel['output_mpeg_srt'].'</span> ';
																				}

																				break;
																		}

																		break;
																} ?></td>

																	<td>
																		<?php
																if ($channel['channel_status'] == 0) {
																?>
																		<span id="status" class="label label-gray">Offline</span>
																		<?php
															}
															elseif($channel['channel_status'] == 1)
															{
																?>
																		<span id="status" class="label label-live">Online</span>
																		<?php
															}
																?>
																	</td>
																	<td>
																		<?php
																if ($channel['uptime'] !="" && $channel['uptime'] !="00:00:00") {
																	$d = date('Y-m-d\TH:i:sP',strtotime($channel['uptime']));
																?>
																		<p class="counter" title="<?php echo $d; ?>"></p>
																		<?php
															} else {
																?>
																		<p class="counter clr" title="">00:00:00</p>
																		<?php
															}
																?>

																	</td>
																	<td>
																		<a data-container="body" id="ss_<?php echo $channel['id']; ?>" data-toggle="tooltip" title="Refresh" data-placement="bottom" data-html="true" class="refreshchannelsStatus" href="javascript:void(0);">
																			<i class="fa fa-refresh"></i></a></td>
																	<td>
																		<a data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id']; ?>" class="channelscopy" href="javascript:void(0);">
																			<i class="fa fa-copy"></i></a></td>
																	<td>
																		<?php
																if ($channel['channel_status'] == 0) {
																?>
																		<a data-container="body" data-toggle="tooltip" title="Start/Stop" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id']; ?>" class="channelsstartstop" href="javascript:void(0);">
																			<i class="fa fa-play"></i></a>
																		<?php
															}
															elseif($channel['channel_status'] == 1)
															{
																?>
																		<a data-container="body" data-toggle="tooltip" title="Start/Stop" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id']; ?>" class="channelsstartstop" href="javascript:void(0);">
																			<i class="fa fa-pause"></i></a>
																		<?php
															}
																?>
																	</td>
																	<td>
																		<?php
																if ($channel['isLocked'] == 0) {
																?>
																		<a data-container="body" data-toggle="tooltip" title="Lock/Un-Lock" data-placement="bottom" id="ss_<?php echo $channel['id']; ?>" data-html="true" class="channellocs" href="javascript:void(0);">
																			<i class="fa fa-unlock"></i></a>
																		<?php
															}
															elseif($channel['isLocked'] == 1)
															{
																?>
																		<a data-container="body" data-toggle="tooltip" title="Lock/Un-Lock" data-placement="bottom" id="ss_<?php echo $channel['id']; ?>" data-html="true" class="channellocs" href="javascript:void(0);">
																			<i class="fa fa-lock"></i></a>
																		<?php
															}
																?>
																	</td>
																	<td>
																		<a data-container="body" data-toggle="tooltip" title="Delete" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id']; ?>"  class="channelsDelete" href="javascript:void(0);">
																			<i class="fa fa-trash"></i></a></td>
																</tr>
																<?php
																$counter++;
																}
															}																		
														}	
																}
																else{
																	?>
																	<tr> 
																	<td colspan="12">No Record Found</td>
																	</tr>
																	<?php
																}
										?>
															</table>
														</div>

													</div>
												</div>
											</div>

										</div>
										<?php
									}
								}
										?> 
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- ========= Section One End ========= -->


                    </div>
        		</div>
        	</div>
        </div>
       </div>
    </main>
<div class="modal fade" id="create_channel_group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="content-box config-contentonly">
				<div class="config-container">
					<div class="form-group col-lg-12">
						<h3 class="tit">Enter Group Name</h3></div>
						<div class="form-group col-lg-12">
							<div class="row">								
								<input class="form-control" type="text" id="ch_grpup_name" name="ch_grpup_name"/>
							</div>
						</div>
						<div class="tab-btn-container">
							<input type="button" class="btn btn-primary save saveChannelGroupName" value="Create"/>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>