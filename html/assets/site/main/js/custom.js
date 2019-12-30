var encoderInputs = [];
var globalBankId = 0;
var ips = [];
var channelsURLS = [];
var lockApps = [];
var lockChannels = [];
var sourceURL = "";
var playerId = "";
var logTable;
var rightSideBar = [];
var updateChannelId =0;
//var encoderharwareCount = 0;
//var encoderModelsCount = [];
//var encoderModelFirstSelection = 0;
//var encoderModelSecondSelection = 0;
//var encoderModelThirdSelection = 0;
//var encoderModelInputs = [];
//var encoderModelOutputs = [];
var hardwareIds = [];
var modelIds =[];
var encoderModelInputSelection = [];
var encoderModelOutputSelection = [];
var encodersData = {operators:{}};
  var data = {
      operators: {
        operator1: {
          top: 20,
          left: 20,
          properties: {
            title: 'Operator 1',
            inputs: {},
            outputs: {
              output_1: {
                label: 'Output 1',
              }
            }
          }
        },
        operator2: {
          top: 80,
          left: 300,
          properties: {
            title: 'Operator 2',
            inputs: {
              input_1: {
                label: 'Input 1',
              },
              input_2: {
                label: 'Input 2',
              },
            },
            outputs: {}
          }
        },
      }
    };
/* harrdware adding */
var contains = function(needle) {
    // Per spec, the way to identify NaN is that it is not equal to itself
    var findNaN = needle !== needle;
    var indexOf;

    if(!findNaN && typeof Array.prototype.indexOf === 'function') {
        indexOf = Array.prototype.indexOf;
    } else {
        indexOf = function(needle) {
            var i = -1, index = -1;

            for(i = 0; i < this.length; i++) {
                var item = this[i];

                if((findNaN && item !== item) || item === needle) {
                    index = i;
                    break;
                }
            }
            return index;
        };
    }
    return indexOf.call(this, needle) > -1;
};
/* Drop Encoders */
$(document).ready(function(){

	 $('.encoderschannelsDrops').flowchart({
      data: encodersData
    });
    if($('#enable_recording_on_local_disk').is(":checked") == true)
    {
		$('.isdefaultrecording_preset').show();
	}
	else
	{
		$('.enbleVidDefault').hide();
    	$('.enableAudioEnc').hide();
    	$('.isdefaultrecording_preset').hide();
	}
	if($('#record_channel').is(":checked") == true)
    {
		$('.rcdfields').show();
	}
	else
	{
		$('.rcdfields').hide();
	}
	$('.schldchnl').hide();
	$('table tbody tr td .app_data').hide();
});
$(document).on('click','.appstatrefresh',function(){
	$(this).find('i').remove();
	$(this).html("<img style='float:right;' src='"+baseURL +"assets/site/main/images/loadSource.gif'/>");
	var obj = $(this);
	var ID = $(this).attr('id');
	var ids = ID.split('_');
	$.ajax({
		url: baseURL + "api/getIncomingStreamsInstances",
		data:{'id':ID},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){

			var h ="";
			var cData = [];	var isValue = false;
			for(var i=0; i<jsonResponse.ConnectionCount.entry.length;i++)
			{
				var objc = {};
				objc.name = jsonResponse.ConnectionCount.entry[i].string;
				objc.y = parseInt(jsonResponse.ConnectionCount.entry[i].int);
				if(parseInt(jsonResponse.ConnectionCount.entry[i].int)>0)
				{
					isValue = true;
				}
				cData.push(objc);
				h += "<tr>";
				h += "<td>"+ jsonResponse.ConnectionCount.entry[i].string  +"</td>";
				h += "<td>"+ jsonResponse.ConnectionCount.entry[i].int +"</td>";
				h += "</tr>";
			}
			$(obj).parent().parent().parent('.app_stat').find('table > tbody').html("");
			$(obj).parent().parent().parent('.app_stat').find('table > tbody').append(h);
			$(obj).parent().parent().parent('.app_stat').find('.streamname').text(jsonResponse.Name + " up since " + jsonResponse.Uptime);
			var seconds = parseInt(jsonResponse.Uptime, 10);
			var days = Math.floor(seconds / (3600*24));
			seconds  -= days*3600*24;
			var hrs   = Math.floor(seconds / 3600);
			seconds  -= hrs*3600;
			var mnts = Math.floor(seconds / 60);
			seconds  -= mnts*60;
			$(obj).parent().parent().parent('.app_stat').find('.streamuptime').text(jsonResponse.Name + " up for " + days+" D, "+hrs+" H, "+mnts+" M, "+seconds+" S");
			var x = jsonResponse.BytesInRate;
			var y = 125000;
			var z = x / y;
			$(obj).parent().parent().parent('.app_stat').find('.bytesIn').text("Bytes In: "+ jsonResponse.BytesInRate + " @ " + z + " Mbits/s");
			var x = jsonResponse.BytesOutRate;
			var y = 125000;
			var z = x / y;
			$(obj).parent().parent().parent('.app_stat').find('.bytesOut').text("Bytes Out: " + jsonResponse.BytesOutRate + " @ " + z + " Mbits/s");

			var chrtid = "charts_" + ids[1];
			if(isValue == true)
			{
				Highcharts.chart(chrtid, {
			    chart: {
			        plotBackgroundColor: null,
			        plotBorderWidth: null,
			        plotShadow: false,
			        type: 'pie',
			        backgroundColor:'rgba(255, 255, 255, 0.0)',

			    },
			    exporting: false,
			    title: {
			        text: ''
			    },
			    tooltip: {
			        pointFormat: '{series.name}: <b>{point.y}</b>'
			    },
			    plotOptions: {
			        pie: {
			            allowPointSelect: true,
			            cursor: 'pointer',
			            dataLabels: {
			                enabled: false
			            },
			            showInLegend: true
			            //center: [30, 30],
			        }
			    },
			    series: [{
			        name: 'Streams',
			        colorByPoint: true,
			        showInLegend: false,
			        data: cData
			    }]
			});
			}



			$(obj).find('img').remove();
			$(obj).parent().find('img').show();
			$(obj).html("<i class='fa fa-refresh' style='color:#fff;float: right;'></i>");
		},
		error:function(){
			$(obj).find('img').remove();
			$(obj).parent().find('img').show();
			$(obj).html("<i class='fa fa-refresh' style='color:#fff;float: right;'></i>");
		}
	});

});
$(document).on('click','.appstat',function(){

	if($(this).find('i').hasClass("fa-minus"))
	{
		$(this).parent().parent().parent('tr').next('tr').find('td').find('.app_stat').hide();
		$(this).find('i').removeClass('fa-minus');
		$(this).find('i').addClass('fa-plus');
		return;
	}
	$(this).find('i').remove();
	$(this).html("<img style='float:right;' src='"+baseURL +"assets/site/main/images/loadSource.gif'/>");
	var obj = $(this);
	var ID = $(this).attr('id');
	var ids = ID.split('_');
	$.ajax({
		url: baseURL + "api/getIncomingStreamsInstances",
		data:{'id':ID},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){

			var h ="";	var cData = [];	var isValue = false;
			for(var i=0; i<jsonResponse.ConnectionCount.entry.length;i++)
			{
				var objc = {};
				objc.name = jsonResponse.ConnectionCount.entry[i].string;
				objc.y = parseInt(jsonResponse.ConnectionCount.entry[i].int);
				cData.push(objc);
				if(parseInt(jsonResponse.ConnectionCount.entry[i].int)>0)
				{
					isValue = true;
				}
				h += "<tr>";
				h += "<td>"+ jsonResponse.ConnectionCount.entry[i].string  +"</td>";
				h += "<td>"+ jsonResponse.ConnectionCount.entry[i].int +"</td>";
				h += "</tr>";
			}
			$(obj).parent().parent().parent('tr').next('tr').find('td').find('.app_stat').find('table > tbody').html("");
			$(obj).parent().parent().parent('tr').next('tr').find('td').find('.app_stat').find('table > tbody').append(h);
			$(obj).parent().parent().parent('tr').next('tr').find('td').find('.app_stat').find('.streamname').text(jsonResponse.Name + " up since " + jsonResponse.Uptime);
			var seconds = parseInt(jsonResponse.Uptime, 10);
			var days = Math.floor(seconds / (3600*24));
			seconds  -= days*3600*24;
			var hrs   = Math.floor(seconds / 3600);
			seconds  -= hrs*3600;
			var mnts = Math.floor(seconds / 60);
			seconds  -= mnts*60;
			$(obj).parent().parent().parent('tr').next('tr').find('td').find('.app_stat').find('.streamuptime').text(jsonResponse.Name + " up for " + days+" D, "+hrs+" H, "+mnts+" M, "+seconds+" S");

			var x = jsonResponse.BytesInRate;
			var y = 125000;
			var z = x / y;
			$(obj).parent().parent().parent('tr').next('tr').find('td').find('.app_stat').find('.bytesIn').text("Bytes In: " + jsonResponse.BytesInRate + " @ " + z + " Mbits/s");
			var x = jsonResponse.BytesOutRate;
			var y = 125000;
			var z = x / y;
			$(obj).parent().parent().parent('tr').next('tr').find('td').find('.app_stat').find('.bytesOut').text("Bytes Out: " + jsonResponse.BytesOutRate + " @ " + z + " Mbits/s");

			var chrtid = "charts_" + ids[1];
			if(isValue == true)
			{
				Highcharts.chart(chrtid, {
			    chart: {
			        plotBackgroundColor: null,
			        plotBorderWidth: null,
			        plotShadow: false,
			        type: 'pie',
			        backgroundColor:'rgba(255, 255, 255, 0.0)',

			    },
			    exporting: false,
			    title: {
			        text: ''
			    },
			    tooltip: {
			        pointFormat: '{series.name}: <b>{point.y}</b>'
			    },
			    plotOptions: {
			        pie: {
			            allowPointSelect: true,
			            cursor: 'pointer',
			            dataLabels: {
			                enabled: false
			            },
			            showInLegend: true
			           // center: ["30%", "30%"],
			        }
			    },
			    series: [{
			        name: 'Streams',
			        colorByPoint: true,
			        showInLegend: false,
			        data: cData
			    }]
			});
			}


			$(obj).parent().parent().parent('tr').next('tr').find('td').find('.app_stat').show();
			$(obj).find('img').remove();
			$(obj).parent().find('img').show();
			$(obj).html("<i class='fa fa-minus' style='color:#fff;float: right;'></i>");
		},
		error:function(){
			$(obj).parent().parent().parent('tr').next('tr').find('td').find('.app_stat').hide();
			$(obj).find('img').remove();
			$(obj).parent().find('img').show();
			$(obj).html("<i class='fa fa-minus' style='color:#fff;float: right;'></i>");
		}
	});

});

$(document).on('click','.copytoclipboardtext',function(){
	$(this).addClass("bounceIn");
	$(this).addClass("animated");
	var $temp = $("<input>");
  	$("body").append($temp);
  	$temp.val($(this).text()).select();
  	document.execCommand("copy");
   $(this).attr('data-original-title', 'Copied').tooltip('show');
  	$temp.remove();
  	$(this).delay(1000).queue(function() {  // Wait for 1 second.
        $(this).removeClass("bounceIn").dequeue();
        $(this).removeClass("animated").dequeue();
     $(this).attr('data-original-title', 'Click To Copy').tooltip('show');
    });
});
$(document).on('click','.lblinputtext',function(){
	if($(this).parent('td').find('.copytoclipboardtext').is(':visible'))
	{
		$(this).parent('td').find('.copytoclipboardtext').hide();
	}
	else
	{
		$(this).parent('td').find('.copytoclipboardtext').show();
	}
});
$(document).on('click','.lbloutputtext',function(){
	 if($(this).parent('td').find('.copytoclipboardtext').is(':visible'))
	{
		$(this).parent('td').find('.copytoclipboardtext').hide();
	}
	else
	{
		$(this).parent('td').find('.copytoclipboardtext').show();
	}
});
$(document).on('click','.lblrecordtext',function(){
	if($(this).parent('td').find('.copyrecordfile').is(':visible'))
	{
		$(this).parent('td').find('.copyrecordfile').hide();
	}
	else
	{
		$(this).parent('td').find('.copyrecordfile').show();
	}
});
$(document).on('change','#channelEncoders',function(){

	var inpHtml = "<option value=''>- Select Input -</option>";
	var OutHtml = "<option value=''>- Select Output -</option>";
	$('#channelInput').html(inpHtml);
	$('#channelOutpue').html(OutHtml);
	$('#channelInput').selectpicker('refresh');
	$('#channelOutpue').selectpicker('refresh');

	var ID = $(this).val();
	$.ajax({
		url: baseURL + "channels/getChannelInputsOutputs",
		data:{'id':ID},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){

			var inpHtml = "";
			var vinputs = 1;
			inpHtml += "<option value=''>- Select Input -</option>";
			if(jsonResponse.hasInputs)
			{
				var Chinputs = jsonResponse.inputs;

				if(Chinputs.length > 0)
				{
					for(var inp=0; inp<Chinputs.length;inp++)
					{
						inpHtml += "<option id='enc_"+ Chinputs[inp].encid+"'  tabindex='"+vinputs+"' label='phyinput' value='phyinput_"+Chinputs[inp].inp_source +"_"+Chinputs[inp].encid+"'>" + Chinputs[inp].inp_name +"</option>";
						vinputs++;
					}
				}

			}

			var vchinputs = jsonResponse.vchinputs;
			for(var inp=0; inp<vchinputs.length;inp++)
			{
				inpHtml += "<option tabindex='"+vinputs+"' label='virinput' value='virinput_"+vchinputs[inp].id+"'>"+ vchinputs[inp].item +"</option>";
				vinputs++;
			}
			$('#channelInput').html(inpHtml);
			$('#channelInput').selectpicker('refresh');
			var OutHtml = " <option value=''>- Select Output -</option>";
			var voutputs = 1;
			if(jsonResponse.hasOutputs)
			{
				var Choutputs = jsonResponse.outputs;
				for(var out=0; out<Choutputs.length;out++)
				{
					OutHtml += "<option id='enc_"+ Choutputs[out].encid+"'  tabindex='"+voutputs+"' label='phyoutput' value='phyoutput_"+Choutputs[out].out_destination +"_"+Choutputs[out].encid+"'>"+ Choutputs[out].out_name +"</option>";
					voutputs++;
				}
			}
			var vchoutputs = jsonResponse.vchoutputs;
			for(var out=0; out<vchoutputs.length;out++)
			{
				OutHtml += "<option tabindex='"+voutputs+"' label='viroutput' value='viroutput_"+vchoutputs[out].id+"'>"+ vchoutputs[out].item +"</option>";
				voutputs++;
			}
			$('#channelOutpue').html(OutHtml);
			$('#channelOutpue').selectpicker('refresh');
		},
		error:function(){

		}
	});

});

$(document).on('change','#enablechannelSchedule',function(){
	if($(this).is(':checked') == true)
	{
		$('.schldchnl').show();
	}
	else if($(this).is(':checked') == false)
	{
		$('.schldchnl').hide();
	}
});
$(document).on('change','#record_channel',function(){
	if($(this).is(':checked') == true)
	{
		$('.rcdfields').show();
	}
	else if($(this).is(':checked') == false)
	{
		$('.rcdfields').hide();
	}
});

$(document).on('change','#is_default_recording_preset',function(){
	if($(this).is(':checked') == true)
	{
		$('.enbleVidDefault').show();
		$('.enableAudioEnc').show();
	}
	else if($(this).is(':checked') == false)
	{
		$('.enbleVidDefault').hide();
		$('.enableAudioEnc').hide();
	}
});
$(document).on('change','#enable_recording_on_local_disk',function(){
	$('.isdefaultrecording_preset').show();
});
 $('.encoderschannelsDrops').droppable({
	    tolerance: "intersect",
	    accept: ".external-event",
	    activeClass: "ui-state-default",
	    hoverClass: "ui-state-hover",
	    drop: function(event, ui) {
	    	var obj = $(this);
	    	var len = encodersData.operators.length;
	    	var start = 0;
	    	if(len=0)
	    	{
				start =1;
			}
			else
			{
				start=len+1;
			}
	    	var encoderObject =  { top: 20, left: 20,properties: {title: 'Encoder '+ui.draggable[0].attributes.id.value,inputs: {},outputs: {output_1: {label: 'Output 1',}}}};
	    	//encodersData.operators['operator'+start]=encoderObject;
	    	$('.encoderschannelsDrops').flowchart('createOperator', 'Encoder '+ui.draggable[0].attributes.id.value, encoderObject);
			 //$('.encoderschannelsDrops').flowchart({data: encodersData });
	    }
	});



$(document).on('click','.pairing_gateway_encoder',function(){
	var anch = $(this);
	var id = $(this).attr("id");
	var idarray = id.split('_');
	if(id != "")
	{
		swal({
			title: "Are you sure?",
			text: "You want to "+idarray[1]+" this!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, "+idarray[1]+" it!",
			closeOnConfirm: true
		},
		function(){
				$(this).find('span').html("<img src='"+baseURL +"assets/site/main/images/loadgateway.gif'/>");
				$.ajax({
					url: baseURL + "encoders/gatewaypairing",
					data:{'id':id,'action':idarray[1]},
					type:'post',
					dataType:'json',
					success:function(jsonResponse){
						switch(idarray[1])
						{
							case "pair":
								if(jsonResponse.status == true)
								{
									$(anch).html("Unpair <span></span>").attr("id",jsonResponse.response).removeClass('rd').addClass('gr');
									$('.pairingtext').val(jsonResponse.responseserver);
								}
								if(jsonResponse.status == false)
								{
									toastr['error']('Error occured while performing actions.');
								}
							break;
							case "unpair":
								if(jsonResponse.status == true)
								{
									$(anch).html("Pair <span></span>").attr("id",jsonResponse.response).removeClass('gr').addClass('rd');
									$('.pairingtext').val("");
								}
								if(jsonResponse.status == false)
								{
									toastr['error']('Error occured while performing actions.');
								}
							break;
						}
						$(anch).find('span').html("");
					},
					error:function(){
						toastr['error']('Error occured while performing actions');
						$(anch).find('span').html("");
					}
				});
		});


	}
});

$(document).on('click','.pairing_encoder',function(){



	var anch = $(this);
	var id = $(this).attr("id");
	var idarray = id.split('_');


	if(id != "")
	{
		swal({
			title: "Are you sure?",
			text: "You want to "+idarray[1]+" this!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, "+idarray[1]+" it!",
			closeOnConfirm: true
		},
		function(){
				$(this).find('span').html("<img src='"+baseURL +"assets/site/main/images/loadgateway.gif'/>");
				$.ajax({
					url: baseURL + "encoders/pairing",
					data:{'id':id,'action':idarray[1]},
					type:'post',
					dataType:'json',
					success:function(jsonResponse){
						switch(idarray[1])
						{
							case "pair":
								if(jsonResponse.status == true)
								{
									$(anch).html("Unpair <span></span>").attr("id",jsonResponse.response).removeClass('rd').addClass('gr');
									$('.pairingtext').val(jsonResponse.responseserver);
								}
								if(jsonResponse.status == false)
								{
									toastr['error']('Error occured while performing actions.');
								}
							break;
							case "unpair":
								if(jsonResponse.status == true)
								{
									$(anch).html("Pair <span></span>").attr("id",jsonResponse.response).removeClass('gr').addClass('rd');
									$('.pairingtext').val("");
								}
								if(jsonResponse.status == false)
								{
									toastr['error']('Error occured while performing actions.');
								}
							break;
						}
						$(anch).find('span').html("");
					},
					error:function(){
						toastr['error']('Error occured while performing actions');
						$(anch).find('span').html("");
					}
				});
		});


	}
});
$(document).on('change','.hardware_input_table tbody tr td.sourcestd .selectpicker',function(){
	var selectedValue =  $(this).val();
	if(selectedValue != '')
	{
		$('.hardware_input_table tbody tr td.sourcestd .selectpicker > option[value="'+selectedValue+'"]').attr("disabled","disabled");
		$(this).find('option:selected').removeAttr('disabled');
	}
	var selectedInputs = [];
	$('.hardware_input_table tbody tr td.sourcestd .selectpicker').each(function(){
		$(this).find('option').each(function(){
			if($(this).is(':selected'))
			{
				selectedInputs.push($(this).val());
			}
		});
		$(this).selectpicker('refresh');
	});
	$('.hardware_input_table tbody tr td.sourcestd .selectpicker').each(function(){
		$(this).find('option').each(function(){
			if(selectedInputs.indexOf($(this).val()) == -1)
			{
				var attr = $(this).attr('disabled');
				if (typeof attr !== typeof undefined && attr !== false) {
				 	$(this).removeAttr('disabled');
				}
			}
		});
		$(this).selectpicker('refresh');
	});

});
$(document).on('change','.hardware_output_table tbody tr td.sourcestd .selectpicker',function(){
	var selectedValue =  $(this).val();
	if(selectedValue != '')
	{
		$('.hardware_output_table tbody tr td.sourcestd .selectpicker > option[value="'+selectedValue+'"]').attr("disabled","disabled");
		$(this).find('option:selected').removeAttr('disabled');
	}
	$('.hardware_output_table tbody tr td.sourcestd .selectpicker > option[value="'+selectedValue+'"]').attr("disabled","disabled");
	$(this).find('option:selected').removeAttr('disabled');
	var selectedOutputs = [];
	$('.hardware_output_table tbody tr td.sourcestd .selectpicker').each(function(){
		$(this).find('option').each(function(){
			if($(this).is(':selected'))
			{
				selectedOutputs.push($(this).val());
			}
		});
		$(this).selectpicker('refresh');
	});
	$('.hardware_output_table tbody tr td.sourcestd .selectpicker').each(function(){
		$(this).find('option').each(function(){
			if(selectedOutputs.indexOf($(this).val()) == -1)
			{
				var attr = $(this).attr('disabled');
				if (typeof attr !== typeof undefined && attr !== false) {
				 	$(this).removeAttr('disabled');
				}
			}
		});
		$(this).selectpicker('refresh');
	});
	$(this).selectpicker('refresh');
});

$(document).on('click','.deleteEncInputs',function(e){


	$(this).parent().parent('tr').remove();
	if($(".hardware_input_table tbody tr").length == 0)
	{
		$(".hardware_input_table tbody").append("<tr class='emptyrow'><td colspan='5'>No Inputs Created Yet!</td></tr>");
	}
	var selectedInputs = [];
	$('.hardware_input_table tbody tr td .videosources').each(function(){
		$(this).find('option').each(function(){
			if($(this).is(':selected'))
			{
				selectedInputs.push($(this).val());
			}
		});
	});
	$('.hardware_input_table tbody tr td .videosources').each(function(){
		$(this).find('option').each(function(){
			if(selectedInputs.indexOf($(this).val()) == -1)
			{
				var attr = $(this).attr('disabled');
				if (typeof attr !== typeof undefined && attr !== false) {
				 	$(this).removeAttr('disabled');
				}
			}
		});
	});
});
$(document).on('click','.deleteEncOuptputs',function(e){

	$(this).parent().parent('tr').remove();
	if($(".hardware_output_table tbody tr").length == 0)
	{
		$(".hardware_output_table tbody").append("<tr class='emptyrow'><td colspan='4'>No Outputs Created Yet!</td></tr>");
	}
	var selectedOutputs = [];
	$('.hardware_output_table tbody tr td .videosources').each(function(){
		$(this).find('option').each(function(){
			if($(this).is(':selected'))
			{
				selectedOutputs.push($(this).val());
			}
		});
	});
	$('.hardware_output_table tbody tr td .videosources').each(function(){
		$(this).find('option').each(function(){
			if(selectedOutputs.indexOf($(this).val()) == -1)
			{
				var attr = $(this).attr('disabled');
				if (typeof attr !== typeof undefined && attr !== false) {
				 	$(this).removeAttr('disabled');
				}
			}
		});
	});
});
$(document).on('click','.minlink',function(e){
	encoderharwareCount = encoderharwareCount-1;
	var idd = $(this).parent().parent().parent('.hardware-box').find('select:eq(1)').attr('id');
	if(idd == 'encoder_model1')
	{
		encoderModelSecondSelection = 0;
	}
	else if(idd == 'encoder_model2')
	{
		encoderModelThirdSelection = 0;
	}
	refreshEncodersInputOutputs();
	$(this).parent().parent().parent('.hardware-box').remove();
});
var refreshEncodersInputOutputs = function(){
	encoderModelInputs = [];
	encoderModelOutputs = [];
	for(var k in encoderModelsCount)
	{
		encoderModelsCount[k] = 0;
	}

	if(encoderModelFirstSelection > 0)
	{
		encoderModelsCount[encoderModelFirstSelection] = encoderModelsCount[encoderModelFirstSelection] + 1;
	}
	if(encoderModelSecondSelection > 0)
	{
		encoderModelsCount[encoderModelSecondSelection] = encoderModelsCount[encoderModelSecondSelection] + 1;
	}
	if(encoderModelThirdSelection > 0)
	{
		encoderModelsCount[encoderModelThirdSelection] = encoderModelsCount[encoderModelThirdSelection] + 1;
	}

	if(Object.keys(encoderModelsCount).length > 0)
	{
		for(var i=1; i<=Object.keys(encoderModelsCount).length; i++)
		{
			if(encoderModelsCount[i] > 0)
			{
				var casee = (i);
				switch(casee)
				{
					case 1:
					var len = parseInt(encoderModelsCount[i]) * 4;
					for(var inp=1; inp<=len; inp++)
					{
						encoderModelInputs.push("DeckLink Duo ("+ inp +")");
						encoderModelOutputs.push("DeckLink Duo ("+ inp +")");
					}
					break;
					case 6:
					var len = parseInt(encoderModelsCount[i]) * 4;

					for(var inp=1; inp<=len; inp++)
					{
						encoderModelInputs.push("DeckLink SDI ("+ inp +")");
						encoderModelOutputs.push("DeckLink SDI ("+ inp +")");
					}
					break;
					case 8:
					var len = parseInt(encoderModelsCount[i]) * 1;
					for(var inp=1; inp<=len; inp++)
					{
						if(inp == 1)
						{
							encoderModelInputs.push("DeckLink SDI Micro");
							encoderModelOutputs.push("DeckLink SDI Micro");
						}
						else
						{
							encoderModelInputs.push("DeckLink SDI Micro ("+ inp +")");
							encoderModelOutputs.push("DeckLink SDI Micro ("+ inp +")");
						}
					}
					break;
					case 9:
					var len = parseInt(encoderModelsCount[i]) * 1;
					for(var inp=1; inp<=len; inp++)
					{
						if(inp == 1)
						{
							encoderModelInputs.push("DeckLink Mini Recorder 4K");
							encoderModelInputs.push("DeckLink Mini Recorder 4K - HDMI");
						}
						else
						{
							encoderModelInputs.push("DeckLink Mini Recorder 4K ("+ inp +")");
							encoderModelInputs.push("DeckLink Mini Recorder 4K - HDMI ("+ inp +")");
						}

					}
					break;
					case 10:
					var len = parseInt(encoderModelsCount[i]) * 1;
					for(var inp=1; inp<=len; inp++)
					{
						if(inp == 1)
						{
							encoderModelOutputs.push("Decklink Mini Monitor 4K");
							//encoderModelOutputs.push("DeckLink Mini Monitor - HDMI");
						}
						else
						{
							encoderModelOutputs.push("DeckLink Mini Monitor 4K ("+ inp +")");
							//encoderModelOutputs.push("DeckLink Mini Monitor ("+ inp +") HDMI");
						}
					}
					break;
					case 11:
					encoderModelInputs.push("DeckLink HD Extreme");
					encoderModelOutputs.push("DeckLink HD Extreme");
					break;
				}
			}
		}
	}
	else
	{
		toastr['error']('Please select at least one Model/Card.');
	}
	if(encoderModelInputs.length == 0)
	{
		if($(".hardware_input_table tbody tr").length > 0)
		{
			$(".hardware_input_table tbody tr").remove();
		}
	}
	else
	{
		$(".hardware_input_table tbody tr").each(function(){
			var h = "<option value=''>-- none--</option>";
			$(this).find('.sourcestd .slctpckr').html("");
			for(var inplis =0; inplis <encoderModelInputs.length; inplis++)
			{
				 h += "<option value='"+encoderModelInputs[inplis]+"'>"+encoderModelInputs[inplis]+"</option>";
			}

			$(this).find('.sourcestd .slctpckr').html(h);
			//$(this).find('.sourcestd .slctpckr').selectpicker('refresh');
			//$(this).find('.sourcestd > .videosources').selectpicker('refresh');
		});
	}
	if(encoderModelOutputs.length == 0)
	{
		if($(".hardware_output_table tbody tr").length > 0)
		{
			$(".hardware_output_table tbody tr").remove();
		}
	}
	else
	{
		$(".hardware_output_table tbody tr").each(function(){
			var o = "<option value=''>-- none--</option>";
			$(this).find('.sourcestd > .slctpckr').html("");
			for(var ouplis =0; ouplis <encoderModelOutputs.length; ouplis++)
			{
				o += "<option value='"+encoderModelOutputs[ouplis]+"'>"+encoderModelOutputs[ouplis]+"</option>";
			}

			$(this).find('.sourcestd .slctpckr').html(o);
			//$(this).find('.sourcestd .slctpckr').selectpicker('refresh');
		});
	}
}
$(document).on('click','#add_encoder_outputs',function(e){
	if(encoderModelOutputs.length > 0)
	{
		var startno = 0;
		if($(".hardware_output_table tbody tr.emptyrow").length > 0)
		{
			startno = 0;
		}
		else
		{
			startno = $(".hardware_output_table tbody tr").length;
		}

		if(encoderModelOutputs.length > startno)
		{
			var htmlOutput = "";
			htmlOutput += "<tr>";
			htmlOutput += "<td><input type='text' class='form-control selectpicker' id='outputs' name='outputs[]' value='Output"+ (startno+1) +"'/></td>";
			htmlOutput += "<td class='sourcestd'><select id='videooutputsources' name='videooutputsources[]' class='form-control slctpckr videosources'>";
			htmlOutput += "<option value=''>-- none --</option>";
			var selectedOutputs = [];
			$('.hardware_output_table tbody tr td .videosources').each(function(){
				$(this).find('option').each(function(){
					if($(this).is(':selected'))
					{
						selectedOutputs.push($(this).val());
					}
				});
			});
			for(var inplist =0; inplist <encoderModelOutputs.length; inplist++)
			{
				if(selectedOutputs.indexOf(encoderModelInputs[inplist]) != -1)
				{
					htmlOutput += "<option disabled='disabled' value='"+encoderModelOutputs[inplist]+"'>"+encoderModelOutputs[inplist]+"</option>";
				}
				else
				{
					htmlOutput += "<option value='"+encoderModelOutputs[inplist]+"'>"+encoderModelOutputs[inplist]+"</option>";
				}

			}
			htmlOutput += "</select></td>";

			htmlOutput += "<td class='sourcestd'><select id='encoderOutputFormat' name='encoderOutputFormat[]' class='form-control encoderOutputFormat'>";
			htmlOutput += "<option value=''>-- none --</option>";
			for(var oformat=0;oformat<encoderModelOutFormat.length;  oformat++)
			{
				htmlOutput += "<option value='"+encoderModelOutFormat[oformat].id+"'>"+encoderModelOutFormat[oformat].id+"</option>";
			}
			htmlOutput += "</select></td>";

			htmlOutput += "<td>-</td>";
			htmlOutput += "<td><a href='javascript:void(0);' class='deleteEncOuptputs'><i class='fa fa-trash'></i></td>";
			htmlOutput += "</tr>";
			if($(".hardware_output_table tbody tr.emptyrow").length > 0)
			{
				$(".hardware_output_table tbody tr").remove();
				$(".hardware_output_table tbody").append(htmlOutput);
			}
			else
			{
				$(".hardware_output_table tbody").append(htmlOutput);
			}
			//$('.videosources').selectpicker('refresh');
			//$('.encoderOutputFormat').selectpicker('refresh');
		}
		else
		{
			toastr['error']('You have no more outputs to create.');
		}
	}
	else
	{
		toastr['error']('Output Model not selected');
	}
});
$(document).on('click','#add_encoder_inputs',function(e){

	if(encoderModelInputs.length > 0)
	{
		var startno = 0;
		if($(".hardware_input_table tbody tr.emptyrow").length > 0)
		{
			startno = 0;
		}
		else
		{
			startno = $(".hardware_input_table tbody tr").length;
		}
		if(encoderModelInputs.length > startno)
		{
			var htmlInputs = "";
			htmlInputs += "<tr>";
			htmlInputs += "<td><input type='text' class='form-control' id='inputs' name='inputs[]' value='Input"+ (startno+1) +"'/></td>";
			htmlInputs += "<td class='sourcestd'><select id='videosources' name='videoinputsources[]' class='form-control videosources slctpckr'>";
			htmlInputs += "<option value=''>-- none --</option>";
			var selectedInputs = [];
			$('.hardware_input_table tbody tr td .videosources').each(function(){
				$(this).find('option').each(function(){
					if($(this).is(':selected'))
					{
						selectedInputs.push($(this).val());
					}
				});
			});
			for(var inplist =0; inplist <encoderModelInputs.length; inplist++)
			{
				if(selectedInputs.indexOf(encoderModelInputs[inplist]) != -1)
				{
					htmlInputs += "<option disabled='disabled' value='"+encoderModelInputs[inplist]+"'>"+encoderModelInputs[inplist]+"</option>";
				}
				else
				{
					htmlInputs += "<option value='"+encoderModelInputs[inplist]+"'>"+encoderModelInputs[inplist]+"</option>";
				}
			}
			htmlInputs += "</select></td>";

			htmlInputs += "<td><select id='audiosources' name='audiosources[]' class='form-control audiosources'>";
			htmlInputs += "<option value=''>-- none --</option>";
			htmlInputs += "<option value='embedded'>Embeded</option>";
			htmlInputs += "<option value='aes_ebu'>AES/EBU</option>";
			htmlInputs += "<option value='analog'>Analog</option>";
			htmlInputs += "</select></td>";
			htmlInputs += "<td>-</td>";

			htmlInputs += "<td><a href='javascript:void(0);' class='deleteEncInputs'><i class='fa fa-trash'></i></td>";
			htmlInputs += "</tr>";
			if($(".hardware_input_table tbody tr.emptyrow").length > 0)
			{
				$(".hardware_input_table tbody tr").remove();
				$(".hardware_input_table tbody").append(htmlInputs);
			}
			else
			{
				$(".hardware_input_table tbody").append(htmlInputs);
			}
			//$('.videosources').selectpicker('refresh');
			//$('.audiosources').selectpicker('refresh');
		}
		else
		{
			toastr['error']('You have no more inputs to create.');
		}
	}
	else
	{
		toastr['error']('Input Model not selected');
	}
});
$(document).on('change','#encoder_model',function(){
	encoderModelFirstSelection = $(this).val();

	refreshEncodersInputOutputs();
});
$(document).on('change','#encoder_model1',function(){
	encoderModelSecondSelection = $(this).val();
	refreshEncodersInputOutputs();
});
$(document).on('change','#encoder_model2',function(){
	encoderModelThirdSelection = $(this).val();
	refreshEncodersInputOutputs();
});


$(document).on('click','.hdAdd',function(e){

	encoderharwareCount = encoderharwareCount+1;
		if(encoderharwareCount < 3)
		{
			var iid = 0;
			if($('#encoder_hardware1').length > 0)
			{
				iid = 2;
			}
			else if($('#encoder_hardware2').length > 0)
			{
				iid = 1;
			}
			else
			{
				iid = 1;
			}
			var hdHtml ="";
			hdHtml += "<div class='col-lg-3 col-md-12 hardware-box'>";
		    hdHtml += "<div class='form-group'>";
		    hdHtml += "<label style='width:100%;'>Hardware <span class='mndtry'>*</span> <a href='javascript:void(0);' class='pull-right minlink'><i class='fa fa-times-circle'></i></a></label>";
		    hdHtml += "<select class='form-control' name='encoder_hardware"+iid+"' id='encoder_hardware"+iid+"' required='true'>";
	         $('#encoder_hardware option').each(function(){
	         	 hdHtml +="<option value='"+$(this).attr("value")+"'>"+$(this).html()+"</option>";
	         });
		    hdHtml += "</select>";
		    hdHtml += "</div>";
		    hdHtml += "<div class='form-group'>";
		    hdHtml += "<label>Model <span class='mndtry'>*</span></label>";
		    hdHtml += "<select class='form-control' name='encoder_model"+iid+"' id='encoder_model"+iid+"' required='true' disabled='disabled'>";
		     $('#encoder_model option').each(function(){
				var attrDisabled = $(this).attr('disabled');
				if (typeof attrDisabled !== typeof undefined && attrDisabled !== false) {
				    hdHtml +="<option disabled='disabled' value='"+$(this).attr("value")+"'>"+$(this).html()+"</option>";
				}
				else
				{
					hdHtml +="<option value='"+$(this).attr("value")+"'>"+$(this).html()+"</option>";
				}
	         });
		    hdHtml += "</select>";
		    hdHtml += "</div>";
			hdHtml += "</div>";
			var hbsize = $('.hardware-box').length;
			$('.hardware-box:eq('+(hbsize-1)+')').after(hdHtml);
			$('#encoder_hardware'+iid).selectpicker('refresh');
			$('#encoder_model'+iid).selectpicker('refresh');
		}
		else{
			toastr['error']('You cant add more than two dynamic hardware');
		}
});
/* create schedule */
$(document).on('click','.createschedule',function(e){
	$('#schedulepopup').modal('show');
});

$(document).on('click','.showdevicelist',function(e){
	var anch = $(this);
	$('.deviceouptut').html("");
	var id = $(this).attr('id');
	$(this).find('span').html("<img src='"+baseURL +"assets/site/main/images/loadgateway.gif'/>");
	$.ajax({
			url: baseURL + "api/showdevicelist",
			data:{'id':id,'action':"show"},
			type:'post',
			dataType:'json',
			success:function(jsonResponse){
				if(jsonResponse.status == true)
				{
					$('.deviceouptut').html(jsonResponse.data);
				}
				if(jsonResponse.status == false)
				{
					toastr['error'](jsonResponse.data);
				}
				$(anch).find('span').html("");
			},
			error:function(){
				toastr['error']('Error occured while performing actions');
				$(anch).find('span').html("");
			}
		});
});


$('.scheduleTable tr td .schLockUnlock').each(function(){
	var ids = $(this).attr('id');
	var id = ids.split('_');
	var obj = $(this);
	if(schedulesLocks[id[1]] == 1)
	{
		$(this).find('i').removeAttr('class');
		$(this).find('i').addClass('fa fa-lock');
		$(obj).find('i').addClass('c-orange');
	}
	else if(schedulesLocks[id[1]] == 0)
	{
		$(this).find('i').removeAttr('class');
		$(this).find('i').addClass('fa fa-unlock');
	}
});
$(document).on('click','.schLockUnlock',function(){

	var permis = JSON.parse(userPermissions);
	var obj = $(this);
	var id = $(this).attr("id");
	var cls = $(this).find('i').attr('class');
	var classNames = cls.split(' ');
	var ids = id.split('_');
	if(classNames[1] == "fa-unlock")
	{
		action = "Lock";
	}
	else if(classNames[1] == "fa-lock")
	{
		action = "UnLock";
	}
	swal({
		title: "Are you sure?",
		text: "You want to "+action+" this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, "+action+" it!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
			url: baseURL + "api/scheduleLockUnlock",
			data:{'id':id,'action':action},
			type:'post',
			dataType:'json',
			success:function(jsonResponse){
				if(jsonResponse.status == true)
				{
					if(action == "Lock")
					{
						$(obj).find('i').removeClass('fa-unlock');
						$(obj).find('i').addClass('fa-lock');
						$(obj).find('i').addClass('c-orange');
					}
					else if(action == "UnLock")
					{
						$(obj).find('i').removeClass('fa-lock');
						$(obj).find('i').removeClass('c-orange');
						$(obj).find('i').addClass('fa-unlock');
					}
					toastr['success']( action + ' Successfully!');
				}
				if(jsonResponse.status == false)
				{
					toastr['error'](jsonResponse.response);
				}
			},
			error:function(){
				toastr['error']('Error occured while performing actions');
			}
		});
	});
});
$(document).on('click','.schdule_title',function(e){
	var id = $(this).attr("id");
	var nm = $(this).attr("name");
	var d = schedulesData[nm];
	switch(id)
	{
		case "lvchannel":
		$('#edit_schedulechannelpopup').modal('show');
		var h = '<option selected="selected" id="'+d.id+'" value="'+d.sid+'">' +d.title+'</option>';
		$('#edit_sch_channel_list').html(h);
		$('#edit_sch_channel_list').selectpicker('refresh');
		$('#edit_schedule_popup_channel_starttime').val(d.start_datetime);
		$('#edit_schedule_popup_channel_endtime').val(d.end_datetime);
		break;
		case "lvtarget":
		var h = '<option selected="selected"  id="'+d.id+'" value="'+d.sid+'">' +d.title+'</option>';
		$('#edit_sch_target_list').html(h);
		$('#edit_sch_target_list').selectpicker('refresh');
		$('#edit_schedule_popup_target_starttime').val(d.start_datetime);
		$('#edit_schedule_popup_target_endtime').val(d.end_datetime);
		$('#edit_scheduleTargetpopup').modal('show');
		break;
	}

});

$(document).on('click','.schdule',function(e){
	var id = $(this).attr("id");
	switch(id)
	{
		case "liveChannel":
		$('#schedulepopup').modal('hide');
		$('#schedulechannelpopup').modal('show');
		$('#sch_channel_list').val("");
		$('#sch_channel_list').selectpicker('refresh');
		$('#schedule_popup_channel_starttime').val("");
		$('#schedule_popup_channel_endtime').val("");
		break;
		case "liveTarget":
		$('#schedulepopup').modal('hide');
		$('#sch_target_list').val("");
		$('#sch_target_list').selectpicker('refresh');
		$('#schedule_popup_target_starttime').val("");
		$('#schedule_popup_target_endtime').val("");
		$('#scheduleTargetpopup').modal('show');
		break;
	}

});
function scheduleActions(){
	var Ids = [];
    if($("#actionSchedule option:selected").val() == "" || $('.scheduleTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }


	$("input:checkbox[class=scheduleactions]:checked").each(function() {
		var id = $(this).val();
		Ids.push(id);
		var action = $("#actionSchedule").val();
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
				closeOnConfirm: true
			},
			function(){
				$.ajax({
			        url: baseURL + 'api/scheduleActions',
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){

			        	$('.scheduleTable tr td').find("input[type='checkbox']").prop('checked',false);
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
								toastr['success'](action + " Successfully!");
							break;
							case "Lock":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										var ch = jsonResponse.response[Ids[i]]["change"];
										$('#row_'+Ids[i]).find('.schLockUnlock').find('i').removeClass('fa-unlock');
										$('#row_'+Ids[i]).find('.schLockUnlock').find('i').addClass('fa-lock');
										$('#row_'+Ids[i]).find('.schLockUnlock').find('i').addClass('c-orange');
										schedulesLocks[Ids[i]] = 1;

									}
									else if(jsonResponse.response[Ids[i]]["status"] == false)
									{
										$('#row_'+Ids[i]).find('.schLockUnlock').find('i').removeClass('fa-lock');
										$('#row_'+Ids[i]).find('.schLockUnlock').find('i').addClass('fa-unlock');
										$('#row_'+Ids[i]).find('.schLockUnlock').find('i').removeClass('c-orange');
										schedulesLocks[Ids[i]] = 0;
									}
								}
								toastr['success'](action +" Successfully!");
							break;
							case "UnLock":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('.scheduleTable #row_'+Ids[i]).find('.schLockUnlock').find('i').removeClass('fa-lock');
										$('.scheduleTable #row_'+Ids[i]).find('.schLockUnlock').find('i').addClass('fa-unlock');
										$('.scheduleTable #row_'+Ids[i]).find('.schLockUnlock').find('i').removeClass('c-orange');
										schedulesLocks[Ids[i]] = 0;
									}
								}
								toastr['success'](action +" Successfully!");
							break;
							case "Delete":
								for(i=0; i<Ids.length; i++)
					        	{
									$('.scheduleTable #row_'+Ids[i]).remove();
								}
								toastr['success'](action +" Successfully!");

							break;
						}
					},
			        error:function(){
			        	$('.wowzaTable tr td').find("input[type='checkbox']").prop('checked',false);
			        	toastr['error']("Error Occurred while "+action+"!");
					}
				});
			});
		}
		else
		{
			toastr['info']('At least select one action');
			return false;
		}
	});
}
$(document).on('click','.scheduleDel',function(){

	var sdel = $(this);

	var schId = $(this).attr('id');
	idd = schId.split('_');
	if(schedulesLocks[idd[1]] == 1)
	{
		toastr['warning']('You cant perform this action on locked schedule');
		return;
	}
	var textt = $(this).parent().parent().find('.title').find('a').text();
	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to delete "+textt.replace(/(\r\n\t|\n|\r\t)/gm,"")+"!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, delete it!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "api/scheduledelete",
	        data:{'schId':schId,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Deleted Successfully!');
					$(sdel).parent().parent().remove();
					$.each(calenderEvents, function( key, value ) {
						console.log(value);
						console.log(schId);
						  if(value.id == idd[1])
						  {
						  	calenderEvents.pop(value);
						  }
					});
					$('#calendar').fullCalendar('removeEvents');
		            $('#calendar').fullCalendar('addEventSource', calenderEvents);
		            $('#calendar').fullCalendar('rerenderEvents' );

		            var s = $('.scheduleTable > tbody tr').length;
		            if(s == 1)
		            {
						$('.scheduleTable > tbody tr:eq(0)').after("<tr><td colspan='12'>Not Created Yet</td></tr>");
					}
				}
	            if(jsonResponse.status == false)
	            {
					toastr['error'](jsonResponse.response);
				}
			},
	        error:function(){
			}
		});
	});
});
var scheduleLength = $('.scheduleTable tr td .scheduleactions').length;
var scheduleCheckedLength = 0;
$('.scheduleTable tr td .scheduleactions').click(function(){

if($(this).is(":checked")== false)
	{
		if($('#selecctallschedule').is(":checked") == true)
		{
			$('#selecctallschedule').prop('checked', false);
		}
		scheduleCheckedLength = 0;
		$('.scheduleTable tr td .scheduleactions').each(function () {
           if($(this).is(":checked")== true)
           {
		   	   scheduleCheckedLength++;
		   }
        });
        if(scheduleCheckedLength == scheduleLength)
        {
			$('#selecctallschedule').prop('checked', true);
		}
	}
	else if($(this).is(":checked")== true)
	{
		scheduleCheckedLength = 0;
		$('.scheduleTable tr td .scheduleactions').each(function () {
           if($(this).is(":checked")== true)
           {
		   	  scheduleCheckedLength++;
		   }
        });
        if(scheduleCheckedLength == scheduleLength)
        {
			$('#selecctallschedule').prop('checked', true);
		}
	}
});
$('#selecctallschedule').click(function (event) {//alert(1);
    if (this.checked) {
        $('.scheduleactions').each(function () { //loop through each checkbox
            $(this).prop('checked', true); //check
        });
    } else {
        $('.scheduleactions').each(function () { //loop through each checkbox
            $(this).prop('checked', false); //uncheck
        });
    }
});

$(document).on('click','.scheduleTable tr td .schstartstop',function(){
    	var thisObj = $(this);
		var targetId = $(this).attr("id");
		var ids = targetId.split('_');
		var className = $(this).find('i').attr("class");
		var cname = className.split(' ');
		var action ="";
		var iddd = $(this).parent().attr("id");
		var IDSS = iddd.split("_");

		if(schedulesLocks[IDSS[1]] == 1)
		{
			toastr['warning']('You cant perform this action on locked schedule');
			return;
		}

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

			var act = targetId.split('_');
			if(act[0] == "target")
			{
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes " + action + " it!",
				closeOnConfirm: true
			},
			function(){
				if(action == "Stop" && appTargets[ids[1]] == "google")
				{
					location.href = baseURL + "admin/googleaccount/transiton/" + ids[1];
				}
				else
				{
					$.ajax({
				        url: baseURL + "admin/targetStartStop",
				        data:{'targetId':targetId,'action':action},
				        type:'post',
				        dataType:'json',
				        success:function(jsonResponse){
				            if(jsonResponse.status == true)
				            {
									switch(jsonResponse.code)
					                {
					                    case 200:
					                    if(jsonResponse.response == "Active" || jsonResponse.response == "Starting" || jsonResponse.response == "Waiting...")
					                    {
											if(cname[1] == "fa-play")
											{
												$(thisObj).find('i').attr("class","fa fa-pause");
											}
											else if(cname[1] == "fa-pause")
											{
												$(thisObj).find('i').attr("class","fa fa-play");
											}
										}


					                    break;
					                    case 400:
					                    toastr['error']('Error occurred while '+ action +'ing ');
					                    break;
					                    case 402:
					                    case 404:
					                    toastr['error']('Error occurred while '+ action +'ing ');
					                    break;
					                    case 415:
										toastr['error']('Error occurred while '+ action +'ing ');
					                    break;
					                    case 500:
										toastr['error']('Error occurred while '+ action +'ing ');
					                    break;
									}
									switch(jsonResponse.response)
					                {
					                    case "Disabled":
										$(thisObj).parent().parent('tr').find('#status').removeAttr("class");
										$(thisObj).parent().parent('tr').find('#status').addClass("label label-gray").text("Disabled");
										toastr['success']('Stream Disabled!');
					                    break;
					                     case "Active":
										$(thisObj).parent().parent('tr').find('#status').removeAttr("class");
										$(thisObj).parent().parent('tr').find('#status').addClass("label label-success").text("Active");
										toastr['success']('Active Stream!');
					                    break;
					                    case "Waiting...":
					                    $(thisObj).parent().parent('tr').find('#status').removeAttr("class");
										$(thisObj).parent().parent('tr').find('#status').addClass("label label-auth").text("Waiting");
										toastr['success']('Waiting Stream!');
					                    break;
					                    case "Starting":
					                    $(thisObj).parent().parent('tr').find('#status').removeAttr("class");
										$(thisObj).parent().parent('tr').find('#status').addClass("label label-auth").text("Starting");
										toastr['success']('Starting Stream!');
					                    break;
					                    case "Error":
					                    $(thisObj).parent().parent('tr').find('#status').removeAttr("class");
										$(thisObj).parent().parent('tr').find('#status').addClass("label label-danger").text("Error");
					                    break;
									}
									setTimeout(scheduleRefresh, 5000);
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
									toastr['success']('Start Successfully!');
				                    break;
				                    case 400:
				                    toastr['error']('Error occurred while '+ action +'ing ');
				                    break;
				                    case 402:
				                    case 404:
				                    toastr['error']('Error occurred while '+ action +'ing ');
				                    break;
				                    case 415:
									toastr['error']('Error occurred while '+ action +'ing ');
				                    break;
				                    case 500:
									toastr['error']('Error occurred while '+ action +'ing ');
				                    break;
								}
							}
						},
				        error:function(){
				        	toastr['error']('Error occurred while '+ action +'ing ');
						}
					});
				}
			});
		}
			else if(act[0] == "channel")
			{
				swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes " + action + " it!",
				closeOnConfirm: true
			},
			function(){
					$(thisObj).parent().parent().find("#status").removeAttr("class");
					$(thisObj).parent().parent().find("#status").addClass("label label-warning").text("Starting");
					$.ajax({
				        url: baseURL + "admin/channelStartStop",
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
									toastr['success'](jsonResponse.message);
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
									toastr['success'](jsonResponse.message);
									setTimeout(scheduleRefresh,5000);
									break;
								}
							}


				            if(jsonResponse.status == false)
				            {
								toastr['error']("Error occured while starting!");
								setTimeout(scheduleRefresh,5000);
							}
							    //$('.loaddiv').hide();
	    					//	$('body').css('overflow','scroll');
						},
				        error:function(){
				        		toastr['error']("Error occured while performing actions!");
				        		setTimeout(scheduleRefresh,5000);
				        		//$('.loaddiv').hide();
	    						//$('body').css('overflow','scroll');
						}
					});
				});
			}



		}
		else
		{
			toastr['info']("You can't " + action + " target with " + $(this).parent().parent().find('#status').text() + " status!");
		}
    });
var scheduleRefresh = function(){
	$('.scheduleTable tr td .schstartstop').each(function(){

		var CURL = "";
    	var thisObj = $(this);
		var channelId = $(this).attr("id");
		var className = $(this).find('i').attr("class");
		var cname = className.split(' ');
		var action ="checkstatus";
		var act = channelId.split('_');
		if(act[0] == "channel")
		{
			$.ajax({
		        url: baseURL + "admin/channelStartStop",
		        data:{'channelId':channelId,'action':'checkstatus'},
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
							break;
						}
					}
				},
		        error:function(){
				}
			});
		}
		else if(act[0] == "target")
		{
			var obj = $(this);
			$.ajax({
		        url: baseURL + "admin/targetStatus",
		        data:{'targetId':channelId,'action':'checkStatus'},
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
							$(obj).parent().parent('tr').find('.schstartstop').find('i').attr('class','fa fa-play');
		                    break;
		                     case "Active":
							$(obj).parent().parent('tr').find('#status').removeAttr("class");
							$(obj).parent().parent('tr').find('#status').addClass("label label-success").text("Active");
							$(obj).parent().parent('tr').find('.schstartstop').find('i').attr('class','fa fa-pause');
		                    break;
		                    case "Waiting...":
		                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
							$(obj).parent().parent('tr').find('#status').addClass("label label-auth").text("Waiting");
							$(obj).parent().parent('tr').find('.schstartstop').find('i').attr('class','fa fa-pause');
		                    break;
		                    case "Error":
		                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
							$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("Error");
							$(obj).parent().parent('tr').find('.schstartstop').removeAttr("href");
							$(obj).parent().parent('tr').find('.schstartstop').find('i').attr('class','fa fa-play').html("<i class='fa fa-ban' id='nested'></i>");
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
		}



    });
};
$('.scheduleTable tr td .schstartstop').each(function(){

		var CURL = "";
    	var thisObj = $(this);
		var channelId = $(this).attr("id");
		var className = $(this).find('i').attr("class");
		var cname = className.split(' ');
		var action ="checkstatus";
		var act = channelId.split('_');
		if(act[0] == "channel")
		{
			$.ajax({
		        url: baseURL + "admin/channelStartStop",
		        data:{'channelId':channelId,'action':'checkstatus'},
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
							break;
						}
					}
				},
		        error:function(){
				}
			});
		}
		else if(act[0] == "target")
		{
			var obj = $(this);
			$.ajax({
		        url: baseURL + "admin/targetStatus",
		        data:{'targetId':channelId,'action':'checkStatus'},
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
							$(obj).parent().parent('tr').find('.schstartstop').find('i').attr('class','fa fa-play');
		                    break;
		                     case "Active":
							$(obj).parent().parent('tr').find('#status').removeAttr("class");
							$(obj).parent().parent('tr').find('#status').addClass("label label-success").text("Active");
							$(obj).parent().parent('tr').find('.schstartstop').find('i').attr('class','fa fa-pause');
		                    break;
		                    case "Waiting...":
		                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
							$(obj).parent().parent('tr').find('#status').addClass("label label-auth").text("Waiting");
							$(obj).parent().parent('tr').find('.schstartstop').find('i').attr('class','fa fa-pause');
		                    break;
		                    case "Error":
		                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
							$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("Error");
							$(obj).parent().parent('tr').find('.schstartstop').removeAttr("href");
							$(obj).parent().parent('tr').find('.schstartstop').find('i').attr('class','fa fa-play').html("<i class='fa fa-ban' id='nested'></i>");
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
		}



    });
/*

		for(var i in jsonResponse.response)
		{
			for(var j=0; j<jsonResponse.response[i].length; j++)
			{
				//var sourcesArray = {'ip':jsonResponse.response[i][j].sourceIP,'name':jsonResponse.response[i][j].fname,'uname':jsonResponse.response[i][j].euname,'pass':jsonResponse.response[i][j].epass,'port':jsonResponse.response[i][j].port,'src':jsonResponse.response[i][j].ndiname,'encid':jsonResponse.response[i][j].encoderId};

				$.ajax({
					url: baseURL + "admin/extractSources",
					data:{'ip':jsonResponse.response[i][j].sourceIP,'name':jsonResponse.response[i][j].fname,'uname':jsonResponse.response[i][j].euname,'pass':jsonResponse.response[i][j].epass,'port':jsonResponse.response[i][j].port,'src':jsonResponse.response[i][j].ndiname,'encid':jsonResponse.response[i][j].encoderId,'nm':jsonResponse.response[i][j].nn},
					type:'post',
					dataType:'json',
					success:function(jsonResponseExtreact){
						console.log(jsonResponseExtreact.data);
						if(jsonResponseExtreact.data.isExist == true)
						{
							$('#external-events div[name="'+jsonResponseExtreact.data.src+'"]').find('img').attr('src',"");
							$('#external-events div[name="'+jsonResponseExtreact.data.src+'"]').find('img').attr('src',baseURL + 'assets/site/main/tmp/images/' + jsonResponseExtreact.data.name);
						}
						else if(jsonResponseExtreact.data.isExist == false)
						{
							$('#external-events div[name="'+jsonResponseExtreact.data.src+'"]').find('img').attr('src',"");
							$('#external-events div[name="'+jsonResponseExtreact.data.src+'"]').find('img').attr('src',baseURL + 'assets/site/main/images/default-gateway.png');
						}
					}
				});
			}
		}
*/

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": true,
  "onclick": null,
  "progressBar": true,
  "showDuration": "2000",
  "hideDuration": "2000",
  "timeOut": "5000",
  "extendedTimeOut": "2000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}


function init_events(ele) {
      $(ele).each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })



      })
}
function dropBanks()
{
	 $('.banks').droppable({
	    tolerance: "intersect",
	    accept: ".external-event",
	    activeClass: "ui-state-default",
	    hoverClass: "ui-state-hover",
	    drop: function(event, ui) {
	    	var obj = $(this);
	    	var isEmpty = $(obj).find('a').find('span').text();
	    	if(isEmpty != "" && isEmpty != "EmptyBank" && isEmpty != "Empty Bank")
	    	{
					swal({
						title: "",
						text: "This Bank is not empty! Are you sure you want to clear all and update the existing source?!",
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-danger",
						confirmButtonText: "Yes, Update it!",
						closeOnConfirm: true
					},
					function(){
						$.ajax({
							url: baseURL + "admin/updateBankName",
							data: { bankname: ui.draggable[0].firstChild.data,endoerId:ui.draggable[0].attributes.id.value, id:$(obj).attr('id'),name:ui.draggable[0].attributes.name.nodeValue },
							dataType: "json",
							type: "POST",
							success: function(data) {
								if(data.status == true)
								{
									$(obj).attr('name',ui.draggable[0].attributes.name.nodeValue);
									$(obj).find('a').find('span').text(ui.draggable[0].firstChild.data);
									banks[$(obj).attr('id')]['name'] = ui.draggable[0].firstChild.data;
									banks[$(obj).attr('id')]['isLocked'] = 0;
									banks = JSON.parse(data.banks);
									channelss = JSON.parse(data.channelss);
								}
								else if(data.status == false)
								{
									toastr['error']('Error Occured While updating bank!');
								}
							},
							error:function(){
								toastr['error']('Error Occured While updating bank!');
							}
						});
						if($('#removeafterdrop').prop('checked') == true)
						{
							$(ui.draggable).remove();
						}
					});

			}
			else
			{
				  $.ajax({
						url: baseURL + "admin/updateBankName",
						data: { bankname: ui.draggable[0].firstChild.data,endoerId:ui.draggable[0].attributes.id.value, id:$(obj).attr('id'),name:ui.draggable[0].attributes.name.nodeValue },
						dataType: "json",
						type: "POST",
						success: function(data) {
							if(data.status == true)
							{
								$(obj).attr('name',ui.draggable[0].attributes.name.nodeValue);
								$(obj).find('a').find('span').text(ui.draggable[0].firstChild.data);
								banks[$(obj).attr('id')]['name'] = ui.draggable[0].firstChild.data;
								banks = JSON.parse(data.banks);
								channelss = JSON.parse(data.channelss);
							}
							else if(data.status == false)
							{
								toastr['error']('Error Occured While updating bank!');
							}
						},
						error:function(){
							toastr['error']('Error Occured While updating bank!');
						}
					});
					if($('#removeafterdrop').prop('checked') == true)
					{
						$(ui.draggable).remove();
					}
			}

	    }
	});
}
function gatewaystrstp()
{
	$('#banks-events .banks').each(function(e){

		$(this).find('.channelStartStopGateway').each(function(){
			var thisObj = $(this);
			var id = $(this).attr('id');
			$.ajax({
				url: baseURL + "admin/gatewayStartStop",
				data:{'id':id,'action':"checkstatus"},
				type:'post',
				dataType:'json',
				success:function(jsonResponse){
					if(jsonResponse.status == true)
					{
						switch(jsonResponse.change)
						{
							case "start":
							$(thisObj).removeAttr("class");
							$(thisObj).addClass("label label-live channelStartStopGateway");												$(thisObj).find("span").removeClass("inactive");
							$(thisObj).find('.counter').removeClass("inactive");
							$(thisObj).find('.counter').attr('title',jsonResponse.time);
							var timer = setInterval(upTime, 1000);
							break;
							case "stop":
							$(thisObj).removeAttr("class");
							$(thisObj).find("span").addClass("inactive");
							$(thisObj).find('.counter').addClass("inactive");
							$(thisObj).addClass("label label-gray channelStartStopGateway");
							$(thisObj).find('.counter').attr('title',"").text("00:00:00");
							break;
						}
					}
					if(jsonResponse.status == false)
					{
						toastr['error'](jsonResponse.response);
					}
				},
				error:function(){
					toastr['error']('Error occured while performing actions');
				}
			});
		});
	});
}
function cald()
{
	 var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
      events    : calenderEvents,
      eventRender: function(event, element,calEvent) {

//here i am adding icon next to title

			element.find(".fc-title").after($("<span class=\"fc-event-icons\"></span>"));

	  },
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      }
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
}
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    if(typeof calenderEvents !== "undefined")
    {
		 var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
      events    : calenderEvents,
       eventRender: function(event, element,calEvent) {

//here i am adding icon next to title

			element.find(".fc-title").before($("<i class='fa fa-bolt'></i>"));

	  },
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      }
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
	}

  });

$(document).ready(function(){

	$("a.remote > span.text").html(function(i,val){
		return val.replace('Remote', "<span class='remote'>Remote</span>");
	});
	$('#calender').hide();
	$('.gateway-rtmp-url').hide();
	$('.gateway-rtmp-key').hide();
	$('.gateway-uname').hide();
	$('.gateway-pass').hide();
	$('.new-srt').hide();
	$('.ch-audio-channels').hide();
	if($('.banks').length > 0)
	{
		dropBanks();
	}

	$('#banks-events .banks').each(function(){

		$(this).find('.channelStartStopGateway').each(function(){
			var thisObj = $(this);
			var id = $(this).attr('id');
			$.ajax({
				url: baseURL + "admin/gatewayStartStop",
				data:{'id':id,'action':"checkstatus"},
				type:'post',
				dataType:'json',
				success:function(jsonResponse){
					if(jsonResponse.status == true)
					{
						switch(jsonResponse.change)
						{
							case "start":
							$(thisObj).removeAttr("class");
							$(thisObj).addClass("label label-live channelStartStopGateway");
							$(thisObj).find("span").removeClass("inactive");
							$(thisObj).find('.counter').removeClass("inactive");
							$(thisObj).find('.counter').attr('title',jsonResponse.time);
							var timer = setInterval(upTime, 1000);
							break;
							case "stop":
							$(thisObj).removeAttr("class");
							$(thisObj).find("span").addClass("inactive");
							$(thisObj).find('.counter').addClass("inactive");
							$(thisObj).addClass("label label-gray channelStartStopGateway");
							$(thisObj).find('.counter').attr('title',"").text("00:00:00");
							break;
						}
					}
					if(jsonResponse.status == false)
					{
						toastr['error'](jsonResponse.response);
					}
				},
				error:function(){
					toastr['error']('Error occured while performing actions');
				}
			});
		});
	});
});
// auto complete
if(Action == "createtarget" )
{
	if($( "#twitterCat").length > 0)
	{
		 $( "#twitterCat").autocomplete({
		source: function(request, response) {
			//console.info(request, 'request');
			//console.info(response, 'response');

			$.ajax({
				//q: request.term,
				url: baseURL + "admin/getTwitchGames",
				data: { term: $("#twitterCat").val()},
				dataType: "json",
				type: "POST",
				success: function(data) {
					response($.map(data, function (item) {
                            return {
                                name: item.name,
                                icon: item.icon
                            }
                        }));
				}
			});
		},
		focus: function( event, ui ) {
        $( "#twitterCat" ).val( ui.item.id );
        return false;
      },
      select: function( event, ui ) {
        $( "#twitterCat" ).val( ui.item.name );

        return false;
      },
		minLength: 1
}).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li><div class='respData'><img src='"+item.icon+"'><span>"+item.name+"</span></div></li>" ).appendTo( ul );
      };
	}
}



var appTargetRefresh = function(timeinseconds){

	   $('.appsTable tr td .appsdel').each(function(){
		var obj = $(this);
		var appId = $(this).attr('id');
		var idd = appId.split('_');
		$.ajax({
	        url: baseURL + "admin/applicationStatus",
	        data:{'appId':idd[1],'action':'checkStatus'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){

				if(jsonResponse.status == true)
				{
				  	switch(jsonResponse.response)
	                {
	                    case 200:
						$(obj).parent().parent('tr').find('#status').removeAttr("class");

						var storedAppLocks = JSON.parse(localStorage.getItem("applock"));
						if(storedAppLocks !== undefined && storedAppLocks != null && storedAppLocks.length > 0)
						{
							for(var i=0;i<storedAppLocks.length; i++)
							{
								if(storedAppLocks.indexOf("lock_" + idd[1]) != -1)
								{
									$(obj).parent().parent('tr').find('#status').addClass("label label-warning").text("Locked");
								}
								else
								{
									$(obj).parent().parent('tr').find('#status').addClass("label label-success").text("Un-Locked");
								}
							}
						}
						else
						{
							$(obj).parent().parent('tr').find('#status').addClass("label label-success").text("Un-Locked");
						}


	                    break;
					}
				}
				else if(jsonResponse.status == false)
				{
				  	switch(jsonResponse.response)
	                {
	                      case 404:
						$(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("NA");

	                    break;
	                    case 500:
	                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("NA");

	                    break;
					}
				}
			},
	        error:function(){

			}
		});
	});
	   $('.targetTable tr td .targenbdib').each(function(){
		var obj = $(this);
		var targetId = $(this).attr('id');
		$.ajax({
	        url: baseURL + "admin/targetStatus",
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
	                    case "Starting":
	                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-auth").text("Starting");
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
	   //setTimeout(appTargetRefresh, timeinseconds);
	};
$(document).on('click','.refreshchannelsStatus',function(){
	$(this).find('i').remove();
	$(this).html("<img style='float:right;' src='"+baseURL +"assets/site/main/images/loadSource.gif'/>");
	var thisObj = $(this);
	var channelId = $(this).attr("id");
	var action ="checkstatus";
		$.ajax({
		        url: baseURL + "channels/status",
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
							$(thisObj).parent().parent().find(".channelsstartstop").find('i').removeAttr("class");
							$(thisObj).parent().parent().find(".channelsstartstop").find('i').addClass("fa fa-pause");

							$(thisObj).parent().parent().find('.counter').attr('title',jsonResponse.time);
							var timer = setInterval(upTime, 1000);
							break;
							case "stop":
							$(thisObj).parent().parent().find("#status").removeAttr("class");
							$(thisObj).parent().parent().find("#status").addClass("label label-gray").text("Offline");
							$(thisObj).parent().parent().find(".channelsstartstop").find('i').removeAttr("class");
							$(thisObj).parent().parent().find(".channelsstartstop").find('i').addClass("fa fa-play");
							$(thisObj).parent().parent().find('.counter').attr('title',"");


							//var timer = setInterval(upTime, 1000);

							break;
						}
					}
		            if(jsonResponse.status == false)
		            {
						//swal("Error", "Error occured while starting!",'error');
					}
					$(thisObj).find('img').remove();
					$(thisObj).parent().find('img').show();
					$(thisObj).html("<i class='fa fa-refresh'></i>");
				},
		        error:function(){
				}
			});
});
var channelRefresh = function(){
	$('.channelTable tr td .channelsstartstop').each(function(){


    	var thisObj = $(this);
		var channelId = $(this).attr("id");
		var className = $(this).find('i').attr("class");
		var cname = className.split(' ');
		var action ="checkstatus";


		$.ajax({
			        url: baseURL + "admin/channelStartStop",
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
}
if(Action == "applications")
{
	//setTimeout(appTargetRefresh, 30000);
}


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
var wowzaUptime = function(){
	$('#wowzaengins .wowza_row td .wowid').each(function(){
	var obj = $(this);
	var wowzaId = $(this).attr('id');
		$.ajax({
	        url: baseURL + "admin/wowzauptime",
	        data:{'wowzaId':wowzaId,'action':'checkStatus'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
	                $(obj).parent().parent('tr').find('.uptime').text(jsonResponse.response.ServerUptime);
	                //$(obj).parent().parent('tr').find('.wowzadisable').attr("data-original-title","CPU:"+ jsonResponse.response.CPU+"%" + " Heap: "+ jsonResponse.response.CurrentHeapSize+ " Memory: "+ jsonResponse.response.MemoryUsed+" Disk: "+ jsonResponse.response.DiskUsed);
				}
	            if(jsonResponse.status == false)
	            {
	                $(obj).parent().parent('tr').find('.uptime').text("NA");
	               // $(obj).parent().parent('tr').find('.wowzadisable').attr("data-original-title","CPU: XX Heap: XX Memory: XX Disk: XX");
				}

			},
	        error:function(){
				$(obj).parent().parent('tr').find('.uptime').text("NA");
	               // $(obj).parent().parent('tr').find('.wowzadisable').attr("data-original-title","CPU: XX Heap: XX Memory: XX Disk: XX");
			}
		});
	});
};
var wowzaRefresh = function(){
	$('#wowzaengins .wowza_row td .wowid').each(function(){
	var obj = $(this);
	var wowzaId = $(this).attr('id');
	$.ajax({
        url: baseURL + "admin/wowzastatus",
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
};
$('#wowzaengins .wowza_row td .wowid').each(function(){
	var obj = $(this);
	var wowzaId = $(this).attr('id');
	$.ajax({
        url: baseURL + "admin/wowzastatus",
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
        url: baseURL + "admin/wowzauptime",
        data:{'wowzaId':wowzaId,'action':'checkStatus'},
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.status == true)
            {
                $(obj).parent().parent('tr').find('.uptime').text(jsonResponse.response.ServerUptime);
                //$(obj).parent().parent('tr').find('.wowzadisable').attr("data-original-title","CPU:"+ jsonResponse.response.CPU+"%" + " Heap: "+ jsonResponse.response.CurrentHeapSize+ " Memory: "+ jsonResponse.response.MemoryUsed+" Disk: "+ jsonResponse.response.DiskUsed);
			}
            if(jsonResponse.status == false)
            {
                $(obj).parent().parent('tr').find('.uptime').text("NA");
               // $(obj).parent().parent('tr').find('.wowzadisable').attr("data-original-title","CPU: XX Heap: XX Memory: XX Disk: XX");
			}

		},
        error:function(){
			$(obj).parent().parent('tr').find('.uptime').text("NA");
              //  $(obj).parent().parent('tr').find('.wowzadisable').attr("data-original-title","CPU: XX Heap: XX Memory: XX Disk: XX");
		}
	});
});
$(document).on('click','.wowzareboot',function(){
	var wowzaId = $(this).attr('id');
	var objj = $(this);
	var action = "";
	var permis = JSON.parse(userPermissions);
	var textt = $(this).parent().parent().find('.wowid').text();
	if(permis.reboot_wowza == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
	}
	swal({
		title: "Are you sure?",
		text: "You want to reboot "+textt.replace(/(\r\n\t|\n|\r\t)/gm,"")+"!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Reboot it!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/wowzareboot",
	        data:{'wowzaId':wowzaId,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {

	              	switch(jsonResponse.response)
	                {
	                    case 200:
	                    toastr['success']('Reboot Successfully!');
	                    break;
	                    case 400:
	                    case 402:
	                    case 404:
	                    case 415:
						toastr['error']('Error Occured While Rebooting!');
	                    break;
	                    default:
	                    toastr['error']('Error Occured While Rebooting!');
	                    break;
					}
					wowzaRefresh();
					wowzaUptime();
				}
	            if(jsonResponse.status == false)
	            {
					switch(jsonResponse.response)
	                {
	                    case 200:
	                    toastr['success']('Reboot Successfully!');
	                    break;
	                    case 400:
	                    case 402:
	                    case 404:
	                    case 415:
	                    toastr['error']('Error Occured While Rebooting!');
	                    break;
	                    default:
	                    toastr['error']('Error Occured While Rebooting!');
	                    break;
					}
					wowzaRefresh();
					wowzaUptime();
				}
			},
	        error:function(){
	        	toastr['error']('Error Occured While Rebooting!');
			}
		});
	});
});
$(document).on('click','.sched > a',function(){
	var opentab = $(this).attr('id');
	switch(opentab)
	{
		case "showlist":
		$('#list').show();
		$('#calenders').hide();
		break;
		case "showcalenders":
		$('#calenders').show();
		$('#calenders').addClass("active");
		$('#list').hide();
		break;
	}
});
$(document).on('click','.wowzarefresh',function(){

	var wowzaId = $(this).attr('id');
	var objj = $(this);
	var textt = $(this).parent().parent().find('.wowid').text();
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to refresh "+ textt.replace(/(\r\n\t|\n|\r\t)/gm,""),
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Refresh!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/wowzarefresh",
	        data:{'wowzaId':wowzaId,'action':'refresh'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Refresh Successfully!');
					wowzaRefresh();
					wowzaUptime();
				}
	            if(jsonResponse.status == false)
	            {
					toastr['error']("Error occured while refreshing.");
				}

			},
	        error:function(){
	        	toastr['error']("Error occured while refreshing.");
			}
		});
	});
});
$(document).on('click','.wowzadelete',function(){

	var wdel = $(this);
	var permis = JSON.parse(userPermissions);
	if(permis.delete_wowza == 0)
	{
		toastr['info']('Error! Insufficient Permissions','You do not have permission to do this operation. Contact your system administrator.');
		return;
	}

	var wowzaId = $(this).attr('id');
	var textt = $(this).parent().parent().find('.wowid').text();
	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to delete "+textt.replace(/(\r\n\t|\n|\r\t)/gm,"")+"!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, delete it!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/wowzadelete",
	        data:{'wowzaId':wowzaId,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Deleted Successfully!');
					$(wdel).parent().parent().remove();
				}
	            if(jsonResponse.status == false)
	            {
					toastr['error'](jsonResponse.response);
				}
			},
	        error:function(){
			}
		});
	});
});
function wowzaactions(){
	var Ids = [];
    if($("#actionval option:selected").val() == "" || $('.wowzaTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }


	$("input:checkbox[class=groupdel2]:checked").each(function() {
		var id = $(this).val();
		Ids.push(id);
		var action = $("#actionval").val();
		if(action != "")
		{
			var permis = JSON.parse(userPermissions);
			switch(action)
			{
				case "Reboot":
				if(permis.reboot_wowza == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}

				break;
				case "Delete":
				if(permis.delete_wowza == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
			}

			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: true
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
								toastr['success'](action + " Successfully!");
								wowzaRefresh();
							break;
							case "TakeOffline":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-danger");
										$('#row_'+Ids[i]).find("#status").text("Offline");
									}
								}
								toastr['success'](action +" Successfully!");
							break;
							case "BringOnline":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-success");
										$('#row_'+Ids[i]).find("#status").text("Online");
									}
								}
								toastr['success'](action +" Successfully!");
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
								toastr['success'](action +" Successfully!");
								wowzaRefresh();
							break;
							case "Delete":
								for(i=0; i<Ids.length; i++)
					        	{
									$('.wowzaTable #row_'+Ids[i]).remove();
								}
								toastr['success'](action +" Successfully!");

							break;
						}
					},
			        error:function(){
			        	$('.wowzaTable tr td').find("input[type='checkbox']").prop('checked',false);
			        	toastr['error']("Error Occurred while "+action+"!");
					}
				});
			});
		}
		else
		{
			toastr['info']('At least select one action');
			return false;
		}
	});

}
$('.wowzaTable tr td a.wowzadisable').on('mouseover',function(){

	$(this).parent('td').find('.box-body').show();
});
$('.wowzaTable tr td a.wowzadisable').on('mouseleave',function(){

	$(this).parent('td').find('.box-body').hide();
});
$('.encoderTable tr td a.encoder_heart').on('mouseover',function(){

	$(this).parent('td').find('.box-body').show();
});
$('.encoderTable tr td a.encoder_heart').on('mouseleave',function(){

	$(this).parent('td').find('.box-body').hide();
});
$('.gatewayTable tr td a.gateway_heart').on('mouseover',function(){

	$(this).parent('td').find('.box-body').show();
});
$('.gatewayTable tr td a.gateway_heart').on('mouseleave',function(){

	$(this).parent('td').find('.box-body').hide();
});



/* ================================================================ */
/*  Function for wowza Actions Dropdown & All Single Actions End    */
/* ================================================================ */

/* ================================================================= */
/*  Function for Encoder Actions Dropdown & All Single Actions Start */
/* ================================================================= */
/*
$('.encoderTable tbody tr td .enciid').each(function(){
	var obj = $(this);
	var wowzaId = $(this).attr('id');
	$.ajax({
        url: baseURL + "admin/encoderUptime",
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
                //$(obj).parent().parent('tr').find('.wowzadisable').attr("data-original-title","CPU: XX Heap: XX Memory: XX Disk: XX");
		}
	});
});*/
/* Gateways */
var gatewayLength = $('.gatewayTable tr td .gatewaysGrp').length;
var gatewayCheckedLength = 0;
$('.gatewayTable tr td .gatewaysGrp').click(function(){

if($(this).is(":checked")== false)
	{
		if($('#selectallgateways').is(":checked") == true)
		{
			$('#selectallgateways').prop('checked', false);
		}
		gatewayCheckedLength = 0;
		$('.gatewayTable tr td .gatewaysGrp').each(function () {
           if($(this).is(":checked")== true)
           {
		   	   gatewayCheckedLength++;
		   }
        });
        if(gatewayCheckedLength == gatewayLength)
        {
			$('#selectallgateways').prop('checked', true);
		}
	}
	else if($(this).is(":checked")== true)
	{
		gatewayCheckedLength = 0;
		$('.gatewayTable tr td .gatewaysGrp').each(function () {
           if($(this).is(":checked")== true)
           {
		   	  gatewayCheckedLength++;
		   }
        });
        if(gatewayCheckedLength == gatewayLength)
        {
			$('#selectallgateways').prop('checked', true);
		}
	}
});
$('#selectallgateways').click(function (event) {//alert(1);
    if (this.checked) {
        $('.gatewaysGrp').each(function () { //loop through each checkbox
            $(this).prop('checked', true); //check
        });
    } else {
        $('.gatewaysGrp').each(function () { //loop through each checkbox
            $(this).prop('checked', false); //uncheck
        });
    }
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
	var id = wowzaId.split('_');
	var objj = $(this);
	var action = "";
	var permis = JSON.parse(userPermissions);
	if(permis.reboot_encoder == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
	}
	swal({
		title: "Are you sure?",
		text: "You want to reboot this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Reboot it!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/encoderReboot",
	        data:{'wowzaId':wowzaId,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
	              	switch(jsonResponse.response[id[1]].response)
	                {
	                    case 200:
	                   	toastr['success']('Reboot Successfully!');
	                    break;
	                    case 400:
	                    case 402:
	                    case 404:
	                    case 415:
						toastr['error']('Error Occured while rebooting!');
	                    break;
					}
				}
	            if(jsonResponse.status == false)
	            {
					switch(jsonResponse.response[id[1]].response)
	                {
	                    case 200:
	                   	toastr['success']('Reboot Successfully!');
	                    break;
	                    case 400:
	                    case 402:
	                    case 404:
	                    case 415:
	                  	toastr['error']('Error Occured while rebooting!');
	                    break;
	                    case "NOT Connecting":
	                    toastr['error']('Error Occured while connecting to server!');
	                    break;
	                    default:
	                    toastr['error']('Error Occured while rebooting!');
	                    break;
					}
				}
			},
	        error:function(){
	        	toastr['error']('Error Occured while rebooting!');
			}
		});
	});
});

$(document).on('click','.gateway_refresh',function(){

	var wowzaId = $(this).attr('id');
	var id = wowzaId.split('_');
	var objj = $(this);
	var action = "";
	swal({
		title: "Are you sure?",
		text: "You want to refresh this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Refresh!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/gatewayRefresh",
	        data:{'wowzaId':wowzaId,'action':'refresh'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.response[id[1]].status == true)
	            {
					toastr['success']('Refresh Successfully!');
				}
	            if(jsonResponse.response[id[1]].status == false)
	            {
					toastr['error'](jsonResponse.response);
				}
			},
	        error:function(){
	        	toastr['error']("Error occured while Re-freshing.");
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
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/encoderRefresh",
	        data:{'wowzaId':wowzaId,'action':'refresh'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Refresh Successfully!');
				}
	            if(jsonResponse.status == false)
	            {
					toastr['error'](jsonResponse.response);
				}
			},
	        error:function(){
	        	toastr['error'](jsonResponse.response);
			}
		});
	});
});
$(document).on('click','.encodersdelete',function(){

	var eDel = $(this);
	var permis = JSON.parse(userPermissions);
	if(permis.delete_encoder == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
	}
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
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/encodersdelete",
	        data:{'encodersId':encodersId,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Deleted Successfully!');
					$(eDel).parent().parent().remove();
				}
	            if(jsonResponse.status == false)
	            {
					toastr['error'](jsonResponse.response);
				}
			},
	        error:function(){
	        	toastr['error'](jsonResponse.response);
			}
		});
	});
});
$(document).on('click','.gateway_reboot',function(){

	var wowzaId = $(this).attr('id');
	var objj = $(this);
	var action = "";
	var permis = JSON.parse(userPermissions);
	if(permis.reboot_encoder == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
	}
	swal({
		title: "Are you sure?",
		text: "You want to reboot this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Reboot it!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/gatewayReboot",
	        data:{'wowzaId':wowzaId,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
	              	switch(jsonResponse.response)
	                {
	                    case 200:
	                   	toastr['success']('Reboot Successfully!');
	                    break;
	                    case 400:
	                    case 402:
	                    case 404:
	                    case 415:
						toastr['error']('Error Occured while rebooting!');
	                    break;
					}
				}
	            if(jsonResponse.status == false)
	            {
					switch(jsonResponse.response)
	                {
	                    case 200:
	                   	toastr['success']('Reboot Successfully!');
	                    break;
	                    case 400:
	                    case 402:
	                    case 404:
	                    case 415:
	                  	toastr['error']('Error Occured while rebooting!');
	                    break;
	                    default:
	                    toastr['error']('Error Occured while rebooting!');
	                    break;
					}
				}
			},
	        error:function(){
	        	toastr['error']('Error Occured while rebooting!');
			}
		});
	});
});
$(document).on('click','.gatewayssdelete',function(){

	var eDel = $(this);
	var permis = JSON.parse(userPermissions);
	if(permis.delete_gateway == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
	}
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
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/gatewayssdelete",
	        data:{'encodersId':encodersId,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Deleted Successfully!');
					$(eDel).parent().parent().remove();
				}
	            if(jsonResponse.status == false)
	            {
					toastr['error'](jsonResponse.response);
				}
			},
	        error:function(){
	        	toastr['error'](jsonResponse.response);
			}
		});
	});
});
function submitAllgateways(){
	var Ids = [];
	if($("#actionGateways option:selected").val() == "" || $('.gatewayTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }

	$("input:checkbox[class=gatewaysGrp]:checked").each(function () {
		var id = $(this).val();
		Ids.push(id);
		var action = $("#actionGateways").val();
		if(action != "")
		{
			var permis = JSON.parse(userPermissions);
			switch(action)
			{
				case "Reboot":
				if(permis.reboot_encoder == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "Delete":
				if(permis.delete_encoder == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
			}



			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: true
			},
			function(){
				$.ajax({
			        url: baseURL + 'admin/gatewayActions',
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){

			        	$('.gatewayTable tr td').find("input[type='checkbox']").prop('checked',false);
			        	$('.gatewayTable tr th').find("input[type='checkbox']").prop('checked',false);
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
								toastr['success'](action + " Successfully!");
							break;
							case "TakeOffline":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-danger");
										$('#row_'+Ids[i]).find("#status").text("Offline");
									}
								}
								toastr['success'](action +" Successfully!");
							break;
							case "BringOnline":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-success");
										$('#row_'+Ids[i]).find("#status").text("Online");
									}
								}
								toastr['success'](action +" Successfully!");
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
								toastr['success'](action + " Successfully!");
							break;
							case "Delete":
							toastr['success'](action + " Successfully!");
							for(i=0; i<Ids.length; i++)
				        	{
								$('.gatewayTable #row_'+Ids[i]).remove();
							}
							break;
						}
					},
			        error:function(){
			        	toastr['error']("Error Occured While performing actions");
					}
				});
			});
		}
		else
		{
			toastr['info']("At least select one action");
			return;
		}
	});
}
function submitAllencoders(){
	var Ids = [];
	if($("#actionEncoders option:selected").val() == "" || $('.encoderTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }

	$("input:checkbox[class=endcoderGrp]:checked").each(function () {
		var id = $(this).val();
		Ids.push(id);
		var action = $("#actionEncoders").val();
		if(action != "")
		{
			var permis = JSON.parse(userPermissions);
			switch(action)
			{
				case "Reboot":
				if(permis.reboot_encoder == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "Delete":
				if(permis.delete_encoder == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
			}



			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: true
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
								toastr['success'](action + " Successfully!");
							break;
							case "TakeOffline":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-danger");
										$('#row_'+Ids[i]).find("#status").text("Offline");
									}
								}
								toastr['success'](action +" Successfully!");
							break;
							case "BringOnline":
								for(i=0; i<Ids.length; i++)
					        	{
									if(jsonResponse.response[Ids[i]]["status"] == true)
									{
										$('#row_'+Ids[i]).find("#status").removeAttr("class");
										$('#row_'+Ids[i]).find("#status").addClass("label label-success");
										$('#row_'+Ids[i]).find("#status").text("Online");
									}
								}
								toastr['success'](action +" Successfully!");
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
								toastr['success'](action + " Successfully!");
							break;
							case "Delete":
							toastr['success'](action + " Successfully!");
							for(i=0; i<Ids.length; i++)
				        	{
								$('.encoderTable #row_'+Ids[i]).remove();
							}
							break;
						}
					},
			        error:function(){
			        	toastr['error']("Error Occured While performing actions");
					}
				});
			});
		}
		else
		{
			toastr['info']("At least select one action");
			return;
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
		var permis = JSON.parse(userPermissions);
		if(icon[1] == "fa-check-circle")
		{
			act = "Disable";
			if(permis.disable_template == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
		}
		else if(icon[1] == "fa-ban")
		{
			act = "Enable";
			if(permis.enable_template == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
		}
		swal({
				title: "Are you sure?",
				text: "You want to "+act+" this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes "+act+" it!",
				closeOnConfirm: true
			},
		function(){
				$.ajax({
			        url: baseURL + "admin/templateEnableDisable",
			        data:{'templateId':templateId,'action':act},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
								toastr['success'](act + ' Successfully!');

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
							toastr['error']('Error Occured While '+act+'!');
						}
					},
			        error:function(){
			        	toastr['error']('Error Occured While '+act+'!');
					}
				});
			});
	});
$('.encodingTable tr td .deleteEncodingTempate').click(function(){
	var permis = JSON.parse(userPermissions);
	if(permis.delete_template == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
	}
		var thisObj = $(this);
		var templateId = $(this).attr("id");
		swal({
				title: "Are you sure?",
				text: "You want to Delete this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes delete it!",
				closeOnConfirm: true
			},
		function(){
				$.ajax({
			        url: baseURL + "admin/templateDelete",
			        data:{'templateId':templateId},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
							toastr['success']('Deleted Successfully!');
							location.reload();
						}
			            if(jsonResponse.status == false)
			            {
							toastr['error']('Error Occured While Deleting!');
						}
					},
			        error:function(){
			        	toastr['error']('Error Occured While Deleting!');
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

	if($("#enctempactionval option:selected").val() == "" || $('.encodingTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }

	$("input:checkbox[class=encodingTemplates]:checked").each(function () {
		var thisobj = $(this);
		var id = $(this).attr("id");
		var ieT = id.split('_');
		Ids.push(ieT[1]);
		var action = $("#enctempactionval").val();
		if(action != "")
		{
			var permis = JSON.parse(userPermissions);
			switch(action)
			{
				case "Enable":
				if(permis.enable_template == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "Disable":
				if(permis.disable_template == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "Delete":
				if(permis.disable_template == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
			}
			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: true
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
							else if(action == "Delete")
			            	{
			            		for(var i=0; i<Ids.length; i++)
			            		{
									$('.encodingTable #row_'+Ids[i]).remove();
								}
							}
							toastr['success'](action + " Successfully!");
						}
			            if(jsonResponse.status == false)
			            {
							toastr['error']( jsonResponse.response);
						}
					},
			        error:function(){
			        	toastr['error']('Error occured while ' + action);
					}
				});
			});
		}
		else
		{
			toastr['info']('At least select one action');
			return;
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
	if($("#actionChannels option:selected").val() == "" || $('.channelTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }

	$("input:checkbox[class=channelActions]:checked").each(function () {
		var ids = $(this).attr("id");
		var id = ids.split('_');
		Ids.push(id[1]);
		var action = $("#actionChannels").val();
		var permis = JSON.parse(userPermissions);
		switch(action)
		{
			case "Lock":
			if(permis.lock_channel == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
			break;
			case "Un-Lock":
			if(permis.unlock_channel == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
			break;
			case "Restart":
			if(permis.restart_channel == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
			break;
			case "Delete":
			if(permis.delete_channel == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
			break;
		}


		if(action != "" && action != "0" && action == "Lock" || action == "UnLock")
		{

			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: true
			},
			function(){
				if(action == "Lock")
				{
					lockChannels.push(id[1]);
					$('#row_' + id[1]).find('.channellocs').find('i').removeAttr("class");
					$('#row_' + id[1]).find('.channellocs').find('i').attr("class","fa fa-lock");
				}
				if(action == "UnLock")
				{
					lockChannels.pop(id[1]);
					$('#row_' + id[1]).find('.channellocs').find('i').removeAttr("class");
					$('#row_' + id[1]).find('.channellocs').find('i').attr("class","fa fa-unlock");
				}
				localStorage.setItem("channelsLock", JSON.stringify(lockChannels));
				toastr['success'](action + "!", "Successfully!");
			});
			return;
		}




		if(action != "" && action != "0" && action == "Restart" || action == "Delete" || action == "Archive")
		{
			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: true
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
								toastr['success'](action + "!", "Successfully!");
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
								toastr['success'](action + "!", "Successfully!");
							break;
							case "Delete":
							toastr['success'](action +  " Successfully!");
							for(i=0; i<Ids.length; i++)
				        	{
								$('.channelTable #row_'+Ids[i]).remove();
							}
							case "Archive":
							toastr['success'](action +  " Successfully!");
							for(i=0; i<Ids.length; i++)
				        	{
								$('.channelTable #row_'+Ids[i]).remove();
							}
							break;
						}
					},
			        error:function(){
			        	toastr['error']("Error Occured While performing actions");
					}
				});
			});
		}
		else
		{
			toastr['info']('At least select one action');
			return;
		}
	});
}
function submitArchiveChannels()
{
	var Ids = [];
	if($("#actionArchiveChannel option:selected").val() == "" || $('.archiveChannelsTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }

	$("input:checkbox[class=selectarchive]:checked").each(function () {
		var ids = $(this).attr("id");
		var id = ids.split('_');
		Ids.push(id[1]);
		var action = $("#actionArchiveChannel").val();

		if(action != "" && action != "0" && action == "Restore" || action == "Delete")
		{
			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: true
			},
			function(){
				$.ajax({
			        url: baseURL + 'admin/channelActions',
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){

			        	$('.archiveChannelsTable tr td').find("input[type='checkbox']").prop('checked',false);
			        	$('.archiveChannelsTable tr th').find("input[type='checkbox']").prop('checked',false);
			        	switch(action)
			        	{
							case "Delete":
							toastr['success'](action +  " Successfully!");
							for(i=0; i<Ids.length; i++)
				        	{
								$('.archiveChannelsTable #row_'+Ids[i]).remove();
							}
							case "Restore":
							toastr['success'](action +  " Successfully!");
							for(i=0; i<Ids.length; i++)
				        	{
								$('.archiveChannelsTable #row_'+Ids[i]).remove();
							}
							break;
						}
						$('.archiveChannelsTable').DataTable().ajax.reload();
					},
			        error:function(){
			        	toastr['error']("Error Occured While performing actions");
					}
				});
			});
		}
		else
		{
			toastr['info']('At least select one action');
			return;
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
	if(applicationLocks[idd[1]] == 1)
	{
		toastr['warning']('You cant perform this action on locked APP');
		return;
	}

	var permis = JSON.parse(userPermissions);
	if(permis.reboot_application == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
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
			closeOnConfirm: true
		},
		function(){
			$.ajax({
		        url: baseURL + "admin/applicaitonRestart",
		        data:{'wowzaId':appid,'action':'Reboot'},
		        type:'post',
		        dataType:'json',
		        success:function(jsonResponse){
		            if(jsonResponse.status == true)
		            {
						toastr['success']('Refresh Successfully!');
					}
		            if(jsonResponse.status == false)
		            {
		            	toastr['error'](jsonResponse.response);
					}
				},
		        error:function(){
		        	toastr['error']('Error occurred while performing actions');
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
	if(applicationLocks[idd[1]] == 1)
	{
		toastr['warning']('You cant perform this action on locked APP');
		return;
	}
	var permis = JSON.parse(userPermissions);
	if(permis.copy_application == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
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
				closeOnConfirm: true
			},
			function(){
				$.ajax({
			        url: baseURL + "admin/copyApplication",
			        data:{'appid':appid,'action':'delete'},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
							toastr['success']('Deleted Successfully!');
							location.reload();
						}
			            if(jsonResponse.status == false)
			            {
			            	toastr['error'](jsonResponse.response);
						}
					},
			        error:function(){
			        	toastr['error']('Error occurred while performing actions');
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

	if(applicationLocks[idd[1]] == 1)
	{
		toastr['warning']('You cant perform this action on locked APP');
		return;
	}
	var permis = JSON.parse(userPermissions);
	if(permis.delete_application == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
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
			closeOnConfirm: true
		},
		function(){
			$.ajax({
		        url: baseURL + "admin/deleteApplication",
		        data:{'appid':appid,'action':'delete'},
		        type:'post',
		        dataType:'json',
		        success:function(jsonResponse){
		            if(jsonResponse.status == true)
		            {
						toastr['success']('Deleted Successfully!');
						$(objj).parent().parent().remove();
					}
		            if(jsonResponse.status == false)
		            {
		            	toastr['error'](jsonResponse.response);
					}
				},
		        error:function(){
		        	toastr['error']('Error occured while performing actions');
				}
			});
		});
	}
});
/* For Application Status */
 $('.appsTable tr td .appsdel').each(function(){
		var obj = $(this);
		var appId = $(this).attr('id');
		var idd = appId.split('_');
		$.ajax({
	        url: baseURL + "admin/applicationStatus",
	        data:{'appId':idd[1],'action':'checkStatus'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){

				if(jsonResponse.status == true)
				{
				  	switch(jsonResponse.response)
	                {
	                    case 200:
						$(obj).parent().parent('tr').find('#status').removeAttr("class");

						if(applicationLocks[idd[1]] == 1)
						{
							$(obj).parent().parent().find('.appsLock').find('i').removeAttr('class');
							$(obj).parent().parent().find('.appsLock').find('i').addClass('fa fa-lock');
							$(obj).parent().parent('tr').find('#status').removeAttr("class");
							$(obj).parent().parent('tr').find('#status').addClass("label label-warning").text("Locked");
						}
						else if(applicationLocks[idd[1]] == 0)
						{
							$(obj).parent().parent().find('.appsLock').find('i').removeAttr('class');
							$(obj).parent().parent().find('.appsLock').find('i').addClass('fa fa-unlock');
							$(obj).parent().parent('tr').find('#status').removeAttr("class");
							$(obj).parent().parent('tr').find('#status').addClass("label label-success").text("Un-Locked");
						}
	                    break;
					}
				}
				else if(jsonResponse.status == false)
				{
				  	switch(jsonResponse.response)
	                {
	                      case 404:
						$(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("NA");

	                    break;
	                    case 500:
	                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-danger").text("NA");

	                    break;
					}
				}
			},
	        error:function(){

			}
		});
	});

$('.appsTable tr td .appsLock').each(function(){

	var ids = $(this).attr('id');
	var id = ids.split('_');
	if(applicationLocks[id[1]] == 1)
	{
		$(this).find('i').removeAttr('class');
		$(this).find('i').addClass('fa fa-lock');
		$(this).parent().parent('tr').find('#status').removeAttr("class");
		$(this).parent().parent('tr').find('#status').addClass("label label-warning").text("Locked");
	}
	else if(applicationLocks[id[1]] == 0)
	{
		$(this).find('i').removeAttr('class');
		$(this).find('i').addClass('fa fa-unlock');
		$(this).parent().parent('tr').find('#status').removeAttr("class");
		$(this).parent().parent('tr').find('#status').addClass("label label-success").text("Un-Locked");
	}
});
$(document).on('click','.appsLock',function(){

	var permis = JSON.parse(userPermissions);
	var obj = $(this);
	var id = $(this).attr("id");
	var cls = $(this).find('i').attr('class');
	var classNames = cls.split(' ');
	var ids = id.split('_');
	if(classNames[1] == "fa-unlock")
	{
		if(permis.lock_application == 0)
		{
			toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
			return;
		}
		action = "Lock";
	}
	else if(classNames[1] == "fa-lock")
	{
		if(permis.lock_application == 0)
		{
			toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
			return;
		}
		action = "UnLock";
	}
			swal({
				title: "Are you sure?",
				text: "You want to "+action+" this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, "+action+" it!",
				closeOnConfirm: true
			},
			function(){
				$.ajax({
					url: baseURL + "admin/appsLockUnlock",
					data:{'id':id,'action':action},
					type:'post',
					dataType:'json',
					success:function(jsonResponse){
						if(jsonResponse.status == true)
						{
							if(action == "Lock")
							{
								$(obj).find('i').removeClass('fa-unlock');
								$(obj).find('i').addClass('fa-lock');
								applicationLocks[ids[1]] = 1;
								$(obj).parent().parent().find("#status").removeAttr("class");
								$(obj).parent().parent().find("#status").addClass("label label-warning").text("Locked");
							}
							else if(action == "UnLock")
							{
								$(obj).find('i').removeClass('fa-lock');
								$(obj).find('i').addClass('fa-unlock');
								applicationLocks[ids[1]] = 0;
								$(obj).parent().parent().find("#status").removeAttr("class");
								$(obj).parent().parent().find("#status").addClass("label label-success").text("Un-Locked");
							}

							toastr['success']( action + ' Successfully!');
						}
						if(jsonResponse.status == false)
						{
							toastr['error'](jsonResponse.response);
						}
					},
					error:function(){
						toastr['error']('Error occured while performing actions');
					}
				});
			});


});
function submitAllApps(appurl)
{
	var Ids = [];

   if($("#actionappval1 option:selected").val() == "" || $('.appsTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }

	$("input:checkbox[class=appActions]:checked").each(function () {
		var appid = $(this).attr("id");
		var id = appid.split('_');
		Ids.push(id[1]);
		var action = $("#actionappval1").val();
		var permis = JSON.parse(userPermissions);
			switch(action)
			{
				case "Lock":
				if(permis.lock_application == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "Un-Lock":
				if(permis.unlock_application == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "Reboot":
				if(permis.reboot_application == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "Delete":
				if(permis.delete_application == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
			}
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
				closeOnConfirm: true
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
							toastr['success'](action + " Successfully!");
							if(action == "Delete")
							{
								for(var i=0; i<Ids.length; i++)
								{
									$('.appsTable #row_'+Ids[i]).remove();
								}
							}
							if(action == "Archive")
							{
								for(var i=0; i<Ids.length; i++)
								{
									var Appname = $('.appsTable #row_'+Ids[i] + ' .appname').text();
									$('.targetTable tbody tr .targetappname').each(function(){
										var apptarname = $(this).text();
										if(Appname == apptarname)
										{
											$(this).parent().remove();
										}
									});
									$('.appsTable #row_'+Ids[i]).remove();
								}
							}
						}
			            if(jsonResponse.status == false)
			            {
							toastr['error'](jsonResponse.response);
						}
					},
			        error:function(){
			        	toastr['error']('Error occured while performing actions');
					}
				});
			});
		}
		else
		{
			toastr['info']('At least select one action');
			return;
		}
	});
}
function submitAllArchiveApps(appurl)
{
	var Ids = [];

   if($("#actionArchiveApps option:selected").val() == "" || $('.archiveAppsTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }

	$("input:checkbox[class=selectarchApps]:checked").each(function () {
		var appid = $(this).attr("id");
		var id = appid.split('_');
		Ids.push(id[1]);
		var action = $("#actionArchiveApps").val();
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
				closeOnConfirm: true
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
							toastr['success'](action + " Successfully!");
							if(action == "Delete")
							{
								for(var i=0; i<Ids.length; i++)
								{
									$('.archiveAppsTable #row_'+Ids[i]).remove();
								}

							}
							if(action == "Restore")
							{
								for(var i=0; i<Ids.length; i++)
								{
									$('.archiveAppsTable #row_'+Ids[i]).remove();
								}
							}
							$('.archiveAppsTable').DataTable().ajax.reload();
						}
			            if(jsonResponse.status == false)
			            {
							toastr['error'](jsonResponse.response);
						}
					},
			        error:function(){
			        	toastr['error']('Error occured while performing actions');
					}
				});
			});
		}
		else
		{
			toastr['info']('At least select one action');
			return;
		}
	});
}
/* ================================================================= */
/* Function for Apps Actions Dropdown & All Single Actions End */
/* ================================================================= */

$('.wowzashowhide').on('click',function(){
	var wid = $(this).attr("id");
	var loclr = JSON.parse(localStorage.getItem("rightside"));
	$('#wowza_accordion_' + wid).fadeOut("slow");
	$('#resourcesUL li#liwowza_'+ wid).find('input[type="checkbox"]').prop("checked",false);
	if(loclr != undefined && loclr != null && loclr.length > 0)
			{
				loclr.push("liwowza_" + wid);
				localStorage.setItem("rightside", JSON.stringify(loclr));
			}
			else
			{
				rightSideBar.push("liwowza_" + wid);
				localStorage.setItem("rightside", JSON.stringify(rightSideBar));
			}
});

$(window).bind('beforeunload',function(){
   // $('.loaddiv').show();
    $('body').css('overflow','hidden');
    $('.loaddiv').css('height',$(window).height());
});
 $(window).on('load',function() {
   // $('.loaddiv').hide();
    $('body').css('overflow','scroll');
  });



$(document).ready(function(){

	/* Archive Section */
	/*archiveTargetTable = $('.archiveTargetTable').DataTable( {
		 	 "columns":[
	            {
	            	"data": "checkbox",
	                "sortable": false
	            },
	            {
	            	"data": "counter",
	                "sortable": true
	            },
	            {
	            	"data": "target_name",
	                "sortable": false
	            },

	            {
	            	"data": "streamurl",
	                "sortable": false
	            },
	            {
	            	"data": "target",
	                "sortable": false
	            },

	            {
	            	"data": "uid",
	                "sortable": false
	            },
	            {
	            	"data": "restore",
	                "sortable": false
	            },
	            {
	            	"data": "delete",
	                "sortable": false
	            }
	        ],
	        "autoWidth" : false,

	        "order": [[1, "desc" ]],
	        "processing": true,
	        "serverSide": true,
	        "ajax": baseURL + "admin/getarchiveTargets",
	         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/img/loading.gif'></div>"}
	    } );
		archiveTargetTable.columns.adjust().draw();*/

		 reprottable = $('.archiveTargetTable').DataTable({
        "order": [[1, "desc" ]],
        "processing": true,
        "sorting":false,
        "searching":false,
        "serverSide": true,
        "ajax": {
        	"url":baseURL + "admin/getarchiveTargets",
        	"type": "POST",
            "data": function ( data ) {
            }
        },
         "aoColumnDefs": [
          {'bSortable':false,'aTargets': [0]},{'bSortable':false,'aTargets': [1]},{'bSortable':false,'aTargets': [2]},{'bSortable':false,'aTargets': [3]},{'bSortable':false,'aTargets': [4]},{'bSortable':false,'aTargets': [5]},{'bSortable':false,'aTargets': [6]},{'bSortable':false,'aTargets': [7]}
       ],
         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/img/loading.gif'></div>"}
    } );

	/*archiveAppsTable = $('.archiveAppsTable').DataTable( {
		 	 "columns":[
	            {
	            	"data": "checkbox",
	                "sortable": false
	            },
	            {
	            	"data": "counter",
	                "sortable": true
	            },
	            {
	            	"data": "application_name",
	                "sortable": false
	            },

	            {
	            	"data": "wowza_path",
	                "sortable": false
	            },
	            {
	            	"data": "uid",
	                "sortable": false
	            },
	            {
	            	"data": "restore",
	                "sortable": false
	            },
	            {
	            	"data": "delete",
	                "sortable": false
	            }
	        ],
	        "autoWidth" : false,

	        "order": [[1, "desc" ]],
	        "processing": true,
	        "serverSide": true,
	        "ajax": baseURL + "admin/getarchiveApps",
	         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/img/loading.gif'></div>"}
	    } );
		archiveAppsTable.columns.adjust().draw();*/

		 reprottable = $('.archiveAppsTable').DataTable({
        "processing": true,
        "searching":false,
        "serverSide": true,
        "ajax": {
        	"url":baseURL + "admin/getarchiveApps",
        	"type": "POST",
            "data": function ( data ) {
            }
        },
         "aoColumnDefs": [
          {'bSortable':false,'aTargets': [0]},{'bSortable':false,'aTargets': [1]},{'bSortable':false,'aTargets': [2]},{'bSortable':false,'aTargets': [3]},{'bSortable':false,'aTargets': [4]},{'bSortable':false,'aTargets': [5]},{'bSortable':false,'aTargets': [6]}
       ],
         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/img/loading.gif'></div>"}
    } );
	/*archiveChannelsTable = $('.archiveChannelsTable').DataTable( {
		 	 "columns":[
	            {
	            	"data": "checkbox",
	                "sortable": false
	            },
	            {
	            	"data": "counter",
	                "sortable": true
	            },
	            {
	            	"data": "channel_name",
	                "sortable": false
	            },

	            {
	            	"data": "process_name",
	                "sortable": false
	            },
	            {
	            	"data": "uid",
	                "sortable": false
	            },
	            {
	            	"data": "restore",
	                "sortable": false
	            },
	            {
	            	"data": "delete",
	                "sortable": false
	            }
	        ],
	        "autoWidth" : false,

	        "order": [[1, "desc" ]],
	        "processing": true,
	        "serverSide": true,
	        "ajax": baseURL + "admin/getarchiveChannels","type": "POST",
	         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/img/loading.gif'></div>"}
	    } );
		archiveChannelsTable.columns.adjust().draw();*/

	/* Archive Channels List */
	 reprottable = $('.archiveChannelsTable').DataTable({
        "processing": true,
        "searching":false,
        "serverSide": true,
        "ajax": {
        	"url":baseURL + "admin/getarchiveChannels",
        	"type": "POST",
            "data": function ( data ) {
            }
        },
         "aoColumnDefs": [
          {'bSortable':false,'aTargets': [0]},{'bSortable':false,'aTargets': [1]},{'bSortable':false,'aTargets': [2]},{'bSortable':false,'aTargets': [3]},{'bSortable':false,'aTargets': [4]},{'bSortable':false,'aTargets': [5]},{'bSortable':false,'aTargets': [6]}
       ],
         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/img/loading.gif'></div>"}
    } );


  logTable = $('.logTables').DataTable( {
	 	 "columns":[
            {
            	"data": "checkbox",
                "sortable": false
            },
            {
            	"data": "counter",
                "sortable": true
            },
            {
            	"data": "log_type",
                "sortable": false
            },

            {
            	"data": "created",
                "sortable": false
            },
            {
            	"data": "message",
                "sortable": false,
                width: '220px'
            },
            {
            	"data": "uid",
                "sortable": false
            },
            {
            	"data": "status",
                "sortable": false
            }
        ],
        "autoWidth" : false,

        "order": [[1, "desc" ]],
        "processing": true,
        "serverSide": true,
        "ajax": baseURL + "admin/getlogs",
         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/img/loading.gif'></div>"}
    } );
	logTable.columns.adjust().draw();
	// For right side bar
	$('.lirightside').each(function(){
		var wid = $(this).attr("id");
		var widp=wid.split('_');
		var locl = JSON.parse(localStorage.getItem("rightside"));
		if(locl !== undefined && locl != null)
		{
			if(locl.indexOf(wid) != -1)
			{
				$(this).children('input[type="checkbox"]').prop("checked",false);
				$('#wowza_accordion_' + widp[1]).fadeOut("slow");
			}
			else
			{
				$(this).children('input[type="checkbox"]').prop("checked",true);
				$('#wowza_accordion_' + widp[1]).fadeIn("slow");
			}
		}
	});

	$('.lirightside').on('click',function(){
		var wid = $(this).attr("id");
		var widp=wid.split('_');
		var loclr = JSON.parse(localStorage.getItem("rightside"));
		if(true == $(this).children('input[type="checkbox"]').is(":checked"))
		{
			$('#wowza_accordion_' + widp[1]).fadeIn("slow");
			if(loclr != undefined && loclr != null && loclr.length > 0)
			{
				loclr.pop("liwowza_" + widp[1]);
				localStorage.setItem("rightside", JSON.stringify(loclr));
			}
			else
			{
				rightSideBar.pop("liwowza_" + widp[1]);
				localStorage.setItem("rightside", JSON.stringify(rightSideBar));
			}
		}
		else if(false == $(this).children('input[type="checkbox"]').is(":checked"))
		{
			$('#wowza_accordion_' + widp[1]).fadeOut("slow");
			if(loclr != undefined && loclr != null && loclr.length > 0)
			{
				loclr.push("liwowza_" + widp[1]);
				localStorage.setItem("rightside", JSON.stringify(loclr));
			}
			else
			{
				rightSideBar.push("liwowza_" + widp[1]);
				localStorage.setItem("rightside", JSON.stringify(rightSideBar));
			}
		}
	});

	$('.tar-uname').hide();
	$('.tar-pass').hide();
	$('#mySidenav').mouseleave(function(event){
	  $('#mySidenav').css({"right":"-200px"});
	});

	$('.refreshCaptcha').on('click', function(){
        $.get('<?php echo base_url();?>home/refresh', function(data){
            $('#captImg').html(data);
        });
    });


	$("#groupfile").change(function(){
    	readURL(this);
	});

	$('#divlock').css('height',$(window).height());
	$('#encoder_inputs').multiselect();
	$('#encoder_output').multiselect();
	$('.datepicker2').datepicker({
	    format: 'dd/mm/yyyy'
	});

	 $('[data-toggle="tooltip"]').tooltip();
	 /* Archive Select/Un-Select Target */
	var archiveTarLength = $('.archiveTargetTable tbody tr td .selectArchTar').length;
	    var archiveCheckedTarLength = 0;
	 	$(document).on('click','.selectArchTar',function(){

	 		if($(this).is(":checked")== false)
			{
				if($('#selectallArchtargets').is(":checked") == true)
				{
					$('#selectallArchtargets').prop('checked', false);
				}
				archiveCheckedTarLength = 0;
				archiveTarLength =0;
				$(this).parent().parent().parent().parent().find('.selectArchTar').each(function () {
				archiveTarLength++;
	               if($(this).is(":checked")== true)
	               {
				   	   archiveCheckedTarLength++;
				   }
	            });

	            if(archiveCheckedTarLength == archiveTarLength)
	            {
					$('#selectallArchtargets').prop('checked', true);
				}
			}
			else if($(this).is(":checked")== true)
			{
				archiveCheckedTarLength = 0;
				archiveTarLength =0;
				$(this).parent().parent().parent().parent().find('.selectArchTar').each(function () {
				archiveTarLength++;
	               if($(this).is(":checked")== true)
	               {
				   	  archiveCheckedTarLength++;
				   }
	            });

	            if(archiveCheckedTarLength == archiveTarLength)
	            {
					$('#selectallArchtargets').prop('checked', true);
				}
			}
	 	});
	  $('#selectallArchtargets').click(function (event) {//alert(1);
        if (this.checked) {
            $('.selectArchTar').each(function () { //loop through each checkbox
                $(this).prop('checked', true); //check
            });
        } else {
            $('.selectArchTar').each(function () { //loop through each checkbox
                $(this).prop('checked', false); //uncheck
            });
        }
    });
	/* Archive Select/Un-Select Apps */
	var archiveAppsLength = $('.archiveAppsTable tbody tr td .selectarchApps').length;
	    var archiveCheckedAppsLength = 0;
	 	$(document).on('click','.selectarchApps',function(){

	 		if($(this).is(":checked")== false)
			{
				if($('#selectallarchiveApps').is(":checked") == true)
				{
					$('#selectallarchiveApps').prop('checked', false);
				}
				archiveCheckedAppsLength = 0;
				archiveAppsLength =0;
				$(this).parent().parent().parent().parent().find('.selectarchApps').each(function () {
				archiveAppsLength++;
	               if($(this).is(":checked")== true)
	               {
				   	   archiveCheckedAppsLength++;
				   }
	            });

	            if(archiveCheckedAppsLength == archiveAppsLength)
	            {
					$('#selectallarchiveApps').prop('checked', true);
				}
			}
			else if($(this).is(":checked")== true)
			{
				archiveCheckedAppsLength = 0;
				archiveAppsLength =0;
				$(this).parent().parent().parent().parent().find('.selectarchApps').each(function () {
				archiveAppsLength++;
	               if($(this).is(":checked")== true)
	               {
				   	  archiveCheckedAppsLength++;
				   }
	            });

	            if(archiveCheckedAppsLength == archiveAppsLength)
	            {
					$('#selectallarchiveApps').prop('checked', true);
				}
			}
	 	});
	  $('#selectallarchiveApps').click(function (event) {//alert(1);
        if (this.checked) {
            $('.selectarchApps').each(function () { //loop through each checkbox
                $(this).prop('checked', true); //check
            });
        } else {
            $('.selectarchApps').each(function () { //loop through each checkbox
                $(this).prop('checked', false); //uncheck
            });
        }
    });
	/* Archive Select/Un-Select Channels */
		var archiveChannelLength = $('.archiveChannelsTable tbody tr td .selectarchive').length;
	    var archiveCheckedChannelLength = 0;
	 	$(document).on('click','.selectarchive',function(){

	 		if($(this).is(":checked")== false)
			{
				if($('#selectallarchivechannels').is(":checked") == true)
				{
					$('#selectallarchivechannels').prop('checked', false);
				}
				archiveCheckedChannelLength = 0;
				archiveChannelLength =0;
				$(this).parent().parent().parent().parent().find('.selectarchive').each(function () {
				archiveChannelLength++;
	               if($(this).is(":checked")== true)
	               {
				   	   archiveCheckedChannelLength++;
				   }
	            });

	            if(archiveCheckedChannelLength == archiveChannelLength)
	            {
					$('#selectallarchivechannels').prop('checked', true);
				}
			}
			else if($(this).is(":checked")== true)
			{
				archiveCheckedChannelLength = 0;
				archiveChannelLength =0;
				$(this).parent().parent().parent().parent().find('.selectarchive').each(function () {
				archiveChannelLength++;
	               if($(this).is(":checked")== true)
	               {
				   	  archiveCheckedChannelLength++;
				   }
	            });

	            if(archiveCheckedChannelLength == archiveChannelLength)
	            {
					$('#selectallarchivechannels').prop('checked', true);
				}
			}
	 	});
	  $('#selectallarchivechannels').click(function (event) {//alert(1);
        if (this.checked) {
            $('.selectarchive').each(function () { //loop through each checkbox
                $(this).prop('checked', true); //check
            });
        } else {
            $('.selectarchive').each(function () { //loop through each checkbox
                $(this).prop('checked', false); //uncheck
            });
        }
    });

	 /* Logs Actions Start */
		var logLength = $('.logTables tbody tr td .selectlogs').length;
	    var logCheckedLength = 0;
	 	$(document).on('click','.selectlogs',function(){

	 		if($(this).is(":checked")== false)
			{
				if($('#log_all').is(":checked") == true)
				{
					$('#log_all').prop('checked', false);
				}
				logCheckedLength = 0;
				logLength =0;
				$(this).parent().parent().parent().parent().find('.selectlogs').each(function () {
				logLength++;
	               if($(this).is(":checked")== true)
	               {
				   	   logCheckedLength++;
				   }
	            });

	            if(logCheckedLength == logLength)
	            {
					$('#log_all').prop('checked', true);
				}
			}
			else if($(this).is(":checked")== true)
			{
				logCheckedLength = 0;
				logLength =0;
				$(this).parent().parent().parent().parent().find('.selectlogs').each(function () {
				logLength++;
	               if($(this).is(":checked")== true)
	               {
				   	  logCheckedLength++;
				   }
	            });

	            if(logCheckedLength == logLength)
	            {
					$('#log_all').prop('checked', true);
				}
			}
	 	});
	  $('#log_all').click(function (event) {//alert(1);
        if (this.checked) {
            $('.selectlogs').each(function () { //loop through each checkbox
                $(this).prop('checked', true); //check
            });
        } else {
            $('.selectlogs').each(function () { //loop through each checkbox
                $(this).prop('checked', false); //uncheck
            });
        }
    });
	 /* Logs Actions End */
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

    /* Archive Restore/Delete Section */

    $('.targetTable tr td .targenbdib').click(function(){
    	var thisObj = $(this);
		var targetId = $(this).attr("id");
		var ids = targetId.split('_');
		var className = $(this).find('i').attr("class");
		var cname = className.split(' ');
		var action ="";
		var permis = JSON.parse(userPermissions);
		if(cname[1] == "fa-play")
		{
			action = "Start";
			if(permis.start_target == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
		}
		else if(cname[1] == "fa-pause")
		{
			action = "Stop";
			if(permis.start_target == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
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
				closeOnConfirm: true
			},
			function(){
				if(action == "Stop" && appTargets[ids[1]] == "google")
				{
					location.href = baseURL + "admin/googleaccount/transiton/" + ids[1];
				}
				else
				{
					$.ajax({
				        url: baseURL + "admin/targetStartStop",
				        data:{'targetId':targetId,'action':action},
				        type:'post',
				        dataType:'json',
				        success:function(jsonResponse){
				            if(jsonResponse.status == true)
				            {
									switch(jsonResponse.code)
					                {
					                    case 200:
					                    if(jsonResponse.response == "Active" || jsonResponse.response == "Starting" || jsonResponse.response == "Waiting...")
					                    {
											if(cname[1] == "fa-play")
											{
												$(thisObj).find('i').attr("class","fa fa-pause");
											}
											else if(cname[1] == "fa-pause")
											{
												$(thisObj).find('i').attr("class","fa fa-play");
											}
										}


					                    break;
					                    case 400:
					                    toastr['error']('Error occurred while '+ action +'ing ');
					                    break;
					                    case 402:
					                    case 404:
					                    toastr['error']('Error occurred while '+ action +'ing ');
					                    break;
					                    case 415:
										toastr['error']('Error occurred while '+ action +'ing ');
					                    break;
					                    case 500:
										toastr['error']('Error occurred while '+ action +'ing ');
					                    break;
									}
									switch(jsonResponse.response)
					                {
					                    case "Disabled":
										$(thisObj).parent().parent('tr').find('#status').removeAttr("class");
										$(thisObj).parent().parent('tr').find('#status').addClass("label label-gray").text("Disabled");
										toastr['success']('Stream Disabled!');
					                    break;
					                     case "Active":
										$(thisObj).parent().parent('tr').find('#status').removeAttr("class");
										$(thisObj).parent().parent('tr').find('#status').addClass("label label-success").text("Active");
										toastr['success']('Active Stream!');
					                    break;
					                    case "Waiting...":
					                    $(thisObj).parent().parent('tr').find('#status').removeAttr("class");
										$(thisObj).parent().parent('tr').find('#status').addClass("label label-auth").text("Waiting");
										toastr['success']('Waiting Stream!');
					                    break;
					                    case "Starting":
					                    $(thisObj).parent().parent('tr').find('#status').removeAttr("class");
										$(thisObj).parent().parent('tr').find('#status').addClass("label label-auth").text("Starting");
										toastr['success']('Starting Stream!');
					                    break;
					                    case "Error":
					                    $(thisObj).parent().parent('tr').find('#status').removeAttr("class");
										$(thisObj).parent().parent('tr').find('#status').addClass("label label-danger").text("Error");
					                    break;
									}
									setTimeout(appTargetRefresh, 5000);
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
									toastr['success']('Start Successfully!');
				                    break;
				                    case 400:
				                    toastr['error']('Error occurred while '+ action +'ing ');
				                    break;
				                    case 402:
				                    case 404:
				                    toastr['error']('Error occurred while '+ action +'ing ');
				                    break;
				                    case 415:
									toastr['error']('Error occurred while '+ action +'ing ');
				                    break;
				                    case 500:
									toastr['error']('Error occurred while '+ action +'ing ');
				                    break;
								}
							}
						},
				        error:function(){
				        	toastr['error']('Error occurred while '+ action +'ing ');
						}
					});
				}
			});
		}
		else
		{
			toastr['info']("You can't " + action + " target with " + $(this).parent().parent().find('#status').text() + " status!");
		}
    });
    $('.targetTable tr td .targenbdib').each(function(){
		var obj = $(this);
		var targetId = $(this).attr('id');
		$.ajax({
	        url: baseURL + "admin/targetStatus",
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
	                    case "Starting":
	                    $(obj).parent().parent('tr').find('#status').removeAttr("class");
						$(obj).parent().parent('tr').find('#status').addClass("label label-auth").text("Starting");
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
function submitAllLogs()
{
		var Ids = [];
	if($("#actionLogs option:selected").val() == "" || $('.logTables tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }
    $(".logTables tbody tr td input:checkbox[class=selectlogs]:checked").each(function () {
		var id = $(this).parent().parent().parent('tr').attr('id');
		var idsss = id.split('_');
		Ids.push(idsss[1]);
		var action = $("#actionLogs").val();
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
				closeOnConfirm: true
			},
			function(){
				$.ajax({
			        url: baseURL + 'admin/clearlogs',
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){

			        	switch(action)
			        	{
							case "Clear":
							toastr['success'](action + " Successfully!");
							for(i=0; i<Ids.length; i++)
				        	{
								$('.logTables #row_'+Ids[i]).remove();
							}
							break;
						}
						logTable.ajax.reload(null,false);
					},
			        error:function(){
			        	toastr['error']("Error Occured While performing actions");
					}
				});
			});
		}
		else
		{
			toastr['info']("At least select one action");
			return;
		}
	});
}
/* Target Actions Start */
$(document).on('click','.archTargetRestore',function(){
	var appid = $(this).attr('id');
	var objj = $(this);
	var action = "";

	if($(this).find('i').length > 1)
	{
		toastr['info']("You cant restore target of archived app.");
		return;
	}
	else
	{
		swal({
			title: "Are you sure?",
			text: "You want to restore this!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, Restore it!",
			closeOnConfirm: true
		},
		function(){
			$.ajax({
		        url: baseURL + "admin/restoreArchiveTarget",
		        data:{'appid':appid,'action':'delete'},
		        type:'post',
		        dataType:'json',
		        success:function(jsonResponse){
		            if(jsonResponse.status == true)
		            {
						toastr['success']('Restore Successfully!');
						$(objj).parent().parent().remove();
					}
		            if(jsonResponse.status == false)
		            {
		            	toastr['error'](jsonResponse.response);
					}
					$('.archiveTargetTable').DataTable().ajax.reload();
				},
		        error:function(){
		        	toastr['error'](jsonResponse.response);
				}
			});
		});
	}
});
$(document).on('click','.archAppRestore',function(){
	var appid = $(this).attr('id');
	var objj = $(this);
	var action = "";
	swal({
			title: "Are you sure?",
			text: "You want to restore this!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, Restore it!",
			closeOnConfirm: true
		},
	function(){
			$.ajax({
		        url: baseURL + "admin/restoreArchiveApp",
		        data:{'appid':appid,'action':'restore'},
		        type:'post',
		        dataType:'json',
		        success:function(jsonResponse){
		            if(jsonResponse.status == true)
		            {
						toastr['success']('Restore Successfully!');
						$(objj).parent().parent().remove();
						$('.archiveAppsTable').DataTable().ajax.reload();
					}
		            if(jsonResponse.status == false)
		            {
		            	toastr['error'](jsonResponse.response);
					}
				},
		        error:function(){
		        	toastr['error'](jsonResponse.response);
				}
			});
		});
});
$(document).on('click','.archChannelRestore',function(){
	var appid = $(this).attr('id');
	var objj = $(this);
	var action = "";
	swal({
			title: "Are you sure?",
			text: "You want to restore this!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, Restore it!",
			closeOnConfirm: true
		},
	function(){
			$.ajax({
		        url: baseURL + "admin/restoreArchiveChannel",
		        data:{'appid':appid,'action':'restore'},
		        type:'post',
		        dataType:'json',
		        success:function(jsonResponse){
		            if(jsonResponse.status == true)
		            {
						toastr['success']('Restore Successfully!');
						$(objj).parent().parent().remove();
					}
		            if(jsonResponse.status == false)
		            {
		            	toastr['error'](jsonResponse.response);
					}
					$('.archiveChannelsTable').DataTable().ajax.reload();
				},
		        error:function(){
		        	toastr['error'](jsonResponse.response);
				}
			});
		});

});
/* Target Archive Delete Action */
$(document).on('click','.targetArchiveDel',function(){
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
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/deleteTarget",
	        data:{'appid':appid,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Deleted Successfully!');
					$(objj).parent().parent().remove();
				}
	            if(jsonResponse.status == false)
	            {
	            	toastr['error'](jsonResponse.response);
				}
			},
	        error:function(){
	        	toastr['error'](jsonResponse.response);
			}
		});
	});
});
$(document).on('click','.appArchiveDel',function(){
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
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/deleteApplication",
	        data:{'appid':appid,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Deleted Successfully!');
					$(objj).parent().parent().remove();
				}
	            if(jsonResponse.status == false)
	            {
	            	toastr['error'](jsonResponse.response);
				}
			},
	        error:function(){
	        	toastr['error'](jsonResponse.response);
			}
		});
	});
});
$(document).on('click','.channelArchiveDel',function(){
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
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/channelDelete",
	        data:{'channelId':appid,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Deleted Successfully!');
					$(objj).parent().parent().remove();
				}
	            if(jsonResponse.status == false)
	            {
	            	toastr['error'](jsonResponse.response);
				}
			},
	        error:function(){
	        	toastr['error'](jsonResponse.response);
			}
		});
	});
});
/* Target Archive Delete Action */
$(document).on('click','.targdel',function(){
	var appid = $(this).attr('id');
	var objj = $(this);
	var action = "";
	var permis = JSON.parse(userPermissions);

	if(permis.delete_target == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
	}
	swal({
		title: "Are you sure?",
		text: "You want to delete this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, delete it!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/deleteTarget",
	        data:{'appid':appid,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Deleted Successfully!');
					$(objj).parent().parent().remove();
				}
	            if(jsonResponse.status == false)
	            {
	            	toastr['error'](jsonResponse.response);
				}
			},
	        error:function(){
	        	toastr['error'](jsonResponse.response);
			}
		});
	});
});
$(document).on('click','.targcopy',function(){
	var appid = $(this).attr('id');
	var objj = $(this);
	var action = "";
	var permis = JSON.parse(userPermissions);
	if(permis.copy_target == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
	}
	swal({
		title: "Are you sure?",
		text: "You want to copy this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Copy it!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/copyTarget",
	        data:{'appid':appid,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Deleted Successfully!');
				}
	            if(jsonResponse.status == false)
	            {
	            	toastr['error'](jsonResponse.response);
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
        url: baseURL + "admin/lockscreen",
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
        url: baseURL + "admin/unlock",
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
				toastr['error'](jsonResponse.response);
			}
		},
        error:function(){
        	toastr['error']('Error occured while performing actions');
		}
	});
});




//group user application delete

$(document).on('click','.applicationdelete1',function(){


	var appid = $(this).attr('id');


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
					closeOnConfirm: true
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
								toastr['success']('Deleted Successfully!');
							}
							if(jsonResponse.status == false)
							{
								toastr['error'](jsonResponse.response);
							}
						},
						error:function(){
							toastr['error'](jsonResponse.response);
						}
					});
				});

			}
			if(jsonResponse.status == false)
			{
				toastr['info'](jsonResponse.response);
			}
		},
		error:function(){
			toastr['error'](jsonResponse.response);
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
		closeOnConfirm: true
	},
	function(){
		$.ajax({
	        url: baseURL + "admin/deleteApplication",
	        data:{'appid':appid,'action':'delete'},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {
					toastr['success']('Deleted Successfully!');
					location.reload();
				}
	            if(jsonResponse.status == false)
	            {
	            	toastr['error'](jsonResponse.response);
				}
			},
	        error:function(){
	        	toastr['error']('Error occured while performing actions');
			}
		});
	});
});


});
function enableAppEdit()
{
$('#block').removeAttr("readonly").css("color","#fff");
}
function submitAllGroups(url){


	var Ids = [];
	if($("#actionval option:selected").val() == "" || $('.groupTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }

	$("input:checkbox[class=groupaction]:checked").each(function () {
		var obj = $(this);
		var id = $(this).val();
		Ids.push(id);
		var action = $("#actionval").val();
		if(action != "")
		{
			var permis = JSON.parse(userPermissions);
			switch(action)
			{
				case "Block":
				if(permis.block_group == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "UnBlock":
				if(permis.unblock_group == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "Delete":
				if(permis.delete_group == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
			}


			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: true
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
									toastr['success']('Deleted Successfully!');
									$('.groupTable #row_'+Ids[i]).remove();
									break;
								}
							}
						}
						switch(action)
		            	{
							case "Block":
							case "UnBlock":
							toastr['success'](action + 'Successfully!');
							break;
						}
					},
			        error:function(){
			        	toastr['error']( jsonResponse.response);
					}
				});
			});
		}
		else
		{
			toastr['info']('At Least select one action');
			return;
		}
	});

}
function submitAllTargets(tarurl)
{
	var Ids = [];
	if($("#actiontargetval1 option:selected").val() == "" || $('.targetTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }

	$("input:checkbox[class=targetactions]:checked").each(function () {
		var stringId = $(this).attr("id");
		var idArray = stringId.split('_');
		var id = idArray[1];
		Ids.push(id);
		var action = $("#actiontargetval1").val();
		if(action != "")
		{
			var permis = JSON.parse(userPermissions);
			switch(action)
			{
				case "Start":
				if(permis.start_target == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "Stop":
				if(permis.stop_target == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "Delete":
				if(permis.delete_target == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}

			}

			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: true
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
							toastr['success'](action + " Successfully!");
							if(action == "Delete")
							{
								for(var i=0; i<Ids.length; i++)
			            		{
									$(".targetTable #row_"+ Ids[i]).remove();
								}
							}
							if(action == "Archive")
							{
								for(var i=0; i<Ids.length; i++)
			            		{
									$(".targetTable #row_"+ Ids[i]).remove();
								}
							}
						}
			            if(jsonResponse.status == false)
			            {
			            	toastr['error'](jsonResponse.response);
						}
					},
			        error:function(){
					}
				});
			});
		}
		else
		{
			toastr['info']('At least select one action');
			return;
		}
	});
}

function submitAllArchiveTargets(tarurl)
{
	var Ids = [];
	if($("#actionArchTarget option:selected").val() == "" || $('.archiveTargetTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }

	$("input:checkbox[class=selectArchTar]:checked").each(function () {
		var stringId = $(this).attr("id");
		var idArray = stringId.split('_');
		var id = idArray[1];
		Ids.push(id);
		var action = $("#actionArchTarget").val();
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
				closeOnConfirm: true
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
							toastr['success'](action + " Successfully!");
							if(action == "Delete")
							{
								for(var i=0; i<Ids.length; i++)
			            		{
									$(".archiveTargetTable #row_"+ Ids[i]).remove();
								}
							}
							if(action == "Restore")
							{
								for(var i=0; i<Ids.length; i++)
			            		{
									$(".archiveTargetTable #row_"+ Ids[i]).remove();
								}
							}
							$('.archiveTargetTable').DataTable().ajax.reload();
						}
			            if(jsonResponse.status == false)
			            {
			            	toastr['error'](jsonResponse.response);
						}
					},
			        error:function(){
					}
				});
			});
		}
		else
		{
			toastr['info']('At least select one action');
			return;
		}
	});
}

function submitAllUser(url){
	var Ids = [];
	if($("#actionval1 option:selected").val() == "" || $('.userTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }
	$("input:checkbox[class=useraction]:checked").each(function () {
		var id = $(this).val();
		Ids.push(id);
		var action = $("#actionval1").val();
		if(action != "" && action != "0")
		{
			var permis = JSON.parse(userPermissions);
			switch(action)
			{
				case "Block":
				if(permis.block_user == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "UnBlock":
				if(permis.unblock_user == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
				case "Delete":
				if(permis.delete_user == 0)
				{
					toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
					return;
				}
				break;
			}

			var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, " + action + " it!",
				closeOnConfirm: true
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
									toastr['success']('Deleted Successfully!');
									$('.userTable #row_'+Ids[i]).remove();
									break;
								}
							}
						}
						switch(action)
		            	{
							case "Block":
							case "UnBlock":
							toastr['success'](action + " Successfully!");
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
			toastr['info']('At least select one action');
			return;
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
				closeOnConfirm: true
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
							toastr['success']('Deleted Successfully!');
							location.reload();
						}
						if(jsonResponse.status == false)
						{
							toastr['error'](jsonResponse.response);
						}
					},
					error:function(){
						toastr['error']('Error occured while performing actions');
					}
				});
			});

	});
}

$(document).on('click','.savegatewaychannel',function(){

	var isValid = true;
	if($('#channel_name').val() == "")
	{
		$(this).css("border","1px solid red");
		isValid = false;
	}
	if($('#channel_ndi_source').val() == "")
	{
		$(this).css("border","1px solid red");
		isValid = false;
	}
	if($('#channelOutpue').val() == "")
	{
		$(this).css("border","1px solid red");
		isValid = false;
	}

	var len = $('#banks-events div#'+ globalBankId + ' .box-events-buttons li').length;
	var banksize = $('#banks-events div#'+ globalBankId + ' .box-events-buttons li:eq('+(len-1)+')');
	$.ajax({
		url: baseURL + "admin/createGatewayChannel",
		data:{'bankId':globalBankId,'channelName':$('#channel_name').val(),'channel_ndi_source':$('#channel_ndi_source').val(),'channelOutpue':$('#newchannelOutpue').val(),'ndi_destination':$('#ndi_destination').val(),'channel_apps':$('#channel_apps').val(),'output_rtmp_url':$('#output_rtmp_url').val(),'output_rtmp_key':$('#output_rtmp_key').val(),'auth_uname':$('#auth_uname').val(),'auth_pass':$('#auth_pass').val(),'encoding_profile':$('#encoding_profile').val(),'srt_ip':$('#new_srt_ip').val(),'srt_port':$('#new_srt_port').val(),'srt_mode':$('#new_srt_mode').val(),'audio_channel':$('#audio_channel').val()},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				channelss = JSON.parse(jsonResponse.channelss);
				var Channnel = channelss[jsonResponse.message];
				var HtmlB = "";
				HtmlB += "<li id='"+jsonResponse.message+"' class='label label-gray channelStartStopGateway'><a id='"+Channnel['channel_type']+"_"+globalBankId+"' class='settings' href='javascript:void(0);'><i class='fa fa-gear' style='color: #3737376b;position:  absolute;left: 0;padding: 2px;top:  0;font-size:  16px;'></i></a><a class='stopgatewaych' id='stop_"+globalBankId+"' href='javascript:void(0);' ><i class='fa fa-times' style='color: #3737376b;position:  absolute;right:  0;padding: 2px;top:  0;font-size:  16px;'></i></a><span class='events-attachment-button inactive'>"+Channnel['channel_type']+"</span><p class='counter inactive' style='color: #f2f906;font-size: 13px;font-family: monospace;text-align:  center;' title=''>00:00:00:00</p></li>";

				$(HtmlB).insertBefore($('#banks-events div#'+ globalBankId + ' .box-events-buttons li:eq('+(len-1)+')'));
				$('#channel_name').val("");
				$('#channel_ndi_source').val("");
				$('#channelType').val("");
				$('#channelOutpue').val("");
				$('#ndi_destination').val("");
				$('#channel_apps').val("");
				$('#output_rtmp_url').val("");
				$('#output_rtmp_key').val("");
				$('#new_srt_ip').val("");
				$('#new_srt_port').val("");
				$('#new_srt_mode').val("");
				$('#auth_uname').val("");
				$('#auth_pass').val("");
				$('#encoding_profile').val("");
				$('#audio_channel').val("");
				toastr['success']('Creatd Successfully!');
				banks = JSON.parse(jsonResponse.banks);

				$('#modelCreateGatewayChannels').modal('hide');
			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.message);
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');
		}

	});

});

$(document).on('click','.addnewchannel',function(){
	var BankID = $(this).attr('id');
	var ids = BankID.split('_');
	globalBankId = ids[1];
	if($('#banks-events div#'+ globalBankId).find('a').find('span').text().trim() == "" || $('#banks-events div#'+ globalBankId).find('a').find('span').text().trim() == "EmptyBank")
	{
		toastr['error']('You cant add channel in empty bank');
		return false;
	}
	$('#modelCreateGatewayChannels').modal('show');
	$('#channel_name').val($('#banks-events div#'+ globalBankId).find('a').find('span').text().trim());
	$('#channel_ndi_source').val($('#banks-events div#'+ globalBankId).find('a').find('span').text().trim());
});

$(document).on('click','.bankpopup',function(e){
		e.stopPropagation();

		var idG = $(this).parent().attr('id');
		var b = banks[idG];
		var isEmpty = $(this).find('span').text();

	    if(isEmpty == "" || isEmpty == "EmptyBank" || isEmpty == "Empty Bank")
	    {
	    	toastr['error']('You cant perform this action on empty Bank');
			return;
		}
		if(b['isLocked'] == 1)
		{
			toastr['error']('You cant perform this action on locked Bank');
			return;
		}
		$('#bankPopup').modal('show');
		$('#bank_popup_name').val(b['name']);
		$('#bank_popup_id').val(idG);
});

$(document).on('click','.saveBankDetails',function(){
	if($('#bank_popup_name').val() == "")
	{
		$('#bank_popup_name').css('border','1px solid red');
		return;
	}
	$.ajax({
		url: baseURL + "admin/updateBankNameOnly",
		data:{'id':$('#bank_popup_id').val(),'bankname':$('#bank_popup_name').val()},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				toastr['success']("Update Successfully!");
				$("#"+$('#bank_popup_id').val()).find('a').find('span').text($('#bank_popup_name').val());
				banks = JSON.parse(jsonResponse.banks);
				channelss = JSON.parse(jsonResponse.channelss);
			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.message);
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');
		}
	});
	$('#bankPopup').modal('hide');
});
$(document).on('click','.settings',function(e){
	e.stopPropagation();
	var channalId = $(this).parent().attr('id');
	var bankIds = $(this).attr('id').split('_');
	var bankId = bankIds[1];
	updateChannelId = channalId;
	var channelData = channelss[channalId];
	if(channelData['channel_ndi_source'] == "")
	{
		toastr['error']('You cant perform this action on empty bank');
		return;
	}
	if(channelData['isLocked'] == 1)
	{
		toastr['error']('You cant perform this action on locked Bank');
		return;
	}

	if(bankIds[0] != "")
	{

		switch(bankIds[0])
		{
			case "NDI":
			$('#ndiChannelPopup').modal('show');
			$('#ndi_channel_name').val(channelData['channel_name']);
			$('#source').val(channelData['channel_ndi_source']);
			$('#destination').val(channelData['ndi_destination']);
			break;
			case "RTMP":
			console.log(channelData);
			$('#rtmpChannelPopup').modal('show');
			$('#rtmp_channel_name').val(channelData['channel_name']);
			$('#rtmp_ndi_source').val(channelData['channel_ndi_source']);

			if(channelData['channel_apps'] > 0)
			{
				$('#rtmp_apps').val(channelData['channel_apps']);
				$('#rtmp_apps').selectpicker('refresh');
				$('#rtmp_url').val(channelData['output_rtmp_url']);
				$('.gateway-rtmp-url').show();
				$('#rtmp_key').val(channelData['output_rtmp_key']);
				$('.gateway-rtmp-key').show();
			}
			else
			{
				$('#rtmp_apps').val("");
				$('#rtmp_apps').selectpicker('refresh');
				$('#rtmp_url').val("");
				$('#rtmp_key').val("");
				$('.gateway-rtmp-url').hide();
				$('.gateway-rtmp-key').hide();
			}
			if(channelData['encoding_profile'] > 0)
			{
				$('#rtmp_encoding_profile').val(channelData['encoding_profile']);
				$('#rtmp_encoding_profile').selectpicker('refresh');
			}
			else
			{
				$('#rtmp_encoding_profile').val("");
				$('#rtmp_encoding_profile').selectpicker('refresh');
			}

			break;
			case "SRT":
			$('#srtChannelPopup').modal('show');
			$('#srt_channel_name').val(channelData['channel_name']);
			$('#srt_source').val(channelData['channel_ndi_source']);
			$('#srt_ip').val(channelData['srt_ip']);
			$('#srt_port').val(channelData['srt_port']);
			$('#srt_mode').val(channelData['srt_mode']);
			if(channelData['encoding_profile'] > 0)
			{
				$('#srt_encoding_profile').val(channelData['encoding_profile']);
				$('#srt_encoding_profile').selectpicker('refresh');
			}
			else
			{
				$('#srt_encoding_profile').val(channelData['encoding_profile']);
				$('#srt_encoding_profile').selectpicker('refresh');
			}
			break;
			case "SDI":

			$('#sdiChannelPopup').modal('show');
			$('#sdi_channel_name').val(channelData['channel_name']);
			$('#sdi_source').val(channelData['channel_ndi_source']);
			$('#sdi_audio_channel').val(channelData['audio_channel']);
			$('#sdi_audio_channel').selectpicker('refresh');
			if(channelData['sdi_output'] != "")
			{
				$('#sdi_output').val(channelData['sdi_output']);
				$('#sdi_output').selectpicker('refresh');
			}
			else
			{
				$('#sdi_output').val("");
				$('#sdi_output').selectpicker('refresh');
			}
			break;
		}
	}
});


$(document).on('click','.saveSchedulePopupTarget',function(){
	if($('#sch_target_list').val() == "")
	{
		$('#sch_target_list').css('border','1px solid red');
		return;
	}
	if($('#schedule_popup_target_starttime').val() == "")
	{
		$('#schedule_popup_target_starttime').css('border','1px solid red');
		return;
	}
	if($('#schedule_popup_target_endtime').val() == "")
	{
		$('#schedule_popup_target_endtime').css('border','1px solid red');
		return;
	}
	$.ajax({
		url: baseURL + "api/saveTargetSchedule",
		data:{'id':$('#sch_target_list').val(),'stime':$('#schedule_popup_target_starttime').val(),'etime':$('#schedule_popup_target_endtime').val()},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				toastr['success']("Update Successfully!");
					var h = "";
				h += "<tr id='row_"+jsonResponse.response.id+"'>";
				h += "<td><div ><input name='schids[]' value='"+jsonResponse.response.id+"' id='schedule_"+jsonResponse.response.id+"' type='checkbox' class='scheduleactions'><label for='schedule_"+jsonResponse.response.id+"'></label></div></td>";
				h += "<td class='cnt'>0</td>";
				h += "<td class='title'><a class='schdule_title' id='lvtarget' name='"+jsonResponse.response.id+"' href='javascript:void(0);'>"+jsonResponse.response.title+"</a></td>";
				switch(jsonResponse.response.type)
				{
					case "google":
					h +="<td><div class='btn btn-google btn-sm'><span><i class='fa fa-youtube'></i> Youtube Live</span></div></td>";
					break;
					case "facebook":
					h +="<td><div class='btn btn-facebook btn-sm'><span><i class='fa fa-facebook'></i> Facebook Live</span></div></td>";
					break;
					case "twitch":
					h +="<td><div class='btn btn-twitch btn-sm'><span><i class='fa fa-twitch'></i> Twitch</span></div></td>";
					break;
					case "twitter":
					h +="<td><div class='btn btn-twitter btn-sm'><span><i class='fa fa-twitter'></i> Twitch</span></div></td>";
					break;
					default:
					h +="<td><div class='btn btn-github btn-sm btndis'><span><i class='fa fa-bolt'></i>" + jsonResponse.response.type + "</span></div></td>";
					break;
				}
				h +="<td>"+ jsonResponse.response.start_datetime +"</td>";
				h +="<td>"+ jsonResponse.response.end_datetime +"</td>";
				h +="<td><span id='status' class='label label-gray'>Disabled</span></td>";
				h +="<td><p class='counter' title=''></p></td>";
				h +="<td><a href='javascript:void(0);'><i class='fa fa-refresh' aria-hidden='true'></i></a></td>";
				h +="<td id='"+ jsonResponse.response.schedule_type +"_"+ jsonResponse.response.sid +"'><a class='schstartstop' href='javascript:void(0);' id='"+ jsonResponse.response.schedule_type +"_"+ jsonResponse.response.sid +"'><i class='fa fa-play' aria-hidden='true'></i></a></td>";
				h +="<td><a href='javascript:void(0);' class='schLockUnlock' id='"+ jsonResponse.response.schedule_type +"_"+ jsonResponse.response.id +"'><i class='fa fa-unlock' aria-hidden='true'></i></a></td>";
				h +="<td><a href='javascript:void(0);' class='scheduleDel' id='"+ jsonResponse.response.schedule_type +"_"+ jsonResponse.response.id +"'><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
				h += "</tr>";
				var event = {};
				event.id = jsonResponse.response.id;
		  		event.title = jsonResponse.response.title;
		  		var sdate = convertDateTime(jsonResponse.response.start_datetime);
		  		var edate = convertDateTime(jsonResponse.response.end_datetime);
		  		event.start = sdate;
		  		event.end = edate;
		  		event.backgroundColor = '#3C8DBC';
		  		event.borderColor = '#3C8DBC';
				calenderEvents.push(event);


				var schd = {};
				schd.id = jsonResponse.response.id;
				schd.title = jsonResponse.response.title;
				schd.schedule_type = jsonResponse.response.schedule_type;
				schd.type = jsonResponse.response.type;
				schd.sid = jsonResponse.response.sid;
				schd.start_datetime = jsonResponse.response.start_datetime;
				schd.end_datetime = jsonResponse.response.end_datetime;
				schd.isLocked = jsonResponse.response.isLocked;
				schedulesData[jsonResponse.response.id] = schd;

				var size = $('.scheduleTable > tbody > tr').length;
				if(size == 1 || size > 2)
				{
					$('.scheduleTable > tbody > tr:eq(0)').after(h);
					$('.scheduleTable > tbody > tr > td.cnt').each(function(){
						var t = $(this).text();
						$(this).text(parseInt(t)+1);
					});
				}
				else if(size == 2)
				{
					if($('.scheduleTable > tbody > tr:eq(1) td').length > 2)
					{
						$('.scheduleTable > tbody > tr:eq(0)').after(h);
						$('.scheduleTable > tbody > tr > td.cnt').each(function(){
							var t = $(this).text();
							$(this).text(parseInt(t)+1);
						});
					}
					else
					{
						$('.scheduleTable > tbody > tr:eq(1)').remove();
						$('.scheduleTable > tbody > tr:eq(0)').after(h);
						$('.scheduleTable > tbody > tr > td.cnt').each(function(){
							var t = $(this).text();
							$(this).text(parseInt(t)+1);
						});
					}
				}

				setTimeout(scheduleRefresh,5000);
				 $('#calendar').fullCalendar('removeEvents');
	             $('#calendar').fullCalendar('addEventSource', calenderEvents);
	             $('#calendar').fullCalendar('rerenderEvents' );

			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.message);
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');
		}
	});
	$('#scheduleTargetpopup').modal('hide');
});
$(document).on('click','.updateSchedulePopupTarget',function(){
	if($('#edit_sch_target_list').val() == "")
	{
		$('#edit_sch_target_list').css('border','1px solid red');
		return;
	}
	if($('#edit_schedule_popup_target_starttime').val() == "")
	{
		$('#edit_schedule_popup_target_starttime').css('border','1px solid red');
		return;
	}
	if($('#edit_schedule_popup_target_endtime').val() == "")
	{
		$('#edit_schedule_popup_target_endtime').css('border','1px solid red');
		return;
	}
	var sid = $('#edit_sch_target_list option').attr('id');
	$.ajax({
		url: baseURL + "api/updateScheduleTarget",
		data:{'id':$('#edit_sch_target_list').val(),'stime':$('#edit_schedule_popup_target_starttime').val(),'etime':$('#edit_schedule_popup_target_endtime').val(),'sid':sid},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				toastr['success']("Update Successfully!");
				$('.scheduleTable > tbody > #row_' + sid + ' td:eq(4)').html(jsonResponse.response.start_datetime);
				$('.scheduleTable > tbody > #row_' + sid + ' td:eq(5)').html(jsonResponse.response.end_datetime);
				var event = {};
				event.id = jsonResponse.response.id;
		  		event.title = jsonResponse.response.title;
		  		var sdate = convertDateTime(jsonResponse.response.start_datetime);
		  		var edate = convertDateTime(jsonResponse.response.end_datetime);
		  		event.start = sdate;
		  		event.end = edate;
		  		event.backgroundColor = '#3C8DBC';
		  		event.borderColor = '#3C8DBC';
		  		if(calenderEvents.length > 0)
		  		{
					$.each(calenderEvents,function( key, value){
						if(value.id == jsonResponse.response.id)
						{
							calenderEvents.splice(key,1);
						}
					});
				}
				calenderEvents.push(event);
		  		 $('#calendar').fullCalendar('removeEvents');
	             $('#calendar').fullCalendar('addEventSource', calenderEvents);
	             $('#calendar').fullCalendar('rerenderEvents' );
			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.message);
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');
		}
	});
	$('#edit_scheduleTargetpopup').modal('hide');
});
$(document).on('click','.saveScheduleChannel',function(){
	if($('#sch_channel_list').val() == "")
	{
		$('#sch_channel_list').css('border','1px solid red');
		return;
	}
	if($('#schedule_popup_channel_starttime').val() == "")
	{
		$('#schedule_popup_channel_starttime').css('border','1px solid red');
		return;
	}
	if($('#schedule_popup_channel_endtime').val() == "")
	{
		$('#schedule_popup_channel_endtime').css('border','1px solid red');
		return;
	}
	$.ajax({
		url: baseURL + "api/saveChannelSchedule",
		data:{'id':$('#sch_channel_list').val(),'stime':$('#schedule_popup_channel_starttime').val(),'etime':$('#schedule_popup_channel_endtime').val()},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				toastr['success']("Update Successfully!");
				var h = "";
				h += "<tr id='row_"+jsonResponse.response.id+"'>";
				h += "<td><div class='boxes'><input name='schids[]' value='"+jsonResponse.response.id+"' id='schedule_"+jsonResponse.response.id+"' type='checkbox' class='scheduleactions'><label for='schedule_"+jsonResponse.response.id+"'></label></div></td>";
				h += "<td class='cnt'>0</td>";
				h += "<td class='title'><a class='schdule_title' id='lvchannel' name='"+jsonResponse.response.id+"' href='javascript:void(0);'>"+jsonResponse.response.title+"</a></td>";
				h +="<td><div class='btn btn-github btn-sm btndis'><span><i class='fa fa-random'></i> "+ jsonResponse.response.type +"</span></div></td>";
				h +="<td>"+ jsonResponse.response.start_datetime +"</td>";
				h +="<td>"+ jsonResponse.response.end_datetime +"</td>";
				h +="<td><span id='status' class='label label-gray'>Disabled</span></td>";
				h +="<td><p class='counter' title=''></p></td>";
				h +="<td><a href='javascript:void(0);'><i class='fa fa-refresh' aria-hidden='true'></i></a></td>";
				h +="<td id='"+ jsonResponse.response.schedule_type +"_"+ jsonResponse.response.sid +"'><a class='schstartstop' href='javascript:void(0);' id='"+ jsonResponse.response.schedule_type +"_"+ jsonResponse.response.sid +"'><i class='fa fa-play' aria-hidden='true'></i></a></td>";
				h +="<td><a href='javascript:void(0);' class='schLockUnlock' id='"+ jsonResponse.response.schedule_type +"_"+ jsonResponse.response.id +"'><i class='fa fa-unlock' aria-hidden='true'></i></a></td>";
				h +="<td><a href='javascript:void(0);' class='scheduleDel' id='"+ jsonResponse.response.schedule_type +"_"+ jsonResponse.response.id +"'><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
				h += "</tr>";
				var event = {};
				event.id = jsonResponse.response.id;
		  		event.title = jsonResponse.response.title;
		  		var sdate = convertDateTime(jsonResponse.response.start_datetime);
		  		var edate = convertDateTime(jsonResponse.response.end_datetime);
		  		event.start = sdate;
		  		event.end = edate;
		  		event.backgroundColor = '#3C8DBC';
		  		event.borderColor = '#3C8DBC';
				calenderEvents.push(event);

				var schd = {};
				schd.id = jsonResponse.response.id;
				schd.title = jsonResponse.response.title;
				schd.schedule_type = jsonResponse.response.schedule_type;
				schd.type = jsonResponse.response.type;
				schd.sid = jsonResponse.response.sid;
				schd.start_datetime = jsonResponse.response.start_datetime;
				schd.end_datetime = jsonResponse.response.end_datetime;
				schd.isLocked = jsonResponse.response.isLocked;
				schedulesData[jsonResponse.response.id] = schd;

				var size = $('.scheduleTable > tbody > tr').length;
				if(size == 1 || size > 2)
				{
					$('.scheduleTable > tbody > tr:eq(0)').after(h);
					$('.scheduleTable > tbody > tr > td.cnt').each(function(){
						var t = $(this).text();
						$(this).text(parseInt(t)+1);
					});
				}
				else if(size == 2)
				{
					if($('.scheduleTable > tbody > tr:eq(1) td').length > 2)
					{
						$('.scheduleTable > tbody > tr:eq(0)').after(h);
						$('.scheduleTable > tbody > tr > td.cnt').each(function(){
							var t = $(this).text();
							$(this).text(parseInt(t)+1);
						});
					}
					else
					{
						$('.scheduleTable > tbody > tr:eq(1)').remove();
						$('.scheduleTable > tbody > tr:eq(0)').after(h);
						$('.scheduleTable > tbody > tr > td.cnt').each(function(){
							var t = $(this).text();
							$(this).text(parseInt(t)+1);
						});
					}
				}
				setTimeout(scheduleRefresh,5000);
				$('#calendar').fullCalendar('removeEvents');
	            $('#calendar').fullCalendar('addEventSource', calenderEvents);
	            $('#calendar').fullCalendar('rerenderEvents' );
			}
			if(jsonResponse.status == false)
			{
				toastr['error']('Error occured while performing actions');
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');
		}
	});
	$('#schedulechannelpopup').modal('hide');
});
$(document).on('change','#sch_channel_list',function(){
	var thisval = $(this).val();
	if(thisval == -5)
	{
		location.href = baseURL + "createchannel";
	}
});
$(document).on('change','#sch_target_list',function(){
	var thisval = $(this).val();
	if(thisval == -5)
	{
		location.href = baseURL + "createtarget";
	}
});
$(document).on('click','.updateScheduleChannel',function(){
	if($('#edit_sch_channel_list').val() == "")
	{
		$('#edit_sch_channel_list').css('border','1px solid red');
		return;
	}
	if($('#edit_schedule_popup_channel_starttime').val() == "")
	{
		$('#edit_schedule_popup_channel_starttime').css('border','1px solid red');
		return;
	}
	if($('#edit_schedule_popup_channel_endtime').val() == "")
	{
		$('#edit_schedule_popup_channel_endtime').css('border','1px solid red');
		return;
	}
	var sid = $('#edit_sch_channel_list option').attr('id');
	$.ajax({
		url: baseURL + "api/updateScheduleChannel",
		data:{'id':$('#edit_sch_channel_list').val(),'stime':$('#edit_schedule_popup_channel_starttime').val(),'etime':$('#edit_schedule_popup_channel_endtime').val(),'sid':sid},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				toastr['success']("Update Successfully!");
				$('.scheduleTable > tbody > #row_' + sid + ' td:eq(4)').html(jsonResponse.response.start_datetime);
				$('.scheduleTable > tbody > #row_' + sid + ' td:eq(5)').html(jsonResponse.response.end_datetime);

				var event = {};
				event.id = jsonResponse.response.sid;
		  		event.title = jsonResponse.response.title;
		  		var sdate = convertDateTime(jsonResponse.response.start_datetime);
		  		var edate = convertDateTime(jsonResponse.response.end_datetime);
		  		event.start = sdate;
		  		event.end = edate;
		  		event.backgroundColor = '#3C8DBC';
		  		event.borderColor = '#3C8DBC';
		  		if(calenderEvents.length > 0)
		  		{
					$.each(calenderEvents,function( key, value){
						if(value.id == jsonResponse.response.id)
						{
							calenderEvents.splice(key,1);
						}
					});
				}
				calenderEvents.push(event);
		  		 $('#calendar').fullCalendar('removeEvents');
	             $('#calendar').fullCalendar('addEventSource', calenderEvents);
	             $('#calendar').fullCalendar('rerenderEvents' );
			}
			if(jsonResponse.status == false)
			{
				toastr['error']('Error occured while performing actions');
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');
		}
	});
	$('#edit_schedulechannelpopup').modal('hide');
});

$(document).on('click','.saveNDI',function(){
	if($('#ndi_channel_name').val() == "")
	{
		$('#ndi_channel_name').css('border','1px solid red');
		return;
	}
	$.ajax({
		url: baseURL + "admin/updateGatewayChannel",
		data:{'id':updateChannelId,'channelname':$('#ndi_channel_name').val(),'sourcename':$('#ndi_channel_name').val()},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				toastr['success']("Update Successfully!");
				banks = JSON.parse(jsonResponse.banks);
				channelss = JSON.parse(jsonResponse.channelss);
			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.message);
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');
		}
	});
	$('#ndiChannelPopup').modal('hide');
});

$(document).on('click','.saveRTMP',function(){
	if($('#rtmp_channel_name').val() == "")
	{
		$('#rtmp_channel_name').css('border','1px solid red');
		return;
	}
	if($('#rtmp_ndi_source').val() == "")
	{
		$('#rtmp_ndi_source').css('border','1px solid red');
		return;
	}
	if($('#rtmp_apps').val() == "")
	{
		$('#rtmp_apps').css('border','1px solid red');
		return;
	}
	if($('#rtmp_url').val() == "")
	{
		$('#rtmp_url').css('border','1px solid red');
		return;
	}
	if($('#rtmp_key').val() == "")
	{
		$('#rtmp_key').css('border','1px solid red');
		return;
	}
	if($('#rtmp_encoding_profile').val() == "" || $('#rtmp_encoding_profile').val() == 0)
	{
		$('#rtmp_encoding_profile').css('border','1px solid red');
		return;
	}

	$.ajax({
		url: baseURL + "admin/updateGatewayRTMPChannel",
		data:{'id':updateChannelId,'channelname':$('#rtmp_channel_name').val(),'rtmp_ndi_source':$('#rtmp_ndi_source').val(),'rtmp_apps':$('#rtmp_apps').val(),'rtmp_url':$('#rtmp_url').val(),'rtmp_key':$('#rtmp_key').val(),'rtmp_key':$('#rtmp_key').val(),'rtmp_encoding_profile':$('#rtmp_encoding_profile').val(),'gateway_auth_uname':$('#gateway_auth_uname').val(),'gateway_auth_pass':$('#gateway_auth_pass').val()},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				toastr['success']("Update Successfully!");
				banks = JSON.parse(jsonResponse.banks);
				channelss = JSON.parse(jsonResponse.channelss);
			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.message);
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');

		}
	});
	$('#rtmpChannelPopup').modal('hide');
});
$(document).on('click','.saveSRT',function(){
	if($('#srt_channel_name').val() == "")
	{
		$('#srt_channel_name').css('border','1px solid red');
		return;
	}
	if($('#srt_source').val() == "")
	{
		$('#srt_source').css('border','1px solid red');
		return;
	}
	if($('#srt_ip').val() == "")
	{
		$('#srt_ip').css('border','1px solid red');
		return;
	}
	if($('#srt_port').val() == "")
	{
		$('#srt_port').css('border','1px solid red');
		return;
	}
	if($('#srt_mode').val() == "")
	{
		$('#srt_mode').css('border','1px solid red');
		return;
	}
	if($('#srt_encoding_profile').val() == "")
	{
		$('#srt_encoding_profile').css('border','1px solid red');
		return;
	}

	$.ajax({
		url: baseURL + "admin/updateGatewaySRTChannel",
		data:{'id':updateChannelId,'channelname':$('#srt_channel_name').val(),'srt_source':$('#srt_source').val(),'srt_ip':$('#srt_ip').val(),'srt_port':$('#srt_port').val(),'srt_mode':$('#srt_mode').val(),'srt_encoding_profile':$('#srt_encoding_profile').val()},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				toastr['success']("Update Successfully!");
				banks = JSON.parse(jsonResponse.banks);
				channelss = JSON.parse(jsonResponse.channelss);
			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.message);
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');

		}
	});
	$('#srtChannelPopup').modal('hide');
});
$(document).on('click','.saveSDI',function(){
	if($('#sdi_channel_name').val() == "")
	{
		$('#sdi_channel_name').css('border','1px solid red');
		return;
	}
	if($('#sdi_source').val() == "")
	{
		$('#sdi_source').css('border','1px solid red');
		return;
	}
	if($('#sdi_output').val() == "")
	{
		$('#sdi_output').css('border','1px solid red');
		return;
	}
	if($('#sdi_audio_channel').val() == "")
	{
		$('#sdi_audio_channel').css('border','1px solid red');
		return;
	}

	$.ajax({
		url: baseURL + "admin/updateGatewaySDIChannel",
		data:{'id':updateChannelId,'channelname':$('#sdi_channel_name').val(),'sdi_source':$('#sdi_source').val(),'sdi_output':$('#sdi_output').val(),'sdi_audio_channel':$('#sdi_audio_channel').val()},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				toastr['success']("Update Successfully!");
				banks = JSON.parse(jsonResponse.banks);
				channelss = JSON.parse(jsonResponse.channelss);
			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.message);
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');

		}
	});
	$('#sdiChannelPopup').modal('hide');
});
$(document).on('click','.stopgatewaych',function(e){
		e.stopPropagation();
	var idG = $(this).parent().attr('id');
	var delIds = $(this).attr('id');
	var delId = delIds.split('_');
	globalBankId = delId[1];
	var channelData = channelss[idG];
	if(channelData['isLocked'] == 1)
	{
		toastr['error']('You cant perform this action on locked Bank');
		return;
	}
	swal({
		title: "Are you sure?",
		text: "You want to delete this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Delete it!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
			url: baseURL + "admin/deletGatewayChannel",
			data:{'id':idG},
			type:'post',
			dataType:'json',
			success:function(jsonResponse){
				if(jsonResponse.status == true)
				{
					$('#banks-events div#'+ globalBankId + ' .box-events-buttons li#'+idG).remove();
					toastr['success']("Deleted Successfully!");
					delete channelss[idG];
				}
				if(jsonResponse.status == false)
				{
					toastr['error'](jsonResponse.message);
				}
			},
			error:function(){
				toastr['error']('Error occured while performing actions');
				$(anch).find('span').html("<i class='fa fa-plus'></i> Bank");
			}
		});
	});

});

$(document).on('click','.channelStartStopGateway',function(e){

	var action = "";
	var thisObj = $(this);
	if($(this).hasClass("label-gray"))
	{
		action = "Start";
	}
	else if($(this).hasClass("label-live"))
	{
		action = "Stop";
	}

	if($(this).parent().parent().parent().find('a').find('span').text().trim() == "" || $(this).parent().parent().parent().find('a').find('span').text().trim() == "EmptyBank")
	{
		toastr['error']('You cant perform this action on empty bank');
		return false;
	}

	var id = $(this).attr('id');
	var channelData = channelss[id];
	if(channelData['isLocked'] == 1)
	{
		toastr['error']('You cant perform this action on locked Bank');
		return;
	}

	swal({
		title: "Are you sure?",
		text: "You want to "+action+" this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, "+action+" it!",
		closeOnConfirm: true
	},
	function(){
		$(thisObj).find("img").show();
		$.ajax({
			url: baseURL + "admin/gatewayStartStop",
			data:{'id':id,'action':action},
			type:'post',
			dataType:'json',
			success:function(jsonResponse){
				if(jsonResponse.status == true)
				{
					switch(jsonResponse.change)
					{
						case "start":
						$(thisObj).removeAttr("class");
						$(thisObj).addClass("label label-live channelStartStopGateway");
						$(thisObj).find("span").removeClass("inactive");
						$(thisObj).find('.counter').removeClass("inactive");
						$(thisObj).find('.counter').attr('title',jsonResponse.time);
						var timer = setInterval(upTime, 1000);
						toastr['success'](jsonResponse.message);
						break;
						case "stop":
						$(thisObj).removeAttr("class");
						$(thisObj).find("span").addClass("inactive");
						$(thisObj).find('.counter').addClass("inactive");
						$(thisObj).addClass("label label-gray channelStartStopGateway");
						$(thisObj).find('.counter').attr('title',"").text("00:00:00");
						toastr['success'](jsonResponse.message);
						break;
					}
					$(thisObj).find("img").hide();
				}
				if(jsonResponse.status == false)
				{
					toastr['error'](jsonResponse.message);
					$(thisObj).find("img").hide();
				}
			},
			error:function(){
				toastr['error']('Error occured while performing actions');
				$(thisObj).find("img").hide();
			}
		});
	});
});
$(document).on('click','.delBank',function(){
	var idG = $(this).parent().parent().attr('id');
	var b = banks[idG];
	//console.log(banks);
	if(b['isLocked'] == 1)
	{
		toastr['error']('You cant perform this action on locked Bank');
		return;
	}


	swal({
		title: "Are you sure?",
		text: "You want to delete this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Delete it!",
		closeOnConfirm: true
	},
	function(){
		$.ajax({
			url: baseURL + "admin/deletBank",
			data:{'id':idG},
			type:'post',
			dataType:'json',
			success:function(jsonResponse){
				if(jsonResponse.status == true)
				{
					$('#banks-events div#'+ idG).remove();
					toastr['success']("Deleted Successfully!");
					delete banks[idG];
				}
				if(jsonResponse.status == false)
				{
					toastr['error'](jsonResponse.message);
				}
			},
			error:function(){
				toastr['error']('Error occured while performing actions');

			}
		});
	});
});
$(document).on('click','.bankLock',function(){
	var action = "";
	var obj = $(this);
	if(true == $(this).hasClass("fa-unlock"))
	{
		action = "Lock";
	}
	else if(true == $(this).hasClass("fa-lock"))
	{
		action = "UnLock";
	}
	var BankId = $(this).parent().parent().attr("id");
	$.ajax({
		url: baseURL + "admin/lockUnlockBank",
		data:{'id':BankId,'action':action},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				switch(jsonResponse.change)
				{
					case "Lock":
					$(obj).removeClass('fa-unlock');
					$(obj).addClass('fa-lock');
					break;
					case "UnLock":
					$(obj).removeClass('fa-lock');
					$(obj).addClass('fa-unlock');
					break;
				}
				banks = JSON.parse(jsonResponse.banks);
				channelss = JSON.parse(jsonResponse.channelss);
			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.message);
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');
		}
	});
});
$(document).on('click','.addBank',function(){

	var anch = $(this);
	var banksize = $('#banks-events').find(".banks").length;

	$(this).find('span').html("<img src='"+baseURL +"assets/site/main/images/loadgateway.gif'/> Bank");
	$.ajax({
		url: baseURL + "admin/createBank",
		data:{'id':0},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				banks[jsonResponse.response.bankId]="Empty Bank";
				var Bank = "";
				Bank += "<div id='"+jsonResponse.response.bankId+"' class='banks external-event' style='position: relative;border: 1px solid #dfe2e5;'>";
   				Bank += "<div class='banks-action'>";
      			Bank += "<li data-toggle='tooltip' data-placement='left' title='Destination Bank' class='fa fa-info-circle' style='color: #fff;'></li>";
      			Bank += "<li class='fa fa-unlock bankLock' style='color:#fff;'></li>";
      			Bank += "<li class='fa fa-times delBank' style='color:#fff;'></li>";
   				Bank += "</div>";
   				Bank += "<a style='text-align:center;margin:0 0 10px;display:block;' class='bankpopup'><i class='fa fa-link' style='color:#fff;'></i><span>EmptyBank</span></a>";
   				Bank += "<div class='box-events-buttons'>";
      			Bank += "<ul class='events-attachments clearfix'>";
         		Bank += "<li id='"+jsonResponse.response.ndiId+"' class='label label-gray channelStartStopGateway'><a id='NDI_"+jsonResponse.response.bankId+"' class='settings' href='javascript:void(0);'><i class='fa fa-gear' style='color: #3737376b;position:  absolute;left: 0;padding: 2px;top:  0;font-size:  16px;'></i></a><a class='stopgatewaych' id='stop_"+jsonResponse.response.bankId+"' href='javascript:void(0);' ><i class='fa fa-times' style='color: #3737376b;position:  absolute;right:  0;padding: 2px;top:  0;font-size:  16px;'></i></a><span class='events-attachment-button inactive'>NDI</span><p class='counter inactive' style='color: #f2f906;font-size: 13px;font-family: monospace;text-align:  center;' title=''>00:00:00:00</p></li>";
         		Bank += "<li id='"+jsonResponse.response.rtmpId+"' class='label label-gray channelStartStopGateway'><a id='RTMP_"+jsonResponse.response.bankId+"' class='settings' href='javascript:void(0);'><i class='fa fa-gear' style='color: #3737376b;position:  absolute;left: 0;padding: 2px;top:  0;font-size:  16px;'></i></a><a class='stopgatewaych' id='stop_"+jsonResponse.response.bankId+"' href='javascript:void(0);'><i class='fa fa-times' style='color: #3737376b;position:  absolute;right:  0;padding: 2px;top:  0;font-size:  16px;'></i></a><span class='events-attachment-button inactive'>RTMP</span><p class='counter inactive' style='color: #f2f906;font-size: 13px;font-family: monospace;text-align:  center;' title=''>00:00:00:00</p></li>";
         		Bank += "<li id='"+jsonResponse.response.srtId+"' class='label label-gray channelStartStopGateway'><a id='SRT_"+jsonResponse.response.bankId+"' class='settings' href='javascript:void(0);'><i class='fa fa-gear' style='color: #3737376b;position:  absolute;left: 0;padding: 2px;top:  0;font-size:  16px;'></i></a><a class='stopgatewaych' id='stop_"+jsonResponse.response.bankId+"' href='javascript:void(0);'><i class='fa fa-times' style='color: #3737376b;position:  absolute;right:  0;padding: 2px;top:  0;font-size:  16px;'></i></a><span class='events-attachment-button inactive'>SRT</span><p class='counter inactive' style='color: #f2f906;font-size: 13px;font-family: monospace;text-align:  center;' title=''>00:00:00:00</p></li>";
         		Bank += "<li id='"+jsonResponse.response.recId+"' class='label label-gray channelStartStopGateway'><a id='SDI_"+jsonResponse.response.bankId+"' class='settings' href='javascript:void(0);'><i class='fa fa-gear' style='color: #3737376b;position:  absolute;left: 0;padding: 2px;top:  0;font-size:  16px;'></i></a><a class='stopgatewaych' id='stop_"+jsonResponse.response.bankId+"' href='javascript:void(0);'><i class='fa fa-times' style='color: #3737376b;position:  absolute;right:  0;padding: 2px;top:  0;font-size:  16px;'></i></a><span class='events-attachment-button inactive'>SDI</span><p class='counter inactive' style='color: #f2f906;font-size: 13px;font-family: monospace;text-align:  center;' title=''>00:00:00:00</p></li>";
				Bank +="<li class='label label-add' style='border: 1px dashed #73787e;text-align:  center;font-size: 33px;'><a href='javascript:void(0);' class='addnewchannel' data-toggle='modal' data-target='#modelCreateGatewayChannels' id='bank_"+jsonResponse.response.bankId+"'> <i class='fa fa-plus' style='color: #464748;'></i></a></li>";
      			Bank +="</ul>";
   				Bank +="</div>";
				Bank +="</div>";
				if(banksize == 0)
				{
					$("#banks-events").html(Bank);
				}
				else if(banksize > 0)
				{
					$(Bank).insertAfter($('#banks-events .banks:eq('+(banksize-1)+')'));
				}
				$(anch).find('span').html("<i class='fa fa-plus'></i> Bank");
				dropBanks();
				banks = JSON.parse(jsonResponse.banks);
				channelss = JSON.parse(jsonResponse.channelss);

			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.message);
				$(anch).find('span').html("<i class='fa fa-plus'></i> Bank");
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');
			$(anch).find('span').html("<i class='fa fa-plus'></i> Bank");
		}
	});
});


$(document).on('click','#localsourcescheck',function(){

	if($(this).is(":checked") == false)
	{
		$('#external-events div.external-event').each(function(){
			var isLocal = $(this).attr('role');
			if(isLocal != 'false')
			{
				$(this).css('display','none');
			}
		});
	}
	else if($(this).is(":checked") == true)
	{
		$('#external-events div.external-event').each(function(){
			var isLocal = $(this).attr('role');
			if(isLocal != 'false')
			{
				$(this).css('display','block');
			}
		});
	}

});

$(document).on('click','.resourceInfo',function(){
	var encidd = $(this).parent().attr('id');
	var sourcename = $(this).parent().attr('name');

	$(this).find('i').remove();
	$(this).html("<img style='float:right;' src='"+baseURL +"assets/site/main/images/loadSource.gif'/>");
	var obj = $(this);
	$.ajax({
		url: baseURL + "admin/extractSources",
		data:{'src':sourcename,'encid':encidd},
		type:'post',
		dataType:'json',
		success:function(jsonResponseExtreact){
			console.log(jsonResponseExtreact.data);
			if(jsonResponseExtreact.data.isExist == true)
			{
				$('#external-events div[name="'+jsonResponseExtreact.data.src+'"]').css('min-height','105px').find('img').attr('src',baseURL + 'assets/site/main/tmp/images/' + jsonResponseExtreact.data.name);
				var info = "<ul>";
				info += "<li>" + jsonResponseExtreact.data.Audio + "</li>";
				info += "<li>" + jsonResponseExtreact.data.Video + "</li>";
				$('#external-events div[name="'+jsonResponseExtreact.data.src+'"]').find('.infoSources').html(info);
			}
			else if(jsonResponseExtreact.data.isExist == false)
			{
				$('#external-events div[name="'+jsonResponseExtreact.data.src+'"]').css('min-height','105px').find('img').attr('src',baseURL + 'assets/site/main/images/default-gateway.png');
				var info = "<ul>";
				info += "<li>" + jsonResponseExtreact.data.Audio + "</li>";
				info += "<li>" + jsonResponseExtreact.data.Video + "</li>";
				$('#external-events div[name="'+jsonResponseExtreact.data.src+'"]').find('.infoSources').html(info);
			}
			$(obj).find('img').remove();
			$(obj).parent().find('img').show();
			$(obj).html("<i class='fa fa-info-circle' style='color:#fff;float: right;'></i>");
		},
		error:function()
		{
			toastr['error']('Error occured while getting info');
			$(obj).find('img').remove();
			$(obj).html("<i class='fa fa-info-circle' style='color:#fff;float: right;'></i>");
		}
	});

});

$(document).on('click','.refreshSource',function(){
	$('#external-events div.external-event').remove();
	var anch = $(this);
	$(this).find('span').html("<img src='"+baseURL +"assets/site/main/images/loadgateway.gif'/> Refresh");
	$.ajax({
		url: baseURL + "admin/getGatewayNDISource",
		data:{'id':0},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				if(Object.keys(jsonResponse.response).length >0)
				{
					var NDISources = "";
					var sourcesArray = {};
					for(var i in jsonResponse.response)
					{
						for(var j=0; j<jsonResponse.response[i].length; j++)
						{
							if(jsonResponse.response[i][j].isLocal == true)
							{
								NDISources += "<div role='"+jsonResponse.response[i][j].isLocal+"' name='"+jsonResponse.response[i][j].ndiname+"' id='"+jsonResponse.response[i][j].encoderId+"' class='external-event bg-aqua' style='position: relative;display:none;font-size:13px;'> " + jsonResponse.response[i][j].ndiname + "(" + jsonResponse.response[i][j].sourceIP + ") <a class='resourceInfo' href='javascript:void(0);'><i class='fa fa-info-circle' style='color:#fff;float: right;'></i></a><br><img src='"+baseURL+"assets/site/main/img/channel-loading.gif' alt='...' style='display:none;' class='margin ajxSload'/><div class='infoSources'></div>";
							NDISources += "</div>";
							}
							else if(jsonResponse.response[i][j].isLocal == false)
							{
								NDISources += "<div role='"+jsonResponse.response[i][j].isLocal+"' name='"+jsonResponse.response[i][j].ndiname+"' id='"+jsonResponse.response[i][j].encoderId+"' class='external-event bg-aqua' style='position: relative;font-size: 13px;'> " + jsonResponse.response[i][j].ndiname + "(" + jsonResponse.response[i][j].sourceIP + ") <a class='resourceInfo' href='javascript:void(0);'><i class='fa fa-info-circle' style='color:#fff;float: right;'></i></a><br><img src='"+baseURL+"assets/site/main/img/channel-loading.gif' alt='...' style='display:none;' class='margin ajxSload'/><div class='infoSources'></div>";
							NDISources += "</div>";
							}
						}

					}
					$(NDISources).insertBefore("#removedropGateway");
					init_events($('#external-events div.external-event'));
					$(anch).find('span').html("<i class='fa fa-refresh'></i> Refresh");


				}
				else
				{
					var NDISources = "No Sources Found";
					$('#external-events').html(NDISources);
					$(anch).find('span').html("<i class='fa fa-refresh'></i> Refresh");
				}

			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.response);
				$(anch).find('span').html("<i class='fa fa-refresh'></i> Refresh");
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');
			$(anch).find('span').html("<i class='fa fa-refresh'></i> Refresh");
		}
	}).done(function(jsonResponse){



	});
});

$(document).ready(function(){

	/* Get Gateway Sources */
	/*$.ajax({
		url: baseURL + "admin/getGatewayNDISource",
		data:{'id':0},
		type:'post',
		dataType:'json',
		success:function(jsonResponse){
			if(jsonResponse.status == true)
			{
				if(Object.keys(jsonResponse.response).length >0)
				{
					var NDISources = "";
					for(var i in jsonResponse.response)
					{
						for(var j=0; j<jsonResponse.response[i].length; j++)
						{
							NDISources += "<div class='external-event bg-aqua ui-draggable ui-draggable-handle' style='position: relative;'>" + jsonResponse.response[i][j].ndiname + " (" + jsonResponse.response[i][j].sourceIP + ") <i class='fa fa-info-circle' style='color:#fff;float: right;'></i><br><img src='http://placehold.it/80x45' alt='...' class='margin'>";
							NDISources += "</div>";
						}
					}
					$('#external-events').html(NDISources);
				}
				else
				{
					var NDISources = "No Sources Found";
					$('#external-events').html(NDISources);
						$('#channel_ndi_source').selectpicker('refresh');
				}

			}
			if(jsonResponse.status == false)
			{
				toastr['error'](jsonResponse.response);
			}
		},
		error:function(){
			toastr['error']('Error occured while performing actions');
		}
	});
	*/

	setTimeout(function() {
   		$('.alert').fadeOut('slow');
	}, 5000);
	/* Create Chanell Page Things Start */
	if(Action != "updatechannel")
	{
		$('.hls,.audioch,.ndi,.ips,.rtmp,.mpeg-rtp,.mpeg-udp,.mpeg-srt,.ch-applications,.ndi-name,.out-rtmp-url,.out-rtmp-key,.ch-uname,.ch-pass,.out-mpeg-rpt,.out-mpeg-udp,.out-mpeg-srt').hide();
		$('.ch-profile').hide();
		$('.ch-authentication').hide();
	}


	$(document).on('click','.channellocs',function(){

	var permis = JSON.parse(userPermissions);
	var obj = $(this);
	var id = $(this).attr("id");
	var ids = id.split('_');
	var cls = $(this).find('i').attr('class');
	var classNames = cls.split(' ');var action = "";
	if(classNames[1] == "fa-unlock")
	{
		if(permis.lock_application == 0)
		{
			toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
			return;
		}
		action = "Lock";
	}
	else if(classNames[1] == "fa-lock")
	{
		if(permis.lock_application == 0)
		{
			toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
			return;
		}
		action = "UnLock";
	}
	var objj = $(this);
			swal({
				title: "Are you sure?",
				text: "You want to "+action+" this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, "+action+" it!",
				closeOnConfirm: true
			},
			function(){
				$.ajax({
					url: baseURL + "admin/channelsLockUnlock",
					data:{'id':id,'action':action},
					type:'post',
					dataType:'json',
					success:function(jsonResponse){
						if(jsonResponse.status == true)
						{
							if(action == "Lock")
							{
								$(obj).find('i').removeClass('fa-unlock');
								$(obj).find('i').addClass('fa-lock');
								ids
								channelLocks[ids[1]] = 1;
							}
							else if(action == "UnLock")
							{
								$(obj).find('i').removeClass('fa-lock');
								$(obj).find('i').addClass('fa-unlock');
								channelLocks[ids[1]] = 0;
							}
							toastr['success']( action + ' Successfully!');
						}
						if(jsonResponse.status == false)
						{
							toastr['error'](jsonResponse.response);
						}
					},
					error:function(){
						toastr['error']('Error occured while performing actions');
					}
				});
			});



});

	$(document).on('click','#find_NDISources',function(){
		var txt = "NULL";
		var obj = $(this);
		$(this).find('i').remove();
		if($("#isIPAddress").is(":checked") == true)
		{
			if($("#ip_addresses_comma").val() !== "")
			{
				txt = $("#ip_addresses_comma").val();
			}
		}
		if($("#channelEncoders").val() == "" || $("#channelEncoders").val() <= 0)
		{
			toastr['error']('Please Select Encoder First.');
			return;
		}
		$(this).html("<img style='float:right;' src='"+baseURL +"assets/site/main/images/loadSource.gif'/>");
		var Ecid = $("#channelEncoders").val();

		$.ajax({
				url: baseURL + "admin/getNDISource",
				data:{'id':Ecid,'txt':txt},
				type:'post',
				dataType:'json',
				success:function(jsonResponse){
					if(jsonResponse.status == true)
					{

						if(Object.keys(jsonResponse.response).length >0)
						{
							console.log(Object.keys(jsonResponse.response).length);
							var NDISources = "<option value='0'>Select Source</option>";
							for(var i in jsonResponse.response)
							{
								NDISources += "<optgroup label='"+i+" / Found "+jsonResponse.response[i].length+" NDI Sources '>";
								for(var j=0; j<jsonResponse.response[i].length; j++)
								{
									if(jsonResponse.response[i][j].isRemote == true)
									{
										NDISources += "<option class='remote' id="+jsonResponse.response[i][j].encid+" value='"+jsonResponse.response[i][j].encid + "#" +jsonResponse.response[i][j].ndiname +"#Remote'>-- " + jsonResponse.response[i][j].ndiname + "  Remote</span></option>";
									}
									else if(jsonResponse.response[i][j].isRemote == false)
									{
										NDISources += "<option id="+jsonResponse.response[i][j].encid+" value='"+jsonResponse.response[i][j].encid + "#" +jsonResponse.response[i][j].ndiname +"#No'>-- " + jsonResponse.response[i][j].ndiname + "</option>";
									}
								}
								NDISources += "</optgroup>";
							}


							$('#channel_ndi_source').html(NDISources);
							$('#channel_ndi_source').selectpicker('refresh');
							$(obj).find('img').remove();
							$(obj).html("<i class='fa fa-refresh'></i>");
							$("a.remote > span.text").html(function(i,val){
								return val.replace('Remote', "<span class='remote'>Remote</span>");
							});
						}
						else
						{
							var NDISources = "<option value='0'>No NDI Sources Found</option>";
							$('#channel_ndi_source').html(NDISources);
							$('#channel_ndi_source').selectpicker('refresh');
							$(obj).find('img').remove();
							$(obj).html("<i class='fa fa-refresh'></i>");
						}

					}
					if(jsonResponse.status == false)
					{
						toastr['error'](jsonResponse.response);
						$(obj).find('img').remove();
						$(obj).html("<i class='fa fa-refresh'></i>");
					}
				},
				error:function(){
					toastr['error']('Error occured while performing actions');
					$(obj).find('img').remove();
					$(obj).html("<i class='fa fa-refresh'></i>");
				}
			});

	});
	$(document).on('change','#channelInput',function(){

		var typpe = $(this).find('option:selected').attr("label");
		if(Action == "updatechannel")
		{
			if(typpe == "phyinput")
			{
				return;
			}
		}
		$('.hls').hide();
		//$('#channelOutpue').selectpicker('refresh');
		$('#channelOutpue').parent().find('.dropdown-menu li').removeClass('disabled');
		$('#channelOutpue option').each(function(){
			$(this).removeAttr('disabled');
		});
		$('.ch-authentication').hide();
		$('.ndi').hide();$('.mpeg-rtp').hide();$('.ips').hide();
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
				$('.audioch').show();
				$('#encid').val(encinput);
				$('#channelOutpue').children('option[label="phyoutput"]').hide();
				$('#channelOutpue').children('option[label="phyoutput"]').each(function(){
					var indx = $(this).attr("tabindex");
					$('#channelOutpue').parent().find('.dropdown-menu li[data-original-index="'+indx+'"]').hide();
				});
				if($('#channelOutpue').val() != "" &&  $('#channelOutpue').val() == "viroutput_4")
				{
					$('.ch-authentication').show();
					$('.ch-applications').show();
				}
				else
				{
					$('.ch-authentication').hide();
					$('.ch-applications').hide();
				}

				break;
				case "virinput":
					$('.audioch').hide();
					var inpval = $(this).val();
					switch(inpval)
					{
						case "virinput_3":
						//$('#channelOutpue').children('option[value="viroutput_3"]').prop('disabled', true);
						var ind = $('#channelOutpue').children('option[value="viroutput_3"]').attr("tabindex");
						//$('#channelOutpue').parent().find('.dropdown-menu li[data-original-index="'+ind+'"]').addClass('disabled');
						$('.ips').show();
						$('#find_NDISources').find('i').remove();
						var txt = "NULL";
						if($("#isIPAddress").is(":checked") == true)
						{
							if($("#ip_addresses_comma").val() !== "")
							{
								txt = $("#ip_addresses_comma").val();
							}
						}
						if($("#channelEncoders").val() == "" || $("#channelEncoders").val() <= 0)
						{
							toastr['error']('Please Select Encoder First.');
							return;
						}

						var Ecid = $("#channelEncoders").val();
						$('#find_NDISources').html("<img style='float:right;' src='"+baseURL +"assets/site/main/images/loadSource.gif'/>");
						$.ajax({
							url: baseURL + "admin/getNDISource",
							data:{'id':Ecid,'txt':txt},
							type:'post',
							dataType:'json',
							success:function(jsonResponse){
								if(jsonResponse.status == true)
								{
									if(Object.keys(jsonResponse.response).length >0)
									{
										var NDISources = "<option value='0'>Select Source</option>";
										for(var i in jsonResponse.response)
										{
											NDISources += "<optgroup label='"+i+" / Found "+jsonResponse.response[i].length+" NDI Sources '>";
											console.log(jsonResponse.response[i].length);
											for(var j=0; j<jsonResponse.response[i].length; j++)
											{
												if(jsonResponse.response[i][j].isRemote == true)
												{
													NDISources += "<option class='remote' id="+jsonResponse.response[i][j].encid+" value='"+jsonResponse.response[i][j].encid + "#" +jsonResponse.response[i][j].ndiname +"#Remote'>-- " + jsonResponse.response[i][j].ndiname + "  Remote</option>";
												}
												else if(jsonResponse.response[i][j].isRemote == false)
												{
													NDISources += "<option id="+jsonResponse.response[i][j].encid+" value='"+jsonResponse.response[i][j].encid + "#" +jsonResponse.response[i][j].ndiname +"#No'>-- " + jsonResponse.response[i][j].ndiname + "</option>";
												}
											}
											NDISources += "</optgroup>";
										}


										$('#channel_ndi_source').html(NDISources);
										//$('#channel_ndi_source').selectpicker('refresh');
										$("#find_NDISources").find('img').remove();
										$("#find_NDISources").html("<i class='fa fa-refresh'></i>");
										$("a.remote > span.text").html(function(i,val){
											return val.replace('Remote', "<span class='remote'>Remote</span>");
										});
									}
									else
									{
										var NDISources = "<option value='0'>No NDI Sources Found</option>";
										$('#channel_ndi_source').html(NDISources);
										//$('#channel_ndi_source').selectpicker('refresh');
										$("#find_NDISources").find('img').remove();
										$("#find_NDISources").html("<i class='fa fa-refresh'></i>");
									}

								}
								if(jsonResponse.status == false)
								{
									toastr['error'](jsonResponse.response);
									$("#find_NDISources").find('img').remove();
									$("#find_NDISources").html("<i class='fa fa-refresh'></i>");
								}
							},
							error:function(){
								toastr['error']('Error occured while performing actions');
								$("#find_NDISources").find('img').remove();
								$("#find_NDISources").html("<i class='fa fa-refresh'></i>");
							}
						});

						$('.ndi').show();
						if($('#channelOutpue').val() != "" &&  $('#channelOutpue').val() == "viroutput_4")
						{
							$('.ch-authentication').show();
							$('.ch-applications').show();
						}
						else
						{
							$('.ch-authentication').hide();
							$('.ch-applications').hide();
						}
						break;
						case "virinput_4":
							$('.rtmp').show();
							if($('#channelOutpue').val() != "" &&  $('#channelOutpue').val() == "viroutput_4")
							{
								$('.ch-authentication').show();
								$('.ch-applications').show();
							}
							else
							{
								$('.ch-authentication').hide();
								$('.ch-applications').hide();
							}
						break;
						case "virinput_5":
							$('.mpeg-rtp').show();
							if($('#channelOutpue').val() != "" &&  $('#channelOutpue').val() == "viroutput_4")
							{
								$('.ch-authentication').show();
								$('.ch-applications').show();
							}
							else
							{
								$('.ch-authentication').hide();
								$('.ch-applications').hide();
							}
						break;
						case "virinput_6":
							$('.mpeg-udp').show();
							if($('#channelOutpue').val() != "" &&  $('#channelOutpue').val() == "viroutput_4")
							{
								$('.ch-authentication').show();
								$('.ch-applications').show();
							}
							else
							{
								$('.ch-authentication').hide();
								$('.ch-applications').hide();
							}
						break;
						case "virinput_7":
							$('.mpeg-srt').show();
							if($('#channelOutpue').val() != "" &&  $('#channelOutpue').val() == "viroutput_4")
							{
								$('.ch-authentication').show();
								$('.ch-applications').show();
							}
							else
							{
								$('.ch-authentication').hide();
								$('.ch-applications').hide();
							}
						break;
							case "virinput_8":
							$('.hls').show();
							if($('#channelOutpue').val() != "" &&  $('#channelOutpue').val() == "viroutput_4")
							{
								$('.ch-authentication').show();
								$('.ch-applications').show();
							}
							else
							{
								$('.ch-authentication').hide();
								$('.ch-applications').hide();
							}
						break;
					}
				break;
			}
		}
	});
	$(document).on('change','#newchannelOutpue',function(){
		var channelOutput = $(this).val();
		var channelOutput = $(this).find('option:selected').attr("tabindex");

		var typpe = $(this).find('option:selected').attr("label");
		$('.ch-audio-channels').hide();
		$('.ch-profile').hide();
		$('.ndi-name').hide();$('.ch-applications').hide();$('.out-rtmp-url').hide();
		$('.out-rtmp-key').hide();
		$('.out-rtmp-url > input[type=text]').val("");
		$('.new-srt').hide();
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
							$('.ch-authentication').hide();
								$('.ch-applications').hide();
						break;
						case "viroutput_4":
							$('.ch-applications').show();
							$('.ch-profile').show();
							$('.ch-authentication').show();
						break;

						case "viroutput_7":
							$('.new-srt').show();
							$('.ch-profile').show();
							$('.ch-authentication').hide();
							$('.ch-applications').hide();
						break;
					}
				break;
				case "phyoutput":
				$('.ch-audio-channels').show();
				var eid = $(this).find('option:selected').attr("id");
				$("#encid").val(eid);
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
							$('.ch-authentication').hide();
								$('.ch-applications').hide();
						break;
						case "viroutput_4":
							$('.ch-applications').show();
							$('.ch-profile').show();
							$('.ch-authentication').show();
						break;
						case "viroutput_5":
							$('.out-mpeg-rpt').show();
							$('.ch-profile').show();
							$('.ch-authentication').hide();
								$('.ch-applications').hide();
						break;
						case "viroutput_6":
							$('.out-mpeg-udp').show();
							$('.ch-profile').show();
							$('.ch-authentication').hide();
								$('.ch-applications').hide();
						break;
						case "viroutput_7":
							$('.out-mpeg-srt').show();
							$('.ch-profile').show();
							$('.ch-authentication').hide();
								$('.ch-applications').hide();

						break;
					}
				break;
				case "phyoutput":
				var eid = $(this).find('option:selected').attr("id");
				$("#encid").val(eid);

				var typpec = $("#channelInput").find('option:selected').attr("label");

				if(typpec == "phyoutput")
				{
					$('#channelInput').selectpicker('refresh');
					$('#channelInput').children('option[label="phyoutput"]').hide();
					$('#channelInput').children('option[label="phyoutput"]').each(function(){
						var indx = $(this).attr("tabindex");
						$('#channelInput').parent().find('.dropdown-menu li[data-original-index="'+indx+'"]').hide();
					});
				}
				else if(typpec == "" || typpec == undefined)
				{
					$('#channelInput option[label="phyinput"]').hide();
					$('#channelInput option[label="phyinput"]').each(function(){
						var indx1 = $(this).attr("tabindex");
						$('#channelInput').parent().find('.dropdown-menu li[data-original-index="'+indx1+'"]').hide();
					});
				}
				break;
			}
		}
	});
	$(document).on('change','#rtmp_apps',function(){
		var appId = $(this).val();
		if(appId != -2 && appId != "")
		{
			var streamURL = $(this).find('option[value="'+appId +'"]').attr("id");
			var streamURLArray = streamURL.split('/');
			var streamURI = streamURLArray[streamURLArray.length-2];
			var streamName = streamURLArray[streamURLArray.length-1];
			$('.gateway-rtmp-url').show();
			var URRR = "rtmp://" + streamURLArray[streamURLArray.length-3] +"/" + streamURLArray[streamURLArray.length-2];

			$('.gateway-rtmp-key').show();
			$('.gateway-rtmp-key .row > input[type=text]').val(streamName);
			$('.gateway-rtmp-url .row > input[type=text]').val(URRR);
		}
		else
		{
			if(appId == -2)
			{
				$('.gateway-rtmp-url').show();
				$('.gateway-rtmp-key').show();
				$('.gateway-rtmp-key .row > input[type=text]').val("");
			$('.gateway-rtmp-url .row > input[type=text]').val("");
			}
			else
			{
				$('.gateway-rtmp-url').val("").hide();
				$('.gateway-rtmp-key').val("").hide();
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
	$(document).on('change','#gateway-auth',function(){
		$('.gateway-uname > input[type="text"]').val("");
		$('.gateway-pass > input[type="text"]').val("");
		if($(this).is(":checked") == true)
		{
			$('.gateway-uname').show();
			$('.gateway-pass').show();
		}
		else if($(this).is(":checked") == false)
		{
			$('.gateway-uname').hide();
			$('.gateway-pass').hide();
		}
	});

	$(document).on('change','#isIPAddress',function(){


		if($(this).is(":checked") == true)
		{
			$('.ips > input[type="text"]').val("");
			$('.ips > input[type="text"]').removeAttr("disabled");
		}
		else if($(this).is(":checked") == false)
		{
			$('.ips > input[type="text"]').val("");
			$('.ips > input[type="text"]').attr("disabled","disabled");
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
	$(document).on('change','#target_auth',function(){
		$('.tar-uname > input[type="text"]').val("");
		$('.tar-pass > input[type="text"]').val("");
		if($(this).is(":checked") == true)
		{
			$('.tar-uname').show();
			$('.tar-pass').show();
		}
		else if($(this).is(":checked") == false)
		{
			$('.tar-uname').hide();
			$('.tar-pass').hide();
		}
	});
	/* Create Chanell Page Things End */
	/* Encoding Template */

	$(document).on('change','#encoder_hardware',function(){
		$('#encoder_model').removeAttr('disabled');
		$('#encoder_model').parent().find('.dropdown-toggle').removeClass("disabled");
	});
	$(document).on('change','#encoder_hardware1',function(){
		$('#encoder_model1').removeAttr('disabled');
		$('#encoder_model1').parent().find('.dropdown-toggle').removeClass("disabled");
	});
	$(document).on('change','#encoder_hardware2',function(){
		$('#encoder_model2').removeAttr('disabled');
		$('#encoder_model2').parent().find('.dropdown-toggle').removeClass("disabled");
	});
	/* previous design encoder model
	$(document).on('change','#encoder_model',function(){

		$('#encoder_inputs').removeAttr('disabled');
		$('#encoder_output').removeAttr('disabled');
		$('#encoder_inputs').parent().find('.btn-default').removeAttr("disabled");
		$('#encoder_output').parent().find('.btn-default').removeAttr("disabled");
		var inputs = EncInputs[$(this).val()];
		var outputs = EncOutputs[$(this).val()];
		var inpHtml = "";
		if(inputs !== undefined && inputs.length > 0)
		{
			for(var inp = 0; inp<inputs.length; inp++)
			{
				inpHtml += "<option value='" + inputs[inp].id + "'>" + inputs[inp].value + "</option>" ;
			}
			$("#encoder_inputs").html(inpHtml);
			$('#encoder_inputs').multiselect('rebuild');
		}
		else
		{
			$("#encoder_inputs").html(inpHtml);
			$('#encoder_inputs').multiselect('rebuild');
		}
		var outHtml = "";
		if(outputs !== undefined && outputs.length > 0)
		{

			for(var oup = 0; oup<outputs.length; oup++)
			{
				outHtml += "<option value='" + outputs[oup].id + "'>" + outputs[oup].value + "</option>" ;
			}
			$("#encoder_output").html(outHtml);
			$('#encoder_output').multiselect('rebuild');
		}
		else
		{
			$("#encoder_output").html(outHtml);
			$('#encoder_output').multiselect('rebuild');
		}
	});*/



	if(Action != "updateencodingtemplate" && Action != "editEncoder")
	{
		$('#video_codec,#video_resolution, #video_bitrate, #video_framerate, #video_min_bitrate, #video_max_bitrate').attr('disabled','disabled');
		//$('#adv_video_min_bitrate, #adv_video_max_bitrate').parent().parent().hide();
		//$("#adv_video_buffer_size, #adv_video_gop, #adv_video_keyframe_intrval").parent().hide();
		$('#advance_video_ch').hide();
		$('.deinterlanc').hide();
		$('.latency').hide();
			$('#audio_codec,#audio_channel, #audio_bitrate, #audio_sample_rate').attr('disabled','disabled');
		$('.advance_vid_setting').hide();
		$('.enableAdvanceAudio').hide();
		$('.adv_audio').hide();
	}
	if(Action != "editEncoder")
	{
		$('#encoder_inputs, #encoder_output, #encoder_model').attr('disabled','disabled');
		$('#encoder_inputs').parent().find('.btn-default').attr("disabled","disabled");
		$('#encoder_output').parent().find('.btn-default').attr("disabled","disabled");
	}



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
			$('#advance_video_setting').prop('checked',false);
			/*$('#adv_video_min_bitrate, #adv_video_max_bitrate').parent().parent().hide();
			$("#adv_video_buffer_size, #adv_video_gop, #adv_video_keyframe_intrval").parent().hide();*/
			$('#advance_video_ch').hide();
			$('#video_codec,#video_resolution, #video_bitrate, #video_framerate, #video_min_bitrate, #video_max_bitrate').attr('disabled','disabled');
			$('#video_codec').parent().find('.dropdown-toggle').addClass('disabled');
			$('#video_resolution').parent().find('.dropdown-toggle').addClass('disabled');
		}
	});
	$(document).on('change','#advance_video_setting',function(){
		if($(this).is(':checked') == true)
		{
			/*$("#adv_video_min_bitrate").parent().parent().parent().show();
			$('#adv_video_max_bitrate').parent().parent().parent().show();
			$("#adv_video_buffer_size, #adv_video_gop, #adv_video_keyframe_intrval").parent().show();*/
			$('#advance_video_ch').show();
			$('.deinterlanc').show();
			$('.latency').show();
		}
		else if($(this).is(':checked') == false)
		{
			/*$("#adv_video_min_bitrate").parent().parent().parent().hide();
			$('#adv_video_max_bitrate').parent().parent().parent().hide();
			$("#adv_video_buffer_size, #adv_video_gop, #adv_video_keyframe_intrval").parent().hide();*/
			$('#advance_video_ch').hide();
			$('.deinterlanc').hide();
			$('.latency').hide();
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
$(document).on('change','.encinpus .multiselect-native-select ul li a label input[type=checkbox]',function(){
//$('#encoder_inputs').parent('.multiselect-native-select').find('ul li a label input[type=checkbox]').on('change',function(){

		if($('#encoder_model').val() == 1 || $('#encoder_model').val() == 6)
		{
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
		}
	});

	$(document).on('change','.oupout .multiselect-native-select ul li a label input[type=checkbox]',function(){

	//$('#encoder_output').parent('.multiselect-native-select').find('ul li a label input[type=checkbox]').on('change',function(){

		if($('#encoder_model').val() == 1 || $('#encoder_model').val() == 6)
		{
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
		}


		});

	/* Encoding Template end */


	/* Channels Start Stop */
	$(document).on('click','.channelscopy',function(){
	var appid = $(this).attr('id');
	var objj = $(this);
	var action = "";	var isPerform =0;
	var idd = appid.split('_');

	if(channelLocks[idd[1]] == 1)
	{
		toastr['warning']('You cant perform this action on locked Channel');
		return;
	}
	var permis = JSON.parse(userPermissions);
	if(permis.copy_channel == 0)
	{
		toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
		return;
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
				closeOnConfirm: true
			},
			function(){
				$.ajax({
			        url: baseURL + "admin/copyChannel",
			        data:{'appid':appid,'action':'delete'},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
							toastr['success'](jsonResponse.response);
							location.reload();
						}
			            if(jsonResponse.status == false)
			            {
			            	toastr['error'](jsonResponse.response);
						}
					},
			        error:function(){
			        	toastr['error']('Error occurred while performing actions');
					}
				});
			});
	}
	else
	{

	}

});
	$('.channelTable tr td .channelsstartstop').each(function(){

		return;
    	var thisObj = $(this);
		var channelId = $(this).attr("id");
		var className = $(this).find('i').attr("class");
		var cname = className.split(' ');
		var action ="checkstatus";


		$.ajax({
			        url: baseURL + "admin/channelStartStop",
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
	$('.channelTable tr td .channelsDelete').click(function(){

		var cobj = $(this);
		var thisObj = $(this);
		var channelId = $(this).attr("id");
		var ids = channelId.split('_');
		var permis = JSON.parse(userPermissions);
		if(channelLocks.length > 0)
		{
			if(channelLocks[ids[1]] == 1)
			{
				toastr['warning']('You cannot perform this action on locked channel');
				return;
			}
		}

		if(permis.delete_channel == 0)
		{
			toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
			return;
		}
		swal({
				title: "Are you sure?",
				text: "You want to delete this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes delete it!",
				closeOnConfirm: true
			},
		function(){

				$.ajax({
			        url: baseURL + "admin/channelDelete",
			        data:{'channelId':channelId,'action':'Delete'},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
							toastr['success']('Deleted Successfully');
							$(cobj).parent().parent().remove();
						}
			            if(jsonResponse.status == false)
			            {
			            	toastr['error'](jsonResponse.response);
						}

					},
			        error:function(){
			        	toastr['error']('Error occured while performing actions');
					}
				});
			});

    });
	$('.channelTable tr td .channelsstartstop').click(function(){

    	var thisObj = $(this);
		var channelId = $(this).attr("id");
		var className = $(this).find('i').attr("class");
		var cname = className.split(' ');
		var action ="";
		var permis = JSON.parse(userPermissions);
		var API_URL = "";
		if(cname[1] == "fa-play")
		{
			action = "Start";
			API_URL = "channels/start";
			if(permis.start_channel == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
		}
		else if(cname[1] == "fa-pause")
		{
			API_URL = "channels/stop";
			action = "Stop";
			if(permis.stop_channel == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
		}
		var idds = channelId.split('_');
		if(channelLocks[idds[1]] == 1)
		{
			toastr['warning']('You cant perform this action on locked channel!');
			return;
		}


		swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes " + action + " it!",
				closeOnConfirm: true
			},
		function(){
				$(thisObj).parent().parent().find("#status").removeAttr("class");
				$(thisObj).parent().parent().find("#status").addClass("label label-warning").text("Starting");
				$.ajax({
			        url: baseURL + API_URL,
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
								toastr['success'](jsonResponse.message);
								$(thisObj).parent().parent().find('.counter').attr('title',jsonResponse.time).removeClass("clr");
								var timer = setInterval(upTime, 1000);
								break;
								case "stop":
								$(thisObj).parent().parent().find("#status").removeAttr("class");
								$(thisObj).parent().parent().find("#status").addClass("label label-gray").text("Offline");
								$(thisObj).find("i").removeAttr("class");
								$(thisObj).find("i").addClass("fa fa-play");
								$(thisObj).parent().parent().find('.counter').text("00:00:00");
								$(thisObj).parent().parent().find('.counter').attr("title","").addClass("clr");
								toastr['success'](jsonResponse.message);
								//setTimeout(channelRefresh,5000);
								break;
							}
						}


			            if(jsonResponse.status == false)
			            {
							toastr['error']("Error occured while starting!");
							//setTimeout(channelRefresh,5000);
						}
						    //$('.loaddiv').hide();
    					//	$('body').css('overflow','scroll');
					},
			        error:function(){
			        		toastr['error']("Error occured while performing actions!");
			        	//	setTimeout(channelRefresh,5000);
			        		//$('.loaddiv').hide();
    						//$('body').css('overflow','scroll');
					}
				});
			});

    });

    $('.splayer').click(function(){

    	var thisObj = $(this);
		var channelId = $(this).attr("id");
		var className = $(this).text();
		var action ="";
		var API_URL ="";
		var permis = JSON.parse(userPermissions);
		if(className.trim() == "START")
		{
			action = "Start";
			API_URL = "channels/start";
			if(permis.start_channel == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
		}
		else if(className.trim() == "STOP")
		{
			action = "Stop";
			API_URL = "channels/stop";
			if(permis.stop_channel == 0)
			{
				toastr['warning']('You do not have permission to do this operation. Contact your system administrator.','Error! Insufficient Permissions');
				return;
			}
		}



		swal({
				title: "Are you sure?",
				text: "You want to " + action + " this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes " + action + " it!",
				closeOnConfirm: true
			},
		function(){
			 $('.loaddiv').show();
	    $('body').css('overflow','hidden');
	    $('.loaddiv').css('height',$(window).height());
				$.ajax({
			        url: baseURL + API_URL,
			        data:{'channelId':channelId,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {
			            	var idd = channelId.split('_');
							switch(jsonResponse.change)
							{
								case "start":
								$('#statusvideo').text("ONLINE").removeAttr('class').addClass('label label-live');

								$('.stpt').removeAttr("disabled");
								$('.strt').attr("disabled","disabled");
								toastr['success'](jsonResponse.message);
								window.history.pushState({}, "io Hub",  baseURL + 'updatechannel/' + idd[1] + '/live');
								break;
								case "stop":
								$('#statusvideo').text("OFFLINE").removeAttr('class').addClass('label label-gray');

								toastr['success'](jsonResponse.message);
								$('.strt').removeAttr("disabled");
								$('.stpt').attr("disabled","disabled");
								window.history.pushState({}, "io Hub",  baseURL + 'updatechannel/' + idd[1] + '/offline');
								break;
							}
						}


			            if(jsonResponse.status == false)
			            {
							toastr['error']("Error occured while starting!");
						}
						    $('.loaddiv').hide();
    						$('body').css('overflow','scroll');
					},
			        error:function(){
			        		toastr['error']("Error occured while performing actions!");
			        		$('.loaddiv').hide();
    						$('body').css('overflow','scroll');
					}
				});
			});

    });

	/* Channels Start Stop End*/

});
function openEditPage(URLL,objj){

	var st = $(objj).parent().parent().find("#status").html();

	if(st == "Offline" || st == "OFFLINE")
	{
		location.href = URLL + "/offline";
	}
	if(st == "Online" || st == "LIVE" || st == "ONLINE")
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
function upt()
{

}
 function upTime() {
 	$('.counter').each(function(){
 		var countTo = $(this).attr('title');
 		if(countTo != "" && countTo != "00:00:00:00")
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
			if(false == $(this).parent().hasClass("channelStartStopGateway"))
			{
				//$(this).html("");
			}

		}
 	});

}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgdiv').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function openNav() {
    //document.getElementById("mySidenav").style.width = "150px";
    $("#mySidenav").css({"right":"0px"});
}

function closeNav() {
    $("#mySidenav").css({"right":"-200px"});
}
function convertDateTime(d){
    dateTime = d.split(" ");

    var date = dateTime[0].split("/");
    var yyyy = date[2];
    var mm = date[1]-1;
    var dd = date[0];

    var time = dateTime[1].split(":");
    var h = time[0];
    var m = time[1];
    var s = parseInt(time[2]); //get rid of that 00.0;

    return new Date(yyyy,mm,dd,h,m);
}
