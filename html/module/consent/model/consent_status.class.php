<?php

class consent_status
{
	public $table_name="consent_status";
	public $consent_status_id;
	public $consent_status_name;
	public $consent_status_description;
	
	function __Construct($consent_status_id=NULL)
	{
		if(isset($consent_status_id))
		{
			$this->consent_status_id=$consent_status_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `consent_status_id`=:consent_status_id";
		$db->query($query);
		$db->bind("consent_status_id",$this->consent_status_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_status($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."`";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_this_status($consent_status_id)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE consent_status_id='".$consent_status_id."'";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}
}
?>