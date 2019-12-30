<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>applications">Apps</a></li>
        <li class="breadcrumb-item active">New Application</li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
             <form class="form-only form-one" method="post" action="<?php echo site_url();?>admin/saveCreateVod" enctype="multipart/form-data">
             <div class="card-header">Add New Application</div>
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
               <div class="col-lg-12 col-12-12">
                <div class="content-box config-contentonly">

                     <div class="config-container" id="wowza_form">



                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						    <div class="wowza-form col-lg-12 conf" id="wowza_form ">
			</div>
                               <div class="row">
                               	 <div class="col-lg-6 col-md-12">
                                    <div class="form-group col-lg-12">
                                       <div class="row">
                                          <label>Application Name  <span class="mndtry">*</span></label>
                                          <input type="text" class="form-control"  placeholder="" name="application_name" id="application_name" required="true">
                                       </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                       <div class="row">
                                          <label>Live Source  <span class="mndtry">*</span></label>
                                          <select id="live_source" name="live_source" class="form-control selectpicker" onchange="showAddress(this.value);" required="true">
                                             <option value="0">-- Select --</option>
                                             <?php
                                                if(sizeof($wowzaz)>0)
                                                {
                                                	foreach($wowzaz as $wowza)
                                                	{

                                                		echo '<option value="'.$wowza['id'].'">'.$wowza['wse_instance_name'].'</option>';

                                                	}
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                       <div class="row">
                                          <!---<input type="text" class="form-control" placeholder="rtmp://192.168.1.11:1935/PL-FB-LIVE/myStream" name="wowza_path" id="block">--->
                                          <input type="text" class="form-control" name="wowza_path" id="block"  readonly="true" <i type="button" class="fa fa-edit btn btedit" onclick="enableAppEdit();"></i></input>
                                       </div>
                                    </div>
                                 </div>
                             <div class="col-lg-6">

                                <div id="player-container" style="border:1px solid #fff;height:270px;width:480px;" class="pull-right">
										<div style="height:215px;" id="player_apps" title=""></div>
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

         </div>
				</div>
        <div class="card-footer">
          <button class="btn btn-sm btn-primary" type="submit">Save</button>
            <button class="btn btn-sm btn-danger" type="reset">Reset</button>
            </div>
            </form>
			</div>
		</div>
	</div>
</main>
