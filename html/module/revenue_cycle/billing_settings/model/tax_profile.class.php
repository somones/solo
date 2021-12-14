<?php

class tax_profile
{
	public $table_name="rc_tax_profile";
	public $profile_id;
	public $profile_name;
	public $profile_tra;
	public $profile_active;

	function __Construct($profile_id=NULL)
	{
		if(isset($profile_id))
		{
			$this->profile_id=$profile_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `profile_id`=:profile_id";
		$db->query($query);
		$db->bind("profile_id",$this->profile_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_tax_profile($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."`";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function billing_item_profile($tax_profile_id_FK)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE profile_id = '".$tax_profile_id_FK."'";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
}
?>