<?php

class menu_items
{
	public $table_name="template_menu_item";
	public $item_id;
	public $category_id_FK;
	public $item_title;
	public $page_path;
	public $append_param;
	
	function __Construct($item_id=NULL)
	{
		if(isset($item_id))
		{
			$this->item_id=$item_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `item_id`=:item_id";
		$db->query($query);
		$db->bind("item_id",$this->item_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_menu_item($user_session=NULL)
	{
		$query="SELECT * FROM `template_menu_item` ORDER by item_id ASC";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_menu_item($user_id)
	{
		$query="INSERT INTO `".$this->table_name."` 
		(
			`category_id_FK`,
			`item_title`,
			`page_path`
		) 
		VALUES 
		(
			'".$this->category_id_FK."',
			'".$this->item_title."',
			'".$this->page_path."'
		)";

		$db=new Database();
		$db->query($query);
		$db->execute();
		$item_id=$db->lastInsertId();
		return $item_id;
	}

	function update_menu_item($item_id) {
		$query= "UPDATE `template_menu_item` SET 
		`category_id_FK` = '".$this->category_id_FK."', 
		`item_title` = '".$this->item_title."',
		`page_path` = '".$this->page_path."'
		WHERE `item_id`='".$item_id."'";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_menu_item($item_id)
	{
		$db=new Database();
		$query="DELETE FROM `template_menu_item` WHERE `item_id`='".$item_id."'";
		$db->query($query);
		$db->execute();
	}
}
?>
