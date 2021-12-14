<?php
class request_group 
{
	public $table_name="setup_emp_request_group";
	public $emp_group_id;
	public $emp_group_name;
	public $emp_group_description;
	public $emp_group_active;
	public $request_date_created;
	public $request_user_id_FK;
	
	function __Construct($emp_group_id=NULL)
	{
		if(isset($emp_group_id))
		{
			$this->emp_group_id=$emp_group_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `emp_group_id`=:emp_group_id";
		$db->query($query);
		$db->bind("emp_group_id",$this->emp_group_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_request_groups () {
		$db		=new Database();
		$query="SELECT * FROM `setup_emp_request_group` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>