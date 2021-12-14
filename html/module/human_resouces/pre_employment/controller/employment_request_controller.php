<?php
ini_set('display_errors', 1);
session_start();
error_reporting(E_ALL);

require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/employment_request.class.php");

if($_POST['action']==1)
{

	$employment_request = new employment_request();
	
	$val=new Validation();
	$val->setRules("request_job_title","Title is a required Field.",array("required"));	
	$val->setRules("request_group_id_FK","Request Group is a required Field.",array("required"));

	$val->setRules("branch_id_FK","Region is a required Field.",array("required"));
	$val->setRules("request_reason","Reason for Vacancy is a required Field.",array("required"));
	$val->setRules("request_type_id_FK","Request Type is a required Field.",array("required"));
	
	if(!$val->validate())
	{
		$result["success"]		= 0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
	}
	else
	{
		if($_POST['request_id']==-1)
		{
			$employment_requestObj	    =	new employment_request();
			$this_request_id	        =	$employment_requestObj->insert_new_request($_POST,$_SESSION['employee_id']);
			$employment_requestObj		=	new employment_request($this_request_id);
			$result["success"]=1;
			$result["return_value"]		=	$this_request_id;
			$result["return_html"]		=	$val->draw_success_chart("Request added Successfully",1);
		} else {

			$employment_requestObj		=new employment_request($_POST['request_id']);
			$employment_requestObj->update_request($_POST,$_SESSION['employee_id']);
			$result["success"]=1;
			$result["return_value"]	    =$_POST['request_id'];
			$result["return_html"]	    =$val->draw_success_chart("Request Updated Successfully",1);
		}
	}
	echo json_encode($result);	
} else if ($_POST['action']==3) {
	$employmentRQ	=new employment_request();
	$employmentRQ->delete_request($_POST['request_id']);
	echo "<div class='alert alert-success'>Request Deleted</div>";
} else if ($_POST['action']==4) {
	$action_re	=new employment_request();
	$action_re->save_action($_POST,$_SESSION['employee_id']);
	echo "<div class='alert alert-success'>Request Action Added</div>";
} else if ($_POST['action']==5) {

	$val=new Validation();

	if ($_POST['opening_id_FK'] == -1) {
		$val->setRules("opning_title","The Title is a required Field.",array("required"));
		$val->setRules("opening_description","The Description is a required Field.",array("required"));	
	}
	
	$val->setRules("opening_id_FK","The Opening is a required Field.",array("required"));	
	$val->setRules("opening_start_date","The Strat Date is a required Field.",array("required"));
	$val->setRules("opening_end_date","The End Date is a required Field.",array("required"));	
	
	if(!$val->validate())
	{
		$result["success"]		= 0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
	}
	else
	{
		$action_re	=new employment_request();
		$this_request_id = $action_re->save_job_opning($_POST,$_SESSION['employee_id']);
		$result["success"]=1;
		$result["return_value"]		=	$this_request_id;
		$result["return_html"]		=	$val->draw_success_chart("Well Done!!",1);
	} echo json_encode($result);
} else if ($_POST['action']==6) {
	$val=new Validation();
	
	$val->setRules("applicant_id","Applicant is a required Field.",array("required"));	
	$val->setRules("matching_notes","Comments is a required Field.",array("required"));	
	
	if(!$val->validate())
	{
		$result["success"]		= 0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
	}
	else
	{
		$action_re	=new employment_request();
		$this_request_id = $action_re->save_matching($_POST,$_SESSION['employee_id']);
		$result["success"]=1;
		$result["return_value"]		=	$this_request_id;
		$result["return_html"]		=	$val->draw_success_chart("Well Done!!",1);
	} echo json_encode($result);
} else if ($_POST['action']==7) {
	$action_re	=new employment_request();
	$action_re->save_unmatched_action($_POST,$_SESSION['employee_id']);
	echo "<div class='alert alert-success'>Request Action Added</div>";
}