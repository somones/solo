<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/user.class.php");


if($_POST['action']==1) 
{
	if($_POST['user_id']==-1)
	{
		$branch_id 				=trim($_POST["branch_id"]);
		$department_id 			=trim($_POST["department_id"]);
		$employee_full_name 	=trim($_POST["employee_full_name"]);
		$employee_dob 			=trim($_POST["employee_dob"]);
		$employee_job_title 	=trim($_POST["employee_job_title"]);
		$employee_number 		=trim($_POST["employee_number"]);
		$employee_email 		=trim($_POST["employee_email"]);
		$roles_id_FK 			=trim($_POST["roles_id_FK"]);
		$employee_active 		=trim($_POST["employee_active"]);
		$profile_completed 		=trim($_POST["profile_completed"]);

		$userObj				=new user();

		$val=new Validation();
			
		$val->setRules("branch_id","Branch is a required Field.",array("required"));
		$val->setRules("department_id","Department is a required Field.",array("required"));
		$val->setRules("employee_full_name","Employee Name is a required Field.",array("required"));
		$val->setRules("employee_dob","Employee Date of birth is a required Field.",array("required"));
		$val->setRules("employee_job_title","Employee Job  Title is a required Field.",array("required"));
		$val->setRules("employee_number","Employee HR Number is a required Field.",array("required"));
		$val->setRules("employee_email","Employee Email is a required Field.",array("required"));
		$val->setRules("roles_id_FK","Role is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$userObj->branch_id 			=$branch_id;
			$userObj->department_id 		=$department_id;
			$userObj->employee_full_name 	=$employee_full_name;
			$userObj->employee_dob 			=$employee_dob;
			$userObj->employee_job_title 	=$employee_job_title;
			$userObj->employee_number 		=$employee_number;
			$userObj->employee_email 		=$employee_email;
			$userObj->roles_id_FK 			=$roles_id_FK;

			$userObj->employee_active 		=$employee_active;
			$userObj->profile_completed 	=$profile_completed;

			$user_id	                    =$userObj->insert_new_user($_SESSION['employee_id']);

			$userObj->remove_all_permissions($user_id);		
			$roles_id_FK	=explode(",",$_POST["roles_id_FK"]);		
			for($i=0;$i<count($roles_id_FK);$i++)
			{
				$userObj->add_user_roles($user_id,$roles_id_FK[$i]);
			}
			
			$result["success"]		=1;
			$result["return_value"]	=$user_id;
			$result["return_html"]	=$val->draw_success_chart("User added Successfully",1);
		}
	}
 
	else
	{	
		$branch_id 				=trim($_POST["branch_id"]);
		$department_id 			=trim($_POST["department_id"]);
		$employee_full_name 	=trim($_POST["employee_full_name"]);
		$employee_dob 			=trim($_POST["employee_dob"]);
		$employee_job_title 	=trim($_POST["employee_job_title"]);
		$employee_number 		=trim($_POST["employee_number"]);
		$employee_email 		=trim($_POST["employee_email"]);
		$roles_id_FK 			=trim($_POST["roles_id_FK"]);
		$employee_active 		=trim($_POST["employee_active"]);
		$profile_completed 		=trim($_POST["profile_completed"]);

		$userObj				=new user();

		$val=new Validation();
			
		$val->setRules("branch_id","Branch is a required Field.",array("required"));
		$val->setRules("department_id","Department is a required Field.",array("required"));
		$val->setRules("employee_full_name","Employee Name is a required Field.",array("required"));
		$val->setRules("employee_dob","Employee Date of birth is a required Field.",array("required"));
		$val->setRules("employee_job_title","Employee Job  Title is a required Field.",array("required"));
		$val->setRules("employee_number","Employee HR Number is a required Field.",array("required"));
		$val->setRules("employee_email","Employee Email is a required Field.",array("required"));
		$val->setRules("roles_id_FK","Role is a required Field.",array("required"));

		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$userObj->branch_id 			=$branch_id;
			$userObj->department_id 		=$department_id;
			$userObj->employee_full_name 	=$employee_full_name;
			$userObj->employee_dob 			=$employee_dob;
			$userObj->employee_job_title 	=$employee_job_title;
			$userObj->employee_number 		=$employee_number;
			$userObj->employee_email 		=$employee_email;
			$userObj->roles_id_FK 			=$roles_id_FK;

			$userObj->employee_active 		=$employee_active;
			$userObj->profile_completed 	=$profile_completed;
			
			$user_id = $_POST['user_id'];
			$userObj->update_this_user($_POST['user_id']);
			
			$userObj->remove_all_permissions($user_id);		
			$roles_id_FK	=explode(",",$_POST["roles_id_FK"]);		
			for($i=0;$i<count($roles_id_FK);$i++)
			{
				$userObj->add_user_roles($user_id,$roles_id_FK[$i]);
			}
			$result["success"]		=1;
			$result["return_value"]	=$_POST['user_id'];
			$result["return_html"]	=$val->draw_success_chart("user Updated Successfully",1);
		}
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$item_categoryObj	=new user();
	$item_categoryObj->delete_this_user($_POST['user_id']);
}
else if($_POST['action']==3)
{
	//session_destroy();
	session_start();
	$_SESSION['employee_id'] = $_POST['user_id'];
	header("Location: http://www.fakihivfcms.com");

}