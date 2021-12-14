<?php

class consent_request_pending
{
	public $table_name="consent_request_pending";
	public $pending_id;
	public $consent_id_FK;
	public $user_id_FK;
	public $pending_date;
	public $pending_status;
	
	function __Construct($pending_id=NULL)
	{
		if(isset($pending_id))
		{
			$this->pending_id=$pending_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `pending_id`=:pending_id";
		$db->query($query);
		$db->bind("pending_id",$this->pending_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_consent_request_pending($user_session=NULL)
	{
		$query="SELECT * FROM `consent_request_pending` 

		INNER JOIN `consent_request` ON `consent_request`.`consent_request_id` = `consent_request_pending`.`request_id_FK`
		WHERE `pending_status`= 0";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function list_of_consent_signed_pending($user_session=NULL)
	{
		$query="SELECT * FROM `consent_request_pending` 
		INNER JOIN `consent_request` ON `consent_request`.`consent_request_id` = `consent_request_pending`.`request_id_FK`
		WHERE `pending_status`=1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
}
?>