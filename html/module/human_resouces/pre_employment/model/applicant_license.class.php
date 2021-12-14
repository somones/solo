<?php
class applicant_license 
{
	public $table_name="applicant_license";
	public $license_id;
	public $license_name;
	public $license_description;
	public $license_active;
	
	function __Construct($license_id=NULL)
	{
		if(isset($license_id))
		{
			$this->license_id=$license_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `license_id`=:license_id";
		$db->query($query);
		$db->bind("license_id",$this->license_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function get_active_license () {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE license_active=1";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_applicant_license ($license_id) {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE  license_id = '".$license_id."'";
		$db->query($query);
	 	$result=$db->single();
	 	return $result;
	}

}
?>