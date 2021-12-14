<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/billing_items.class.php");
require_once("../model/billing_item_categories.class.php");
require_once("../../master_settings/model/code.class.php");


if($_POST['action']==1) 
{
	if($_POST['billing_item_id']==-1)
	{
		$item_category_id_FK 	 		=trim($_POST["item_category_id_FK"]);
		$item_description 	 			=trim($_POST["item_description"]);
		$item_code_id_FK	 			=trim($_POST["item_code_id_FK"]);
		$item_code_value	 			=trim($_POST["item_code_value"]);
		$tax_profile_id_FK	 			=trim($_POST["tax_profile_id_FK"]);
		$tax_value	 					=trim($_POST["tax_value"]);
		$billing_itemObj				=new billing_item();

		$val=new Validation();
		$val->setRules("item_description","Billing Item Description is a required Field.",array("required"));	
		$val->setRules("item_category_id_FK","Category is a required Field.",array("required"));
		$val->setRules("tax_profile_id_FK","Tax Profile is a required Field.",array("required"));
		$val->setRules("tax_value","Tax Value is a required Field.",array("required"));
		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->item_category_id_FK  	=$item_category_id_FK;
			$billing_itemObj->item_description      =$item_description;
			$billing_itemObj->item_code_id_FK 		=$item_code_id_FK;
			$billing_itemObj->item_code_value       =$item_code_value;
			$billing_itemObj->tax_profile_id_FK     =$tax_profile_id_FK;
			$billing_itemObj->tax_value       		=$tax_value;
			$billing_item_id	                    =$billing_itemObj->insert_new_billing_item($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$billing_item_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		$item_category_id_FK 	 		=trim($_POST["item_category_id_FK"]);
		$item_description 	 			=trim($_POST["item_description"]);
		$item_code_id_FK	 			=trim($_POST["item_code_id_FK"]);
		$item_code_value	 			=trim($_POST["item_code_value"]);
		$tax_profile_id_FK	 			=trim($_POST["tax_profile_id_FK"]);
		$tax_value	 					=trim($_POST["tax_value"]);
		$billing_itemObj				=new billing_item();

		$val=new Validation();
		$val->setRules("item_description","Billing Item Description is a required Field.",array("required"));	
		$val->setRules("item_category_id_FK","Category is a required Field.",array("required"));
		$val->setRules("tax_profile_id_FK","Tax Profile is a required Field.",array("required"));
		$val->setRules("tax_value","Tax Value is a required Field.",array("required"));	
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->item_category_id_FK        	=$item_category_id_FK;
			$billing_itemObj->item_description             	=$item_description;
			$billing_itemObj->item_code_id_FK 				=$item_code_id_FK;
			$billing_itemObj->item_code_value       		=$item_code_value;
			$billing_itemObj->tax_profile_id_FK     		=$tax_profile_id_FK;
			$billing_itemObj->tax_value       				=$tax_value;
			$billing_itemObj->update_the_billing_item($_POST['billing_item_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['billing_item_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$item_categoryObj	=new billing_item();
	$item_categoryObj->delete_billing_item($_POST['billing_item_id']);
} else if ($_POST['action']==3) 
{
	if($_POST['category_id']==-1)
	{
		$category_description 	 		=trim($_POST["category_description"]);
		$item_categoryObj				=new billing_item_category();

		$val=new Validation();
		$val->setRules("category_description","The Category Description is a required Field.",array("required"));	
		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$item_categoryObj->category_description  	=$category_description;
			$category_id	                    		=$item_categoryObj->insert_new_item_category($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$category_id;
			$result["return_html"]	=$val->draw_success_chart("Well Done!!",1);
		}
	}
 
	else
	{
		$category_description 	 		=trim($_POST["category_description"]);
		$item_categoryObj				=new billing_item_category();

		$val=new Validation();
		$val->setRules("category_description","The Category Description is a required Field.",array("required"));		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$item_categoryObj->category_description        	=$category_description;
			$item_categoryObj->update_item_category($_POST['category_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['category_id'];
			$result["return_html"]	=$val->draw_success_chart("Well Done!!",1);
		}
	}
	echo json_encode($result);	
} 
else if($_POST['action']==4)
{
	$item_categoryObj	=new billing_item_category();
	$item_categoryObj->delete_item_category($_POST['category_id']);
}else if($_POST['action']==5)
{
	$item_categoryObj	=new rc_code();
	$item_categoryObj->get_code_item($_POST['code_id'],$_POST['category_id']);
}else if($_POST['action']==6)
{
	$item_categoryObj	=new rc_code();
	$item_categoryObj->get_code_item_search($_POST['search_token'],$_POST['category_id']);
}
?>