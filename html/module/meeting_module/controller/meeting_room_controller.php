<?php
session_start();
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");

require_once("../model/room.class.php");


if($_POST['action']==1) 
{	
	if($_POST['room_id']==-1)
	{
		$room_title 	 			=trim($_POST["room_title"]);
		$room_description 	 		=trim($_POST["room_description"]);
		$branch_id_FK 	 			=trim($_POST["branch_id_FK"]);
		$room_capacity 	 			=trim($_POST["room_capacity"]);

		$roomObj					=new meeting_room();

		$val=new Validation();
		$val->setRules("room_title","Room Name is a required Field.",array("required"));
		$val->setRules("branch_id_FK","Room Branch is a required Field.",array("required"));
		$val->setRules("room_capacity","Room Capacity is a required Field.",array("required"));	
		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$room_id	                     	=$roomObj->insert_new_room($_POST,$_SESSION['employee_id']);
			
			$result["success"]		=1;
			$result["return_value"]	=$room_id;
			$result["return_html"]	=$val->draw_success_chart("Added Successfully",1);
		}
	}
 
	else
	{
		$room_title 	 			=trim($_POST["room_title"]);
		$room_description 	 		=trim($_POST["room_description"]);
		$branch_id_FK 	 			=trim($_POST["branch_id_FK"]);
		$room_capacity 	 			=trim($_POST["room_capacity"]);
		$roomObj					=new meeting_room();

		$val=new Validation();
		
		$val->setRules("room_title","Room Name is a required Field.",array("required"));
		$val->setRules("branch_id_FK","Room Branch is a required Field.",array("required"));
		$val->setRules("room_capacity","Room Capacity is a required Field.",array("required"));
		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$roomObj->update_selected_room($_POST,$_POST['room_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['room_id'];
			$result["return_html"]	=$val->draw_success_chart("Updated Successfully",1);
		}		
		
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$roomObj			=new meeting_room();
	$roomObj->delete_selected_room($_POST['room_id']);
}

?>