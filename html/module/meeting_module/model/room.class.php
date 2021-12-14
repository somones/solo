<?php

class meeting_room
{
	public $table_name="module_meeting_room";
	public $room_id;
	public $room_title;
	public $room_description;
	public $branch_id_FK;
	public $room_capacity;
	public $room_active;
	
	function __Construct($room_id=NULL)
	{
		if(isset($room_id))
		{
			$this->room_id=$room_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `room_id`=:room_id";
		$db->query($query);
		$db->bind("room_id",$this->room_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}	
	
	function get_active_rooms()
	{
		$db=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE `room_active`='1' ORDER BY `room_title`";
		$db->query($query);
		return $db->resultset();
	}

	function get_meeting_room($room_id){
		$db=new Database();
		$query = "SELECT * FROM `setup_company_branch` INNER JOIN `module_meeting_room` ON `module_meeting_room`.`branch_id_FK` = `setup_company_branch`.`branch_id` WHERE `module_meeting_room`.`branch_id_FK` = '".$room_id."'";

		$db->query($query);
		return $db->resultset();
	}


	function insert_new_room($array,$user_id)
	{
		$query="INSERT INTO `".$this->table_name."` 
		(
			`room_title`,
			`room_description`,
			`branch_id_FK`,
			`room_capacity`,
			`room_active`
		) 
		VALUES 
		(
			'".$array["room_title"]."',
			'".$array["room_description"]."',
			'".$array["branch_id_FK"]."',
			'".$array["room_capacity"]."',
			'1'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$room_id=$db->lastInsertId();
		return $room_id;
	}

	function update_selected_room($array,$room_id) {
		$query= "UPDATE `module_meeting_room` SET 
		`room_title` = '".$array["room_title"]."',
		`room_description` = '".$array["room_description"]."', 
		`branch_id_FK` = '".$array["branch_id_FK"]."', 
		`room_capacity` = '".$array["room_capacity"]."' 
		
		WHERE `room_id`='".$room_id."' ";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_selected_room($room_id)
	{
		$db=new Database();
		$query="DELETE FROM `module_meeting_room` WHERE `room_id`='".$room_id."'";
		$db->query($query);
		$db->execute();
	}
}
?>

