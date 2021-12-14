<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/role.class.php");
//print_r($_POST);
if($_POST['action']==1) // To save A meeting
{
	if($_POST['role_id']==-1)
	{
		$role_name 	 =trim($_POST["role_name"]);
		$role_desc	 =trim($_POST["role_description"]);
		$roleObj			=new role();

		$val=new Validation();
		$val->setRules("role_name","Role Title is a required Field.",array("required"));	
		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$roleObj->role_name=$role_name;
			$roleObj->role_description=$role_desc;
			$role_id	=$roleObj->insert_new_role($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$role_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		$role_name 	 =trim($_POST["role_name"]);
		$role_desc	 =trim($_POST["role_description"]);
		$roleObj			=new role($_POST['role_id']);

		$val=new Validation();
		$val->setRules("role_name","Role Title is a required Field.",array("required"));	
		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$roleObj->role_name=$role_name;
			$roleObj->role_description=$role_desc;
			$roleObj->update_the_role($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['role_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}		
		
	}
	
	echo json_encode($result);	

} 
else if($_POST['action']==2)
{
$roleObj			=new role($_POST['role_id']);
$roleObj->delete_role();
	
}

else if($_POST['action']==3)
{

	$roleObj=new role($_POST['role_id']);
	$roleObj->remove_all_permissions();
	$roleObj->assign_permission_to_role($_POST['array']);
	echo "<div class='alert alert-success'>Permissions Updated successfully</div>";
}

else if($_POST['action']==4)
{
	$roleObj=new role($_POST['list_id']);	
	$roleObj->delete_users_from_role();
	$roleObj->add_users_to_role($_POST['array']);
	echo "<div class='alert alert-success'>Users Updated successfully</div>";
	
}

?>