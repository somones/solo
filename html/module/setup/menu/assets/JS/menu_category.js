// ----------------------------------------- CODE ---------------------------------------------------

function get_menu_category_form(category_id)
{
	var page_name="menu/view/menu_category_form.php";
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

function save_menu_category(category_id)
{
	//alert(category_id);
	var category_name=$('#category_name').val();
	var module_id_FK=$('#module_id_FK').val();
	var display_order=$('#display_order').val();

	var div_id="modules_form_div";
	var page_name="menu/controller/category_controller.php";
	var parameter=
		"category_id="+category_id+
		"&category_name="+category_name+
		"&module_id_FK="+module_id_FK+
		"&display_order="+display_order+
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
			server_loader("html/module/setup/menu/view/menu_category_main_view.php","sub-content-wrapper","menu_id=16","loading ....")
			$(".modal.in").modal("hide");
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is setup_security...');
	}
	});	
}

function delete_menu_category(category_id){
	//alert(category_id);
	var s=confirm("Are you sure you want to Delete this Menu Category?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="modules_form_div";
		var page_name="menu/controller/category_controller.php";
		var parameter="category_id="+category_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The Code ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/setup/menu/view/menu_category_main_view.php","sub-content-wrapper","menu_id=16","loading ....")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}