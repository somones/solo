function update_profile(user_id)
{
	var branch_id_FK				=$('#branch_id_FK').val();
	var department_id_FK			=$('#department_id_FK').val();
	var employee_full_name			=$('#employee_full_name').val();
	var employee_job_title			=$('#employee_job_title').val();
	var employee_dob				=$('#employee_dob').val();
	var employee_number				=$('#employee_number').val();
	
	var div_id="profile_form_div";
	var page_name	="../controller/profile_controller.php";
	var parameter="user_id="+user_id+"&branch_id_FK="+branch_id_FK+"&department_id_FK="+department_id_FK+"&employee_full_name="+employee_full_name+"&employee_job_title="+employee_job_title+"&employee_dob="+employee_dob+"&employee_number="+employee_number+"&action=1";
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "html",
	success: function(result) 
	{
		$('#' + div_id).html(result);
		if(result["success"]==1)
		{
			server_loader("html/module/profile/view/profile_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is save Profile...');
	}
	});	
}