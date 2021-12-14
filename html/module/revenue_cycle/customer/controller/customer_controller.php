<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/customer.class.php");
//require_once("../model/code_type.class.php");
//print_r($_POST);
if($_POST['action']==1) 
{
	if($_POST['customer_id']==-1)
	{
		$customer_name 	 					=trim($_POST["customer_name"]);
		$customer_display_name 	 			=trim($_POST["customer_display_name"]);
		$customer_email	 					=trim($_POST["customer_email"]);
		$customer_mobile_number	 			=trim($_POST["customer_mobile_number"]);
		$branch_id_FK	 					=trim($_POST["branch_id_FK"]);
		$customerObj						=new customer();

		$val=new Validation();
		$val->setRules("customer_name","The Name is a required Field.",array("required"));
		$val->setRules("customer_display_name","Display Name is a required Field.",array("required"));	
		$val->setRules("customer_mobile_number","Phone Number is a required Field.",array("required"));
		$val->setRules("customer_email","Email is a required Field.",array("required"));
		$val->setRules("branch_id_FK","Branch is a required Field.",array("required"));
		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$customerObj->customer_name        				=$customer_name;
			$customerObj->customer_display_name             =$customer_display_name;
			$customerObj->customer_email 					=$customer_email;
			$customerObj->customer_mobile_number       		=$customer_mobile_number;
			$customerObj->branch_id_FK       				=$branch_id_FK;
			$customer_id	                     			=$customerObj->insert_new_customer($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$customer_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		$customer_name 	 					=trim($_POST["customer_name"]);
		$customer_display_name 	 			=trim($_POST["customer_display_name"]);
		$customer_email	 					=trim($_POST["customer_email"]);
		$customer_mobile_number	 			=trim($_POST["customer_mobile_number"]);
		$branch_id_FK	 					=trim($_POST["branch_id_FK"]);
		$customerObj						=new customer();

		$val=new Validation();
		$val->setRules("customer_name","The Name is a required Field.",array("required"));
		$val->setRules("customer_display_name","Display Name is a required Field.",array("required"));	
		$val->setRules("customer_mobile_number","Phone Number is a required Field.",array("required"));
		$val->setRules("customer_email","Email is a required Field.",array("required"));
		$val->setRules("branch_id_FK","Branch is a required Field.",array("required"));
		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$customerObj->customer_name        				=$customer_name;
			$customerObj->customer_display_name             =$customer_display_name;
			$customerObj->customer_email 					=$customer_email;
			$customerObj->customer_mobile_number       		=$customer_mobile_number;
			$customerObj->branch_id_FK       				=$branch_id_FK;
			$customerObj->update_the_customer($_POST['customer_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['customer_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}		
		
	}
	echo json_encode($result);	
} else if($_POST['action']==2) {
	$customerObj			=new customer();
	$customerObj->delete_customer($_POST['customer_id']);
} else if($_POST['action']==3) {
	$customerObj			=new customer();
	$customerObj->reactive_customer($_POST['customer_id']);
}

?>