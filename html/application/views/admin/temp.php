<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	.netdata-chart span{
		color: #FFFFFF !important;
	}
	.wowzaTable tr td a.wowzadisable:hover .box-body
	{
		display:block !important;
	}
.dropzone {
    background: #343B41;
}

th.tg-0pky, th.tg-0lax, td.tg-0pky, td.tg-0lax {
    padding: 0;
}
</style>
<?php

function convertToDHMS($seconds){
	$string = "";

	$days = intval(intval($seconds) / (3600*24));
	$hours = (intval($seconds) / 3600) % 24;
	$minutes = (intval($seconds) / 60) % 60;
	$seconds = (intval($seconds)) % 60;

	if($days> 0){
	    $string .= "$days:";
	}
	else
	{
		   $string .= "00:";
	}
	if($hours > 0){
	    $string .= "$hours:";
	}
	else
	{
		   $string .= "00:";
	}
	if($minutes > 0){
	    $string .= "$minutes:";
	}
	else
	{
		   $string .= "00:";
	}
	if ($seconds > 0){
	    $string .= "$seconds";
	}
	else
	{
		   $string .= "00";
	}

	return $string;
}
?>
<main class="main main-editrundown">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active"><a href="rundowns">Rundowns</a></li>
					<li class="breadcrumb-item active">Rundown 1</li>
        </ol>
        <div class="container-fluid">
					<div class="animated fadeIn">
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
					<div class="card">
						<div class="card-header">Rundown 1</div>
						<div class="card-body">
							<div class="card rundown-control border-primary" style="background: #2f353a;">
								<div class="card-body">
									<div class="table-responsive no-padding">
									  <table class="table table-hover check-input cstmtable channeltable channelTable">
									    <tbody>
												<tr>
												    <th class="tg-0pky" colspan="2"style="text-align: center;vertical-align:middle;border-right:1px solid #23282c;"><p style="margin:0;"data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Current Played Time">CPT</p><span class="counter" style="font-size:16px;" title="2019-09-12T16:58:03+02:00">12:00:30:21</span></th>
												    <th class="tg-0pky" colspan="2"style="text-align: center;vertical-align:middle;border-right:1px solid #23282c;"><p style="margin:0;"data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Current Remaining Time">CRT</p><span class="counter" style="font-size:16px;" title="2019-09-12T16:58:03+02:00">12:00:30:21</span></th>
												    <th class="tg-0lax" style="width:20%; padding:5px;" colspan="3" rowspan="4">
												      <div id="player-container" style="background-image: url(&quot;https://kurrenttv.nbla.cloud/thumb/0000/30/orig.jpg&quot;);background-size:cover;">
												        <div id="player_live" title="rtmp://152.115.45.140:1935/ktv-test-hls-02/nebula_contitest" style="visibility: visible;"></div>
												        <div id="player-tip"></div>
												      </div>
												    </th>
												  </tr>
												  <tr>
												    <td class="tg-0pky" style="padding:0;vertical-align: middle;" colspan="4">
															<div class="progress" style="height: 15px;border-radius: 0;">
																<div data-container="body" data-toggle="tooltip" data-placement="left" data-original-title="Current Clip Progress" class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
															</div>
														</td>
												  </tr>
												  <tr>
												    <th class="tg-0pky" colspan="2"style="text-align: center;vertical-align:middle;border-right:1px solid #23282c;"><p style="margin:0;"data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Playlist Played Time">PPT</p><span class="counter" style="font-size:16px;" title="2019-09-12T16:58:03+02:00">12:00:30:21</span></th>
												    <th class="tg-0pky" colspan="2"style="text-align: center;vertical-align:middle;border-right:1px solid #23282c;"><p style="margin:0;"data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Playlist Remaining Time">PRT</p><span class="counter" style="font-size:16px;" title="2019-09-12T16:58:03+02:00">12:00:30:21</span></th>
												  </tr>
												  <tr>
														<td class="tg-0pky" style="padding:0;vertical-align: middle;" colspan="4">
															<div class="progress" style="height: 30px;border-radius: 0;">
																<div data-container="body" data-toggle="tooltip" data-placement="left" data-original-title="Playlist Progress" class="progress-bar" role="progressbar" style="width: 43%;" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
															</div>
														</td>
												  </tr>
													<tr>
														<td class="tg-0pky" style="padding:5px;" colspan="2">NOW: Clips Name</td>
														<td class="tg-0pky" style="padding:5px;" colspan="2">NEXT: Next Clip Name</td>
														<td class="tg-0pky" style="padding:5px;" colspan="3"></td>
													</tr>
									    </tbody>
									  </table>
									</div>
									<div class="row">
										<div class="form-group col-lg-12" style="margin-bottom: 0;">
												<div class="video-buttons  col-md-12">
													<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" data-original-title="Retake"><i class="fa fa-step-backward"></i></button>
													<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" data-original-title="Take"><i class="fa fa-play"></i></button>
													<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" data-original-title="Stop"><i class="fa fa-stop"></i></button>
													<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" data-original-title="Next"><i class="fa fa-step-forward"></i></button>
												</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card rundown-content border-secondary" style="background: #2f353a;">
								<div class="card-body">
									<div class="row man-buttons">
										<div class="form-group col-lg-12">
												<div class="playlist-buttons  col-md-12">
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Add Assets"><i class="fa fa-database"></i></button>
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Upload Playlist"><i class="icon icon-cloud-upload"></i></button>
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Download Playlist"><i class="icon icon-cloud-download"></i></button>
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Append"><i class="cui-chevron-bottom"></i></button>
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Insert"><i class="cui-arrow-bottom"></i></button>
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Copy"><i class="fa fa-copy"></i></button>
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Paste"><i class="fa fa-paste"></i></button>
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Delete Selected"><i class="cui-delete"></i></button>
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Clear Playlist"><i class="cui-trash"></i></button>
												</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-lg-5" style="display:none;">
											<a class="btn-close" href="" data-toggle="tooltip" data-placement="bottom" data-original-title="Close Window" style="float: right;"><i class="icon-close"></i></a>
											<div class="assets-card">
						        		<div class="assets-card-body">
													<ul class="nav nav-tabs">
														<li class="nav-item"><a class="nav-link active"  href="#main" role="tab" data-toggle="tab">Main</a></li>
														<li class="nav-item"><a class="nav-link"  href="#fill" role="tab" data-toggle="tab">Fill</a></li>
														<li class="nav-item"><a class="nav-link"  href="#music" role="tab" data-toggle="tab">Music</a></li>
														<li class="nav-item"><a class="nav-link"  href="#stories" role="tab" data-toggle="tab">Stories</a></li>
														<li class="nav-item"><a class="nav-link"  href="#commercial" role="tab" data-toggle="tab">Commercial</a></li>
													</ul>
													<div class="tab-content" style="border-bottom:none;border-radius: 0;">
														<div class="tab-pane active" role="tabpanel" id="view-set" style="padding-bottom:0;">
															<div class="row">
															  <div class="col-md-12">
															      <div class="form-group">
															          <div class="input-group">
															              <div class="input-group-prepend">
															                  <button type="button" class="btn btn-btn btn-outline-dark btn-block"><i class="fa fa-search"></i></button>
															              </div>
															              <input id="input3-group2" name="input3-group2" placeholder="Search" type="text" class="form-control" value="">
															              <div class="input-group-append">
																							<button type="button" class="btn btn-btn btn-outline-dark btn-block"><i class="fa fa-times"></i></button>
															              </div>
															          </div>
															      </div>
															  </div>
															  <div class="col-md-4"></div>
															</div>
														</div>
													</div>
													<div class="tab-content" style="border-top:none;">
													        <div class="tab-pane active show" role="tabpanel" id="main">
																			    <div class="assets-card-body">
																					<div class="row" id="main_list">
																						<div class="col-md-12">
																									<table class="table table-hover check-input cstmtable ">
																									   <thead>
																									      <tr>
																									      <th class="" style="text-align: left;" data-is-only-head="false" title="Title" data-field="title">
																									            ID
																									         </th>
																									         <th class="" style="text-align: left;" data-is-only-head="false" title="Title" data-field="title">
																									            Title
																									         </th>
																									         <th class="" style="text-align: left;" data-is-only-head="false" title="Folder" data-field="id_folder">
																									            Folder
																									            <div></div>
																									         </th>
																									         <th class="" style="text-align: left;" data-is-only-head="false" title="Duration" data-field="duration">
																									            Duration
																									            <div></div>
																									         </th>
																													 <th width="80px" class="" style="text-align: left;" data-is-only-head="false" title="Duration" data-field="thumbnail">
																									            Thumbnail
																									            <div></div>
																									         </th>
																									      </tr>
																									   </thead>
																									   <tbody>
																											 <tr>
																													<td>1</td>
																													<td><a href="https://iohub.tv/iohub/editasset/44">test-nometa</a></td>
																													<td><span class="folder" style="background-color:#2872b3">Movie</span></td>
																													<td>00:00:00:00</td>
																													<td style="padding-bottom: 0;padding-top: 0;vertical-align: middle;"><img style="width:85%;vertical-align:middle;" src="https://kurrenttv.nbla.cloud/thumb/0000/30/orig.jpg"></td>
																												</tr>
																											</tbody>
																									</table>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
										<div class="form-group col-lg-12">
											<div class="table-responsive no-padding" style="text-align:center;">
											    <table class="table table-hover check-input cstmtable appsTable table table-responsive-sm table-bordered table-striped">
											        <tbody>
											            <tr style="background-color: rgb(46, 52, 58);">
											                <th width="40px">
											                    <div class="boxes">
											                        <input type="checkbox" id="selectallApps" class="selectallApps">
											                        <label for="selectallApps"></label>
											                    </div>
											                </th>
											                <th width="40px">ID</th>
											                <th>Title</th>
											                <th>Start Time</th>
											                <th>Duration</th>
											                <th width="80px">Thumbnail</th>
											                <th>Status</th>
											                <th>QC</th>
											            </tr>
											            <tr class="current" style="background-color: #01a65a17;">
											              <td>
											                <div class="boxes">
											                  <input type="checkbox">
											                  <label></label>
											                </div>
											              </td>
											              <td>1</td>
											              <td>30 Years of Free software foundation</td>
											              <td>12:32:00:23</td>
																		<td>00:02:46:00</td>
																		<td style="padding-bottom: 0;padding-top: 0;vertical-align: middle;"><img style="width:85%;vertical-align:middle;" src="https://kurrenttv.nbla.cloud/thumb/0000/30/orig.jpg"></img></td>
																		<td><span id="status" class="label label-success">ONAIR</span></td>
																		<td><i class="icon-check icons text-success"></i></td>
											            </tr>
																	<tr class="cued" style="background-color: #ffc10736;">
											              <td>
											                <div class="boxes">
											                  <input type="checkbox">
											                  <label></label>
											                </div>
											              </td>
											              <td>2</td>
											              <td>30 Years of Free software foundation</td>
											              <td>12:32:00:23</td>
																		<td>00:02:46:00</td>
																		<td style="padding-bottom: 0;padding-top: 0;vertical-align: middle;"><img style="width:85%;vertical-align:middle;" src="https://kurrenttv.nbla.cloud/thumb/0000/30/orig.jpg"></img></td>
																		<td><span id="status" class="label label-warning">CUED</span></td>
																		<td><i class="icon-check icons text-success"></i></td>
											            </tr>
																	<tr class="ready">
											              <td>
											                <div class="boxes">
											                  <input type="checkbox">
											                  <label></label>
											                </div>
											              </td>
											              <td>3</td>
											              <td>30 Years of Free software foundation</td>
											              <td>12:32:00:23</td>
																		<td>00:02:46:00</td>
																		<td style="padding-bottom: 0;padding-top: 0;vertical-align: middle;"><img style="width:85%;vertical-align:middle;" src="https://kurrenttv.nbla.cloud/thumb/0000/30/orig.jpg"></img></td>
																		<td><span id="status" class="label label-gray">READY</span></td>
																		<td><i class="icon-check icons text-success"></i></td>
											            </tr>
																	<tr class="ready">
											              <td>
											                <div class="boxes">
											                  <input type="checkbox">
											                  <label></label>
											                </div>
											              </td>
											              <td>4</td>
											              <td>30 Years of Free software foundation</td>
											              <td>12:32:00:23</td>
																		<td>00:02:46:00</td>
																		<td style="padding-bottom: 0;padding-top: 0;vertical-align: middle;"><img style="width:85%;vertical-align:middle;" src="https://kurrenttv.nbla.cloud/thumb/0000/30/orig.jpg"></img></td>
																		<td><span id="status" class="label label-gray">READY</span></td>
																		<td><i class="icon-check icons text-success"></i></td>
											            </tr>
																	<tr class="ready">
											              <td>
											                <div class="boxes">
											                  <input type="checkbox">
											                  <label></label>
											                </div>
											              </td>
											              <td>5</td>
											              <td>30 Years of Free software foundation</td>
											              <td>12:32:00:23</td>
																		<td>00:02:46:00</td>
																		<td style="padding-bottom: 0;padding-top: 0;vertical-align: middle;"><img style="width:85%;vertical-align:middle;" src="https://kurrenttv.nbla.cloud/thumb/0000/30/orig.jpg"></img></td>
																		<td><span id="status" class="label label-gray">READY</span></td>
																		<td><i class="icon-check icons text-success"></i></td>
											            </tr>
																	<tr class="missing" style="background-color: #dd4b3929;">
											              <td>
											                <div class="boxes">
											                  <input type="checkbox">
											                  <label></label>
											                </div>
											              </td>
											              <td>6</td>
											              <td>30 Years of Free software foundation</td>
											              <td>12:32:00:23</td>
																		<td>00:02:46:00</td>
																		<td style="padding-bottom: 0;padding-top: 0;vertical-align: middle;"><img style="width:85%;vertical-align:middle;" src=""></img></td>
																		<td><span id="status" class="label label-danger">MISSING</span></td>
																		<td><i class="icon-close icons text-danger"></i></td>
											            </tr>
																	<tr class="ready">
											              <td>
											                <div class="boxes">
											                  <input type="checkbox">
											                  <label></label>
											                </div>
											              </td>
											              <td>7</td>
											              <td>30 Years of Free software foundation</td>
											              <td>12:32:00:23</td>
																		<td>00:02:46:00</td>
																		<td style="padding-bottom: 0;padding-top: 0;vertical-align: middle;"><img style="width:85%;vertical-align:middle;" src="https://kurrenttv.nbla.cloud/thumb/0000/30/orig.jpg"></img></td>
																		<td><span id="status" class="label label-gray">READY</span></td>
																		<td><i class="icon-check icons text-success"></i></td>
											            </tr>
											        </tbody>
											    </table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button class="btn btn-sm btn-primary btnSaveAssets" type="button">Update</button>
							<button class="btn btn-sm btn-danger btnresetAssets" type="reset">Reset</button>
						</div>
					</div>
				</div>
			</div>
		</main>
