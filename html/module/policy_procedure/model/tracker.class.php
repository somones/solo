<?php

class policy_tracker
{
	public $table_name="pp_policy_action_log";
	public $tracker_id;
	public $policy_id_FK;
	public $action_id_FK;
	public $tracker_comment;
	public $user_id_FK;
	public $date_time_inserted;	
	
	
	function __Construct($tracker_id=NULL)
	{
		if(isset($tracker_id))
		{
			$this->tracker_id=$tracker_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		//INNER JOIN `pp_policy_pending_actions` ON `pp_policy_pending_actions`.`tracker_id_FK`=`".$this->table_name."`.`tracker_id`
	    //INNER JOIN `setup_employee`  ON `setup_employee`.`employee_id`=`pp_policy_pending_actions`.`employee_id_FK`

		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` 
		
		 INNER JOIN `pp_policy_action` ON `pp_policy_action`.`action_id`=`pp_policy_action_log`.`action_id_FK`
		 INNER JOIN `pp_policy_state` ON `pp_policy_state`.`state_id` =`pp_policy_action`.`state_id_FK`
		 WHERE `tracker_id`=:tracker_id";
		 //echo $query;
		$db->query($query);
		$db->bind("tracker_id",$this->tracker_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}	
	
    function get_tracker_state()
	{
		$db=new Database();
		$query="SELECT * FROM `pp_policy_action_log` INNER JOIN `pp_policy_action` ON `pp_policy_action`.`action_id`=`pp_policy_action_log`.`action_id_FK` WHERE `tracker_id`='".$this->tracker_id."'";
		$db->query($query);
		return $db->resultset();
	}
	
	function get_pending_details()
	{
		$db=new Database();
		$query=" SELECT * FROM `pp_policy_pending_actions` 
		INNER JOIN `setup_employee`  ON `setup_employee`.`employee_id`=`pp_policy_pending_actions`.`employee_id_FK` 
		WHERE `tracker_id_FK`='".$this->tracker_id."'";
		$db->query($query);
		return $db->resultset();
		
	}
	
}

?>

