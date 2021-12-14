// ----------------------------------------- CODE ---------------------------------------------------

function get_module_form(module_id)
{
	var page_name="menu/view/modules_form.php";
	var div_id="modal_default";
	var parameter="module_id="+module_id;
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

function save_module(module_id)
{
	//alert(module_id);
	var module_name=$('#module_name').val();
	var module_url=$('#module_url').val();

	var div_id="modules_form_div";
	var page_name="menu/controller/modules_controller.php";
	var parameter=
		"module_id="+module_id+
		"&module_name="+module_name+
		"&module_url="+module_url+
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
			server_loader("html/module/setup/menu/view/modules_main_view.php","sub-content-wrapper","menu_id=16","loading ....")
			$(".modal.in").modal("hide");
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is save module...');
	}
	});	
}

function delete_module(module_id){
	//alert(module_id);
	var s=confirm("Are you sure you want to Delete this Module?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="modules_form_div";
		var page_name="menu/controller/modules_controller.php";
		var parameter="module_id="+module_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/setup/menu/view/modules_main_view.php","sub-content-wrapper","menu_id=16","loading ....")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}