// ----------------------------------------- CODE ---------------------------------------------------

function get_code_form(code_id)
{
	var page_name="master_settings/view/code_form.php";
	var div_id="modal_default";
	var parameter="code_id="+code_id;
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

function save_code(code_id)
{
	//alert(code_id);
	var code_type_id_FK=$('#code_type_id_FK').val();
	var code_value=$('#code_value').val();
	var code_short_description=$('#code_short_description').val();
	var code_description=$('#code_description').val();

	var div_id="code_form_div";
	var page_name="master_settings/controller/master_settings_controller.php";
	var parameter=
		"code_id="+code_id+
		"&code_type_id_FK="+code_type_id_FK+
		"&code_value="+code_value+
		"&code_short_description="+code_short_description+
		"&code_description="+code_description+
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
			server_loader("html/module/revenue_cycle/master_settings/view/code_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			$(".modal.in").modal("hide");
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is setup_security...');
	}
	});	
}

function delete_role(code_id){
	//alert(code_id);
	var s=confirm("Are you sure you want to Delete this Code?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="code_form_div";
		var page_name="master_settings/controller/master_settings_controller.php";
		var parameter="code_id="+code_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The Code ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/revenue_cycle/master_settings/view/code_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}

// ----------------------------------------- CODETYPE ---------------------------------------------------

function get_code_type_from(code_type_id)
{
	var page_name="master_settings/view/code_type_from.php";
	var div_id="modal_default";
	var parameter="code_type_id="+code_type_id;
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

function save_code_type(code_type_id)
{
	//alert(code_type_id);
	var code_type_name=$('#code_type_name').val();
	var code_type_description=$('#code_type_description').val();
	var code_type_insurance_id_FK=$('#code_type_insurance_id_FK').val();
	var code_type_category_id_FK=$('#code_type_category_id_FK').val();

	var div_id="code_form_div";
	var page_name="master_settings/controller/master_settings_controller.php";
	var parameter=
		"code_type_id="+code_type_id+
		"&code_type_name="+code_type_name+
		"&code_type_description="+code_type_description+
		"&code_type_insurance_id_FK="+code_type_insurance_id_FK+
		"&code_type_category_id_FK="+code_type_category_id_FK+
		"&action=3";

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
			$('#' + div_id).html(result);
			server_loader("html/module/revenue_cycle/master_settings/view/code_type_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			$(".modal.in").modal("hide");
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is setup_security...');
	}
	});		
}

function delete_code_type(code_type_id){
	//alert(code_type_id);
	var s=confirm("Are you sure you want to Delete this Code?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="code_form_div";
		var page_name="master_settings/controller/master_settings_controller.php";
		var parameter="code_type_id="+code_type_id+"&action=4";
		
			show_loading_gif(div_id,"Deleting The Code ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/revenue_cycle/master_settings/view/code_type_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}