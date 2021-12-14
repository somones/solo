<?php
class visa_type
{
	public $table_name="setup_visa_type";
	public $type_id;
	public $type_title;
	public $type_description;
	public $exist_tag;
	public $display_to_all;
	
	function __Construct($type_id=NULL)
	{
		if(isset($type_id))
		{
			$this->type_id=$type_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `type_id`=:type_id";
		$db->query($query);
		$db->bind("type_id",$this->type_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_visa () {
		$db		=new Database();
		$query="SELECT * FROM `setup_visa_type` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_employment_visa($visa_type_id){
		$db		=new Database();
		$query="SELECT * FROM `setup_visa_type` WHERE type_id = '".$visa_type_id."'";
		$db->query($query);
	 	$result=$db->single();
	 	return $result;
	}

}
?>