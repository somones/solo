<?php

class speciality
{
	public $table_name="setup_speciality";
	public $speciality_id;
	public $speciality_title;
	public $speciality_description;
	public $speciality_active;
	
	function __Construct($speciality_id=NULL)
	{
		if(isset($speciality_id))
		{
			$this->speciality_id=$speciality_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `speciality_id`=:speciality_id";
		$db->query($query);
		$db->bind("speciality_id",$this->speciality_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_specility($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE speciality_active=1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_speciality($user_id) {

		$query="INSERT INTO `".$this->table_name."` 
		(
			`speciality_title`,
			`speciality_description`,
			`speciality_active`
		)

		VALUES(
			'".$this->speciality_title."',
			'".$this->speciality_description."',
			'1'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_speciality($speciality_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		
		`speciality_title` = '".$this->speciality_title."', 
		`speciality_description` = '".$this->speciality_description."'
		
		WHERE `speciality_id`='".$speciality_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_speciality($speciality_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `speciality_id`='".$speciality_id."'";
		$db->query($query);
		$db->execute();
	}
	
	function get_active_speciality()
	{
		$db=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE `speciality_active`='1'";
		$db->query($query);
		return $db->resultset();
	}

	function get_doctor_speciality($speciality_id_FK)
	{
		$db=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE `speciality_id`='".$speciality_id_FK."'";
		$db->query($query);
		return $db->single();
	}
}

?>

