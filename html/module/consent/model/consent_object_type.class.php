<?php

class consent_object_type
{
	public $table_name="consent_object_type";
	public $type_id;
	public $type_name;
	public $type_description;
	public $type_linked_to_user;
	
	function __Construct($type_id=NULL)
	{
		if(isset($type_id))
		{
			$this->type_id=$type_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `type_id`=:type_id";
		$db->query($query);
		$db->bind("type_id",$this->type_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_all_object_type($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."`";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_object_type($user_id) {

		$query="INSERT INTO `".$this->table_name."` 
		(
			`type_name`,
			`type_description`,
			`type_linked_to_user`
		)

		VALUES(
			'".$this->type_name."',
			'".$this->type_description."',
			'".$this->type_linked_to_user."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_object_type($type_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		`type_name` = '".$this->type_name."',
		`type_description` = '".$this->type_description."',
		`type_linked_to_user` = '".$this->type_linked_to_user."'
		WHERE `type_id`='".$type_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_object_type($type_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `type_id`='".$type_id."'";
		$db->query($query);
		$db->execute();
	}
}
?>