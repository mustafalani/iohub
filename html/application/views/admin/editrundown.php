<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	.assetloop{
		background: #2F353A;
		border: 1px solid #3A4149 !important;
		color: #fff;
	}
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
.cstmtable{
	table-layout: fixed;
}
.list-group-item{
	display:table-footer-group;
}
.list-group{
	    display: table-footer-group;
}
.iconselected{
	color:#FFF;
	background-color:#73818F !important;
	border-color: #73818F !important;
}
.missing{
	background-color: #dd4b3929 !important;
}
.ttl_rundown{
	background: none;
	border: none;
	color: white;
}
</style>
<script type="text/javascript">
	var _folderSettings = {};
	var RUNDOWN_URL = '<?php echo $RUNDOWN_URL;?>';
	var PLAYLISTNAME = '<?php echo $rundwon[0]["rundown_id"];?>';
	var isPlaylistOnline = '<?php echo $isOnline;?>';
</script>

<?php
$settingss = json_encode($settings);
echo '<script type="text/javascript">';
echo "_folderSettings=".$settingss;
echo '</script>';
?>
<script type="text/javascript">
	var mainAssets = {};
	var fillAssets = {};
	var musicAssets = {};
	var storiesAssets = {};
	var commercialAssets = {};
	var currentIndexGreenBar = 0;
	var currentIndexPostion =0;
	var currentIndex = 0;
	var currentIndexDuration = 0;
	currentIndex = parseInt('<?php echo $OnlineIndex;?>');
</script>
<?php
$totalTime = "";
$totalClipDuration = 0;
$currentIndexDuration = 0;
$now = "";
$next = "";
if(sizeof($clips)>0)
{
	$cunter_ind =1;
	$currentindex = 0;
	$URL = $RUNDOWN_URL."/login";
	$ch1 = curl_init();
	curl_setopt($ch1,CURLOPT_URL, $URL);
	curl_setopt($ch1, CURLOPT_POST, 1);
	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch1,CURLOPT_POSTFIELDS, "login=".$wuname."&password=".$wpass."&api=1");
	curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
	$result = curl_exec($ch1);
	$jsonData = rtrim($result, "\0");
	$resultarray = json_decode($jsonData,TRUE);
	curl_close($ch1);

	foreach($clips as $clip_id){
		if($OnlineIndex >= ($cunter_ind-1))
		{
			$currentindex = $currentindex + $clip_id['clip_duration'];

		}
		$totalClipDuration = $totalClipDuration + $clip_id['clip_duration'];

		if($isOnline == 1 && ($cunter_ind-1)== (int)$OnlineIndex){
			$curl = curl_init();
			$fields = json_encode(array("object_type" =>'asset','id_asset'=>(int)$clip_id['clip_id'],'objects'=>array((int)$clip_id['clip_id']),'session_id'=>$resultarray['session_id']));
			  curl_setopt_array($curl, array(
			  CURLOPT_URL => $RUNDOWN_URL."/api/get",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
				'Authorization: Bearer '.base64_encode($wuname.':'.$wpass),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$response = curl_exec($curl);
			$clip = json_decode($response,TRUE);
			$err = curl_error($curl);
			curl_close($curl);
			$now = 	$clip['data'][0]['title'];
			$currentIndexDuration = $clip['data'][0]['duration'];
		}
		if($isOnline == 1 && ($cunter_ind-1)== ((int)$OnlineIndex)+1){
			$curl = curl_init();
			$fields = json_encode(array("object_type" =>'asset','id_asset'=>(int)$clip_id['clip_id'],'objects'=>array((int)$clip_id['clip_id']),'session_id'=>$resultarray['session_id']));
			  curl_setopt_array($curl, array(
			  CURLOPT_URL => $RUNDOWN_URL."/api/get",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
				'Authorization: Bearer '.base64_encode($wuname.':'.$wpass),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$response = curl_exec($curl);
			$clip = json_decode($response,TRUE);
			$err = curl_error($curl);
			curl_close($curl);
			$next = 	$clip['data'][0]['title'];
		}
		$cunter_ind++;
	}
}
if($currentIndesPos != "" && $currentIndesPos > 0){
	$currentindex = $currentindex + $currentIndesPos;
}
?>
<script type="text/javascript">
	currentIndexGreenBar = parseInt('<?php echo $currentindex;?>');
	currentIndexDuration = parseInt('<?php echo $currentIndexDuration;?>');
</script>

<?php
function formatMilliseconds($milliseconds) {
    $seconds = floor($milliseconds / 1000);
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $milliseconds = $milliseconds % 1000;
    $seconds = $seconds % 60;
    $minutes = $minutes % 60;

    $format = '%u:%02u:%02u.%03u';
    $time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
    return rtrim($time, '0');
}
function convertToDHMS($seconds){
	$string = "";

	$days = intval(intval($seconds) / (3600*24));
	$hours = (intval($seconds) / 3600) % 24;
	$minutes = (intval($seconds) / 60) % 60;
	$seconds = (intval($seconds)) % 60;


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

if($main['count']>0)
{
	foreach($main['data'] as $m){
		?>
		<script type="text/javascript">
			mainAssets['<?php echo $m["id"];?>'] = '<?php echo json_encode($m);?>';
		</script>
		<?php
	}
}
if($fill['count']>0)
{
	foreach($fill['data'] as $f){
		?>
		<script type="text/javascript">
			fillAssets['<?php echo $f["id"];?>'] = '<?php echo json_encode($f);?>';
		</script>
		<?php
	}
}
if($music['count']>0)
{
	foreach($music['data'] as $mu){
		?>
		<script type="text/javascript">
			musicAssets['<?php echo $mu["id"];?>'] = '<?php echo json_encode($mu);?>';
		</script>
		<?php
	}
}
if($story['count']>0)
{
	foreach($story['data'] as $s){
		?>
		<script type="text/javascript">
			storiesAssets['<?php echo $s["id"];?>'] = '<?php echo json_encode($s);?>';
		</script>
		<?php
	}
}
if($commercial['count']>0)
{
	foreach($commercial['data'] as $c){
		?>
		<script type="text/javascript">
			storiesAssets['<?php echo $c["id"];?>'] = '<?php echo json_encode($c);?>';
		</script>
		<?php
	}
}
//echo '<script type="text/javascript">mainAssets ='.json_encode($main['data']).';</script>';
?>
<script type="text/javascript">
//var per = 0;
//var per1 = 0;
//setInterval(function(){
//per++;
//if(per <= 100){
  //  $('.progress-bar-one').css({background: "linear-gradient(to right, #4dbd74 "+per+"%,transparent "+per+"%,transparent 100%)"});
//}}, 100);
</script>
<main class="main main-editrundown">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
	        <li class="breadcrumb-item"><a href="<?php echo site_url();?>">Home</a></li>
  			<li class="breadcrumb-item active"><a href="<?php echo site_url();?>rundowns">Rundowns</a></li>
			<li class="breadcrumb-item active"><?php echo $rundwon[0]['title'];?></li>
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
						<div class="card-header"><input style="background: none;border: navajowhite;color: #fff;" type="text" id="rundowntitle_<?php echo $rundwon[0]['id'];?>" class="runttl" name="rundowntitle_<?php echo $rundwon[0]['id'];?>" value="<?php echo $rundwon[0]['title'];?>"/>  <a class="rundownttileupdate" href="javascript:void(0);"><i class="fa fa-save fa-lg mt-4"></i></a>
						</div>
						<div class="card-body">
							<div class="card rundown-control border-primary" style="background: #2f353a;">
								<div class="card-body">
									<div class="table-responsive no-padding">
									  <table class="table table-hover check-input cstmtable channeltable channelTable">
									    <tbody>
												<tr>
												    <th class="tg-0pky" colspan="2"style="text-align: center;vertical-align:middle;border-right:1px solid #23282c;"><p style="margin:0;"data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Current Played Time">CPT</p><span class="counter starttime_bar" style="font-size:16px;" title=""></span></th>
												    <th class="tg-0pky" colspan="2"style="text-align: center;vertical-align:middle;border-right:1px solid #23282c;"><p style="margin:0;"data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Current Remaining Time">CRT</p><span class="counter endtime_bar" style="font-size:16px;" title=""></span></th>
												    <th class="tg-0lax" style="width:20%; padding:5px;" colspan="3" rowspan="4">
												    	<?php
											$URL = "rtmp://";
											$encoder = $this->common_model->getAllEncoders($rundwon[0]['engine_id'],0);
											$nebula = $this->common_model->getNebulabyId($rundwon[0]['engine_id'],0);
											if($rundwon[0]['engine_type'] == 'encoder')
											{
												$URL = $URL.$encoder[0]['encoder_ip'];
											}
											else if($rundwon[0]['engine_type'] == 'nebula')
											{
												$URL = $URL.$nebula[0]['encoder_ip'];
											}
											$URL = $URL.':1935/rundowns/'.$rundwon[0]['rundown_id'].'-preview';
											//$URL = 'rtmp://152.115.45.140:1935/rundowns/'.$rundwon[0]['rundown_id'].'-preview';

											?>
												      <div id="player-container">
												        <div id="player_rundownlive" title="<?php echo $URL?>" style="visibility: visible;"></div>
												        <div id="player-tip"></div>
												      </div>
												      <button type="button" id="playrunlist" class="btn btn-sm btn-success">Preview</button>
												    </th>
												  </tr>
												  <tr>
												    <td class="tg-0pky" style="padding:0;vertical-align: middle;" colspan="4">
															<div class="progress" style="height: 15px;border-radius: 0;">
																<div  data-container="body" data-toggle="tooltip" data-placement="left" data-original-title="Current Clip Progress" class="progress-bar-tow" role="progressbar" style="width: 100%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
															</div>
														</td>
												  </tr>
												  <tr>
												    <th class="tg-0pky" colspan="2"style="text-align: center;vertical-align:middle;border-right:1px solid #23282c;"><p style="margin:0;"data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Playlist Played Time">PPT</p><span class="counter" style="font-size:16px;" title="2019-09-12T16:58:03+02:00">00:00:00:00</span></th>
												    <th class="tg-0pky" colspan="2"style="text-align: center;vertical-align:middle;border-right:1px solid #23282c;"><p style="margin:0;"data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Playlist Remaining Time">PRT</p><span class="counter" style="font-size:16px;" title="2019-09-12T16:58:03+02:00"><?php echo convertToDHMS($totalClipDuration);?></span></th>
												  </tr>
												  <tr>
														<td class="tg-0pky" style="padding:0;vertical-align: middle;" colspan="4">
															<div class="progress" style="height: 30px;border-radius: 0;">
																<div data-container="body" data-toggle="tooltip" data-placement="left" data-original-title="Playlist Progress" class="progress-bar-one" role="progressbar" style="width: 100%;" aria-valuenow="<?php echo $currentindex;?>" aria-valuemin="0" aria-valuemax="100"></div>
															</div>
														</td>
												  </tr>
													<tr>
														<td class="tg-0pky" style="padding:5px;" colspan="2">NOW: <span class="nowclip"><?php echo $now;?></span>
														</td>
														<td class="tg-0pky" style="padding:5px;" colspan="2">NEXT: <span class="nextclip"><?php echo $next;?></span></td>
														<td class="tg-0pky" style="padding:5px;" colspan="3"></td>
													</tr>
									    </tbody>
									  </table>
									</div>
									<div class="row">
										<div class="form-group col-lg-12" style="margin-bottom: 0;">
												<div class="video-buttons  col-md-12">
													<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" data-original-title="Retake"><i class="fa fa-step-backward"></i></button>
													<button type="button" class="btn btn-default btnRunPlaylist" data-toggle="tooltip" data-placement="bottom" data-original-title="Take"><i class="fa fa-play"></i></button>
													<button type="button" class="btn btn-default btnStopPlaylist" data-toggle="tooltip" data-placement="bottom" data-original-title="Stop"><i class="fa fa-stop"></i></button>
													<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" data-original-title="Next"><i class="fa fa-step-forward"></i></button>
												</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card rundown-temp border-danger" style="background: #2f353a;">
							  <div class="card-body">
							    <div class="row">
							      <div class="form-group col-lg-12" style="margin-bottom: 0;">
							          <div class="video-buttons  col-md-12">
							          				<?php
													$timeFirst  = strtotime(date('Y-m-d H:i:s'));
													$timeSecond = strtotime($currentIndestime);
													$differenceInSeconds = $timeFirst - $timeSecond;

							          				?>
							          				<script type="text/javascript">
							          					currentIndexPostion = parseInt('<?php echo $differenceInSeconds;?>');
							          				</script>
													<p><strong>current index: </strong><?php echo $OnlineIndex;?></p>
													<p><strong>current index startime: </strong><?php echo $currentIndestime;?></p>
													<p><strong>current index duration (in seconds): </strong> <?php echo $currentIndexDuration;?></p>
													<p><strong>current index position (in seconds): </strong><?php echo $differenceInSeconds;?></p>
													<p><strong>Count Up (in seconds): </strong><span class="countup">0</span></p>

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
													<button type="button" class="btn_db btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Add Assets"><i class="fa fa-database"></i></button>
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Upload Playlist"><i class="icon icon-cloud-upload"></i></button>
													<a href="<?php echo site_url();?>nebula/downloadPlaylist/<?php echo $this->uri->segment(2);?>" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Download Playlist"><i class="icon icon-cloud-download"></i></a>
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Append"><i class="cui-chevron-bottom"></i></button>
													<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Insert"><i class="cui-arrow-bottom"></i></button>
													<button type="button" class="btn btn-outline-secondary btn_asset_copy" data-toggle="tooltip" data-placement="bottom" data-original-title="Copy"><i class="fa fa-copy"></i></button>
													<!--<button type="button" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Paste"><i class="fa fa-paste"></i></button>-->
													<button type="button" class="btndeleteselected btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" data-original-title="Delete Selected"><i class="cui-delete"></i></button>
													<button type="button" class="btn btn-outline-secondary btn_clear_assets" data-toggle="tooltip" data-placement="bottom" data-original-title="Clear Playlist"><i class="cui-trash"></i></button>
												</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-lg-5 assetlist dnone">
											<a class="assetclose btn-close" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" data-original-title="Close Window" style="float: right;"><i class="icon-close"></i></a>
											<div class="assets-card">
						        		<div class="assets-card-body">
													<ul class="nav nav-tabs rundowntabs">
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
													<div class="tab-content" style="border-top:none;height: 50vh;overflow-y: scroll;">
													        <div class="tab-pane active show" role="tabpanel" id="main">
																			    <div class="assets-card-body">
																					<div class="row" id="main_list">
																						<div class="col-md-12">
																									<table class="table table-hover check-input cstmtable ">
																									   <thead>
																									      <tr>
																									      <th width="70px" class="" data-is-only-head="false" title="ID" data-field="title">
																									            ID
																									         </th>
																									         <th class="" style="text-align: left;" data-is-only-head="false" title="Title" data-field="title">
																									            Title
																									         </th>
																									         <th width="100px" class="" data-is-only-head="false" title="Folder" data-field="id_folder">
																									            Folder
																									            <div></div>
																									         </th>
																									         <th width="120px" class="" data-is-only-head="false" title="Duration" data-field="duration">
																									            Duration
																									            <div></div>
																									         </th>
																													 <th width="100px" class="" data-is-only-head="false" title="Thumbnail" data-field="thumbnail">
																									            Thumbnail
																									            <div></div>
																									         </th>
																									      </tr>
																									   </thead>
																									   <tbody id="maintable">

																									   </tbody>
																									</table>
																								</div>
																							</div>
																						</div>
																					</div>
															<div class="tab-pane" role="tabpanel" id="fill">
																			    <div class="assets-card-body">
																					<div class="row" id="main_list">
																						<div class="col-md-12">
																									<table class="table table-hover check-input cstmtable ">
																									   <thead>
																									      <tr>
																									      <th width="70px" class="" data-is-only-head="false" title="ID" data-field="title">
																									            ID
																									         </th>
																									         <th class="" style="text-align: left;" data-is-only-head="false" title="Title" data-field="title">
																									            Title
																									         </th>
																									         <th width="100px" class="" data-is-only-head="false" title="Folder" data-field="id_folder">
																									            Folder
																									            <div></div>
																									         </th>
																									         <th width="120px" class="" data-is-only-head="false" title="Duration" data-field="duration">
																									            Duration
																									            <div></div>
																									         </th>
																													 <th width="100px" class="" data-is-only-head="false" title="Thumbnail" data-field="thumbnail">
																									            Thumbnail
																									            <div></div>
																									         </th>
																									      </tr>
																									   </thead>
																									   <tbody id="filltable">

																											</tbody>
																									</table>
																								</div>
																							</div>
																						</div>
																					</div>
															<div class="tab-pane" role="tabpanel" id="music">
																			    <div class="assets-card-body">
																					<div class="row" id="main_list">
																						<div class="col-md-12">
																									<table class="table table-hover check-input cstmtable ">
																									   <thead>
																									      <tr>
																									      <th width="70px" class="" data-is-only-head="false" title="ID" data-field="title">
																									            ID
																									         </th>
																									         <th class="" style="text-align: left;" data-is-only-head="false" title="Title" data-field="title">
																									            Title
																									         </th>
																									         <th width="100px" class="" data-is-only-head="false" title="Folder" data-field="id_folder">
																									            Folder
																									            <div></div>
																									         </th>
																									         <th width="120px" class="" data-is-only-head="false" title="Duration" data-field="duration">
																									            Duration
																									            <div></div>
																									         </th>
																													 <th width="100px" class="" data-is-only-head="false" title="Thumbnail" data-field="thumbnail">
																									            Thumbnail
																									            <div></div>
																									         </th>
																									      </tr>
																									   </thead>
																									   <tbody id="musictable">

																											</tbody>
																									</table>
																								</div>
																							</div>
																						</div>
																					</div>
															<div class="tab-pane" role="tabpanel" id="stories">
																			    <div class="assets-card-body">
																					<div class="row" id="main_list">
																						<div class="col-md-12">
																									<table class="table table-hover check-input cstmtable ">
																									   <thead>
																									      <tr>
																									      <th width="70px" class="" data-is-only-head="false" title="ID" data-field="title">
																									            ID
																									         </th>
																									         <th class="" style="text-align: left;" data-is-only-head="false" title="Title" data-field="title">
																									            Title
																									         </th>
																									         <th width="100px" class="" data-is-only-head="false" title="Folder" data-field="id_folder">
																									            Folder
																									            <div></div>
																									         </th>
																									         <th width="120px" class="" data-is-only-head="false" title="Duration" data-field="duration">
																									            Duration
																									            <div></div>
																									         </th>
																													 <th width="100px" class="" data-is-only-head="false" title="Thumbnail" data-field="thumbnail">
																									            Thumbnail
																									            <div></div>
																									         </th>
																									      </tr>
																									   </thead>
																									   <tbody id="storytable">

																											</tbody>
																									</table>
																								</div>
																							</div>
																						</div>
																					</div>
															<div class="tab-pane" role="tabpanel" id="commercial">
																			    <div class="assets-card-body">
																					<div class="row" id="main_list">
																						<div class="col-md-12">
																									<table class="table table-hover check-input cstmtable ">
																									   <thead>
																									      <tr>
																									      <th width="70px" class="" data-is-only-head="false" title="ID" data-field="title">
																									            ID
																									         </th>
																									         <th class="" style="text-align: left;" data-is-only-head="false" title="Title" data-field="title">
																									            Title
																									         </th>
																									         <th width="100px" class="" data-is-only-head="false" title="Folder" data-field="id_folder">
																									            Folder
																									            <div></div>
																									         </th>
																									         <th width="120px" class="" data-is-only-head="false" title="Duration" data-field="duration">
																									            Duration
																									            <div></div>
																									         </th>
																													 <th width="100px" class="" data-is-only-head="false" title="Thumbnail" data-field="thumbnail">
																									            Thumbnail
																									            <div></div>
																									         </th>
																									      </tr>
																									   </thead>
																									   <tbody id="commercialtable">

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
										<div class="rundownslist form-group col-lg-12">
											<div class="table-responsive no-padding" style="text-align:center;">
											    <table class="table table-hover check-input cstmtable appsTable table table-responsive-sm table-bordered table-striped">
											    	<thead>
											                <th width="40px" style="vertical-align:middle;">
											                    <div class="boxes">
											                        <input type="checkbox" id="selectallassets" class="selectallApps">
											                        <label for="selectallassets"></label>
											                    </div>
											                </th>
											                <th width="40px">ID</th>
											                <th style="text-align:left;">Title</th>
											                <th>Start Time</th>
											                <th>Duration</th>
											                <th width="120px">Thumbnail</th>
											                <th width="120px">Loop</th>
											                <th width="120px">Status</th>
											                <th width="80px">QC</th>

											    	</thead>
											        <tbody id="tableassetsss" class="dropabletd">
											            <?php
											            if(sizeof($clips)>0)
											            {
											            	$cunter =1;
											            	foreach($clips as $clip_id){
																$URL = $RUNDOWN_URL."/login";
																$ch1 = curl_init();
																curl_setopt($ch1,CURLOPT_URL, $URL);
																curl_setopt($ch1, CURLOPT_POST, 1);
																curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
																curl_setopt($ch1,CURLOPT_POSTFIELDS, "login=".$wuname."&password=".$wpass."&api=1");
																curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
																$result = curl_exec($ch1);
																$jsonData = rtrim($result, "\0");
																$resultarray = json_decode($jsonData,TRUE);
																curl_close($ch1);

																$curl = curl_init();
																$fields = json_encode(array("object_type" =>'asset','id_asset'=>(int)$clip_id['clip_id'],'objects'=>array((int)$clip_id['clip_id']),'session_id'=>$resultarray['session_id']));
																  curl_setopt_array($curl, array(
																  CURLOPT_URL => $RUNDOWN_URL."/api/get",
																  CURLOPT_RETURNTRANSFER => true,
																  CURLOPT_ENCODING => "",
																  CURLOPT_MAXREDIRS => 10,
																  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
																  CURLOPT_CUSTOMREQUEST => "POST",
																  CURLOPT_POSTFIELDS =>$fields,
																  CURLOPT_HTTPHEADER => array(
																  	'Accept: application/json',
																    'Content-Type: application/json',
																    'Content-Length:'. strlen($fields),
																	'Authorization: Bearer '.base64_encode($wuname.':'.$wpass),
																    'Cookie: '.$_SERVER['HTTP_COOKIE']
																  ),
																));
																$response = curl_exec($curl);
																$clip = json_decode($response,TRUE);
																$err = curl_error($curl);
																curl_close($curl);
																if(array_key_exists('status',$clip['data'][0]) && $clip['data'][0]['status'] == 1){
																//echo $isOnline;
																	if($isOnline == 1 && ($cunter-1)== (int)$OnlineIndex){
																		?>
																	<tr style="background-color: #01a65a17;" accesskey="<?php echo $clip['data'][0]['id'];?>" draggable="true" class="sortable-chosen">
																	<?php
																	}
																	else if($isOnline == 1 && ($cunter-1) == ((int)$OnlineIndex)+1){
																		?>
																	<tr style="background-color: #ffc10736;" accesskey="<?php echo $clip['data'][0]['id'];?>" draggable="true" class="sortable-chosen">
																	<?php
																	}
																	else{

																		?>
																	<tr accesskey="<?php echo $clip['data'][0]['id'];?>" draggable="true" class="sortable-chosen">
																	<?php
																	}
																}
																else{
																	?>
																	<tr accesskey="<?php echo $clip['data'][0]['id'];?>" draggable="true" class="sortable-chosen missing">
																	<?php
																}
																?>

																	<td class='stime'  accesskey='<?php echo $clip_id['start_time'];?>'>
																	<div class="boxes">
																	<input type="checkbox" id="asset_<?php echo $cunter.'_'. $clip['data'][0]['id'];?>" class="drag_assets">
																	<label for="asset_<?php echo $cunter.'_'.$clip['data'][0]['id'];?>"></label>
																	</div>
																	</td>
																	<td><?php echo $cunter;?></td>
																	<td accesskey='<?php echo $clip_id['path'];?>' style="text-align:left;"><?php echo $clip['data'][0]['title'];?></td>
																	<td>00:00:00</td>
																	<td class='duration' accesskey='<?php echo $clip_id['clip_duration'];?>'><?php
																	if(array_key_exists('duration',$clip['data'][0]))
																	{
																		echo gmdate("H:i:s", $clip['data'][0]['duration']);
																	}
																	else{
																		echo "00:00:00";
																	}
																	?></td>
																	<td style="padding-bottom: 0;padding-top: 0;vertical-align: middle;">
																	<?php

																	if(false === file_get_contents($RUNDOWN_URL."/thumb/0000/".$clip['data'][0]['id']."/orig.jpg",0,null,0,1)){
																	?>
																		<img style="width:65%;vertical-align:middle;" src="<?php echo site_url();?>public/site/main/img/NoImageAvailable.png" onerror="imgError(this);"></img>
																		<?php

																	}
																	else{
																		?>
																		<img style="width:65%;vertical-align:middle;" src="<?php echo $RUNDOWN_URL;?>/thumb/0000/<?php echo $clip['data'][0]['id'];?>/orig.jpg" onerror="imgError(this);"></img>
																		<?php

																	}
																	 ?>
																	</td>
																	<td>
																		<select id="assetloop" name="assetloop" class="assetloop">
																			<option value="">--</option>
																			<?php
																			for($i=1; $i<=100; $i++){
																				if($clip_id['loop'] == $i){
																					?>
																				<option selected="selected" value="<?php echo $i;?>"><?php echo $i;?></option>
																				<?php
																				}
																				else{
																					?>
																				<option value="<?php echo $i;?>"><?php echo $i;?></option>
																				<?php
																				}

																			}
																			?>
																		</select>
																	</td>
																	<td>
																	<?php
																	if($clip['data'][0]['status'] == 1){
																		if($isOnline == 1 && ($cunter-1)== (int)$OnlineIndex){
																			?>
																		<span id="status" class="label label-success">ONAIR</span>
																		<?php
																		}
																		elseif($isOnline == 1 && ($cunter-1)== ((int)$OnlineIndex)+1){
																			?>
																		<span id="status" class="label label-warning">CUED</span>
																		<?php
																		}
																		else{
																		?>
																		<span id="status" class="label label-gray">READY</span>
																		<?php
																		}

																	}
																	else{
																		?>
																		<span id="status" class="label label-danger">MISSING</span>
																		<?php
																	}
																	 ?>
																	</td>
																	<td>
																	  <?php
						                                              if(array_key_exists('qc/state',$clip['data'][0]))
						                                              {
																	  	switch($clip['data'][0]['qc/state'])
																	  	{
																			case "3":
																			?>
												                          <i class="icon-close icons text-danger"></i>
																			<?php
																			break;
																			case "4":
																			?>
																		   <i class="icon-check icons text-success"></i>
																			<?php
																			break;
																			case "0":
																			?>
												                          <i class="fa fa-circle-thin icons text-secondary" style="font-size: 24px;"></i>
																			<?php
																			break;
																		}
																	  }
																	  else{
																	  	?>
												                          <i class="fa fa-circle-thin icons"></i>
																		<?php
																	  }
						                                              ?>
																	</td>
																</tr>
																<?php
																$cunter++;
															}
														}
														else{
															?>
															 <tr class="empty">
													          	<td colspan="9">No Record Found</td>
													          </tr>
															<?php
														}
											            ?>


											        </tbody>
											    </table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button class="btn btn-sm btn-primary btnSaveRundownList" type="button">Update</button>
							<button class="btn btn-sm btn-danger btnresetAssets" type="reset">Reset</button>
						</div>
					</div>
				</div>
			</div>
		</main>
