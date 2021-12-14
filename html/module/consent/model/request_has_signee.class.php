<?php

class request_has_signee
{
	public $table_name="consent_request_has_signee";
	public $step_id;
	public $request_id_FK;
	public $user_id_FK;
	public $user_type_id_FK;
	public $signed;
	public $document_id_FK;
	public $signed_doc_id;
	
	function __Construct($step_id=NULL)
	{
		if(isset($step_id))
		{
			$this->step_id=$step_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `step_id`=:step_id";
		$db->query($query);
		$db->bind("step_id",$this->step_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function assign_this_consent_request_to($consent_request_id,$user_type,$user_id,$file_id) {
		$query="INSERT INTO `consent_request_has_signee` 
		(
			`request_id_FK`,
			`user_id_FK`,
			`user_type_id_FK`,
			`signed`,
			`document_id_FK`,
			`signed_doc_id`,
			`consent_partially_signed`
		)
		VALUES(
			'".$consent_request_id."',
			'".$user_id."',
			'".$user_type."',
			'0',
			'".$file_id."',
			'0',
			'0'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();

		$patient_id=$db->lastInsertId();
		return $patient_id;
	}


	function update_this_consent_request($request_id,$employee_id,$file_id,$user_type,$user_id) {
		$query= "UPDATE `consent_request_has_signee` SET `signed` = '1', `toked_by` = '".$user_id."'
		WHERE `request_id_FK`='".$request_id."' AND `user_id_FK`='".$employee_id."' AND `document_id_FK` = '".$file_id."' AND `user_type_id_FK` = '".$user_type."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function update_signed_this_consent_request($request_id,$file_id) {
		$query= "UPDATE `consent_request_has_signee` SET `consent_partially_signed` = '1'
		WHERE `request_id_FK`='".$request_id."' AND `document_id_FK` = '".$file_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function get_user_request($user_id) {
		
		$db=new Database();
		$query="SELECT DISTINCT * FROM `consent_request_has_signee`
		INNER JOIN `consent_request` ON `consent_request`.`consent_request_id` = `request_id_FK`
		WHERE `user_type_id_FK` = 2 ORDER BY `consent_request_has_signee`.`step_id` ASC";
		
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_list_request() {
		
		$db=new Database();
		$query="SELECT * FROM `consent_request_has_signee`
		INNER JOIN `consent_request` ON `consent_request`.`consent_request_id` = `request_id_FK` ";
		
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_doc_request() {
		
		$db=new Database();
		$query="SELECT * FROM `consent_request_has_signee`
		INNER JOIN `consent_request` ON `consent_request`.`consent_request_id` = `request_id_FK`
		WHERE `user_type_id_FK` = 2";
		
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_consent_file($file_id){
		$db=new Database();
		$query="SELECT * FROM `consent_signed_file` WHERE `consent_signed_id` = '".$file_id."'";
		$db->query($query);
	 	$result = $db->resultset();
	 	return $result;
	}

	function get_this_patient($patient_id,$request_id) {
		
		$db=new Database();
		$query="SELECT * FROM `consent_request_has_signee`
		INNER JOIN `consent_request` ON `consent_request`.`consent_request_id` = `request_id_FK`
		WHERE `step_id`='".$patient_id."' AND `request_id_FK` = '".$request_id."' ";
		
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function get_consent_patient($user_type_id_FK,$request_id_FK) {
		
		$db=new Database();
		$query="SELECT * FROM `consent_request_has_signee` WHERE `user_type_id_FK` = '".$user_type_id_FK."'  AND `request_id_FK` = '".$request_id_FK."'";
		
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function get_consent_doctor($patient_id) {
		
		$db=new Database();
		$query="SELECT * FROM `consent_request_has_signee` WHERE `user_type_id_FK` = '".$user_type_id_FK."' ";
		
		$db->query($query);
		$result=$db->single();
		return $result;
	}
}
?>