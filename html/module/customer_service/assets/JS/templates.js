// ----------------------------------------- BILLING ITEMS ---------------------------------------------------
function get_templates_category_form(message_templates_categories_id)
{
	var page_name="../view/templates_categories_form.php";
	var div_id="modal_default";
	var parameter="message_templates_categories_id="+message_templates_categories_id;
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
			alert('Error...');
		}
	});
	return Ajax;
}

function save_this_templates_category(message_templates_categories_id)
{
	var message_templates_categories_name=$('#message_templates_categories_name').val();
	var message_templates_categories_description=$('#message_templates_categories_description').val();
	var message_templates_categories_branch_id_FK=$('#message_templates_categories_branch_id_FK').val();

	var div_id="conact_form_div";
	var page_name="../controller/messages_template_controller.php";
	var parameter=
		"message_templates_categories_id="+message_templates_categories_id+
		"&message_templates_categories_name="+message_templates_categories_name+
		"&message_templates_categories_description="+message_templates_categories_description+
		"&message_templates_categories_branch_id_FK="+message_templates_categories_branch_id_FK+
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
			server_loader("html/module/customer_service/view/templates_categories_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is setup_security...');
	}
	});	
}

function delete_this_templates_category(message_templates_categories_id){
	//alert(contact_id);
	var s=confirm("Are you sure you want to Delete this Category?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="conact_form_div";
		var page_name="../controller/messages_template_controller.php";
		var parameter="message_templates_categories_id="+message_templates_categories_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting Template Category ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/customer_service/view/templates_categories_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}

// ----------------------------------------- BILLING ITEMS ---------------------------------------------------
function get_message_templates_form(message_template_id)
{
	var page_name="../view/message_template_form.php";
	var div_id="modal_default";
	var parameter="message_template_id="+message_template_id;
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
			alert('Error...');
		}
	});
	return Ajax;
}

function save_this_templates(message_template_id)
{
	var message_template_name=$('#message_template_name').val();
	var message_template_categorie_id_FK=$('#message_template_categorie_id_FK').val();
	var message_template_description=$('#message_template_description').val();

	var div_id="conact_form_div";
	var page_name="../controller/messages_template_controller.php";
	var parameter=
		"message_template_id="+message_template_id+
		"&message_template_name="+message_template_name+
		"&message_template_categorie_id_FK="+message_template_categorie_id_FK+
		"&message_template_description="+message_template_description+
		"&action=3";
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
			server_loader("html/module/customer_service/view/templates_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is ...');
	}
	});	
}

function delete_this_templates(message_template_id){
	//alert(contact_id);
	var s=confirm("Are you sure you want to Delete this Template?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="conact_form_div";
		var page_name="../controller/messages_template_controller.php";
		var parameter="message_template_id="+message_template_id+"&action=4";
		
			show_loading_gif(div_id,"Deleting Template Category ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/customer_service/view/templates_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}