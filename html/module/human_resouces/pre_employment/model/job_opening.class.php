<?php
class emp_job_opening
{
	public $table_name="setup_emp_job_opening";
	public $opening_id;
	public $opening_title;
	public $opening_description;
	
	function __Construct($opening_id=NULL)
	{
		if(isset($opening_id))
		{
			$this->opening_id=$opening_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `opening_id`=:opening_id";
		$db->query($query);
		$db->bind("opening_id",$this->opening_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_job_opning () {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}
}
?>