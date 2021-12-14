<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../model/consent_category.class.php");




if($_POST['action']==1) 
{
	if($_POST['consent_category_id']==-1)
	{
		$consent_category_name 	 					=trim($_POST["consent_category_name"]);
		$consent_category_description 	 			=trim($_POST["consent_category_description"]);

		$billing_itemObj				=new consent_category();

		$val=new Validation();
			
		$val->setRules("consent_category_name","Consent Name is a required Field.",array("required"));
		$val->setRules("consent_category_description","Consent Description is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->consent_category_name  				=$consent_category_name;
			$billing_itemObj->consent_category_description      	=$consent_category_description;

			$consent_category_id	                    =$billing_itemObj->insert_new_consent_category($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$consent_category_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		
		$consent_category_name 	 					=trim($_POST["consent_category_name"]);
		$consent_category_description 	 			=trim($_POST["consent_category_description"]);


		$billing_itemObj					=new consent_category();

		$val=new Validation();

		$val->setRules("consent_category_name","Consent Name is a required Field.",array("required"));
		$val->setRules("consent_category_description","Consent Description is a required Field.",array("required"));

		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->consent_category_name        		=$consent_category_name;
			$billing_itemObj->consent_category_description      =$consent_category_description;

			$billing_itemObj->update_this_consent_category($_POST['consent_category_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['consent_category_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$item_categoryObj	=new consent_category();
	$item_categoryObj->delete_this_consent_category($_POST['consent_category_id']);
}
?>