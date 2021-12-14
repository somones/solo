<?php
class position 
{
	public $table_name="setup_position";
	public $position_id;
	public $position_title;
	public $position_description;
	public $position_exist_tag;
	public $position_display_to_all;
	
	function __Construct($position_id=NULL)
	{
		if(isset($position_id))
		{
			$this->position_id=$position_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `position_id`=:position_id";
		$db->query($query);
		$db->bind("position_id",$this->position_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_positions () {
		$db		=new Database();
		$query="SELECT * FROM `setup_position` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>