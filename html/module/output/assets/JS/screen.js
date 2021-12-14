function check_code () {
	
	var checkin_code=$('#checkin_code').val();
	var page_name="../view/check_in.php";
	var div_id="modal_default";
	var parameter="checkin_code="+checkin_code;
	$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: true}); 
   
		show_loading_gif(div_id,"Loading Form..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;	
}

function update_atendee (employee_id_FK){
	//alert(employee_id_FK,meeting_id);
	var div_id="security_form_div";
	var page_name="../controller/output_controller.php";
	var parameter="employee_id_FK="+employee_id_FK+"&action=1";
	
		show_loading_gif(div_id,"Updating The Role ..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);
			//server_loader("html/module/output/view/main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			$(".modal.in").modal("hide");
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;	
}
