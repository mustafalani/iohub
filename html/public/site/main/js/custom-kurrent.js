
/*Admin Encoding Templates Start */
	$('#selectallencoding').click(function (event) {//alert(1);
		if (this.checked) {
			$('.endcodingGrp').each(function () { //loop through each checkbox
				$(this).prop('checked', true); //check 
			});
		} else {
			$('.endcodingGrp').each(function () { //loop through each checkbox
				$(this).prop('checked', false); //uncheck              
			});
		}
	});
 /*Admin Encoding Templates End */

//Start - select all Admin Encoding Templates
function submitAllencodings(wurl){
	
	var Ids = [];
	$("input:checkbox[class=endcodingGrp]:checked").each(function () {
		var id = $(this).val();
		Ids.push(id);
		var action = $("#actionEncoding").val();
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
			        url: baseURL + wurl,
			        data:{'id':Ids,'action':action},
			        type:'post',
			        dataType:'json',
			        success:function(jsonResponse){
			            if(jsonResponse.status == true)
			            {	                	                
							swal( action + "!", "Successfully!", "success");
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
			swal('At Least','select one action.');
		}
	});
	
}
//End - select all Admin Encoding Templates