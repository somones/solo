<?php
class profission 
{
	public $table_name="setup_profession";
	public $profession_id;
	public $profession_title;
	public $profession_description;
	public $profession_display_to_all;
	
	function __Construct($profession_id=NULL)
	{
		if(isset($profession_id))
		{
			$this->profession_id=$profession_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `profession_id`=:profession_id";
		$db->query($query);
		$db->bind("profession_id",$this->profession_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_professions () {
		$db		=new Database();
		$query="SELECT * FROM `setup_profession` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_applicant_profission ($applicant_profession_FK) {
		$db		=new Database();
		$query="SELECT * FROM `setup_profession` WHERE profession_id = '".$applicant_profession_FK."'";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>