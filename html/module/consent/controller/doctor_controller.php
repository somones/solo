<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");

require_once("../model/doctor.class.php");


if($_POST['action']==1) 
{
	//print_r($_POST);
	if($_POST['doctor_id']==-1)
	{
		$doctor_title 								=trim($_POST["doctor_title"]);
		$doctor_name								=trim($_POST["doctor_name"]);
		$doctor_email								=trim($_POST["doctor_email"]);
		$doctor_phone_number						=trim($_POST["doctor_phone_number"]);
		$doctor_extension							=trim($_POST["doctor_extension"]);
		$doctor_hr_number							=trim($_POST["doctor_hr_number"]);
		$doctor_branch_FK							=trim($_POST["doctor_branch_FK"]);
		$doctor_departement_FK						=trim($_POST["doctor_departement_FK"]);
		$doctor_specialty_FK						=trim($_POST["doctor_specialty_FK"]);
		$doctor_experience							=trim($_POST["doctor_experience"]);
		$doctor_nationality							=trim($_POST["doctor_nationality"]);
		$doctor_gender								=trim($_POST["doctor_gender"]);
		$user_id_FK									=trim($_POST["user_id_FK"]);

		$doctor_itemObj				=new doctor();

		$val=new Validation();
			
		$val->setRules("doctor_title","Doctor Title is a required Field.",array("required"));
		$val->setRules("doctor_name","Doctor Name is a required Field.",array("required"));
		$val->setRules("doctor_hr_number","Doctor HR Number is a required Field.",array("required"));
		$val->setRules("doctor_branch_FK","Doctor Branch is a required Field.",array("required"));
		$val->setRules("doctor_departement_FK","Doctor Departemnet is a required Field.",array("required"));
		$val->setRules("doctor_specialty_FK","Doctor Speciality is a required Field.",array("required"));
		$val->setRules("doctor_gender","Doctor Gender is a required Field.",array("required"));
		$val->setRules("user_id_FK","USER is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$doctor_itemObj->doctor_title							=$doctor_title;
			$doctor_itemObj->doctor_name							=$doctor_name;
			$doctor_itemObj->doctor_email							=$doctor_email;
			$doctor_itemObj->doctor_phone_number					=$doctor_phone_number;
			$doctor_itemObj->doctor_extension						=$doctor_extension;
			$doctor_itemObj->doctor_hr_number						=$doctor_hr_number;
			$doctor_itemObj->doctor_branch_FK						=$doctor_branch_FK;
			$doctor_itemObj->doctor_departement_FK					=$doctor_departement_FK;
			$doctor_itemObj->doctor_specialty_FK					=$doctor_specialty_FK;
			$doctor_itemObj->doctor_experience						=$doctor_experience;
			$doctor_itemObj->doctor_nationality						=$doctor_nationality;
			$doctor_itemObj->doctor_gender							=$doctor_gender;
			$doctor_itemObj->user_id_FK								=$user_id_FK;

			$doctor_id	                    						=$doctor_itemObj->insert_new_doctor($_SESSION['employee_id']);

			$doctor_itemObj->remove_all_branch($doctor_id);		
			$doctor_branch_FK	=explode(",",$_POST["doctor_branch_FK"]);		
			for($i=0;$i<count($doctor_branch_FK);$i++)
			{
				$doctor_itemObj->add_doctor_branch($doctor_id,$doctor_branch_FK[$i]);
			}

			$result["success"]		=1;
			$result["return_value"]	=$doctor_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		$doctor_title 								=trim($_POST["doctor_title"]);
		$doctor_name								=trim($_POST["doctor_name"]);
		$doctor_email								=trim($_POST["doctor_email"]);
		$doctor_phone_number						=trim($_POST["doctor_phone_number"]);
		$doctor_extension							=trim($_POST["doctor_extension"]);
		$doctor_hr_number							=trim($_POST["doctor_hr_number"]);
		$doctor_branch_FK							=trim($_POST["doctor_branch_FK"]);
		$doctor_departement_FK						=trim($_POST["doctor_departement_FK"]);
		$doctor_specialty_FK						=trim($_POST["doctor_specialty_FK"]);
		$doctor_experience							=trim($_POST["doctor_experience"]);
		$doctor_nationality						    =trim($_POST["doctor_nationality"]);
		$doctor_gender								=trim($_POST["doctor_gender"]);
		$user_id_FK									=trim($_POST["user_id_FK"]);

		$doctor_itemObj								=new doctor();

		$val=new Validation();

		$val->setRules("doctor_title","Doctor Title is a required Field.",array("required"));
		$val->setRules("doctor_name","Doctor Name is a required Field.",array("required"));
		$val->setRules("doctor_hr_number","Doctor HR Number is a required Field.",array("required"));
		$val->setRules("doctor_branch_FK","Doctor Branch is a required Field.",array("required"));
		$val->setRules("doctor_departement_FK","Doctor Departemnet is a required Field.",array("required"));
		$val->setRules("doctor_specialty_FK","Doctor Speciality is a required Field.",array("required"));
		$val->setRules("doctor_gender","Doctor Gender is a required Field.",array("required"));
		$val->setRules("user_id_FK","USER is a required Field.",array("required"));
		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$doctor_itemObj->doctor_title							=$doctor_title;
			$doctor_itemObj->doctor_name							=$doctor_name;
			$doctor_itemObj->doctor_email							=$doctor_email;
			$doctor_itemObj->doctor_phone_number					=$doctor_phone_number;
			$doctor_itemObj->doctor_extension						=$doctor_extension;
			$doctor_itemObj->doctor_hr_number						=$doctor_hr_number;
			$doctor_itemObj->doctor_branch_FK						=$doctor_branch_FK;
			$doctor_itemObj->doctor_departement_FK					=$doctor_departement_FK;
			$doctor_itemObj->doctor_specialty_FK					=$doctor_specialty_FK;
			$doctor_itemObj->doctor_experience						=$doctor_experience;
			$doctor_itemObj->doctor_nationality						=$doctor_nationality;
			$doctor_itemObj->doctor_gender							=$doctor_gender;
			$doctor_itemObj->user_id_FK								=$user_id_FK;

			$doctor_itemObj->update_this_doctor($_POST['doctor_id']);

			$doctor_itemObj->remove_all_branch($_POST['doctor_id']);		
			$doctor_branch_FK	=explode(",",$_POST["doctor_branch_FK"]);		
			for($i=0;$i<count($doctor_branch_FK);$i++)
			{
				$doctor_itemObj->add_doctor_branch($_POST['doctor_id'],$doctor_branch_FK[$i]);
			}

			$result["success"]		=1;
			$result["return_value"]	=$_POST['doctor_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$item_categoryObj	=new doctor();
	$item_categoryObj->delete_this_doctor($_POST['doctor_id']);
}
?>