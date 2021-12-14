function submit_save_applicant(applicant_id)
{
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
			//server_loader("html/module/human_resouces/../view/human_ressource_pool.php","sub-content-wrapper","meni_id=16","loading Applicant")
		}
	},
	error: function(xhr, textStatus, errorThrown)
	{
		alert('Something went wrong in applicant...');
	}
	});	
}