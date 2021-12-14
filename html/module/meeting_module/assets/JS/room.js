// ----------------------------------------- CODE ---------------------------------------------------

function get_meeting_room_form(room_id)
{
	var page_name="../view/meeting_room_form.php";
	var div_id="modal_default";
	var parameter="room_id="+room_id;
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

function save_meeting_room(room_id)
{
	var room_title=$('#room_title').val();
	var room_description=$('#room_description').val();
	var branch_id_FK=$('#branch_id_FK').val();
	var room_capacity=$('#room_capacity').val();

	var div_id="modules_form_div";
	var page_name="../controller/meeting_room_controller.php";
	var parameter=
		"room_id="+room_id+
		"&room_title="+room_title+
		"&room_description="+room_description+
		"&branch_id_FK="+branch_id_FK+
		"&room_capacity="+room_capacity+
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
			server_loader("html/module/meeting_module/view/meeting_room_main_view.php","sub-content-wrapper","menu_id=16","loading ....")
			
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is save module...');
	}
	});	
}

function delete_meeting_room(room_id){
	//alert(room_id);
	var s=confirm("Are you sure you want to Delete this Room?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="modules_form_div";
		var page_name="../controller/meeting_room_controller.php";
		var parameter="room_id="+room_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/meeting_module/view/meeting_room_main_view.php","sub-content-wrapper","menu_id=16","loading ....")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}