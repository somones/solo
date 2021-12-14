<?php

class messages_template_categorie
{
	public $table_name="steup_messages_template_categorie";
	public $message_templates_categories_id;
	public $message_templates_categories_name;
	public $message_templates_categories_description;
	public $message_templates_categories_branch_id_FK;
	public $message_templates_categories_active;
	
	function __Construct($message_templates_categories_id=NULL)
	{
		if(isset($message_templates_categories_id))
		{
			$this->message_templates_categories_id=$message_templates_categories_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `message_templates_categories_id`=:message_templates_categories_id";
		$db->query($query);
		$db->bind("message_templates_categories_id",$this->message_templates_categories_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_messages_template_categorie($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE message_templates_categories_active=1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_messages_template_categorie($message_templates_categories_id)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE message_templates_categories_id='".$message_templates_categories_id."'";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function insert_new_messages_template_categorie($user_id) {

		$query="INSERT INTO `".$this->table_name."` 
		(
			`message_templates_categories_name`,
			`message_templates_categories_description`,
			`message_templates_categories_branch_id_FK`,
			`message_templates_categories_active`
		)

		VALUES(
			'".$this->message_templates_categories_name."',
			'".$this->message_templates_categories_description."',
			'".$this->message_templates_categories_branch_id_FK."',
			'1'
		)";
		
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_messages_template_categorie($message_templates_categories_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		`message_templates_categories_name` = '".$this->message_templates_categories_name."', 
		`message_templates_categories_description` = '".$this->message_templates_categories_description."',
		`message_templates_categories_branch_id_FK` = '".$this->message_templates_categories_branch_id_FK."'

		WHERE `message_templates_categories_id`='".$message_templates_categories_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_messages_template_categorie($message_templates_categories_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `message_templates_categories_id`='".$message_templates_categories_id."'";
		$db->query($query);
		$db->execute();
	}
}
?>