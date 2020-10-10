<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<script>
  function enableEdit()
  {
  	$('#streamurl').removeAttr("readonly").css("color","#fff");
  }
  function showPages(valueofTimeline)
  {
  	if(valueofTimeline == "page")
  	{
		$('.pageslist').show();
	}
	else
	{
		$('.pageslist').hide();
	}
  }

</script>
<style type="text/css">
.btedit {

    position: absolute;
    right: 7px;
    top: 1px;
    background: none;
    color: #3C8DBC;
    font-size: 18px;
    padding: 0;
    -webkit-appearance:none;

}
.btn-github:hover {

    color: #fff;
    background-color: #2b2b2b;
    border-color: rgba(0,0,0,0.2);

}
.btn-group-sm > .btn, .btn-sm {

    padding: 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;

}

.ui-autocomplete{
	z-index: 9999;
	height: 200px !important;
	overflow-y: scroll;
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
top: 38px;
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
	.dropdown-menu li > a {

    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: normal;
    line-height: 20px;
    color: #333333;
    white-space: nowrap;

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
.timepicker-picker .btn {

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
.dropdown-menu li > a:hover, .dropdown-menu li > a:focus, .dropdown-submenu:hover > a {

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
<style type="text/css">
	.btn-github {
    color: #fff;
    background-color: #444;
    border-color: rgba(0,0,0,0.2);
}
.btn-soundcloud {

    color: #fff;
    background-color: #f50;
    border-color: rgba(0,0,0,0.2);

}
.btn-google {

    color: #fff;
    background-color: #dd4b39;
    border-color: rgba(0,0,0,0.2);

}
</style>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>applications">Apps</a></li>
        <li class="breadcrumb-item active">New Target</li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
            <?php
						$socialLogin = $this->session->userdata('socialLogin');
						if(sizeof($socialLogin) > 0)
						{
							switch($socialLogin)
							{
								case "google":
								?>
								<form class="form-only form-one" method="post" action="<?php echo site_url();?>admin/googleaccount/savetarget" enctype="multipart/form-data">
								<?php
								break;
								case "twitter":
								?>
								<form class="form-only form-one" method="post" action="<?php echo site_url();?>admin/saveTarget" enctype="multipart/form-data">
								<?php
								break;
								default:
								?>
								<form class="form-only form-one" method="post" action="<?php echo site_url();?>admin/saveTarget" enctype="multipart/form-data">
								<?php
								break;
							}
						}
						else
						{
					?>
						<form class="form-only form-one" method="post" action="<?php echo site_url();?>admin/saveTarget" enctype="multipart/form-data">
					<?php
						}
						?>

             <div class="card-header">Add New Target</div>
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

			<div class="col-lg-12 col-12-12">
	            <div class="content-box config-contentonly">
	            <div class="config-container">


      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

	  <div class="sav-btn-dv wowza-save">
					</div>
					<div class="row">
						<div class="col-lg-6 p-t-15">

							<?php
                                $socialLogin = $this->session->userdata('socialLogin');
                                if(sizeof($socialLogin)>0)
                                {
									switch($socialLogin)
	                                {
										case "facebook":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm" href="<?php echo site_url();?>admin/fb">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis">
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis">
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm btndis">
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span style="width: 100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;
										case "google":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm " href="<?php echo site_url();?>admin/googlelogin">
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis">
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm btndis">
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;
										case "twich":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm " href="<?php echo site_url();?>twitch">
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm btndis">
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>

                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;
										case "twitter":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm " href="<?php echo site_url();?>twitter">
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>

                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;
										case "twitch":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm "  href="<?php echo site_url();?>twitch">
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm btndis">
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>

                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;
										case "wowzacdn":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm " href="<?php echo site_url();?>admin/wowzacdn">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>

                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;
										case "akamai":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>

                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;
										case "cloudfront":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>

                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;


										case "rtmp":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>

                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm " href="<?php echo site_url();?>admin/rtmp">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;
										case "mpeg":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>

                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm " href="<?php echo site_url();?>admin/mpeg">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;
										case "rtp":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>

                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm " href="<?php echo site_url();?>admin/rtp">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;
										case "srt":
										?>

							 <div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm btndis" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>

                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm " href="<?php echo site_url();?>admin/srt">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
										break;
									}
								}
								else
								{
									?>
							<div class="form-group col-lg-12">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span style="width: 100%;"><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm" href="<?php echo site_url();?>admin/fb">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm" href="<?php echo site_url();?>admin/googlelogin">
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm" href="<?php echo site_url();?>twitch">
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>
                                    <a class="btn btn-twitter btn-sm" href="<?php echo site_url();?>admin/twitter">
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>
                                    <a class="btn btn-sm" style="color: #23282c; background-color: #19b7ea; border-color: #19b7ea;">
                                        <i class="fa fa-vimeo"></i>
                                            Vimeo Live
                                    </a>
                                    </div>
                                </div>
                            </div>
		                    <div class="form-group col-lg-9">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>

                                    </div>
                                </div>
                            </div>
		                    <div class="form-group col-lg-10">
                                <div class="row">
                                <span style="width:100%;"><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">

                                        <a class="btn btn-github btn-sm" href="<?php echo site_url();?>admin/rtmp">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>
                                    </div>
                                </div>
                            </div>
									<?php
								}
                            ?>



							<div class="form-group col-lg-12">
								<div class="row">
									<label>Target Name</label>
									<input type="text" class="form-control" placeholder="" name="target_name" id="target_name" required="true">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Select Application</label>
									<select class="form-control selectpicker" name="wowzaengin" id="wowzaengin" onchange="showApplicationURL(this.value);" required="true">
										<option value="0">-- Select --</option>
										 <?php																				$selected = $this->uri->segment(3);


											if(sizeof($apps)>0)
											{
												foreach($apps as $app)
												{
													if($selected != "" && $selected > 0 && $selected == $app['id'])
													{
														echo '<option selected="selected" value="'.$app['id'].'">'.$app['application_name'].'</option>';
													}
													else
													{
														echo '<option value="'.$app['id'].'">'.$app['application_name'].'</option>';
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
									if($selected != "" && $selected > 0)
									{
										$apps = $this->common_model->getApplicationStreams($selected);
										$wid = $apps[0]['live_source'];
										$wowza = $this->common_model->getWovzData($wid);
										$path = explode("/",$apps[0]['wowza_path']);
										$SURL="";
										if(sizeof($wowza)>0)
										{
											$SURL = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$apps[0]['application_name'].'/'.$path[sizeof($path)-1];
										}
										?>
										<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true" value="<?php echo $SURL; ?>" required="true">
										<i type="button" class="fa fa-edit btn btedit" onclick="enableEdit();"></i>
										<?php
									}
									else
									{
										?>
										<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true">
										<i type="button" class="fa fa-edit btn btedit" onclick="enableEdit();"></i>
										<?php
									}
									?>

								</div>
							</div>

						</div>
						<div class="col-lg-6 p-t-15" id="facebookTargetFields">

						<?php
						$youtubeData1=$this->session->userdata('youtubeData_broadid');
						$fbUser=$this->session->userdata('fbUser');
						$youtubeData=$this->session->userdata('youtubeData');
						//print_r($youtubeData);
						$facebookData = $this->session->userdata('ddd');

						if(!empty($fbUser))
						{
							?>

							<div class="form-group col-lg-12">
								<div class="btns-dv">
									<div class="row">
										<a class="btn btn-facebook btn-sm fbbutton" href="<?php echo site_url();?>admin/facebookLogout">
                                            <span id="status">
                                                <i class="fa fa-facebook"></i>
                                                 (<?php echo $fbUser['name'];?>)
                                                <img style="margin-left:7px;width:32px;" class="img-circle" src="//graph.facebook.com/<?php echo $fbUser['id'];?>/picture">
                                            </span>
                                        </a>
									</div>
								</div>
							</div>

							<?php
						}

                        $socialLogin = $this->session->userdata('socialLogin');
                        if(sizeof($socialLogin)>0)
                        {
                        	switch($socialLogin)
                        	{
								case "google":
								?>
									<input type="hidden" value="" id="broadcast_id" name="broadcast_id"/>
							<input type="hidden" value="" id="livstreamid" name="livstreamid"/>
							<div class="form-group col-lg-12 pdright">
								<div class="btns-dv">
									<div class="row">
										<a class="btn btn-google btn-sm fbbutton" href="<?php echo site_url();?>admin/cancelProvider">
                                            <span id="status">
                                                <i class="fa fa-google"></i>
                                               	  Logout
                                            </span>
                                        </a>
									</div>
								</div>
							</div>
								<?php
								break;

							}
                        }
						?>
						<input type="hidden" value="<?php if(!empty($youtubeData)) echo $youtubeData['cdn']->ingestionInfo['streamName']; else echo "";?>" id="googlestream" name="googlestream"/>


							<?php
							if(!empty($fbUser))
							{
							?>
							<input type="hidden" value="<?php echo $fbUser['id'];?>" id="fbuserid" name="fbuserid"/>
							<input type="hidden" value="<?php echo $fbUser['name'];?>" id="fbusername" name="fbusername"/>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Share On</label>
									<select class="form-control" name="timelines" id="timelines" onchange="showPages(this.value);">
										<option value="">Select An Option</option>
										<option value="timeline" >Timeline</option>
										<option value="page">Page</option>
									</select>
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Privacy</label>
									<select class="form-control" id="privacy" name="privacy">

										<option value="SELF">Only Me</option>
										<option value="ALL_FRIENDS">Friends</option>
										<option value="FRIENDS_OF_FRIENDS">Friends OF Friends</option>
										<option value="EVERYONE">Public</option>
									</select>
								</div>
							</div>
							<div class="form-group col-lg-12 pageslist" style="display:none;">
								<div class="row">
									<label>Pages</label>
									<select class="form-control " id="pagelist" name="pagelist">
									<option value="">Select</option>
									<?php
										$pages = $this->session->userdata('dfff');
										if(sizeof($pages)>0)
										{
											foreach($pages['data'] as $key=>$body)
											{
												echo '<option value="'.$body['id'].'_'.$body['access_token'].'_'.$body['name'].'">'.$body['name'].'</option>';
											}
										}
									?>
									</select>
								</div>
							</div>

							<?php
						}
						?>
							<?php
							if(sizeof($socialLogin)>0)
                            {
                        		switch($socialLogin)
                        		{
								case "google":
								?>
								<div class="form-group col-lg-12">
								<div class="row">
									<label>Privacy Status</label>
									<select class="form-control " name="privacystatus" id="privacystatus" onchange="showApplicationURL(this.value);" required="true">
										<option value="0">-- Select --</option>
										 <option value="private">Private</option>
										 <option value="public">Public</option>
										 <option value="unlisted">Unlisted</option>
									</select>
								</div>
							</div>
								<?php
								break;
								}
							}

							if(sizeof($socialLogin)>0)
							{
								if($socialLogin == "facebook" || $socialLogin == "google" || $socialLogin == "twitter" || $socialLogin == "twitch")
								{
									?>
									<div class="form-group col-lg-12">
								<div class="row">
									<label>Title</label>
									<input type="text" class="form-control" placeholder="Title of the live video post" name="title" id="title">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Description</label>
									<textarea class="form-control" rows="4" id="description" name="description"></textarea>
								</div>
							</div>
									<?php
								}
							}

							if(sizeof($socialLogin)>0)
							{
								if($socialLogin == "rtmp")
								{
									?>
									<div class="form-group col-lg-12">
										<div class="row">
											<label>RTMP Stream URL</label>
											<input type="text" class="form-control" name="rtmp_stream_url" id="rtmp_stream_url">

										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="row">
											<label>RTMP Stream Key</label>
											<input type="text" class="form-control" name="rtmp_stream_key" id="rtmp_stream_key">

										</div>
									</div>
									<div class="form-group col-lg-12 check-input">
									<div class="row">
                                    	<div class="boxes"></div>
                                        <input type="checkbox" id="target_auth" name="target_auth">
                                        <label for="target_auth" style="padding-left: 20px;line-height:15px;">Use Authentication</label>
                                    </div>
									</div>
									<div class="form-group col-lg-12">
                                    <div class="row tar-uname">

                                    	<label>Username</label>
                                    	<input type="text" class="form-control" name="target_auth_uname" id="target_auth_uname"/>
                                    </div>
									</div>
									<div class="form-group col-lg-12">
                                    <div class="row tar-pass">

                                    	<label>Password</label>
                                    	<input type="text" class="form-control" name="target_auth_pass" id="target_auth_pass"/>
                                    </div>
                                    </div>
									<?php
								}
								if($socialLogin == "twitch")
								{
									?>
									<div class="form-group col-lg-12">
										<div class="row">
											<label>Game/Category</label>
											<input type="text" class="form-control" name="twitterCat" id="twitterCat">

										</div>
									</div>
									<div class="form-group col-lg-12">
								<div class="row">
									<label>Language</label>
									<select class="form-control" name="twitterLang" id="twitterLang">
										<option value="0">-- Select --</option>

										 <?php
										 $langs = $this->common_model->getLanguages();
										 if(sizeof($langs)>0)
										 {
										 	foreach($langs as $lang)
										 	{
												?>
										 		<option value="<?php echo $lang['iso_639-1'];?>"><?php echo $lang['name'];?></option>
										 		<?php
											}
										 }
										 ?>
									</select>
								</div>
							</div>
							<div class="form-group col-lg-12">
										<div class="row">


											<label>Ingest Server</label>
											<select class="form-control " name="ingestserver" id="ingestserver">
										<option value="0">-- Select --</option>
											<?php
											$URL = "https://api.twitch.tv/kraken/ingests";
											$curl = curl_init($URL);
											curl_setopt($curl, CURLOPT_FAILONERROR, true);
											curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
											curl_setopt($curl, CURLOPT_HEADER, false);    // we want headers
											curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
											curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
											curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
											curl_setopt($curl, CURLOPT_HTTPHEADER,array('Accept: application/vnd.twitchtv.v5+json','Client-ID: kz30uug3w8b73asx3qe2q1yt98al5r'));
											$result = curl_exec($curl);
											$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
											$ingest = json_decode($result,TRUE);
											$response = array();
											if(sizeof($ingest)>0)
											{
												foreach($ingest['ingests'] as $inge)
												{
													?>
													<option value="<?php echo $inge['url_template'];?>"><?php echo $inge['name'];?></option>
													<?php
												}
											}

											?>
											</select>
										</div>
									</div>
									<?php
								}
							}
							?>
							<?php
							if(!empty($fbUser))
							{
							?>
							<div class="form-group col-lg-12 check-input ">
								<div class="row">
									<div class="boxes">
                                        <input type="checkbox" id="continuelive" name="continuelive">
                                        <label for="continuelive" style="padding-left: 20px;line-height:15px;">Send a continuous live stream</label>
                                    </div>
									<!--<label class="checkbox-inline">
									<input type="checkbox" id="continuelive" name="continuelive">
										Send a continuous live stream
									</label>-->
								</div>
							</div>
							<?php
							}
							?>

						</div>
						<div class="col-lg-6 p-t-15">
							<div class="form-group col-lg-9 check-input">
                                <div class="row">
                                	<div class="boxes">
										<input class="checkbox" id="enableTargetSchedule" name="enableTargetSchedule" type="checkbox">
                                        <label for="enableTargetSchedule" style="overflow: visible !important;"></label>
									</div>
                                    <label style="padding-left: 20px;line-height:15px;">Enable Schedule</label>

                                </div>
                            </div>
                            <div class="form-group col-lg-12 pdleft">
                                <div class=" pdleft">
                            		 <label>Start Time</label>
								  <!--<div id="datetimepicker1" class=" input-append date">-->
                  <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                    <div id="datetimepicker_schedule_start_time" class="input-append date">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="icon-calendar"></i>
                          </span>
                        </div>
                        <input name="start_date" id="start_date" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                      </div>
                    </div>
                  </div>



								  <!--</div>-->
								  </div>
                            	<div class=" pdleft">
                            		 <label>End Time</label>
                                 <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                   <div id="datetimepicker_schedule_start_time" class="input-append date">
                                     <div class="input-group">
                                       <div class="input-group-prepend">
                                         <span class="input-group-text">
                                           <i class="icon-calendar"></i>
                                         </span>
                                       </div>
                                       <input id="end_date" name="end_date" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                                     </div>
                                   </div>
                                 </div>




								  </div>


                            </div>
                            </div>
					</div>
					<!-- </div> -->
	            </div>

				</div>
			</div>
			</div>
				</div>
        <div class="card-footer">
          <button class="btn btn-sm btn-primary" type="submit">Save</button>
            <?php
						$socialLogin = $this->session->userdata('socialLogin');
						if(sizeof($socialLogin) > 0)
						{
						?>
						<a href="<?php echo site_url();?>admin/cancelProvider" class="btn btn-sm btn-danger btntop2">
							Reset
						</a>
						<?php
						}
						?>
            </div>
            </form>
			</div>
		</div>
	</div>
</main>
