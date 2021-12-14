<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../lib/model/database.class.php");
require_once("../../../lib/model/company.class.php");
require_once("../../../lib/model/employee.class.php");
require_once("../../../lib/model/department.class.php");
require_once("../../../lib/model/validation.class.php");
require_once("../../../lib/model/branch.class.php");
require_once("../../../lib/model/module.class.php");
require_once("../../../lib/model/item_category.class.php");
require_once("../../../lib/model/template.inc.php");
if($_POST['action']==1)
{
	$employeeObj=new employee($_SESSION['employee_id']);
	$val= new Validation();
	$val->setRules("employee_full_name","Fulle name is a required Field.",array("required"));
	$val->setRules("employee_dob","Date of birth is a required ",array("required"));
	$val->setRules("branch_id_FK","Branch  is a required Field.",array("required"));
	$val->setRules("department_id_FK","Departement  is a required Field. ",array("required"));
	$val->setRules("employee_job_title","Job Title is a required Field.",array("required"));
	$val->setRules("employee_number","HR File number is a required ",array("required"));	
	if($val->validate())
	{
		$employeeObj->branch_id_FK =$_POST['branch_id_FK'];
		$employeeObj->department_id_FK =$_POST['department_id_FK'];
		$employeeObj->employee_full_name =$_POST['employee_full_name'];
		$employeeObj->employee_job_title =$_POST['employee_job_title'];
		$employeeObj->employee_dob =$_POST['employee_dob'];
		$employeeObj->employee_number =$_POST['employee_number'];
		$employeeObj->profile_completed =1;

		$employeeObj->update_employee_profile();
		$val->draw_success_chart("Your Profile is updated successfully");
	}
	else
	{
		$val->draw_errors_list();
	}
}

?>