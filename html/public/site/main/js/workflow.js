var _settings = [];
$(document).on('click','.cls_close_wf',function(){	
	var ID = $(this).parent().attr('id');
	//removeByAttr(encodersData.operators, ID, 1);
	$('.workflow-drag-area').flowchart('deleteSelected');
});
$(document).ready(function(){
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
	  defaultLinkColor: '#3366ff',
	  // default link color
	  defaultSelectedLinkColor: 'black',
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
				oprtid = 'Encoder_Input_'+ui.draggable[0].attributes.id.value+ '_' + start; 
				var prop = {};
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
				var prop = {};
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
				oprtid = 'Encoder_Gateway_'+ui.draggable[0].attributes.id.value+ '_' + start; 
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'GT_INPUT'}},outputs: {output_1: {label: 'OUTPUT'}},id:'encoder_gateway_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('publisher_box') !== -1)
			{
				oprtid = 'Encoder_Publisher_'+ui.draggable[0].attributes.id.value+ '_' + start; 
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'PUB_INPUT'}},outputs: {output_1: {label: 'OUTPUT'}},id:'encoder_publisher_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('facebook_box') !== -1)
			{
				oprtid = 'Target_Facebook_'+ui.draggable[0].attributes.id.value+ '_' + start;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'FB_OUT'}},outputs: {},id:'target_facebook_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}			 
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('youtube_box') !== -1)
			{
				oprtid = 'Target_Youtube_'+ui.draggable[0].attributes.id.value+ '_' + start;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'Youtube'}},outputs: {},id:'encoder_youtube_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('twitch_box') !== -1)
			{
				oprtid = 'Target_Twitch_'+ui.draggable[0].attributes.id.value+ '_' + start;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'Twitch'}},outputs: {},id:'encoder_twitch_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('twitter_box') !== -1)
			{
				oprtid = 'Target_Twitter_'+ui.draggable[0].attributes.id.value+ '_' + start;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'Twitter'}},outputs: {},id:'encoder_twitter_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('wowzacdn_box') !== -1)
			{
				oprtid = 'Target_WowzaCDN_'+ui.draggable[0].attributes.id.value+ '_' + start;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'WowzaCDN'}},outputs: {},id:'encoder_wowzacdn_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('TRG_RTMP_box') !== -1)
			{
				oprtid = 'Target_RTMP_'+ui.draggable[0].attributes.id.value+ '_' + start;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'TRG_RTMP'}},outputs: {},id:'encoder_TRGRTMP_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('TRG_MPEG_TS_box') !== -1)
			{
				oprtid = 'Target_MPEGTS_'+ui.draggable[0].attributes.id.value+ '_' + start;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'MPEGTS_INPUT'}},outputs: {},id:'encoder_TRGMPEGTS_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('TRG_RTP_box') !== -1)
			{
				oprtid = 'Target_MPEGTSRTP_'+ui.draggable[0].attributes.id.value+ '_' + start;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'TRGRTP_INPUT'}},outputs: {},id:'encoder_TRGRTP_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}
			else if(ui.draggable[0].attributes.class.nodeValue.indexOf('TRG_SRT_box') !== -1)
			{
				oprtid = 'Target_MPEGTSSRT_'+ui.draggable[0].attributes.id.value+ '_' + start;
				var encoderObject =  { top: ui.position.top, left: ui.position.left,properties: {title: ui.draggable[0].attributes.id.value.toUpperCase(),inputs: {input_1: {label: 'TRGSRT_INPUT'}},outputs: {},id:'encoder_TRGSRT_' + ui.draggable[0].attributes.id.value,name:oprtid}};
			}
	    	encodersData.operators[oprtid] = encoderObject;
	    	$('.workflow-drag-area').flowchart('createOperator',oprtid , encoderObject);
			 //$('.encoderschannelsDrops').flowchart({data: encodersData });
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

function workflow_settings(_boxType)
{
	switch(_boxType)
	{
		case "input_sdi":		
		$('#workflow_sdiChannelPopup').modal('show');
		break;
		case "input_ndi":
		$('#workflow_ndiChannelPopup').modal('show');
		break;
		case "input_rtmp":
		$('#workflow_rtmpChannelPopup').modal('show');		
		break;
		case "input_rtp":
		$('#workflow_rtpChannelPopup').modal('show');
		break;
		case "input_udp":
		$('#workflow_udpChannelPopup').modal('show');
		break;
		case "input_srt":
		$('#workflow_srtChannelPopup').modal('show');
		break;
		case "output_sdi":
		$('#workflow_out_sdiChannelPopup').modal('show');
		break;
		case "output_ndi":
		$('#workflow_out_ndiChannelPopup').modal('show');
		break;
		case "output_rtmp":
		$('#workflow_out_rtmpChannelPopup').modal('show');
		break;
		case "output_rtp":
		$('#workflow_out_rtpChannelPopup').modal('show');		
		break;
		case "output_udp":
		$('#workflow_out_udpChannelPopup').modal('show');
		break;
		case "output_srt":
		$('#workflow_out_srtChannelPopup').modal('show');
		break;
		case "gateway_gateway":
		$('#workflow_out_ndiChannelPopup').modal('show');
		break;
		case "publishers_publisher":
		$('#workflow_out_rtmpChannelPopup').modal('show');
		break;
		case "TRG_facebook":
		alert(_boxType);
		break;
		case "TRG_youtube":
		alert(_boxType);
		break;
		case "TRG_twitch":
		alert(_boxType);
		break;
		case "TRG_twitter":
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
var removeByAttr = function(arr, attr, value){
    var i = arr.length;
    while(i--){
       if( arr[i] 
           && arr[i].hasOwnProperty(attr) 
           && (arguments.length > 2 && arr[i][attr] === value ) ){ 

           arr.splice(i,1);

       }
    }
    return arr;
}