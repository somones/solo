// ----------------------------------------- BILLING ITEMS ---------------------------------------------------

function get_speciality_form(speciality_id)
{
	var page_name="../view/speciality_form.php";
	var div_id="modal_default";
	var parameter="speciality_id="+speciality_id;
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

function save_this_speciality(speciality_id)
{
	var speciality_title=$('#speciality_title').val();
	var speciality_description=$('#speciality_description').val();

	var div_id="speciality_form_div";
	var page_name="../controller/speciality_controller.php";
	var parameter=
		"speciality_id="+speciality_id+
		"&speciality_title="+speciality_title+
		"&speciality_description="+speciality_description+
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
			server_loader("html/module/consent/view/speciality_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is ...');
	}
	});	
}

function delete_this_speciality(speciality_id){
	//alert(speciality_id);
	var s=confirm("Are you sure you want to Delete this Speciality?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="speciality_form_div";
		var page_name="../controller/speciality_controller.php";
		var parameter="speciality_id="+speciality_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting This Speciality ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/consent/view/speciality_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}