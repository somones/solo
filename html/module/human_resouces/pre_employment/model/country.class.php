<?php
class country 
{
	public $table_name="setup_country";
	public $country_id;
	public $country_code;
	public $country_name;
	
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
		$query	="SELECT * FROM `".$this->table_name."` WHERE `country_id`=:country_id";
		$db->query($query);
		$db->bind("country_id",$this->country_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_countries () {
		$db		=new Database();
		$query="SELECT * FROM `setup_country` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>