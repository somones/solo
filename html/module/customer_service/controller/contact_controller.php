<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../model/contact.class.php");




if($_POST['action']==1) 
{
	if($_POST['contact_id']==-1)
	{
		$contact_name 	 					=trim($_POST["contact_name"]);
		$contact_email 	 					=trim($_POST["contact_email"]);
		$contact_mobile_number	 			=trim($_POST["contact_mobile_number"]);
		$contact_user_id_FK	 				=trim($_POST["contact_user_id_FK"]);
		$extension_number	 				=trim($_POST["extension_number"]);
		$branch_id_FK	 					=trim($_POST["branch_id_FK"]);

		$billing_itemObj				=new contact();

		$val=new Validation();
			
		$val->setRules("contact_name","Contact Name is a required Field.",array("required"));
		$val->setRules("contact_email","Contact Email is a required Field.",array("required"));
		$val->setRules("contact_mobile_number","Contact Mobile Phone is a required Field.",array("required"));
		$val->setRules("contact_user_id_FK","Contact User is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->contact_name  				=$contact_name;
			$billing_itemObj->contact_email      			=$contact_email;
			$billing_itemObj->contact_mobile_number 		=$contact_mobile_number;
			$billing_itemObj->contact_user_id_FK 			=$contact_user_id_FK;
			$billing_itemObj->extension_number 				=$extension_number;
			$billing_itemObj->branch_id_FK 					=$branch_id_FK;

			$contact_id	                    =$billing_itemObj->insert_new_contact($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$contact_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		
		$contact_name 	 					=trim($_POST["contact_name"]);
		$contact_email 	 					=trim($_POST["contact_email"]);
		$contact_mobile_number	 			=trim($_POST["contact_mobile_number"]);
		$contact_user_id_FK	 				=trim($_POST["contact_user_id_FK"]);
		$extension_number	 				=trim($_POST["extension_number"]);
		$branch_id_FK	 					=trim($_POST["branch_id_FK"]);

		$billing_itemObj					=new contact();

		$val=new Validation();

		$val->setRules("contact_name","Contact Name is a required Field.",array("required"));
		$val->setRules("contact_email","Contact Email is a required Field.",array("required"));
		$val->setRules("contact_mobile_number","Contact Mobile Phone is a required Field.",array("required"));
		$val->setRules("contact_user_id_FK","Contact User is a required Field.",array("required"));

		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->contact_name        		=$contact_name;
			$billing_itemObj->contact_email             =$contact_email;
			$billing_itemObj->contact_mobile_number 	=$contact_mobile_number;
			$billing_itemObj->contact_user_id_FK 		=$contact_user_id_FK;
			$billing_itemObj->extension_number 			=$extension_number;
			$billing_itemObj->branch_id_FK 				=$branch_id_FK;

			$billing_itemObj->update_this_contact($_POST['contact_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['contact_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$item_categoryObj	=new contact();
	$item_categoryObj->delete_this_contact($_POST['contact_id']);
}
?>