<?php
class marital_status
{
	public $table_name="setup_marital_status";
	public $marital_status_id;
	public $marital_status_title;
	
	function __Construct($country_id=NULL)
	{
		if(isset($country_id))
		{
			$this->country_id=$country_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `marital_status_id`=:marital_status_id";
		$db->query($query);
		$db->bind("marital_status_id",$this->marital_status_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_marital_status () {
		$db		=new Database();
		$query="SELECT * FROM `setup_marital_status` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>