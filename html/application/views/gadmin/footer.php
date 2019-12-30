   <footer class="main-footer">
            <div class="footer-container">
                <div class="row">
                    <div class="col-md-8 footer-text">Kurrent Stream Manager - Copyright Kurrent Ltd. All rights reserved<br> v1.0</div>
                    <div class="col-md-4 footer-text2"><a href="#">Technical Support <i class="fa fa-angle-up"></i></a></div>
                </div>

            </div>
        </footer>

    </div>
    <!-- ============================== Viewport Container End ============================== -->

    <!-- ========= jQuery Included ========= -->
    <script src="<?php echo site_url();?>assets/site/main/js/jquery.min.js"></script>
    <!-- === Bootstrap 3.3.7 === -->
    <script src="<?php echo site_url();?>assets/site/main/js/bootstrap.min.js"></script>
    <!-- === Date Picker === -->
    <script src="<?php echo site_url();?>assets/site/main/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo site_url();?>assets/site/main/js/bootstrap-select.min.js"></script>
    <script src="<?php echo site_url();?>assets/site/main/js/bootstrap-multiselect.js"></script>
    <!-- === Admin Min JS === -->
    <script src="<?php echo site_url();?>assets/site/main/js/admin.min.js"></script>
    <script src="<?php echo site_url();?>assets/site/main/js/sweetalert.js"></script>
    <!-- === Custom JS === -->
    <script src="<?php echo site_url();?>assets/site/main/js/custom-groupadmin.js"></script>
	<div id="profileUploadsPic" class="modal fade" role="dialog">
  	<div id="profilePic" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image file Here</span></div>
  		</div>
  </div>
  
  	<!--<script>
	$('#menu > ul li a').click(function(e) {
    var $this = $(this);
    $this.parent().siblings().removeClass('active').end().addClass('active');
   event.doDefault()
});


		</script>-->
		
		
	<script type="text/javascript">
	
$(document).ready(function(){
	var action = '<?php echo $this->uri->segment(2);?>';
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
				$('#apps a[href="' + activeTab + '"]').tab('show');
			break;
			
		}
		
	}
});

	  function processAjaxData(tabid){
		     window.history.pushState({}, "Admin | Applications",  baseURL + 'admin/applications/' + tabid);
	  }
	$(document).ready(function(){
	
	
	
	$('.nav-tabs li a').click(function(){
		var tabid = $(this).attr("id");
		if(tabid != "" && tabid != 'undefined')
		{
			switch(tabid)
			{
				case "application":
				window.history.pushState({}, "GroupAdmin | Applications",  baseURL + 'groupadmin/applications/' + tabid);
				break;
				case "target":
				window.history.pushState({}, "GroupAdmin | Applications",  baseURL + 'groupadmin/applications/' + tabid);
				break;
				case "groups":
				window.history.pushState({}, "GroupAdmin | Groups",  baseURL + 'groupadmin/clients/' + tabid);
				break;
				case "users":
				window.history.pushState({}, "GroupAdmin | Users",  baseURL + 'groupadmin/clients/' + tabid);
				break;
				case "permissions":
				window.history.pushState({}, "GroupAdmin | Permissions",  baseURL + 'groupadmin/clients/' + tabid);
				break;
				case "wowza":
				window.history.pushState({}, "GroupAdmin | Configuration",  baseURL + 'groupadmin/configuration/' + tabid);
				break;
				case "system":
				window.history.pushState({}, "GroupAdmin | Configuration",  baseURL + 'groupadmin/configuration/' + tabid);
				break;
				case "encoders":
				window.history.pushState({}, "GroupAdmin | Configuration",  baseURL + 'groupadmin/configuration/' + tabid);
				break;
			}
		}
		
	});	
		
	$('#streamurl').css("color","#999999");
  	$('#streamurl').blur(function(){  		
  		$('#streamurl').attr("readonly",true);
  		$('#streamurl').css("color","#999999");
  	});
  });
	$('#uploadprofilepic').click(function(){ $('#groupfile').trigger('click'); });
		$('#add_wowza').click(function(){
			$('#wowza_form').css('display','block');
		})
		
		/*Dropzone.options.profilePic = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
			var url      = window.location.href; 
			var n = url.lastIndexOf("/");
			var pathtoredirect= url.substring(n);
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Profile Pic Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				$("#imgdiv").attr("src",jsresp.file_path);
				$('#profileUploadsPic').modal('hide');
				this.removeFile(file);
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: jsresp.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    sending: function(file, xhr, formData){
           formData.append("csrf_test_name", csrf_test_name);
        },      
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*",
	    maxFilesize:5,
	    parallelUploads:1
	}	*/
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
						var htmltext = "http://"+jsonResponse.data[0].ip_address+ ":"+ jsonResponse.data[0].rtmp_port+ "/" + appname + "/" + jsonResponse.data[0].stream_name;
						
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
	if(array_key_exists('isLock',$userdata))
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
	