function submit_save_applicant(applicant_id)
{
	//alert(applicant_id);
	var applicant_title__id_FK=$('#applicant_title__id_FK').val();
	var applicant_first_name=$('#applicant_first_name').val();
	var applicant_last_name=$('#applicant_last_name').val();
	var applicant_suffix=$('#applicant_suffix').val();
	var applicant_email=$('#applicant_email').val();
	var applicant_phone_number=$('#applicant_phone_number').val();
	var applicant_nationality_id_FK=$('#applicant_nationality_id_FK').val();
	var applicant_citizen_id_FK=$('#applicant_citizen_id_FK').val();
	var applicant_marital_status_FK=$('#applicant_marital_status_FK').val();
	var applicant_residency_FK=$('#applicant_residency_FK').val();
	var applicant_visa_type_FK=$('#applicant_visa_type_FK').val();
	var applicant_current_employment_status=$('#applicant_current_employment_status').val();
	var applicant_current_employment_poistion=$('#applicant_current_employment_poistion').val();
	var applicant_current_employer_text=$('#applicant_current_employer_text').val();
	var applicant_applying_position_id_FK=$('#applicant_applying_position_id_FK').val();
	var applicant_availibility_FK=$('#applicant_availibility_FK').val();
	var applicant_profession_FK=$('#applicant_profession_FK').val();
	var applicant_speciality=$('#applicant_speciality').val();
	var applicant_education_level_FK=$('#applicant_education_level_FK').val();
	var applicant_institution_name=$('#applicant_institution_name').val();
	var applicant_board_certified_id_FK=$('#applicant_board_certified_id_FK').val();
	var applicant_hold_haad_license=$('#applicant_hold_haad_license').val();
	var applicant_hold_dha_license=$('#applicant_hold_dha_license').val();
	var applicant_contact_reference=$('#applicant_contact_reference').val();
	var applicant_available_start_date=$('#applicant_available_start_date').val();
	var applicant_cv_id_FK=$('#applicant_cv_id_FK').val();
	var other_visa_type=$('#other_visa_type').val();
	var other_position=$('#other_position').val();
	var other_profession=$('#other_profession').val();
	var other_board=$('#other_board').val();
	var countryCode=$('#countryCode').val();
	
	var items = [];
	$('#applicant_llicense_id_FK option:selected').each(function(){ items.push($(this).val()); });
	var result = items.join(', ');

	var div_id="applicant_op_div";
	var page_name="pre_employment/controller/human_ressource_controller.php";
	var parameter=
		"applicant_id="+applicant_id
		+"&applicant_title__id_FK="+applicant_title__id_FK
		+"&applicant_first_name="+applicant_first_name
		+"&applicant_last_name="+applicant_last_name
		+"&applicant_suffix="+applicant_suffix
		+"&applicant_email="+applicant_email
		+"&applicant_phone_number="+applicant_phone_number
		+"&applicant_nationality_id_FK="+applicant_nationality_id_FK
		+"&applicant_citizen_id_FK="+applicant_citizen_id_FK
		+"&applicant_marital_status_FK="+applicant_marital_status_FK
		+"&applicant_residency_FK="+applicant_residency_FK
		+"&applicant_visa_type_FK="+applicant_visa_type_FK
		+"&applicant_current_employment_status="+applicant_current_employment_status
		+"&applicant_current_employment_poistion="+applicant_current_employment_poistion
		+"&applicant_current_employer_text="+applicant_current_employer_text
		+"&applicant_applying_position_id_FK="+applicant_applying_position_id_FK
		+"&applicant_availibility_FK="+applicant_availibility_FK
		+"&applicant_profession_FK="+applicant_profession_FK
		+"&applicant_speciality="+applicant_speciality
		+"&applicant_education_level_FK="+applicant_education_level_FK
		+"&applicant_institution_name="+applicant_institution_name
		+"&applicant_board_certified_id_FK="+applicant_board_certified_id_FK
		+"&applicant_hold_haad_license="+applicant_hold_haad_license
		+"&applicant_hold_dha_license="+applicant_hold_dha_license
		+"&applicant_contact_reference="+applicant_contact_reference
		+"&applicant_available_start_date="+applicant_available_start_date
		+"&applicant_cv_id_FK="+applicant_cv_id_FK
		+"&other_visa_type="+other_visa_type
		+"&other_position="+other_position
		+"&other_profession="+other_profession
		+"&other_board="+other_board
		+"&countryCode="+countryCode
		+"&applicant_llicense_id_FK="+result
		+"&action=1";
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
			server_loader("html/module/human_resouces/pre_employment/view/human_ressource_pool.php","sub-content-wrapper","meni_id=16","loading Applicant")
		}
	},
	error: function(xhr, textStatus, errorThrown)
	{
		alert('Something went wrong in applicant...');
	}
	});	
}

function submit_save_web_form(applicant_id)
{
	alert(applicant_id);
	var applicant_title__id_FK=$('#applicant_title__id_FK').val();
	var applicant_first_name=$('#applicant_first_name').val();
	var applicant_last_name=$('#applicant_last_name').val();
	var applicant_suffix=$('#applicant_suffix').val();
	var applicant_email=$('#applicant_email').val();
	var applicant_phone_number=$('#applicant_phone_number').val();
	var applicant_nationality_id_FK=$('#applicant_nationality_id_FK').val();
	var applicant_citizen_id_FK=$('#applicant_citizen_id_FK').val();
	var applicant_marital_status_FK=$('#applicant_marital_status_FK').val();
	var applicant_residency_FK=$('#applicant_residency_FK').val();
	var applicant_visa_type_FK=$('#applicant_visa_type_FK').val();
	var applicant_current_employment_status=$('#applicant_current_employment_status').val();
	var applicant_current_employment_poistion=$('#applicant_current_employment_poistion').val();
	var applicant_current_employer_text=$('#applicant_current_employer_text').val();
	var applicant_applying_position_id_FK=$('#applicant_applying_position_id_FK').val();
	var applicant_availibility_FK=$('#applicant_availibility_FK').val();
	var applicant_profession_FK=$('#applicant_profession_FK').val();
	var applicant_speciality=$('#applicant_speciality').val();
	var applicant_education_level_FK=$('#applicant_education_level_FK').val();
	var applicant_institution_name=$('#applicant_institution_name').val();
	var applicant_board_certified_id_FK=$('#applicant_board_certified_id_FK').val();
	var applicant_hold_haad_license=$('#applicant_hold_haad_license').val();
	var applicant_hold_dha_license=$('#applicant_hold_dha_license').val();
	var applicant_contact_reference=$('#applicant_contact_reference').val();
	var applicant_available_start_date=$('#applicant_available_start_date').val();
	var applicant_cv_id_FK=$('#applicant_cv_id_FK').val();
	var other_visa_type=$('#other_visa_type').val();
	var other_position=$('#other_position').val();
	var other_profession=$('#other_profession').val();
	var other_board=$('#other_board').val();

	var items = [];
	$('#applicant_llicense_id_FK option:selected').each(function(){ items.push($(this).val()); });
	var result = items.join(', ');
	
	var div_id="applicant_op_div";
	var page_name="../controller/human_ressource_controller.php";
	var parameter=
		"applicant_id="+applicant_id
		+"&applicant_title__id_FK="+applicant_title__id_FK
		+"&applicant_first_name="+applicant_first_name
		+"&applicant_last_name="+applicant_last_name
		+"&applicant_suffix="+applicant_suffix
		+"&applicant_email="+applicant_email
		+"&applicant_phone_number="+applicant_phone_number
		+"&applicant_nationality_id_FK="+applicant_nationality_id_FK
		+"&applicant_citizen_id_FK="+applicant_citizen_id_FK
		+"&applicant_marital_status_FK="+applicant_marital_status_FK
		+"&applicant_residency_FK="+applicant_residency_FK
		+"&applicant_visa_type_FK="+applicant_visa_type_FK
		+"&applicant_current_employment_status="+applicant_current_employment_status
		+"&applicant_current_employment_poistion="+applicant_current_employment_poistion
		+"&applicant_current_employer_text="+applicant_current_employer_text
		+"&applicant_applying_position_id_FK="+applicant_applying_position_id_FK
		+"&applicant_availibility_FK="+applicant_availibility_FK
		+"&applicant_profession_FK="+applicant_profession_FK
		+"&applicant_speciality="+applicant_speciality
		+"&applicant_education_level_FK="+applicant_education_level_FK
		+"&applicant_institution_name="+applicant_institution_name
		+"&applicant_board_certified_id_FK="+applicant_board_certified_id_FK
		+"&applicant_hold_haad_license="+applicant_hold_haad_license
		+"&applicant_hold_dha_license="+applicant_hold_dha_license
		+"&applicant_contact_reference="+applicant_contact_reference
		+"&applicant_available_start_date="+applicant_available_start_date
		+"&applicant_cv_id_FK="+applicant_cv_id_FK
		+"&other_visa_type="+other_visa_type
		+"&other_position="+other_position
		+"&other_profession="+other_profession
		+"&other_board="+other_board
		+"&applicant_llicense_id_FK="+result
		+"&action=7";
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
			//server_loader("html/module/human_resouces/pre_employment/view/human_ressource_pool.php","sub-content-wrapper","meni_id=16","loading Applicant")
		}
	},
	error: function(xhr, textStatus, errorThrown)
	{
		alert('Something went wrong in applicant...');
	}
	});	
}

function submit_save_applicant_interview(applicant_id,template_id,flow_id,counter,questions_array,types_array)
{

	var res_questions = questions_array.split(",");
	var res_type	  = types_array.split(",");
	var sub_array = [];
    var results = [];

	for(var i=0;i<res_questions.length-1;i++)
	{
		if(res_type[i]=="0")
		{
			var radioValue=$("#answer_"+i).val();
		}
		else
		{
        	radioValue=-1;
			var radioValue = $("input[name='radio_"+i+"']:checked").val();
		}
			sub_array.push(radioValue);
	}
	results.push(sub_array);

	var div_id="save_interview_div";
	var page_name="pre_employment/controller/human_ressource_controller.php";
		
	var parameter=
		"applicant_id="+applicant_id+
		"&template_id="+template_id+
		"&flow_id="+flow_id+
		"&res_questions="+JSON.stringify(res_questions)+
		"&results="+JSON.stringify(results)+
		"&action=5";

	$.ajax({
		type: 'POST',
		url:page_name,
		data:parameter,
		dataType: "html",
		success: function(result) 
		{
			$('#' + div_id).html(result);
			get_applicant_details(applicant_id,flow_id);
			//server_loader("html/module/human_resouces/pre_employment/view/applicant_interview_main_view.php","sub-content-wrapper","meni_id=16","loading Applicant")
		},
		error: function(xhr, textStatus, errorThrown)
		{
			alert('Something went wrong in Saving...');
		}
	});
}

function submit_update_applicant_interview(applicant_id,template_id,flow_id,counter,questions_array,types_array,interview_id)
{
	//alert(".....");

	var res_questions = questions_array.split(",");
	var res_type	  = types_array.split(",");
	var sub_array = [];
    var results = [];
	//alert(res_questions);
	//alert(res_type);
	for(var i=0;i<res_questions.length-1;i++)
	{
		if(res_type[i]=="0")
		{
			var radioValue=$("#answer_"+i).val();
		}
		else
		{
        	radioValue=-1;
			var radioValue = $("input[name='radio_"+i+"']:checked").val();
		}
			sub_array.push(radioValue);
	}
	results.push(sub_array);

	var div_id="save_interview_div";
	var page_name="pre_employment/controller/human_ressource_controller.php";
		
	var parameter=
		"applicant_id="+applicant_id+
		"&template_id="+template_id+
		"&flow_id="+flow_id+
		"&res_questions="+JSON.stringify(res_questions)+
		"&results="+JSON.stringify(results)+
		"&interview_id="+interview_id+
		"&action=6";

	$.ajax({
		type: 'POST',
		url:page_name,
		data:parameter,
		dataType: "html",
		success: function(result) 
		{
			$('#' + div_id).html(result);
			get_applicant_details(applicant_id,flow_id);
			$(".modal.in").modal("hide");
		},
		error: function(xhr, textStatus, errorThrown)
		{
			alert('Something went wrong in Saving...');
		}
	});
}


function initialize_file_form()
{
			$('#applicant_cv_id_FK').change(function(){ 
			//on change event
			formdata = new FormData();
			if($(this).prop('files').length > 0)
			{
				file =$(this).prop('files')[0];
				formdata.append("att", file);
				formdata.append("applicant_id", applicant_id);

				jQuery.ajax({
					url: "../controller/file_uploader_controller.php",
					type: "POST",
					data: formdata,
					processData: false,
					contentType: false,
					success: function (result) {
						$('#applicant_op_div').html(result);
					}
				});	
			}
		});
}

function edit_applicant (applicant_id) {
	var page_name="pre_employment/view/human_ressource_form.php";
	var div_id="sub-content-wrapper";
	var parameter="applicant_id="+applicant_id+"&action=1";

		show_loading_gif(div_id,"Loading Applicant infos..");
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

function submit_delete_applicant(applicant_id){
	//alert(applicant_id);
	var s=confirm("Are you sure you want to Cancel this Applicant?");
		if(s)
		{
			//alert(applicant_id);
			var div_id="div_section_content";
			var page_name="pre_employment/controller/human_ressource_controller.php";
			var parameter="applicant_id="+applicant_id+"&action=3";
			
				show_loading_gif(div_id,"Deleting Applicant ..");
				var Ajax = $.ajax({
				type: 'POST',
				url: page_name,
				data: parameter,
				success: function(result) {
					$('#' + div_id).html(result);
					server_loader("html/module/human_resouces/pre_employment/view/human_ressource_delete_form.php","sub-content-wrapper","meni_id=16","loading Applicant")
				},
				error: function(xhr, textStatus, errorThrown) {
					alert('Something went wrong...');
				}
			});
			return Ajax;	
		}
}

function assign_to_applicants (applicant_id){
	var page_name="pre_employment/view/assign_modal.php";
	var div_id="modal_default";
	var parameter="applicant_id="+applicant_id;
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

function save_assigned_flow (applicant_id) {
	//alert(request_id);
	//var opening_id_FK=$('#opening_id_FK').val();
	var opening_id_FK = [];  
        $('.Get_this').each(function(){  
            if($(this).is(":checked"))  
            {  
                opening_id_FK.push($(this).val());  
            }  
        });  
    //opening_id_FKVal = opening_id_FK.toString();
	var opening_description=$('#opening_description').val();

	var div_id="div_section_content";
	var page_name="pre_employment/controller/human_ressource_controller.php";
	var parameter=
		"applicant_id="+applicant_id+
		"&opening_id_FK="+opening_id_FK+
		"&opening_description="+opening_description+
		"&action=4";
		show_loading_gif(div_id,"Assign Flow ..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);
			$(".modal.in").modal("hide");
			//get_applicant_details();
			server_loader("html/module/human_resouces/pre_employment/view/human_ressource_pool.php","sub-content-wrapper","meni_id=16","loading Applicant")
			//alert('Will Done!!!...');
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;
}



function updated_assigned_flow (template_id,applicant_id,interview_id,flow_id){
	//alert("let Start");
	var page_name="pre_employment/view/flow_update_view.php";
	var div_id="modal_default";
	var parameter=
		"template_id="+template_id+
		"&applicant_id="+applicant_id+
		"&interview_id="+interview_id+
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
	return Ajax
}

function get_list_applicants(flow_id,status_id,request_id) {
	//alert(status_id);
	var page_name="pre_employment/view/applicants_list_view.php";
	var div_id="sub-content-wrapper";
	var parameter="flow_id="+flow_id+"&status_id="+status_id+"&request_id="+request_id;

		show_loading_gif(div_id,"Loading ..");
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

function get_applicant_details(applicant_id,flow_id,status_id,request_id){
	//alert(flow_id);
	//alert("Get Applicants Details");
	var page_name="pre_employment/view/applicant_info_view.php";
	var div_id="sub-content-wrapper";
	var parameter="applicant_id="+applicant_id+"&flow_id="+flow_id+"&status_id="+status_id+"&request_id="+request_id;

		show_loading_gif(div_id,"Loading ..");
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
function get_template_form(applicant_id,flow_id,status_id)
{
	var template_id=$('#template_id').val();
	var page_name="pre_employment/view/evaluation_form_view.php";
	var div_id="sub-content-wrapper";
	var parameter="applicant_id="+applicant_id+"&template_id="+template_id+"&flow_id="+flow_id+"&status_id="+status_id;

		show_loading_gif(div_id,"Loading ..");
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
function get_template_1_form(applicant_name,template_id){
	//alert(template_id);
	var page_name="pre_employment/view/evaluation_form_view.php";
	var div_id="sub-content-wrapper";
	var parameter="applicant_name="+applicant_name+"&template_id="+template_id;

		show_loading_gif(div_id,"Loading ..");
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

function load_resume(file){
	var page_name="pre_employment/view/resum_modal.php";
	var div_id="sub-content-wrapper";
	var parameter="file="+file;

		show_loading_gif(div_id,"Loading ..");
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

 function back_to_pool(){
	var page_name="pre_employment/view/human_ressource_pool.php";
	var div_id="sub-content-wrapper";
	var parameter="";

		show_loading_gif(div_id,"Loading ..");
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
