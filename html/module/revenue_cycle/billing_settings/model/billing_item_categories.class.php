<?php

class billing_item_category
{
	public $table_name="rc_billing_item_category";
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

	function list_of_billing_item_category($user_session=NULL)
	{
		$query="SELECT * FROM `rc_billing_item_category`" ;
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function billing_item_category($category_id)
	{
		$query="SELECT * FROM `rc_billing_item_category` WHERE category_id = '".$category_id."'" ;
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function billing_item_category_id($category_id)
	{
		$query="SELECT category_id FROM `rc_billing_item_category` WHERE category_id = '".$category_id."' ";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		print_r($result);
		return $result;
	}

	function insert_new_item_category($user_id) {
		$query="INSERT INTO `rc_billing_item_category` 
		(
			`category_description`
		)

		VALUES(
			'".$this->category_description."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$code_id=$db->lastInsertId();
		return $code_id;
	}

	function update_item_category($category_id){
		
		$query= "UPDATE `rc_billing_item_category` SET 
		
		`category_description` = '".$this->category_description."'
		
		WHERE `category_id`='".$category_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_item_category($category_id)
	{
		$db=new Database();
		$query="DELETE FROM `rc_billing_item_category` WHERE `category_id`='".$category_id."'";
		$db->query($query);
		$db->execute();
	}
}
?>