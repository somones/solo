function submit_save_survey(template_id,branch_id,survey_questions,language)
{
	var questions=survey_questions.split(",")
	var str="";
	for(var i=0;i<questions.length-1;i++)
	{
		var radioValue = $("input[name='option_"+questions[i]+"']:checked").val();
		if(radioValue)
		{
				str+=radioValue+",";
		}
		else
		{
			str+="0,";
		}
	}
		var gender=$('#gender').val();
		var doctor=0;
		if(template_id==2)
		{
			doctor=$('#doctor_id').val();
		}
		var div_id="modal_default";
		$('#'+div_id).modal({show: 'true',backdrop: 'static',keyboard: false});
		var page_name="../controller/survey_controller.php";
		show_loading_gif(div_id,"Loading Form");		
		var parameter="language="+language+"&template_id="+template_id+"&branch_id="+branch_id+"&survey_questions="+survey_questions+"&gender="+gender+"&doctor_id="+doctor+"&str="+str;

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

