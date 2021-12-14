<?php

class role
{
	public $table_name="setup_user_role";
	public $role_id;
	public $role_name;
	public $role_description;
	
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

	function list_role($user_session=NULL)
	{
		$query="SELECT * FROM `setup_user_role`";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_role($user_id)
	{
		$query="INSERT INTO `".$this->table_name."` 
		(`role_name`,`role_description`) 
		VALUES('".$this->role_name."','".$this->role_description."')";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$role_id=$db->lastInsertId();
		return $role_id;
	}

	function update_the_role($user_id){
		$query= "UPDATE `setup_user_role` 
		SET 
		`role_name` = '".$this->role_name."', 
		`role_description` = '".$this->role_description."' 
		WHERE `role_id`='".$this->role_id."'";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_role()
	{
		$db=new Database();
		$query="DELETE FROM `setup_user_role` WHERE `role_id`='".$this->role_id."'";
		$db->query($query);
		$db->execute();
	}
	
	function remove_all_permissions()
	{
		$db=new Database();
		$query="DELETE FROM `setup_role_previlige` WHERE `role_id_FK`='".$this->role_id."'";
		$db->query($query);
		$db->execute();
	}
	
	function assign_permission_to_role($array)
	{
		$db=new Database();
		if(strlen($array)>0)
		{
			$values=explode(",",$array);
			for($i=0;$i<count($values);$i++)
			{
				$query="INSERT INTO `setup_role_previlige` (`role_id_FK`,`menu_item_id_FK`) VALUES('".$this->role_id."','".$values[$i]."')";
				$db->query($query);
				$db->execute();
			}
		}
	}
	
	function get_role_menu_items()
	{
		$array=array();
		$db=new Database();
		$query="SELECT * FROM `setup_role_previlige` WHERE `role_id_FK`='".$this->role_id."'";
		$db->query($query);
		$result=$db->resultset();
		for($i=0;$i<count($result);$i++)
		{
			array_push($array,$result[$i]["menu_item_id_FK"]);
		}
		return $array;
	}
	
	function get_role_assigned_list()
	{
		$array=array();
		$db=new Database();
		$query="SELECT * FROM `setup_employee_has_role` WHERE `role_id_FK`='".$this->role_id."'";
		$db->query($query);
		$result=$db->resultset();
		for($i=0;$i<count($result);$i++)
		{
			array_push($array,$result[$i]["employee_id_FK"]);
		}
		return $array;		
	}
	
	function delete_users_from_role()
	{
		$db=new Database();
		$query="DELETE FROM `setup_employee_has_role` WHERE `role_id_FK`='".$this->role_id."'";
		$db->query($query);
		$db->execute();		
	}
	
	function add_users_to_role($array)
	{
		$db=new Database();
		if(strlen($array)>0)
		{
			$values=explode(",",$array);
			for($i=0;$i<count($values);$i++)
			{
				$query="INSERT INTO `setup_employee_has_role` (`employee_id_FK`,`role_id_FK`) VALUES('".$values[$i]."','".$this->role_id."')";
				$db->query($query);
				$db->execute();
				
			}
		}		
	}
}
?>

