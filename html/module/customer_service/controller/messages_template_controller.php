<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../model/messages_template_categorie.class.php");
require_once("../model/messages_template.class.php");

if($_POST['action']==1) 
{
	if($_POST['message_templates_categories_id']==-1)
	{
		$message_templates_categories_name 	 							=trim($_POST["message_templates_categories_name"]);
		$message_templates_categories_description 	 					=trim($_POST["message_templates_categories_description"]);
		$message_templates_categories_branch_id_FK	 					=trim($_POST["message_templates_categories_branch_id_FK"]);


		$billing_itemObj				=new messages_template_categorie();

		$val=new Validation();
			
		$val->setRules("message_templates_categories_name","Name is a required Field.",array("required"));
		$val->setRules("message_templates_categories_branch_id_FK","Description is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->message_templates_categories_name  				=$message_templates_categories_name;
			$billing_itemObj->message_templates_categories_description      	=$message_templates_categories_description;
			$billing_itemObj->message_templates_categories_branch_id_FK 		=$message_templates_categories_branch_id_FK;

			$message_templates_categories_id	                    =$billing_itemObj->insert_new_messages_template_categorie($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$message_templates_categories_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		
		$message_templates_categories_name 	 					=trim($_POST["message_templates_categories_name"]);
		$message_templates_categories_description 	 			=trim($_POST["message_templates_categories_description"]);
		$message_templates_categories_branch_id_FK	 			=trim($_POST["message_templates_categories_branch_id_FK"]);

		$billing_itemObj					=new messages_template_categorie();

		$val=new Validation();

		$val->setRules("message_templates_categories_name","Name is a required Field.",array("required"));
		$val->setRules("message_templates_categories_branch_id_FK","Description is a required Field.",array("required"));

		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->message_templates_categories_name        		=$message_templates_categories_name;
			$billing_itemObj->message_templates_categories_description      =$message_templates_categories_description;
			$billing_itemObj->message_templates_categories_branch_id_FK 	=$message_templates_categories_branch_id_FK;

			$billing_itemObj->update_this_messages_template_categorie($_POST['message_templates_categories_id']);
			
			$result["success"]		=1;
			$result["return_value"]	=$_POST['message_templates_categories_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$item_categoryObj	=new messages_template_categorie();
	$item_categoryObj->delete_this_messages_template_categorie($_POST['message_templates_categories_id']);
} else if ($_POST['action']==3) {
	if($_POST['message_template_id']==-1)
	{
		$message_template_name 	 								=trim($_POST["message_template_name"]);
		$message_template_description 	 						=trim($_POST["message_template_description"]);
		$message_template_categorie_id_FK	 					=trim($_POST["message_template_categorie_id_FK"]);


		$billing_itemObj				=new messages_template();

		$val=new Validation();
			
		$val->setRules("message_template_name","Name is a required Field.",array("required"));
		$val->setRules("message_template_categorie_id_FK","Description is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->message_template_name  				=$message_template_name;
			$billing_itemObj->message_template_description      	=$message_template_description;
			$billing_itemObj->message_template_categorie_id_FK 		=$message_template_categorie_id_FK;

			$message_template_id	                    =$billing_itemObj->insert_new_message_template($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$message_template_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		
		$message_template_name 	 						=trim($_POST["message_template_name"]);
		$message_template_description 	 				=trim($_POST["message_template_description"]);
		$message_template_categorie_id_FK	 			=trim($_POST["message_template_categorie_id_FK"]);

		$billing_itemObj					=new messages_template();

		$val=new Validation();

		$val->setRules("message_template_name","Name is a required Field.",array("required"));
		$val->setRules("message_template_categorie_id_FK","Description is a required Field.",array("required"));

		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->message_template_name        		=$message_template_name;
			$billing_itemObj->message_template_description      =$message_template_description;
			$billing_itemObj->message_template_categorie_id_FK 	=$message_template_categorie_id_FK;

			$billing_itemObj->update_this_message_template($_POST['message_template_id']);
			
			$result["success"]		=1;
			$result["return_value"]	=$_POST['message_template_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
	echo json_encode($result);
} else if ($_POST['action']==4) {
	$item_categoryObj	=new messages_template();
	$item_categoryObj->delete_this_message_template($_POST['message_template_id']);
}
?>