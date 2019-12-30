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
.btn {

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
<!-- ========= Content Wrapper Start ========= -->
<main class="main">
				<!-- Breadcrumb-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="#">Home</a>
					</li>
          <li class="breadcrumb-item">
            <a href="extra">Extra</a>
          </li>
					<li class="breadcrumb-item active">Stream Viewer</li>
				</ol>
				<div class="container-fluid">
				<div class="animated fadeIn">
									<div class="card">
				<div class="card-body">
                    <div class="row">
                    		<div class="col-lg-12 col-12-12">
								<div class="content-box config-contentonly">
									<div class="config-container">

                        <!-- ========= Section One Start ========= -->
									 <div class="col-lg-6 pdright">
									     <div id="player-container" style="border:1px solid #fff;height:270px;width:480px;" class="pull-right">
												<div  style="width:480px;height:270px;" id="playapppone_player" title="Test"></div>
												<div id="player-tip"></div>
											</div>
										<div class="form-group pdleft pdright" style="margin-top: 8px;float: left;width: 100%;">
											<input type="text" class="form-control playapppone" id="textpalyer1" name="textpalyer1" placeholder="rtmp://www.example.com/live/stream" style="width:90%;float:left;"/>
											<button type="button" class="playStreams" id="playapppone" class="btn" style="color:#747474;width:10%;height:30px;"><i class="fa fa-play"></i></button>
										</div>
									</div>
									<div class="col-lg-6 pdright">
									     <div id="player-container" style="border:1px solid #fff;height:270px;width:480px;" class="pull-right">
												<div  style="width:480px;height:270px;" id="playappptwo_player" title="Test"></div>
												<div id="player-tip"></div>
											</div>
										<div class="form-group pdleft pdright" style="margin-top: 8px;float: left;width: 100%;">
											<input type="text" class="form-control playappptwo" id="textpalyer1" name="textpalyer1" placeholder="rtmp://www.example.com/live/stream" style="width:90%;float:left;"/>
											<button type="button" class="playStreams"  id="playappptwo" class="btn" style="color:#747474;width:10%;height:30px;"><i class="fa fa-play"></i></button>
										</div>
									</div>
									<div class="col-lg-6 pdright">
									     <div id="player-container" style="border:1px solid #fff;height:270px;width:480px;" class="pull-right">
												<div  style="width:480px;height:270px;" id="playapppthree_player" title="Test"></div>
												<div id="player-tip"></div>
											</div>
										<div class="form-group pdleft pdright" style="margin-top: 8px;float: left;width: 100%;">
											<input type="text" class="form-control playapppthree" id="textpalyer1" name="textpalyer1" placeholder="rtmp://www.example.com/live/stream" style="width:90%;float:left;"/>
											<button type="button" class="playStreams"  id="playapppthree" class="btn" style="color:#747474;width:10%;height:30px;"><i class="fa fa-play"></i></button>
										</div>
									</div>
									<div class="col-lg-6 pdright">
									     <div id="player-container" style="border:1px solid #fff;height:270px;width:480px;" class="pull-right">
												<div  style="width:480px;height:270px;" id="playapppfour_player" title="Test"></div>
												<div id="player-tip"></div>
											</div>
										<div class="form-group pdleft pdright" style="margin-top: 8px;float: left;width: 100%;">
											<input type="text" class="form-control playapppfour" id="textpalyer1" name="textpalyer1" placeholder="rtmp://www.example.com/live/stream" style="width:90%;float:left;"/>
											<button type="button" class="playStreams"  id="playapppfour" class="btn" style="color:#747474;width:10%;height:30px;"><i class="fa fa-play"></i></button>
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
            <!-- ========= Main Content End ========= -->
        </main>
        <!-- ========= Content Wrapper End ========= -->
