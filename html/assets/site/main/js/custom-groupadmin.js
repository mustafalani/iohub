var encoderInputs = [];
var channelsURLS = [];
var lockApps = [];
var sourceURL = "";
var playerId = "";
/* ================================================================ */
/*  Function for wowza Actions Dropdown & All Single Actions Start  */
/* ================================================================ */
var wowzaLength = $('.wowzaTable tr td .groupdel2').length;
var wowzaCheckedLength = 0;
$('.wowzaTable tr td .groupdel2').click(function(){

if($(this).is(":checked")== false)
	{
		if($('#selecctalladminuser').is(":checked") == true)
		{
			$('#selecctalladminuser').prop('checked', false);
		}
		wowzaCheckedLength = 0;
		$('.wowzaTable tr td .groupdel2').each(function () {
           if($(this).is(":checked")== true)
           {
		   	   wowzaCheckedLength++;
		   }
        });
        if(wowzaCheckedLength == wowzaLength)
        {
			$('#selecctalladminuser').prop('checked', true);
		}
	}
	else if($(this).is(":checked")== true)
	{
		wowzaCheckedLength = 0;
		$('.wowzaTable tr td .groupdel2').each(function () {
           if($(this).is(":checked")== true)
           {
		   	  wowzaCheckedLength++;
		   }
        });
        if(wowzaCheckedLength == wowzaLength)
        {
			$('#selecctalladminuser').prop('checked', true);
		}
	}
});
$('#selecctalladminuser').click(function (event) {
    if (this.checked) {
        $('.groupdel2').each(function () {
            $(this).prop('checked', true);
        });
    } else {
        $('.groupdel2').each(function () {
            $(this).prop('checked', false);
        });
    }
});
$('#wowzaengins .wowza_row td .wowid').each(function(){
	var obj = $(this);
	var wowzaId = $(this).attr('id');
	$.ajax({
        url: baseURL + "groupadmin/wowzastatus",
        data:{'wowzaId':wowzaId,'action':'checkStatus'},
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
			  	switch(jsonResponse.response)
                {
                    case 200:
					$(obj).parent().parent('tr').find('#status').removeAttr("class");
					$(obj).parent().parent('tr').find('#status').addClass("label label-success").text("Online");
                    break;
                    case 401:
                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
					$(obj).parent().parent('tr').find('#status').addClass("label label-auth").text("Auth Required");
                    break;
                    case "400":
                    case "402":
                    case "404":
                    case "415":
					$(obj).parent().parent('tr').find('#status').removeAttr("class");
					$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("Offline");
                    break;
                    default:
                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
					$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("Offline");
                    break;
				}
			}
			else if(jsonResponse.status == false)
			{
			  	switch(jsonResponse.response)
                {
                    case "200":
					$(obj).parent().parent('tr').find('#status').removeAttr("class");
					$(obj).parent().parent('tr').find('#status').addClass("label label-success").text("Online");
                    break;
                    case 401:
                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
					$(obj).parent().parent('tr').find('#status').addClass("label label-auth").text("Auth Required");
                    break;
                    case 402:
					$(obj).parent().parent('tr').find('#status').removeAttr("class");
					$(obj).parent().parent('tr').find('#status').addClass("label label-auth").text("Payment Required");
                    break;
                    case 404:
                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
					$(obj).parent().parent('tr').find('#status').addClass("label label-auth").text("Not Found");
                    break;
                    case 400:
                    case 415:
					$(obj).parent().parent('tr').find('#status').removeAttr("class");
					$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("Offline");
                    break;
                    default:
                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
					$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("Offline");
                    break;
				}
			}
		},
        error:function(){

		}
	});
});
$('#wowzaengins .wowza_row td .wowid').each(function(){
	var obj = $(this);
	var wowzaId = $(this).attr('id');
	$.ajax({
        url: baseURL + "groupadmin/wowzauptime",
        data:{'wowzaId':wowzaId,'action':'checkStatus'},
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.status == true)
            {
                $(obj).parent().parent('tr').find('.uptime').text(jsonResponse.response.ServerUptime);
                $(obj).parent().parent('tr').find('.wowzadisable').attr("data-original-title","CPU:"+ jsonResponse.response.CPU+"%" + " Heap: "+ jsonResponse.response.CurrentHeapSize+ " Memory: "+ jsonResponse.response.MemoryUsed+" Disk: "+ jsonResponse.response.DiskUsed);
			}
            if(jsonResponse.status == false)
            {
                $(obj).parent().parent('tr').find('.uptime').text("NA");
                $(obj).parent().parent('tr').find('.wowzadisable').attr("data-original-title","CPU: XX Heap: XX Memory: XX Disk: XX");
			}

		},
        error:function(){
			$(obj).parent().parent('tr').find('.uptime').text("NA");
                $(obj).parent().parent('tr').find('.wowzadisable').attr("data-original-title","CPU: XX Heap: XX Memory: XX Disk: XX");
		}
	});
});
$(document).on('click','.wowzareboot',function(){
	var wowzaId = $(this).attr('id');
	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to reboot this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Reboot it!",
		closeOnConfirm: false
	},
	function(){
		$.ajax({
	        url: baseURL + "groupadmin/wowzareboot",
	        data:{'wowzaId':wowzaId,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {

	              	switch(jsonResponse.response)
	                {
	                    case 200:
	                   	swal("Rebooted!", "Successfully!",'success');
	                    break;
	                    case 400:
	                    case 402:
	                    case 404:
	                    case 415:
						swal("Error!","While Rebooting!",'error');
	                    break;
	                    default:
	                    swal("Error!","While Rebooting!",'error');
	                    break;
					}
				}
	            if(jsonResponse.status == false)
	            {
					switch(jsonResponse.response)
	                {
	                    case 200:
	                   	swal("Rebooted!", "Successfully!", 'success');
	                    break;
	                    case 400:
	                    case 402:
	                    case 404:
	                    case 415:
	                  	swal("Error!","While Rebooting!","error");
	                    break;
	                    default:
	                    swal("Error!","While Rebooting22!","error");
	                    break;
					}
				}
			},
	        error:function(){
	        	swal("Error!","While Rebooting!",'error');
			}
		});
	});
});
$(document).on('click','.wowzarefresh',function(){
	var wowzaId = $(this).attr('id');
	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to refresh this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Refresh!",
		closeOnConfirm: false
	},
	function(){
		$.ajax({
	        url: baseURL + "groupadmin/wowzarefresh",
	        data:{'wowzaId':wowzaId,'action':'refresh'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					swal("Refresh!", "Successfully!", "success");
				}
	            if(jsonResponse.status == false)
	            {
					swal("Error!", jsonResponse.response, "error");
				}
			},
	        error:function(){
			}
		});
	});
});
$(document).on('click','.wowzadelete',function(){

	var wowzaId = $(this).attr('id');

	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to delete this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, delete it!",
		closeOnConfirm: false
	},
	function(){
		$.ajax({
	        url: baseURL + "groupadmin/wowzadelete",
	        data:{'wowzaId':wowzaId,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					swal("Deleted!", "Successfully!", "success");
					location.reload();
				}
	            if(jsonResponse.status == false)
	            {
					swal("Error!", jsonResponse.response, "error");
				}
			},
	        error:function(){
			}
		});
	});
});
function wowzaactions(){
	var Ids = [];
	$("input:checkbox[class=groupdel2]:checked").each(function () {
		var id = $(this).val();
		Ids.push(id);
		var action = $("#actionval").val();
		if(action != "")
		{
			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
			        url: baseURL + 'admin/wowzaActions',
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){

			        	$('.wowzaTable tr td').find("input[type='checkbox']").prop('checked',false);
			        	switch(action)
			        	{
							case "Refresh":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-success");
									}
									else if(jsonResponse.response[Ids[i]]["status"] == false)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-danger");
									}
								}
								swal( action + "!", "Successfully!", "success");
							break;
							case "Reboot":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-success");
									}
									else if(jsonResponse.response[Ids[i]]["status"] == false)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-danger");
									}
								}
								swal( action + "!", "Successfully!", "success");
							break;
							case "Delete":
							swal( action + "!", "Successfully!", "success");
							break;
						}
					},
			        error:function(){
			        	$('.wowzaTable tr td').find("input[type='checkbox']").prop('checked',false);
			        	swal("Error!", "Error Occurred while "+action+"!", "success");
					}
				});
			});
		}
		else
		{
			swal('At Least','select one action.');
		}
	});

}
/* ================================================================ */
/*  Function for wowza Actions Dropdown & All Single Actions End    */
/* ================================================================ */

/* ================================================================= */
/*  Function for Encoder Actions Dropdown & All Single Actions Start */
/* ================================================================= */
$('.encoderTable tbody tr td .enciid').each(function(){
	var obj = $(this);
	var wowzaId = $(this).attr('id');
	$.ajax({
        url: baseURL + "groupadmin/encoderUptime",
        data:{'id':wowzaId,'action':'checkStatus'},
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.response[wowzaId]['status'] == true)
            {
                $(obj).parent().parent('tr').find('.uptime').text(jsonResponse.response[wowzaId]['response']);
			}
            if(jsonResponse.response[wowzaId]['status'] == false)
            {
                $(obj).parent().parent('tr').find('.uptime').text("NA");
			}
		},
        error:function(){
			$(obj).parent().parent('tr').find('.uptime').text("NA");
                $(obj).parent().parent('tr').find('.wowzadisable').attr("data-original-title","CPU: XX Heap: XX Memory: XX Disk: XX");
		}
	});
});
var encoderLength = $('.encoderTable tr td .endcoderGrp').length;
var encoderCheckedLength = 0;
$('.encoderTable tr td .endcoderGrp').click(function(){

if($(this).is(":checked")== false)
	{
		if($('#selectallencoders').is(":checked") == true)
		{
			$('#selectallencoders').prop('checked', false);
		}
		encoderCheckedLength = 0;
		$('.encoderTable tr td .endcoderGrp').each(function () {
           if($(this).is(":checked")== true)
           {
		   	   encoderCheckedLength++;
		   }
        });
        if(encoderCheckedLength == encoderLength)
        {
			$('#selectallencoders').prop('checked', true);
		}
	}
	else if($(this).is(":checked")== true)
	{
		encoderCheckedLength = 0;
		$('.encoderTable tr td .endcoderGrp').each(function () {
           if($(this).is(":checked")== true)
           {
		   	  encoderCheckedLength++;
		   }
        });
        if(encoderCheckedLength == encoderLength)
        {
			$('#selectallencoders').prop('checked', true);
		}
	}
});
$('#selectallencoders').click(function (event) {//alert(1);
    if (this.checked) {
        $('.endcoderGrp').each(function () { //loop through each checkbox
            $(this).prop('checked', true); //check
        });
    } else {
        $('.endcoderGrp').each(function () { //loop through each checkbox
            $(this).prop('checked', false); //uncheck
        });
    }
});
$(document).on('click','.encoder_reboot',function(){
	var wowzaId = $(this).attr('id');
	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to reboot this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Reboot it!",
		closeOnConfirm: false
	},
	function(){
		$.ajax({
	        url: baseURL + "groupadmin/encoderReboot",
	        data:{'wowzaId':wowzaId,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
	              	switch(jsonResponse.response)
	                {
	                    case 200:
	                   	swal("Rebooted!", "Successfully!",'success');
	                    break;
	                    case 400:
	                    case 402:
	                    case 404:
	                    case 415:
						swal("Error!","While Rebooting!",'error');
	                    break;
	                    default:
	                    swal("Error!","While Rebooting!",'error');
	                    break;
					}
				}
	            if(jsonResponse.status == false)
	            {
					switch(jsonResponse.response)
	                {
	                    case 200:
	                   	swal("Rebooted!", "Successfully!", 'success');
	                    break;
	                    case 400:
	                    case 402:
	                    case 404:
	                    case 415:
	                  	swal("Error!","While Rebooting!","error");
	                    break;
	                    default:
	                    swal("Error!","While Rebooting22!","error");
	                    break;
					}
				}
			},
	        error:function(){
	        	swal("Error!","While Rebooting!",'error');
			}
		});
	});
});
$(document).on('click','.encoder_refresh',function(){
	var wowzaId = $(this).attr('id');
	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to refresh this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Refresh!",
		closeOnConfirm: false
	},
	function(){
		$.ajax({
	        url: baseURL + "groupadmin/encoderRefresh",
	        data:{'wowzaId':wowzaId,'action':'refresh'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					swal("Refresh!", "Successfully!", "success");
					location.reload();
				}
	            if(jsonResponse.status == false)
	            {
					swal("Error!", jsonResponse.response, "error");
				}
			},
	        error:function(){
			}
		});
	});
});
$(document).on('click','.encodersdelete',function(){

	var encodersId = $(this).attr('id');
	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to delete this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, delete it!",
		closeOnConfirm: false
	},
	function(){
		$.ajax({
	        url: baseURL + "groupadmin/encodersdelete",
	        data:{'encodersId':encodersId,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					swal("Deleted!", "Successfully!", "success");
					location.reload();
				}
	            if(jsonResponse.status == false)
	            {
					swal("Error!", jsonResponse.response, "error");
				}
			},
	        error:function(){
			}
		});
	});
});
function submitAllencoders(){
	var Ids = [];
	$("input:checkbox[class=endcoderGrp]:checked").each(function () {
		var id = $(this).val();
		Ids.push(id);
		var action = $("#actionEncoders").val();
		if(action != "")
		{
			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
			        url: baseURL + 'admin/encoderActions',
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){

			        	$('.encoderTable tr td').find("input[type='checkbox']").prop('checked',false);
			        	$('.encoderTable tr th').find("input[type='checkbox']").prop('checked',false);
			        	switch(action)
			        	{
							case "Refresh":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-success");
									}
									else if(jsonResponse.response[Ids[i]]["status"] == false)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-danger");
									}
								}
								swal( action + "!", "Successfully!", "success");
							break;
							case "Reboot":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-success");
									}
									else if(jsonResponse.response[Ids[i]]["status"] == false)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-danger");
									}
								}
								swal( action + "!", "Successfully!", "success");
							break;
							case "Delete":
							swal( action + "!", "Successfully!", "success");
							location.reload();
							break;
						}
					},
			        error:function(){
			        	swal("Error!", "Error Occured While performing actions", "error");
					}
				});
			});
		}
		else
		{
			swal('At Least','select one action.');
		}
	});
}
/* ================================================================= */
/*  Function for Encoder Actions Dropdown & All Single Actions End   */
/* ================================================================= */

/* ============================================================================ */
/*  Function for Encoder Template Actions Dropdown & All Single Actions Start   */
/* ============================================================================ */
var eTemplateLength = $('.encodingTable tr td .encodingTemplates').length;
var eTCheckedLength = 0;
$('.encodingTable tr td .enbdisb').click(function(){
		var thisObj = $(this);
		var templateId = $(this).attr("id");
		var icons = $(this).find('i').attr("class");
		var icon = icons.split(' ');
		var act = "";
		if(icon[1] == "fa-check-circle")
		{
			act = "Disable";
		}
		else if(icon[1] == "fa-ban")
		{
			act = "Enable";
		}
		swal({
				title: "Are you sure?",
				text: "You want to "+act+" this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes "+act+" it!",
				closeOnConfirm: false
			},
		function(){
				$.ajax({
			        url: baseURL + "groupadmin/templateEnableDisable",
			        data:{'templateId':templateId,'action':act},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
							swal('Success!', act + ' Successfully!','success');

							if(icon[1] == "fa-check-circle")
							{
								$(thisObj).find('i').removeClass("fa-check-circle");
								$(thisObj).find('i').addClass("fa fa-ban");
								$(thisObj).parent().parent().find("#status").removeClass("label-success");
								$(thisObj).parent().parent().find("#status").addClass("label-danger");
								$(thisObj).parent().parent().find("#status").text("Disabled");
							}
							else if(icon[1] == "fa-ban")
							{
								$(thisObj).find('i').removeClass("fa-ban");
								$(thisObj).find('i').addClass("fa-check-circle");
								$(thisObj).parent().parent().find("#status").removeClass("label-danger");
								$(thisObj).parent().parent().find("#status").addClass("label-success");
								$(thisObj).parent().parent().find("#status").text("Enabled");
							}
						}
			            if(jsonResponse.status == false)
			            {
							swal('Error','Error Occured While '+act+'!','error');

						}
					},
			        error:function(){
			        	swal('Error','Error Occured While '+act+'!','error');
					}
				});
			});
	});
$('.encodingTable tr td .deleteEncodingTempate').click(function(){
		var thisObj = $(this);
		var templateId = $(this).attr("id");
		swal({
				title: "Are you sure?",
				text: "You want to Delete this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes delete it!",
				closeOnConfirm: false
			},
		function(){
				$.ajax({
			        url: baseURL + "groupadmin/templateDelete",
			        data:{'templateId':templateId},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
							swal('Success!','Deleted Successfully!','success');
							location.reload();
						}
			            if(jsonResponse.status == false)
			            {
							swal('Error','Error Occured While Deleting!','error');

						}
					},
			        error:function(){
			        	swal('Error','Error Occured While Deleting!','error');
					}
				});
			});
	});
$('.encodingTable tr td .encodingTemplates').click(function(){

if($(this).is(":checked")== false)
	{
		if($('#eTemplateall').is(":checked") == true)
		{
			$('#eTemplateall').prop('checked', false);
		}
		eTCheckedLength = 0;
		$('.encodingTable tr td .encodingTemplates').each(function () {
           if($(this).is(":checked")== true)
           {
		   	   eTCheckedLength++;
		   }
        });
        if(eTCheckedLength == eTemplateLength)
        {
			$('#eTemplateall').prop('checked', true);
		}
	}
	else if($(this).is(":checked")== true)
	{
		eTCheckedLength = 0;
		$('.encodingTable tr td .encodingTemplates').each(function () {
           if($(this).is(":checked")== true)
           {
		   	  eTCheckedLength++;
		   }
        });
        if(eTCheckedLength == eTemplateLength)
        {
			$('#eTemplateall').prop('checked', true);
		}
	}
});
$('#eTemplateall').click(function (event) {//alert(1);
    if (this.checked) {
        $('.encodingTemplates').each(function () { //loop through each checkbox
            $(this).prop('checked', true); //check
        });
    } else {
        $('.encodingTemplates').each(function () { //loop through each checkbox
            $(this).prop('checked', false); //uncheck
        });
    }
});
function submitAllencodingTemplate(eurl)
{
	var Ids = [];
	$("input:checkbox[class=encodingTemplates]:checked").each(function () {
		var thisobj = $(this);
		var id = $(this).attr("id");
		var ieT = id.split('_');
		Ids.push(ieT[1]);
		var action = $("#enctempactionval").val();
		if(action != "")
		{
			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
			        url: baseURL + eurl,
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
			            	if(action == "Enable")
			            	{
			            		for(var i=0; i<Ids.length; i++)
			            		{
									$("#templateAction_"+ Ids[i]).parent().parent().parent().find("#status").text("Enabled");
									$("#templateAction_"+ Ids[i]).parent().parent().parent().find("#status").removeClass("label-danger");
									$("#templateAction_"+ Ids[i]).parent().parent().parent().find("#status").addClass("label-success");
									$("#templateAction_"+ Ids[i]).parent().parent().parent().find('.enbdisb').find('i').removeClass("fa-ban");
									$("#templateAction_"+ Ids[i]).parent().parent().parent().find('.enbdisb').find('i').addClass("fa fa-check-circle");
								}
							}
							else if(action == "Disable")
			            	{
			            		for(var i=0; i<Ids.length; i++)
			            		{
									$("#templateAction_"+ Ids[i]).parent().parent().parent().find("#status").text("Disabled");
									$("#templateAction_"+ Ids[i]).parent().parent().parent().find("#status").removeClass("label-success");
									$("#templateAction_"+ Ids[i]).parent().parent().parent().find("#status").addClass("label-danger");
									$("#templateAction_"+ Ids[i]).parent().parent().parent().find('.enbdisb').find('i').removeClass("fa-check-circle");
									$("#templateAction_"+ Ids[i]).parent().parent().parent().find('.enbdisb').find('i').addClass("fa fa-ban");
								}
							}
							swal( action + "!", "Successfully!", "success");
						}
			            if(jsonResponse.status == false)
			            {
							swal("Error!", jsonResponse.response, "error");
						}
					},
			        error:function(){
					}
				});
			});
		}
		else
		{
			swal('At Least','select one action.');
		}
	});
}
/* ============================================================================ */
/*  Function for Encoder Template Actions Dropdown & All Single Actions End   */
/* ============================================================================ */
/* ================================================================= */
/* Function for Channels Actions Dropdown & All Single Actions Start */
/* ================================================================= */
var channelsLength = $('.channelTable tr td .channelActions').length;
var channelCheckedLength = 0;
$('.channelTable tr td .channelActions').click(function(){

if($(this).is(":checked")== false)
	{
		if($('#allChannels').is(":checked") == true)
		{
			$('#allChannels').prop('checked', false);
		}
		channelCheckedLength = 0;
		$('.channelTable tr td .channelActions').each(function () {
           if($(this).is(":checked")== true)
           {
		   	   channelCheckedLength++;
		   }
        });
        if(channelCheckedLength == wowzaLength)
        {
			$('#allChannels').prop('checked', true);
		}
	}
	else if($(this).is(":checked")== true)
	{
		channelCheckedLength = 0;
		$('.channelTable tr td .channelActions').each(function () {
           if($(this).is(":checked")== true)
           {
		   	  channelCheckedLength++;
		   }
        });
        if(channelCheckedLength == channelsLength)
        {
			$('#allChannels').prop('checked', true);
		}
	}
});
$('#allChannels').click(function (event) {
    if (this.checked) {
        $('.channelActions').each(function () {
            $(this).prop('checked', true);
        });
    } else {
        $('.channelActions').each(function () {
            $(this).prop('checked', false);
        });
    }
});
function submitChannels()
{
	var Ids = [];
	$("input:checkbox[class=channelActions]:checked").each(function () {
		var ids = $(this).attr("id");
		var ids = ids.split('_');
		Ids.push(id);
		var action = $("#actionChannels").val();
		if(action != "" && action == "Restart" && action == "Delete")
		{
			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
			        url: baseURL + 'admin/channelActions',
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){

			        	$('.channelTable tr td').find("input[type='checkbox']").prop('checked',false);
			        	$('.channelTable tr th').find("input[type='checkbox']").prop('checked',false);
			        	switch(action)
			        	{
							case "Refresh":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-success");
									}
									else if(jsonResponse.response[Ids[i]]["status"] == false)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-danger");
									}
								}
								swal( action + "!", "Successfully!", "success");
							break;
							case "Reboot":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-success");
									}
									else if(jsonResponse.response[Ids[i]]["status"] == false)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-danger");
									}
								}
								swal( action + "!", "Successfully!", "success");
							break;
							case "Delete":
							swal( action + "!", "Successfully!", "success");
							location.reload();
							break;
						}
					},
			        error:function(){
			        	swal("Error!", "Error Occured While performing actions", "error");
					}
				});
			});
		}
		else
		{
			swal('At Least','select one action.');
		}
	});
}
/* ================================================================= */
/* Function for Channels Actions Dropdown & All Single Actions End */
/* ================================================================= */

/* ================================================================= */
/* Function for Apps Actions Dropdown & All Single Actions Start */
/* ================================================================= */
$(document).on('click','.appsfresh',function(){
	var appid = $(this).attr('id');
	var objj = $(this);
	var action = "";
	var isPerform = 0;
	var idd = appid.split('_');
	var storedAppLocks = JSON.parse(localStorage.getItem("applock"));
	if(storedAppLocks !== undefined && storedAppLocks != null && storedAppLocks.length > 0)
	{
		if(storedAppLocks.indexOf("lock_"+ idd[1]) != -1)
		{
			isPerform = 1;
			swal('Information','You cant perform this action on locked APP','warning');
		}
	}
	if(isPerform == 0)
	{
		swal({
			title: "Are you sure?",
			text: "You want to Reboot this!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, Reboot!",
			closeOnConfirm: false
		},
		function(){
			$.ajax({
		        url: baseURL + "groupadmin/applicaitonRestart",
		        data:{'wowzaId':appid,'action':'Reboot'},
		        type:'post',
		        dataType:'json',
		        success:function(jsonResponse){
		            if(jsonResponse.status == true)
		            {
						swal("Refresh!", "Successfully!", "success");
					}
		            if(jsonResponse.status == false)
		            {
						swal("Error!", jsonResponse.response, "error");
					}
				},
		        error:function(){
				}
			});
		});
	}
});
$(document).on('click','.appscopy',function(){
	var appid = $(this).attr('id');
	var objj = $(this);
	var action = "";	var isPerform =0;
	var idd = appid.split('_');
	var storedAppLocks = JSON.parse(localStorage.getItem("applock"));
	if(storedAppLocks !== undefined && storedAppLocks != null && storedAppLocks.length > 0)
	{
		if(storedAppLocks.indexOf("lock_"+ idd[1]) != -1)
		{
			isPerform = 1;
			swal('Information','You cant perform this action on locked APP','warning');
		}
	}
	if(isPerform == 0)
	{
			swal({
				title: "Are you sure?",
				text: "You want to copy this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, Copy it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
			        url: baseURL + "groupadmin/copyApplication",
			        data:{'appid':appid,'action':'delete'},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
							swal("Deleted!", "Successfully!", "success");
							location.reload();
						}
			            if(jsonResponse.status == false)
			            {
							swal("Error!", jsonResponse.response, "error");
						}
					},
			        error:function(){
					}
				});
			});
	}
	else
	{

	}

});
$(document).on('click','.appsdel',function(){
	var appid = $(this).attr('id');	var objj = $(this);
	var idd = appid.split('_');
	var action = "";var isPerform =0;
	var storedAppLocks = JSON.parse(localStorage.getItem("applock"));
	if(storedAppLocks !== undefined && storedAppLocks != null && storedAppLocks.length > 0)
	{
		if(storedAppLocks.indexOf("lock_"+ idd[1]) != -1)
		{
			isPerform = 1;
			swal('Information','You cant perform this action on locked APP','warning');
		}
	}
	if(isPerform == 0)
	{
		swal({
			title: "Are you sure?",
			text: "You want to delete this!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false
		},
		function(){
			$.ajax({
		        url: baseURL + "groupadmin/deleteApplication",
		        data:{'appid':appid,'action':'delete'},
		        type:'post',
		        dataType:'json',
		        success:function(jsonResponse){
		            if(jsonResponse.status == true)
		            {
						swal("Deleted!", "Successfully!", "success");
						location.reload();
					}
		            if(jsonResponse.status == false)
		            {
						swal("Error!", jsonResponse.response, "error");
					}
				},
		        error:function(){
				}
			});
		});
	}
});
$('.appsTable tr td .appsLock').each(function(){
	var storedAppLocks = JSON.parse(localStorage.getItem("applock"));
	if(storedAppLocks !== undefined && storedAppLocks != null && storedAppLocks.length > 0)
	{
		for(var i=0;i<storedAppLocks.length; i++)
		{
			if(storedAppLocks.indexOf($(this).attr('id')) != -1)
			{
				$(this).find('i').removeAttr('class');
				$(this).find('i').addClass('fa fa-lock');
			}
		}
	}
});
$(document).on('click','.appsLock',function(){
	var id = $(this).attr("id");
	var cls = $(this).find('i').attr('class');
	var classNames = cls.split(' ');
	if(classNames[1] == "fa-unlock")
	{
		lockApps.push(id);
		$(this).find('i').removeClass('fa-unlock');
		$(this).find('i').addClass('fa-lock');
	}
	else if(classNames[1] == "fa-lock")
	{
		lockApps.pop(id);
		$(this).find('i').removeClass('fa-lock');
		$(this).find('i').addClass('fa-unlock');
	}
	localStorage.setItem("applock", JSON.stringify(lockApps));

});
function submitAllApps(appurl)
{
	var Ids = [];



	$("input:checkbox[class=appActions]:checked").each(function () {
		var appid = $(this).attr("id");
		var id = appid.split('_');
		Ids.push(id[1]);
		var action = $("#actionappval1").val();
		if(action != "" && action != "Lock" && action != "Un-Lock")
		{
			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
			        url: baseURL + appurl,
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
							swal( action , "Successfully!", "success");
							location.reload();
						}
			            if(jsonResponse.status == false)
			            {
							swal("Error!", jsonResponse.response, "error");
						}
					},
			        error:function(){
					}
				});
			});
		}
		else
		{
			swal("At least",'select one action');
		}
	});
}
/* ================================================================= */
/* Function for Apps Actions Dropdown & All Single Actions End */
/* ================================================================= */


$(window).bind('beforeunload',function(){
    $('.loaddiv').show();
    $('body').css('overflow','hidden');
    $('.loaddiv').css('height',$(window).height());
});
 $(window).on('load',function() {
    $('.loaddiv').hide();
    $('body').css('overflow','scroll');
  });
$(document).ready(function(){
	$('#divlock').css('height',$(window).height());
	$('#encoder_inputs').multiselect();
	$('#encoder_output').multiselect();
	$('.datepicker2').datepicker({
	    format: 'dd/mm/yyyy'
	});

	 $('[data-toggle="tooltip"]').tooltip();



	 /* Encoders Actions Start */

	 /* Encoders Actions End */
	  /* Encoders Template Actions Start */

	 /* Encoders Template Actions End */


	 /* Apps Actions Start */
	 var appLength = $('.appsTable tr td .appActions').length;
	    var appCheckedLength = 0;
	 	$('.appsTable tr td .appActions').click(function(){

	 		if($(this).is(":checked")== false)
			{
				if($('#selectallApps').is(":checked") == true)
				{
					$('#selectallApps').prop('checked', false);
				}
				appCheckedLength = 0;
				$('.appsTable tr td .appActions').each(function () {
	               if($(this).is(":checked")== true)
	               {
				   	   appCheckedLength++;
				   }
	            });
	            if(appCheckedLength == appLength)
	            {
					$('#selectallApps').prop('checked', true);
				}
			}
			else if($(this).is(":checked")== true)
			{
				appCheckedLength = 0;
				$('.appsTable tr td .appActions').each(function () {
	               if($(this).is(":checked")== true)
	               {
				   	  appCheckedLength++;
				   }
	            });
	            if(appCheckedLength == appLength)
	            {
					$('#selectallApps').prop('checked', true);
				}
			}
	 	});
	  $('#selectallApps').click(function (event) {//alert(1);
        if (this.checked) {
            $('.appActions').each(function () { //loop through each checkbox
                $(this).prop('checked', true); //check
            });
        } else {
            $('.appActions').each(function () { //loop through each checkbox
                $(this).prop('checked', false); //uncheck
            });
        }
    });

	 /* Apps Actions End*/
	  /* Target Actions Start */
	 var tarLength = $('.targetTable tr td .targetactions').length;
	    var tarCheckedLength = 0;
	 	$('.targetTable tr td .targetactions').click(function(){
	 		if($(this).is(":checked")== false)
			{
				if($('#selectalltargets').is(":checked") == true)
				{
					$('#selectalltargets').prop('checked', false);
				}
				tarCheckedLength = 0;
				$('.targetTable tr td .targetactions').each(function () {
	               if($(this).is(":checked")== true)
	               {
				   	   tarCheckedLength++;
				   }
	            });
	            if(tarCheckedLength == tarLength)
	            {
					$('#selectalltargets').prop('checked', true);
				}
			}
			else if($(this).is(":checked")== true)
			{
				tarCheckedLength = 0;
				$('.targetTable tr td .targetactions').each(function () {
	               if($(this).is(":checked")== true)
	               {
				   	  tarCheckedLength++;
				   }
	            });
	            if(tarCheckedLength == tarLength)
	            {
					$('#selectalltargets').prop('checked', true);
				}
			}
	 	});
	  $('#selectalltargets').click(function (event) {//alert(1);
        if (this.checked) {
            $('.targetactions').each(function () { //loop through each checkbox
                $(this).prop('checked', true); //check
            });
        } else {
            $('.targetactions').each(function () { //loop through each checkbox
                $(this).prop('checked', false); //uncheck
            });
        }
    });
    $('.targetTable tr td .targenbdib').click(function(){
    	var thisObj = $(this);
		var targetId = $(this).attr("id");
		var className = $(this).find('i').attr("class");
		var cname = className.split(' ');
		var action ="";
		if(cname[1] == "fa-play")
		{
			action = "Start";
		}
		else if(cname[1] == "fa-pause")
		{
			action = "Stop";
		}
		if($(this).parent().parent().find('#status').text() !== "NA" && $(this).parent().parent().find('#status').text() !== "Error")
		{

			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes " + action + " it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
			        url: baseURL + "groupadmin/targetStartStop",
			        data:{'targetId':targetId,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
								switch(jsonResponse.code)
				                {
				                    case 200:
				                    if(cname[1] == "fa-play")
									{
										$(thisObj).find('i').attr("class","fa fa-pause");
									}
									else if(cname[1] == "fa-pause")
									{
										$(thisObj).find('i').attr("class","fa fa-play");
									}
				                   	swal("Start", "Successfully!",'success');
				                    break;
				                    case 400:
				                    swal("Error", "While " + action + "ing",'error');

				                    break;
				                    case 402:
				                    case 404:
				                    swal("Error", "While " + action + "ing",'error');
				                    break;
				                    case 415:
									swal("Error", "While " + action + "ing",'error');
				                    break;
				                    case 500:
									swal("Error", "While " + action + "ing",'error');
				                    break;
								}
								switch(jsonResponse.response)
				                {
				                    case "Disabled":
									$(thisObj).parent().parent('tr').find('#status').removeAttr("class");
									$(thisObj).parent().parent('tr').find('#status').addClass("label label-gray").text("Disabled");
				                    break;
				                     case "Active":
									$(thisObj).parent().parent('tr').find('#status').removeAttr("class");
									$(thisObj).parent().parent('tr').find('#status').addClass("label label-success").text("Active");
				                    break;
				                    case "Waiting...":
				                    $(thisObj).parent().parent('tr').find('#status').removeAttr("class");
									$(thisObj).parent().parent('tr').find('#status').addClass("label label-auth").text("Waiting");
				                    break;
				                    case "Starting":
				                    $(thisObj).parent().parent('tr').find('#status').removeAttr("class");
									$(thisObj).parent().parent('tr').find('#status').addClass("label label-auth").text("Starting");
				                    break;
				                    case "Error":
				                    $(thisObj).parent().parent('tr').find('#status').removeAttr("class");
									$(thisObj).parent().parent('tr').find('#status').addClass("label label-danger").text("Error");
				                    break;
								}
						}
			            if(jsonResponse.status == false)
			            {
							switch(jsonResponse.response)
			                {
			                    case 200:
			                   	if(cname[1] == "fa-play")
								{
									$(thisObj).find('i').attr("class","fa fa-pause");
								}
								else if(cname[1] == "fa-pause")
								{
									$(thisObj).find('i').attr("class","fa fa-play");
								}
			                   	swal("Start", "Successfully!",'success');
			                    break;
			                    case 400:
			                    swal("Error", "While " + action + "ing",'error');
			                    break;
			                    case 402:
			                    case 404:
			                    swal("Error", "While " + action + "ing",'error');
			                    break;
			                    case 415:
								swal("Error", "While " + action + "ing",'error');
			                    break;
			                    case 500:
								swal("Error", "While " + action + "ing",'error');
			                    break;
							}
						}
					},
			        error:function(){
					}
				});
			});
		}
		else
		{
			swal("Information", "You can't " + action + " target with " + $(this).parent().parent().find('#status').text() + " status!" ,'warning');
		}
    });
    $('.targetTable tr td .targenbdib').each(function(){
		var obj = $(this);
		var targetId = $(this).attr('id');
		$.ajax({
	        url: baseURL + "groupadmin/targetStatus",
	        data:{'targetId':targetId,'action':'checkStatus'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
				if(jsonResponse.status == true)
				{
				  	switch(jsonResponse.response)
	                {
	                    case "Disabled":
						$(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-gray").text("Disabled");
						$(obj).parent().parent('tr').find('.targenbdib').find('i').attr('class','fa fa-play');
	                    break;
	                     case "Active":
						$(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-success").text("Active");
						$(obj).parent().parent('tr').find('.targenbdib').find('i').attr('class','fa fa-pause');
	                    break;
	                    case "Waiting...":
	                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-auth").text("Waiting");
						$(obj).parent().parent('tr').find('.targenbdib').find('i').attr('class','fa fa-pause');
	                    break;
	                    case "Error":
	                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("Error");
						$(obj).parent().parent('tr').find('.targenbdib').removeAttr("href");
						$(obj).parent().parent('tr').find('.targenbdib').find('i').attr('class','fa fa-play').html("<i class='fa fa-ban' id='nested'></i>");
	                    break;
					}
				}
				else if(jsonResponse.status == false)
				{
				  	switch(jsonResponse.response)
	                {
	                     case "Disabled":
						$(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-gray").text("Disabled");
						$(obj).parent().parent('tr').find('.targenbdib').find('i').attr('class','fa fa-play');
	                    break;
	                     case "Active":
						$(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-success").text("Active");
						$(obj).parent().parent('tr').find('.targenbdib').find('i').attr('class','fa fa-pause');
	                    break;
	                    case "Waiting...":
	                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-auth").text("Waiting");
						$(obj).parent().parent('tr').find('.targenbdib').find('i').attr('class','fa fa-pause');
	                    break;
	                    default:
	                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("NA");
						$(obj).parent().parent('tr').find('.targenbdib').removeAttr("href");
						$(obj).parent().parent('tr').find('.targenbdib').find('i').attr('class','fa fa-play').html("<i class='fa fa-ban' id='nested'></i>");
	                    break;
	                    case "Error":
	                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("Error");
						$(obj).parent().parent('tr').find('.targenbdib').find('i').attr('class','fa fa-play').html("<i class='fa fa-ban' id='nested'></i>");
	                    break;
					}
				}
			},
	        error:function(){

			}
		});
	});
	 /* Target Actions End*/
	 /* Groups Actions Start */
	  var groupLength = $('.groupTable tr td .groupaction').length;
	    var groupCheckedLength = 0;
	 	$('.groupTable tr td .groupaction').click(function(){
	 		if($(this).is(":checked")== false)
			{
				if($('#selecctallgroups').is(":checked") == true)
				{
					$('#selecctallgroups').prop('checked', false);
				}
				groupCheckedLength = 0;
				$('.groupTable tr td .groupaction').each(function () {
	               if($(this).is(":checked")== true)
	               {
				   	   groupCheckedLength++;
				   }
	            });
	            if(groupCheckedLength == groupLength)
	            {
					$('#selecctallgroups').prop('checked', true);
				}
			}
			else if($(this).is(":checked")== true)
			{
				groupCheckedLength = 0;
				$('.groupTable tr td .groupaction').each(function () {
	               if($(this).is(":checked")== true)
	               {
				   	  groupCheckedLength++;
				   }
	            });
	            if(groupCheckedLength == groupLength)
	            {
					$('#selecctallgroups').prop('checked', true);
				}
			}
	 	});
	  $('#selecctallgroups').click(function (event) {//alert(1);
        if (this.checked) {
            $('.groupaction').each(function () { //loop through each checkbox
                $(this).prop('checked', true); //check
            });
        } else {
            $('.groupaction').each(function () { //loop through each checkbox
                $(this).prop('checked', false); //uncheck
            });
        }
    });

	 /* Groups Actions End */

	/* User Action Start */
	 var userLength = $('.userTable tr td .useraction').length;
	    var userCheckedLength = 0;
	 	$('.userTable tr td .useraction').click(function(){
	 		if($(this).is(":checked")== false)
			{
				if($('#selecctalluser').is(":checked") == true)
				{
					$('#selecctalluser').prop('checked', false);
				}
				userCheckedLength = 0;
				$('.userTable tr td .useraction').each(function () {
	               if($(this).is(":checked")== true)
	               {
				   	   userCheckedLength++;
				   }
	            });
	            if(userCheckedLength == userLength)
	            {
					$('#selecctalluser').prop('checked', true);
				}
			}
			else if($(this).is(":checked")== true)
			{
				userCheckedLength = 0;
				$('.userTable tr td .useraction').each(function () {
	               if($(this).is(":checked")== true)
	               {
				   	  userCheckedLength++;
				   }
	            });
	            if(userCheckedLength == userLength)
	            {
					$('#selecctalluser').prop('checked', true);
				}
			}
	 	});
	 $('#selecctalluser').click(function (event) {//alert(1);
        if (this.checked) {
            $('.useraction').each(function () { //loop through each checkbox
                $(this).prop('checked', true); //check
            });
        } else {
            $('.useraction').each(function () { //loop through each checkbox
                $(this).prop('checked', false); //uncheck
            });
        }
    });
	/* User Action End */

	$('#selecctallgroupuser').click(function (event) {//alert(1);
        if (this.checked) {
            $('.groupdel2').each(function () { //loop through each checkbox
                $(this).prop('checked', true); //check
            });
        } else {
            $('.groupdel2').each(function () { //loop through each checkbox
                $(this).prop('checked', false); //uncheck
            });
        }
    });

});

//Start Admin Encoders single row delete code

//End Admin Encoders single row delete code


/*
$(document).on('click','.wowzadisable',function(){
	var wowzaId = $(this).attr('id');
	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to disable this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Disable!",
		closeOnConfirm: false
	},
	function(){
		$.ajax({
	        url: baseURL + "groupadmin/wowzadisable",
	        data:{'wowzaId':wowzaId,'action':'refresh'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					swal("Disabled!", "Successfully!", "success");
					location.reload();
				}
	            if(jsonResponse.status == false)
	            {
					swal("Error!", jsonResponse.response, "error");
				}
			},
	        error:function(){
			}
		});
	});
});
*/
/* Applications Actions Start */


/* Applications Actions End */
/* Target Actions Start */
$(document).on('click','.targdel',function(){
	var appid = $(this).attr('id');
	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to delete this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, delete it!",
		closeOnConfirm: false
	},
	function(){
		$.ajax({
	        url: baseURL + "groupadmin/deleteTarget",
	        data:{'appid':appid,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					swal("Deleted!", "Successfully!", "success");
					location.reload();
				}
	            if(jsonResponse.status == false)
	            {
					swal("Error!", jsonResponse.response, "error");
				}
			},
	        error:function(){
			}
		});
	});
});
$(document).on('click','.targcopy',function(){
	var appid = $(this).attr('id');
	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to copy this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Copy it!",
		closeOnConfirm: false
	},
	function(){
		$.ajax({
	        url: baseURL + "groupadmin/copyTarget",
	        data:{'appid':appid,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					swal("Deleted!", "Successfully!", "success");
					location.reload();
				}
	            if(jsonResponse.status == false)
	            {
					swal("Error!", jsonResponse.response, "error");
				}
			},
	        error:function(){
			}
		});
	});
});

/* Target Actions End */
/* Applications Start Lock/Unlock */

/* Applications end Lock/Unlock */

$(document).on('click','#lockscreen',function(){

	$.ajax({
        url: baseURL + "groupadmin/lockscreen",
        data:{},
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.status == true)
            {
				$('#divlock').removeClass("screenlock");
				$('#divlock').addClass("screenunlock");
				$('body').css('overflow','hidden');
			}
		},
        error:function(){
		}
	});
});


$(document).on('click','#lockscreen',function(){

	$.ajax({
        url: baseURL + "groupadmin/lockscreen",
        data:{},
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.status == true)
            {
				$('#divlock').removeClass("screenlock");
				$('#divlock').addClass("screenunlock");

			}
		},
        error:function(){
		}
	});
});
$(document).on('click','#btnunlock',function(){
	var pass = $('#unlockpass').val();
	if($("#unlockpass").val()=="")
		{
			$('#unlockpass').css('border','1px solid red');
			$("#unlockpass").focus();
			return false;
		}
	$.ajax({
        url: baseURL + "groupadmin/unlock",
        data:{'password':pass},
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.status == true)
            {
				$('#divlock').removeClass("screenunlock");
				$('#divlock').addClass("screenlock");
				$('body').css('overflow','none');

			}
			if(jsonResponse.status == false)
			{
				swal(jsonResponse.response);
			}
		},
        error:function(){
		}
	});
});




//group user application delete

$(document).on('click','.applicationdelete1',function(){
	alert('ok');

	var appid = $(this).attr('id');
	alert(appid);

	var objj = $(this);
	var action = "";

	$.ajax({
		url: baseURL + "Groupuser/applicationdelete",
		data:{'id':appid,'action':'delete'},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				swal({
					title: "Are you sure?",
					text: "You want to delete this!",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Yes, delete it!",
					closeOnConfirm: false
				},
				function(){
					$.ajax({
						url: baseURL + "Groupuser/applicationdelete1",
						data:{'id':appid,'action':'delete'},
						type:'post',
						dataType:'json',
						success:function(jsonResponse){
							if(jsonResponse.status == true)
							{
								swal("Deleted!", "Successfully!", "success");
								location.reload();
							}
							if(jsonResponse.status == false)
							{
								swal("Error!", jsonResponse.response, "error");
							}
						},
						error:function(){
						}
					});
				});

			}
			if(jsonResponse.status == false)
			{

				swal(jsonResponse.response);
			}
		},
		error:function(){


		}
	});


});


//group user target delete

$(document).on('click','.targetdeluser',function(){

	alert('ok');
	var appid = $(this).attr('id');
	alert(appid);

	var objj = $(this);
	var action = "";

	$.ajax({
		url: baseURL + "Groupuser/targetdelete",
		data:{'id':appid,'action':'delete'},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				swal({
					title: "Are you sure?",
					text: "You want to delete this!",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Yes, delete it!",
					closeOnConfirm: false
				},
				function(){
					$.ajax({
						url: baseURL + "Groupuser/targetdelete1",
						data:{'id':appid,'action':'delete'},
						type:'post',
						dataType:'json',
						success:function(jsonResponse){
							if(jsonResponse.status == true)
							{
								swal("Deleted!", "Successfully!", "success");
								location.reload();
							}
							if(jsonResponse.status == false)
							{
								swal("Error!", jsonResponse.response, "error");
							}
						},
						error:function(){
						}
					});
				});

			}

			if(jsonResponse.status == false)
			{

				swal(jsonResponse.response);
			}
		},
		error:function(){


		}
	});


});


//groupadmin user target delete

$(document).on('click','.groupadmintargdel',function(){


	var appid = $(this).attr('id');
	var uid = $(this).attr('uid');
	var objj = $(this);
	var action = "";

	$.ajax({
		url: baseURL + "Groupadmin/targetdelete",
		data:{'id':appid,'uid':uid},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				swal({
					title: "Are you sure?",
					text: "You want to delete this!",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Yes, delete it!",
					closeOnConfirm: false
				},
				function(){
					$.ajax({
						url: baseURL + "Groupadmin/groupadmintargetdelete",
						data:{'id':appid,'action':'delete'},
						type:'post',
						dataType:'json',
						success:function(jsonResponse){
							if(jsonResponse.status == true)
							{
								swal("Deleted!", "Successfully!", "success");
								location.reload();
							}
							if(jsonResponse.status == false)
							{
								swal("Error!", jsonResponse.response, "error");
							}
						},
						error:function(){
						}
					});
				});

			}
			if(jsonResponse.status == false)
			{	  //alert(jsonResponse.response);
				//swal("Error!", jsonResponse.response, "error");
			}
			if(jsonResponse.status == false)
			{
				//alert(jsonResponse.response);
				//swal("Error!", jsonResponse.response, "danger")
				swal(jsonResponse.response);
			}
		},
		error:function(){


		}
	});


});


//groupadmin application delete

$(document).on('click','.applicationdelete2',function(){


	var appid = $(this).attr('id');


	var objj = $(this);
	var action = "";

	$.ajax({
		url: baseURL + "Groupadmin/applicationdelete",
		data:{'id':appid,'action':'delete'},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				swal({
					title: "Are you sure?",
					text: "You want to delete this!",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Yes, delete it!",
					closeOnConfirm: false
				},
				function(){
					$.ajax({
						url: baseURL + "Groupadmin/applicationdelete1",
						data:{'id':appid,'action':'delete'},
						type:'post',
						//dataType:'json',
						success:function(jsonResponse){alert(jsonResponse);
							if(jsonResponse.status == true)
							{
								swal("Deleted!", "Successfully!", "success");
								location.reload();
							}
							if(jsonResponse.status == false)
							{
								swal("Error!", jsonResponse.response, "error");
							}
						},
						error:function(){
						}
					});
				});

			}
			if(jsonResponse.status == false)
			{	  //alert(jsonResponse.response);
				//swal("Error!", jsonResponse.response, "error");
			}
			if(jsonResponse.status == false)
			{
				//alert(jsonResponse.response);
				//swal("Error!", jsonResponse.response, "danger")
				swal(jsonResponse.response);
			}
		},
		error:function(){


		}
	});


});



/* Group delete by admin */
$(document).on('click','.groupdel',function(){


$(document).on('click','.groupde2',function(){

	var appid = $(this).attr('id');


		var appid = $(this).attr('id');

	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to delete this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, delete it!",
		closeOnConfirm: false
	},
	function(){
		$.ajax({
	        url: baseURL + "groupadmin/deleteApplication",
	        data:{'appid':appid,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					swal("Deleted!", "Successfully!", "success");
					location.reload();
				}
	            if(jsonResponse.status == false)
	            {
					swal("Error!", jsonResponse.response, "error");
				}
			},
	        error:function(){
			}
		});
	});
});


});

function submitAllGroups(url){

	var Ids = [];
	$("input:checkbox[class=groupaction]:checked").each(function () {
		var obj = $(this);
		var id = $(this).val();
		Ids.push(id);
		var action = $("#actionval").val();
		if(action != "")
		{

			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
			        url: baseURL + url,
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){

			           	 $('.groupTable tr th input[type="checkbox"]').prop('checked',false);
			        	$('.groupTable tr td input[type="checkbox"]').prop('checked',false);
		                for(var i=0; i<Ids.length; i++)
		                {
							if(jsonResponse[Ids[i]].status == true)
							{
								switch(action)
				            	{
									case "Block":

									$('.groupTable #row_'+Ids[i]).find('#status').removeAttr("class");
									$('.groupTable #row_'+Ids[i]).find('#status').attr("class","label label-danger");
									$('.groupTable #row_'+Ids[i]).find('#status').text("Blocked");
									break;
									case "UnBlock":
									$('.groupTable #row_'+Ids[i]).find('#status').removeAttr("class");
									$('.groupTable #row_'+Ids[i]).find('#status').attr("class","label label-success");
									$('.groupTable #row_'+Ids[i]).find('#status').text("Active");
									break;
									case "Delete":
									swal("Deleted!", "Successfully!", "success");
									location.reload();
									break;
								}
							}
						}
						switch(action)
		            	{
							case "Block":
							case "UnBlock":
							swal(action, "Successfully!", "success");
							break;
						}
					},
			        error:function(){
			        	swal("Error!", jsonResponse.response, "error");
					}
				});
			});
		}
		else
		{
			swal('At Least','select one action');
		}
	});

}
function submitAllTargets(tarurl)
{
	var Ids = [];
	$("input:checkbox[class=targetactions]:checked").each(function () {
		var stringId = $(this).attr("id");
		var idArray = stringId.split('_');
		var id = idArray[1];
		Ids.push(id);
		var action = $("#actiontargetval1").val();
		if(action != "")
		{
			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
			        url: baseURL + tarurl,
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
							swal( action , "Successfully!", "success");
							location.reload();
						}
			            if(jsonResponse.status == false)
			            {
							swal("Error!", jsonResponse.response, "error");
						}
					},
			        error:function(){
					}
				});
			});
		}
		else
		{
			swal("At least",'select one action');
		}
	});
}

function submitAllUser(url){
	var Ids = [];
	$("input:checkbox[class=useraction]:checked").each(function () {
		var id = $(this).val();
		Ids.push(id);
		var action = $("#actionval1").val();
		if(action != "")
		{
			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
			        url: baseURL + url,
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			        	$('.userTable tr th input[type="checkbox"]').prop('checked',false);
			        	$('.userTable tr td input[type="checkbox"]').prop('checked',false);
			             for(var i=0; i<Ids.length; i++)
		                {
							if(jsonResponse[Ids[i]].status == true)
							{
								switch(action)
				            	{
									case "Block":

									$('.userTable #row_'+Ids[i]).find('#status').removeAttr("class");
									$('.userTable #row_'+Ids[i]).find('#status').attr("class","label label-danger");
									$('.userTable #row_'+Ids[i]).find('#status').text("Blocked");
									break;
									case "UnBlock":
									$('.userTable #row_'+Ids[i]).find('#status').removeAttr("class");
									$('.userTable #row_'+Ids[i]).find('#status').attr("class","label label-success");
									$('.userTable #row_'+Ids[i]).find('#status').text("Active");
									break;
									case "Delete":
									swal("Deleted!", "Successfully!", "success");
									location.reload();
									break;
								}
							}
						}
						switch(action)
		            	{
							case "Block":
							case "UnBlock":
							swal(action, "Successfully!", "success");
							break;
						}
					},
			        error:function(){
					}
				});
			});
		}
		else
		{
			swal("At least",'select one action');
		}
	});

}


$(".checkAll").click(function () {
	var currVal = $(this).val();
	$('.'+currVal+'').not(this).prop('checked', this.checked);
});

function actionPerform(roletype,tab,selectedid){

	if(roletype == 'groupadmin'){

		var url = $("#"+selectedid+" option:selected").val();
		//alert(url);

		if(url == '' || url == 'undefined'){
			alert('Please select action.');
			return false;
		}

		if(tab == 'application'){
			var chk_box_cls_name = 'grp_admin_app_chk_class';
			url = roletype+"/"+url;
		}
		else if(tab == 'target'){
			var chk_box_cls_name = 'grp_admin_target_chk_class';
			url = roletype+"/"+url;
		}
	}

	if(roletype == 'groupuser'){
		var url = $("#"+selectedid+" option:selected").val();

		if(url == '' || url == 'undefined'){
			alert('Please select action.');
			return false;
		}

		if(tab == 'application'){
			var chk_box_cls_name = 'grp_user_app_chk_class';
			url = roletype+"/"+url;
		}
		else if(tab == 'target'){
			var chk_box_cls_name = 'grp_user_target_chk_class';
			url = roletype+"/"+url;
		}
	}

	var Ids = [];
	$("input:checkbox[class="+chk_box_cls_name+"]:checked").each(function () {
		var id = $(this).val();
		//alert(id);
		Ids.push(id);
		var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to delete this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, delete it!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
					url: baseURL + url,
					data:{'id':Ids},
					type:'post',
					dataType:'json',
					success:function(jsonResponse){
						if(jsonResponse.status == true)
						{
							swal("Deleted!", "Successfully!", "success");
							location.reload();
						}
						if(jsonResponse.status == false)
						{
							swal(jsonResponse.response);
						}
					},
					error:function(){
					}
				});
			});

	});
}
$(document).ready(function(){
	/* Create Chanell Page Things Start */
	if(Action != "updatechannel")
	{
		$('.ndi,.rtmp,.mpeg-rtp,.mpeg-udp,.mpeg-srt,.ch-applications,.ndi-name,.out-rtmp-url,.out-rtmp-key,.ch-uname,.ch-pass,.out-mpeg-rpt,.out-mpeg-udp,.out-mpeg-srt').hide();
		$('.ch-profile').hide();
		$('.ch-authentication').hide();
	}



	$(document).on('change','#channelInput',function(){
		$('#channelOutpue').selectpicker('refresh');
		$('#channelOutpue').parent().find('.dropdown-menu li').removeClass('disabled');
		$('#channelOutpue option').each(function(){
			$(this).removeAttr('disabled');
		});
		$('.ch-authentication').hide();
		$('.ndi').hide();$('.mpeg-rtp').hide();
		$('.rtmp').hide();$('.mpeg-udp').hide();$('.mpeg-srt').hide();
		$('.ndi-name').hide();$('.ch-applications').hide();$('.out-rtmp-url').hide();
		$('.out-rtmp-key').hide();
		$('.out-rtmp-url > input[type=text]').val("");
		$('.out-mpeg-rpt').hide();$('.out-mpeg-udp').hide();$('.out-mpeg-srt').hide();
		$('.out-rtmp-key > input[type=text]').val("");
		$('#channelOutpue').children('option[label="phyoutput"]').show();
		$('#channelOutpue').children('option[label="phyoutput"]').each(function(){
			var indx = $(this).attr("tabindex");
			$('#channelOutpue').parent().find('.dropdown-menu li[data-original-index="'+indx+'"] a').removeAttr("style");
		});
		var channelInput = $(this).find('option:selected').attr("tabindex");
		var typpe = $(this).find('option:selected').attr("label");
		var encinput = $(this).find('option:selected').attr("id");

		if(channelInput != "" && channelInput > 0)
		{
			switch(typpe)
			{
				case "phyinput":
				$('#encid').val(encinput);
				$('#channelOutpue').children('option[label="phyoutput"]').hide();
				$('#channelOutpue').children('option[label="phyoutput"]').each(function(){
					var indx = $(this).attr("tabindex");
					$('#channelOutpue').parent().find('.dropdown-menu li[data-original-index="'+indx+'"]').hide();
				});
				break;
				case "virinput":
					var inpval = $(this).val();
					switch(inpval)
					{
						case "virinput_3":
						$('#channelOutpue').children('option[value="viroutput_3"]').prop('disabled', true);
						var ind = $('#channelOutpue').children('option[value="viroutput_3"]').attr("tabindex");
						$('#channelOutpue').parent().find('.dropdown-menu li[data-original-index="'+ind+'"]').addClass('disabled');
						$.ajax({
							url: baseURL + "groupadmin/getNDISource",
							data:{'id':0},
							type:'post',
							dataType:'json',
							success:function(jsonResponse){
								if(jsonResponse.status == true)
								{
									if(jsonResponse.response.length >0)
									{
										var NDISources = "<option value='0'>Select Source</option>";
										for(var i=0; i<jsonResponse.response.length; i++)
										{
											NDISources += "<option value='"+jsonResponse.response[i]+"'>"+jsonResponse.response[i]+"</option>";
											$('#channel_ndi_source').html(NDISources);
											$('#channel_ndi_source').selectpicker('refresh');
										}
									}
									else
									{
										var NDISources = "<option value='0'>No NDI Sources Found</option>";
										$('#channel_ndi_source').html(NDISources);
											$('#channel_ndi_source').selectpicker('refresh');
									}

								}
								if(jsonResponse.status == false)
								{
									swal(jsonResponse.response);
								}
							},
							error:function(){
							}
						});

						$('.ndi').show();
						break;
						case "virinput_4":
							$('.rtmp').show();
							$('.ch-authentication').show();
						break;
						case "virinput_5":
							$('.mpeg-rtp').show();
						break;
						case "virinput_6":
							$('.mpeg-udp').show();
						break;
						case "virinput_7":
							$('.mpeg-srt').show();
						break;
					}
				break;
			}
		}
	});
	$(document).on('change','#channelOutpue',function(){
		var channelOutput = $(this).val();
		var channelOutput = $(this).find('option:selected').attr("tabindex");

		var typpe = $(this).find('option:selected').attr("label");

		$('.ch-profile').hide();
		$('.ndi-name').hide();$('.ch-applications').hide();$('.out-rtmp-url').hide();
		$('.out-rtmp-key').hide();
		$('.out-rtmp-url > input[type=text]').val("");
		$('.out-mpeg-rpt').hide();$('.out-mpeg-udp').hide();$('.out-mpeg-srt').hide();
		$('.out-rtmp-key > input[type=text]').val("");

		if(channelOutput != "" && channelOutput > 0)
		{
			switch(typpe)
			{
				case "viroutput":
				var vl = $(this).val();
					switch(vl)
					{
						case "viroutput_3":
							$('.ndi-name').show();
						break;
						case "viroutput_4":
							$('.ch-applications').show();
							$('.ch-profile').show();
						break;
						case "viroutput_5":
							$('.out-mpeg-rpt').show();
						break;
						case "viroutput_6":
							$('.out-mpeg-udp').show();
						break;
						case "viroutput_7":
							$('.out-mpeg-srt').show();
						break;
					}
				break;
				case "phyoutput":
				var eid = $(this).find('option:selected').attr("id");
				$("#encid").val(eid);
				break;
			}
		}
	});
	$(document).on('change','#channel_apps',function(){
		var appId = $(this).val();
		if(appId != -2 && appId != "")
		{
			var streamURL = $(this).find('option[value="'+appId +'"]').attr("id");
			var streamURLArray = streamURL.split('/');
			var streamURI = streamURLArray[streamURLArray.length-2];
			var streamName = streamURLArray[streamURLArray.length-1];
			$('.out-rtmp-url').show();
			var URRR = "rtmp://" + streamURLArray[streamURLArray.length-3] +"/" + streamURLArray[streamURLArray.length-2];

			$('.out-rtmp-key').show();
			$('.out-rtmp-key > input[type=text]').val(streamName);
			$('.out-rtmp-url > input[type=text]').val(URRR);
		}
		else
		{
			if(appId == -2)
			{
				$('.out-rtmp-url').show();
				$('.out-rtmp-key').show();
				$('.out-rtmp-key > input[type=text]').val("");
			$('.out-rtmp-url > input[type=text]').val("");
			}
			else
			{
				$('.out-rtmp-url').val("").hide();
				$('.out-rtmp-key').val("").hide();
			}
		}
	});
	$(document).on('change','#channel-auth',function(){
		$('.ch-uname > input[type="text"]').val("");
		$('.ch-pass > input[type="text"]').val("");
		if($(this).is(":checked") == true)
		{
			$('.ch-uname').show();
			$('.ch-pass').show();
		}
		else if($(this).is(":checked") == false)
		{
			$('.ch-uname').hide();
			$('.ch-pass').hide();
		}
	});
	/* Create Chanell Page Things End */
	/* Encoding Template */

	$(document).on('change','#encoder_hardware',function(){
		$('#encoder_model').removeAttr('disabled');
		$('#encoder_model').parent().find('.dropdown-toggle').removeClass("disabled");
	});
	$(document).on('change','#encoder_model',function(){
		$('#encoder_inputs').removeAttr('disabled');
		$('#encoder_output').removeAttr('disabled');
		$('#encoder_inputs').parent().find('.btn-default').removeAttr("disabled");
		$('#encoder_output').parent().find('.btn-default').removeAttr("disabled");
	});
	if(Action != "updateencodingtemplate")
	{
		$('#video_codec,#video_resolution, #video_bitrate, #video_framerate, #video_min_bitrate, #video_max_bitrate').attr('disabled','disabled');
		$("#adv_video_min_bitrate, #adv_video_max_bitrate, #adv_video_buffer_size, #adv_video_gop, #adv_video_keyframe_intrval").parent().hide();
			$('#audio_codec,#audio_channel, #audio_bitrate, #audio_sample_rate').attr('disabled','disabled');
		$('.advance_vid_setting').hide();
		$('.enableAdvanceAudio').hide();
		$('.adv_audio').hide();
	}

	$('#encoder_inputs, #encoder_output, #encoder_model').attr('disabled','disabled');
	$('#encoder_inputs').parent().find('.btn-default').attr("disabled","disabled");
	$('#encoder_output').parent().find('.btn-default').attr("disabled","disabled");



	$(document).on('change','#enableVideo',function(){

		if($(this).is(':checked') == true)
		{
			$('.advance_vid_setting').show();
			$('#video_codec,#video_resolution, #video_bitrate, #video_framerate, #video_min_bitrate, #video_max_bitrate').removeAttr('disabled');
			$('#video_codec').parent().find('.dropdown-toggle').removeClass('disabled');
			$('#video_resolution').parent().find('.dropdown-toggle').removeClass('disabled');
		}
		else if($(this).is(':checked') == false)
		{
			$('.advance_vid_setting').hide();
			$("#adv_video_min_bitrate, #adv_video_max_bitrate, #adv_video_buffer_size, #adv_video_gop, #adv_video_keyframe_intrval").parent().hide();
			$('#video_codec,#video_resolution, #video_bitrate, #video_framerate, #video_min_bitrate, #video_max_bitrate').attr('disabled','disabled');
			$('#video_codec').parent().find('.dropdown-toggle').addClass('disabled');
			$('#video_resolution').parent().find('.dropdown-toggle').addClass('disabled');
		}
	});
	$(document).on('change','#advance_video_setting',function(){
		if($(this).is(':checked') == true)
		{
			$("#adv_video_min_bitrate").parent().parent().show();
			$('#adv_video_max_bitrate').parent().parent().show();
			$("#adv_video_min_bitrate, #adv_video_max_bitrate, #adv_video_buffer_size, #adv_video_gop, #adv_video_keyframe_intrval").parent().show();
		}
		else if($(this).is(':checked') == false)
		{
			$("#adv_video_min_bitrate").parent().parent().hide();
			$('#adv_video_max_bitrate').parent().parent().hide();
			$("#adv_video_min_bitrate, #adv_video_max_bitrate, #adv_video_buffer_size, #adv_video_gop, #adv_video_keyframe_intrval").parent().hide();
		}
	});
	$(document).on('change','#audio_check',function(){
		if($(this).is(':checked') == true)
		{
			$('.enableAdvanceAudio').show();

			$('#audio_codec,#audio_channel, #audio_bitrate, #audio_sample_rate').attr('disabled','disabled');
			$('#audio_codec').removeAttr('disabled');
			$('#audio_channel').removeAttr('disabled');
			$('#audio_bitrate').removeAttr('disabled');
			$('#audio_sample_rate').removeAttr('disabled');
			$('#audio_channel').parent().find('.dropdown-toggle').removeClass('disabled');
			$('#audio_bitrate').parent().find('.dropdown-toggle').removeClass('disabled');
			$('#audio_sample_rate').parent().find('.dropdown-toggle').removeClass('disabled');

			$('#audio_codec').parent().find('.dropdown-toggle').removeClass('disabled');
			$('#audio_channel').parent().find('.dropdown-toggle').removeClass('disabled');
			$('#audio_bitrate').parent().find('.dropdown-toggle').removeClass('disabled');
			$('#audio_sample_rate').parent().find('.dropdown-toggle').removeClass('disabled');
		}
		else if($(this).is(':checked') == false)
		{
			$('.enableAdvanceAudio').hide();
			$('#audio_codec,#audio_channel, #audio_bitrate, #audio_sample_rate').removeAttr('disabled','disabled');
			$('#audio_codec').parent().find('.dropdown-toggle').addClass('disabled');
			$('#audio_channel').parent().find('.dropdown-toggle').addClass('disabled');
			$('#audio_bitrate').parent().find('.dropdown-toggle').addClass('disabled');
			$('#audio_sample_rate').parent().find('.dropdown-toggle').addClass('disabled');
		}
	});
	$(document).on('change','#enableAdvanceAudio', function(){
		if($(this).is(":checked") == true)
		{
			$('.adv_audio').show();
		}
		else if($(this).is(":checked") == false)
		{
			$('.adv_audio').hide();
		}
	});

$('#encoder_inputs').parent('.multiselect-native-select').find('ul li a label input[type=checkbox]').on('change',function(){

		if($(this).is(":checked") == true)
		{

			if($('#encoder_output').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').is(":checked")== true)
			{
				$('#encoder_output').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').prop('checked',false);

			}
			encoderInputs.push($(this).parent().text());
			$('#encoder_output').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').parent().parent().parent().addClass('disabled');
			$('#encoder_output').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').prop("disabled",true);

			var cnt = 0;
			$('#encoder_output').parent('.multiselect-native-select').find('ul li a label input[type="checkbox"]').each(function(){
				if($(this).is(":checked")== true)
				{
					cnt++;
				}
			});
			$('#encoder_output').parent('.multiselect-native-select').find('.dropdown-toggle').find("span").text(" " + cnt + " Selected");

		}
		else if($(this).is(":checked") == false)
		{
			encoderInputs.pop($(this).parent().text());
			$('#encoder_output').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').prop("disabled",false);
			$('#encoder_output').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').parent().parent().parent().removeClass('disabled');
		}

	});
	$('#encoder_output').parent('.multiselect-native-select').find('ul li a label input[type=checkbox]').on('change',function(){
		if($(this).is(":checked") == true)
		{

			if($('#encoder_inputs').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').is(":checked")== true)
			{
				$('#encoder_inputs').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').prop('checked',false);
					encoderInputs.pop($(this).parent().text());
			}

			$('#encoder_inputs').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').parent().parent().parent().addClass('disabled');
			$('#encoder_inputs').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').prop("disabled",true);

			var cnt = 0;
			$('#encoder_inputs').parent('.multiselect-native-select').find('ul li a label input[type="checkbox"]').each(function(){
				if($(this).is(":checked")== true)
				{
					cnt++;
				}
			});
			$('#encoder_inputs').parent('.multiselect-native-select').find('.dropdown-toggle').find("span").text(" " + cnt + " Selected");

		}
		else if($(this).is(":checked") == false)
		{
			encoderInputs.pop($(this).parent().text());
			$('#encoder_inputs').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').prop("disabled",false);
			$('#encoder_inputs').parent('.multiselect-native-select').find('ul li a label input[value="'+$(this).val()+'"]').parent().parent().parent().removeClass('disabled');
		}
		});

	/* Encoding Template end */


	/* Channels Start Stop */
	$('.channelTable tr td .channelsstartstop').each(function(){
    	var thisObj = $(this);
		var channelId = $(this).attr("id");
		var className = $(this).find('i').attr("class");
		var cname = className.split(' ');
		var action ="checkstatus";
		$.ajax({
			        url: baseURL + "groupadmin/channelStartStop",
			        data:{'channelId':channelId,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
							switch(jsonResponse.change)
							{
								case "start":
								$(thisObj).parent().parent().find("#status").removeAttr("class");
								$(thisObj).parent().parent().find("#status").addClass("label label-live").text("Online");
								$(thisObj).find("i").removeAttr("class");
								$(thisObj).find("i").addClass("fa fa-pause");

								$(thisObj).parent().parent().find('.counter').attr('title',jsonResponse.time);
								var timer = setInterval(upTime, 1000);
								break;
								case "stop":
								$(thisObj).parent().parent().find("#status").removeAttr("class");
								$(thisObj).parent().parent().find("#status").addClass("label label-gray").text("Offline");
								$(thisObj).find("i").removeAttr("class");
								$(thisObj).find("i").addClass("fa fa-play");
								$(thisObj).parent().parent().find('.counter').attr('title',"");


								//var timer = setInterval(upTime, 1000);

								break;
							}
						}
			            if(jsonResponse.status == false)
			            {
							//swal("Error", "Error occured while starting!",'error');
						}
					},
			        error:function(){
					}
				});

    });

	$('.channelTable tr td .channelsstartstop').click(function(){

    	var thisObj = $(this);
		var channelId = $(this).attr("id");
		var className = $(this).find('i').attr("class");
		var cname = className.split(' ');
		var action ="";
		if(cname[1] == "fa-play")
		{
			action = "Start";
		}
		else if(cname[1] == "fa-pause")
		{
			action = "Stop";
		}
		swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes " + action + " it!",
				closeOnConfirm: false
			},
		function(){

				$.ajax({
			        url: baseURL + "groupadmin/channelStartStop",
			        data:{'channelId':channelId,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
							switch(jsonResponse.change)
							{
								case "start":
								$(thisObj).parent().parent().find("#status").removeAttr("class");
								$(thisObj).parent().parent().find("#status").addClass("label label-live").text("Online");
								$(thisObj).find("i").removeAttr("class");
								$(thisObj).find("i").addClass("fa fa-pause");
								swal('Channels',jsonResponse.message,'success');
								$(thisObj).parent().parent().find('.counter').attr('title',jsonResponse.time);
								var timer = setInterval(upTime, 1000);
								break;
								case "stop":
								$(thisObj).parent().parent().find("#status").removeAttr("class");
								$(thisObj).parent().parent().find("#status").addClass("label label-gray").text("Offline");
								$(thisObj).find("i").removeAttr("class");
								$(thisObj).find("i").addClass("fa fa-play");
								$(thisObj).parent().parent().find('.counter').text("");
								$(thisObj).parent().parent().find('.counter').attr("title","");
								swal('Channels',jsonResponse.message,'warning');
								break;
							}
						}
			            if(jsonResponse.status == false)
			            {
				           // $('.loaddiv').hide();
	    					//$('body').css('overflow','scroll');
							swal("Error", "Error occured while starting!",'error');
						}
					},
			        error:function(){
					}
				});
			});

    });
	/* Channels Start Stop End*/

});
function openEditPage(URLL,objj){

	var st = $(objj).parent().parent().find("#status").html();
	if(st == "Offline")
	{
		location.href = URLL + "/offline";
	}
	if(st == "Online")
	{
		location.href = URLL + "/live";
	}
}
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
 function upTime() {
 	$('.counter').each(function(){
 		var countTo = $(this).attr('title');
 		if(countTo != "")
 		{
			now = new Date();
			countTo = new Date(countTo);
			difference = (now-countTo);

			days=Math.floor(difference/(60*60*1000*24)*1);
			hours=Math.floor((difference%(60*60*1000*24))/(60*60*1000)*1);
			mins=Math.floor(((difference%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);
			secs=Math.floor((((difference%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);

			if (days < 1) days = "";
			if (days > 0) days = days + "D";
			if (secs < 10) secs = "0" + secs;
			if (mins < 10) mins = "0" + mins;
			if (hours < 10) hours = "0" + hours;

			var tt = "";
			if(days == "")
			{
				tt = hours + ":" + mins + ":" + secs;
			}
			if(days == "" && hours == "")
			{
				tt = mins + ":" + secs;
			}
			if(days != "")
			{
				tt = days + " " + hours + ":" + mins + ":" + secs;
			}
			$(this).html(tt);
		}
		else
		{
			$(this).html("");
		}
 	});

}
