// ----------------------------------------- BILLING ITEMS ---------------------------------------------------

function get_contact_form(contact_id)
{
	var page_name="../view/contact_form.php";
	var div_id="modal_default";
	var parameter="contact_id="+contact_id;
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

function save_this_contact(contact_id)
{
	var contact_name=$('#contact_name').val();
	var contact_email=$('#contact_email').val();
	var contact_mobile_number=$('#contact_mobile_number').val();
	var contact_user_id_FK=$('#contact_user_id_FK').val();
	var extension_number=$('#extension_number').val();
	var branch_id_FK=$('#branch_id_FK').val();

	var div_id="conact_form_div";
	var page_name="../controller/contact_controller.php";
	var parameter=
		"contact_id="+contact_id+
		"&contact_name="+contact_name+
		"&contact_email="+contact_email+
		"&contact_mobile_number="+contact_mobile_number+
		"&contact_user_id_FK="+contact_user_id_FK+
		"&extension_number="+extension_number+
		"&branch_id_FK="+branch_id_FK+
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
			server_loader("html/module/customer_service/view/contacts_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is contact...');
	}
	});	
}

function delete_this_contact(contact_id){
	//alert(contact_id);
	var s=confirm("Are you sure you want to Delete this Contact?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="conact_form_div";
		var page_name="../controller/contact_controller.php";
		var parameter="contact_id="+contact_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The Code ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/customer_service/view/contacts_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}
// ----------------------------------------- ////////////// ---------------------------------------------------

function get_distribution_list_form(list_id,menu_id)
{
	var page_name="../view/distribution_list_form.php";
	var div_id="modal_default";
	var parameter="list_id="+list_id+"&menu_id="+menu_id;
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

function save_this_distribution_list(list_id,menu_id)
{
	var branch_id_FK=$('#branch_id_FK').val();
	var list_type_id_FK=$('#list_type_id_FK').val();
	var list_name=$('#list_name').val();
	var list_description=$('#list_description').val();

	var div_id="conact_form_div";
	var page_name="../controller/distribution_list_controller.php";
	var parameter=
		"list_id="+list_id+
		"&branch_id_FK="+branch_id_FK+
		"&list_type_id_FK="+list_type_id_FK+
		"&list_name="+list_name+
		"&list_description="+list_description+
		"&menu_id="+menu_id+
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
			server_loader("html/module/customer_service/view/distribution_list_main_view.php","sub-content-wrapper","menu_id=16","loading")
			
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong ...');
	}
	});	
}

function delete_this_distribution_list(list_id){
	//alert(list_id);
	var s=confirm("Are you sure you want to Delete this Contact?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="conact_form_div";
		var page_name="../controller/distribution_list_controller.php";
		var parameter="list_id="+list_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The Code ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/customer_service/view/distribution_list_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}

function assign_contact_to_list(list_id)
{
	var page_name="../view/assign_list_form.php";
	var div_id="modal_default";
	var parameter="list_id="+list_id;
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

function update_contact_list(list_id,counter)
{
	var array=new Array();
	for(var i=0;i<counter;i++)
	{
		if($('#contact_id_'+i).is(":checked"))
			 array.push($('#contact_id_'+i).val());
	}	
		var page_name="../controller/distribution_list_controller.php";	
		var div_id="assign_roles_div";
		var parameter="list_id="+list_id+"&array="+array+"&action=3";
		show_loading_gif(div_id,"Assigning Users..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			server_loader("html/module/customer_service/view/distribution_list_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;
}

// ----------------------------------------- /////Email//////// ---------------------------------------------------
function get_new_email_form (message_type,type_id,menu_id) {
	$(".modal.in").modal("hide");
	var parameter="message_type="+message_type+"&type_id="+type_id+"&menu_id="+menu_id;
	var page_name="../view/send_email_sms_main_form.php";
	var div_id="sub-content-wrapper";
		show_loading_gif(div_id,"Loading Meeting Content..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		dataType: "html",
		success: function(result) {
			$('#' + div_id).html(result);
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;	
}

function get_confirm_email_form (message_type,distribution_list_type,menu_id) {
	
	var message_distribution_id_FK=$('#message_distribution_id_FK').val();
	var receiver_number=$('#receiver_number').val();
	var message_subject=$('#message_subject').val();
	var message_content=$('#message_content').val();
	var arabic_text=$('#arabic_text').val();
	
	var message_type_id_FK=message_type;
	
	var page_name="../view/confirm_email_form.php";
	var div_id="sub-content-wrapper";
	var parameter=
		"message_distribution_id_FK="+message_distribution_id_FK+
		"&receiver_number="+receiver_number+
		"&message_subject="+message_subject+
		"&message_content="+message_content+
		"&message_type_id_FK="+message_type_id_FK+
		"&distribution_list_type="+distribution_list_type+
		"&arabic_text="+arabic_text+
		"&menu_id="+menu_id;

		show_loading_gif(div_id,"Loading Meeting Content..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		dataType: "html",
		success: function(result) {
			$('#' + div_id).html(result);
			$("[name='data_grid']").DataTable();
			//DataTable
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;
}


function confirm_email_form (message_type,distribution_list_type,menu_id) {
	var message_distribution_id_FK=$('#message_distribution_id_FK').val();
	var receiver_number=$('#receiver_number').val();
	var message_subject=$('#message_subject').val();
	var message_content=$('#message_content').val();
	var arabic_text=$('#arabic_text').val();
	var message_type_id_FK=message_type;
	
	var div_id="email_div";
	var page_name="../controller/distribution_list_controller.php";
	var parameter=
		"message_distribution_id_FK="+message_distribution_id_FK+
		"&receiver_number="+receiver_number+
		"&message_subject="+message_subject+
		"&message_content="+message_content+
		"&message_type_id_FK="+message_type_id_FK+
		"&distribution_list_type="+distribution_list_type+
		"&arabic_text="+arabic_text+
		"&menu_id="+menu_id+
		"&action=8";
		show_loading_gif(div_id,"Loading Meeting Content..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		dataType: "json",
		success: function(result) {
			$('#' + div_id).html(result['return_html']);
			if(result["success"]==1)
			{	
				get_confirm_email_form (message_type,distribution_list_type,menu_id);
			}
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong Confirmat...');
		}
	});
	return Ajax;
}

function send_and_save_this_messages(message_distribution_id_FK,message_type,distribution_list_type,menu_id,arabic_text)
{
	var receiver_number=$('#receiver_number').val();
	var message_subject=$('#message_subject').val();
	var message_content=$('#message_content').val();
	var message_type_id_FK=message_type;

	var div_id="modal_default";
	$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: false});

	var page_name="../controller/distribution_list_controller.php";
	var parameter=
		"message_distribution_id_FK="+message_distribution_id_FK+
		"&receiver_number="+receiver_number+
		"&message_subject="+message_subject+
		"&message_content="+message_content+
		"&message_type_id_FK="+message_type_id_FK+
		"&menu_id="+menu_id+
		"&distribution_list_type="+distribution_list_type+
		"&arabic_text="+arabic_text+
		"&action=4";
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
		alert('Something went wrong is setup_security...');
	}
	});	
	
}

// ----------------------------------------- /////Email//////// ---------------------------------------------------

function get_distribution_list_type_form(type_id)
{
	var page_name="../view/distribution_list_type_form.php";
	var div_id="modal_default";
	var parameter="type_id="+type_id;
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

function save_this_distribution_list_type(type_id)
{
	var list_type_name=$('#list_type_name').val();
	var list_type_description=$('#list_type_description').val();

	var div_id="email_div";
	var page_name="../controller/distribution_list_controller.php";
	var parameter=
		"type_id="+type_id+
		"&list_type_name="+list_type_name+
		"&list_type_description="+list_type_description+
		"&action=5";
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
			server_loader("html/module/customer_service/view/distribution_list_type_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is setup_security...');
	}
	});	
}

function delete_this_distribution_list_type(type_id){
	//alert(list_id);
	var s=confirm("Are you sure you want to Delete this Type?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="conact_form_div";
		var page_name="../controller/distribution_list_controller.php";
		var parameter="type_id="+type_id+"&action=6";
		
			show_loading_gif(div_id,"Deleting The Code ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/customer_service/view/distribution_list_type_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				$(".modal.in").modal("hide");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}

// ------------------------- SEARCH -------------------------
function get_result_of_message_search() {
	//alert("Start");
	var branch_id=$('#branch_id').val();
	var type_id=$('#type_id').val();
	var list_type_id=$('#list_type_id').val();
	var list_id=$('#list_id').val();
	var employee_id=$('#employee_id').val();
	var contact_id=$('#contact_id').val();

	$.ajax({
	type: 'POST',
	dataType: "html",
	success: function(result)
	{
		load_result_of_message_search(branch_id,type_id,list_type_id,list_id,employee_id,contact_id)
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is get_result_of_invoice_search...');
	}
	});
}

function load_result_of_message_search(branch_id,type_id,list_type_id,list_id,employee_id,contact_id){
	var div_id="table_result";
    var parameter=
	    "branch_id="+branch_id+
	    "&type_id="+type_id+
	    "&list_type_id="+list_type_id+
	    "&list_id="+list_id+
	    "&employee_id="+employee_id+
	    "&contact_id="+contact_id;
    var page_name="../view/search_resault_view.php";
	show_loading_gif(div_id,"Loading Orders...");
	var Ajax = $.ajax({
	type: 'POST',
	url: page_name,
	data: parameter,
	//dataType: "html",
	success: function(result) {
		$('#' + div_id).html(result);
	},
	error: function(xhr, textStatus, errorThrown) {
		alert('error...');
	}
});
	return Ajax;
}

