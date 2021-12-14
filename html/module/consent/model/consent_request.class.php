<?php
date_default_timezone_set('Asia/Dubai'); 
class consent_request
{
	public $table_name="consent_request";
	public $consent_request_id;
	public $consent_request_title;
	public $patient_file;
	public $consent_request_date_time;
	public $consent_request_active;
	public $status_id_FK;
	public $consent_id_FK;
	public $branch_id_FK;
	
	function __Construct($consent_request_id=NULL)
	{
		if(isset($consent_request_id))
		{
			$this->consent_request_id=$consent_request_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `consent_request_id`=:consent_request_id";
		$db->query($query);
		$db->bind("consent_request_id",$this->consent_request_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_consent_request($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE consent_request_active = 1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function list_of_consent_request_full($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` 
		INNER JOIN `setup_company_branch` ON `setup_company_branch`.`branch_id` = `branch_id_FK`
		INNER JOIN `consent_setup` ON `consent_setup`.`consent_id` = `consent_id_FK`
		INNER JOIN `setup_uploads` ON `setup_uploads`.`upload_id` = `consent_file_id_FK`
		INNER JOIN `consent_status` ON `consent_status`.`consent_status_id` = `status_id_FK`

		WHERE consent_request_active = 1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_signed_file($file_id) {
		$query="SELECT * FROM `consent_signed_file` WHERE consent_signed_id = '".$file_id."' ";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function get_consent_file($file_id){
		$db=new Database();
		$query="SELECT * FROM `setup_uploads` WHERE `upload_id` = '".$file_id."'";
		$db->query($query);
	 	$result = $db->resultset();
	 	return $result;
	}

	function get_consent_pdf($file_id){
		$db=new Database();
		$query="SELECT * FROM `setup_uploads` WHERE `upload_id` = '".$file_id."'";
		$db->query($query);
	 	$result = $db->single();
	 	return $result;
	}

	function insert_new_consent_request($consent_suffix) {
		$patient_file_name = $this->patient_file."-".$consent_suffix."-[".date("Y-m-d")."]";
		//[Patient] [Consent Name] [Y-m-d]

		$query="INSERT INTO `".$this->table_name."` 
		(
			`consent_request_title`,
			`patient_file`,
			`consent_request_date_time`,
			`consent_id_FK`,
			`status_id_FK`,
			`consent_request_active`,
			`branch_id_FK`
		)

		VALUES(

			'".$patient_file_name."',
			'".$this->patient_file."',
			'".date("Y-m-d H:i:s")."',
			'".$this->consent_id_FK."',
			'1',
			'1',
			'".$this->branch_id_FK."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$consent_request_id=$db->lastInsertId();
		return $consent_request_id;
	}

	function update_this_consent_request($consent_request_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 

		`consent_request_title` = '".$this->consent_request_title."', 
		`patient_file` = '".$this->patient_file."',
		`consent_request_date_time` = '".$this->consent_request_date_time."',
		`consent_id_FK` = '".$this->consent_id_FK."'
		
		WHERE `consent_request_id`='".$consent_request_id."' ";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function assign_new_file($file_id,$consent_request_id){
		$db=new Database();
		$query="UPDATE  `".$this->table_name."` SET `consent_file_id_FK`='".$file_id."' WHERE `consent_request_id`='".$consent_request_id."' ";
		$db->query($query);
		$db->execute();
	}

	function get_consent_requiest_file($file_id){
		$db=new Database();
		$query="SELECT * FROM `setup_uploads` WHERE `upload_id` = '".$file_id."'";
		$db->query($query);
	 	$result = $db->resultset();
	 	return $result;
	}

	function assign_this_consent_request_to_the_doctor($consent_request_id) {
		$length = 4;
		$characters = '123456789';
        $randomString = '';
        for ($i=0; $i < $length; $i++) { 
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $suffix_id = "DOC".$randomString;

		$query="INSERT INTO `consent_request_has_doctor` 
		(
			`suffix`,
			`request_id_FK`,
			`doctor_id_FK`,
			`date_time`,
			`request_status`
		)
		VALUES(
			'".$suffix_id."',
			'".$consent_request_id."',
			'".$this->doctor_id."',
			'".date("Y-m-d")."',
			'0'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		return $suffix_id;
	}

	function assign_this_consent_request_to_the_admin($consent_request_id) {
		$length = 4;
		$characters = '123456789';
        $randomString = '';
        for ($i=0; $i < $length; $i++) { 
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $suffix_id = "ADM".$randomString;

		$query="INSERT INTO `consent_request_has_admin` 
		(
			`suffix`,
			`request_id_FK`,
			`employee_id_FK`,
			`date_time`,
			`request_status`
		)
		VALUES(
			'".$suffix_id."',
			'".$consent_request_id."',
			'".$this->admin_id."',
			'".date("Y-m-d")."',
			'0'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();

		$query= "UPDATE `".$this->table_name."` SET 
		`status_id_FK` = '8' WHERE `consent_request_id`='".$consent_request_id."' ";

		$db=new Database();
		$db->query($query);
		$db->execute();
		return $suffix_id;
	}

	function save_the_admin_pending_request($consent_request_id,$user_id,$suffix) {
		$query="INSERT INTO `consent_request_pending` 
		(
			`suffix`,
			`request_id_FK`,
			`user_id_FK`,
			`Profission`,
			`pending_date`,
			`pending_status`
		)
		VALUES(
			'".$suffix."',
			'".$consent_request_id."',
			'".$user_id."',
			'Admin',
			'".date("Y-m-d")."',
			'0'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function save_the_doctor_pending_request($consent_request_id,$user_id,$suffix) {
		$suffix_id = "DOC".$consent_request_id;
		$query="INSERT INTO `consent_request_pending` 
		(
			`suffix`,
			`request_id_FK`,
			`user_id_FK`,
			`Profission`,
			`pending_date`,
			`pending_status`
		)
		VALUES(
			'".$suffix."',
			'".$consent_request_id."',
			'".$user_id."',
			'Doctor',
			'".date("Y-m-d")."',
			'0'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_consent_request($consent_request_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `consent_request_id`='".$consent_request_id."'";
		$db->query($query);
		$db->execute();
	}

	function get_admin_request($user_id) {
		
		$db=new Database();
		$query="SELECT * FROM `consent_request_has_admin`
			INNER JOIN `consent_request` ON `consent_request`.`consent_request_id` = `consent_request_has_admin`.`request_id_FK` 
			INNER JOIN `setup_employee` ON `setup_employee`.`employee_id` = `consent_request_has_admin`.`employee_id_FK` 
			WHERE `employee_id_FK`='".$user_id."'";
		
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}



function update_consent_request_has_admin($request_id,$employee_id,$suffix){
	//print_r($_POST);
	$query= "UPDATE `consent_request_has_admin` SET 
	`request_status` = '1'
	WHERE `request_id_FK`='".$request_id."' AND `employee_id_FK`='".$employee_id."' AND `suffix` = '".$suffix."' ";
	$db=new Database();
	$db->query($query);
	$db->execute();
}

function update_consent_request_has_doctor($request_id,$doctor_id,$suffix){
	//print_r($_POST);
	$query= "UPDATE `consent_request_has_doctor` SET 

	`request_status` = '1'
	
	WHERE `request_id_FK`='".$request_id."' AND `doctor_id_FK`='".$doctor_id."' AND `suffix` = '".$suffix."' ";

	$db=new Database();
	$db->query($query);
	$db->execute();
}

function update_consent_request_pending($request_id,$user_id,$suffix){
	//print_r($_POST);
	$query= "UPDATE `consent_request_pending` SET 

	`pending_status` = '1'
	
	WHERE `request_id_FK`='".$request_id."' AND `user_id_FK`='".$user_id."' AND `suffix` = '".$suffix."' ";

	$db=new Database();
	$db->query($query);
	$db->execute();
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

		WHERE `pending_status`=1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
}
?>