<?php

class modules
{
	public $table_name="setup_modules";
	public $module_id;
	public $module_name;
	public $module_base_url;
	public $module_url;
	public $path_to_assets;
	public $display_order;
	public $active_state;
	
	function __Construct($module_id=NULL)
	{
		if(isset($module_id))
		{
			$this->module_id=$module_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `module_id`=:module_id";
		$db->query($query);
		$db->bind("module_id",$this->module_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_modules($user_session=NULL)
	{
		$query="SELECT * FROM `setup_modules` WHERE active_state = 1";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_module($user_id)
	{
		$query="INSERT INTO `".$this->table_name."` 
		(
			`module_name`,
			`module_base_url`,
			`module_url`,
			`path_to_assets`,
			`active_state`
		) 
		VALUES 
		(
			'".$this->module_name."',
			'/',
			'".$this->module_url."',
			'../../../',
			'1'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$module_id=$db->lastInsertId();
		return $module_id;
	}

	function update_the_module($module_id) {
		$query= "UPDATE `setup_modules` SET 
		`module_name` = '".$this->module_name."', 
		`module_url` = '".$this->module_url."' 
		WHERE `module_id`='".$module_id."'";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_module($module_id)
	{
		$db=new Database();
		$query="DELETE FROM `setup_modules` WHERE `module_id`='".$module_id."'";
		$db->query($query);
		$db->execute();
	}

	function get_category_module($module_category_id)
	{
		$query="SELECT * FROM `setup_modules` WHERE module_id = '".$module_category_id."'";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
}
?>

