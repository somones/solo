// ----------------------------------------- BILLING ITEMS ---------------------------------------------------

function get_doctor_form(doctor_id)
{
	var page_name="../consent/view/doctor_form.php";
	var div_id="modal_default";
	var parameter="doctor_id="+doctor_id;
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

function save_this_doctor(doctor_id)
{
	//alert(doctor_id);
	var doctor_title=$('#doctor_title').val();
	var doctor_name=$('#doctor_name').val();
	var doctor_email=$('#doctor_email').val();
	var doctor_phone_number=$('#doctor_phone_number').val();
	var doctor_extension=$('#doctor_extension').val();
	var doctor_hr_number=$('#doctor_hr_number').val();
	var doctor_departement_FK=$('#doctor_departement_FK').val();
	var doctor_specialty_FK=$('#doctor_specialty_FK').val();
	var doctor_experience=$('#doctor_experience').val();
	var doctor_nationality=$('#doctor_nationality').val();
	var doctor_gender=$('#doctor_gender').val();
	var user_id_FK=$('#user_id_FK').val();

	var items = [];
	$('#doctor_branch_FK option:selected').each(function(){ items.push($(this).val()); });
	var result = items.join(', ');	

	var div_id="doctor_form_div";
	var page_name="../consent/controller/doctor_controller.php";
	var parameter=
		"doctor_id="+doctor_id+
		"&doctor_title="+doctor_title+
		"&doctor_name="+doctor_name+
		"&doctor_email="+doctor_email+
		"&doctor_phone_number="+doctor_phone_number+
		"&doctor_extension="+doctor_extension+
		"&doctor_hr_number="+doctor_hr_number+
		"&doctor_branch_FK="+result+
		"&doctor_departement_FK="+doctor_departement_FK+
		"&doctor_specialty_FK="+doctor_specialty_FK+
		"&doctor_experience="+doctor_experience+
		"&doctor_nationality="+doctor_nationality+
		"&doctor_gender="+doctor_gender+
		"&user_id_FK="+user_id_FK+
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
			server_loader("html/module/consent/view/doctor_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
		}	
	},
	error: function(xhr, textStatus, errorThrown)
	{
		alert('Something went wrong is ...');
	}
	});	
}

function delete_this_doctor(doctor_id){
	//alert(doctor_id);
	var s=confirm("Are you sure you want to Delete this Doctor?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="doctor_form_div";
		var page_name="../consent/controller/doctor_controller.php";
		var parameter="doctor_id="+doctor_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The Consent Category ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/consent/view/doctor_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}