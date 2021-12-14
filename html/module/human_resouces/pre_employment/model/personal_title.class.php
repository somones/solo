<?php
class title
{
	public $table_name="setup_personal_title";
	public $personal_id;
	public $personal_title;
	public $personal_description;
	
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
		$query	="SELECT * FROM `".$this->table_name."` WHERE `personal_id`=:personal_id";
		$db->query($query);
		$db->bind("personal_id",$this->personal_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_titles () {
		$db		=new Database();
		$query="SELECT * FROM `setup_personal_title` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>