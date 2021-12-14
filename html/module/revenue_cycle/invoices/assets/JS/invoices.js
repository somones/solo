function load_invoice_page(invoice_id)
{
	var page_name="invoices/view/invoice_skeleton.php";
	var div_id="sub-content-wrapper";
	var parameter="invoice_id="+invoice_id;
	//$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: true}); 
   
		show_loading_gif(div_id,"Loading Form..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$(".modal.in").modal("hide");
			$('#' + div_id).html(result);
			make_search_field('invoices/model/services.config.php','diagnosis_text','diagnosis_id','',"button_diagnosis_add");
			list_orders(invoice_id);
        	list_invoice_payments(invoice_id);
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong is load_invoice_page ...');
		}
	});
	return Ajax;
}

function list_invoice_payments(invoice_id)
{
	var div_id="list_invoice_payments";
    var parameter="invoice_id="+invoice_id;
    var page_name="invoices/view/load_invoice_payments.php";
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

function show_toast(type,title,message)
{
	toastr[type](message,title, {
      positionClass:"toast-top-full-width",
      closeButton:true,
      progressBar:false,
      preventDuplicates:true,
      newestOnTop:true,
    });	
}

function start_new_order(branch_id) {
	var page_name="invoices/view/new_invoice.php";
	var div_id="modal_default";
	var parameter="branch_id="+branch_id;
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

function submit_create_invoice(invoice_id,branch_id) {
	//alert(invoice_id);
	var customer_id		=$('#customer_id').val();
	var rate_sheet		=$('#rate_sheet_id').val();
	var discount_plan	=$('#discount_plan').val();

	var div_id="procedure_div";
	var page_name="invoices/controller/invoices_controller.php";
	var parameter=
		"invoice_id="+invoice_id+
		"&customer_id="+customer_id+
		"&rate_sheet="+rate_sheet+
		"&discount_plan="+discount_plan+
		"&branch_id="+branch_id+
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
			$('#' + div_id).html(result);
			load_invoice_page(result["return_value"]);
		}	
	},

	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is submit_create_invoice...');
	}
	});
	return Ajax;
}

function submit_save_invoice_note(invoice_id) {
	var comment=$('#invoice_comment').val();
	comment=encodeURIComponent(comment);

	var div_id="saved_note";
	var page_name="invoices/controller/invoices_controller.php";
	var parameter=
		"invoice_id="+invoice_id+
		"&comment="+comment+
		"&action=2";
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "html",
	success: function(result)
	{
		load_invoice_page(invoice_id);
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is submit_save_invoice_note...');
	}
	});
}

function submit_update_order_rates(invoice_id,index)
{
	var array=index.split(",");
	var concat="";
	for(var i=0;i<array.length;i++)
	{
		concat+=($('#order_rate_'+array[i]).val()+"***"+$('#order_discount_'+array[i]).val())+"~!~!";
	}
		var div_id="update_orders_div";
		show_loading_gif(div_id,"Updating rates...");
		var Ajax = $.ajax({
		type: 'POST',
		url: "invoices/controller/invoices_controller.php",
		dataType: "json",
		data: "invoice_id="+invoice_id+"&index="+index+"&concat="+concat+"&action=5",
		success: function(result) {
			$('#' + div_id).html(result["return_html"]);
			if(result["success"]==1)
				list_orders(invoice_id);
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;		
}

function add_new_service(invoice_id,order_id) // <------------------------------------|||||||||||||||||||||||||||||||
{
	var service_id=$('#diagnosis_id').val();

	if(service_id > -1)
	{
		var div_id="invoice_operations";
		var page_name="invoices/controller/invoices_controller.php";
		var parameter=
			"service_id="+service_id+
			"&invoice_id="+invoice_id+
			"&order_id="+order_id+
			"&action=3";
		$.ajax({
		type: 'POST',
		url:page_name,
		data:parameter,
		dataType: "html",
		success: function(result) {
			$('#' + div_id).html(result);
            list_orders(invoice_id);
		},
		error: function(xhr, textStatus, errorThrown)
		{
			alert('Something went wrong is Creation...');
		}
		});
		return Ajax;
	}
}

function list_orders(invoice_id)
{
    var div_id="invoice_items";
    var parameter="invoice_id="+invoice_id;
    var page_name="invoices/view/list_invoice_orders.php";
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


function load_payment_form(invoice_id,payment_type)
{
	var page_name="invoices/view/payment_form.php";
	var div_id="modal_default";
	var parameter="invoice_id="+invoice_id+"&payment_type="+payment_type;
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

function edit_invoice_overveiw(invoice_id,branch_id)
{
	var div_id="modal_default";
	var page_name="invoices/view/new_invoice.php";
	var parameter="invoice_id="+invoice_id+"&branch_id="+branch_id;
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

function credit_note_form(invoice_id,credit_note_id)
{
	var div_id="modal_default";
	var page_name="invoices/view/credit_note_form.php";
	var parameter="invoice_id="+invoice_id+"&credit_note_id="+credit_note_id;
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

function submit_save_credit_note(invoice_id,credit_note,index,total_credit_notes,total_credit_vat,credit_amount,total_gross)
{
	var array=index.split(",");
	var concat="";
	for(var i=0;i<array.length;i++)
	{
		concat+=$('#credit_rate_'+array[i]).val()+"***";
	}	
	var div_id="credit_note_form_div";
	var page_name="invoices/controller/invoices_controller.php";
	var parameter=
		"credit_note="+credit_note+
		"&invoice_id="+invoice_id+
		"&index="+index+
		"&total_credit_notes="+total_credit_notes+
		"&total_credit_vat="+total_credit_vat+
		"&credit_amount="+credit_amount+
		"&total_gross="+total_gross+
		"&concat="+concat+"&action=4";

		show_loading_gif(div_id,"Saving Credit note...");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		dataType: "html",
		data: parameter,
		success: function(result) {
			credit_note_form(invoice_id,1)
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Ajax;
	alert(concat);
}

function make_search_field(values_page,search_field,id_field,attach_param,btn_id)//<-------------Serach-------------------
{
	var Obj;
	var Ajax = $.ajax({
		type: 'POST',
		url: values_page,
		data:attach_param,
		success: function(result) {
			var search_values=(JSON.parse(result));
			Obj=$('#'+search_field).autocomplete({
				lookup:search_values,
				minChars:3,
				showNoSuggestionNotice:true,
				lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
					var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
					return re.test(suggestion.value);
				},
				onSelect: function(suggestion) {
					$('#'+id_field).val(suggestion.data);
					if(btn_id)
					{
						$('#'+btn_id).removeClass("btn-danger");
						$('#'+btn_id).addClass("btn-success");
						$('#'+btn_id).prop('disabled', false);
					}
				},
				onHint: function (hint) {
				},
				onInvalidateSelection: function() {
					$('#'+id_field).val('-1');
					if(btn_id)
					{
						$('#'+btn_id).removeClass("btn-success");
						$('#'+btn_id).addClass("btn-danger");
						$('#'+btn_id).prop('disabled', true);
					}
				}
			});	
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');
		}
	});
	return Obj;			
}

function submit_save_payment(invoice_id,payment_type)
{
	var amount=$('#payment_amount').val();
	var payment_mode=$('#payment_mode_id').val();
	var reference	=$('#payment_reference_number').val();
	var payment_notes	=$('#payment_notes').val();
	payment_notes=encodeURIComponent(payment_notes);
	
	var div_id="payment_div";
	var page_name="invoices/controller/invoices_controller.php";
	var parameter=
		"invoice_id="+invoice_id+
		"&payment_mode="+payment_mode+
		"&reference="+reference+
		"&payment_notes="+payment_notes+
		"&payment_amount="+amount+
		"&payment_type="+payment_type+"&action=6";

	show_loading_gif(div_id,"Adding Payment..");
	var Ajax = $.ajax({
	type: 'POST',
	url: page_name,
	dataType: "json",
	data:parameter,
	
	success: function(result) 
	{
		$('#' + div_id).html(result["return_html"]);
		if(result["success"]==1)
		{
			list_invoice_payments(invoice_id);
			list_orders(invoice_id);
			$(".modal.in").modal("hide");
			show_toast("success","Payment","Payment recorded Successfully");
		}
	},
	error: function(xhr, textStatus, errorThrown) {
		alert('Something went wrong...');
	}
});
return Ajax;
}

function delete_invoice(invoice_id){
	var s=confirm("Are you sure you want to Delete this INVOICE?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="code_form_div";
		var page_name="invoices/controller/invoices_controller.php";
		var parameter="invoice_id="+invoice_id+"&action=7";
		
			show_loading_gif(div_id,"Deleting The INVOICE ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/revenue_cycle/invoices/view/invoices_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}

function delete_invoice_order(credit_note_id){
	var s=confirm("Are you sure you want to Delete this INVOICE?");
	if(s)
	{
		//alert(meeting_id);
		var div_id="code_form_div";
		var page_name="invoices/controller/invoices_controller.php";
		var parameter="credit_note_id="+credit_note_id+"&action=8";
		
			show_loading_gif(div_id,"Deleting The INVOICE ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				$('#' + div_id).html(result);
				server_loader("html/module/revenue_cycle/invoices/view/invoices_main_view.php","sub-content-wrapper","menu_id=16","loading Meetings")
				
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went wrong...');
			}
		});
		return Ajax;	
	}
}

function get_result_of_invoice_search() {
	//alert("Start");
	var customer_search=$('#customer_search').val();
	var date_start=$('#date_start').val();
	var date_end=$('#date_end').val();
	var rate_plan=$('#rate_plan').val();
	var invoice_search=$('#invoice_search').val();
	var paid_status=$('#paid_status').val();

	$.ajax({
	type: 'POST',
	dataType: "html",
	success: function(result)
	{
		load_result_of_invoice_search(invoice_search,customer_search,rate_plan,paid_status,date_start)
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is get_result_of_invoice_search...');
	}
	});
}

function load_result_of_invoice_search(invoice_search,customer_search,rate_plan,paid_status,date_start){
	var div_id="table_result";
    var parameter="invoice_search="+invoice_search+"&customer_search="+customer_search+"&rate_plan="+rate_plan+"&paid_status="+paid_status+"&date_start="+date_start;
    var page_name="invoices/view/search_resault_view.php";
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