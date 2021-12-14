<?php

class category
{
	public $table_name="template_menu_category";
	public $category_id;
	public $category_name;
	public $module_id_FK;
	public $icon_css;
	public $display_order;
	
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

	function list_menu_category($user_session=NULL)
	{
		$query="SELECT * FROM `template_menu_category`";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_menu_category($user_id)
	{
		$query="INSERT INTO `".$this->table_name."` 
		(
			`category_name`,
			`module_id_FK`,
			`display_order`
		) 
		VALUES 
		(
			'".$this->category_name."',
			'".$this->module_id_FK."',
			'".$this->display_order."'
		)";

		$db=new Database();
		$db->query($query);
		$db->execute();
		$category_id=$db->lastInsertId();
		return $category_id;
	}

	function update_menu_category($category_id) {
		$query= "UPDATE `template_menu_category` SET 
		`category_name` = '".$this->category_name."', 
		`module_id_FK` = '".$this->module_id_FK."',
		`display_order` = '".$this->display_order."'
		WHERE `category_id`='".$category_id."' ";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_menu_category($category_id)
	{
		$db=new Database();
		$query="DELETE FROM `template_menu_category` WHERE `category_id`='".$category_id."'";
		$db->query($query);
		$db->execute();
	}

	function get_item_menu_category($item_menu_category_id)
	{
		$query="SELECT * FROM `template_menu_category` WHERE category_id= '".$item_menu_category_id."'";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
}
?>

