// ----------------------------------------- BILLING ITEMS ---------------------------------------------------

function get_biiling_item_form(billing_item_id)
{
	var page_name="billing_settings/view/billing_items_form.php";
	var div_id="modal_default";
	var parameter="billing_item_id="+billing_item_id;
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

function save_billing_item(billing_item_id)
{
	//alert(billing_item_id);
	var item_category_id_FK=$('#item_category_id_FK').val();
	var item_description=$('#item_description').val();
	var item_code_id_FK=$('#item_code_id_FK').val();
	var item_code_value=$('#item_code_value').val();
	var tax_profile_id_FK=$('#tax_profile_id_FK').val();
	var tax_value=$('#tax_value').val();

	var div_id="code_form_div";
	var page_name="billing_settings/controller/billing_settings_controller.php";
	var parameter=
		"billing_item_id="+billing_item_id+
		"&item_category_id_FK="+item_category_id_FK+
		"&item_description="+item_description+
		"&item_code_id_FK="+item_code_id_FK+
		"&item_code_value="+item_code_value+
		"&tax_profile_id_FK="+tax_profile_id_FK+
		"&tax_value="+tax_value+
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
			server_loader("html/module/revenue_cycle/billing_settings/view/billing_items_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			$(".modal.in").modal("hide");
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is setup_security...');
	}
	});	
}

function delete_billing_item(billing_item_id){
	//alert(billing_item_id);
	var s=confirm("Are you sure you want to Delete this Item?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="code_form_div";
		var page_name="billing_settings/controller/billing_settings_controller.php";
		var parameter="billing_item_id="+billing_item_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The Code ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/revenue_cycle/billing_settings/view/billing_items_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}

// ----------------------------------------- BILLING ITEMS CATEGORIES ---------------------------------------------------

function get_biiling_item_categories_form(category_id)
{
	var page_name="billing_settings/view/billing_item_categories_form.php";
	var div_id="modal_default";
	var parameter="category_id="+category_id;
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

function save_billing_item_categories(category_id)
{
	//alert(category_id);
	var category_description=$('#category_description').val();

	var div_id="code_form_div";
	var page_name="billing_settings/controller/billing_settings_controller.php";
	var parameter=
		"category_id="+category_id+
		"&category_description="+category_description+
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
			server_loader("html/module/revenue_cycle/billing_settings/view/billing_item_categories_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			$(".modal.in").modal("hide");
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is setup_security...');
	}
	});	
}

function delete_billing_item_categories(category_id){
	//alert(category_id);
	var s=confirm("Are you sure you want to Delete this Category?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="code_form_div";
		var page_name="billing_settings/controller/billing_settings_controller.php";
		var parameter="category_id="+category_id+"&action=4";
		
			show_loading_gif(div_id,"Deleting The Code ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/revenue_cycle/billing_settings/view/billing_item_categories_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}
