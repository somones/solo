<?php
class education_level 
{
	public $table_name="setup_education_level";
	public $education_level_id;
	public $education_level_title;
	public $education_description;
	
	function __Construct($education_level_id=NULL)
	{
		if(isset($education_level_id))
		{
			$this->education_level_id=$education_level_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `education_level_id`=:education_level_id";
		$db->query($query);
		$db->bind("education_level_id",$this->education_level_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_education_level () {
		$db		=new Database();
		$query="SELECT * FROM `setup_education_level` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>