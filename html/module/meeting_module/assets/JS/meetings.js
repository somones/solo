function submit_save_meeting(meeting_id)
{
	var meeting_title=$('#meeting_title').val();
	var meeting_room=$('#meeting_room').val();
	var meeting_start_date_time=$('#meeting_start_date_time').val();
	var meeting_end_date_time=$('#meeting_end_date_time').val();
	var meeting_description=$('#meeting_description').val();
	meeting_description=encodeURIComponent(meeting_description);
	var items = [];
	$('#meeting_attendees option:selected').each(function(){ items.push($(this).val()); });
	var result = items.join(', ');	
	
	var div_id="meeting_op_div";
	var page_name="../controller/meetings_controller.php";
	var parameter=
		"meeting_title="+meeting_title+
		"&meeting_id="+meeting_id+
		"&meeting_start_date_time="+meeting_start_date_time+
		"&meeting_end_date_time="+meeting_end_date_time+
		"&meeting_description="+meeting_description+
		"&action=1"+
		"&meeting_room="+meeting_room+
		"&attendees="+result;
		
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
			edit_meeting(result["return_value"]);
		}
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong...');
	}
	});	
}

function submit_edit_meeting(meeting_id)
{
	var meeting_title=$('#meeting_title').val();
	var meeting_room=$('#meeting_room').val();
	var meeting_start_date_time=$('#meeting_start_date_time').val();
	var meeting_end_date_time=$('#meeting_end_date_time').val();
	var meeting_description=$('#meeting_description').val();
	
	meeting_description=encodeURIComponent(meeting_description);
	var items = [];
	$('#meeting_attendees option:selected').each(function(){ items.push($(this).val()); });
	var result = items.join(', ');	
	
	alert(result);
	
	var div_id="meeting_op_div";
	var page_name="../controller/meetings_controller.php";
	var parameter="meeting_title="+meeting_title+"&meeting_id="+meeting_id+"&meeting_start_date_time="+meeting_start_date_time+"&meeting_end_date_time="+meeting_end_date_time+"&meeting_description="+meeting_description+"&action=1&meeting_room="+meeting_room+"&attendees="+result;
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "html",
	success: function(result) 
	{
		$('#' + div_id).html(result);
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong...');
	}
	});	
}

function submit_delete_meeting(meeting_id){
	var s=confirm("Are you sure you want to Cancel this meeting?");
		if(s)
		{
			//alert(meeting_id);
			var div_id="div_section_content";
			var page_name="../controller/meetings_controller.php";
			var parameter="meeting_id="+meeting_id+"&action=3";
			
				show_loading_gif(div_id,"Deleting Meeting ..");
				var Ajax = $.ajax({
				type: 'POST',
				url: page_name,
				data: parameter,
				success: function(result) {
					$('#' + div_id).html(result);
					server_loader("html/module/meeting_module/view/delete_meeting.php","sub-content-wrapper","meni_id=16","loading Meetings")
				},
				error: function(xhr, textStatus, errorThrown) {
					alert('Something went wrong...');
				}
			});
			return Ajax;	
		}
}

function edit_meeting (meeting_id) {
	var page_name="../view/meeting_form.php";
	var div_id="sub-content-wrapper";
	var parameter="meeting_id="+meeting_id+"&action=2";

		show_loading_gif(div_id,"Loading Meeting Content..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			$("[name='data_grid']").DataTable();
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;	
}

function meeting_info (meeting_id) {
	var page_name="../view/meeting_info.php";
	var div_id="sub-content-wrapper";
	var parameter="meeting_id="+meeting_id+"&action=2";

		show_loading_gif(div_id,"Loading Meeting Content..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			$("[name='data_grid']").DataTable();
			initSample();
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;	
}

function submit_save_html_content(meeting_id)
{
	var content=CKEDITOR.instances.editor.getData();
	meeting_mom=encodeURIComponent(content);

	var div_id="meeting_info_div";
	var page_name="../controller/meetings_controller.php";
	var parameter="meeting_id="+meeting_id+"&meeting_mom="+meeting_mom+"&action=4";
	
		show_loading_gif(div_id,"Updating Meeting ..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			//alert(result);
			$('#' + div_id).html(result);
			$(".modal.in").modal("hide");
			//server_loader("html/module/meeting_module/view/list_meeting.php","sub-content-wrapper","meni_id=16","loading Meetings")
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong HERE...');
		}
	});
	return Ajax;
}