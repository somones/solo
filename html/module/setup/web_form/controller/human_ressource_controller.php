<?php
ini_set('display_errors', 1);
session_start();
error_reporting(E_ALL);

require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../model/applicant.class.php");

if($_POST['action']==1)
{
	//print_r($_POST);
	//echo "string";

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
	 	//If timing is correct 
		if($_POST['applicant_id']==-1)
		{
			$applicantObj			=	new applicant();
			$this_applicant_id	    =	$applicantObj->insert_new_applicant($_POST,$_SESSION['employee_id']);
			$thisapplicantObj		=	new applicant($this_applicant_id);
			$result["success"]=1;
			$result["return_value"]	=	$this_applicant_id;
			$result["return_html"]	=	$val->draw_success_chart("Applicant added Successfully",1);
		} else {

			$thisapplicantObj		=new applicant($_POST['applicant_id']);
			$thisapplicantObj->update_applicant($_POST,$_SESSION['employee_id']);
			$result["success"]=1;
			$result["return_value"]	=$_POST['applicant_id'];
			$result["return_html"]	=$val->draw_success_chart("Applicant Updated Successfully",1);
		}
	}
	echo json_encode($result);	
} 