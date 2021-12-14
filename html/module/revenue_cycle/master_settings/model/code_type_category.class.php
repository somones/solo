<?php

class code_type_category
{
	public $table_name="rc_code_type_category";
	public $category_id;
	public $category_description;
	
	function __Construct($category_id=NULL)
	{
		if(isset($category_id))
		{
			$this->category_id=$category_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `category_id`=:category_id";
		$db->query($query);
		$db->bind("category_id",$this->category_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_role($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."`";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
}
?>

