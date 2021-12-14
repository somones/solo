function submit_save_request(request_id)
{
	var request_job_title=$('#request_job_title').val();
	var request_group_id_FK=$('#request_group_id_FK').val();
	var request_description=$('#request_description').val();

	var branch_id_FK=$('#branch_id_FK').val();
	var gender_id_FK=$('#gender_id_FK').val();
	var request_reason=$('#request_reason').val();
	var request_type_id_FK=$('#request_type_id_FK').val();
	var nationality_id_FK=$('#nationality_id_FK').val();
	var request_experience=$('#request_experience').val();
	
	var div_id="request_op_div";
	var page_name="pre_employment/controller/employment_request_controller.php";
	var parameter=
		"request_id="+request_id+
		"&request_job_title="+request_job_title+
		"&request_group_id_FK="+request_group_id_FK+
		"&request_description="+request_description+
		"&branch_id_FK="+branch_id_FK+
		"&gender_id_FK="+gender_id_FK+
		"&request_reason="+request_reason+
		"&request_type_id_FK="+request_type_id_FK+
		"&nationality_id_FK="+nationality_id_FK+
		"&request_experience="+request_experience+
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
			if (request_id == -1) {
				$(".modal.in").modal("hide");
				server_loader("html/module/human_resouces/pre_employment/view/my_employment_request_list.php","sub-content-wrapper","meni_id=16","loading Request")
			} else {
				$(".modal.in").modal("hide");
			}
		}
	},
	error: function(xhr, textStatus, errorThrown)
	{
		alert('Something went wrong in Request...');
	}
	});	
}

function edit_request (request_id) {
	//alert(request_id);
	var page_name="pre_employment/view/employment_request_form.php";
	var div_id="sub-content-wrapper";
	var parameter="request_id="+request_id+"&action=1";

		show_loading_gif(div_id,"Loading Request infos..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			$("[name='data_grid']").DataTable();
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;	
}

function submit_delete_request(request_id){
	//alert(request_id);
	var s=confirm("Are you sure you want to Cancel this Request?");
		if(s)
		{
			//alert(request_id);
			var div_id="div_section_content";
			var page_name="pre_employment/controller/employment_request_controller.php";
			var parameter="request_id="+request_id+"&action=3";
			
				show_loading_gif(div_id,"Deleting Request ..");
				var Ajax = $.ajax({
				type: 'POST',
				url: page_name,
				data: parameter,
				success: function(result) {
					$('#' + div_id).html(result);
					server_loader("html/module/human_resouces/pre_employment/view/employment_request_delete.php","sub-content-wrapper","meni_id=16","loading Request")
				},
				error: function(xhr, textStatus, errorThrown) {
					alert('Something went wrong...');
				}
			});
			return Ajax;	
		}
}


function open_modal(request_id,request_state_id){
	//alert(request_id);

	var page_name="pre_employment/view/modal_requested.php";
	var div_id="modal_default";
	var parameter="request_id="+request_id+"&request_state_id="+request_state_id;
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

function open_unmatched_modal(request_id,request_state_id,applicant_id,flow_id){
	//alert(flow_id);

	var page_name="pre_employment/view/modal_requested_unmatched.php";
	var div_id="modal_default";
	var parameter=
	"request_id="+request_id+
	"&request_state_id="+request_state_id+
	"&applicant_id="+applicant_id+
	"&flow_id="+flow_id;
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

function actions_unmatched_log(action_id,request_id,request_state_id,applicant_id,flow_id){
//alert(applicant_id);
//alert(flow_id);
	var div_id="div_section_content";
	var page_name="pre_employment/controller/employment_request_controller.php";
	var parameter=
	"action_id="+action_id+
	"&request_id="+request_id+
	"&request_state_id="+request_state_id+
	"&applicant_id="+applicant_id+
	"&flow_id="+flow_id+
	"&action=7";
			
	show_loading_gif(div_id,"Updating Request Actions ..");
	var Ajax = $.ajax({
	type: 'POST',
	url: page_name,
	data: parameter,
	success: function(result) {

	$('#' + div_id).html(result);
		$(".modal.in").modal("hide");
		server_loader("html/module/human_resouces/pre_employment/view/employment_request_list.php","sub-content-wrapper","meni_id=16","loading Request")
	},
	error: function(xhr, textStatus, errorThrown) {
		alert('Something went wrong in Action Log...');
	}
	});
	return Ajax;
}

function actions_log(action_id,request_id,request_state_id) {
	var action_comment=$('#action_comment').val();
	var div_id="div_section_content";
	var page_name="pre_employment/controller/employment_request_controller.php";
	var parameter="action_id="+action_id+"&request_id="+request_id+"&action_comment="+action_comment+"&action=4";
			
	show_loading_gif(div_id,"Updating Request Actions ..");
	var Ajax = $.ajax({
	type: 'POST',
	url: page_name,
	data: parameter,
	success: function(result) {

	$('#' + div_id).html(result);
		$(".modal.in").modal("hide");
		server_loader("html/module/human_resouces/pre_employment/view/employment_request_list.php","sub-content-wrapper","meni_id=16","loading Request")
	},
	error: function(xhr, textStatus, errorThrown) {
		alert('Something went wrong in Action Log...');
	}
	});
	return Ajax;
}

function sourcing_modal(request_id,request_state_id){
	//alert("Sourcing");

	var page_name="pre_employment/view/sourcing_modal.php";
	var div_id="modal_default";
	var parameter="request_id="+request_id+"&request_state_id="+request_state_id;
	$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: true}); 
   
		show_loading_gif(div_id,"Loading Form..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);
			 $("[name='datefield']").datepicker({format: 'yyyy-mm-dd'});
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;
}


function matching_modal(request_id,request_state_id){
	//alert("Sourcing");

	var page_name="pre_employment/view/modal_action.php";
	var div_id="modal_default";
	var parameter="request_id="+request_id+"&request_state_id="+request_state_id;
	$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: true}); 
   
		show_loading_gif(div_id,"Loading Form..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);
			 $("[name='datefield']").datepicker({format: 'yyyy-mm-dd'});
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;
}
function save_request_opening (action_id,request_id,request_state_id){
	var opening_id_FK=$('#opening_id_FK').val();
	var opning_title=$('#opning_title').val();
	var opening_description=$('#opening_description').val();
	var opening_start_date=$('#opening_start_date').val();
	var opening_end_date=$('#opening_end_date').val();
	var div_id="div_section_content";
	var page_name="pre_employment/controller/employment_request_controller.php";
	var parameter=
			"action_id="+action_id+
			"&request_id="+request_id+
			"&opening_id_FK="+opening_id_FK+
			"&opning_title="+opning_title+
			"&opening_description="+opening_description+
			"&opening_start_date="+opening_start_date+
			"&opening_end_date="+opening_end_date+
			"&action=5";
	show_loading_gif(div_id,"Processing Actions ..");
	var Ajax = $.ajax({
	type: 'POST',
	url: page_name,
	data: parameter,
	dataType: "json",
	success: function(result) {
		$('#' + div_id).html(result['return_html']);
		if(result["success"]==1)
		{
			$(".modal.in").modal("hide");
			server_loader("html/module/human_resouces/pre_employment/view/employment_request_list.php","sub-content-wrapper","meni_id=16","loading Request")
		}
	},
	error: function(xhr, textStatus, errorThrown) {
		alert('Something went wrong in Action Log...');
	}
	});
	return Ajax;
}
function save_matching_opening (flow_id,action_id,request_id){
	//alert(score);
	var applicant_id=$('#applicant_id').val();
	var matching_notes=$('#matching_notes').val();
	var GlobalScore=$('#GlobalScore').val();
	var div_id="div_section_content";
	var page_name="pre_employment/controller/employment_request_controller.php";
	var parameter=
			"flow_id="+flow_id+
			"&GlobalScore="+GlobalScore+
			"&applicant_id="+applicant_id+
			"&matching_notes="+matching_notes+
			"&action_id="+action_id+
			"&request_id="+request_id+
			"&action=6";
	show_loading_gif(div_id,"Processing Actions ..");
	var Ajax = $.ajax({
	type: 'POST',
	url: page_name,
	data: parameter,
	dataType: "json",
	success: function(result) {
		$('#' + div_id).html(result['return_html']);
		if(result["success"]==1)
		{
			$(".modal.in").modal("hide");
			server_loader("html/module/human_resouces/pre_employment/view/employment_request_list.php","sub-content-wrapper","meni_id=16","loading Request")
		}
	},
	error: function(xhr, textStatus, errorThrown) {
		alert('Something went wrong in Action Log...');
	}
	});
	return Ajax;

}

function get_result_of_this_search() {

	var ref_request=$('#ref_request').val();
	var date_start=$('#date_start').val();
	var date_end=$('#date_end').val();
	var branch_id=$('#branch_id').val();

	$.ajax({
	type: 'POST',
	dataType: "html",
	success: function(result)
	{
		load_result_of_request_search(branch_id,ref_request,date_start,date_end)
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is get_result_of_invoice_search...');
	}
	});
}

function load_result_of_request_search(branch_id,ref_request,date_start,date_end){
	var div_id="table_result";
    var parameter="branch_id="+branch_id+"&ref_request="+ref_request+"&date_start="+date_start+"&date_end="+date_end;
    var page_name="pre_employment/controller/search_resault_view.php";
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