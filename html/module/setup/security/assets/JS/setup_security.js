function get_role_form(role_id)
{
	var page_name="security/view/add_role.php";
	var div_id="modal_default";
	var parameter="role_id="+role_id;
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

function set_role_previlige(role_id)
{
	var page_name="security/view/role_previlige.php";
	var div_id="sub-content-wrapper";
	var parameter="role_id="+role_id;
	//$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: true}); 
   
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

function save_role(role_id)
{
	var role_name=$('#role_name').val();
	var role_description=$('#role_description').val();

	var div_id="security_form_div";
	var page_name="security/controller/role_controller.php";
	var parameter="role_id="+role_id+"&role_name="+role_name+"&role_description="+role_description+"&action=1";
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "json",
	success: function(result) 
	{
		$('#' + div_id).html(result["return_html"]);
		if(result["success"]==1)
		{
			server_loader("html/module/setup/security/view/security_groups_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			//Close the modal
			
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is setup_security...');
	}
	});	
}


function delete_role(role_id){
	var s=confirm("Are you sure you want to Delete this Role?");
		if(s)
		{
			//alert(meeting_id);
			var div_id="security_form_div";
			var page_name="security/controller/role_controller.php";
			var parameter="role_id="+role_id+"&action=2";
			
				show_loading_gif(div_id,"Deleting The Role ..");
				var Ajax = $.ajax({
				type: 'POST',
				url: page_name,
				data: parameter,
				success: function(result) {
					$('#' + div_id).html(result);
					server_loader("html/module/setup/security/view/security_groups_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				},
				error: function(xhr, textStatus, errorThrown) {
					alert('Something went wrong...');
				}
			});
			return Ajax;	
		}
}

function submit_save_permissions(counter,role_id)
{
	var array=new Array();
	for(var i=0;i<counter;i++)
	{
		if($('#menu_item_checkbox_'+i).is(":checked"))
			 array.push($('#menu_item_checkbox_'+i).val()); 
		
	}
		var div_id="permissions_div";
		var page_name="security/controller/role_controller.php";
		var parameter="role_id="+role_id+"&action=3"+"&array="+array;
				show_loading_gif(div_id,"Deleting The Role ..");
				var Ajax = $.ajax({
				type: 'POST',
				url: page_name,
				data: parameter,
				success: function(result) {
					$('#' + div_id).html(result);
					//server_loader("html/module/setup/security/view/security_groups_main_view.php","sub-content-wrapper","meni_id=16","loading Meetings")
				},
				error: function(xhr, textStatus, errorThrown) {
					alert('Something went wrong...');
				}
			});
			return Ajax;	
}

function assign_roles_to_users(role_id)
{
	var page_name="security/view/assign_role.php";
	var div_id="modal_default";
	var parameter="role_id="+role_id;
	$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: true}); 
   
		show_loading_gif(div_id,"Loading Form..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			//$("[name='data_grid']").DataTable();
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;
}


function update_role_users(role_id,counter)
{
	var array=new Array();
	for(var i=0;i<counter;i++)
	{
		if($('#employee_checkbox_'+i).is(":checked"))
			 array.push($('#employee_checkbox_'+i).val()); 
		
	}	


		var page_name="security/controller/role_controller.php";	
		var div_id="assign_roles_div";
		var parameter="role_id="+role_id+"&array="+array+"&action=4";
		show_loading_gif(div_id,"Assigning Users..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			//$("[name='data_grid']").DataTable();
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;
}