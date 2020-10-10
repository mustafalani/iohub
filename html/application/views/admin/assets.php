<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
	$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
		localStorage.setItem('activeTab', $(e.target).attr('href'));
	});
	var activeTab = localStorage.getItem('activeTab');
	if(activeTab){
		$('#appstarger a[href="' + activeTab + '"]').tab('show');
	}
});
</script>
<style type="text/css">
	table tr td.tdimg{
		text-align: left;
	}
	table tr td.tdimg a{
		padding-left: 10px;
		width: 100%;
	}
	table tr td.tdimg img{
		width: 30px;
	}
	.form-control {
		height: calc(1.5em + 0.75rem + 2px);
		font-size: 0.875rem;
	}
	.norecord{

	}
	.folder{
		padding-left: 7px;
		padding-right: 7px;
		padding-top: 3px;
		padding-bottom: 3px;
		border-radius: 3px;
	}
	.playbtn{
		display: block;
	    width: 50px;
	    height: 50px;
	    position: absolute;
	    top: 17%;
	    left: 31%;
	    font-size: 26px;
	    border: 1px solid;
	    text-align: center;
	    background: #2F353A;
	    border-radius: 51px;
	    padding-top: 4px;
	    padding-left: 6px;
	}
	.modal-title{
		width: 100%;
    	text-align: center;
	}
	element {

	}
.cstmtable {

    border-collapse: collapse;
   border: none !important;

}
.table {
    margin-bottom: 0 !important;
}
.dnone{
	display: none !important;
}
</style>
<?php
//$setting = $settings;
function convertoTimeFormat($time){

	$t = (int)($time)*(1000);

	return date('Y-m-d H:i:s',$t);
}
function subTitle($data){
	if($data != "" && $data != NULL){
		return $data;
	}else{
		return "-";
	}
}
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
function convertToReadableSize($size){

	if($size != "NAN" && $size != "")
	{
		$base = log($size) / log(1024);
	  $suffix = array("", "KB", "MB", "GB", "TB");
	  $f_base = floor($base);
	  return round(pow(1024, $base - floor($base)), 1).' ' . $suffix[$f_base];
	}
	else{
		return "0 KB";
	}
}
function fps($fps)
{
	if($fps != NULL && $fps !="")
	{
		$fpsArray = explode('/',$fps);
		return $fpsArray[0];
	}
	return "0";
}
function codec($codec){
	if($codec != "")
		return strtoupper($codec);
	else
		return "";
}
?>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href=<?php echo site_url();?>>Home</a>
          </li>
          <li class="breadcrumb-item active"><?php $nebula_id = $this->uri->segment(2);?><?php $nebula = $this->common_model->getNebulabyId($nebula_id);?><?php echo $nebula[0]['encoder_name'];?></li>
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
					<div class="mb-4 col-12">
    <ul class="nav nav-tabs assettabs">
        <li class="nav-item"><a class="nav-link active"  href="#main" role="tab" data-toggle="tab">Main</a></li>
        <li class="nav-item"><a class="nav-link"  href="#fill" role="tab" data-toggle="tab">Fill</a></li>
        <li class="nav-item"><a class="nav-link"  href="#music" role="tab" data-toggle="tab">Music</a></li>
        <li class="nav-item"><a class="nav-link"  href="#stories" role="tab" data-toggle="tab">Stories</a></li>
        <li class="nav-item"><a class="nav-link"  href="#commercial" role="tab" data-toggle="tab">Commercial</a></li>
		<li class="nav-item"><a class="nav-link"  href="#incoming" role="tab" data-toggle="tab">Incoming</a></li>
		<li class="nav-item"><a class="nav-link" href="#archive" role="tab" data-toggle="tab">Archive</a></li>
        <li class="nav-item"><a class="nav-link" href="#trash" role="tab" data-toggle="tab">Trash</a></li>
    </ul>
		<div class="tab-content" style="border-bottom:none;border-radius: 0;">
			<div class="tab-pane active" role="tabpanel" id="view-set" style="padding-bottom:0;">
				<div class="row">
						<div class="d-none d-sm-inline-block col-sm-4">
								<div aria-label="Toolbar with button groups" role="toolbar" class="float-left btn-toolbar">
										<div aria-label="First group" role="group" class="mr-3 btn-group">
												<button  type="button" class="btn btn-outline-secondary active list">
														<i class="fa fa-th-list"></i></button>
												<button type="button" accesskey="<?php echo $this->uri->segment(2);?>" class="btn btn-outline-secondary  grid">

														<i class="fa fa-th-large"></i></button>
												<button type="button" class="btn btn-outline-secondary">

														<i class="fa fa-cog"></i></button>
										</div>
								</div>
						</div>
						<div class="d-none d-sm-inline-block col-sm-4">
								<a  href="<?php echo site_url();?>addasset/<?php echo $this->uri->segment(2);?>">
										<button class="float-left btn btn-primary">

												<i class="fa fa-plus"></i> Add New Asset</button>
								</a>
						</div>
						<div class="col-md-4">
								<div class="float-right position-relative form-group">
										<div class="input-group">
												<div class="input-group-prepend">
														<button type="button" class="btn btn-btn btn-outline-dark btn-block">

																<i class="fa fa-search"></i></button>
												</div>
												<input id="input3-group2" name="input3-group2" placeholder="Search" type="text" class="form-control" value="">
												<div class="input-group-append">
														<button type="button" class="btn btn-btn btn-outline-dark btn-block">

																<i class="fa fa-times"></i></button>
												</div>
										</div>
								</div>
						</div>
						<div class="col-md-4"></div>
				</div>
			</div>
		</div>
    <div class="tab-content" style="border-top:none;">
        <div class="tab-pane active" role="tabpanel" id="main">
						<div class="card">
						    <div class="card-body dnone">
						        <div class="row " id="main_grid">
						        </div>

						    </div>
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
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">Subtitle </th>
												          <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">IDC </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Genre" data-field="genre">
												            Genre
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Folder" data-field="id_folder">
												            Folder
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Duration" data-field="duration">
												            Duration
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Creation time

												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Modified time

												         </th>
												      </tr>
												   </thead>
												   <tbody>
												   	<?php
										        	if(is_array($main) && $main['count']>0){						        											$counter = 1;
														foreach($main['data'] as $mainAssets){
															?>
															<tr>
																<td><?php echo $counter;?></td>
																<td><a href="<?php echo site_url();?>editasset/<?php echo $mainAssets['id'];?>/<?php echo $this->uri->segment(2);?>"><?php echo $mainAssets['title'];?></a></td>
																<td><?php echo subTitle($mainAssets['subtitle']);?></td>
																<td><?php echo subTitle($mainAssets['idec']);?></td>
																<td><?php echo subTitle($mainAssets['gener']);?></td>
																<td><span class="folder" style="background-color:#<?php echo base_convert($settings['data']['folders'][$mainAssets['id_folder']]['color'], 10, 16);?>"><?php echo $settings['data']['folders'][$mainAssets['id_folder']]['title'];?></span></td>

																<td><?php echo convertToDHMS($mainAssets['duration']);?></td>
																<td><?php echo convertoTimeFormat($mainAssets['ctime']);?></td>
																<td><?php echo convertoTimeFormat($mainAssets['mtime']);?></td>
															</tr>
															<?php
															$counter++;
														}
													}else{
														?>
													<tr><td colspan="9">No Record Found</td></tr>
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
        <div class="tab-pane" role="tabpanel" id="fill">
            <div class="card">
						    <div class="card-body dnone">
						        <div class="row " id="fill_grid">
						        </div>

						    </div>
						    <div class="assets-card-body">
						    <div class="row" id="fill_list">
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
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">Subtitle </th>
												          <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">IDC </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Genre" data-field="genre">
												            Genre
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Folder" data-field="id_folder">
												            Folder
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Duration" data-field="duration">
												            Duration
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Creation time

												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Modified time

												         </th>
												      </tr>
												   </thead>
												   <tbody>
												   	<?php
										        	if(is_array($fill) && $fill['count']>0){						        											$counter = 1;
														foreach($fill['data'] as $fillAssets){
															?>
															<tr>
																<td><?php echo $counter;?></td>
																<td><a href="<?php echo site_url();?>editasset/<?php echo $fillAssets['id'];?>/<?php echo $this->uri->segment(2);?>"><?php echo $fillAssets['title']; ?></a></td>
																<td><?php echo subTitle($fillAssets['subtitle']);?></td>
																<td><?php echo subTitle($fillAssets['idec']);?></td>
																<td><?php echo subTitle($fillAssets['gener']);?></td>
																<td><span class="folder" style="background-color:#<?php echo base_convert($settings['data']['folders'][$fillAssets['id_folder']]['color'], 10, 16);?>"><?php echo $settings['data']['folders'][$fillAssets['id_folder']]['title'];?></span></td>

																<td><?php echo convertToDHMS($fillAssets['duration']);?></td>
																<td><?php echo convertoTimeFormat($fillAssets['ctime']);?></td>
																<td><?php echo convertoTimeFormat($fillAssets['mtime']);?></td>
															</tr>
															<?php
															$counter++;
														}
													}else{
														?>
													<tr><td>No Record Found</td></tr>
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
        <div class="tab-pane" role="tabpanel" id="music">
            <div class="card">
						    <div class="card-body dnone">
						        <div class="row " id="music_grid">

						        </div>

						    </div>
						    <div class="assets-card-body">
						    <div class="row" id="music_list">
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
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">Subtitle </th>
												          <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">IDC </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Genre" data-field="genre">
												            Genre
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Folder" data-field="id_folder">
												            Folder
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Duration" data-field="duration">
												            Duration
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Creation time

												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Modified time

												         </th>
												      </tr>
												   </thead>
												   <tbody>
												   	<?php
										        	if(is_array($music) && $music['count']>0){						        											$counter = 1;
														foreach($music['data'] as $musicAssets){
															?>
															<tr>
																<td><?php echo $counter;?></td>
																<td><a href="<?php echo site_url();?>editasset/<?php echo $musicAssets['id'];?>/<?php echo $this->uri->segment(2);?>"><?php echo $musicAssets['title']; ?></a></td>
																<td><?php echo subTitle($musicAssets['subtitle']);?></td>
																<td><?php echo subTitle($musicAssets['idec']);?></td>
																<td><?php echo subTitle($musicAssets['gener']);?></td>
																<td><span class="folder" style="background-color:#<?php echo base_convert($settings['data']['folders'][$musicAssets['id_folder']]['color'], 10, 16);?>"><?php echo $settings['data']['folders'][$musicAssets['id_folder']]['title'];?></span></td>

																<td><?php echo convertToDHMS($musicAssets['duration']);?></td>
																<td><?php echo convertoTimeFormat($musicAssets['ctime']);?></td>
																<td><?php echo convertoTimeFormat($musicAssets['mtime']);?></td>
															</tr>
															<?php
															$counter++;
														}
													}else{
														?>
													<tr><td  colspan="9">No Record Found</td></tr>
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
        <div class="tab-pane" role="tabpanel" id="stories">
            <div class="card">
						    <div class="card-body dnone">
						        <div class="row " id="stories_grid">
						        </div>

						    </div>
						    <div class="assets-card-body">
						    <div class="row" id="stories_list">
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
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">Subtitle </th>
												          <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">IDC </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Genre" data-field="genre">
												            Genre
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Folder" data-field="id_folder">
												            Folder
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Duration" data-field="duration">
												            Duration
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Creation time

												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Modified time

												         </th>
												      </tr>
												   </thead>
												   <tbody>
												   	<?php
										        	if(is_array($story) && $story['count']>0){						        											$counter = 1;
														foreach($story['data'] as $storyAssets){
															?>
															<tr>
																<td><?php echo $counter;?></td>
																<td><a href="<?php echo site_url();?>editasset/<?php echo $storyAssets['id'];?>/<?php echo $this->uri->segment(2);?>"><?php echo $storyAssets['title']; ?></a></td>
																<td><?php echo subTitle($storyAssets['subtitle']);?></td>
																<td><?php echo subTitle($storyAssets['idec']);?></td>
																<td><?php echo subTitle($storyAssets['gener']);?></td>
																<td><span class="folder" style="background-color:#<?php echo base_convert($settings['data']['folders'][$storyAssets['id_folder']]['color'], 10, 16);?>"><?php echo $settings['data']['folders'][$storyAssets['id_folder']]['title'];?></span></td>

																<td><?php echo convertToDHMS($storyAssets['duration']);?></td>
																<td><?php echo convertoTimeFormat($storyAssets['ctime']);?></td>
																<td><?php echo convertoTimeFormat($storyAssets['mtime']);?></td>
															</tr>
															<?php
															$counter++;
														}
													}else{
														?>
													<tr><td  colspan="9">No Record Found</td></tr>
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
        <div class="tab-pane" role="tabpanel" id="commercial">
            <div class="card">
						    <div class="card-body dnone">
						        <div class="row " id="commercial_grid">

						        </div>

						    </div>
						    <div class="assets-card-body">
						    <div class="row" id="commercial_list">
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
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">Subtitle </th>
												          <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">IDC </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Genre" data-field="genre">
												            Genre
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Folder" data-field="id_folder">
												            Folder
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Duration" data-field="duration">
												            Duration
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Creation time

												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Modified time

												         </th>
												      </tr>
												   </thead>
												   <tbody>
												   	<?php
										        	if(is_array($commercial) && $commercial['count']>0){						        											$counter = 1;
														foreach($commercial['data'] as $commercialAssets){
															?>
															<tr>
																<td><?php echo $counter;?></td>
																<td><a href="<?php echo site_url();?>editasset/<?php echo $commercialAssets['id'];?>/<?php echo $this->uri->segment(2);?>"><?php echo $commercialAssets['title']; ?></a></td>
																<td><?php echo subTitle($commercialAssets['subtitle']);?></td>
																<td><?php echo subTitle($commercialAssets['idec']);?></td>
																<td><?php echo subTitle($commercialAssets['gener']);?></td>
																<td><span class="folder" style="background-color:#<?php echo base_convert($settings['data']['folders'][$commercialAssets['id_folder']]['color'], 10, 16);?>"><?php echo $settings['data']['folders'][$commercialAssets['id_folder']]['title'];?></span></td>

																<td><?php echo convertToDHMS($commercialAssets['duration']);?></td>
																<td><?php echo convertoTimeFormat($commercialAssets['ctime']);?></td>
																<td><?php echo convertoTimeFormat($commercialAssets['mtime']);?></td>
															</tr>
															<?php
															$counter++;
														}
													}else{
														?>
													<tr><td  colspan="9">No Record Found</td></tr>
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
        <div class="tab-pane" role="tabpanel" id="incoming">
            <div class="card">
						    <div class="card-body dnone">
						        <div class="row " id="incoming_grid">

						        </div>

						    </div>
						    <div class="assets-card-body">
						    <div class="row" id="incoming_list">
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
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">Subtitle </th>
												          <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">IDC </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Genre" data-field="genre">
												            Genre
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Folder" data-field="id_folder">
												            Folder
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Duration" data-field="duration">
												            Duration
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Creation time

												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Modified time

												         </th>
												      </tr>
												   </thead>
												   <tbody>
												   	<?php
										        	if(is_array($incoming) && $incoming['count']>0){						        											$counter = 1;
														foreach($incoming['data'] as $incomingAssets){
															?>
															<tr>
																<td><?php echo $counter;?></td>
																<td><a href="<?php echo site_url();?>editasset/<?php echo $incomingAssets['id'];?>/<?php echo $this->uri->segment(2);?>"><?php echo $incomingAssets['title']; ?></a></td>
																<td><?php echo subTitle($incomingAssets['subtitle']);?></td>
																<td><?php echo subTitle($incomingAssets['idec']);?></td>
																<td><?php echo subTitle($incomingAssets['gener']);?></td>
																<td><span class="folder" style="background-color:#<?php echo base_convert($settings['data']['folders'][$incomingAssets['id_folder']]['color'], 10, 16);?>"><?php echo $settings['data']['folders'][$incomingAssets['id_folder']]['title'];?></span></td>

																<td><?php echo convertToDHMS($incomingAssets['duration']);?></td>
																<td><?php echo convertoTimeFormat($incomingAssets['ctime']);?></td>
																<td><?php echo convertoTimeFormat($incomingAssets['mtime']);?></td>
															</tr>
															<?php
															$counter++;
														}
													}else{
														?>
													<tr><td  colspan="9">No Record Found</td></tr>
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
        <div class="tab-pane" role="tabpanel" id="archive">
            <div class="card">
						    <div class="card-body dnone">
						        <div class="row " id="archive_grid">

						        </div>

						    </div>
						    <div class="assets-card-body">
						    <div class="row" id="archive_list">
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
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">Subtitle </th>
												          <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">IDC </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Genre" data-field="genre">
												            Genre
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Folder" data-field="id_folder">
												            Folder
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Duration" data-field="duration">
												            Duration
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Creation time

												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Modified time

												         </th>
												      </tr>
												   </thead>
												   <tbody>
												   	<?php
										        	if(is_array($archive) && $archive['count']>0){						        											$counter = 1;
														foreach($archive['data'] as $archiveAssets){
															?>
															<tr>
																<td><?php echo $counter;?></td>
																<td><a href="<?php echo site_url();?>editasset/<?php echo $archiveAssets['id'];?>/<?php echo $this->uri->segment(2);?>"><?php echo $archiveAssets['title']; ?></a></td>
																<td><?php echo subTitle($archiveAssets['subtitle']);?></td>
																<td><?php echo subTitle($archiveAssets['idec']);?></td>
																<td><?php echo subTitle($archiveAssets['gener']);?></td>
																<td><span class="folder" style="background-color:#<?php echo base_convert($settings['data']['folders'][$archiveAssets['id_folder']]['color'], 10, 16);?>"><?php echo $settings['data']['folders'][$archiveAssets['id_folder']]['title'];?></span></td>

																<td><?php echo convertToDHMS($archiveAssets['duration']);?></td>
																<td><?php echo convertoTimeFormat($archiveAssets['ctime']);?></td>
																<td><?php echo convertoTimeFormat($archiveAssets['mtime']);?></td>
															</tr>
															<?php
															$counter++;
														}
													}else{
														?>
													<tr><td  colspan="9">No Record Found</td></tr>
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
        <div class="tab-pane" role="tabpanel" id="trash">
            <div class="card">
						    <div class="card-body dnone">
						        <div class="row " id="trash_grid">

						        </div>

						    </div>
						    <div class="assets-card-body">
						    <div class="row" id="trash_list">
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
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">Subtitle </th>
												          <th class="" style="text-align: left;" data-is-only-head="false" title="Subtitle" data-field="subtitle">IDC </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Genre" data-field="genre">
												            Genre
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Folder" data-field="id_folder">
												            Folder
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Duration" data-field="duration">
												            Duration
												            <div></div>
												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Creation time

												         </th>
												         <th class="" style="text-align: left;" data-is-only-head="false" title="Creation time" data-field="ctime">
												            Modified time

												         </th>
												      </tr>
												   </thead>
												   <tbody>
												   	<?php
										        	if(is_array($trash) && $trash['count']>0){						        											$counter = 1;
														foreach($trash['data'] as $trashAssets){
															?>
															<tr>
																<td><?php echo $counter;?></td>
																<td><a href="<?php echo site_url();?>editasset/<?php echo $trashAssets['id'];?>/<?php echo $this->uri->segment(2);?>"><?php echo $trashAssets['title']; ?></a></td>
																<td><?php echo subTitle($trashAssets['subtitle']);?></td>
																<td><?php echo subTitle($trashAssets['idec']);?></td>
																<td><?php echo subTitle($trashAssets['gener']);?></td>
																<td><span class="folder" style="background-color:#<?php echo base_convert($settings['data']['folders'][$trashAssets['id_folder']]['color'], 10, 16);?>"><?php echo $settings['data']['folders'][$trashAssets['id_folder']]['title'];?></span></td>

																<td><?php echo convertToDHMS($trashAssets['duration']);?></td>
																<td><?php echo convertoTimeFormat($trashAssets['ctime']);?></td>
																<td><?php echo convertoTimeFormat($trashAssets['mtime']);?></td>
															</tr>
															<?php
															$counter++;
														}
													}else{
														?>
													<tr><td  colspan="9">No Record Found</td></tr>
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
					</div>
					</div>
        		</div>
        	</div>
        </div>
    </div>
</main>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <video id="videoTAG" controls autoplay style="width:100%;" >
        	<source src="#" type="video/webm"></source>
        	<source src="#" type="video/mp4"></source>
        	<source src="#" type="video/ogg"></source>
        </video>
      </div>
    </div>

  </div>
</div>
