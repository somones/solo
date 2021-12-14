function submit_save_policy(policy_id)
{
var div_id		="policy_div";
show_loading_gif(div_id,"Creating Policy");
var page_name				="../controller/policy_controller.php";
var policy_title			=$('#policy_title').val();
var policy_description		=$('#policy_description').val();	
var policy_chapter			=$('#policy_chapter').val();
var policy_department		=$('#policy_department').val();
var policy_effective_date	=$('#policy_effective_date').val();
var policy_revision_date	=$('#policy_revision_date').val();
var policy_control_type		=$('#policy_control_type').val();
var policy_control_password		=$('#policy_control_password').val();

var items = [];
$('#policy_branch option:selected').each(function(){ items.push($(this).val()); });
var result = items.join(', ');
var parameter	="policy_title="+policy_title+"&policy_description="+encodeURIComponent(policy_description)+"&policy_chapter="+policy_chapter+"&policy_department="+policy_department+"&policy_effective_date="+policy_effective_date+"&policy_revision_date="+policy_revision_date+"&policy_id="+policy_id+"&action=1"+"&policy_branches="+items+"&policy_control_type="+policy_control_type+"&policy_control_password="+policy_control_password;


$.ajax({
type: 'POST',
url:page_name,
data:parameter,
dataType: "json",
success: function(result) 
{
	//$('#' + div_id).html(result[]);

	if(result["success"]==0)
	{
		$('#' + div_id).html(result["return_html"]);
	}
	else
	{
		load_content_editor(result["return_value"]);
			
	}

},
error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
{
	alert('Something went wrong...');
}
});	
}

function authenticate_then_proceed(policy_id)
{
		var div_id="modal_default";
		$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: false});
		var page_name="../view/policy_authentication_form.php";
		show_loading_gif(div_id,"Loading Form");		
		var parameter="policy_id="+policy_id;

		$.ajax({
		type: 'POST',
		url:page_name,
		data:parameter,
		dataType: "html",
		success: function(result) 
		{
			$('#' + div_id).html(result);
		},
		error: function(xhr, textStatus, errorThrown) 
		{
			alert('Something went wrong...');
		}
	});	
}

function disable_enable_password_field()
{
	var policy_control_type		=$('#policy_control_type').val();

	if(policy_control_type==1)
	{
		$("#policy_control_password").prop('disabled', true);	
	}
	else
	{
		$("#policy_control_password").prop('disabled', false);	
	}

}
function unsign_att(policy_id,atta_id)
{
	alert(policy_id);
	alert(atta_id);
}



function get_file_uploader(policy_id)
{
	//alert(policy_id);
	var div_id="content_editor_tab_content";
	var page_name="../view/file_uploader.php";
	show_loading_gif(div_id,"Loading Form");
	var parameter	="policy_id="+policy_id;
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "html",
	success: function(result) 
	{
			$('#' + div_id).html(result);
			$('#file_uploader').change(function(){    
				//on change event  
				formdata = new FormData();
				if($(this).prop('files').length > 0)
				{
					file =$(this).prop('files')[0];
					formdata.append("att", file);
					
					jQuery.ajax({
						url: "../controller/file_uploader_controller.php",
						type: "POST",
						data: formdata,
						processData: false,
						contentType: false,
						success: function (result) {
							//alert(result);
							$('#'+div_id).html(result);
							 // if all is well
							 // play the audio file
						}
					});					
					
					
				}
			});	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong...');
	}
	});	
}

function submit_file_uploader(policy_id)
{
	formdata = new FormData();
	
    if($('#file_uploader').prop('files').length > 0)
    {
        file =$(this).prop('files')[0];
        formdata.append("to_upload", file);
    }
}


function server_loader_PP(page_name,div_id,parameter,text_value)
{
		show_loading_gif(div_id,text_value);
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


function swap_order(section_id_1,section_id_2,policy_id)
{
	var div_id="div_section_content";

	var page_name="../controller/policy_controller.php";
	var parameter="section_id_1="+section_id_1+"&section_id_2="+section_id_2+"&action=8&policy_id="+policy_id;
	
		show_loading_gif(div_id,"Swapping Order..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			//$("[name='data_grid']").DataTable();
			//server_loader_PP("../view/policy_form.php","content_editor_tab_content","policy_id="+policy_id,"Loading Policy Properties.");
			load_content_editor(policy_id);
			
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');

		}
	});
	return Ajax;
	
}

function preview_policy(policy_id)
{
	var page_name="../view/read_main_view.php?pp="+policy_id;
	window.open(page_name);
	
	
	
}


function submit_authenticate_reading(policy_id)
{
	
	var policy_password=$('#policy_password').val();
	
	var page_name	="../controller/policy_controller.php";
	var div_id		="authenticate_div";
	show_loading_gif(div_id,"Creating Policy");
	var parameter="policy_password="+policy_password+"&action=14&policy_id="+policy_id;
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
			preview_policy(policy_id);
			$("#modal_default").modal("hide");
		}
	
		
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong...');
	}
	});		
	
}

function get_selected_branch(counter)
{
	var selected=0;
	var policy_id=-1;
	for (i = 0; i < counter; i++) 
	{
		if($('#policy_index_'+i).is(":checked"))
		{
			selected++;
			policy_id=$('#policy_index_'+i).val();
		}
			
	}
	if(selected != 1)
	{
		alert("Kindly Select 1 Policy to Use this option");
	}
	else
	{
		load_content_editor(policy_id);
	}
	
}

function load_content_editor(policy_id)
{
	var page_name="../view/policy_content_editor.php";
	var div_id="sub-content-wrapper";
	var parameter="policy_id="+policy_id;

		show_loading_gif(div_id,"Loading Policy Content..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			$("[name='data_grid']").DataTable();
			server_loader_PP("../view/policy_form.php","content_editor_tab_content","policy_id="+policy_id,"Loading Policy Properties.");
			//initSample();
			
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');

		}
	});
	return Ajax;		
}

function add_section_policy(policy_id,section_id)
{
	var div_id="content_editor_op";
	var page_name="../controller/policy_controller.php";
	var parameter="section_id="+section_id+"&policy_id="+policy_id+"&action=2";
	
		show_loading_gif(div_id,"Adding new section");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			//$("[name='data_grid']").DataTable();
			//server_loader_PP("../view/policy_form.php","content_editor_tab_content","policy_id="+policy_id,"Loading Policy Properties.");
			load_content_editor(policy_id);
			
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');

		}
	});
	return Ajax;		
	

}

function load_section_content(content_id)
{
	var div_id="content_editor_tab_content";
	var page_name="../view/content_view.php";
	var parameter="content_id="+content_id;
	
		show_loading_gif(div_id,"Loading Policy Content..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			//$("[name='data_grid']").DataTable();
			//server_loader_PP("../view/policy_form.php","content_editor_tab_content","policy_id="+policy_id,"Loading Policy Properties.");
			//load_content_editor(policy_id);
			initSample();
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');

		}
	});
	return Ajax;	
}

function submit_save_content(content_id,policy_id)
{
	
		var editor='editor';
		var content=CKEDITOR.instances.editor.getData();//editorElement.getHtml();
		content=encodeURIComponent(content);
		var s=confirm("Are you sure you want to save the content of this Section");
		if(s)
		{
				var div_id="div_section_content";
				var page_name="../controller/policy_controller.php";
				var parameter="content_id="+content_id+"&action=3&policy_id="+policy_id+"&content="+content;
				
					show_loading_gif(div_id,"Saving Policy Section Content..");
					var Ajax = $.ajax({
					type: 'POST',
					url: page_name,
					data: parameter,
					success: function(result) {
						$('#' + div_id).html(result);	
						//$("[name='data_grid']").DataTable();
						//server_loader_PP("../view/policy_form.php","content_editor_tab_content","policy_id="+policy_id,"Loading Policy Properties.");
						//load_content_editor(policy_id);
						
					},
					error: function(xhr, textStatus, errorThrown) {
						alert('Something went wrong...');

					}
				});
				return Ajax;				
		}
}

function remove_section_from_policy(content_id,policy_id)
{
		var s=confirm("Are you sure you want to remove this section from this policy");
		if(s)
		{
			
			var div_id="div_section_content";
			var page_name="../controller/policy_controller.php";
			var parameter="content_id="+content_id+"&action=4&policy_id="+policy_id;
			
				show_loading_gif(div_id,"Removing Policy Section..");
				var Ajax = $.ajax({
				type: 'POST',
				url: page_name,
				data: parameter,
				success: function(result) {
					$('#' + div_id).html(result);	
					//$("[name='data_grid']").DataTable();
					//server_loader_PP("../view/policy_form.php","content_editor_tab_content","policy_id="+policy_id,"Loading Policy Properties.");
					load_content_editor(policy_id);
					
				},
				error: function(xhr, textStatus, errorThrown) {
					alert('Something went wrong...');

				}
			});
			return Ajax;	
		}
	
}

function apply_action(policy_id,user_id,action_id)
{
	
		var div_id="modal_default";
		$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: true}); 
		

		var div_id="modal_default";
		var page_name="../view/policy_actions_view.php";
		var parameter="policy_id="+policy_id+"&user_id="+user_id+"&action_id="+action_id;
		show_loading_gif(div_id,"Removing Policy Section..");
		var Ajax = $.ajax({
		type: 'POST',
		url: page_name,
		data: parameter,
		success: function(result) {
			$('#' + div_id).html(result);	
			//$("[name='data_grid']").DataTable();
			//server_loader_PP("../view/policy_form.php","content_editor_tab_content","policy_id="+policy_id,"Loading Policy Properties.");
			load_content_editor(policy_id);
			
		},
		error: function(xhr, textStatus, errorThrown) {
			alert('Something went wrong...');

		}
	});
	return Ajax;
	
}


function submit_publish_action(action_id,policy_id)
{
	var notify=0;
	var notification_text=$('#action_form_text_notification').val();
	if($("#notify_checkbox").is(':checked'))
		notify=1;
	
	var page_name	="../controller/policy_controller.php";
	var div_id		="div_submit_action";
	show_loading_gif(div_id,"Creating Policy");
	var parameter="action_id="+action_id+"&text_notification="+encodeURIComponent(notification_text)+"&notify="+notify+"&action=5&policy_id="+policy_id;
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "json",
	success: function(result) 
	{
		if(result["success"]==0)
		{
			$('#' + div_id).html(result);
		}
		else
		{
			$('#' + div_id).html(result["return_html"]);
			load_content_editor(policy_id);
		}
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong...');
	}
	});	
	
}

function submit_save_policy_flow_action(action_id,policy_id)
{

	var employee_id=$('#action_form_employee_id').val();
	var text_notification=$('#action_form_text_notification').val();


	var page_name	="../controller/policy_controller.php";
	var div_id		="div_submit_action";
	show_loading_gif(div_id,"Creating Policy");
	var parameter	="action_id="+action_id+"&text_notification="+encodeURIComponent(text_notification)+"&employee_id="+employee_id+"&policy_id="+policy_id+"&action=5";
	$.ajax({
	type: 'POST',
	url:page_name,
	data:parameter,
	dataType: "json",
	success: function(result) 
	{
		if(result["success"]==0)
		{
			$('#' + div_id).html(result["return_html"]);
		}
		else
		{
			$('#' + div_id).html(result["return_html"]);
			load_content_editor(policy_id);
		}
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong...');
	}
	});			
		


	
		
		
}


function submit_save_revision_notes(policy_id)
{
	var revision_notes=$('#ëditor_notes_text').val();
	var page_name	="../controller/policy_controller.php";
	var div_id		="content_editor_op";
	show_loading_gif(div_id,"Saving revision notes..");
	var parameter	="policy_id="+policy_id+"&revision_notes="+encodeURIComponent(revision_notes)+"&action=6";
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

function get_policy_operations_history(policy_id)
{
		var div_id="modal_default";
		$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: true}); 

	var page_name	="../view/policy_time_line.php";
	show_loading_gif(div_id,"Generating Report..");
	var parameter	="policy_id="+policy_id;
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

function policy_reader(policy_id)
{
		var div_id="modal_default";
		$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: true}); 
		var page_name	="../view/read_main_view.php";
		show_loading_gif(div_id,"Loading Policy..");
		var parameter	="policy_id="+policy_id;
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

/*
function submit_done_revision(policy_id)
{
	var revision_notes=$('#ëditor_notes_text').val();
	var page_name	="../controller/policy_controller.php";
	var div_id		="content_editor_op";
	show_loading_gif(div_id,"Saving revision notes..");
	var parameter	="policy_id="+policy_id+"&action=7";
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
*/
	

function get_chapter_form(chapter_id)
{
	var page_name="../view/chapter_form.php";
	var div_id="modal_default";
	var parameter="chapter_id="+chapter_id;
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
			alert('Something in Chapter...');
		}
	});
	return Ajax;
}

function save_chapter(chapter_id)
{
	var chapter_title=$('#chapter_title').val();
	var div_id="chapter_form_div";
	var page_name	="../controller/policy_controller.php";
	var parameter="chapter_id="+chapter_id+"&chapter_title="+chapter_title+"&action=9";
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
			server_loader("html/module/policy_procedure/view/list_chapter.php","sub-content-wrapper","menu_id=16","loading Meetings");
			//Close the modal
			$(".modal.in").modal("hide");
			
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is save Chapter...');
	}
	});	
}

function delete_chapter(chapter_id){
	var s=confirm("Are you sure you want to Delete this Chapter?");
		if(s)
		{
			//alert(meeting_id);
			var div_id="chapter_form_div";
			var page_name	="../controller/policy_controller.php";
			var parameter="chapter_id="+chapter_id+"&action=10";
			
				show_loading_gif(div_id,"Deleting The Chapter ..");
				var Ajax = $.ajax({
				type: 'POST',
				url: page_name,
				data: parameter,
				success: function(result) {
					$('#' + div_id).html(result);
					server_loader("html/module/policy_procedure/view/list_chapter.php","sub-content-wrapper","menu_id=16","loading Meetings");
				},
				error: function(xhr, textStatus, errorThrown) {
					alert('Something went wrong...');
				}
			});
			return Ajax;	
		}
}
/*
function delete_chapter(chapter_id){
		alert(chapter_id);
		var div_id="chapter_form_div";
		var page_name	="../controller/policy_controller.php";
		var parameter="chapter_id="+chapter_id+"&action=13";
		
			show_loading_gif(div_id,"Deleting The Chapter ..");
			var Ajax = $.ajax({
			type: 'POST',
			url: page_name,
			data: parameter,
			success: function(result) {
				if(result > 0){
                    alert("This Existe");
                 }
                 else{
                    alert("This Not Existe");
                 }
				//$('#' + div_id).html(result);
				//server_loader("html/module/policy_procedure/view/list_chapter.php","sub-content-wrapper","menu_id=16","loading Meetings");
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('Something went Delete...');
			}
		});
		return Ajax;	
}*/

function get_section_form(section_id)
{
	var page_name="../view/section_form.php";
	var div_id="modal_default";
	var parameter="section_id="+section_id;
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
			alert('Something in section...');
		}
	});
	return Ajax;
}

function save_section(section_id)
{
	var section_title			=$('#section_title').val();
	var section_help_tip		=$('#section_help_tip').val();
	var div_id="section_form_div";
	var page_name	="../controller/policy_controller.php";
	var parameter="section_id="+section_id+"&section_title="+section_title+"&section_help_tip="+section_help_tip+"&action=11";
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
			server_loader("html/module/policy_procedure/view/list_section.php","sub-content-wrapper","menu_id=16","loading Meetings");
			//Close the modal
			$(".modal.in").modal("hide");
			
		}	
	},
	error: function(xhr, textStatus, errorThrown) //$('#reg_grid').DataTable();
	{
		alert('Something went wrong is save Chapter...');
	}
	});	
}

function delete_section(section_id){
	var s=confirm("Are you sure you want to Delete this Section?");
		if(s)
		{
			//alert(meeting_id);
			var div_id="chapter_form_div";
			var page_name	="../controller/policy_controller.php";
			var parameter="section_id="+section_id+"&action=12";
			
				show_loading_gif(div_id,"Deleting The Section ..");
				var Ajax = $.ajax({
				type: 'POST',
				url: page_name,
				data: parameter,
				success: function(result) {
					$('#' + div_id).html(result);
					server_loader("html/module/policy_procedure/view/list_section.php","sub-content-wrapper","menu_id=16","loading Meetings");
				},
				error: function(xhr, textStatus, errorThrown) {
					alert('Something went wrong...');
				}
			});
			return Ajax;	
		}
}