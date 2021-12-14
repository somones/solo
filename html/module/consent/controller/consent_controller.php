<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../../../lib/model/uploaded_file.class.php");
require_once("../model/consent.class.php");
require_once("../model/consent_request.class.php");
require_once("../model/consent_user_group.class.php");
require_once("../model/request_has_signee.class.php");


if($_POST['action']==1) 
{
	//print_r($_POST);
	if($_POST['consent_id']==-1)
	{
		$consent_title 	 					=trim($_POST["consent_title"]);
		$consent_description 	 			=trim($_POST["consent_description"]);
		$category_id_FK 	 				=trim($_POST["category_id_FK"]);
		$branch_id_FK 	 					=trim($_POST["branch_id_FK"]);
	/*
		$admin_signature_required 	 		=trim($_POST["admin_signature_required"]);
		$patient_signature_required 	 	=trim($_POST["patient_signature_required"]);
		$doctor_signature_required 	 		=trim($_POST["doctor_signature_required"]);

		$admin_x 							= trim($_POST["admin_x"]);
		$admin_y 							= trim($_POST["admin_y"]);
		$admin_w 							= trim($_POST["admin_w"]);
		$admin_page 						= trim($_POST["admin_page"]);

		$pat_x  							= trim($_POST["pat_x"]);
		$pat_y 								= trim($_POST["pat_y"]);
		$pat_w 								= trim($_POST["pat_w"]);
		$pat_page 							= trim($_POST["pat_page"]);
		
		$doc_x 								= trim($_POST["doc_x"]);
		$doc_y 								= trim($_POST["doc_y"]);
		$doc_w 								= trim($_POST["doc_w"]);
		$doc_page 							= trim($_POST["doc_page"]);
	*/

		$consentObj							=new consent();

		$val=new Validation();
			
		$val->setRules("consent_title","Consent Title is a required Field.",array("required"));
		$val->setRules("consent_description","Consent Description is a required Field.",array("required"));
		$val->setRules("category_id_FK","Consent Category is a required Field.",array("required"));
		$val->setRules("branch_id_FK","Consent branch is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$consentObj->consent_title  							=$consent_title;
			$consentObj->consent_description      					=$consent_description;
			$consentObj->category_id_FK      						=$category_id_FK;
			$consentObj->branch_id_FK      							=$branch_id_FK;
		/*
			$consentObj->admin_signature_required      				=$admin_signature_required;
			$consentObj->patient_signature_required      			=$patient_signature_required;
			$consentObj->doctor_signature_required      			=$doctor_signature_required;
		
			$consentObj->admin_x 									=$admin_x;
			$consentObj->admin_y 									=$admin_y;
			$consentObj->admin_w									=$admin_w;
			$consentObj->admin_page									=$admin_page;
			
			$consentObj->pat_x 										=$pat_x;
			$consentObj->pat_y 										=$pat_y;
			$consentObj->pat_w 										=$pat_w;
			$consentObj->pat_page 									=$pat_page;
			
			$consentObj->doc_x 										=$doc_x;
			$consentObj->doc_y 										=$doc_y;
			$consentObj->doc_w 										=$doc_w;
			$consentObj->doc_page 									=$doc_page;
		*/

			$consent_id	                    		=$consentObj->insert_new_consent($_SESSION['employee_id']);

			$consentObj->remove_all_branch($consent_id);		
			$branch_id_FK	=explode(",",$_POST["branch_id_FK"]);		
			for($i=0;$i<count($branch_id_FK);$i++)
			{
				$consentObj->add_consent_branch($consent_id,$branch_id_FK[$i]);
			}
			
			$result["success"]		=1;
			$result["return_value"]	=$consent_id;
			$result["return_html"]	=$val->draw_success_chart("Consent added Successfully",1);
		}
	}
 
	else
	{
		
		$consent_title 	 					=trim($_POST["consent_title"]);
		$consent_description 	 			=trim($_POST["consent_description"]);
		$category_id_FK 	 				=trim($_POST["category_id_FK"]);
		$branch_id_FK 	 					=trim($_POST["branch_id_FK"]);
	/*
		$admin_signature_required 	 		=trim($_POST["admin_signature_required"]);
		$patient_signature_required 	 	=trim($_POST["patient_signature_required"]);
		$doctor_signature_required 	 		=trim($_POST["doctor_signature_required"]);

		$admin_x 							= trim($_POST["admin_x"]);
		$admin_y 							= trim($_POST["admin_y"]);
		$admin_w 							= trim($_POST["admin_w"]);
		$admin_page 						= trim($_POST["admin_page"]);

		$pat_x  							= trim($_POST["pat_x"]);
		$pat_y 								= trim($_POST["pat_y"]);
		$pat_w 								= trim($_POST["pat_w"]);
		$pat_page 							= trim($_POST["pat_page"]);
		
		$doc_x 								= trim($_POST["doc_x"]);
		$doc_y 								= trim($_POST["doc_y"]);
		$doc_w 								= trim($_POST["doc_w"]);
		$doc_page 							= trim($_POST["doc_page"]);
	*/
		$consentObj							=new consent();

		$val=new Validation();

		$val->setRules("consent_title","Consent Title is a required Field.",array("required"));
		$val->setRules("consent_description","Consent Description is a required Field.",array("required"));
		$val->setRules("category_id_FK","Consent Category is a required Field.",array("required"));
		$val->setRules("branch_id_FK","Consent branch is a required Field.",array("required"));

		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			//print_r($_POST);
			$consentObj->consent_title        		=$consent_title;
			$consentObj->consent_description      	=$consent_description;
			$consentObj->category_id_FK      		=$category_id_FK;
			$consentObj->branch_id_FK      			=$branch_id_FK;
		/*
			$consentObj->admin_signature_required      				=$admin_signature_required;
			$consentObj->patient_signature_required      			=$patient_signature_required;
			$consentObj->doctor_signature_required      			=$doctor_signature_required;

			$consentObj->admin_x 									=$admin_x;
			$consentObj->admin_y 									=$admin_y;
			$consentObj->admin_w									=$admin_w;
			$consentObj->admin_page									=$admin_page;
			
			$consentObj->pat_x 										=$pat_x;
			$consentObj->pat_y 										=$pat_y;
			$consentObj->pat_w 										=$pat_w;
			$consentObj->pat_page 									=$pat_page;
			
			$consentObj->doc_x 										=$doc_x;
			$consentObj->doc_y 										=$doc_y;
			$consentObj->doc_w 										=$doc_w;
			$consentObj->doc_page 									=$doc_page;
		*/
			$consent_id = $_POST['consent_id'];
			$consentObj->update_this_consent($_POST['consent_id']);
			
			$consentObj->remove_all_branch($consent_id);		
			$branch_id_FK	=explode(",",$_POST["branch_id_FK"]);		
			for($i=0;$i<count($branch_id_FK);$i++)
			{
				$consentObj->add_consent_branch($consent_id,$branch_id_FK[$i]);
			}
			$result["success"]		=1;
			$result["return_value"]	=$_POST['consent_id'];
			$result["return_html"]	=$val->draw_success_chart("Consent Updated Successfully",1);
		}
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$item_categoryObj	=new consent();
	//echo $_POST['consent_id'];
	$item_categoryObj->delete_this_consent($_POST['consent_id']);
	$item_categoryObj->remove_all_stepes($_POST['consent_id']);
	$item_categoryObj->remove_all_branch($_POST['consent_id']);
}
else if ($_POST['action']==3) {
	
	$consent_request_title 	 					=trim($_POST["consent_request_title"]);
	$branch_id_FK 	 							=trim($_POST["branch_id_FK"]);
	$consent_id_FK 	 							=trim($_POST["consent_id_FK"]);
	$consent_file_id_FK 	 					=trim($_POST["consent_file_id_FK"]);
	$patient_file 	 							=trim($_POST["patient_file"]);

	$consentObj									=new consent_request();

	$val=new Validation();
		
	$val->setRules("consent_id_FK","The Constent is a required Field.",array("required"));
	$val->setRules("branch_id_FK","Consent branch is a required Field.",array("required"));
	$val->setRules("consent_file_id_FK","Consent File is a required Field.",array("required"));
	$val->setRules("patient_file","The Patient File is a required Field.",array("required"));

	if(!$val->validate())
	{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
	}
	else
	{
		$consentObj->consent_request_title  			=$consent_request_title;
		$consentObj->branch_id_FK      					=$branch_id_FK;
		$consentObj->consent_id_FK      				=$consent_id_FK;
		$consentObj->consent_file_id_FK      			=$consent_file_id_FK;
		$consentObj->patient_file      					=$patient_file;
		
		$uploadObj = new uploaded_file();
		$upload_Obj =$uploadObj->get_this_file($consent_file_id_FK);

		$consentRObj						=new consent();
		$consentR_Obj						=$consentRObj->get_this_consent($consent_id_FK);

		$consent_request_id=$consentObj->insert_new_consent_request($consentR_Obj['consent_title']);

		$request_patientObj	=new request_has_signee();
		$patient_id = $request_patientObj->assign_this_consent_request_to($consent_request_id,3,0,$_POST['consent_file_id_FK']);

		$consentObj->assign_new_file($_POST['consent_file_id_FK'],$consent_request_id);
		$result["success"]		=1;
		$result["return_value"]	=$consent_request_id;
		$result["patient_id"]	=$patient_id;
		$result["return_html"]	=$val->draw_success_chart("Consent added Successfully",1);
	}
	echo json_encode($result);
}
else if($_POST['action']==4)
{
	$consent_requestObj	=new consent_request();
	$consent_requestObj->delete_this_consent_request($_POST['consent_id']);
}
else if ($_POST['action']==5) {
	
	$doctor_id_FK 	 							=trim($_POST["doctor_id_FK"]);
	$comments 	 								=trim($_POST["comments"]);

	$consentObj									=new consent_request();

	$val=new Validation();

	$val->setRules("doctor_id_FK","Doctor is a required Field.",array("required"));
	
	if(!$val->validate())
	{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
	}
	else
	{
		$consentObj->doctor_id_FK        		=$doctor_id_FK;
		$consentObj->comments      				=$comments;
		
		$consentObj->assign_this_consent_request_to_the_doctor($_POST['consent_request_id']);

		$result["success"]		=1;
		$result["return_value"]	=$_POST['consent_request_id'];
		$result["return_html"]	=$val->draw_success_chart("Consent Updated Successfully",1);
	}
	echo json_encode($result);
}
else if ($_POST['action']==6) {
	$employee_id_FK 	 						=trim($_POST["employee_id_FK"]);
	$comments 	 								=trim($_POST["comments"]);

	$consentObj									=new consent_request();

	$val=new Validation();

	$val->setRules("employee_id_FK","Admin is a required Field.",array("required"));
	
	if(!$val->validate())
	{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
	}
	else
	{
		$consentObj->employee_id_FK        		=$employee_id_FK;
		$consentObj->comments      				=$comments;
		
		$consentObj->assign_this_consent_request_to_the_admin($_POST['consent_request_id']);

		$result["success"]		=1;
		$result["return_value"]	=$_POST['consent_request_id'];
		$result["return_html"]	=$val->draw_success_chart("Consent Updated Successfully",1);
	}
	echo json_encode($result);
}
else if ($_POST['action']==7) {
	
	$patient_id_FK 	 							=trim($_POST["patient_id_FK"]);
	$comments 	 								=trim($_POST["comments"]);

	$consentObj									=new consent_request();

	$val=new Validation();

	$val->setRules("patient_id_FK","Patient is a required Field.",array("required"));
	
	if(!$val->validate())
	{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
	}
	else
	{
		$consentObj->patient_id_FK        		=$patient_id_FK;
		$consentObj->comments      				=$comments;
		
		$consentObj->assign_this_consent_request_to_the_patient($_POST['consent_request_id']);

		$result["success"]		=1;
		$result["return_value"]	=$_POST['consent_request_id'];
		$result["return_html"]	=$val->draw_success_chart("Consent Updated Successfully",1);
	}
	echo json_encode($result);
}
if($_POST['action']==8) 
{
	if($_POST['consent_group_id']==-1)
	{
		$consent_group_title 	 					=trim($_POST["consent_group_title"]);
		$consent_group_description 	 				=trim($_POST["consent_group_description"]);

		$consentObj									=new consent_user_group();

		$val=new Validation();
			
		$val->setRules("consent_group_title","Consent Title is a required Field.",array("required"));
		$val->setRules("consent_group_description","Consent Description is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$consentObj->consent_group_title  				=$consent_group_title;
			$consentObj->consent_group_description      	=$consent_group_description;

			$consent_group_id	                    		=$consentObj->insert_new_consent_user_group($_SESSION['employee_id']);
			
			$result["success"]		=1;
			$result["return_value"]	=$consent_group_id;
			$result["return_html"]	=$val->draw_success_chart("Consent added Successfully",1);
		}
	}
 
	else
	{
		
		$consent_group_title 	 					=trim($_POST["consent_group_title"]);
		$consent_group_description 	 				=trim($_POST["consent_group_description"]);

		$consentObj									=new consent_user_group();

		$val=new Validation();

		$val->setRules("consent_group_title","Consent Title is a required Field.",array("required"));
		$val->setRules("consent_group_description","Consent Description is a required Field.",array("required"));

		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$consentObj->consent_group_title        		=$consent_group_title;
			$consentObj->consent_group_description      	=$consent_group_description;
			
			$consentObj->update_this_consent_user_group($_POST['consent_group_id']);

			$result["success"]		=1;
			$result["return_value"]	=$_POST['consent_group_id'];
			$result["return_html"]	=$val->draw_success_chart("Consent Updated Successfully",1);
		}
	}
	echo json_encode($result);	
} 
else if($_POST['action']==9)
{
	$item_categoryObj	=new consent_user_group();
	$item_categoryObj->delete_this_consent_user_group($_POST['consent_group_id']);
}
else if($_POST['action']==10) {
	$contactObj=new consent_user_group($_POST['consent_group_id']);	
	$contactObj->delete_user_from_group();
	$contactObj->add_user_to_group($_POST['array']);
	echo "<div class='alert alert-success'>Well Done</div>";
	
}
else if($_POST['action']==11) {
	$contactObj=new consent();	
	$contactObj->add_rules($_POST['consent_id'],$_POST['consent_id_FK'],$_POST['user_step'],$_POST['comment']);
	echo "<div class='alert alert-success'>Well Done</div>";
}
else if($_POST['action']==12) {
	$doctor_id 	 						=trim($_POST["doctor_id"]);
	$admin_id 	 						=trim($_POST["admin_id"]);

	$consentObj							=new request_has_signee();

	$val=new Validation();

	$val->setRules("doctor_id","The Doctor is a required Field.",array("required"));
	$val->setRules("admin_id","The Admin is a required Field.",array("required"));

	if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		} else {
			$consentObj->doctor_id        		=$doctor_id;
			$consentObj->admin_id      			=$admin_id;
			
			if ($doctor_id != 0) {
				$user_type = 2;
				$consentObj->assign_this_consent_request_to($_POST['consent_id_FK'],$user_type,$_POST['doctor_id'],$_POST['file_id']);
				//$suffix_id = $consentObj->assign_this_consent_request_to_the_doctor($_POST['consent_id_FK']);
				//$consentObj->save_the_doctor_pending_request($_POST['consent_id_FK'],$doctor_id,$suffix_id);
			}
			if ($admin_id != 0) {
				$user_type = 1;
				$consentObj->assign_this_consent_request_to($_POST['consent_id_FK'],$user_type,$_POST['admin_id'],$_POST['file_id']);
				//$suffix_id = $consentObj->assign_this_consent_request_to_the_admin($_POST['consent_id_FK']);
				//$consentObj->save_the_admin_pending_request($_POST['consent_id_FK'],$admin_id,$suffix_id);
			}
			$val=new Validation();
			$result["success"]		=1;
			$result["return_value"]	=$_POST['consent_id_FK'];
			$result["return_html"]	=$val->draw_success_chart("Sent",1);
		}
	echo json_encode($result);
}
else if($_POST['action']==13) {

	$request_id 	 					=trim($_POST["request_id"]);
	$employee_id 	 					=trim($_POST["employee_id"]);
	$file_id 	 						=trim($_POST["file_id"]);
	$user_type 	 						=trim($_POST["user_type"]);
	$user_id 	 						=trim($_POST["user_id"]);

	$consentObj							=new request_has_signee();

	$consentObj->request_id        		=$request_id;
	$consentObj->employee_id      		=$employee_id;
	$consentObj->file_id      			=$file_id;
	$consentObj->user_type      		=$user_type;
	
	$consentObj->update_this_consent_request($request_id,$employee_id,$file_id,$user_type,$user_id);
	$consentObj->update_signed_this_consent_request($_POST['request_id'],$_POST['file_id']);
	//$consentObj->update_consent_request_pending($request_id,$employee_id);

	$val=new Validation();
	$result["success"]		=1;
	$result["return_value"]	=1;
	$result["return_html"]	=$val->draw_success_chart("Sent",1);

	echo json_encode($result);
}
else if($_POST['action']==14) {

	$request_id 	 					=trim($_POST["request_id"]);
	$employee_id 	 					=trim($_POST["employee_id"]);
	$suffix 	 						=trim($_POST["suffix"]);


	$consentObj							=new consent_request();

	$consentObj->request_id        		=$request_id;
	$consentObj->employee_id      		=$employee_id;
	$consentObj->suffix      			=$suffix;
	

	$consentObj->update_consent_request_has_doctor($request_id,$employee_id,$suffix);
	$consentObj->update_consent_request_pending($request_id,$employee_id,$suffix);

	$val=new Validation();
	$result["success"]		=1;
	$result["return_value"]	=1;
	$result["return_html"]	=$val->draw_success_chart("Sent",1);

	echo json_encode($result);
}
?>