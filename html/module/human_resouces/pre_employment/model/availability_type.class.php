<?php
class availability_type
{
	public $table_name="setup_availability_type";
	public $availability_type_id;
	public $availability_type_name;
	
	function __Construct($availability_type_id=NULL)
	{
		if(isset($availability_type_id))
		{
			$this->availability_type_id=$availability_type_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `availability_type_id`=:availability_type_id";
		$db->query($query);
		$db->bind("availability_type_id",$this->availability_type_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_availability_type () {
		$db		=new Database();
		$query="SELECT * FROM `setup_availability_type` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>