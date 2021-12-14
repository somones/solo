// ----------------------------------------- BILLING ITEMS ---------------------------------------------------

function get_consent_category_form(consent_category_id)
{
	var page_name="../view/consent_category_form.php";
	var div_id="modal_default";
	var parameter="consent_category_id="+consent_category_id;
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

function save_this_consent_category(consent_category_id)
{
	var consent_category_name=$('#consent_category_name').val();
	var consent_category_description=$('#consent_category_description').val();

	var div_id="consent_category_form_div";
	var page_name="../controller/consent_category_controller.php";
	var parameter=
		"consent_category_id="+consent_category_id+
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

function delete_this_consent_category(consent_category_id){
	//alert(consent_category_id);
	var s=confirm("Are you sure you want to Delete this Consent Category?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="consent_category_form_div";
		var page_name="../controller/consent_category_controller.php";
		var parameter="consent_category_id="+consent_category_id+"&action=2";
		
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

// ----------------------------------------- BILLING ITEMS ---------------------------------------------------

function get_consent_form(consent_id)
{
	var page_name="../view/consent_form.php";
	var div_id="modal_default";
	var parameter="consent_id="+consent_id;

	$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: true}); 
	$.ajax({
		type: 'POST',
		url:page_name,
		data:parameter,
		dataType: "html",
		success: function(result) 
		{
			$('#' + div_id).html(result);
			if(result["success"]==1)
			{
				$('#' + div_id).html(result);
			}	
		},
		error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
		{
			alert('Something went wrong is ...');
		}
	});	
}

function save_this_consent(consent_id)
{
	var consent_title=$('#consent_title').val();
	var consent_description=$('#consent_description').val();
	var category_id_FK=$('#category_id_FK').val();
	
	var items = [];
	$('#branch_id_FK option:selected').each(function(){ items.push($(this).val()); });
	var result = items.join(', ');

	//var admin_signature_required=$('#admin_signature_required').val();
	//var patient_signature_required=$('#patient_signature_required').val();
	//var doctor_signature_required=$('#doctor_signature_required').val();


    var admin_signature_required ='';
    inputs = $('#admin_signature_required');
    inputs.each(function() {
        if( $( this ).attr( 'type' ) === 'checkbox' ) {
            admin_signature_required = $(this).is( ':checked' ) ? 1: 0;
        }else
        {
            admin_signature_required = $(this).val();
        }
    });

    var patient_signature_required ='';
    inputs = $('#patient_signature_required');
    inputs.each(function() {
        if( $( this ).attr( 'type' ) === 'checkbox' ) {
            patient_signature_required = $(this).is( ':checked' ) ? 1: 0;
        }else
        {
            patient_signature_required = $(this).val();
        }
    });	

    var doctor_signature_required ='';
    inputs = $('#doctor_signature_required');
    inputs.each(function() {
        if( $( this ).attr( 'type' ) === 'checkbox' ) {
            doctor_signature_required = $(this).is( ':checked' ) ? 1: 0;
        }else
        {
            doctor_signature_required = $(this).val();
        }
    });	

	var div_id="consent_form_div";
	var page_name="../controller/consent_controller.php";
	var parameter=
		"consent_id="+consent_id+
		"&consent_title="+consent_title+
		"&consent_description="+consent_description+
		"&category_id_FK="+category_id_FK+
		"&branch_id_FK="+result+
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
			$(".modal.in").modal("hide");
			server_loader("html/module/consent/view/consent_main_view.php","sub-content-wrapper","menu_id=59","loading")
		}
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went here ...');
	}
	});	
}

function delete_this_consent(consent_id){
	//alert(consent_category_id);
	var s=confirm("Are you sure you want to Delete this Consent Category?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="consent_category_form_div";
		var page_name="../controller/consent_controller.php";
		var parameter="consent_id="+consent_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The Consent Category ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/consent/view/consent_main_view.php","sub-content-wrapper","menu_id=59","loading")
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

function save_consent_request(consent_request_id)
{
	//alert(consent_request_id);
	var consent_request_title=$('#consent_request_title').val();
	var branch_id_FK=$('#branch_id_FK').val();
	var consent_id_FK=$('#consent_id_FK').val();
	var consent_file_id_FK=$('#consent_file_id_FK').val();
	var patient_file=$('#patient_file').val();
	 
	
	var div_id="request_op_div";
	var page_name="../controller/consent_controller.php";
	var parameter=
		"consent_request_id="+consent_request_id+
		"&consent_request_title="+consent_request_title+
		"&branch_id_FK="+branch_id_FK+
		"&consent_id_FK="+consent_id_FK+
		"&consent_file_id_FK="+consent_file_id_FK+
		"&patient_file="+patient_file+
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
			$('#save_btn').attr('disabled','disabled');
			$('#file_up').attr('disabled','disabled');
			get_required_form(result['return_value'],consent_id_FK,consent_file_id_FK,result["patient_id"]);
		}
	},
	error: function(xhr, textStatus, errorThrown)
	{
		alert('Something went wrong in Request...');
	}
	});	
}

function get_required_form(request_id,consent_id_FK,consent_file_id_FK,patient_id)
{
	var div_id="required_signature";
    var parameter="request_id="+request_id+"&consent_id_FK="+consent_id_FK+"&consent_file_id_FK="+consent_file_id_FK+"&patient_id="+patient_id;
    var page_name="../view/required_form.php";
	show_loading_gif(div_id,"Loading Orders...");
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

function send_for_signature(consent_id_FK,file_id){
	var doctor_id=$('#doctor_id').val();
	var admin_id=$('#admin_id').val();
	
	var div_id="signateur_error";
	var page_name="../controller/consent_controller.php";
	var parameter=
		"consent_id_FK="+consent_id_FK+
		"&doctor_id="+doctor_id+
		"&admin_id="+admin_id+
		"&file_id="+file_id+
		"&action=12";
	$.ajax({
		type: 'POST',
		url:page_name,
		data:parameter,
		dataType: "json",
		success: function(result) 
		{
			$('#' + div_id).html(result['return_html']);
			if (result["success"] == 1) {
				$('#send_btn').attr('disabled','disabled');
				server_loader("html/module/consent/view/admin_consent_request.php","sub-content-wrapper","menu_id=67","loading")
			}
		},
		error: function(xhr, textStatus, errorThrown)
		{
			alert('Something went wrong in Request...');
		}
	});	
}

function show_required_file(file_id){
	var page_name="../view/consent_file_modal.php";
	var div_id="modal_default";
	var parameter="file_id="+file_id;
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

function show_admin_required_file(signed_doc_id,file_id,request_id,employee_id,signed,user_type,consent_partially_signed,x,y,w,page,user_name,hr_num) {
	var page_name="../view/consent_admin_file_modal.php";
	var div_id="modal_default";
	var parameter=
		"file_id="+file_id+
		"&request_id="+request_id+
		"&employee_id="+employee_id+
		"&signed="+signed+
		"&user_type="+user_type+
		"&signed_doc_id="+signed_doc_id+
		"&consent_partially_signed="+consent_partially_signed+
		"&x="+x+
		"&y="+y+
		"&w="+w+
		"&page="+page+
		"&user_name="+user_name+
		"&hr_num="+hr_num;

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

function Sign_this_doc(request_id,employee_id,file_id,user_type,user_id){
	//alert(user_id);
	var div_id="consent_category_form_div";
	var page_name="../controller/consent_controller.php";
	var parameter=
		"request_id="+request_id+
		"&employee_id="+employee_id+
		"&file_id="+file_id+
		"&user_type="+user_type+
		"&user_id="+user_id+
		"&action=13";
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "json",
	success: function(result) 
	{
		$('#' + div_id).html(result['return_html']);
		$(".modal.in").modal("hide");
		server_loader("html/module/consent/view/admin_consent_request.php","sub-content-wrapper","menu_id=67","loading")
		//if (user_type == 3) {
			//window.location.reload(true);
		//} else {
			//window.location.reload(true);
		//}
	},
	error: function(xhr, textStatus, errorThrown)
	{
		alert('Something went wrong in Request...');
	}
	});
}

function Sign_doctor_doc(request_id,employee_id,suffix){

	var div_id="consent_category_form_div";
	var page_name="../controller/consent_controller.php";
	var parameter=
		"request_id="+request_id+
		"&employee_id="+employee_id+
		"&suffix="+suffix+
		"&action=14";
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "json",
	success: function(result) 
	{
		$('#' + div_id).html(result['return_html']);
		server_loader("html/module/consent/view/doctor_consent_request.php","sub-content-wrapper","menu_id=16","loading Meetings")
		$(".modal.in").modal("hide");
	},
	error: function(xhr, textStatus, errorThrown)
	{
		alert('Something went wrong in Request...');
	}
	});
}

function show_doctor_required_file(file_id){
	var page_name="../view/consent_doctor_file_modal.php";
	var div_id="modal_default";
	var parameter="file_id="+file_id;
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

function delete_this_consent_request(consent_request_id) {
	//alert(consent_request_id);
	var s=confirm("Are you sure you want to Cancel this Request?");
	if(s)
	{
		//alert(consent_request_id);
		var div_id="div_section_content";
		var page_name="../controller/consent_controller.php";
		var parameter="consent_request_id="+consent_request_id+"&action=4";
		
			show_loading_gif(div_id,"Deleting Request ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/consent/view/consent_request_main_view.php","sub-content-wrapper","meni_id=16","loading Request")
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}

function send_this_concert_to_admin(consent_request_id)
{
	var page_name="../view/consent_admin_request.php";
	var div_id="modal_default";
	var parameter="consent_request_id="+consent_request_id;
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

function send_this_concert_to_doctor(consent_request_id)
{
	var page_name="../view/consent_doctor_request.php";
	var div_id="modal_default";
	var parameter="consent_request_id="+consent_request_id;
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

function send_this_concert_to_patient(consent_request_id)
{
	var page_name="../view/consent_patient_request.php";
	var div_id="modal_default";
	var parameter="consent_request_id="+consent_request_id;
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

function assign_to_this_doctor(consent_request_id)
{
	//alert(consent_request_id);
	var doctor_id_FK=$('#doctor_id_FK').val();
	var comments=$('#comments').val();
	
	var div_id="consent_assign_form_div";
	var page_name="../controller/consent_controller.php";
	var parameter=
		"consent_request_id="+consent_request_id+
		"&doctor_id_FK="+doctor_id_FK+
		"&comments="+comments+
		"&action=5";
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "json",
	success: function(result) 
	{
		$('#' + div_id).html(result['return_html']);
		server_loader("html/module/consent/view/consent_request_main_view.php","sub-content-wrapper","meni_id=16","loading Request");
		$(".modal.in").modal("hide");
	},
	error: function(xhr, textStatus, errorThrown)
	{
		alert('Something went wrong in Request...');
	}
	});	
}

function assign_to_this_admin(consent_request_id)
{
	//alert(consent_request_id);
	var employee_id_FK=$('#employee_id_FK').val();
	var comments=$('#comments').val();
	
	var div_id="consent_assign_form_div";
	var page_name="../controller/consent_controller.php";
	var parameter=
		"consent_request_id="+consent_request_id+
		"&employee_id_FK="+employee_id_FK+
		"&comments="+comments+
		"&action=6";
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "json",
	success: function(result) 
	{
		$('#' + div_id).html(result['return_html']);
		server_loader("html/module/consent/view/consent_request_main_view.php","sub-content-wrapper","meni_id=16","loading Request");
		$(".modal.in").modal("hide");
	},
	error: function(xhr, textStatus, errorThrown)
	{
		alert('Something went wrong in Request...');
	}
	});	
}

function assign_to_this_patient(consent_request_id)
{
	//alert(consent_request_id);
	var patient_id_FK=$('#patient_id_FK').val();
	var comments=$('#comments').val();
	
	var div_id="consent_assign_form_div";
	var page_name="../controller/consent_controller.php";
	var parameter=
		"consent_request_id="+consent_request_id+
		"&patient_id_FK="+patient_id_FK+
		"&comments="+comments+
		"&action=7";
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "json",
	success: function(result) 
	{
		$('#' + div_id).html(result['return_html']);
		server_loader("html/module/consent/view/consent_request_main_view.php","sub-content-wrapper","meni_id=16","loading Request");
		$(".modal.in").modal("hide");
	},
	error: function(xhr, textStatus, errorThrown)
	{
		alert('Something went wrong in Request...');
	}
	});
}
// ----------------------------------------- BILLING ITEMS ---------------------------------------------------

function get_consent_group_form_modal (consent_group_id)
{
	var page_name="../view/consent_group_form_modal.php";
	var div_id="modal_default";
	var parameter="consent_group_id="+consent_group_id;
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

function save_this_consent_group (consent_group_id)
{
	var consent_group_title=$('#consent_group_title').val();
	var consent_group_description=$('#consent_group_description').val();

	var div_id="consent_form_div";
	var page_name="../controller/consent_controller.php";
	var parameter=
		"consent_group_id="+consent_group_id+
		"&consent_group_title="+consent_group_title+
		"&consent_group_description="+consent_group_description+
		"&action=8";
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
			server_loader("html/module/consent/view/consent_group_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is ...');
	}
	});	
}

function delete_this_consent_group (consent_group_id){
	//alert(consent_group_id);
	var s=confirm("Are you sure you want to Delete this Group?");
	if(s)
	{
		var div_id="consent_category_form_div";
		var page_name="../controller/consent_controller.php";
		var parameter="consent_group_id="+consent_group_id+"&action=9";
		
			show_loading_gif(div_id,"Deleting The Consent Category ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/consent/view/consent_group_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}

function assign_user_to_group(consent_group_id)
{
	var page_name="../view/assign_user_to_group_modal.php";
	var div_id="modal_default";
	var parameter="consent_group_id="+consent_group_id;
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

function update_contact_list_group(consent_group_id,counter)
{
	var array=new Array();
	for(var i=0;i<counter;i++)
	{
		if($('#employee_id_'+i).is(":checked"))
			 array.push($('#employee_id_'+i).val());
	}	
		var page_name="../controller/consent_controller.php";	
		var div_id="assign_roles_div";
		var parameter="consent_group_id="+consent_group_id+"&array="+array+"&action=10";
		show_loading_gif(div_id,"Assigning Users..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			server_loader("html/module/consent/view/consent_group_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;
}

function get_signateur_form()
{
	var page_name="../view/signature_form_view.php";
	var div_id="consent_category_form_div";
	var parameter="";
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

function get_signateur_modal(){
	var page_name="../view/signature_modal_view.php";
	var div_id="modal_default";
	var parameter="";
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