<?php
ini_set('display_errors', 1);
session_start();
error_reporting(E_ALL);

require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/applicant.class.php");
require_once("../model/flow_interview.class.php");

if($_POST['action']==1)
{
	//print_r($_POST);
	$applicant = new applicant();
	
	$val=new Validation();
	$val->setRules("applicant_title__id_FK","Title is a required Field.",array("required"));	
	$val->setRules("applicant_first_name","First Name is a required Field.",array("required"));
	$val->setRules("applicant_last_name","Last Name is a required Field.",array("required"));
	$val->setRules("applicant_email","Email is a required Field.",array("required"));
	$val->setRules("applicant_phone_number","Phone Number is a required Field.",array("required"));
	$val->setRules("applicant_nationality_id_FK","Nationality is a required Field.",array("required"));
	$val->setRules("applicant_marital_status_FK","Marital Status is a required Field.",array("required"));
	$val->setRules("applicant_profession_FK","Profession is a required Field.",array("required"));
	$val->setRules("applicant_cv_id_FK","Updated CV is a required Field.",array("required"));

	if(!$val->validate())
	{
		$result["success"]		= 0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
	}
	else
	{
	 	//If timing is correct 
		if($_POST['applicant_id']==-1)
		{
			$applicantObj			=	new applicant();
			$this_applicant_id	    =	$applicantObj->insert_new_applicant($_POST,$_SESSION['employee_id']);
			$thisapplicantObj		=	new applicant($this_applicant_id);

			$applicantObj->remove_all_applicant_license($this_applicant_id);		
			$applicant_llicense_id_FK	=explode(",",$_POST["applicant_llicense_id_FK"]);		
			for($i=0;$i<count($applicant_llicense_id_FK);$i++)
			{
				$applicantObj->add_applicant_license($this_applicant_id,$applicant_llicense_id_FK[$i]);
			}

			$result["success"]=1;
			$result["return_value"]	=	$this_applicant_id;
			$savedapplicant			=new applicant($this_applicant_id);
			$applicantObj->assign_new_file($_POST['applicant_cv_id_FK']);
			$result["return_html"]	=	$val->draw_success_chart("Applicant added Successfully",1);
		} else {
			$thisapplicantObj		=new applicant($_POST['applicant_id']);
			$thisapplicantObj->update_applicant($_POST,$_SESSION['employee_id']);

			$thisapplicantObj->remove_all_applicant_license($_POST['applicant_id']);		
			$applicant_llicense_id_FK	=explode(",",$_POST["applicant_llicense_id_FK"]);		
			for($i=0;$i<count($applicant_llicense_id_FK);$i++)
			{
				$thisapplicantObj->add_applicant_license($_POST['applicant_id'],$applicant_llicense_id_FK[$i]);
			}
			
			$result["success"]=1;
			$result["return_value"]	=$_POST['applicant_id'];
			$result["return_html"]	=$val->draw_success_chart("Applicant Updated Successfully",1);
		}
	}
	echo json_encode($result);	
} else if ($_POST['action']==3) {
	$applicantObj	=new applicant();
	$applicantObj->delete_applicant($_POST['applicant_id']);
	$applicantObj->remove_all_applicant_license($_POST['applicant_id']);
	echo "<div class='alert alert-success'>Applicant Deleted</div>";
} else if ($_POST['action']==4) {
	//print_r($_POST);
	$applicantObj	=new applicant();
	$applicantObj->insert_opening_flow($_POST,$_SESSION['employee_id']);
	echo "<div class='alert alert-success'>Well Done</div>";
} else if ($_POST['action']==5) {
	$data 	= json_decode($_POST['results'], true);
	$Q 		= json_decode($_POST['res_questions'], true);

	$flow = new Flow();
	$flow->save_interview($_POST,$_SESSION['employee_id']);
	
	for ($i=0; $i < count($data); $i++) { 

		for ($B=0; $B < count($data[0]); $B++) { 
			$interview = new Flow();
			$interview->save_flow_interview_results($Q[$B],$data[$i][$B],$_SESSION['employee_id']);
		}
	}
	echo "<div class='alert alert-success'>Well Done</div>";
} else if ($_POST['action']==6) {
	if ($_POST['applicant_id'] <> -1) {
		# code...
	
	$data 	= json_decode($_POST['results'], true);
	$Q 		= json_decode($_POST['res_questions'], true);
	
	for ($i=0; $i < count($data); $i++) { 

		for ($B=0; $B < count($data[0]); $B++) { 
			echo "Question ".$Q[$B]."--> Answer ".$data[$i][$B];;
			echo '<br>';

			$interview = new Flow();
			$interview->update_flow_interview_results($_POST['interview_id'],$Q[$B],$data[$i][$B]);
		}
	}
	echo "<div class='alert alert-success'>Well Done</div>";
	}
} else if ($_POST['action']==7) {
	$applicant = new applicant();
	
	$val=new Validation();
	$val->setRules("applicant_title__id_FK","Title is a required Field.",array("required"));	
	$val->setRules("applicant_first_name","First Name is a required Field.",array("required"));
	$val->setRules("applicant_last_name","Last Name is a required Field.",array("required"));
	$val->setRules("applicant_email","Email is a required Field.",array("required"));
	$val->setRules("applicant_phone_number","Phone Number is a required Field.",array("required"));
	$val->setRules("applicant_nationality_id_FK","Nationality is a required Field.",array("required"));
	$val->setRules("applicant_marital_status_FK","Marital Status is a required Field.",array("required"));
	
	if(!$val->validate())
	{
		$result["success"]		= 0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
	}
	else
	{
		$applicantObj			=	new applicant();
		$this_applicant_id	    =	$applicantObj->insert_new_web_form_applicant($_POST,$_SESSION['employee_id']);
		$thisapplicantObj		=	new applicant($this_applicant_id);
		$result["success"]=1;
		$result["return_value"]	=	$this_applicant_id;
		$result["return_html"]	=	$val->draw_success_chart("Applicant added Successfully",1);

	}
	echo json_encode($result);
}