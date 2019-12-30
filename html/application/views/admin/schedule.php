<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
.sched > a:first-child {
    vertical-align: middle;
}
.config-container {

    width: 100%;
    margin: 0 auto;
    padding: 0;

}
.content-box {
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
.sched {
    margin: 0 auto;
    position: absolute;
    top: -25px;
    left: 42%;
    font-size: 37px;
}
.fc-content
{
	padding: 5px;
	font-size: 14px;
}
.fc-content i
{
	font-size: 14px;
	margin-left: 3px;
	margin-right: 5px;
	color: wheat;
}
.action-table table.table tr td .btn .fa {
    font-size: 13px;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background:#191919 !important;
}
.btn-github {
    color: #fff !important;
}
.input-append .add-on:last-child, .input-append .btn:last-child, .input-append .btn-group:last-child > .dropdown-toggle {

    -webkit-border-radius: 0 4px 4px 0;
    -moz-border-radius: 0 4px 4px 0;
    border-radius: 0 4px 4px 0;

}
.input-append .add-on, .input-prepend .add-on {

    display: inline-block;
    width: auto;
    height: 27px;
    min-width: 16px;
    padding: 4px 5px;
    font-size: 14px;
    font-weight: normal;
    line-height: 20px;
    text-align: center;
    text-shadow: 0 1px 0 #ffffff;
    background-color: #eeeeee;
    border: 1px solid #ccc;
    position: absolute;
top: 27px;
z-index: 1;

}
.input-append input, .input-prepend input, .input-append select, .input-prepend select, .input-append .uneditable-input, .input-prepend .uneditable-input {

    position: relative;
    margin-bottom: 0;
    *margin-left: 0;
    vertical-align: top;
    -webkit-border-radius: 0 4px 4px 0;
    -moz-border-radius: 0 4px 4px 0;
    border-radius: 0 4px 4px 0;

}
.input-append.date .add-on i, .input-prepend.date .add-on i {

    display: block;
    cursor: pointer;
    width: 16px;
    height: 16px;

}
	div.dropdown-menu li > a {

    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: normal;
    line-height: 20px;
    color: #333333;
    white-space: nowrap;

}
.bootstrap-datetimepicker-widget > ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
[class^="icon-"], [class*=" icon-"] {

    display: inline-block;
    width: 14px;
    height: 14px;
    margin-top: 1px;
    *margin-right: .3em;
    line-height: 14px;
    vertical-align: text-top;
    background-image: url("assets/site/main/img/glyphicons-halflings.png");
    background-position: 14px 14px;
    background-repeat: no-repeat;

}
.bootstrap-select .dropdown-menu > li > a {
    color: #777 !important;
}
.bootstrap-select .dropdown-menu > li:hover > a {
    color: #FFF !important;
}
.bootstrap-select .dropdown-menu > li.selected > a {
    color: #FFF !important;
}
/*a.btn {

    display: inline-block;
    *display: inline;
    padding: 4px 12px;
    margin-bottom: 0;
    *margin-left: .3em;
    font-size: 14px;
    line-height: 20px;
    color: #333333;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;
    cursor: pointer;
    background-color: #f5f5f5;
    *background-color: #e6e6e6;
    background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
    background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
    background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
    background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
    background-repeat: repeat-x;
    border: 1px solid #bbbbbb;
        border-top-color: rgb(187, 187, 187);
        border-right-color: rgb(187, 187, 187);
        border-bottom-color: rgb(187, 187, 187);
        border-left-color: rgb(187, 187, 187);
    *border: 0;
    border-color: #e6e6e6 #e6e6e6 #bfbfbf;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    border-bottom-color: #a2a2a2;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    *zoom: 1;
    -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);

}*/
.icon-chevron-up {

    background-position: -288px -120px;

}
.icon-chevron-down {

    background-position: -313px -119px;

}
.icon-calendar {
    background-position: -192px -120px;
}
.icon-time {
    background-position: -48px -24px;
}
div.dropdown-menu li.picker-switch > a:hover, .dropdown-menu li.picker-switch > a:focus, .dropdown-submenu:hover > a {

    color: #ffffff;
    text-decoration: none;
    background-color: #0081c2;
    background-image: -moz-linear-gradient(top, #0088cc, #0077b3);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0077b3));
    background-image: -webkit-linear-gradient(top, #0088cc, #0077b3);
    background-image: -o-linear-gradient(top, #0088cc, #0077b3);
    background-image: linear-gradient(to bottom, #0088cc, #0077b3);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc', endColorstr='#ff0077b3', GradientType=0);

}
	.modal-content {
		background:#2f353a;
	}
	.tit
	{
		margin: 0;
	}
	.iconn
	{
		font-size:36px;
		color: gray;
	}
	.schdule
	{
		display: inline-block;
		padding: 20px;
		text-align: center;
		border-radius: 4px;
		color: gray;
	}
	.schdule:hover
	{
		color: #fff;
	}
	.schdule:hover .iconn
	{
		color: #fff;
	}
  a:hover {
    text-decoration: none;
  }
</style>
<script type="text/javascript">
	var calenderEvents = [];
</script>
<script type="text/javascript">
	var schedulesLocks = [];
	var schedulesData = [];
</script>
<?php
if(sizeof($schedule)>0)
{
	foreach($schedule as $sch1)
	{
		if($sch1['isLocked'] == NULL || $sch1['isLocked'] == "" || $sch1['isLocked'] == 0)
		{
			if($sch1['schedule_type'] == "channel")
			{
				$channel = $this->common_model->getChannelbyId($sch1['sid']);
			}
			elseif($sch1['schedule_type'] == "target")
			{
				$channel = $this->common_model->getTargetbyId($sch1['sid']);
			}
			if(sizeof($channel)>0)
			{
				$t1 = "";
				 if($sch1['schedule_type'] == "channel")
				  {
					$title1 = $this->common_model->getChannelbyId($sch1['sid']);
					$t1 = $title1[0]['channel_name'];
				  }
				  elseif($sch1['schedule_type'] == "target")
				  {
					$title1 = $this->common_model->getTargetbyId($sch1['sid']);
					$t1 = $title1[0]['target_name'];
				  }
				echo '<script type="text/javascript">schedulesLocks['.$sch1['id'].']=0;</script>';
				?>
					<script type="text/javascript">
						var schd = {};
						schd.id = '<?php echo $sch1["id"]; ?>';
						schd.title = '<?php echo $t1;?>';
						schd.schedule_type = '<?php echo $sch1["schedule_type"]; ?>';
						schd.type = '<?php echo $sch1["type"]; ?>';
						schd.sid = '<?php echo $sch1["sid"]; ?>';
						schd.start_datetime = '<?php echo $sch1["start_datetime"]; ?>';
						schd.end_datetime = '<?php echo $sch1["end_datetime"]; ?>';
						schd.isLocked = '<?php echo $sch1["isLocked"]; ?>';
						schedulesData['<?php echo $sch1["id"]; ?>'] = schd;
					</script>
				<?php
			}
		}
		else
		{
			echo '<script type="text/javascript">schedulesLocks['.$sch1['id'].']=1;</script>';
		}
	}
}
$arraySchedules = array();
if(sizeof($schedule)>0)
{
	$counterr =0;
	foreach($schedule as $sch)
	{
		$channel = $this->common_model->getChannelbyId($sch['sid']);
		if($sch['schedule_type'] == "channel")
		{
			$channel = $this->common_model->getChannelbyId($sch['sid']);
		}
		elseif($sch['schedule_type'] == "target")
		{
			$channel = $this->common_model->getTargetbyId($sch['sid']);
		}
		if(sizeof($channel)>0)
		{
			$title1 = ""; $t1 = "";
		  $sarray = explode(" ",$sch["start_datetime"]);
		  $earray = explode(" ",$sch["end_datetime"]);
		  $sdate = explode("/",$sarray[0]);
		  $stime = explode(":",$sarray[1]);

		  $edate = explode("/",$earray[0]);
		  $etime = explode(":",$earray[1]);
         // $startTime  = date("Y-m-d",strtotime($sch["start_datetime"]))."T".$sarray[1].".00Z";
          //$endTime  = date("Y-m-d",strtotime($sch["end_datetime"]))."T".$earray[1].".00Z";
		  if($sch['schedule_type'] == "channel")
		  {
			$title1 = $this->common_model->getChannelbyId($sch['sid']);
			$t1 = $title1[0]['channel_name'];
		  }
		  elseif($sch['schedule_type'] == "target")
		  {
			$title1 = $this->common_model->getTargetbyId($sch['sid']);
			$t1 = $title1[0]['target_name'];
		  }
		  $bccolor = "#".$counterr."C".$counterr."DBC";
		  ?>
		  <script type="text/javascript">
		  		var event = {};
		  		event.id = '<?php echo $sch["id"];?>';
		  		event.title = '<?php echo $t1;?>';
		  		event.start = new Date('<?php echo $sdate[2];?>','<?php echo $sdate[1];?>'-1,'<?php echo $sdate[0];?>','<?php echo $stime[0];?>','<?php echo $stime[1];?>');
		  		event.end = new Date('<?php echo $edate[2];?>','<?php echo $edate[1];?>'-1,'<?php echo $edate[0];?>','<?php echo $etime[0];?>','<?php echo $etime[1];?>');
		  		event.backgroundColor = '<?php echo $bccolor;?>';
		  		event.borderColor = '#3C8DBC';
				calenderEvents.push(event);
			</script>
		  <?php
		}
		$counterr++;
	}
}
?>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Scheduler</li>
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
					<div class="config-contentonly">
						<div class="config-container">
							<!-- === Nav tabs === -->

							<!-- === Tab panes === -->
							<div class="tab-content">

			  	<div role="tabpanel" class="tab-pane active" id="list">
			  		<div class="card-body">
                                        <div class="row">
                                            <div class="col-12" style="padding: 0;">
                                                <div class="box-header">

                                                    <!-- Single button -->
                                                    <div class="btn-group">
														<select class="form-control actionsel" id="actionSchedule">
															<option value="">Action</option>

															<option value="Lock">Lock</option>
															<option value="UnLock">Un-Lock</option>
															<option value="Delete">Delete</option>
														</select>
													</div>
                                                    <!-- Standard button -->
                                                    <button type="button" class="btn btn-primary submit" onclick="scheduleActions();">Submit</button>

                                                     <div class="col-md-6 sched">
                                                    	<a id="showlist" href="javascript:void(0);" role="tab"><i class="fa fa-list" aria-hidden="true"></i></a>
                                                    	<span>|</span>
                                                    	<a id="showcalenders" href="javascript:void(0);" role="tab"><i class="fa fa-calendar" aria-hidden="true"></i>
</a>
                                                    </div>
                                                    <a class="add-btn btn btn-primary createschedule float-right" href="javascript:void(0);"><span><i class="fa fa-plus"></i> Schedule</span></a>

												</div>
												<br/><br/>
                                                    <div class="table-responsive no-padding">
                                                        <table id="wowzaengins" class="table table-hover cstmtable check-input scheduleTable">
                                                            <tr>
                                                                <th>
                                                                    <div class="boxes">
																		<input type="checkbox"  class="checkbox" id="selecctallschedule"/>
                                                                        <label for="selecctallschedule"></label>
																	</div>
																</th>
																<th>ID</th>
                                                                <th>Title </th>
                                                                <th>Type</th>
                                                                <th>Start Time</th>
                                                                <th>End Time</th>
                                                                <th>Status</th>
                                                                <th> &nbsp; </th>
                                                                <th> &nbsp; </th>
                                                                <th> &nbsp; </th>
                                                                <th> &nbsp; </th>
                                                                <th> &nbsp; </th>
															</tr>
															<?php

															if(sizeof($schedule)>0)
															{
																$counter =1;
																foreach($schedule as $schdle)
																{
																	if($schdle['schedule_type'] == "channel")
																	{
																		$channel = $this->common_model->getChannelbyId($schdle['sid']);
																	}
																	elseif($schdle['schedule_type'] == "target")
																	{
																		$channel = $this->common_model->getTargetbyId($schdle['sid']);
																	}

																	if(sizeof($channel)>0)
																	{
																			$title = "";$t = "";
																	if($schdle['schedule_type'] == "channel")
																	{
																		$title = $this->common_model->getChannelbyId($schdle['sid']);
																		$t = $title[0]['channel_name'];
																	}
																	elseif($schdle['schedule_type'] == "target")
																	{
																		$title = $this->common_model->getTargetbyId($schdle['sid']);
																		$t = $title[0]['target_name'];
																	}
																	?>
																	<tr id="row_<?php echo $schdle['id'];?>">
																		<td>
																			<div class="boxes">
						                                                      <input class="scheduleactions" id="schedule_<?php echo $schdle['id'];?>" type="checkbox" name="schids[]" value="<?php echo $schdle['id'];?>">
						                                                      <label for="schedule_<?php echo $schdle['id'];?>"></label>
						                                                    </div>
																		</td>
																		<td class='cnt'><?php echo $counter; ?></td>
																		<td class="title">
																		<?php
																		if($schdle['schedule_type'] == "channel")
																		{
																			?>
																			<a class="schdule_title" id="lvchannel" name="<?php echo $schdle['id'];?>" href="javascript:void(0);"><?php echo $t; ?></a>
																			<?php
																		}
																		elseif($schdle['schedule_type'] == "target")
																		{
																			?>
																			<a class="schdule_title" id="lvtarget" name="<?php echo $schdle['id'];?>" href="javascript:void(0);"><?php echo $t; ?></a>
																			<?php
																		}
																		?>

																		</td>
																		<td><?php
																		switch($schdle['type'])
																		{
																			case "google":
																			?>
																			<div class="btn btn-google btn-sm">
						                                                      <span>
						                                                      <i class="fa fa-youtube"></i>
						                                                      Youtube Live
						                                                      </span>
						                                                    </div>
																			<?php
																			break;
																			case "facebook":
																			?>
																			<div class="btn btn-facebook btn-sm">
						                                                      <span>
						                                                      <i class="fa fa-facebook"></i>
						                                                      Facebook Live
						                                                      </span>
						                                                    </div>
																			<?php
																			break;
																			case "twitch":
																			?>
																			<div class="btn btn-facebook btn-sm">
						                                                      <span>
						                                                      <i class="fa fa-facebook"></i>
						                                                      Facebook Live
						                                                      </span>
						                                                    </div>
																			<?php
																			break;
																			case "twitter":
																			?>
																			<div class="btn btn-facebook btn-sm">
						                                                      <span>
						                                                      <i class="fa fa-twitter"></i>
						                                                      Facebook Live
						                                                      </span>
						                                                    </div>
																			<?php
																			break;
																			default:
																			if($schdle['schedule_type'] == "channel")
																			{
																				?>
																			<div class="btn btn-github btn-sm btndis">
						                                                      <span>
						                                                      <i class="fa fa-random"></i>
						                                                      <?php
						                                                      echo $schdle['type'];
						                                                      ?>
						                                                      </span>
						                                                    </div>
																			<?php
																			}
																			elseif($schdle['schedule_type'] == "target")
																			{
																				?>
																			<div class="btn btn-github btn-sm btndis">
						                                                      <span>
						                                                      <i class="fa fa-bolt"></i>
						                                                      <?php
						                                                      echo $schdle['type'];
						                                                      ?>
						                                                      </span>
						                                                    </div>
																			<?php
																			}


																			break;
																		}
																		 ?></td>
																		 <td><?php echo $schdle['start_datetime']; ?></td>
																		 <td><?php echo $schdle['end_datetime']; ?></td>
																		  <td><span id="status" class="label label-gray">Disabled</span></td>
																		  <td><p class="counter" title=""></p></td>
																		  <td><a href="javascript:void(0);"><i class="fa fa-refresh" aria-hidden="true"></i></a></td>
                                                  <td id="<?php echo $schdle['schedule_type'];?>_<?php echo $schdle['id'];?>"><a class="schstartstop" href="javascript:void(0);" id="<?php echo $schdle['schedule_type'];?>_<?php echo $schdle['sid'];?>"><i class="fa fa-play" aria-hidden="true"></i></a></td>
                                                  <td><a class="schLockUnlock" href="javascript:void(0);" id="<?php echo $schdle['schedule_type'];?>_<?php echo $schdle['id'];?>"><i class="fa fa-unlock" aria-hidden="true"></i></a></td>
                                                  <td><a id="<?php echo $schdle['schedule_type'];?>_<?php echo $schdle['id'];?>" href="javascript:void(0);" class="scheduleDel"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
																	</tr>
																	<?php
																	$counter++;
																	}
																}
																if($counter == 1)
																{
																	echo '<tr>';
																echo '<td colspan="12">Not Created Yet</td>';
																echo '</tr>';
																}
															}
															else
															{
																echo '<tr>';
																echo '<td colspan="12">Not Created Yet</td>';
																echo '</tr>';
															}
															?>


														</table>
													</div>
											</div>
										</div>
									</div>
								</div>
							<div role="tabpanel" class="tab-pane" id="calenders">
								<div class="card-body">
					       			<div class="row">
					            		<div class="col-12">
					            			<div class="box-header action-table">

                                                    <!-- Single button -->
                                                   <div class="col-md-6 sched">
                                                    	<a id="showlist" href="javascript:void(0);" role="tab"><i class="fa fa-list" aria-hidden="true"></i></a>
                                                    	<span>|</span>
                                                    	<a id="showcalenders" href="javascript:void(0);" role="tab"><i class="fa fa-calendar" aria-hidden="true"></i>
</a>
                                                    </div>
                                                      <a class="add-btn createschedule btn btn-primary float-right" href="javascript:void(0);"><span><i class="fa fa-plus"></i> Schedule</span></a>
												</div>
												<br/><br/>
					         				<div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
					          <!-- /. box -->
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

<div class="modal fade" id="schedulepopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top: 25vh;">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="config-container">
                	<h2>Schedule Live</h2>
	                 <div class="tab-btn-container">
	                	<a class="schdule" id="liveChannel" href="javascript:void(0);"><i class="fa fa-random iconn"></i><br/>Channels</a>
	                    <a  class="schdule" id="liveTarget" href="javascript:void(0);"><i class="fa fa-bolt iconn"></i><br/>Target</a>
	                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="schedulechannelpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="config-container">
                  <div class="form-group col-lg-12"><h3 class="tit">Schedule Live Channel</h3></div>
	                    <div class="row">
	        				<div class="col-lg-12 p-t-15">
	        					<div class="form-group col-lg-12">
                                <div class="row">
                                    <!--<label> Channels</label>-->
                                    <select class="form-control" name="sch_channel_list" id="sch_channel_list">
                                        <option value="0">- Select Channel -</option>
                                        <?php
											if(sizeof($channels)>0)
											{
												foreach($channels as $channel)
												{
													if($channel['is_scheduled'] != 1)
													{
														echo '<option value="'.$channel['id'].'">'.$channel['channel_name'].'</option>';
													}
												}
											}
										?>
										<option value="-5">Add New</option>
                                    </select>
                                </div>
                            	</div>
                              <div class="form-group col-lg-12" style="padding:0;">
                                <label style="float: left;margin-top: 0.5rem;">Start Time</label>
                                <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                  <div id="datetimepicker_schedule_start_time" class="input-append date">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="icon-calendar"></i>
                                        </span>
                                      </div>
                                      <input id="schedule_popup_channel_starttime" name="schedule_popup_channel_starttime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                                    </div>
                                  </div>
                                </div>
                                <label style="float: left;margin-top: 0.5rem;">End Time</label>
                                <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                  <div id="datetimepicker_schedule_end_time" class="input-append date">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="icon-calendar"></i>
                                        </span>
                                      </div>
                                      <input id="schedule_popup_channel_endtime" name="schedule_popup_channel_endtime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                                    </div>
                                  </div>
                                </div>
                              </div>
	        				</div>
	        			</div>
                <div class="tab-btn-container">
                 <input type="button" class="btn btn-primary save saveScheduleChannel" value="Save"/>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_schedulechannelpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
            <div class="config-container">
            <div class="form-group col-lg-12"><h3 class="tit">Update Live Channel Schedule</h3></div>
	                    <div class="row">
	        				<div class="col-lg-12 p-t-15">
	        					<div class="form-group col-lg-12">
                                <div class="row">
                                    <!--<label> Channels</label>-->
                                    <select class="form-control" name="edit_sch_channel_list" id="edit_sch_channel_list">
                                        <option value="0">- Select Channel -</option>

                                    </select>
                                </div>
                            	</div>
                            	<div class="form-group col-lg-12" style="padding:0;">
                                <label style="float: left;margin-top: 0.5rem;">Start Time</label>
                                <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                  <div id="edit_datetimepicker_schedule_start_time" class=" input-append date">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="icon-calendar"></i>
                                        </span>
                                      </div>
                                    <input id="edit_schedule_popup_channel_starttime" name="edit_schedule_popup_channel_starttime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                                  </div>
                                </div>
                                </div>
                                <label style="float: left;margin-top: 0.5rem;">End Time</label>
                                <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                  <div id="edit_datetimepicker_schedule_end_time" class=" input-append date">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="icon-calendar"></i>
                                        </span>
                                      </div>
                                    <input id="edit_schedule_popup_channel_endtime" name="edit_schedule_popup_channel_endtime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control"  type="text" style="padding-left:32px;"></input>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          </div>
                <div class="tab-btn-container">
                 <input type="button" class="btn btn-primary save updateScheduleChannel" value="Update"/>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="scheduleTargetpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="config-container">
                  <div class="form-group col-lg-12"><h3 class="tit">Schedule Live Target</h3></div>
	                    <div class="row">
	        				<div class="col-lg-12 p-t-15">
	        					<div class="form-group col-lg-12">
                                <div class="row">
                                    <!--<label> Channels</label>-->
                                    <select class="form-control" name="sch_target_list" id="sch_target_list">
                                        <option value="0">- Select Output -</option>
                                        <?php
											if(sizeof($targets)>0)
											{
												foreach($targets as $target)
												{
													if($target['enableTargetSchedule'] != 1)
													{
														echo '<option value="'.$target['id'].'">'.$target['target_name'].'</option>';
													}
												}
											}
										?>
										<option value="-5">Add New</option>
                                    </select>
                                </div>
                            	</div>
                            	<div class="form-group col-lg-12" style="padding:0;">
                                <label style="float: left;margin-top: 0.5rem;">Start Time</label>
                                <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                  <div id="datetimepicker_schedule_target_starttime" class=" input-append date">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="icon-calendar"></i>
                                        </span>
                                      </div>
                                      <input id="schedule_popup_target_starttime" name="schedule_popup_target_starttime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                                    </div>
                                  </div>
                                  </div>
                  <label style="float: left;margin-top: 0.5rem;">End Time</label>
                            	<div class="col-md-12" style="padding:0;margin-bottom:1rem;">
								  <div id="datetimepicker_schedule_target_endtime" class=" input-append date">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="icon-calendar"></i>
                        </span>
                      </div>
                      <input id="schedule_popup_target_endtime" name="schedule_popup_target_endtime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                    </div>
                  </div>
                </div>
              </div>
              </div>
	        			</div>
                <div class="tab-btn-container">
                 <input type="button" class="btn btn-primary save saveSchedulePopupTarget" value="Save"/>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_scheduleTargetpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="config-container">
                  <div class="form-group col-lg-12"><h3 class="tit">Update Live Target Schedule</h3></div>
	                    <div class="row">
	        				<div class="col-lg-12 p-t-15">
	        					<div class="form-group col-lg-12">
                                <div class="row">
                                    <!--<label> Channels</label>-->

                                    	<select class="form-control" name="edit_sch_target_list" id="edit_sch_target_list">
                                        <option value="0">- Select Output -</option>

                                    </select>


                                </div>
                            	</div>
                            	<div class="form-group col-lg-12" style="padding:0;">
                                <label style="float: left;margin-top: 0.5rem;">Start Time</label>
                                <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                  <div id="edit_datetimepicker_schedule_target_starttime" class=" input-append date">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="icon-calendar"></i>
                                        </span>
                                      </div>
                                      <input id="edit_schedule_popup_target_starttime" name="edit_schedule_popup_target_starttime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                                    </div>
                                  </div>
                                  </div>
                                  <label style="float: left;margin-top: 0.5rem;">End Time</label>
                                  <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                    <div id="edit_datetimepicker_schedule_target_endtime" class=" input-append date">
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            <i class="icon-calendar"></i>
                                          </span>
                                        </div>
                                      <input id="edit_schedule_popup_target_endtime" name="edit_schedule_popup_target_endtime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            </div>
                <div class="tab-btn-container">
                 <input type="button" class="btn btn-primary save updateSchedulePopupTarget" value="Update"/>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>
