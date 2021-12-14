<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/modules.class.php");

//print_r($_POST);
if($_POST['action']==1) 
{
	if($_POST['module_id']==-1)
	{
		$module_name 	 			=trim($_POST["module_name"]);
		$module_url 	 			=trim($_POST["module_url"]);

		$moduleObj					=new modules();

		$val=new Validation();
		$val->setRules("module_name","Module Name is a required Field.",array("required"));
		$val->setRules("module_url","Module URL is a required Field.",array("required"));	
		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$moduleObj->module_name        		=$module_name;
			$moduleObj->module_url             	=$module_url;
			$module_id	                     	=$moduleObj->insert_new_module($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$module_id;
			$result["return_html"]	=$val->draw_success_chart("Added Successfully",1);
		}
	}
 
	else
	{
		$module_name 	 			=trim($_POST["module_name"]);
		$module_url 	 			=trim($_POST["module_url"]);
		$moduleObj					=new modules();

		$val=new Validation();
		$val->setRules("module_name","Module Name is a required Field.",array("required"));
		$val->setRules("module_url","Module URL is a required Field.",array("required"));	
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$moduleObj->module_name        =$module_name;
			$moduleObj->module_url         =$module_url;
			$moduleObj->update_the_module($_POST['module_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['module_id'];
			$result["return_html"]	=$val->draw_success_chart("Updated Successfully",1);
		}		
		
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$moduleObj			=new modules();
	$moduleObj->delete_module($_POST['module_id']);
}

?>