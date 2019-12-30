<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
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
z-index: 9999;

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
    background-image: url("public/site/main/img/glyphicons-halflings.png");
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
</style>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo site_url();?>">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>rundowns">Rundowns</a></li>
        <li class="breadcrumb-item active">New Rundown</li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
             <form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>nebula/saveRundown" enctype="multipart/form-data">
             <div class="card-header">Add New Rundown</div>
				<div class="card-body">
				<div class="row">
                        <!-- ========= Section One Start ========= -->
                        <div class="col-lg-12 col-12-12">

      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="content-box config-contentonly">
                                <div class="config-container">
                                    <div class="row">
                        <div class="col-lg-6 p-t-15">
                            <div class="form-group col-lg-11">
                                <div class="row">
                                    <label>Title <span class="mndtry">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" required="true"/>
                                </div>
                            </div>
							<div class="form-group col-lg-11">
                                <div class="row">
                                    <label>Rundown Engine <span class="mndtry">*</span></label>

                                   <select class="form-control selectpicker" name="engine_id" id="engine_id" required="true">
                                        <option value="">- Select Engine -</option>
                                        <?php
                                        if(sizeof($encoders)>0)
			                        	{
											foreach($encoders as $encode)
											{
											?>
												<!--<option value="encoder_<?php echo $encode['id'];?>"><?php echo $encode['encoder_name'];?></option>-->
											<?php
											}
										}
										if(sizeof($nebula)>0)
			                        	{
											foreach($nebula as $encd)
											{
											?>
												<option value="nebula_<?php echo $encd['id'];?>"><?php echo $encd['encoder_name'];?></option>
											<?php

											}
										}
                                        ?>
                                    </select>
                                </div>
                            </div>
                            </div>

							<div class="col-lg-6 p-t-15">
                <div class="form-group col-lg-11" style="margin-bottom: 10px;">
                                <div class="row form-group check-input">
                                <div class="boxes">
										<input class="checkbox" id="is_scheduled" name="is_scheduled" type="checkbox">
                                        <label for="is_scheduled"></label>
									</div>
                                    <label style="padding-left: 20px;line-height:15px;">Enable Schedule</label>

                                </div>
                            </div>
                            <div class="form-group col-lg-11 pdleft" style="margin-bottom: 40px;">
                                <div class="col-md-12 pdleft">
                            		 <label>Start Time</label>
                                 <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                   <div id="datetimepicker_schedule_start_time" class="input-append date">
                                     <div class="input-group">
                                       <div class="input-group-prepend">
                                         <span class="input-group-text">
                                           <i class="icon-calendar"></i>
                                         </span>
                                       </div>
                                       <input id="rundown_starttime" name="rundown_starttime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                                     </div>
                                   </div>
                                 </div>
								  </div>
                            	<div class="col-md-12 pdleft">
                            		 <label>End Time</label>
                                 <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                   <div id="datetimepicker_schedule_start_time" class="input-append date">
                                     <div class="input-group">
                                       <div class="input-group-prepend">
                                         <span class="input-group-text">
                                           <i class="icon-calendar"></i>
                                         </span>
                                       </div>
                                       <input id="rundown_endtime" name="rundown_endtime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
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
        <div class="card-footer">
          <button class="btn btn-sm btn-primary" type="submit">Save</button>
            <button class="btn btn-sm btn-danger" type="reset">Reset</button>
            </div>
            </form>
			</div>
		</div>
	</div>
</main>
