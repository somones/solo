// ----------------------------------------- CODE ---------------------------------------------------

function get_menu_item_form(item_id)
{
	var page_name="menu/view/menu_item_form.php";
	var div_id="modal_default";
	var parameter="item_id="+item_id;
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

function save_menu_item(item_id)
{
	//alert(item_id);
	var category_id_FK=$('#category_id_FK').val();
	var item_title=$('#item_title').val();
	var page_path=$('#page_path').val();

	var div_id="modules_form_div";
	var page_name="menu/controller/menu_item_controller.php";
	var parameter=
		"item_id="+item_id+
		"&category_id_FK="+category_id_FK+
		"&item_title="+item_title+
		"&page_path="+page_path+
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
			server_loader("html/module/setup/menu/view/menu_item_main_view.php","sub-content-wrapper","menu_id=16","loading ....")
			$(".modal.in").modal("hide");
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is setup_security...');
	}
	});	
}

function delete_menu_item(item_id){
	//alert(item_id);
	var s=confirm("Are you sure you want to Delete this Menu Item?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="modules_form_div";
		var page_name="menu/controller/menu_item_controller.php";
		var parameter="item_id="+item_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The ...");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/setup/menu/view/menu_item_main_view.php","sub-content-wrapper","menu_id=16","loading ....")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}