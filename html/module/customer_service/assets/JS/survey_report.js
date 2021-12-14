// --------------------------------------------------------------- Survy Report ---------------------------------------------------------------

function get_survy_report_details () {
	var survey_template_id =$('#survey_template_id').val();
	var parameter="survey_template_id="+survey_template_id;
	var page_name="../view/survey_report_detail.php";
	var div_id="sub-content-wrapper";
		show_loading_gif(div_id,"Loading Meeting Content..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		dataType: "html",
		success: function(result) {
			$('#' + div_id).html(result);
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;	
}

function save_this_contact(contact_id)
{
	var contact_name=$('#contact_name').val();
	var contact_email=$('#contact_email').val();
	var contact_mobile_number=$('#contact_mobile_number').val();
	var contact_user_id_FK=$('#contact_user_id_FK').val();
	var extension_number=$('#extension_number').val();
	var branch_id_FK=$('#branch_id_FK').val();

	var div_id="conact_form_div";
	var page_name="../controller/contact_controller.php";
	var parameter=
		"contact_id="+contact_id+
		"&contact_name="+contact_name+
		"&contact_email="+contact_email+
		"&contact_mobile_number="+contact_mobile_number+
		"&contact_user_id_FK="+contact_user_id_FK+
		"&extension_number="+extension_number+
		"&branch_id_FK="+branch_id_FK+
		"&action=1";
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "json",
	success: function(result) 
	{
		$('#' + div_id).html(result['return_html']);
		if(result["success"]==1)
		{
			$('#' + div_id).html(result);
			$(".modal.in").modal("hide");
			server_loader("html/module/customer_service/view/contacts_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is contact...');
	}
	});	
}

function confirm_email_form (message_type,distribution_list_type,menu_id) {
	var message_distribution_id_FK=$('#message_distribution_id_FK').val();
	var receiver_number=$('#receiver_number').val();
	var message_subject=$('#message_subject').val();
	var message_content=$('#message_content').val();
	var arabic_text=$('#arabic_text').val();
	var message_type_id_FK=message_type;
	
	var div_id="email_div";
	var page_name="../controller/distribution_list_controller.php";
	var parameter=
		"message_distribution_id_FK="+message_distribution_id_FK+
		"&receiver_number="+receiver_number+
		"&message_subject="+message_subject+
		"&message_content="+message_content+
		"&message_type_id_FK="+message_type_id_FK+
		"&distribution_list_type="+distribution_list_type+
		"&arabic_text="+arabic_text+
		"&menu_id="+menu_id+
		"&action=8";
		show_loading_gif(div_id,"Loading Meeting Content..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		dataType: "json",
		success: function(result) {
			$('#' + div_id).html(result['return_html']);
			if(result["success"]==1)
			{	
				get_confirm_email_form (message_type,distribution_list_type,menu_id);
			}
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong Confirmat...');
		}
	});
	return Ajax;
}


// --------------------------------------------------------------- Survy Report ---------------------------------------------------------------


function get_result() {
	//alert("Start");
	var survey_template_id=$('#survey_template_id').val();
	var date_start=$('#date_start').val();
	var date_end=$('#date_end').val();
	var branch_id=$('#branch_id').val();

	$.ajax({
	type: 'POST',
	dataType: "html",
	success: function(result)
	{
		load_result_of_invoice_search(survey_template_id,date_start,date_end,branch_id)
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is get_result_of_invoice_search...');
	}
	});
}

function load_result_of_invoice_search(survey_template_id,date_start,date_end,branch_id){
	var div_id="table_result";
    var parameter="survey_template_id="+survey_template_id+"&date_start="+date_start+"&date_end="+date_end+"&branch_id="+branch_id;
    var page_name="../view/search_html_result.php";
	show_loading_gif(div_id,"Loading Orders...");
	var Ajax = $.ajax({
	type: 'POST',
	url: page_name,
	data: parameter,
	dataType: "html",
	success: function(result) {
		$('#' + div_id).html(result);
	},
	error: function(xhr, textStatus, errorThrown) {
		alert('Something went wrong...');
	}
});
	return Ajax;
}