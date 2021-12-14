<?php

class policy_state
{
	public $table_name="pp_policy_state";
	public $state_id;
	public $state_title;
	public $read_only;
	
	
	
	function __Construct($state_id=NULL)
	{
		if(isset($state_id))
		{
			$this->state_id=$state_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `state_id`=:state_id";
		$db->query($query);
		$db->bind("state_id",$this->state_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}	
	
	function get_active_states()
	{
		$db=new Database();
		$query="SELECT * FROM `".$this->table_name."` ";
		$db->query($query);
		return $db->resultset();
		
	}
	
	function get_state_actions()
	{
		$db=new Database();
		$query="SELECT * FROM `pp_policy_state_has_allowed_action` INNER JOIN  `pp_policy_action` ON `action_id_FK`=`action_id` 
		WHERE `pp_policy_state_has_allowed_action`.`state_id_FK`='".$this->state_id."'";
		
		$db->query($query);
		return $db->resultset();
	}
	
	function get_action_attributes($action_id)
	{
		$db=new Database();
		$query="SELECT * FROM `pp_policy_action`  WHERE `action_id`='".$action_id."'";
		
		$db->query($query);
		return $db->resultset();		
	}
	
}

?>

