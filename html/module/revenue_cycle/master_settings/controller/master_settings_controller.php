<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/code.class.php");
require_once("../model/code_type.class.php");
//print_r($_POST);
if($_POST['action']==1) 
{
	if($_POST['code_id']==-1)
	{
		$code_type_id_FK 	 		=trim($_POST["code_type_id_FK"]);
		$code_value 	 			=trim($_POST["code_value"]);
		$code_short_description	 	=trim($_POST["code_short_description"]);
		$code_description	 		=trim($_POST["code_description"]);
		$codeObj					=new rc_code();

		$val=new Validation();
		$val->setRules("code_type_id_FK","The Code Type is a required Field.",array("required"));
		$val->setRules("code_value","Code Value is a required Field.",array("required"));	
		$val->setRules("code_description","Code Description is a required Field.",array("required"));
		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$codeObj->code_type_id_FK        =$code_type_id_FK;
			$codeObj->code_value             =$code_value;
			$codeObj->code_short_description =$code_short_description;
			$codeObj->code_description       =$code_description;
			$code_id	                     =$codeObj->insert_new_code($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$code_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		$code_type_id_FK 	 		=trim($_POST["code_type_id_FK"]);
		$code_value 	 			=trim($_POST["code_value"]);
		$code_short_description	 	=trim($_POST["code_short_description"]);
		$code_description	 		=trim($_POST["code_description"]);
		$codeObj					=new rc_code();

		$val=new Validation();
		$val->setRules("code_type_id_FK","The Code Type is a required Field.",array("required"));
		$val->setRules("code_value","Code Value is a required Field.",array("required"));	
		$val->setRules("code_description","Code Description is a required Field.",array("required"));	
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$codeObj->code_type_id_FK        =$code_type_id_FK;
			$codeObj->code_value             =$code_value;
			$codeObj->code_short_description =$code_short_description;
			$codeObj->code_description       =$code_description;
			$codeObj->update_the_code($_POST['code_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['code_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}		
		
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$codeObj			=new rc_code($_POST['code_id']);
	$codeObj->delete_code();
} else if($_POST['action']==3)
{
	print_r($_POST);
	if($_POST['code_type_id']==-1)
	{
		$code_type_name 	 				=trim($_POST["code_type_name"]);
		$code_type_description 	 			=trim($_POST["code_type_description"]);
		$code_type_insurance_id_FK	 		=trim($_POST["code_type_insurance_id_FK"]);
		$code_type_category_id_FK	 		=trim($_POST["code_type_category_id_FK"]);
		$codeTypeObj						=new code_type();

		$val=new Validation();
		$val->setRules("code_type_name","Code Type Name is a required Field.",array("required"));	
		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$codeTypeObj->code_type_name        			=$code_type_name;
			$codeTypeObj->code_type_description             =$code_type_description;
			$codeTypeObj->code_type_insurance_id_FK 		=$code_type_insurance_id_FK;
			$codeTypeObj->code_type_category_id_FK       	=$code_type_category_id_FK;
			$code_type_id	                     			=$codeTypeObj->insert_new_code_type($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$code_type_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		$code_type_name 	 		=trim($_POST["code_type_name"]);
		$code_type_description 	 			=trim($_POST["code_type_description"]);
		$code_type_insurance_id_FK	 	=trim($_POST["code_type_insurance_id_FK"]);
		$code_type_category_id_FK	 		=trim($_POST["code_type_category_id_FK"]);
		$codeTypeObj					=new code_type();

		$val=new Validation();
		$val->setRules("code_type_name","Code Type Name is a required Field.",array("required"));	
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$codeTypeObj->code_type_name        =$code_type_name;
			$codeTypeObj->code_type_description             =$code_type_description;
			$codeTypeObj->code_type_insurance_id_FK =$code_type_insurance_id_FK;
			$codeTypeObj->code_type_category_id_FK       =$code_type_category_id_FK;
			$codeTypeObj->update_the_code_type($_POST['code_type_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['code_type_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}		
		
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$codeTypeObj			=new code_type($_POST['code_type_id']);
	$codeTypeObj->delete_code_type();
}

?>