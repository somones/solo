<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/category.class.php");

//print_r($_POST);
if($_POST['action']==1) 
{
	if($_POST['category_id']==-1)
	{
		$category_name 	 			=trim($_POST["category_name"]);
		$module_id_FK 	 			=trim($_POST["module_id_FK"]);
		$display_order 	 			=trim($_POST["display_order"]);

		$moduleObj					=new category();

		$val=new Validation();
		$val->setRules("module_id_FK","Category Module is a required Field.",array("required"));
		$val->setRules("category_name","Category Name is a required Field.",array("required"));
		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$moduleObj->category_name        		=$category_name;
			$moduleObj->module_id_FK             	=$module_id_FK;
			$moduleObj->display_order             	=$display_order;
			$category_id	                     	=$moduleObj->insert_new_menu_category($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$category_id;
			$result["return_html"]	=$val->draw_success_chart("Added Successfully",1);
		}
	}
 
	else
	{
		$category_name 	 			=trim($_POST["category_name"]);
		$module_id_FK 	 			=trim($_POST["module_id_FK"]);
		$display_order 	 			=trim($_POST["display_order"]);
		$moduleObj					=new category();

		$val=new Validation();
		$val->setRules("module_id_FK","Category Module is a required Field.",array("required"));
		$val->setRules("category_name","Category Name is a required Field.",array("required"));
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$moduleObj->category_name        =$category_name;
			$moduleObj->module_id_FK         =$module_id_FK;
			$moduleObj->display_order        =$display_order;
			$moduleObj->update_menu_category($_POST['category_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['category_id'];
			$result["return_html"]	=$val->draw_success_chart("Updated Successfully",1);
		}		
		
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$moduleObj			=new category();
	$moduleObj->delete_menu_category($_POST['category_id']);
}

?>