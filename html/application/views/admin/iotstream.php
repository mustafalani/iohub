<?php $this->load->view('admin/navigation.php'); ?>
<?php $this->load->view('admin/leftsidebar.php'); ?>
<?php $this->load->view('admin/rightsidebar.php'); ?>

<style type="text/css">
	.clr{
		color: #747474;
	}
</style>
<main class="main">
	<!-- Breadcrumb-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Home</a>
		</li>
		<li class="breadcrumb-item active">Iot Streams</li>
	</ol>
	<div class="container-fluid">
		<div class="animated fadeIn">
			<div class="card">
				<div class="card-body">
					<?php
					if ($this->session->flashdata('success')) {
					?>
					<div class="alert alert-success">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php } else if ($this->session->flashdata('error')) {
					?>
					<div class="alert alert-danger">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $this->session->flashdata('error'); ?>
					</div>
					<?php } else if ($this->session->flashdata('warning')) {
					?>
					<div class="alert alert-warning">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $this->session->flashdata('warning'); ?>
					</div>
					<?php } else if ($this->session->flashdata('info')) {
					?>
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
									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item" role="presentation" class="active">
											<a class="nav-link active" href="#iotstreams" aria-controls="channels" role="tab" data-toggle="tab">IoT Streams</a></li>
										
									</ul>


									<!-- === Tab panes === -->
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane active" id="iotstreams">
											<div class="card-body">
												<div class="row">
													<div class="col-12" style="padding: 0;">
														<div class="box-header">
															<!-- Single button -->
															<div class="btn-group">

																<select class="form-control actionsel" id="actionChannels">
																	<option value="0">Action</option>
																	<option value ="Archive">Archive</option>
																	<option value="Delete">Delete</option>
																</select>

															</div>
															<!-- Standard button -->
															<button type="button" class="btn btn-primary submit" onclick="submitChannels();">Submit</button>
															<a href="<?php echo site_url(); ?>createIoTStream" class="add-btn btn btn-primary float-right">
																<span>
																	<i class="fa fa-plus"></i> IoT Stream</span>
															</a>
														</div>
														<br/>
														<div class="table-responsive no-padding">
															<table  class="table table-hover check-input cstmtable channeltable channelTable">
																<tr>
																	<th width="60px">
																		<div class="boxes">
																			<input type="checkbox" id="alliotstreams" >
																			<label for="alliotstreams"></label>
																		</div>
																	</th>
																	<th width="40px">ID</th>
																	<th>Name</th>
																	<th>Encoder</th>
																	<th>Input</th>	
																	<th> Status </th>
																	<th></th>
																	<th width="20px"> &nbsp; </th>
																	<th width="20px"> &nbsp; </th>
																</tr>
																<?php
																$counter=1;
																if (sizeof($streams)>0) {
																	foreach ($streams as $stream) {
																		?>
																<tr id="row_<?php echo $stream['id']; ?>">
																<td>
																	<div class="boxes">
																		<input type="checkbox" id="channel_<?php echo $stream['id']; ?>" class="channelActions">
																		<label for="channel_<?php echo $stream['id']; ?>"></label>
																	</div>
																</td>
																<td><?php echo $counter; ?></td>
																<td>
																	<a class="channels_status" onclick="openEditPage('<?php echo site_url(); ?>updatechannel/<?php echo $stream['id']; ?>',this);" href="javascript:void(0);"><?php echo $stream['channel_name']; ?></a></td>
																	<td>
																	<?php
																		$id = $stream['encoder_id'];
																		$encoder = $this->common_model->getAllEncoders($id,0);
																		echo $encoder[0]['encoder_name'];
																	?>
																	</td>
																<td>


																	<?php

																$channelInput = $stream['channelInput'];
																$channelInputid=explode("_",$channelInput);
																switch ($channelInputid[0]) {
																	case "phyinput":
																		$id = $stream['encoder_id'];
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
																		$id = $stream['encoderid'];
																		$encoder = $this->common_model->getAllEncoders($id,0);
																		echo '<label class="label label-input lblinputtext">'.$encoder[0]['encoder_name'].'</label>';
																		switch ($channelInputid[1]) {
																			case 3:
																				echo '<label class="label label-input lblinputtext">'.$virInput[0]['item'].'</label> ';
																				echo  '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$stream['channel_ndi_source'].'</span>';
																				break;
																			case 4:
																				echo '<label class="label label-input lblinputtext">'.$virInput[0]['item'].'</label> ';
																				echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$stream['input_rtmp_url'].'</span> ';
																				break;
																			case 5:
																				echo '<label class="label label-input lblinputtext">RTP</label> ';
																				echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$stream['input_mpeg_rtp'].'</span> ';
																				break;
																			case 6:
																				echo '<label class="label label-input lblinputtext">UDP</label> ';
																				echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$stream['input_mpeg_udp'].'</span> ';
																				break;
																			case 7:
																				echo '<label class="label label-input lblinputtext">SRT</label> ';
																				echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.$stream['input_mpeg_srt'].'</span> ';
																				break;
																			case 8:
																				echo '<label class="label label-input lblinputtext">HLS</label> ';
																				echo '<span data-container="body" data-toggle="tooltip" title="Click To Copy" data-placement="bottom" data-html="true" style="display: none;" class="copytoclipboardtext">'.substr($stream['input_hls_url'],0,50).'...</span> ';
																		}

																		break;
																}
																?></td>
																	<td>
																		<?php
																if ($stream['channel_status'] == 0) {
																		?>
																			<span id="status" class="label label-gray">Offline</span>
																			<?php
																	}
																	elseif($stream['channel_status'] == 1)
																	{
																		?>
																			<span id="status" class="label label-live">Online</span>
																			<?php
																	}
																	?>
																	</td>
																	<td>
																		<?php
																		if ($stream['uptime'] !="" && $stream['uptime'] !="00:00:00") {
																			$d = date('Y-m-d\TH:i:sP',strtotime($stream['uptime']));
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
																	<?php
																	if ($stream['channel_status'] == 0) {
																	?>
																	<a data-container="body" data-toggle="tooltip" title="Start/Stop" data-placement="bottom" data-html="true" id="ss_<?php echo $stream['id']; ?>" class="iotstreamsstartstop" href="javascript:void(0);">
																		<i class="fa fa-play"></i></a>
																	<?php
																}
																elseif($stream['channel_status'] == 1)
																{
																	?>
																		<a data-container="body" data-toggle="tooltip" title="Start/Stop" data-placement="bottom" data-html="true" id="ss_<?php echo $stream['id']; ?>" class="iotstreamsstartstop" href="javascript:void(0);">
																		<i class="fa fa-pause"></i></a>
																	<?php
																}
																	?>
																	</td>
																	<td>
																		<a data-container="body" data-toggle="tooltip" title="Delete" data-placement="bottom" data-html="true" id="ss_<?php echo $stream['id']; ?>"  class="iotstreamsstartstopDelete" href="javascript:void(0);">
																			<i class="fa fa-trash"></i></a>
																			</td>
																</tr>
																		<?php
																		$counter++;
																	}
																}	 else {
																?>
																<tr>
																	<td colspan="12">No IoT Streams Found!</td>
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
