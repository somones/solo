<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../model/speciality.class.php");


if($_POST['action']==1) 
{
	if($_POST['speciality_id']==-1)
	{
		$speciality_title 	 					=trim($_POST["speciality_title"]);
		$speciality_description 	 			=trim($_POST["speciality_description"]);

		$billing_itemObj				=new speciality();

		$val=new Validation();
			
		$val->setRules("speciality_title","Speciality Title is a required Field.",array("required"));
		$val->setRules("speciality_description","Speciality Description is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->speciality_title  				=$speciality_title;
			$billing_itemObj->speciality_description      	=$speciality_description;

			$speciality_id	                    =$billing_itemObj->insert_new_speciality($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$speciality_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		
		$speciality_title 	 					=trim($_POST["speciality_title"]);
		$speciality_description 	 			=trim($_POST["speciality_description"]);


		$billing_itemObj					=new speciality();

		$val=new Validation();

		$val->setRules("speciality_title","Speciality Title is a required Field.",array("required"));
		$val->setRules("speciality_description","Speciality Description is a required Field.",array("required"));

		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->speciality_title        		=$speciality_title;
			$billing_itemObj->speciality_description      =$speciality_description;

			$billing_itemObj->update_this_speciality($_POST['speciality_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['speciality_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$item_categoryObj	=new speciality();
	$item_categoryObj->delete_this_speciality($_POST['speciality_id']);
}
?>