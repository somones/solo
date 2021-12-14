function get_user_form(user_id){
	var page_name="user_and_employee/view/user_form_modal.php";
	var div_id="modal_default";
	var parameter="user_id="+user_id;
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

function save_this_user(user_id) {
	
	var branch_id=$('#branch_id').val();
	var department_id=$('#department_id').val();
	var employee_full_name=$('#employee_full_name').val();
	var employee_dob=$('#employee_dob').val();
	var employee_job_title=$('#employee_job_title').val();
	var employee_number=$('#employee_number').val();
	var employee_email=$('#employee_email').val();

	var employee_active=$('#employee_active').val();
	var profile_completed=$('#profile_completed').val();

	var items = [];
	$('#roles_id_FK option:selected').each(function(){ items.push($(this).val()); });
	var result = items.join(', ');

	var div_id="user_form_div";
	var page_name="user_and_employee/controller/user_controller.php";
	var parameter=
		"user_id="+user_id+
		"&branch_id="+branch_id+
		"&department_id="+department_id+
		"&employee_full_name="+employee_full_name+
		"&employee_dob="+employee_dob+
		"&employee_job_title="+employee_job_title+
		"&employee_number="+employee_number+
		"&employee_email="+employee_email+
		"&roles_id_FK="+result+
		"&employee_active="+employee_active+
		"&profile_completed="+profile_completed+
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
			$('#' + div_id).html(result['return_html']);
			$(".modal.in").modal("hide");
			if (user_id == -1) {} else {
				server_loader("html/module/setup/user_and_employee/view/user_main_view.php","sub-content-wrapper","menu_id=74","loading Meetings")
			}
			
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is ...');
	}
	});	
}

function delete_this_user(user_id) {
	alert(user_id);
	var s=confirm("Are you sure you want to Delete this User?");
	if(s)
	{
		//alert(user_id);
		var div_id="div_section_content";
		var page_name="user_and_employee/controller/user_controller.php";
		var parameter="user_id="+user_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting Request ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/setup/user_and_employee/view/user_main_view.php","sub-content-wrapper","menu_id=74","loading Meetings")
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}

function new_session(user_id) {
	var page_name="user_and_employee/controller/user_controller.php";
	var parameter="user_id="+user_id+"&action=3";
	$.ajax({
		type: 'POST',
		url:page_name,
		data:parameter,
		success: function(result) {
			location.replace("http://www.fakihivfcms.com")
		},
		error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
		}
	});	
}

function get_result() {

	var employee_name=$('#employee_name').val();
	var job_title=$('#job_title').val();
	//var role_id=$('#role_id').val();
	var hr_number=$('#hr_number').val();
	var employee_email=$('#employee_email').val();
	var branch_id=$('#branch_id').val();
	var department_id=$('#department_id').val();
	var isComplete=$('#isComplete').val();
	var isActive=$('#isActive').val();

	$.ajax({
		type: 'POST',
		dataType: "html",
		success: function(result)
		{
			load_search_result(employee_name,job_title,hr_number,employee_email,branch_id,department_id,isComplete,isActive)
		},
		error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
		{
			alert('Something went wrong is ...');
		}
	});
}

function load_search_result(employee_name,job_title,hr_number,employee_email,branch_id,department_id,isComplete,isActive) {
	var div_id="table_result";
    var parameter=
    	"employee_name="+employee_name+
    	"&job_title="+job_title+
    	"&hr_number="+hr_number+
    	"&employee_email="+employee_email+
    	"&branch_id="+branch_id+
    	"&department_id="+department_id+
    	"&isComplete="+isComplete+
    	"&isActive="+isActive;

    var page_name="user_and_employee/view/search_config.php";
	show_loading_gif(div_id,"Loading Orders...");
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
