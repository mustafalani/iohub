var _settings = {};

var _popupElementId = "";
if(Action == "workflows")
{
	 $(window).on('beforeunload', function() {
   		var r = confirm("Are you sure you want to leave?");   		
   		if(r == false)
   		{
			$('.loaddiv').hide();	
			return false;
		}   			
   		else
   			return true;
	});	
}	

$(document).on('click','.cls_close_wf',function(){	
	var ID = $(this).parent().attr('id');
	delete _settings[ID];
	removeEle(encodersData.operators, ID);
	$('.summary_flow > .sum_data #'+ ID).remove();
	$('.workflow-drag-area').flowchart('deleteSelected');
});
$(document).ready(function(){
	
	$('.ch-uname-pub').hide();
	$('.ch-pass-pub').hide();
	$('.out-rtmp-url-pub').hide();
	$('.out-rtmp-key-pub').hide();
	 $('.workflow-drag-area').flowchart({
      data: encodersData,
      // allows to add links by clicking on lines
	  canUserEditLinks: true,
	  // enables drag and drop
	  canUserMoveOperators: true,
	  // custom data
	  data: {},
	  // distance between the output line and the link
	  distanceFromArrow: 3,
	  // default operator class
	  defaultOperatorClass: 'flowchart-default-operator',
	  // default color
	  defaultLinkColor: 'gray',
	  // default link color
	  defaultSelectedLinkColor: '#303030',
	  // width of the links
	  linkWidth: 10,
	  // <a href="https://www.jqueryscript.net/tags.php?/grid/">grid</a> of the operators when moved
	  grid: 20,
	  // allows multiple links on the same input line
	  multipleLinksOnOutput: true,
	  // allows multiple links on the same output line
	  multipleLinksOnInput: false,
	  // Allows to vertical decal the links (in case you override the CSS and links are not aligned with their connectors anymore).
	  linkVerticalDecal: 0,
	  // callbacks
	  onOperatorSelect: function (operatorId) {
	      return true;
	  },
	  onOperatorUnselect: function () {
	      return true;
	  },
	  onOperatorMouseOver: function (operatorId) {
	      return true;
	  },
	  onOperatorMouseOut: function (operatorId) {
	      return true;
	  },
	  onLinkSelect: function (linkId) {
	      return true;
	  },
	  onLinkUnselect: function () {
	      return true;
	  },
	  onOperatorCreate: function (operatorId, operatorData, fullElement) {
	      return true;
	  },
	  onLinkCreate: function (linkId, linkData) {
	      return true;
	  },
	  onOperatorDelete: function (operatorId) {
	      return true;
	  },
	  onLinkDelete: function (linkId, forced) {
	      return true;
	  },
	  onOperatorMoved: function (operatorId, position) {
	  },
	  onAfterChange: function (changeType) {
	  }
    });
    $(".input_box,.output_box").draggable();
    
    $('.workflow-drag-area').droppable({
	    tolerance: "intersect",
	    accept: ".input_box, .output_box, .gateway_box, .publisher_box, #facebook_box, .youtube_box, .twitch_box, .twitter_box, .wowzacdn_box, .TRG_RTMP_box, .TRG_MPEG_TS_box, .TRG_RTP_box, .TRG_SRT_box",
	    activeClass: "ui-state-default",
	    hoverClass: "ui-state-hover",
	    drop: function(event, ui) {	 
	    	var outputCount = 0;
	    	var obj = $(this);	   	
	    	var len = Object.keys(encodersData.operators).length;
	    	var start = 0;
	    	if(len==0)
	    	{
				start =1;
			}
			else
			{
				start=len+1;
			}
			var oprtid = '';
			if(ui.draggable[0].attributes.class.nodeValue.indexOf('input_box') !== -1)
			{
		    	for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "Input")
		    		{
						toastr['error']('You have drag one input');
						return;
					}
		    	}
		    	
				oprtid = 'Encoder_Input_'+ui.draggable[0].attributes.id.value+ '_' + start; 
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>" + "Input-" + ui.draggable[0].attributes.id.value + "</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				prop.channel_encoder=0;
				switch(ui.draggable[0].attributes.id.value)
				{
					case "sdi":
					prop.channel_input='';
					prop.channel_audioChannel = 0;
					break;
					case "ndi":
					prop.channel_isIPAddress=false;
					prop.channel_ipAddress='';
					prop.channel_ndiSource= '';
					break;
					case "rtmp":
					prop.channel_rtmpURL='';
					break;
					case "rtp":
					prop.channel_rtpURL='';
					break;
					case "udp":
					prop.channel_udpURL='';
					break;
					case "srt":
					prop.channel_srtURL='';
					break;
				}
				_settings[oprtid] = prop;		 
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: 'INPUT_' + ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {},outputs: {output_1: {label: ui.draggable[0].attributes.id.value.toUpperCase()}},id:'encoder_input_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('output_box') !== -1)
			{
				
				
				oprtid = 'Encoder_Output_'+ui.draggable[0].attributes.id.value+ '_' + start; 
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>" + "Output-" + ui.draggable[0].attributes.id.value + "</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				prop.channel_out_encoder=0;
				switch(ui.draggable[0].attributes.id.value)
				{
					case "sdi":
					prop.channel_output='';
					break;
					case "ndi":
					prop.channel_ndiname='';					
					break;
					case "rtmp":
					prop.channel_apps=0;
					prop.channel_rtmp_stream_url='';
					prop.channel_rtmp_stream_kay='';
					prop.channel_isuserAuth=false;
					prop.channel_authUsername='';
					prop.channel_authpassword='';
					prop.channel_encodingpreset=0;
					break;
					case "rtp":
					prop.channel_out_rtp_url='';					
					prop.channel_encodingpreset=0;
					break;
					case "udp":
					prop.channel_out_udp_url='';					
					prop.channel_encodingpreset=0;
					break;
					case "srt":
					prop.channel_out_srt_url='';					
					prop.channel_encodingpreset=0;
					break;
				}
				_settings[oprtid] = prop;
				if(ui.draggable[0].attributes.id.value == "sdi")
				{
					var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {multipleLinksOnOutput: true,title: 'OUTPUT_' + ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: ui.draggable[0].attributes.id.value.toUpperCase()}},outputs: {},id:'encoder_output_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				}	
				else
				{
					var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {multipleLinksOnOutput: true,title: 'OUTPUT_' + ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: ui.draggable[0].attributes.id.value.toUpperCase()}},outputs: {output_1: {label: 'OUTPUT'}},id:'encoder_output_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				} 
				
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('gateway_box') !== -1)
			{
				for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "Gateway" && t[2] == ui.draggable[0].attributes.id.value)
		    		{
						toastr['error']('You have already added this type of Gateway');
						return;
					}
		    	}
				oprtid = 'Encoder_Gateway_'+ui.draggable[0].attributes.id.value+ '_' + start; 
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>" + "Gateway" + "</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				prop.channel_out_encoder=0;
				prop.gateway_name="";
				prop.gateway_destination="";
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'GT_INPUT'}},outputs: {output_1: {label: 'OUTPUT'}},id:'encoder_gateway_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				_settings[oprtid] = prop;
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('publisher_box') !== -1)
			{
				for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "Publisher" && t[2] == ui.draggable[0].attributes.id.value)
		    		{
						toastr['error']('You have already added this type of Publisher');
						return;
					}
		    	}
				oprtid = 'Encoder_Publisher_'+ui.draggable[0].attributes.id.value+ '_' + start; 
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>" + "Publisher" + "</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				prop.publisher = 0;
				prop.channel_out_encoder=0;
				prop.channel_pub_apps="";
				prop.output_pub_rtmp_url="";
				prop.output_pub_rtmp_key="";
				prop.channel_auth_pub="";
				prop.pub_auth_uname="";
				prop.pub_auth_pass="";
				prop.pub_encoding_profile="";
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'PUB_INPUT'}},outputs: {output_1: {label: 'OUTPUT'}},id:'encoder_publisher_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				_settings[oprtid] = prop;
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('facebook_box') !== -1)
			{
				for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "Facebook")
		    		{
						toastr['error']('You have already added facebook target');
						return;
					}
		    	}
				oprtid = 'Target_Facebook_'+ui.draggable[0].attributes.id.value+ '_' + start;
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>" + "Facebook" + "</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				prop.channel_out_encoder=0;
				
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'FB_OUT'}},outputs: {},id:'target_facebook_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				_settings[oprtid] = prop;
			}			 
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('youtube_box') !== -1)
			{
				for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "Youtube")
		    		{
						toastr['error']('You have already added Youtube target');
						return;
					}
		    	}		    	
				oprtid = 'Target_Youtube_'+ui.draggable[0].attributes.id.value+ '_' + start;
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>" + "Youtube" + "</span>");
				
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'Youtube'}},outputs: {},id:'encoder_youtube_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				_settings[oprtid] = prop;
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('twitch_box') !== -1)
			{
				for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "Twitch")
		    		{
						toastr['error']('You have already added Twitch target');
						return;
					}
		    	}
				oprtid = 'Target_Twitch_'+ui.draggable[0].attributes.id.value+ '_' + start;
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>" + "Twitch" + "</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'Twitch'}},outputs: {},id:'encoder_twitch_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				_settings[oprtid] = prop;
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('twitter_box') !== -1)
			{
				for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "Twitter")
		    		{
						toastr['error']('You have already added Twitch target');
						return;
					}
		    	}
				oprtid = 'Target_Twitter_'+ui.draggable[0].attributes.id.value+ '_' + start;
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>Twitter</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'Twitter'}},outputs: {},id:'encoder_twitter_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				_settings[oprtid] = prop;
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('wowzacdn_box') !== -1)
			{
				for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "WowzaCDN")
		    		{
						toastr['error']('You have already added WowzaCDN target');
						return;
					}
		    	}
				oprtid = 'Target_WowzaCDN_'+ui.draggable[0].attributes.id.value+ '_' + start;
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>WowzaCDN</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'WowzaCDN'}},outputs: {},id:'encoder_wowzacdn_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				_settings[oprtid] = prop;
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('TRG_RTMP_box') !== -1)
			{
				for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "RTMP")
		    		{
						toastr['error']('You have already added RTMP target');
						return;
					}
		    	}
		    	
				oprtid = 'Target_RTMP_'+ui.draggable[0].attributes.id.value+ '_' + start;
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>RTMP</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'TRG_RTMP'}},outputs: {},id:'encoder_TRGRTMP_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				_settings[oprtid] = prop;
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('TRG_MPEG_TS_box') !== -1)
			{
				for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "MPEGTS")
		    		{
						toastr['error']('You have already added MPEGTSUDP target');
						return;
					}
		    	}
				oprtid = 'Target_MPEGTS_'+ui.draggable[0].attributes.id.value+ '_' + start;
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>MPEGTS</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'MPEGTS_INPUT'}},outputs: {},id:'encoder_TRGMPEGTS_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				_settings[oprtid] = prop;
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('TRG_RTP_box') !== -1)
			{
				for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "MPEGTSRTP")
		    		{
						toastr['error']('You have already added MPEGTSRTP target');
						return;
					}
		    	}
				oprtid = 'Target_MPEGTSRTP_'+ui.draggable[0].attributes.id.value+ '_' + start;
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>MPEGTSRTP</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'TRGRTP_INPUT'}},outputs: {},id:'encoder_TRGRTP_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				_settings[oprtid] = prop;
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('TRG_SRT_box') !== -1)
			{
				for(var key in encodersData.operators){
		    		var t = key.split('_');
		    		if(t[1] == "MPEGTSSRT")
		    		{
						toastr['error']('You have already added MPEGTSSRT target');
						return;
					}
		    	}
				oprtid = 'Target_MPEGTSSRT_'+ui.draggable[0].attributes.id.value+ '_' + start;
				$('.summary_flow > .sum_data').append("<span id='"+oprtid+"' class='apnd'>MPEGTSSRT</span>");
				var prop = {};
				prop.x = 0;
				prop.y =0;
				prop.settings = false;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'TRGSRT_INPUT'}},outputs: {},id:'encoder_TRGSRT_' + ui.draggable[0].attributes.id.value,name:oprtid}};
				_settings[oprtid] = prop;
			}
	    	encodersData.operators[oprtid] = encoderObject;
	    	$('.workflow-drag-area').flowchart('createOperator',oprtid , encoderObject);
			_popupElementId = oprtid;
			
			for(var key in encodersData.operators){
	    		var t = key.split('_');
	    		if(t[1] == "Output")
	    		{
	    			outputCount++;
				}
	    	}
			if(ui.draggable[0].attributes.class.nodeValue.indexOf('input_box') !== -1)
			{		    	
				switch(ui.draggable[0].attributes.id.value)
				{
					case "sdi":
						$('#workflow_sdiChannelPopup').modal('show');
						$('#channelInput').parent().find('.dropdown-menu').find('ul > li').show();
						$('#channel_input_Encoders').val("");
						$('#channelInput').val("");
						$('#sdi_audio_channel').val("");
						$('#channel_input_Encoders').selectpicker('refresh');
						$('#channelInput').selectpicker('refresh');
						$('#sdi_audio_channel').selectpicker('refresh');
						break;
						case "ndi":
						$('#channel_input_ndi_Encoders').val("");
						$('#channel_ndi_source').val("");
						$('#channel_input_ndi_Encoders').selectpicker('refresh');
						$('#channel_ndi_source').selectpicker('refresh');	
						$('#workflow_ndiChannelPopup').modal('show');					
						break;
						case "rtmp":
						$('#channel_input_rtmp_Encoders').val("");
						$('#channel_input_rtmp_Encoders').selectpicker('refresh');
						$('#input_rtmp_url').val("");
						$('#workflow_rtmpChannelPopup').modal('show');
						break;
						case "rtp":
						$('#channel_input_rtp_Encoders').val("");
						$('#channel_input_rtp_Encoders').selectpicker('refresh');
						$('#input_mpeg_rtp').val("");
						$('#workflow_rtpChannelPopup').modal('show');
						break;
						case "udp":
						$('#channel_input_udp_Encoders').val("");
						$('#channel_input_udp_Encoders').selectpicker('refresh');
						$('#input_mpeg_udp').val("");
						$('#workflow_udpChannelPopup').modal('show');
						break;
						case "srt":
						$('#channel_input_srt_Encoders').val("");
						$('#channel_input_srt_Encoders').selectpicker('refresh');
						$('#input_mpeg_srt').val("");
						$('#workflow_srtChannelPopup').modal('show');			
						break;
				}				
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('output_box') !== -1)
			{				
				switch(ui.draggable[0].attributes.id.value)
				{
					case "sdi":					
						$('#channelOutpue').parent().find('.dropdown-menu').find('ul > li').show();	
						if(outputCount > 1)
						{
							if($('#workflow_out_sdiChannelPopup #workflow_out_sdi_encoders').length <= 0)
							{
								var HTML_encdr = encodersList("workflow_out_sdi_encoders");						
								$(HTML_encdr).insertAfter('#workflow_out_sdiChannelPopup .apndendoers');
								$('#workflow_out_sdi_encoders').selectpicker('refresh');	
							}							
						}
						else
						{
							if($('#workflow_out_sdiChannelPopup #workflow_out_sdi_encoders').length > 0)
							{
								$('#workflow_out_sdiChannelPopup #workflow_out_sdi_encoders').parent().parent().remove();
							}
						}
						$('#workflow_out_sdiChannelPopup').modal('show');	
					break;
					case "ndi":										
						if(outputCount > 1)
						{
							if($('#workflow_out_ndiChannelPopup #workflow_out_ndi_encoders').length <= 0)
							{
								var HTML_encdr = encodersList("workflow_out_ndi_encoders");
								$(HTML_encdr).insertAfter('#workflow_out_ndiChannelPopup .apndendoers');
								$('#workflow_out_ndi_encoders').selectpicker('refresh');
							}
						}
						else
						{
							if($('#workflow_out_ndiChannelPopup #workflow_out_ndi_encoders').length > 0)
							{
								$('#workflow_out_ndiChannelPopup #workflow_out_ndi_encoders').parent().parent().remove();
							}
						}
						$('#workflow_out_ndiChannelPopup').modal('show');	
					break;
					case "rtmp":					
						if(outputCount > 1)
						{
							if($('#workflow_out_rtmpChannelPopup #workflow_out_rtmp_encoders').length <= 0)
							{
								var HTML_encdr = encodersList("workflow_out_rtmp_encoders");
								$(HTML_encdr).insertAfter('#workflow_out_rtmpChannelPopup .apndendoers');
								$('#workflow_out_rtmp_encoders').selectpicker('refresh');
							}
						}
						else
						{
							if($('#workflow_out_rtmpChannelPopup #workflow_out_rtmp_encoders').length > 0)
							{
								$('#workflow_out_rtmpChannelPopup #workflow_out_rtmp_encoders').parent().parent().remove();
							}
						}
						$('#workflow_out_rtmpChannelPopup').modal('show');
					break;
					case "rtp":
						if(outputCount > 1)
						{
							if($('#workflow_out_rtpChannelPopup #workflow_out_rtp_encoders').length <= 0)
							{
								var HTML_encdr = encodersList("workflow_out_rtp_encoders");
								$(HTML_encdr).insertAfter('#workflow_out_rtpChannelPopup .apndendoers');
								$('#workflow_out_rtp_encoders').selectpicker('refresh');
							}	
						}
						else
						{
							if($('#workflow_out_rtpChannelPopup #workflow_out_rtp_encoders').length > 0)
							{
								$('#workflow_out_rtpChannelPopup #workflow_out_rtp_encoders').parent().parent().remove();
							}
						}
						$('#workflow_out_rtpChannelPopup').modal('show');
					break;
					case "udp":
						if(outputCount > 1)
						{
							if($('#workflow_out_udpChannelPopup #workflow_out_udp_encoders').length <= 0)
							{
								var HTML_encdr = encodersList("workflow_out_udp_encoders");
								$(HTML_encdr).insertAfter('#workflow_out_udpChannelPopup .apndendoers');
								$('#workflow_out_udp_encoders').selectpicker('refresh');
							}	
						}
						else
						{
							if($('#workflow_out_udpChannelPopup #workflow_out_udp_encoders').length > 0)
							{
								$('#workflow_out_udpChannelPopup #workflow_out_udp_encoders').parent().parent().remove();
							}
						}
						$('#workflow_out_udpChannelPopup').modal('show');
					break;
					case "srt":
						if(outputCount > 1)
						{
							if($('#workflow_out_srtChannelPopup #workflow_out_srt_encoders').length <= 0)
							{
								var HTML_encdr = encodersList("workflow_out_srt_encoders");
								$(HTML_encdr).insertAfter('#workflow_out_srtChannelPopup .apndendoers');
								$('#workflow_out_srt_encoders').selectpicker('refresh');
							}	
						}
						else
						{
							if($('#workflow_out_srtChannelPopup #workflow_out_srt_encoders').length > 0)
							{
								$('#workflow_out_srtChannelPopup #workflow_out_srt_encoders').parent().parent().remove();
							}
						}
						$('#workflow_out_srtChannelPopup').modal('show');				
					break;
				}				
				
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('gateway_box') !== -1)
			{
				$('#workflow_gateway_Popup').modal('show');
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('publisher_box') !== -1)
			{
				$('#workflow_publisher_Popup').modal('show');
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('facebook_box') !== -1)
			{
				var u = baseURL + 'admin/fb';
				popitup(u,"IOHUB - Facebook");
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('youtube_box') !== -1)
			{
				var u = baseURL + 'admin/googlelogin';
				popitup(u,"IOHUB - Youtube");
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('twitch_box') !== -1)
			{
				var u = baseURL + 'twitch';
				popitup(u,"IOHUB - Twitch");
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('twitter_box') !== -1)
			{
				var u = baseURL + 'admin/twitter';
				popitup(u,"IOHUB - Twitter");
			}
			 
	    }
	});
    init_events($('div.input_box'));
    init_events($('div.output_box'));
    init_events($('div.gateway_box'));
    init_events($('div.publisher_box'));
    init_events($('#facebook_box'));
    
    init_events($('#youtube_box'));
    init_events($('#twitch_box'));
    init_events($('#twitter_box'));
    init_events($('#wowzacdn_box'));
    init_events($('#TRG_RTMP_box'));
    init_events($('#TRG_MPEG_TS_box'));
    init_events($('#TRG_RTP_box'));
    init_events($('#TRG_SRT_box'));
});

function workflow_settings(_boxType,id)
{
	_popupElementId = "";
	_popupElementId = id;
	switch(_boxType)
	{
		case "input_sdi":
		if(_settings[_popupElementId].settings == true)
		{
			$('#channel_input_Encoders').val(_settings[_popupElementId].channel_encoder);
			$('#channelInput').val(_settings[_popupElementId].channel_input );
			$('#sdi_audio_channel').val(_settings[_popupElementId].channel_audioChannel);
			$('#channel_input_Encoders').selectpicker('refresh');
			$('#channelInput').selectpicker('refresh');
			$('#sdi_audio_channel').selectpicker('refresh');
		}		
		$('#channelInput').parent().find('.dropdown-menu').find('ul > li').show();		
		$('#workflow_sdiChannelPopup').modal('show');
		break;
		case "input_ndi":
		if(_settings[_popupElementId].settings == true)
		{
			$('#channel_input_ndi_Encoders').val(_settings[_popupElementId].channel_encoder);
			$('#ip_addresses_comma').val(_settings[_popupElementId].channel_ipAddress);
			if(_settings[_popupElementId].channel_isIPAddress == 1)
			{
				$('#wf_isIPAddress').prop('checked',true);
			}			
			$('#channel_ndi_source').val(_settings[_popupElementId].channel_ndiSource);			
			$('#channel_input_ndi_Encoders').selectpicker('refresh');
			$('#channel_ndi_source').selectpicker('refresh');			
		}	
		$('#workflow_ndiChannelPopup').modal('show');
		break;
		case "input_rtmp":
		if(_settings[_popupElementId].settings == true)
		{
			$('#channel_input_rtmp_Encoders').val(_settings[_popupElementId].channel_encoder);
			$('#input_rtmp_url').val(_settings[_popupElementId].channel_rtmpURL);			
			$('#channel_input_rtmp_Encoders').selectpicker('refresh');						
		}	
		$('#workflow_rtmpChannelPopup').modal('show');		
		break;
		case "input_rtp":
		if(_settings[_popupElementId].settings == true)
		{			
			$('#channel_input_rtp_Encoders').val(_settings[_popupElementId].channel_encoder);
			$('#input_mpeg_rtp').val(_settings[_popupElementId].channel_rtpURL);			
			$('#channel_input_rtp_Encoders').selectpicker('refresh');						
		}
		$('#workflow_rtpChannelPopup').modal('show');
		break;
		case "input_udp":
		if(_settings[_popupElementId].settings == true)
		{			
			$('#channel_input_udp_Encoders').val(_settings[_popupElementId].channel_encoder);
			$('#input_mpeg_udp').val(_settings[_popupElementId].channel_udpURL);			
			$('#channel_input_udp_Encoders').selectpicker('refresh');						
		}
		$('#workflow_udpChannelPopup').modal('show');
		break;
		case "input_srt":
		if(_settings[_popupElementId].settings == true)
		{	
			$('#channel_input_srt_Encoders').val(_settings[_popupElementId].channel_encoder);
			$('#input_mpeg_srt').val(_settings[_popupElementId].channel_srtURL);			
			$('#channel_input_srt_Encoders').selectpicker('refresh');						
		}
		$('#workflow_srtChannelPopup').modal('show');
		break;
		case "output_sdi":
		if(_settings[_popupElementId].settings == true)
		{
			if(_settings[_popupElementId].channel_out_encoder > 0)
			{
				$('#workflow_out_sdi_encoders').val(_settings[_popupElementId].channel_out_encoder);
				$('#workflow_out_sdi_encoders').selectpicker('refresh');
			}
			$('#channelOutpue').val(_settings[_popupElementId].channel_output);					
			$('#channelOutpue').selectpicker('refresh');						
		}
		$('#channelOutpue').parent().find('.dropdown-menu').find('ul > li').show();		
		$('#workflow_out_sdiChannelPopup').modal('show');
		break;
		case "output_ndi":
		if(_settings[_popupElementId].settings == true)
		{
			if(_settings[_popupElementId].channel_out_encoder > 0)
			{
				$('#workflow_out_ndi_encoders').val(_settings[_popupElementId].channel_out_encoder);
				$('#workflow_out_ndi_encoders').selectpicker('refresh');
			}			
			$('#ndi_name').val(_settings[_popupElementId].channel_ndiname);	
		}
		$('#workflow_out_ndiChannelPopup').modal('show');
		break;
		case "output_rtmp":
		if(_settings[_popupElementId].settings == true)
		{
			if(_settings[_popupElementId].channel_out_encoder > 0)
			{
				$('#workflow_out_rtmp_encoders').val(_settings[_popupElementId].channel_out_encoder);
				$('#workflow_out_rtmp_encoders').selectpicker('refresh');
			}
			$('#channel_apps').val(_settings[_popupElementId].channel_apps);
		    $('#output_rtmp_url').val(_settings[_popupElementId].channel_rtmp_stream_url);
			$('#output_rtmp_key').val(_settings[_popupElementId].channel_rtmp_stream_kay);
			if(_settings[_popupElementId].channel_isuserAuth > 0)
			{
				$('#channel-auth').prop('checked',true);
				$('#auth_uname').val(_settings[_popupElementId].channel_authUsername);
				$('#auth_pass').val(_settings[_popupElementId].channel_authpassword);
			}
			$('#encoding_profile').val(_settings[_popupElementId].channel_encodingpreset);
		}
		$('#workflow_out_rtmpChannelPopup').modal('show');
		break;
		case "output_rtp":
		if(_settings[_popupElementId].settings == true)
		{
			if(_settings[_popupElementId].channel_out_encoder > 0)
			{
				$('#workflow_out_rtp_encoders').val(_settings[_popupElementId].channel_out_encoder);
				$('#workflow_out_rtp_encoders').selectpicker('refresh');
			}
			$('#output_mpeg_rtp').val(_settings[_popupElementId].channel_out_rtp_url);
			$('#encoding_profile_rtp').val(_settings[_popupElementId].channel_encodingpreset);			
		}
		$('#workflow_out_rtpChannelPopup').modal('show');		
		break;
		case "output_udp":
		if(_settings[_popupElementId].settings == true)
		{
			if(_settings[_popupElementId].channel_out_encoder > 0)
			{
				$('#workflow_out_udp_encoders').val(_settings[_popupElementId].channel_out_encoder);
				$('#workflow_out_udp_encoders').selectpicker('refresh');
			}
			$('#output_mpeg_udp').val(_settings[_popupElementId].channel_out_udp_url);
			$('#encoding_profile_udp').val(_settings[_popupElementId].channel_encodingpreset);			
		}
		$('#workflow_out_udpChannelPopup').modal('show');
		break;
		case "output_srt":
		if(_settings[_popupElementId].settings == true)
		{
			if(_settings[_popupElementId].channel_out_encoder > 0)
			{
				$('#workflow_out_srt_encoders').val(_settings[_popupElementId].channel_out_encoder);
				$('#workflow_out_srt_encoders').selectpicker('refresh');
			}			
			$('#output_mpeg_srt').val(_settings[_popupElementId].channel_out_srt_url);
			$('#encoding_profile_srt').val(_settings[_popupElementId].channel_encodingpreset);			
		}
		$('#workflow_out_srtChannelPopup').modal('show');
		break;
		case "gateway_gateway":
		if(_settings[_popupElementId].settings == true)
		{
			$('#gateway_destination').val(_settings[_popupElementId].gateway_destination);
			$('#gateway_destination').selectpicker('refresh');			
		}
		$('#workflow_gateway_Popup').modal('show');
		break;
		case "publishers_publisher":
		$('#workflow_publisher_Popup').modal('show');
		break;
		case "TRG_facebook":
		$('#workflow_facebook_targetPopup').modal('show');
		break;
		case "TRG_youtube":
		$('#workflow_youtube_targetPopup').modal('show');
		break;
		case "TRG_twitch":
		$('#workflow_twitch_targetPopup').modal('show');
		break;
		case "TRG_twitter":
		$('#workflow_twitter_targetPopup').modal('show');
		break;
		case "TRG_wowzadcn":
		alert(_boxType);
		break;
		case "TRG_wowzadcn":
		alert(_boxType);
		break;
		case "TRG_wowzadcn":
		alert(_boxType);
		break;
		case "TRG_wowzadcn":
		alert(_boxType);
		break;
		case "TRG_wowzadcn":
		alert(_boxType);
		break;
	}
}
$(document).on('change','#wf_isIPAddress',function(){		
		
	if($(this).is(":checked") == true)
	{
		$('.ipss > input[type="text"]').val("");
		$('.ipss > input[type="text"]').removeAttr("disabled");	
	}
	else if($(this).is(":checked") == false)
	{
		$('.ipss > input[type="text"]').val("");	
		$('.ipss > input[type="text"]').attr("disabled","disabled");	
	}
});
/*=============================================================================================*/

/* Save Popups Start */
$(document).on('click','.save_wf_SDI',function(){	
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{
		if($('#channel_input_Encoders').val() == "")
		{
			toastr['error']('Please select Encoder');
			return false;
		}
		if($('#channelInput').val() == "")
		{
			toastr['error']('Please select Input');
			return false;
		}
		if($('#sdi_audio_channel').val() == "" || $('#sdi_audio_channel').val() <=0)
		{
			toastr['error']('Please select audio input');
			return false;
		}
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;
		_settings[_popupElementId].channel_encoder=$('#channel_input_Encoders').val();
		_settings[_popupElementId].channel_input = $('#channelInput').val();
		_settings[_popupElementId].channel_audioChannel = $('#sdi_audio_channel').val();
		
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#channel_input_Encoders').val("");
			$('#channelInput').val("");
			$('#sdi_audio_channel').val("");
			$('#channel_input_Encoders').selectpicker('refresh');
			$('#channelInput').selectpicker('refresh');
			$('#sdi_audio_channel').selectpicker('refresh');
			$('#workflow_sdiChannelPopup').modal('hide');
			
	    }, 2000);
	}
});
$(document).on('click','.save_WF_NDI',function(){
	
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{
		if($('#channel_input_ndi_Encoders').val() == "")
		{
			toastr['error']('Please select Encoder');
			return false;
		}
		if($("#wf_isIPAddress").is(":checked") == true)
		{
			if($('#ip_addresses_comma').val() == "")
			{
				toastr['error']('Please enter IP address');
				return false;
			}	
		}
		if($('#channel_ndi_source').val() == "")
		{
			toastr['error']('Please select NDI source');
			return false;	
		}
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;
		_settings[_popupElementId].channel_encoder = $('#channel_input_ndi_Encoders').val();
		_settings[_popupElementId].channel_ipAddress = $('#ip_addresses_comma').val();
		_settings[_popupElementId].channel_isIPAddress = $('#wf_isIPAddress').val();	
		_settings[_popupElementId].channel_ndiSource = $('#channel_ndi_source').val();
		
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#channel_input_ndi_Encoders').val("");
			$('#channel_ndi_source').val("");
			$('#channel_input_ndi_Encoders').selectpicker('refresh');
			$('#channel_ndi_source').selectpicker('refresh');	
			$('#workflow_ndiChannelPopup').modal('hide');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_RTMP',function(){	
	
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{			
		if($('#channel_input_rtmp_Encoders').val() == "")
		{
			toastr['error']('Please select encoder first');
			return false;	
		}	
		if($('#input_rtmp_url').val() == "")
		{
			toastr['error']('Please enter RTMP URL');
			return false;	
		}
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;
		_settings[_popupElementId].channel_encoder = $('#channel_input_rtmp_Encoders').val();
		_settings[_popupElementId].channel_rtmpURL = $('#input_rtmp_url').val();
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#channel_input_rtmp_Encoders').val("");
			$('#channel_input_rtmp_Encoders').selectpicker('refresh');
			$('#input_rtmp_url').val("");
			$('#workflow_rtmpChannelPopup').modal('hide');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_RTP',function(){
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{			
		if($('#channel_input_rtp_Encoders').val() == "")
		{
			toastr['error']('Please select encoder first');
			return false;	
		}	
		if($('#input_mpeg_rtp').val() == "")
		{
			toastr['error']('Please enter RTP URL');
			return false;	
		}
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;
		_settings[_popupElementId].channel_encoder = $('#channel_input_rtp_Encoders').val();
		_settings[_popupElementId].channel_rtpURL = $('#input_mpeg_rtp').val();
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#channel_input_rtp_Encoders').val("");
			$('#channel_input_rtp_Encoders').selectpicker('refresh');
			$('#input_mpeg_rtp').val("");
			$('#workflow_rtpChannelPopup').modal('hide');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_UDP',function(){
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{			
		if($('#channel_input_udp_Encoders').val() == "")
		{
			toastr['error']('Please select encoder first');
			return false;	
		}	
		if($('#input_mpeg_udp').val() == "")
		{
			toastr['error']('Please enter UDP URL');
			return false;	
		}
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;
		_settings[_popupElementId].channel_encoder = $('#channel_input_udp_Encoders').val();
		_settings[_popupElementId].channel_udpURL = $('#input_mpeg_udp').val();
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#channel_input_udp_Encoders').val("");
			$('#channel_input_udp_Encoders').selectpicker('refresh');
			$('#input_mpeg_udp').val("");
			$('#workflow_udpChannelPopup').modal('hide');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_SRT',function(){
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{			
		if($('#channel_input_srt_Encoders').val() == "")
		{
			toastr['error']('Please select encoder first');
			return false;	
		}	
		if($('#input_mpeg_srt').val() == "")
		{
			toastr['error']('Please enter SRT URL');
			return false;	
		}
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;
		_settings[_popupElementId].channel_encoder = $('#channel_input_srt_Encoders').val();
		_settings[_popupElementId].channel_srtURL = $('#input_mpeg_srt').val();
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#channel_input_srt_Encoders').val("");
			$('#channel_input_srt_Encoders').selectpicker('refresh');
			$('#input_mpeg_srt').val("");
			$('#workflow_srtChannelPopup').modal('hide');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_out_SDI',function(){
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{			
		if($('#workflow_out_sdi_encoders').length > 0)
		{
			if($('#workflow_out_sdi_encoders').val() == "")
			{
				toastr['error']('Please select Encoder');
				return false;	
			}	
		}
		if($('#channelOutpue').val() == "")
		{
			toastr['error']('Please select Output first');
			return false;	
		}
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;		
		_settings[_popupElementId].channel_output = $('#channelOutpue').val();
		if($('#workflow_out_sdi_encoders').length > 0)
		{
			_settings[_popupElementId].channel_out_encoder = $('#workflow_out_sdi_encoders').val();
		}
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#workflow_out_sdiChannelPopup').modal('hide');
			
			if($('#workflow_out_sdi_encoders').length > 0)
			{
				$('#workflow_out_sdi_encoders').val("");
				$('#workflow_out_sdi_encoders').selectpicker('refresh');			
			}			
			$('#channelOutpue').val("");
			$('#channelOutpue').selectpicker('refresh');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_out_NDI',function(){
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{			
		if($('#workflow_out_ndi_encoders').length > 0)
		{
			if($('#workflow_out_ndi_encoders').val() == "")
			{
				toastr['error']('Please select Encoder');
				return false;	
			}	
		}
		if($('#ndi_name').val() == "")
		{
			toastr['error']('Please enter NDI name.');
			return false;	
		}
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;		
		if($('#workflow_out_ndi_encoders').length > 0)
		{
			_settings[_popupElementId].channel_out_encoder = $('#workflow_out_ndi_encoders').val();
		}
		_settings[_popupElementId].channel_ndiname = $('#ndi_name').val();
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#workflow_out_ndiChannelPopup').modal('hide');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_out_RTMP',function(){
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{			
		if($('#workflow_out_rtmp_encoders').length > 0)
		{
			if($('#workflow_out_rtmp_encoders').val() == "")
			{
				toastr['error']('Please select Encoder');
				return false;	
			}	
		}
		if($('#channel_apps').val() == "")
		{
			toastr['error']('Please select application.');
			return false;	
		}
		if($('#output_rtmp_url').val() == "")
		{
			toastr['error']('Please enter RTMP URL.');
			return false;	
		}
		if($('#output_rtmp_key').val() == "")
		{
			toastr['error']('Please enter RTMP key.');
			return false;	
		}
		if($('#channel-auth').is(':checked') == true)
		{
			if($('#auth_uname').val() == "")
			{
				toastr['error']('Please enter username.');
				return false;	
			}
			if($('#auth_pass').val() == "")
			{
				toastr['error']('Please enter password.');
				return false;	
			}
		}		
		if($('#encoding_profile').val() == "")
		{
			toastr['error']('Please select encoding preset.');
			return false;	
		}
		
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;	
		if($('#workflow_out_rtmp_encoders').length > 0)
		{
			_settings[_popupElementId].channel_out_encoder = $('#workflow_out_rtmp_encoders').val();
		}
		_settings[_popupElementId].channel_apps = $('#channel_apps').val();
		_settings[_popupElementId].channel_rtmp_stream_url = $('#output_rtmp_url').val();
		_settings[_popupElementId].channel_rtmp_stream_kay = $('#output_rtmp_key').val();
		_settings[_popupElementId].channel_isuserAuth = $('#channel-auth').val();
		_settings[_popupElementId].channel_authUsername = $('#auth_uname').val();
		_settings[_popupElementId].channel_authpassword = $('#auth_pass').val();
		_settings[_popupElementId].channel_encodingpreset = $('#encoding_profile').val();
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#workflow_out_rtmpChannelPopup').modal('hide');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_out_RTP',function(){
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{			
		if($('#workflow_out_rtp_encoders').length > 0)
		{
			if($('#workflow_out_rtp_encoders').val() == "")
			{
				toastr['error']('Please select Encoder');
				return false;	
			}	
		}
		if($('#output_mpeg_rtp').val() == "")
		{
			toastr['error']('Please enter RTP URL.');
			return false;	
		}
		if($('#encoding_profile_rtp').val() == "")
		{
			toastr['error']('Please select encoding preset.');
			return false;	
		}
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;		
		if($('#workflow_out_rtp_encoders').length > 0)
		{
			_settings[_popupElementId].channel_out_encoder = $('#workflow_out_rtp_encoders').val();
		}
		_settings[_popupElementId].channel_out_rtp_url = $('#output_mpeg_rtp').val();
		_settings[_popupElementId].channel_encodingpreset = $('#encoding_profile_rtp').val();
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#workflow_out_rtpChannelPopup').modal('hide');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_out_UDP',function(){
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{			
		if($('#workflow_out_udp_encoders').length > 0)
		{
			if($('#workflow_out_udp_encoders').val() == "")
			{
				toastr['error']('Please select Encoder');
				return false;	
			}	
		}
		if($('#output_mpeg_udp').val() == "")
		{
			toastr['error']('Please enter UDP URL.');
			return false;	
		}
		if($('#encoding_profile_udp').val() == "")
		{
			toastr['error']('Please select encoding preset.');
			return false;	
		}
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;	
		if($('#workflow_out_udp_encoders').length > 0)
		{
			_settings[_popupElementId].channel_out_encoder = $('#workflow_out_udp_encoders').val();
		}	
		_settings[_popupElementId].channel_out_udp_url = $('#output_mpeg_udp').val();
		_settings[_popupElementId].channel_encodingpreset = $('#encoding_profile_udp').val();
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#workflow_out_udpChannelPopup').modal('hide');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_out_SRT',function(){
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{			
		if($('#workflow_out_srt_encoders').length > 0)
		{
			if($('#workflow_out_srt_encoders').val() == "")
			{
				toastr['error']('Please select Encoder');
				return false;	
			}	
		}
		if($('#output_mpeg_srt').val() == "")
		{
			toastr['error']('Please enter UDP URL.');
			return false;	
		}
		if($('#encoding_profile_srt').val() == "")
		{
			toastr['error']('Please select encoding preset.');
			return false;	
		}
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;		
		if($('#workflow_out_srt_encoders').length > 0)
		{
			_settings[_popupElementId].channel_out_encoder = $('#workflow_out_srt_encoders').val();
		}
		_settings[_popupElementId].channel_out_srt_url = $('#output_mpeg_srt').val();
		_settings[_popupElementId].channel_encodingpreset = $('#encoding_profile_srt').val();
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#workflow_out_srtChannelPopup').modal('hide');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_gateway',function(){
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{			
		if($('#gateway_destination').val() == "")
		{
			toastr['error']('Please enter UDP URL.');
			return false;	
		}		
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;
		_settings[_popupElementId].gateway_destination = $('#gateway_destination').val();
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#workflow_gateway_Popup').modal('hide');
	    }, 2000);
	}
});
$(document).on('click','.save_wf_publisher',function(){
	var obj = $(this);
	if(_settings[_popupElementId].settings == true)
	{
		toastr['info']('Already Saved! Dont Refresh Until Saved Workflow');
	}
	else if(_settings[_popupElementId].settings == false)
	{	
		if($('#channel_publisher').val() == "")
		{
			toastr['error']('Please select Publisher');
			return false;	
		}				
		if($('#channel_pub_apps').val() == "")
		{
			toastr['error']('Please select application.');
			return false;	
		}
		if($('#output_pub_rtmp_url').val() == "")
		{
			toastr['error']('Please enter RTMP URL.');
			return false;	
		}
		if($('#output_pub_rtmp_key').val() == "")
		{
			toastr['error']('Please enter RTMP key.');
			return false;	
		}
		if($('#channel-auth-pub').is(':checked') == true)
		{
			if($('#pub_auth_uname').val() == "")
			{
				toastr['error']('Please enter username.');
				return false;	
			}
			if($('#pub_auth_pass').val() == "")
			{
				toastr['error']('Please enter password.');
				return false;	
			}
		}		
		if($('#pub_encoding_profile').val() == "")
		{
			toastr['error']('Please select encoding preset.');
			return false;	
		}
		
		$(this).parent().find('a').find('i').remove();
		$(this).parent().find('a').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/>");
		
		_settings[_popupElementId].settings = true;				
		_settings[_popupElementId].publisher = $('#channel_publisher').val();
		_settings[_popupElementId].channel_pub_apps = $('#channel_pub_apps').val();
		_settings[_popupElementId].output_pub_rtmp_url = $('#output_pub_rtmp_url').val();
		_settings[_popupElementId].output_pub_rtmp_key = $('#output_pub_rtmp_key').val();
		_settings[_popupElementId].channel_auth_pub = $('#channel-auth-pub').val();
		_settings[_popupElementId].pub_auth_uname = $('#pub_auth_uname').val();
		_settings[_popupElementId].pub_auth_pass = $('#pub_auth_pass').val();
		_settings[_popupElementId].pub_encoding_profile = $('#pub_encoding_profile').val();
		setTimeout(function(){
	        $(obj).parent().find('a').find('img').remove();	
			$(obj).parent().find('a').html("<i class='fa fa-gear iconn'></i>");
			toastr['success']('Values Saved! Dont Refresh Until Saved Workflow');
			$('#workflow_publisher_Popup').modal('hide');
	    }, 2000);
	}
});

/* Save Popups End */

/*=============================================================================================*/

/* Input Encoder Selection */
$(document).on('change','#channel_input_Encoders',function(){

	var inpHtml = "<option value=''>- Select Input -</option>";
	$('#channelInput').html(inpHtml);
	$('#channelInput').selectpicker('refresh');
	var OutHtml = "<option value=''>- Select Output -</option>";	
	$('#channelOutpue').html(OutHtml);
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
			$('#channelOutpue').html(OutHtml);
			$('#channelOutpue').selectpicker('refresh');
		},
		error:function(){

		}
	});

});

var removeEle = function(data,id){
	for(var key in data){
		if(key == id)
		{
			delete encodersData.operators[key];
		}
	}
};
$(document).on('click','.saveWorkflow',function(){	
	if($('#workflow_name').val() == "")
	{
		toastr['error']('Please enter Workflow Name.');
			return false;
	}
	var o = $(this);
	var isReady = true;
	if(Object.keys(_settings).length > 0)
	{
		for(var key in _settings)
		{
			if(key !== "links")
			{
				if(_settings[key].settings == false)
				{
					isReady = false;
				}
			}
		}
		if(isReady === true)
		{
				swal({
					title: "Are you sure?",
					text: "You want to Apply!",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Yes, Apply it!",
					closeOnConfirm: true
				},
				function(){
						var WFID = window.location.pathname.split("/").pop();

						$(this).find('span').html("<img style='width: 38px;' src='"+baseURL +"assets/site/main/img/channel-loading.gif'/> Apply");
						$(this).css({'width':'124px','padding-top':'0px !important','padding-bottom':'0px !important'});					
						_settings['wfid'] = WFID;
						_settings['wfname'] = $('#workflow_name').val();
						$.ajax({
							url: baseURL + "workflow/create",
							data:{_settings},
							type:'post',							
							dataType:'json',
							success:function(jsonResponse){
								if(jsonResponse.status == true)
								{
									toastr['success']('Workflow Saveed Successfully!');
								}
								$(o).find('span').html("Save");
							},
							error:function(){
								toastr['error']('Error occured while performing actions');
								$(o).find('span').html("Save");
							}
						});
				});
		}
		else
		{
			toastr['error']('Please complete workflow settings before submit.');
			return false;
		}
	}
	else
	{
		toastr['error']('Please create workflow before submit.');
		return false;
	}
});
var encodersList = function(encID){
	var encdrList = "";
	encdrList += "<div class='form-group'>";
    encdrList += "<label>Encoders <span class='mndtry'>*</span></label>";
    encdrList += "<select class='form-control selectpicker' name='"+encID+"' id='"+encID+"' required='true'>";
    encdrList += "<option value=''>- Select Encoder -</option>"; 
    for(var i=0; i<allEncoders.length; i++)
    {    	
    	var obj = JSON.parse(allEncoders[i]);    	
		encdrList += "<option id='enc_" + obj.id +"' tabindex='"+(i+1)+"' label='phyinput' value='phyinput_" + obj.id +"'>" + obj.encoder_name +"</option>";
	}
    encdrList += "</select>";                  
    encdrList += "</div>";
    return encdrList;
}
$(document).on('change','#channel_publisher',function(){
	if($(this).val() != "")
	{
		var wid = $(this).val();
		$.ajax({
			url: baseURL + "workflow/getApplicationsbyPublisher",
			data:{'id':wid},
			type:'post',							
			dataType:'json',
			success:function(jsonResponse){
				if(jsonResponse.status == true)
				{
					var ht = "<option value=''>-- Select --</option>";
					console.log(jsonResponse.data.length);
					for(var i=0; i<jsonResponse.data.length; i++)
					{
						ht += "<option id='"+ jsonResponse.data[i].wowza_path +"' value='" + jsonResponse.data[i].id +"'>" + jsonResponse.data[i].application_name + "</option>";	
					}
					$('#channel_pub_apps').html(ht);
					$('#channel_pub_apps').selectpicker('refresh');	
				}
				else
				{
					$('#channel_pub_apps').html("");
					$('#channel_pub_apps').selectpicker('refresh');
				}				
			},
			error:function(){
				toastr['error']('Error occured while performing actions');
				$('#channel_pub_apps').html("");
				$('#channel_pub_apps').selectpicker('refresh');				
			}
		});
	}
	else
	{
		$('#channel_pub_apps').html("");
		$('#channel_pub_apps').selectpicker('refresh');	
	}
});
$(document).on('change','#channel_pub_apps',function(){
	var appId = $(this).val();
	if(appId != -2 && appId != "")
	{
		var streamURL = $(this).find('option[value="'+appId +'"]').attr("id");
		var streamURLArray = streamURL.split('/');
		var streamURI = streamURLArray[streamURLArray.length-2];
		var streamName = streamURLArray[streamURLArray.length-1];
		$('.out-rtmp-url-pub').show();
		var URRR = "rtmp://" + streamURLArray[streamURLArray.length-3] +"/" + streamURLArray[streamURLArray.length-2];

		$('.out-rtmp-key-pub').show();
		$('.out-rtmp-key-pub > input[type=text]').val(streamName);
		$('.out-rtmp-url-pub > input[type=text]').val(URRR);
	}
	else
	{
		if(appId == -2)
		{
			$('.out-rtmp-url-pub').show();
			$('.out-rtmp-key-pub').show();
			$('.out-rtmp-key-pub > input[type=text]').val("");
		$('.out-rtmp-url-pub > input[type=text]').val("");
		}
		else
		{
			$('.out-rtmp-url-pub').hide();
			$('.out-rtmp-key-pub').hide();
		}
	}
});
$(document).on('change','#channel-auth-pub',function(){
	$('.ch-uname-pub > input[type="text"]').val("");
	$('.ch-pass-pub > input[type="text"]').val("");
	if($(this).is(":checked") == true)
	{
		$('.ch-uname-pub').show();
		$('.ch-pass-pub').show();
	}
	else if($(this).is(":checked") == false)
	{
		$('.ch-uname-pub').hide();
		$('.ch-pass-pub').hide();
	}
});
function popitup(url,windowName) {
	newwindow=window.open(url,windowName,'directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=0,height=1000,width=800');
	if (window.focus) {newwindow.focus()}
	return false;
}
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
$(document).on('click','#WFfind_NDISources',function(){
	var txt = "NULL";
	var obj = $(this);
	$(this).find('i').remove();
	if($("#wf_isIPAddress").is(":checked") == true)
	{
		if($("#ip_addresses_comma").val() !== "")
		{
			txt = $("#ip_addresses_comma").val();
		}
	}
	if($("#channel_input_ndi_Encoders").val() == "" || $("#channel_input_ndi_Encoders").val() <= 0)
	{
		toastr['error']('Please Select Encoder First.');
		return;
	}
	$(this).html("<img style='float:right;' src='"+baseURL +"assets/site/main/images/loadSource.gif'/>");
	var Ecid = $("#channel_input_ndi_Encoders").val();

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
					toastr['error']("Error occured while performing actions");
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
document.addEventListener('keydown', function(event) {
    const key = event.key; // const {key} = event; ES6+
    if (key === "Delete") {
        $('.workflow-drag-area').flowchart('deleteSelected');
    }
});