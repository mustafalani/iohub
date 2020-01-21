$(document).on('change','.folderSelection #id_folder',function(){
	var _folderId = $(this).val();	
	var _html ="";
	$('.fields').html("");
	var clr = convertBase(_folderSettings.data.folders[_folderId].color,10,16);
	$(this).parent().find('button').find('span').attr('style','color:#' + clr);
	for(var key in _folderSettings.data.folders[_folderId].meta_set)
	{			
		var k = _folderSettings.data.folders[_folderId].meta_set[key][0];	
		if(_folderSettings.data.meta_types[k].fulltext	== "0")
		{
			var classname = _folderSettings.data.meta_types[k].cs;				
			if(typeof classname !== 'undefined')
			{
				_html += "<div class='form-group col-lg-11'>";
				_html += "<label>"+_folderSettings.data.meta_types[k].aliases['en'][0]+"</label>";
				_html += "<select class='form-control' name='"+k+"' id='"+k+"'>";
				_html += "<option value=''>Select</option>";
				for(var opt in  _folderSettings.data.cs[classname])
				{
					_html += "<option value='"+_folderSettings.data.cs[classname][opt][0]+"'>"+_folderSettings.data.cs[classname][opt][1].aliases['en']+"</option>";				
				}
				_html += "</select>";
				_html += "</div>";		
			}
			else {
				var m =_folderSettings.data.meta_types[k].mode;							
				if(typeof m !== 'undefined' && m == 'date')
				{
					_html += "<div class='form-group col-lg-11'>";
					_html += "<label>"+_folderSettings.data.meta_types[k].aliases['en'][0]+"</label>";
					_html += "<input type='text' class='form-control datepicker' name='"+k+"' id='"+k+"'>";
					_html += "</div>";
				}
				else{
					_html += "<div class='form-group col-lg-11'>";
					_html += "<label>"+_folderSettings.data.meta_types[k].aliases['en'][0]+"</label>";
					_html += "<input type='text' class='form-control' name='"+k+"' id='"+k+"'>";
					_html += "</div>";	
				}
			}
		}
		else if(_folderSettings.data.meta_types[k].fulltext	>= 1)
		{				
			_html += "<div class='form-group col-lg-11'>";
			_html += "<label>"+_folderSettings.data.meta_types[k].aliases['en'][0]+"</label>";
			_html += "<input type='text' class='form-control' name='"+k+"' id='"+k+"'>";
			_html += "</div>";	
		}				
	}
	$('.fields').html(_html);
});
var convertBase = function(val, base1, base2) {
    if (typeof(val) == "number") {
        return parseInt(String(val)).toString(base2);
    } else {
        return parseInt(val.toString(), base1).toString(base2)
    };
}
$(document).on('click','.btnresetAssets',function(){
	$('#title').val("");	
});
$(document).on('click','.btnSaveAssets',function(){
	var obj = $(this);
	var d = {};
	if($('#id_folder').val() == ""){
		toastr['error']("Please select folder first!");		
		return false;
	}
	if($('.fields').html() == ""){
		toastr['error']("Fields should not be null!"); 
		return false;
	}
	$('.fields input,select,textarea').each(function(){	
		if($(this).val() != "")
		{	
			if(isNaN($(this).val())){
				d[$(this).attr('id')] = $(this).val();
			 }else{
				d[$(this).attr('id')] = parseInt($(this).val());
			 }
			
		}
	});	
	d['accesskey'] = $(this).attr('accesskey');
	$.ajax({
        url: baseURL + "admin/saveAssets",
        data:d,
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.status == true)
            {	              	
				Dropzone.autoDiscover = false;
				$('#frm_assetsmain').addClass('dropzone');
				$("#frm_assetsmain").dropzone({
			        maxFiles: 50,
			        url: baseURL + "admin/upload_asset_files",
			        success: function (file, response) {
			            console.log(response);
			        }
			    });
			    var j = JSON.parse(jsonResponse.data);
			    $('#frm_assetsmain > #assetid').val(j.data);
			    $(obj).html('Save');
            	toastr['success']("Asset has been saved successfully!");
			}
            if(jsonResponse.status == false)
            {
				toastr['error']("Error occured while starting!");
			}			
		},
        error:function(){
        	toastr['error']("Error occured while performing actions!");        		
		}
	});
});
$(document).on('click','.btnEditAssets',function(){
	var obj = $(this);
	var d = {};
	if($('#id_folder').val() == ""){
		toastr['error']("Please select folder first!");		
		return false;
	}
	if($('.fields').html() == ""){
		toastr['error']("Fields should not be null!"); 
		return false;
	}
	$('.fields input,select,textarea').each(function(){	
		if($(this).val() != "")
		{	
			if(isNaN($(this).val())){
				d[$(this).attr('id')] = $(this).val();
			 }else{
				d[$(this).attr('id')] = parseInt($(this).val());
			 }
			
		}
	});	
	$('.icnasset i').each(function(){
		if($(this).hasClass('text-success')){	
			d['qc/state'] = 4;		
		}
		else if($(this).hasClass('text-danger')){
			d['qc/state'] = 3;					
		}
		else if($(this).hasClass('text-secondary')){
			d['qc/state'] = 0;
		}
	});
	d['accesskey'] = $(this).attr('accesskey');
	$.ajax({
        url: baseURL + "nebula/updateAssets",
        data:d,
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.status == true)
            {	 			   			   
            	toastr['success']("Asset has been updated successfully!");
			}
            if(jsonResponse.status == false)
            {
				toastr['error']("Error occured while starting!");
			}			
		},
        error:function(){
        	toastr['error']("Error occured while performing actions!");        		
		}
	});
});
$(document).on('click','.icnasset i',function(){
 	if($(this).hasClass('icon-check')){
		if($(this).hasClass('text-success') == false){
			$(this).addClass('text-success');
			$('.icnasset i:eq(1)').removeClass('text-danger');
			$('.icnasset i:eq(2)').removeClass('text-secondary');
		}
	}
	else if($(this).hasClass('icon-close')){
		if($(this).hasClass('text-danger') == false){
			$(this).addClass('text-danger');
			$('.icnasset i:eq(0)').removeClass('text-success');
			$('.icnasset i:eq(2)').removeClass('text-secondary');
		}		
	}
	else if($(this).hasClass('fa-circle-thin')){
		
		if($(this).hasClass('text-secondary') == false){
			$(this).addClass('text-secondary');
			$('.icnasset i:eq(0)').removeClass('text-success');
			$('.icnasset i:eq(1)').removeClass('text-danger');
		}
		
	}
});
$(document).ready(function(){
	dragDropable();
});
function dragDropable()
{
	var maintable = document.getElementById('maintable');
	var filltable = document.getElementById('filltable');
	var musictable = document.getElementById('musictable');
	var storytable = document.getElementById('storytable');
	var commercialtable = document.getElementById('commercialtable');
	var tableassetsss = document.getElementById('tableassetsss');
	
	new Sortable(tableassetsss, {
		group: 'shared', // set both lists to same group
		animation: 150,
		onEnd: function (evt, originalEvent) {
			var cntr = 1;
			$('#' + evt.from.attributes.id.nodeValue + " tr").each(function() {
				$(this).find('td:eq(1)').html(cntr);
				var aid = $(this).attr('accesskey');
				$(this).find('td:eq(0) input[type=checkbox]').attr('id','asset_' + cntr + '_' + aid).attr('class','drag_assets');
				$(this).find('td:eq(0) label').attr('for','asset_' + cntr + '_' + aid);
				cntr++;
			});
			//$('.assetloop').selectpicker();
			//$('.assetloop').selectpicker('refresh');
		},
	});
	new Sortable(maintable, {
			group: {
			name: 'shared',
			pull: 'clone',
			put: false
		},
		sort: false,
		fallbackOnBody:false,
		animation: 150,
		onEnd: function(evt) {	
			
			var assetid = evt.item.accessKey;
			if(evt.to.attributes.id.nodeValue == "tableassetsss"){
				
				if($('#' + evt.to.attributes.id.nodeValue + " tr.empty").length == 1)
				{
					$('#' + evt.to.attributes.id.nodeValue + " tr.empty").remove();
				}
				switch(evt.from.attributes.id.nodeValue){
					case "maintable":
					var asset = JSON.parse(mainAssets[assetid]);
					break;
					case "filltable":
					var asset = JSON.parse(fillAssets[assetid]);
					break;
					case "musictable":
					var asset = JSON.parse(musicAssets[assetid]);
					break;
					case "storytable":
					var asset = JSON.parse(storiesAssets[assetid]);
					break;
					case "commercialtable":
					var asset = JSON.parse(commercialAssets[assetid]);
					break;
				}
				var row = "";					
				row +="<td class='stime' accesskey='"+asset.audio_tracks[0].start_time+"'>";
				row +="<div class='boxes'>";
				row +="<input type='checkbox'>";
				row +="<label></label>";
				row +="</div>";
				row +="</td>";
				row +="<td>1</td>";
				row +="<td accesskey='"+asset.path+"'>"+asset.title+"</td>";
				row +="<td>00:00:00:00</td>"
				row +="<td class='duration' accesskey='"+asset.duration+"'>"+secondsToHms(asset.duration)+"</td>";
				row +="<td style='padding-bottom: 0;padding-top: 0;vertical-align: middle;'><img style='width:85%;vertical-align:middle;' src='"+RUNDOWN_URL+"/thumb/0000/"+asset.id+"/orig.jpg' onerror='imgError(this);'></img></td>";
				row +="<td>";
				row +="<select id='loop_"+asset.id+"' name='loop_"+asset.id+"' class='assetloop'>";
				row +="<option value=''>--</option>";
				for(var i=1;i<=100;i++){
					row +="<option value='"+i+"'>"+i+"</option>";
				}
				row +="</td>";
				if (asset.status == 1) {
					row +="<td><span id='status' class='label label-gray'>READY</span></td>";
				} else {
					row +="<td><span id='status' class='label label-danger'>Missing</span></td>";
				}
				var qc = "";
				for(var key in asset){
					if(key == "qc/state"){
						qc = asset[key];
					}
				}				
				if(qc !== "")
				{
					if(qc == '3'){
						 row +="<td><i class='icon-close icons text-danger'></i></td>";
					}
					else if(qc == '4'){
						row +="<td><i class='icon-check icons text-success'></i></td>";
					}
					else if(qc == 0){
						row +="<td><i class='fa fa-circle-thin icons text-secondary'></i></td>";
					}
				}
				else{
					row +="<td><i class='fa fa-circle-thin icons text-secondary'></i></td>";
				}		
				if (asset.status == 1) {					
				} else {
					$(evt.item).addClass("missing");
				}		
				$(evt.item).html(row);
				var cntr = 1;
				$('#' + evt.to.attributes.id.nodeValue + " tr").each(function() {
					$(this).find('td:eq(1)').html(cntr);
					var aid = $(this).attr('accesskey');
					$(this).find('td:eq(0) input[type=checkbox]').attr('id','asset_' + cntr + '_' + aid).attr('class','drag_assets');
					$(this).find('td:eq(0) label').attr('for','asset_' + cntr + '_' + aid);
					cntr++;
				});
			}
        }
	});
	new Sortable(filltable, {
			group: {
			name: 'shared',
			pull: 'clone',
			put: false, // To clone: set pull to 'clone'
		},
		sort: false,
		animation: 150,
		onEnd: function(evt) {

			var assetid = evt.item.accessKey;
			if(evt.to.attributes.id.nodeValue == "tableassetsss"){
				
				if($('#' + evt.to.attributes.id.nodeValue + " tr.empty").length == 1)
				{
					$('#' + evt.to.attributes.id.nodeValue + " tr.empty").remove();
				}
				switch(evt.from.attributes.id.nodeValue){
					case "maintable":
					var asset = JSON.parse(mainAssets[assetid]);
					break;
					case "filltable":
					var asset = JSON.parse(fillAssets[assetid]);
					break;
					case "musictable":
					var asset = JSON.parse(musicAssets[assetid]);
					break;
					case "storytable":
					var asset = JSON.parse(storiesAssets[assetid]);
					break;
					case "commercialtable":
					var asset = JSON.parse(commercialAssets[assetid]);
					break;
				}
				var row = "";					
				row +="<td class='stime' accesskey='"+asset.audio_tracks[0].start_time+"'>";
				row +="<div class='boxes'>";
				row +="<input type='checkbox'>";
				row +="<label></label>";
				row +="</div>";
				row +="</td>";
				row +="<td>1</td>";
				row +="<td accesskey='"+asset.path+"'>"+asset.title+"</td>";
				row +="<td>"+formatTime(asset.ctime)+"</td>"
				row +="<td class='duration' accesskey='"+asset.duration+"'>"+secondsToHms(asset.duration)+"</td>";
				row +="<td style='padding-bottom: 0;padding-top: 0;vertical-align: middle;'><img style='width:85%;vertical-align:middle;' src='"+RUNDOWN_URL+"/thumb/0000/"+asset.id+"/orig.jpg' onerror='imgError(this);'></img></td>";
				row +="<td>";
				row +="<select id='loop_"+asset.id+"' name='loop_"+asset.id+"' class='assetloop'>";
				row +="<option value=''>--</option>";
				for(var i=1;i<=100;i++){
					row +="<option value='"+i+"'>"+i+"</option>";
				}
				row +="</td>";
				if (asset.status == 1) {
					row +="<td><span id='status' class='label label-gray'>READY</span></td>";
				} else {
					row +="<td><span id='status' class='label label-danger'>Missing</span></td>";
				}
				var qc = "";
				for(var key in asset){
					if(key == "qc/state"){
						qc = asset[key];
					}
				}				
				if(qc !== "")
				{
					if(qc == '3'){
						 row +="<td><i class='icon-close icons text-danger'></i></td>";
					}
					else if(qc == '4'){
						row +="<td><i class='icon-check icons text-success'></i></td>";
					}
					else if(qc == 0){
						row +="<td><i class='fa fa-circle-thin icons text-secondary'></i></td>";
					}
				}
				else{
					row +="<td><i class='fa fa-circle-thin icons text-secondary'></i></td>";
				}				
				$(evt.item).html(row);
				var cntr = 1;
				$('#' + evt.to.attributes.id.nodeValue + " tr").each(function() {
					$(this).find('td:eq(1)').html(cntr);
					var aid = $(this).attr('accesskey');
					$(this).find('td:eq(0) input[type=checkbox]').attr('id','asset_' + cntr + '_' + aid).attr('class','drag_assets');
					$(this).find('td:eq(0) label').attr('for','asset_' + cntr + '_' + aid);
					cntr++;
				});
			}
		}
	});
	new Sortable(musictable, {
			group: {
			name: 'shared',
			pull: 'clone',
			put: false, // To clone: set pull to 'clone'
		},
		sort: false,
		animation: 150,
		onEnd: function(evt) {

			var assetid = evt.item.accessKey;
			if(evt.to.attributes.id.nodeValue == "tableassetsss"){
				
				if($('#' + evt.to.attributes.id.nodeValue + " tr.empty").length == 1)
				{
					$('#' + evt.to.attributes.id.nodeValue + " tr.empty").remove();
				}
				switch(evt.from.attributes.id.nodeValue){
					case "maintable":
					var asset = JSON.parse(mainAssets[assetid]);
					break;
					case "filltable":
					var asset = JSON.parse(fillAssets[assetid]);
					break;
					case "musictable":
					var asset = JSON.parse(musicAssets[assetid]);
					break;
					case "storytable":
					var asset = JSON.parse(storiesAssets[assetid]);
					break;
					case "commercialtable":
					var asset = JSON.parse(commercialAssets[assetid]);
					break;
				}
				var row = "";					
				row +="<td class='stime' accesskey='"+asset.audio_tracks[0].start_time+"'>";
				row +="<div class='boxes'>";
				row +="<input type='checkbox'>";
				row +="<label></label>";
				row +="</div>";
				row +="</td>";
				row +="<td>1</td>";
				row +="<td accesskey='"+asset.path+"'>"+asset.title+"</td>";
				row +="<td>"+formatTime(asset.ctime)+"</td>"
				row +="<td class='duration' accesskey='"+asset.duration+"'>"+secondsToHms(asset.duration)+"</td>";
				row +="<td style='padding-bottom: 0;padding-top: 0;vertical-align: middle;'><img style='width:85%;vertical-align:middle;' src='"+RUNDOWN_URL+"/thumb/0000/"+asset.id+"/orig.jpg' onerror='imgError(this);'></img></td>";
				row +="<td>";
				row +="<select id='loop_"+asset.id+"' name='loop_"+asset.id+"' class='assetloop'>";
				row +="<option value=''>--</option>";
				for(var i=1;i<=100;i++){
					row +="<option value='"+i+"'>"+i+"</option>";
				}
				row +="</td>";
				if (asset.status == 1) {
					row +="<td><span id='status' class='label label-gray'>READY</span></td>";
				} else {
					row +="<td><span id='status' class='label label-danger'>Missing</span></td>";
				}
				var qc = "";
				for(var key in asset){
					if(key == "qc/state"){
						qc = asset[key];
					}
				}				
				if(qc !== "")
				{
					if(qc == '3'){
						 row +="<td><i class='icon-close icons text-danger'></i></td>";
					}
					else if(qc == '4'){
						row +="<td><i class='icon-check icons text-success'></i></td>";
					}
					else if(qc == 0){
						row +="<td><i class='fa fa-circle-thin icons text-secondary'></i></td>";
					}
				}
				else{
					row +="<td><i class='fa fa-circle-thin icons text-secondary'></i></td>";
				}				
				$(evt.item).html(row);
				var cntr = 1;
				$('#' + evt.to.attributes.id.nodeValue + " tr").each(function() {
					$(this).find('td:eq(1)').html(cntr);
					var aid = $(this).attr('accesskey');
					$(this).find('td:eq(0) input[type=checkbox]').attr('id','asset_' + cntr + '_' + aid).attr('class','drag_assets');
					$(this).find('td:eq(0) label').attr('for','asset_' + cntr + '_' + aid);
					cntr++;
				});
			}
		}
	});
	new Sortable(storytable, {
			group: {
			name: 'shared',
			pull: 'clone',
			put: false, // To clone: set pull to 'clone'
		},
		sort: false,
		animation: 150,
		onEnd: function(evt) {

			var assetid = evt.item.accessKey;
			if(evt.to.attributes.id.nodeValue == "tableassetsss"){
				
				if($('#' + evt.to.attributes.id.nodeValue + " tr.empty").length == 1)
				{
					$('#' + evt.to.attributes.id.nodeValue + " tr.empty").remove();
				}
				switch(evt.from.attributes.id.nodeValue){
					case "maintable":
					var asset = JSON.parse(mainAssets[assetid]);
					break;
					case "filltable":
					var asset = JSON.parse(fillAssets[assetid]);
					break;
					case "musictable":
					var asset = JSON.parse(musicAssets[assetid]);
					break;
					case "storytable":
					var asset = JSON.parse(storiesAssets[assetid]);
					break;
					case "commercialtable":
					var asset = JSON.parse(commercialAssets[assetid]);
					break;
				}
				var row = "";					
				row +="<td class='stime' accesskey='"+asset.audio_tracks[0].start_time+"'>";
				row +="<div class='boxes'>";
				row +="<input type='checkbox'>";
				row +="<label></label>";
				row +="</div>";
				row +="</td>";
				row +="<td>1</td>";
				row +="<td accesskey='"+asset.path+"'>"+asset.title+"</td>";
				row +="<td>"+formatTime(asset.ctime)+"</td>"
				row +="<td class='duration' accesskey='"+asset.duration+"'>"+secondsToHms(asset.duration)+"</td>";
				row +="<td style='padding-bottom: 0;padding-top: 0;vertical-align: middle;'><img style='width:85%;vertical-align:middle;' src='"+RUNDOWN_URL+"/thumb/0000/"+asset.id+"/orig.jpg' onerror='imgError(this);'></img></td>";
				row +="<td>";
				row +="<select id='loop_"+asset.id+"' name='loop_"+asset.id+"' class='assetloop'>";
				row +="<option value=''>--</option>";
				for(var i=1;i<=100;i++){
					row +="<option value='"+i+"'>"+i+"</option>";
				}
				row +="</td>";
				if (asset.status == 1) {
					row +="<td><span id='status' class='label label-gray'>READY</span></td>";
				} else {
					row +="<td><span id='status' class='label label-danger'>Missing</span></td>";
				}
				var qc = "";
				for(var key in asset){
					if(key == "qc/state"){
						qc = asset[key];
					}
				}				
				if(qc !== "")
				{
					if(qc == '3'){
						 row +="<td><i class='icon-close icons text-danger'></i></td>";
					}
					else if(qc == '4'){
						row +="<td><i class='icon-check icons text-success'></i></td>";
					}
					else if(qc == 0){
						row +="<td><i class='fa fa-circle-thin icons text-secondary'></i></td>";
					}
				}
				else{
					row +="<td><i class='fa fa-circle-thin icons text-secondary'></i></td>";
				}				
				$(evt.item).html(row);
				var cntr = 1;
				$('#' + evt.to.attributes.id.nodeValue + " tr").each(function() {
					$(this).find('td:eq(1)').html(cntr);
					var aid = $(this).attr('accesskey');
					$(this).find('td:eq(0) input[type=checkbox]').attr('id','asset_' + cntr + '_' + aid).attr('class','drag_assets');
					$(this).find('td:eq(0) label').attr('for','asset_' + cntr + '_' + aid);
					cntr++;
				});
			}
		}
	});
	new Sortable(commercialtable, {
			group: {
			name: 'shared',
			pull: 'clone',
			put: false, // To clone: set pull to 'clone'
		},
		sort: false,
		animation: 150,
		onEnd: function(evt) {

			var assetid = evt.item.accessKey;
			if(evt.to.attributes.id.nodeValue == "tableassetsss"){
				
				if($('#' + evt.to.attributes.id.nodeValue + " tr.empty").length == 1)
				{
					$('#' + evt.to.attributes.id.nodeValue + " tr.empty").remove();
				}
				switch(evt.from.attributes.id.nodeValue){
					case "maintable":
					var asset = JSON.parse(mainAssets[assetid]);
					break;
					case "filltable":
					var asset = JSON.parse(fillAssets[assetid]);
					break;
					case "musictable":
					var asset = JSON.parse(musicAssets[assetid]);
					break;
					case "storytable":
					var asset = JSON.parse(storiesAssets[assetid]);
					break;
					case "commercialtable":
					var asset = JSON.parse(commercialAssets[assetid]);
					break;
				}
				var row = "";					
				row +="<td class='stime' accesskey='"+asset.audio_tracks[0].start_time+"'>";
				row +="<div class='boxes'>";
				row +="<input type='checkbox'>";
				row +="<label></label>";
				row +="</div>";
				row +="</td>";
				row +="<td>1</td>";
				row +="<td accesskey='"+asset.path+"'>"+asset.title+"</td>";
				row +="<td>"+formatTime(asset.ctime)+"</td>"
				row +="<td class='duration' accesskey='"+asset.duration+"'>"+secondsToHms(asset.duration)+"</td>";
				row +="<td style='padding-bottom: 0;padding-top: 0;vertical-align: middle;'><img style='width:85%;vertical-align:middle;' src='"+RUNDOWN_URL+"/thumb/0000/"+asset.id+"/orig.jpg' onerror='imgError(this);'></img></td>";
				row +="<td>";
				row +="<select id='loop_"+asset.id+"' name='loop_"+asset.id+"' class='assetloop'>";
				row +="<option value=''>--</option>";
				for(var i=1;i<=100;i++){
					row +="<option value='"+i+"'>"+i+"</option>";
				}
				row +="</td>";
				if (asset.status == 1) {
					row +="<td><span id='status' class='label label-gray'>READY</span></td>";
				} else {
					row +="<td><span id='status' class='label label-danger'>Missing</span></td>";
				}
				var qc = "";
				for(var key in asset){
					if(key == "qc/state"){
						qc = asset[key];
					}
				}				
				if(qc !== "")
				{
					if(qc == '3'){
						 row +="<td><i class='icon-close icons text-danger'></i></td>";
					}
					else if(qc == '4'){
						row +="<td><i class='icon-check icons text-success'></i></td>";
					}
					else if(qc == 0){
						row +="<td><i class='fa fa-circle-thin icons text-secondary'></i></td>";
					}
				}
				else{
					row +="<td><i class='fa fa-circle-thin icons text-secondary'></i></td>";
				}				
				$(evt.item).html(row);
				var cntr = 1;
				$('#' + evt.to.attributes.id.nodeValue + " tr").each(function() {
					$(this).find('td:eq(1)').html(cntr);
					var aid = $(this).attr('accesskey');
					$(this).find('td:eq(0) input[type=checkbox]').attr('id','asset_' + cntr + '_' + aid).attr('class','drag_assets');
					$(this).find('td:eq(0) label').attr('for','asset_' + cntr + '_' + aid);
					cntr++;
				});
			}
		}
	});
	
}
function imgError(obj){
	$(obj).attr('src', baseURL + 'public/site/main/img/NoImageAvailable.png');
}
$(document).on('click','.btn_db',function(){
	$(this).addClass('iconselected');
	$('.assetlist').removeClass('dnone');
	$('.rundownslist').removeClass('col-lg-12');
	$('.rundownslist').addClass('col-lg-7');	
	var mainHTML = "";
	
	if(Object.keys(mainAssets).length > 0)
	{
		var cntr = 1;
		for(var key in mainAssets)
		{	
			var m = JSON.parse(mainAssets[key]);			
			var clr = convertBase(_folderSettings.data.folders[m['id_folder']].color,10,16);
			
			var external_link = RUNDOWN_URL + '/thumb/0000/' + m['id'] + '/orig.jpg';
			mainHTML += "<tr  accesskey='" + m['id'] + "'>";
			mainHTML += "<td>"+ cntr +"</td>";
			mainHTML += "<td><a href='"+ baseURL + "editasset/"+  m['id'] +"'>"+ m['title'] +"</a></td>";
			mainHTML += "<td><span class='folder' style='background-color:#"+clr+";'>" + _folderSettings.data.folders[m['id_folder']]['title'] + "</span></td>";
			mainHTML += "<td>" +  secondsToHms(m['duration']) + "</td>";		
			mainHTML += "<td style='padding-bottom: 0;padding-top: 0;vertical-align: middle;'>";
			mainHTML += "<img style='width:85%;vertical-align:middle;' src='"+ external_link +"' onerror='imgError(this);'/>";
			mainHTML += "</td>";
			mainHTML += "</tr>";
			cntr++;
		}
		$('#maintable').html(mainHTML);	
	}
	else{
		mainHTML +="<tr><td colspan='5'>No Record Found</td></tr>";
		$('#maintable').html(mainHTML);	
	}
});
$(document).on('click','.rundowntabs li a',function(){
	var tabid = $(this).attr('href');
	var mainHTML = "";
	var ast = {};
	switch(tabid){
		case "#main":
		ast = mainAssets;
		break;
		case "#fill":
		ast = fillAssets;
		break;
		case "#music":
		ast = musicAssets;
		break;
		case "#stories":
		ast = storiesAssets;
		break;
		case "#commercial":
		ast = commercialAssets;
		break;
	}
	if(Object.keys(ast).length > 0)
	{
		var cntr = 1;
		for(var key in ast)
		{	
			var m = JSON.parse(ast[key]);			
			var clr = convertBase(_folderSettings.data.folders[m['id_folder']].color,10,16);
			
			var external_link = RUNDOWN_URL+'/thumb/0000/' + m['id'] + '/orig.jpg';
			mainHTML += "<tr  accesskey='" + m['id'] + "'>";
			mainHTML += "<td>"+ cntr +"</td>";
			mainHTML += "<td><a href='"+ baseURL + "editasset/"+  m['id'] +"'>"+ m['title'] +"</a></td>";
			mainHTML += "<td><span class='folder' style='background-color:#"+clr+";'>" + _folderSettings.data.folders[m['id_folder']]['title'] + "</span></td>";
			
			mainHTML += "<td>" +  secondsToHms(m['duration']) + "</td>";		
			mainHTML += "<td style='padding-bottom: 0;padding-top: 0;vertical-align: middle;'>";
			mainHTML += "<img style='width:85%;vertical-align:middle;' src='"+ external_link +"' onerror='imgError(this);'/>";
			mainHTML += "</td>";
			mainHTML += "</tr>";
			cntr++;
		}
		$(tabid + " table tbody").html(mainHTML);	
	}
	else{
		mainHTML +="<tr><td colspan='5'>No Record Found</td></tr>";
		$(tabid + " table tbody").html(mainHTML);
	}
});
$(document).on('click','.assetclose',function(){
	$('.btn_db').removeClass('iconselected');
	$('.assetlist').addClass('dnone');
	$('.rundownslist').removeClass('col-lg-7');
	$('.rundownslist').addClass('col-lg-12');
});
$(document).on('click','.btndeleteselected',function(){
	$("#tableassetsss tr").each(function(){
		console.log($(this).find('input[type=checkbox]').prop('checked'));
		if($(this).find('input[type=checkbox]').prop('checked') == true){
			$(this).remove();
		}
	});
	var cntr = 1;
	$('#tableassetsss tr').each(function() {
		$(this).find('td:eq(1)').html(cntr);
		cntr++;
	});
});
 
$(document).on('click','.btnSaveRundownList',function(){
	if($("#tableassetsss tr.empty").length == 1)
	{
		toastr['error']('Please add at lease one asset to playlist to update!');
		return false;
	}
	var pathArray = window.location.pathname.split( '/' );
	var clipIDS = "";
	var loops ="";
	var pths = "";
	var stimes = "";
	$("#tableassetsss tr").each(function(){
		clipIDS = clipIDS + $(this).attr('accesskey') + '-' + $(this).find('td.duration').attr('accesskey').trim() + "|";
	});
	$("#tableassetsss tr").each(function(){
		loops = loops + $(this).find('.assetloop').val().trim() + "|";
	});
	$("#tableassetsss tr").each(function(){
		pths = pths + $(this).find('td:eq(2)').attr('accesskey').trim() + "|";
	});
	$("#tableassetsss tr").each(function(){
		stimes = stimes + $(this).find('td.stime').attr('accesskey').trim() + "|";
	});
	var cids = clipIDS.substring(0, clipIDS.length - 1);
	var lps = loops.substring(0, loops.length - 1);
	var pthss = pths.substring(0, pths.length - 1);
	var stime = stimes.substring(0, stimes.length - 1);
	$.ajax({
        url: baseURL + "nebula/saveRundownList",
        data:{'rundownid':pathArray[3],'clipids':cids,'loops':lps,'paths':pthss,'stime':stime},
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.status == true)
            {	
            	toastr['success']("Playlist has been saved successfully!");
			}
            if(jsonResponse.status == false)
            {
				toastr['error']("Error occured while updating playlist!");
			}			
		},
        error:function(){
        	toastr['error']("Error occured while performing actions!");        		
		}
	});
});

$(document).on('click','.btn_asset_copy',function(){
	if($('#tableassetsss tr td .drag_assets').length <= 0){
		toastr['error']("No assets in table!");
		return; 
	}
	$('#tableassetsss tr td .drag_assets').each(function(){
		if($(this).is(":checked")== true)
		{
			var cln = $(this).parent().parent().parent().clone();
			$('#tableassetsss').append(cln);
		}
	});
	var cntr = 1;
	$('#tableassetsss tr').each(function() {
		$(this).find('td:eq(1)').html(cntr);
		var aid = $(this).attr('accesskey');
		$(this).find('td:eq(0) input[type=checkbox]').attr('id','asset_' + cntr + '_' + aid);
		$(this).find('td:eq(0) label').attr('for','asset_' + cntr + '_' + aid);
		cntr++;
	});	
	$('#tableassetsss tr').each(function(){
		$(this).find('td:eq(0) input[type=checkbox]').prop('checked',false);
	});
	toastr['success']("Asset Copied!");
});
$(document).on('click','.btn_clear_assets',function(){
	$('#tableassetsss tr').each(function(){
		$(this).remove();
	});
	var htRow = "<tr class='empty'><td colspan='8'>No Record Found</td></tr>";
	$('#tableassetsss').html(htRow);
});
$('#selectallassets').click(function (event) {
    if (this.checked) {
        $('.drag_assets').each(function () {
            $(this).prop('checked', true);
        });
    } else {
        $('.drag_assets').each(function () {
            $(this).prop('checked', false);
        });
    }
});
var assetsLength = $('#tableassetsss tr td .drag_assets').length;
var assetCheckedLength = 0;
$('#tableassetsss tr td .drag_assets').click(function(){

	if($(this).is(":checked")== false)
	{
		if($('#selectallassets').is(":checked") == true)
		{
			$('#selectallassets').prop('checked', false);
		}
		assetCheckedLength = 0;
		$('#tableassetsss tr td .drag_assets').each(function () {
           if($(this).is(":checked")== true)
           {
		   	   assetCheckedLength++;
		   }
        });
        if(assetCheckedLength == assetsLength)
        {
			$('#selectallassets').prop('checked', true);
		}
	}
	else if($(this).is(":checked")== true)
	{
		assetCheckedLength = 0;
		$('#tableassetsss tr td .drag_assets').each(function () {
           if($(this).is(":checked")== true)
           {
		   	  assetCheckedLength++;
		   }
        });
        if(assetCheckedLength == assetsLength)
        {
			$('#selectallassets').prop('checked', true);
		}
	}
});
$('#actionRundowns').on('change',function(){
	var _action = $(this).val();
	if(_action == ""){
		toastr['error']("Please select at least one action!");
		return;
	}
	if(_action == "Lock"){
		URL = "nebula/lockRundown";
	}
	else if(_action == "UnLock"){
		URL = "nebula/unLockRundown";
	}
	else if(_action == "Delete"){
		URL = "nebula/deleteRundown";
	}
	$.ajax({
        url: baseURL + URL,
        data:{'rundownid':did},
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.status == true){
            	if(_action == "Lock"){
            		$('.rundownActions').each(function () {
            			if($(this).prop('checked') == true){
						   $(this).find('.lck').find('i').removeClass('fa-unlock');
						   $(this).find('.lck').find('i').addClass('fa-lock');
						}
            		});					
				}
				else if(_action == "UnLock"){
					$('.rundownActions').each(function () {
            			if($(this).prop('checked') == true){
						   $(this).find('.lck').find('i').removeClass('fa-lock');
						   $(this).find('.lck').find('i').addClass('fa-unlock');
						}
            		});					
				}
				else if(_action == "Delete"){
					$('.rundownActions').each(function () {
            			if($(this).prop('checked') == true){
						   $(this).remove();
						}
            		});	
					var cntr = 1;
					$(".rundownTR").each(function() {
						$(this).find('td:eq(1)').html(cntr);					
						cntr++;
					});
				}
				toastr['success']( _action + " rundown successfully!");
			}
            if(jsonResponse.status == false){
				toastr['error']("Error occured while deleting rundown!");
			}			
		},
        error:function(){
        	toastr['error']("Error occured while deleting rundown!");        		
		}
	});
});
$(document).on('click','.deleteRundown',function(){
	
	var did = $(this).attr('accesskey');
	if($(this).parent().parent().find('.lck').find('i').hasClass('fa-lock') == true){
		toastr['error']("You cant delete locked record!");
		return;
	}
	var obj = $(this);
	
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
		        url: baseURL + "nebula/deleteRundown",
		        data:{'rundownid':did},
		        type:'post',
		        dataType:'json',
		        success:function(jsonResponse){
		            if(jsonResponse.status == true){	
		                $(obj).parent().parent().remove();
		            	toastr['success']("Delete rundown successfully!");
		            	var cntr = 1;
						$(".rundownTR").each(function() {
							$(this).find('td:eq(1)').html(cntr);					
							cntr++;
						});
					}
		            if(jsonResponse.status == false){
						toastr['error']("Error occured while deleting rundown!");
					}			
				},
		        error:function(){
		        	toastr['error']("Error occured while deleting rundown!");        		
				}
			});
		});
	
	
});
$(document).on('click','.loclRundown',function(){
	var did = $(this).attr('accesskey');
	var obj = $(this);
	var URL = "";
	if($(obj).find('i').hasClass('fa-lock')){
		URL = "nebula/unLockRundown";	
	}
	else if($(obj).find('i').hasClass('fa-unlock')){
		URL = "nebula/lockRundown";	
	}
	$.ajax({
        url: baseURL + URL,
        data:{'rundownid':did},
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.status == true)
            {	
            	toastr['success']("Rundown Locked successfully!");
            	if($(obj).find('i').hasClass('fa-lock')){
					$(obj).find('i').removeClass('fa-lock');
            		$(obj).find('i').addClass('fa-unlock');	
				}
				else if($(obj).find('i').hasClass('fa-unlock')){
					$(obj).find('i').removeClass('fa-unlock');
            		$(obj).find('i').addClass('fa-lock');	
				}
            	
			}
            if(jsonResponse.status == false)
            {
				toastr['error']("Error occured while performing actions!");
			}			
		},
        error:function(){
        	toastr['error']("Error occured while performing actions!");        		
		}
	});
});
$(document).on('click','.rundownttileupdate',function(){
	var ttitle = $('.runttl').val();
	var rid = $('.runttl').attr('id');
	$.ajax({
        url: baseURL + "nebula/updateRundownTitle",
        data:{'title':ttitle,'id':rid},
        type:'post',
        dataType:'json',
        success:function(jsonResponse){
            if(jsonResponse.status == true)
            {	
            	toastr['success']("Rundown Locked successfully!");   
			}
            if(jsonResponse.status == false)
            {
				toastr['error']("Error occured while performing actions!");
			}			
		},
        error:function(){
        	toastr['error']("Error occured while performing actions!");        		
		}
	});
});
$('#allRundowns').click(function (event) {
    if (this.checked) {
        $('.rundownActions').each(function () {
            $(this).prop('checked', true);
        });
    } else {
        $('.rundownActions').each(function () {
            $(this).prop('checked', false);
        });
    }
});
var runLength = $('.rundownActions').length;
var runCheckedLength = 0;
$('.rundownActions').click(function(){

	if($(this).is(":checked")== false)
	{
		if($('#allRundowns').is(":checked") == true)
		{
			$('#allRundowns').prop('checked', false);
		}
		runCheckedLength = 0;
		$('.rundownActions').each(function () {
           if($(this).is(":checked")== true)
           {
		   	   runCheckedLength++;
		   }
        });
        if(runCheckedLength == runLength)
        {
			$('#allRundowns').prop('checked', true);
		}
	}
	else if($(this).is(":checked")== true)
	{
		runCheckedLength = 0;
		$('.rundownActions').each(function () {
           if($(this).is(":checked")== true)
           {
		   	  runCheckedLength++;
		   }
        });
        if(runCheckedLength == runLength)
        {
			$('#allRundowns').prop('checked', true);
		}
	}
});
// Run Playlist
$(document).on('click','.btnRunPlaylist',function () {
    
    if($('#tableassetsss tr').length > 0 && $('#tableassetsss tr:eq(0) td').length > 1){
    	var rid = $('.runttl').attr('id');
		$.ajax({
	        url: baseURL + "nebula/startPlaylist",
	        data:{'rundownid':rid},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {	
	            	toastr['success'](jsonResponse.message);   
	            	isPlaylistOnline = jsonResponse.isOnline;
				}
	            if(jsonResponse.status == false)
	            {
					toastr['error'](jsonResponse.message);
				}			
			},
	        error:function(){
	        	toastr['error']("Error occured while performing actions!");        		
			}
		});
	}else{
		toastr['error']("Please add items in playlist first!");
	}
});
// Stop Playlist
$(document).on('click','.btnStopPlaylist',function () {    
   
    	var rid = $('.runttl').attr('id');
		$.ajax({
	        url: baseURL + "nebula/stopPlaylist",
	        data:{'rundownid':rid},
	        type:'post',
	        dataType:'json',
	        success:function(jsonResponse){
	            if(jsonResponse.status == true)
	            {	
	            	toastr['success'](jsonResponse.message);   
	            	isPlaylistOnline = jsonResponse.isOnline;
				}
	            if(jsonResponse.status == false)
	            {
					toastr['error'](jsonResponse.message);
				}			
			},
	        error:function(){
	        	toastr['error']("Error occured while performing actions!");        		
			}
		});
	
});
function millisToMinutesAndSeconds(millis) {
  var minutes = Math.floor(millis / 60000);
  var seconds = ((millis % 60000) / 1000).toFixed(0);
  return (seconds < 10 ? '0' : '') + seconds;
}
/* IOT STREAMS */
$(document).on('click','.iotstreamsstartstop',function() {
	var thisObj = $(this);
	var iotStreamId = $(this).attr("id");
	var className = $(this).find('i').attr("class");
	var cname = className.split(' ');
	var action ="";
	var API_URL = "";
	if (cname[1] == "fa-play") {
		action = "Start";
		API_URL = "extras/startiotstream";		
	} else if (cname[1] == "fa-pause") {
		API_URL = "extras/stopiotstream";
		action = "Stop";		
	}
	var idds = iotStreamId.split('_');
	swal({
		title: "Are you sure?",
		text: "You want to " + action + " this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes " + action + " it!",
		closeOnConfirm: true
	},
	function() {
		$(thisObj).parent().parent().find("#status").removeAttr("class");
		$(thisObj).parent().parent().find("#status").addClass("label label-warning").text("Starting");
		$.ajax({
			url: baseURL + API_URL,
			data:{'iotstreamid':iotStreamId,'action':action},
			type:'post',
			dataType:'json',
			success:function(jsonResponse) {
				if (jsonResponse.status == true) {
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
						break;
					}
				}


				if (jsonResponse.status == false) {
					toastr['error']("Error occured while starting!");					
				}			
			},
			error:function() {
				toastr['error']("Error occured while performing actions!");
				
			}
		});
	});
});
$(document).on('click','.createChannelGroup',function() {
	$('#create_channel_group').modal('show');	
});
$(document).on('click','.saveChannelGroupName',function() {
	var grpname = $('#ch_grpup_name').val();
	$.ajax({
		url: baseURL + 'nebula/savechannelgroup',
		data:{'groupname':grpname},
		type:'post',
		dataType:'json',
		success:function(jsonResponse) {
			if (jsonResponse.status == true) {
				$('<li class="nav-item" role="presentation"><a class="nav-link active" href="javascript:void(0);" aria-controls="channels" role="tab" data-toggle="tab">'+ grpname +'</a></li>').insertBefore('.channeltabs li:last');
				$('#create_channel_group').modal('hide');
				$('#ch_grpup_name').val("");
			}
			if (jsonResponse.status == false) {
				toastr['error']("Error occured while creating group!");
			}
		},
		error:function() {
			toastr['error']("Error occured while performing actions!");

		}
	});
});

$(document).on('click','.iotstreamsstartstopDelete',function(){
	var iostreamid = $(this).attr('accesskey');
	swal({
		title: "Are you sure?",
		text: "You want to delete this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes delete it!",
		closeOnConfirm: true
	},
	function() {		
		$.ajax({
			url: baseURL + 'extras/deleteiotstream',
			data:{'iotstreamid':iostreamid},
			type:'post',
			dataType:'json',
			success:function(jsonResponse) {
				if (jsonResponse.status == true) {
					toastr['success']("Delete Successfully!");
					setTimeout(function(){
					    location.reload();
					},3000);
				}
				if (jsonResponse.status == false) {
					toastr['error']("Error occured while performing action!");					
				}			
			},
			error:function() {
				toastr['error']("Error occured while performing actions!");
				
			}
		});
	});
});
$(document).on('click','.chnlGrp_delete',function() {
	var grpname = $(this).attr('accesskey');
	 swalExtend({
		swalFunction: deleteExtend,
		hasCancelButton: true,
		buttonNum: 2,		
		buttonNames: ["Yes","Yes - delete Group & Channels"],
		clickFunctionList: [
			function() {
				$.ajax({
					url: baseURL + 'diverse/deletechannelgroup',
					data:{'groupname':grpname,'action':'deletegroup'},
					type:'post',
					dataType:'json',
					success:function(jsonResponse) {
						if (jsonResponse.status == true) {
							toastr['success']("Group Deleted Successfully!");
							setTimeout(function(){
							    location.reload();
							},2000);
						}
						if (jsonResponse.status == false) {
							toastr['error']("Error occured while creating group!");
						}
					},
					error:function() {
						toastr['error']("Error occured while performing actions!");

					}
				});
			},
			function() {
				$.ajax({
					url: baseURL + 'diverse/deletechannelgroup',
					data:{'groupname':grpname ,'action':'deletegroupandchannel'},
					type:'post',
					dataType:'json',
					success:function(jsonResponse) {
						if (jsonResponse.status == true) {
							toastr['success']("Group Deleted Successfully!");
							setTimeout(function(){
							    location.reload();
							},2000);
						}
						if (jsonResponse.status == false) {
							toastr['error']("Error occured while creating group!");
						}
					},
					error:function() {
						toastr['error']("Error occured while performing actions!");

					}
				});
			}
		]
	});
});
function deleteExtend(){
	 swal({
		title: "Are you sure?",
		text: "You want to delete it!",
		type: "warning",
		showCancelButton: true,
		showConfirmButton: false
	});
}
function submitIoTStream()
{
	var Ids = [];
	if($("#actionIotStreams option:selected").val() == "" || $('.iotStreamTable tbody tr').find('input[type=checkbox]:checked').length <= 0)
    {
    	toastr['info']('At least select one action/record');
    	return false;
    }

	$("input:checkbox[class=IoTStreamActions]:checked").each(function () {
		var ids = $(this).attr("id");
		var id = ids.split('_');
		Ids.push(id[1]);
		var action = $("#actionIotStreams").val();

		if(action != "" && action != "0" && action == "Delete" || action == "Archive")
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
			        url: baseURL + 'extras/IoTStreamActions',
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){

			        	$('.iotStreamTable tr td').find("input[type='checkbox']").prop('checked',false);
			        	$('.iotStreamTable tr th').find("input[type='checkbox']").prop('checked',false);
			        	switch(action)
			        	{							
							case "Delete":
							toastr['success'](action +  " Successfully!");
							for(i=0; i<Ids.length; i++)
				        	{
								$('.iotStreamTable #row_'+Ids[i]).remove();
							}
							case "Archive":
							toastr['success'](action +  " Successfully!");
							for(i=0; i<Ids.length; i++)
				        	{
								$('.iotStreamTable #row_'+Ids[i]).remove();
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