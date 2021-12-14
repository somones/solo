<?php

class consent_category
{
	public $table_name="consent_category";
	public $consent_category_id;
	public $consent_category_name;
	public $consent_category_description;
	
	function __Construct($consent_category_id=NULL)
	{
		if(isset($consent_category_id))
		{
			$this->consent_category_id=$consent_category_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `consent_category_id`=:consent_category_id";
		$db->query($query);
		$db->bind("consent_category_id",$this->consent_category_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_consent_category($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."`";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_consent_category($user_id) {

		$query="INSERT INTO `".$this->table_name."` 
		(
			`consent_category_name`,
			`consent_category_description`
		)

		VALUES(
			'".$this->consent_category_name."',
			'".$this->consent_category_description."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_consent_category($consent_category_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		`consent_category_name` = '".$this->consent_category_name."', 
		`consent_category_description` = '".$this->consent_category_description."'
		WHERE `consent_category_id`='".$consent_category_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_consent_category($consent_category_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `consent_category_id`='".$consent_category_id."'";
		$db->query($query);
		$db->execute();
	}
}
?>