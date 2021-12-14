<?php
class interview_template 
{
	public $table_name="emp_interview_template";
	public $template_id;
	public $template_name;
	public $template_description;
	public $template_user_created;
	public $template_date_created;
	
	function __Construct($template_id=NULL)
	{
		if(isset($template_id))
		{
			$this->template_id=$template_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `template_id`=:template_id";
		$db->query($query);
		$db->bind("template_id",$this->template_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_templates () {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function template_per_interview($template_id_FK){
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE template_id ='".$template_id_FK."'";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>