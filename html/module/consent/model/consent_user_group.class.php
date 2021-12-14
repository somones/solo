<?php

class consent_user_group
{
	public $table_name="consent_user_group";
	public $consent_group_id;
	public $consent_group_title;
	public $consent_group_description;
	public $consent_group_active;
	
	function __Construct($consent_group_id=NULL)
	{
		if(isset($consent_group_id))
		{
			$this->consent_group_id=$consent_group_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `consent_group_id`=:consent_group_id";
		$db->query($query);
		$db->bind("consent_group_id",$this->consent_group_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_consent_user_group($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE consent_group_active = 1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_this_consent_user_group($consent_group_id_FK)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE consent_group_id='".$consent_group_id_FK."'";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function insert_new_consent_user_group($user_id) {

		$query="INSERT INTO `".$this->table_name."` 
		(
			`consent_group_title`,
			`consent_group_description`,
			`consent_group_active`
		)

		VALUES(
			'".$this->consent_group_title."',
			'".$this->consent_group_description."',
			'1'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_consent_user_group($consent_group_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 

		`consent_group_title` = '".$this->consent_group_title."', 
		`consent_group_description` = '".$this->consent_group_description."'
		
		WHERE `consent_group_id`='".$consent_group_id."' ";
		
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_consent_user_group($consent_group_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `consent_group_id`='".$consent_group_id."'";
		$db->query($query);
		$db->execute();
	}

	function get_assigned_users($group_id_FK)
	{
		$array=array();
		$db=new Database();
		$query="SELECT * FROM `consent_group_has_user` WHERE `group_id_FK`='".$group_id_FK."'";
		$db->query($query);
		$result=$db->resultset();
		for($i=0;$i<count($result);$i++)
		{
			array_push($array,$result[$i]["user_id_FK"]);
		}
		return $array;		
	}

	function delete_user_from_group()
	{
		$db=new Database();
		$query="DELETE FROM `consent_group_has_user` WHERE `group_id_FK`='".$this->consent_group_id."'";
		$db->query($query);
		$db->execute();		
	}

	function add_user_to_group($array)
	{
		$db=new Database();
		if(strlen($array)>0)
		{
			$values=explode(",",$array);
			for($i=0;$i<count($values);$i++)
			{
				$query="INSERT INTO `consent_group_has_user` (`group_id_FK`,`user_id_FK`) VALUES('".$this->consent_group_id."','".$values[$i]."')";
				$db->query($query);
				$db->execute();
				
			}
		}		
	}
}
?>