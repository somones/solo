<?php

class policy_section
{
	public $table_name="pp_policy_section";
	public $section_id;
	public $section_title;
	public $section_help_tip;
	public $section_date_created;
	public $section_date_updated;
	public $section_active_state;
	
	
	function __Construct($section_id=NULL)
	{
		if(isset($section_id))
		{
			$this->section_id=$section_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `section_id`=:section_id";
		$db->query($query);
		$db->bind("section_id",$this->section_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}	
	
	function get_active_sections()
	{
		$db=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE `section_active_state`='1'";
		$db->query($query);
		return $db->resultset();
		
	}
	
	function get_non_added_sections($policy_id)
	{
		$db=new Database();
		$query="SELECT * FROM `pp_policy_section` WHERE `section_id` not in (SELECT `section_id_FK` FROM `pp_policy_version_content` WHERE `policy_id_FK`='".$policy_id."')";
		$db->query($query);
		return $db->resultset();
	}
	
	function insert_into_pending_actions($array,$user_id,$tracker_id)
	{
		
	}

	function get_sections($user_session=NULL) {
		$db=new Database();
		$query="SELECT * FROM `".$this->table_name."`";
		$db->query($query);
		return $db->resultset();
		
	}


	function insert_new_section($user_id) {
		$query="INSERT INTO `".$this->table_name."` 
		(`section_title`,`section_help_tip`,`section_date_created`) 
		VALUES('".$this->section_title."','".$this->section_help_tip."','".$this->section_date_created."')";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$section_id=$db->lastInsertId();
		return $section_id;
	}

	function update_section($user_id) {
		$query= "UPDATE `pp_policy_section` SET 
		`section_title` = '".$this->section_title."',
		`section_help_tip` = '".$this->section_help_tip."'
		WHERE `section_id`='".$this->section_id."'";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_section() {
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `section_id`='".$this->section_id."'";
		$db->query($query);
		$db->execute();
	}

	function has_section($section_id){
		$query="SELECT * FROM `pp_policy_template_has_section` WHERE `section_id_FK`= '".$section_id."' ";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		
		return $result;
	}
}

?>

