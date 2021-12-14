<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../model/policy.class.php");
require_once("../model/policy_state.class.php");
require_once("../model/tracker.class.php");
require_once("../model/policy_chapter.class.php");
require_once("../model/policy_section.class.php");
require_once("../../../../html/lib/model/validation.class.php");

if($_POST['action']==1)
{
	
	$val = new Validation();
	$val->setRules("policy_title","Policy title is a required Field.",array("required"));
	$val->setRules("policy_description","Policy Description is a required Field.",array("required"));
	$val->setRules("policy_chapter","Policy Chapter is a required Field.",array("required"));
	$val->setRules("policy_department","Policy Department is a required Field.",array("required"));
	$val->setRules("policy_effective_date","Effective date is a required Field.",array("required"));	
	$val->setRules("policy_revision_date","Revision date is a required Field.",array("required"));	
	$val->setRules("policy_branches","At lease one branch is required.",array("required"));	
	$val->setRules("policy_control_type","Policy Control Type is a required Field.",array("required"));
	
	if($_POST['policy_control_type']==2)
			$val->setRules("policy_control_password","Since you select Password Protected , Password is a required Field.",array("required"));
	
	if(!$val->validate())
	{
		//echo $val->draw_errors_list(1);
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]=$val->draw_errors_list(1);
	}

	else
	{
		if($_POST['policy_id']==-1)
		{
			$policyObj	=new policy();
			$inserted_policy_id=$policyObj->insert_new_policy($_POST,$_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$inserted_policy_id;
			$result["return_html"]="";		
		}
		else
		{
			$policyObj	=new policy($_POST['policy_id']);
			$policyObj->update_existing($_POST);
			$result["success"]		=1;
			$result["return_value"]	=$policyObj->policy_id;
			$result["return_html"]	="Policy Updated Successfully";				
		}
	}
echo json_encode($result);
}
else if($_POST['action']==2)
{
	$policyObj=new policy($_POST['policy_id']);
	$policyObj->insert_new_section($_POST['section_id'],$_SESSION['employee_id']);
}
else if($_POST['action']==3)
{
	$policyObj	=new policy($_POST['policy_id']);
	$policyObj->update_policy_section_content($_POST['content_id'],$_POST['content']);
	echo "<div class='alert alert-success'>Policy Section Updated successfully</div>";
}

else if($_POST['action']==4)
{
	$policyObj	=new policy($_POST['policy_id']);
	$policyObj->remove_section_from_policy($_POST['content_id']);
	echo "<div class='alert alert-success'>Policy Section Removed successfully</div>";	
}
else if($_POST['action']==5)
{
	if($_POST['action_id']==1)
	{
		$val = new Validation();
		$val->setRules("employee_id","Reviewer cannot be empty.",array("required"));
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]=$val->draw_errors_list(1);
		}

		else
		{
			$policyObj	=new policy($_POST['policy_id']);
			$tracker_id	=$policyObj->insert_tracker($_POST,$_SESSION['employee_id']);
			$policyObj->update_policy_state($tracker_id);	
			$pending_id=$policyObj->insert_into_pending_actions($_POST,$_SESSION['employee_id'],$tracker_id);
			$result["success"]		=1;
			$result["return_value"]	=$pending_id;
			$result["return_html"]=$val->draw_success_chart("Policy Sent for Revision",1);	
		}	
	echo json_encode($result);
	}
	else if($_POST['action_id']==2)
	{
		$val = new Validation();
		$val->setRules("employee_id","The Employee Who should approve cannnot be empty.",array("required"));
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]=$val->draw_errors_list(1);
		}	
		else
		{
			$policyObj	=new policy($_POST['policy_id']);
			$tracker_id	=$policyObj->insert_tracker($_POST,$_SESSION['employee_id']);
			$policyObj->update_policy_state($tracker_id);	
			$pending_id=$policyObj->insert_into_pending_actions($_POST,$_SESSION['employee_id'],$tracker_id);
			$result["success"]		=1;
			$result["return_value"]	=$pending_id;
			$result["return_html"]=$val->draw_success_chart("Policy Sent for Revision",1);		
		}
		echo json_encode($result);	
	}
	else if($_POST['action_id']==5)
	{
		//print_r($_POST);
		    $val = new Validation();
			$policyObj	=new policy($_POST['policy_id']);
			$tracker_id	=$policyObj->insert_tracker($_POST,$_SESSION['employee_id']);	
			$policyObj->update_policy_state($tracker_id);
			if($_POST['notify']==1)
				$policyObj->notify_employee($_POST['text_notification']);
			$result["success"]		=1;
			$result["return_value"]	=$tracker_id;
			$result["return_html"]=$val->draw_success_chart("The policy is now public for all the Employee.",1);	
			echo json_encode($result);
	}
}

else if($_POST['action']==6)
{
	$policyObj				=new policy($_POST['policy_id']);
	$tracker_id				=$policyObj->policy_state_id_FK;
	$trackerObj				=new policy_tracker($tracker_id);
	$pending_details		=$trackerObj->get_pending_details();
	$policyObj->update_pending_notes($pending_details[0]["pending_id"],$_POST['revision_notes']);
	echo "<div class='alert alert-success'>Revision Notes Updated successfully , <br/> If your revision is done Kindly press on the action 'Revision Done' to inform the author</div>";
}	

else if($_POST['action']==7)
{
	$policyObj				=new policy($_POST['policy_id']);
	$tracker_id				=$policyObj->policy_state_id_FK;
	$trackerObj				=new policy_tracker($tracker_id);
	//var_dump($trackerObj);
	//$tracker_state			=$trackerObj->get_tracker_state();
	//$pStateObj				=new policy_state($tracker_state[0]["state_id_FK"]);
	//$av_actions				=$pStateObj->get_state_actions();	
	//$policyObj->update_pending_notes($trackerObj->pending_id,$_POST['revision_notes']);
	//echo "<div class='alert alert-success'>Revision Notes Updated successfully , <br/> If your revision is done Kindly press on the action 'Revision Done' to inform the author</div>";	
}

else if($_POST['action']==8)
{
	//print_r($_POST);
	$policyObj = new policy($_POST['policy_id']);
	$policyObj->swap_sections($_POST);
	echo "<div class='alert alert-success'>Sections Order updated successfully</div>";	
	
}

else if($_POST['action']==9)
{
	if($_POST['chapter_id']==-1)
	{
		$chapter_title 	 		=trim($_POST["chapter_title"]);
		$chapterObj				=new policy_chapter();

		$val=new Validation();
		$val->setRules("chapter_title","Chapter Title is a required Field.",array("required"));	
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$chapterObj->chapter_title=$chapter_title;
			$chapter_id	=$chapterObj->insert_new_chapter($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$chapter_id;
			$result["return_html"]	=$val->draw_success_chart("Chapter added Successfully",1);
		}
	}
 
	else
	{
		$chapter_title 	 		=trim($_POST["chapter_title"]);
		$chapterObj				=new policy_chapter($_POST['chapter_id']);

		$val=new Validation();
		$val->setRules("chapter_title","Chapter Title is a required Field.",array("required"));	
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$chapterObj->chapter_title =$chapter_title;
			$chapterObj->update_the_chapter($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['chapter_id'];
			$result["return_html"]	=$val->draw_success_chart("Chapter added Successfully",1);
		}		
		
	}
	echo json_encode($result);	
}

else if($_POST['action']==10)
{
	$chapterObj			=new policy_chapter($_POST['chapter_id']);
	$chapterObj->delete_chapter();
}

else if($_POST['action']==11) {
	if($_POST['section_id']==-1) 
	{
		$section_title 	 			=trim($_POST["section_title"]);
		$section_help_tip 	 		=trim($_POST["section_help_tip"]);
		$section_date_created 	 	=Date("Y-m-d H:i:s");
		$sectionObj					=new policy_section();

		$val=new Validation();
		$val->setRules("section_title","Section Title is a required Field.",array("required"));
		$val->setRules("section_help_tip","Section Help is a required Field.",array("required"));		
		
		if(!$val->validate()) 
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else {
			$sectionObj->section_title=$section_title;
			$sectionObj->section_help_tip=$section_help_tip;
			$sectionObj->section_date_created=$section_date_created;
			$section_id	=$sectionObj->insert_new_section($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$section_id;
			$result["return_html"]	=$val->draw_success_chart("Chapter added Successfully",1);
		}
	}
 
	else 
	{
		$section_title 	 			=$_POST["section_title"];
		$section_help_tip 	 		=$_POST["section_help_tip"];
		$sectionObj					=new policy_section($_POST['section_id']);

		$val=new Validation();
		$val->setRules("section_title","Section Title is a required Field.",array("required"));
		$val->setRules("section_help_tip","Section Help is a required Field.",array("required"));	
		
		if(!$val->validate()) {
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else {
			$sectionObj->section_title=$section_title;
			$sectionObj->section_help_tip=$section_help_tip;
			
			$sectionObj->update_section($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['section_id'];
			$result["return_html"]	=$val->draw_success_chart("Chapter added Successfully",1);
		}		
	}
	echo json_encode($result);	
}

else if($_POST['action']==12) {
	$sectionObj			=new policy_section($_POST['section_id']);
	$sectionObj->delete_section();
}
else if($_POST['action']==13) {
	$sectionObj			=new policy_chapter($_POST['section_id']);
	$sectionObj->assigned_chapter();
}
else if($_POST['action']==14) {
	$policObj=new policy($_POST['policy_id']);
	$val=new Validation();
	
	if($policObj->policy_control_password==$_POST['policy_password'])
	{
			$result["success"]		=1;
			$result["return_value"]	=$_POST['policy_id'];
			$result["return_html"]	=$val->draw_success_chart("Authenticated Successfully",1);		
	}
	else
	{
			$result["success"]		=0;
			$result["return_value"]	=$_POST['policy_id'];
			$result["return_html"]	=$val->draw_custom_error("Wrong Password Provided",1);			
	}
echo json_encode($result);
}


?>