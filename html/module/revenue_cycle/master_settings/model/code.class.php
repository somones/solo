<?php

class rc_code
{
	public $table_name="rc_code";
	public $code_id;
	public $code_type_id_FK;
	public $code_value;
	public $code_short_description;
	public $code_description;
	public $code_active;
	
	function __Construct($code_id=NULL)
	{
		if(isset($code_id))
		{
			$this->code_id=$code_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `code_id`=:code_id";
		$db->query($query);
		$db->bind("code_id",$this->code_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_code($user_session=NULL)
	{
		$query="SELECT * FROM `rc_code` ";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_code($user_id) {
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

	function update_the_code($code_id){
		
		$query= "UPDATE `rc_code` SET 
		
		`code_type_id_FK` = '".$this->code_type_id_FK."', 
		`code_value` = '".$this->code_value."',
		`code_short_description` = '".$this->code_short_description."',
		`code_description` = '".$this->code_description."'
		
		WHERE `code_id`='".$code_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_code()
	{
		$db=new Database();
		$query="DELETE FROM `rc_code` WHERE `code_id`='".$this->code_id."'";
		$db->query($query);
		$db->execute();
	}

	function get_code_item($search_token,$category_id){
		$query="SELECT * FROM rc_code
		INNER JOIN rc_code_type ON rc_code_type.code_type_id = rc_code.code_type_id_FK
		WHERE  rc_code.code_id = '".$search_token."' AND rc_code_type.code_type_category_id_FK = '".$category_id."' ";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		echo json_encode($result);
	}





	function get_code_item_search($search_token,$category_id){
		$query="SELECT * FROM rc_code
		INNER JOIN rc_code_type ON rc_code_type.code_type_id = rc_code.code_type_id_FK
		WHERE ( rc_code.code_value LIKE '%".$search_token."%' OR rc_code.code_description LIKE '%".$search_token."%' ) 
		AND rc_code_type.code_type_category_id_FK = '".$category_id."' ";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		echo json_encode($result);
	}
}
?>

