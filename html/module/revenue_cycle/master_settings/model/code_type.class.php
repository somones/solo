<?php

class code_type
{
	public $table_name="rc_code_type";
	public $code_type_id;
	public $code_type_name;
	public $code_type_description;
	public $code_type_insurance_id_FK;
	public $code_type_category_id_FK;
	
	function __Construct($role_id=NULL)
	{
		if(isset($role_id))
		{
			$this->role_id=$role_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `role_id`=:role_id";
		$db->query($query);
		$db->bind("role_id",$this->role_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_code_type($user_session=NULL)
	{
		$query="SELECT * FROM `rc_code_type`";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_code_type($user_id) {
		$query="INSERT INTO `".$this->table_name."` 
		(
			`code_type_id_FK`,
			`code_value`,
			`code_short_description`,
			`code_description`,
			`code_active`
		)

		VALUES(
			'".$this->code_type_id_FK."',
			'".$this->code_value."',
			'".$this->code_short_description."',
			'".$this->code_description."',
			'1'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$code_id=$db->lastInsertId();
		return $code_id;
	}

	function update_the_code_type($code_id){
		
		$query= "UPDATE `rc_code_type` SET 
		
		`code_type_id_FK` = '".$this->code_type_id_FK."', 
		`code_value` = '".$this->code_value."',
		`code_short_description` = '".$this->code_short_description."',
		`code_description` = '".$this->code_description."'
		
		WHERE `code_id`='".$code_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_code_type()
	{
		$db=new Database();
		$query="DELETE FROM `rc_code_type` WHERE `code_id`='".$this->code_id."'";
		$db->query($query);
		$db->execute();
	}

	function get_code_type($code_type_id_FK){
		$query="SELECT * FROM `rc_code_type` WHERE `code_type_id`='".$code_type_id_FK."'";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_category_of_code_type($category_id)
	{
		$query="SELECT * FROM `rc_code_type_category` WHERE `category_id`='".$category_id."' ";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
}
?>