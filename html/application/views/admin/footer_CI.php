   <footer class="main-footer">
            <div class="footer-container">
                <div class="row">
                    <div class="col-md-8 footer-text">ioHub - Copyright Kurrent Ltd. All rights reserved<br> v1.0</div>
                    <div class="col-md-4 footer-text2"><a href="#">Technical Support <i class="fa fa-angle-up"></i></a></div>
                </div>

            </div>
        </footer>

    </div>
      <script type="text/javascript">
    	var netdataTheme = 'slate'; // this is dark
	// Set the default netdata server.
	// on charts without a 'data-host', this one will be used.
	// the default is the server that dashboard.js is downloaded from.
	//var netdataServer = 'http://152.115.45.153:19999/'
	

    </script>
    <!-- ============================== Viewport Container End ============================== -->

    <!-- ========= jQuery Included ========= -->
    
    <script src="<?php echo site_url();?>assets/site/main/js/jquery.min.js"></script>
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
    <!-- === Bootstrap 3.3.7 === -->
    <script src="<?php echo site_url();?>assets/site/main/js/jquery-ui.js"></script>
    <!--<script src="<?php echo site_url();?>assets/site/main/js/jquery-ui.min.js"></script>-->
    
    <script src="<?php echo site_url();?>assets/site/main/bootstrap/js/bootstrap.min.js"></script>
    <!-- === Date Picker === -->   
    <script src="<?php echo site_url();?>assets/site/main/js/bootstrap-datetimepicker.min.js"></script>
  
<!--<script src="<?php echo site_url();?>assets/site/main/js/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>-->
        <script src="<?php echo site_url();?>assets/site/main/js/bootstrap-select.min.js"></script>
      <script src="<?php echo site_url();?>assets/site/main/js/bootstrap-multiselect.js"></script>
    
    <script src="<?php echo site_url();?>assets/site/main/js/datatables.min.js"></script>
    <script src="<?php echo site_url();?>assets/site/main/js/admin.min.js"></script>
    <script src="<?php echo site_url();?>assets/site/main/js/sweetalert.js"></script>
       <script src="<?php echo site_url();?>assets/site/main/js/toastr.min.js"></script>
       <!-- fullCalendar -->
	<script src="<?php echo site_url();?>assets/site/main/js/moment.js"></script>
	<script src="<?php echo site_url();?>assets/site/main/js/fullcalendar.min.js"></script>
	   <script src="<?php echo site_url();?>assets/site/main/js/jquery.flowchart.js"></script>
	 <script type="text/javascript" src="<?php echo site_url();?>assets/site/main/js/highcharts.js"></script>
	<script type="text/javascript" src="<?php echo site_url();?>assets/site/main/js/exporting.js"></script> 
    <script src="<?php echo site_url();?>assets/site/main/js/custom.js"></script>
     <script src="<?php echo site_url();?>assets/site/main/js/workflow.js"></script>
   <script src="<?php echo site_url();?>assets/site/main/js/swfobject.min.js"></script>
   <script src="<?php echo site_url();?>assets/site/main/js/net_js_main.js"></script>  
   <script src="<?php echo site_url();?>assets/site/main/js/piecircle.js"></script> 
   <!--  404 Start-->
   	<script src="<?php echo site_url();?>assets/site/main/js/jquery.vide.min.js"></script>
	<!-- Waypoints -->
	<script src="<?php echo site_url();?>assets/site/main/js/jquery.waypoints.min.js"></script>
	<!-- Main JS -->
	<script src="<?php echo site_url();?>assets/site/main/js/main.js"></script> 
	
	<!--  404 Start-->
     <script src="<?php echo site_url();?>assets/site/main/js/jquery.countdownTimer.min.js"></script>
	 <script src="<?php echo site_url();?>assets/site/main/js/jstz.min.js"></script>
	 <script src="<?php echo site_url();?>assets/site/main/js/jClocksGMT.js"></script>
     <script src="<?php echo site_url();?>assets/site/main/js/jquery.rotate.js"></script>
     <script src="<?php echo site_url();?>assets/site/main/js/ion.rangeSlider.min.js"></script>
      <script type="text/javascript">
     
      	if(Action == "dashboard" || Action == "editEncoder" || Action == "editGateway" || Action == "updatewowzaengin" || Action == "configuration")
      	{     		
			var my_awesome_script = document.createElement('script');
			my_awesome_script.setAttribute('src',baseURL+'assets/site/main/js/dashboard.js?v20170724-7');
			document.head.appendChild(my_awesome_script);
		}
		if(Action == "channels")
      	{     		
			setInterval(upTime, 1000);
		}
		
      </script>   
      
    <script src="<?php echo site_url();?>assets/site/main/js/custom-kurrent.js"></script>
 
    
    <script type="text/javascript"> 

		if(Action == "dashboard" || Action == "editEncoder" || Action == "editGateway" || Action == "updatewowzaengin")
      	{
      		
      		NETDATA.options.current.destroy_on_hide = true;
			// set this to false, to always show all dimensions
			NETDATA.options.current.eliminate_zero_dimensions = true;
			// lower the pressure on this browser
			NETDATA.options.current.concurrent_refreshes = false;
			// if the tv browser is too slow (a pi?)
			// set this to false
			NETDATA.options.current.parallel_refresher = true;
			//NETDATA.options.current.stop_updates_when_focus_is_lost = false;
			// always update the charts, even if focus is lost
			// NETDATA.options.current.stop_updates_when_focus_is_lost = false;
			// Since you may render charts from many servers and any of them may
			// become offline for some time, the charts will break.
			// This will reload the page every RELOAD_EVERY minutes
	      		var RELOAD_EVERY = 5;
					setTimeout(function(){
				    location.reload();
				}, RELOAD_EVERY * 60 * 1000);
		}		
    </script>
	<div id="profileUploadsPic" class="modal fade" role="dialog">
  	<div id="profilePic" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image file Here</span></div>
  		</div>
  </div>
  <script>
    //var timezone = jstz.determine(); 
    //console.log(new Date().toLocaleString('en-US', { timeZone: timezone.name() }));
    </script>
<script type="text/javascript">

$(document).ready(function(){
 	
	$("#rangeslider").ionRangeSlider({
    type: "single",
    min: -20,
    max: 20,
    step: 5,
    grid: true,
    grid_snap: true,
    prettify: function (num) {
        //var m = moment(num, "X").locale("ja");
        return num + "dB";
    }
});

	var d = new Date().toLocaleString('en-US', { timeZone: 'Europe/Copenhagen' });
	var offsetdd = $('#current_timer').attr("title");
	$('#current_timer').jClocksGMT(
    {
    	titel:'',
        offset: offsetdd,
        timeformat: 'HH:mm:ss',
        digital:true,
        analog:false
    });
    $('#datetimepicker1').datetimepicker();
    $('#datetimepicker2').datetimepicker();
     $('#datetimepicker3').datetimepicker();
    $('#datetimepicker4').datetimepicker();
    
    $('#datetimepicker_schedule_start_time').datetimepicker();
    $('#datetimepicker_schedule_end_time').datetimepicker();
    
    $('#edit_datetimepicker_schedule_start_time').datetimepicker();
    $('#edit_datetimepicker_schedule_end_time').datetimepicker();
    
    $('#datetimepicker_schedule_target_starttime').datetimepicker();
    $('#datetimepicker_schedule_target_endtime').datetimepicker();
    
    $('#edit_datetimepicker_schedule_target_starttime').datetimepicker();
    $('#edit_datetimepicker_schedule_target_endtime').datetimepicker();
    //$('.datetimepicker').datetimepicker();
    //$('#target_startendtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: {format: 'MM/DD/YYYY h:mm A'}});
	/*$("#current_timer").countdowntimer({
		//dateAndTime :d,
	currentTime:true,
	displayFormat:"DHMS"
	});*/
	$('#twitter-widget-0').removeAttr("style");
	$('#twitter-widget-0').css({"width":"100%","max-width":"100%"});
	$("#twitter-widget-0").contents().find("html").attr("style","max-width:100%;height:100%");
	$("#twitter-widget-0").contents().find("div#twitter-widget-0").attr("style","max-width:100%;height:100%");
	$("#twitter-widget-0").contents().find("div.EmbeddedTweet-tweet").attr("style","max-width:100%;height:100%");
	$('.irs-grid .irs-grid-text').each(function(){
		//$(this).text($(this).text()+ "db");	
	});
});
</script>
<script type="text/javascript">

function play() {
	
	var id = "";
	if(Segmnetthree == "offline")
	{
		id = "player_live";
	}
	else if(Segmnetthree == "live")
	{
		id = "player_live";
	}
	var src = $('#' + id).attr("title");
	
	if (src) {		
		playRTMP(src,id);
	}	
}
function playSource()
{
	var src = $('#player_source').attr("title");
	
	if($('#player_source_rtmp').length>0)
	{
		var src1 = $('#player_source_rtmp').attr("title");
		playTargetRTMP(src1,"player_source_rtmp");
	}
	if (src) {		
		playTargetRTMP(src,"player_source");
	}
}
function playStreams(id)
{
	var src = $('.' + id).val();
	if(src != "")
	{		
		src = src.replace("http","rtmp");		
		var pid= id + "_player";
		if (src) {		
			playRTMP(src,pid);
		}	
	}
	else
	{
		swal("Warning","Enter RTMP URL First!", 'warning');
	}
}
function playAppSRC(src)
{
	if(src != "")
	{		
		var id="player_apps";
		if (src) {		
			playRTMP(src,id);
		}	
	}
	else
	{
		swal("Warning","Select App First!", 'warning');
	}
}
function playApp()
{
	var src = $('#block').val();
	if(src != "")
	{
		src = src.replace("http","rtmp");	
		var id="player_apps";
		if (src) {		
			playRTMP(src,id);
		}	
	}
	else
	{
		swal("Warning","Select App First!", 'warning');
	}
}
function startPlayer()
{
	$('#statusvideo').text("Online").removeAttr('class').addClass('label label-live');
	play();
	player_live.play2();
}
function stopPlayer()
{
	var attr = $('#player_live').attr('type');	
	if(typeof attr !== typeof undefined && attr !== false)
	{
		$('#statusvideo').text("Offline").removeAttr('class').addClass('label label-gray');
		player_live.stop2();
	}
	else
	{
		toastr['warning']('Player is not started yet!');
	}
}
$(document).ready(function() {
	if(Action == "updatechannel")
	{
		play();
	}	
	if(Action == "editTarget")
	{
		playSource();
	}
	
});
$(document).on('click','.playStreams',function(){
	var id = $(this).attr('id');
	playStreams(id);
});
$(document).on('click','#playappp',function(){
	playApp();
});
$(document).on('click','.plapp',function(){
	if($(this).find('i').hasClass("fa-play"))
	{
		$(this).find('i').removeClass('fa-play');	
		$(this).find('i').addClass('fa-pause');
		var src = $(this).attr("aria-label");
		playAppSRC(src);
	}
	else if($(this).find('i').hasClass("fa-pause"))
	{
		$(this).find('i').removeClass('fa-pause');	
		$(this).find('i').addClass('fa-play');
		player_apps.stop2();
	}
	
	
	
});
function validateUrl(url) {
    if (url == "") {
        $("#url-form").removeClass("has-success");
        $("#url-form").addClass("has-error");
        $("#url-form").addClass("has-feedback");
        var helperIcon = '<span class="glyphicon glyphicon-warning-sign form-control-feedback" id="helper_icon"></span>';
        if ($("#url-form").find("#helper_icon")) {
            $("#url-form").find("#helper_icon").remove();
            $("#url-form").append(helperIcon);
        } else {
            $("#url-form").append(helperIcon);
        }
        var errorText = '<span class="help-block text-right" id="error_text">Please enter URL before play it.</span>';
        if ($("#url-form").find("#error_text")) {
            $("#url-form").find("#error_text").remove();
            $("#url-form").append(errorText);
        } else {
            $("#url-form").append(errorText);
        }
        return false;
    } else {
        $("#url-form").removeClass("has-error");
        $("#url-form").addClass("has-success");
        $("#url-form").addClass("has-feedback");
        var helperIcon = '<span class="glyphicon glyphicon-ok form-control-feedback" id="helper_icon"></span>';
        if ($("#url-form").find("#helper_icon")) {
            $("#url-form").find("#helper_icon").remove();
            $("#url-form").append(helperIcon);
        } else {
            $("#url-form").append(helperIcon);
        }
        if ($("#url-form").find("#error_text")) {
            $("#url-form").find("#error_text").remove();
        }
        return true;
    }
}
</script>
	<script type="text/javascript">

$(document).ready(function(){
	var action = '<?php echo $this->uri->segment(1);?>';
	$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
		var id = $(e.target).attr("id");
		localStorage.setItem('activeTab', $(e.target).attr('href'));
	});
	var activeTab = localStorage.getItem('activeTab');
	if(activeTab){
		switch(action)
		{
			case "clients":
				$('#clients a[href="' + activeTab + '"]').tab('show');
			break;
			case "configuration":
				$('#configuration a[href="' + activeTab + '"]').tab('show');
			break;
			case "applications":
				$('#appstarger a[href="' + activeTab + '"]').tab('show');
			break;

		}

	}
});

	$(document).ready(function(){

	$('#streamurl').css("color","#999999");
  	$('#streamurl').blur(function(){
  		$('#streamurl').attr("readonly",true);
  		$('#streamurl').css("color","#999999");
  	});
  	$('#block').css("color","#999999");
  	$('#block').blur(function(){
  		$('#block').attr("readonly",true);
  		$('#block').css("color","#999999");
  	});
  });
	
		$('#add_wowza').click(function(){
			$('#wowza_form').css('display','block');
		})

	$(function() {
	  /* Upload Profile Pic */
		//$('#profilePic').dropzone({ url: baseURL + "admin/uploadGroupPic",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});
	});
	$('#uploadprofilepic').click(function(){ $('#groupfile').trigger('click'); });

	function showApplicationURL(id)
	{
		$.ajax({
			url:baseURL + "admin/getApplicationStreams",
			type:"post",
			data:{'id':id},
			dataType:"json",
			success:function(jsonResponse){
				if(jsonResponse.status)
				{
					$('#streamurl').val(jsonResponse.data);
				}
			}
		});
	}
	function showAddress(ip)
	{
		var appname = $("#application_name").val();
		if(appname == "")
		{
			alert("Enter Application Name First");
			$('#live_source').val("0");
			$('#block').val("");
		}
		else
		{
			if(ip == 0)
			{
				$('#live_source').val("0");
				$('#block').val("");
			}
			else
			{
				$.ajax({
				url:baseURL + "admin/getIPAdressByWowaz",
				type:"post",
				data:{'id':ip},
				dataType:"json",
				success:function(jsonResponse){

					if(jsonResponse.status)
					{
						var htmltext = "rtmp://"+jsonResponse.data[0].ip_address+ ":"+ jsonResponse.data[0].rtmp_port+ "/" + appname + "/" + jsonResponse.data[0].stream_name;

						$('#block').val(htmltext);
					}
				}
			});
			}
		}
	}

	</script>
	<?php
	$userdata = $this->session->userdata('lock_data');
	if(!empty($userdata) && array_key_exists('isLock',$userdata))
	{
		$isLock = $userdata['isLock'];
		if($isLock)
		{
			?>
				<div id="divlock" class="screenunlock">
					<?php
					$this->load->view('admin/login');
					?>
				</div>
			<?php
		}
		else
		{
			?>
				<div id="divlock" class="screenlock">
					<?php
					$this->load->view('admin/login');
					?>
				</div>
			<?php
		}
	}
	else
	{
		?>
				<div id="divlock" class="screenlock">
					<?php
					$this->load->view('admin/login');
					?>
				</div>
			<?php
	}
	?>

<div class="loaddiv">
	<img src="<?php echo site_url();?>assets/site/main/img/loading.gif"/>
</div>


</body>

</html>
