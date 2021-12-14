// ----------------------------------------- BILLING ITEMS ---------------------------------------------------

function get_patient_form(patient_id)
{
	var page_name="../view/patient_form.php";
	var div_id="modal_default";
	var parameter="patient_id="+patient_id;
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

function save_this_patient(patient_id)
{
	var consent_category_name=$('#consent_category_name').val();
	var consent_category_description=$('#consent_category_description').val();

	var div_id="consent_category_form_div";
	var page_name="../controller/consent_category_controller.php";
	var parameter=
		"patient_id="+patient_id+
		"&consent_category_name="+consent_category_name+
		"&consent_category_description="+consent_category_description+
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
			server_loader("html/module/consent/view/consent_category_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is ...');
	}
	});	
}

function delete_this_patient(patient_id){
	//alert(patient_id);
	var s=confirm("Are you sure you want to Delete this Consent Category?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="consent_category_form_div";
		var page_name="../controller/consent_category_controller.php";
		var parameter="patient_id="+patient_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The Consent Category ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/consent/view/consent_category_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}