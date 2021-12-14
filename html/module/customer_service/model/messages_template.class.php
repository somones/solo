<?php

class messages_template
{
	public $table_name="steup_messages_template";
	public $message_template_id;
	public $message_template_name;
	public $message_template_description;
	public $message_template_categorie_id_FK;
	public $message_template_active;
	
	function __Construct($message_template_id=NULL)
	{
		if(isset($message_template_id))
		{
			$this->message_template_id=$message_template_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `message_template_id`=:message_template_id";
		$db->query($query);
		$db->bind("message_template_id",$this->message_template_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_messages_template($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE message_template_active=1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_message_template($user_id) {

		$query="INSERT INTO `".$this->table_name."` 
		(
			`message_template_name`,
			`message_template_description`,
			`message_template_categorie_id_FK`,
			`message_template_active`
		)

		VALUES(
			'".$this->message_template_name."',
			'".$this->message_template_description."',
			'".$this->message_template_categorie_id_FK."',
			'1'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_message_template($message_template_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		`message_template_name` = '".$this->message_template_name."', 
		`message_template_description` = '".$this->message_template_description."',
		`message_template_categorie_id_FK` = '".$this->message_template_categorie_id_FK."'
		WHERE `message_template_id`='".$message_template_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_message_template($message_template_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `message_template_id`='".$message_template_id."'";
		$db->query($query);
		$db->execute();
	}
}
?>