// ----------------------------------------- CODE ---------------------------------------------------
function get_customer_form(customer_id)
{
	var page_name="customer/view/customer_form.php";
	var div_id="modal_default";
	var parameter="customer_id="+customer_id;
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

function save_customer(customer_id)
{
	//alert(customer_id);
	var customer_name=$('#customer_name').val();
	var customer_display_name=$('#customer_display_name').val();
	var customer_email=$('#customer_email').val();
	var customer_mobile_number=$('#customer_mobile_number').val();
	var branch_id_FK=$('#branch_id_FK').val();

	var div_id="customer_form_div";
	var page_name="customer/controller/customer_controller.php";
	var parameter=
		"customer_id="+customer_id+
		"&customer_name="+customer_name+
		"&customer_display_name="+customer_display_name+
		"&customer_email="+customer_email+
		"&customer_mobile_number="+customer_mobile_number+
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
			server_loader("html/module/revenue_cycle/customer/view/customer_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			$(".modal.in").modal("hide");
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is ...');
	}
	});	
}

function delete_customer(customer_id){
	//alert(customer_id);
	var s=confirm("Are you sure you want to Delete this Customer?");
	if(s)
	{
		var div_id="code_form_div";
		var page_name="customer/controller/customer_controller.php";
		var parameter="customer_id="+customer_id+"&action=2";
		
			show_loading_gif(div_id,"Deleting The Customer ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/revenue_cycle/customer/view/customer_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}

function reactive_customer(customer_id){
	//alert(customer_id);
	var s=confirm("Are you sure you want to Reactivate this Customer?");
	if(s)
	{
		var div_id="code_form_div";
		var page_name="customer/controller/customer_controller.php";
		var parameter="customer_id="+customer_id+"&action=3";
		
			show_loading_gif(div_id,"Adding The Customer ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/revenue_cycle/customer/view/customer_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}
