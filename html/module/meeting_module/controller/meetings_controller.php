<?php

session_start();
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../model/meeting.class.php");
if($_POST['action']==1) // To save A meeting
{
	$current_date_time=date("Y-m-d H:i:s");
	$startDate = $_POST["meeting_start_date_time"];
	$endDate = $_POST["meeting_end_date_time"];
	$room_id = $_POST["meeting_room"];
	$meeting = new meeting();

	$true = $meeting->if_exist($room_id,$startDate,$endDate);
	$val=new Validation();
	$val->setRules("meeting_title","Meeting Title is a required Field.",array("required"));
	$val->setRules("meeting_room","Room is a required Field.",array("required"));
	$val->setRules("meeting_start_date_time","Start date-time is a required Field.",array("required"));
	$val->setRules("meeting_end_date_time","End date-time is a required Field.",array("required"));
	$val->setRules("attendees","Minimum required is 1 Attendee.",array("required"));	
	if(!$val->validate())
	{
	$result["success"]		=0;
	$result["return_value"]	=-1;
	$result["return_html"]	=$val->draw_errors_list(1);
	}
	else
	{
		if ($startDate >= $endDate) {
			$result["return_html"]	=$val->draw_custom_error("The Start Date Can't be bigger or Equal to END DATE",1);
		} else if ( $current_date_time > $startDate) {
		 	$result["return_html"]	=$val->draw_custom_error("Sorry we can't book for this DATE",1);
		 	//$true = $meeting->if_exist($room_id,$startDate,$endDate);
		} else if ($meeting->if_exist($room_id,$startDate) == true) {
		 	$result["return_html"]	=$val->draw_custom_error("Sorry The Room is Booked For this Time",1);
		} else 
		{
		
		//If timing is correct 
		if($_POST['meeting_id']==-1)
		{
			$meetingObj			=new meeting();
			$this_meeting_id	=$meetingObj->insert_new_meeting($_POST,$_SESSION['employee_id']);
			$thismeetingObj=new meeting($this_meeting_id);

			$result["success"]=1;
			$result["return_value"]=$this_meeting_id;
			$result["return_html"]	=$val->draw_success_chart("Meeting added Successfully",1);
		}
		else
		{
			$thismeetingObj			=new meeting($_POST['meeting_id']);
			$thismeetingObj->update_meeting($_POST,$_SESSION['employee_id']);
			$result["success"]=1;
			$result["return_value"]=$_POST['meeting_id'];
			$result["return_html"]	=$val->draw_success_chart("Meeting Updated Successfully",1);						
		}
			$thismeetingObj->remove_all_attendee();	
			$meeting_attendees	=explode(",",$_POST["attendees"]);				
			for($i=0;$i<count($meeting_attendees);$i++)
			{
				$thismeetingObj->add_meeting_attendee($meeting_attendees[$i],2);
			}
		} 
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	print_r($_POST);
	$val=new Validation();
		$val->setRules("meeting_title","Meeting Title is a required Field.",array("required"));
		$val->setRules("meeting_room","Room is a required Field.",array("required"));
		$val->setRules("meeting_start_date_time","Start date-time is a required Field.",array("required"));
		$val->setRules("meeting_end_date_time","End date-time is a required Field.",array("required"));
		$val->setRules("attendees","Minimum required is 1 Attendee.",array("required"));	
		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			//Validate TIming is correct
			$current_date_time=date("Y-m-d H:i:s");
			$startDate = $_POST["meeting_start_date_time"];
			$endDate = $_POST["meeting_end_date_time"];
			$room_id = $_POST["meeting_room"];
			$meeting = new meeting();
			
			if ($startDate == $endDate) {
				$result["return_html"]	=$val->draw_custom_error("The Start Date Can't be bigger or Equal to END DATE",1);
			 } else if ($startDate < $current_date_time) {
			 	$result["return_html"]	=$val->draw_custom_error("Sorry we can't book for this DATE",1);
			 } else {
			 	//If timing is correct 
				$meeting_attendees	=explode(",",$_POST["attendees"]);
				$meetingObj			=new meeting();
				$result["success"]=1;
				$meeting_id	=$meetingObj->update_meeting($_POST,$_SESSION['employee_id']);
				$thismeetingObj=new meeting($meeting_id);
				for($i=0;$i<count($meeting_attendees);$i++)
				{
					$thismeetingObj->add_meeting_attendee($meeting_attendees[$i],2);
				}
				$result["return_value"]=$meeting_id;
				$result["return_html"]	=$val->draw_success_chart("Meeting added Successfully",1);
			}
		}
	echo json_encode($result);		
}

else if($_POST['action']==3) {
	//print_r($_POST);
	$meeting	=new meeting($_POST['meeting_id']);
	$meeting->delete_meeting($_POST['meeting_id']);
	echo "<div class='alert alert-success'>The Meeting Cancelled</div>";	
}

else if($_POST['action']==4){
	$meeting	=new meeting($_POST['meeting_id']);
	$meeting->update_mom_meeting($_POST['meeting_mom']);
	echo "<div class='alert alert-success'>Minutes of Meeting has been updated.</div>";	
	//print_r($_POST);
}

?>