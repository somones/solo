<?php
class applicant 
{
	public $table_name="module_applicant";
	public $applicant_id;
	public $application_ref_number;
	public $applicant_title__id_FK;
	public $applicant_first_name;
	public $applicant_last_name;
	public $applicant_suffix;
	public $applicant_email;
	public $applicant_phone_number;
	public $applicant_nationality_id_FK;
	public $applicant_citizen_id_FK;
	public $applicant_marital_status_FK;
	public $applicant_residency_FK;
	public $applicant_visa_type_FK;
	public $applicant_current_employment_status;
	public $applicant_current_employment_poistion;
	public $applicant_current_employer_text;
	public $applicant_applying_position_id_FK;
	public $applicant_availibility_FK;
	public $applicant_profession_FK;
	public $applicant_speciality;
	public $applicant_education_level_FK;
	public $applicant_institution_name;
	public $applicant_board_certified_id_FK;
	public $applicant_hold_haad_license;
	public $applicant_hold_dha_license;
	public $applicant_contact_reference;
	public $applicant_available_start_date;
	public $applicant_cv_id_FK;
	public $date_created;
	public $source_id_FK;
	public $user_id_FK;
	
	function __Construct($applicant_id=NULL)
	{
		if(isset($applicant_id))
		{
			$this->applicant_id=$applicant_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `applicant_id`=:applicant_id";
		$db->query($query);
		$db->bind("applicant_id",$this->applicant_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;		
	}

	function list_applicants($user_session=NULL) {
		$db		=new Database();
		$query="SELECT * FROM `module_applicant` ";
		$db->query($query);
	 	$result = $db->resultset();
	 	return $result;
	}

	function liste_applicants_inner($applicant_id){
		$db		=new Database();
		$query="SELECT * FROM
		module_applicant
		INNER JOIN setup_profession ON setup_profession.profession_id = module_applicant.applicant_profession_FK
		INNER JOIN setup_availability_type ON setup_availability_type.availability_type_id = module_applicant.applicant_availibility_FK 
		INNER JOIN applicant_source ON applicant_source.source_id = module_applicant.source_id_FK
		WHERE  module_applicant.applicant_id = '".$applicant_id."'";
		$db->query($query);
	 	$result = $db->single();
	 	return $result;
	}

	function other_visa_type($visa_type) {
		$query_type = "INSERT INTO `setup_visa_type` 
			(
				`type_title`,
				`type_description`,
				`exist_tag`,
				`display_to_all`
			) 
			VALUES
			(
				'".$visa_type."','To be updated','1','0' 
			)";

			$db = new Database();
			$db->query($query_type);
			$db->execute();
			$type_id=$db->lastInsertId();
			return $type_id;
	}

	function other_setup_position($position) {
		$query_type = "INSERT INTO `setup_position` 
			(
				`position_title`,
				`position_description`,
				`position_exist_tag`,
				`position_display_to_all`
			) 
			VALUES
			(
				'".$position."','To be updated','1','0' 
			)";

			$db = new Database();
			$db->query($query_type);
			$db->execute();
			$o_position_id=$db->lastInsertId();
			return $o_position_id;
	}

	function other_profession($profession) {
		$query_type = "INSERT INTO `setup_profession` 
			(
				`profession_title`,
				`profession_description`,
				`profession_exist_tag`,
				`profession_display_to_all`
			) 
			VALUES
			(
				'".$profession."','To be updated','1','0' 
			)";

			$db = new Database();
			$db->query($query_type);
			$db->execute();
			$o_profession_id=$db->lastInsertId();
			return $o_profession_id;
	}

	function other_board_certificate($certificate) {
		$query_type = "INSERT INTO `setup_board_certified` 
			(
				`board_name`,
				`board_exist_tag`,
				`display_to_all`
			) 
			VALUES
			(
				'".$certificate."','1','0' 
			)";

			$db = new Database();
			$db->query($query_type);
			$db->execute();
			$o_board_id=$db->lastInsertId();
			return $o_board_id;
	}

	function insert_new_applicant($array,$user_id) {
		$db = new Database();
		

		if ($array["other_visa_type"]!=NULL){
			$o_visa = $this->other_visa_type($array["other_visa_type"]);
		} else {
			$o_visa = $array["applicant_visa_type_FK"];
		} 
		if ($array["other_position"]!=NULL){
			$o_position = $this->other_setup_position($array["other_position"]);
		} else {
			$o_position = $array["applicant_applying_position_id_FK"];
		} 

		if ($array["other_profession"]!=NULL){
			$o_profession = $this->other_profession($array["other_profession"]);
		} else {
			$o_profession = $array["applicant_profession_FK"];
		}  
		if ($array["other_board"]!=NULL){
			$o_board = $this->other_board_certificate($array["other_board"]);
		} else {
			$o_board = $array["applicant_board_certified_id_FK"];
		} 

		$query = "INSERT INTO `module_applicant` 
		(
			`applicant_title__id_FK`,
			`applicant_first_name`,
			`applicant_last_name`,
			`applicant_suffix`,
			`applicant_email`,
			`applicant_phone_number`,
			`applicant_nationality_id_FK`,
			`applicant_citizen_id_FK`,
			`applicant_marital_status_FK`,
			`applicant_residency_FK`,
			`applicant_visa_type_FK`,
			`applicant_current_employment_status`,
			`applicant_current_employment_poistion`,
			`applicant_current_employer_text`,
			`applicant_applying_position_id_FK`,
			`applicant_availibility_FK`,
			`applicant_profession_FK`,
			`applicant_speciality`,
			`applicant_education_level_FK`,
			`applicant_institution_name`,
			`applicant_board_certified_id_FK`,
			`applicant_hold_haad_license`,
			`applicant_hold_dha_license`,
			`applicant_contact_reference`,
			`applicant_available_start_date`,
			`applicant_cv_id_FK`,
			`date_created`,
			`source_id_FK`,
			`user_id_FK`
		) 
		VALUES
		(
			'".$array["applicant_title__id_FK"]."',
			'".$array["applicant_first_name"]."',
			'".$array["applicant_last_name"]."',
			'".$array["applicant_suffix"]."',
			'".$array["applicant_email"]."', 
			'".$array["applicant_phone_number"]."',
			'".$array["applicant_nationality_id_FK"]."',
			'".$array["applicant_citizen_id_FK"]."',
			'".$array["applicant_marital_status_FK"]."',
			'".$array["applicant_residency_FK"]."',
			'".$o_visa."',
			'".$array["applicant_current_employment_status"]."',
			'".$o_position."',
			'".$array["applicant_current_employer_text"]."',
			'".$array["applicant_applying_position_id_FK"]."',
			'".$array["applicant_availibility_FK"]."',
			'".$o_profession."',
			'".$array["applicant_speciality"]."',
			'".$array["applicant_education_level_FK"]."',
			'".$array["applicant_institution_name"]."',
			'".$o_board."',
			'".$array["applicant_hold_haad_license"]."',
			'".$array["applicant_hold_dha_license"]."',
			'".$array["applicant_contact_reference"]."',
			'".$array["applicant_available_start_date"]."',
			'".$array["applicant_cv_id_FK"]."',
			'".Date("Y-m-d H:i:s")."',
			'1',
			'".$user_id."'
		)";


		
		
		$db->query($query);
		$db->execute();
		$applicant_id=$db->lastInsertId();
		
		$request_ref_number = sprintf('%04d',$applicant_id);
		$ref= "APPFK".$request_ref_number;
		$query= "UPDATE `module_applicant` SET 
		`application_ref_number` = '".$ref."' WHERE applicant_id = '".$applicant_id."'";
		$db->query($query);
		$db->execute();
		
		return $applicant_id;
	}

	function update_applicant($array,$user_id){
		//print_r($_POST);
		$db=new Database();

		$query= "UPDATE `module_applicant` SET 
		`applicant_title__id_FK` = '".$array["applicant_title__id_FK"]."',
		`applicant_first_name` = '".$array["applicant_first_name"]."',
		`applicant_last_name` = '".$array["applicant_last_name"]."',
		`applicant_suffix` = '".$array["applicant_suffix"]."',
		`applicant_email` = '".$array["applicant_email"]."',
		`applicant_phone_number` = '".$array["applicant_phone_number"]."',
		`applicant_nationality_id_FK` = '".$array["applicant_nationality_id_FK"]."',
		`applicant_citizen_id_FK` = '".$array["applicant_citizen_id_FK"]."',
		`applicant_marital_status_FK` = '".$array["applicant_marital_status_FK"]."',
		`applicant_residency_FK` = '".$array["applicant_residency_FK"]."',
		`applicant_visa_type_FK` = '".$array["applicant_visa_type_FK"]."',
		`applicant_current_employment_status` = '".$array["applicant_current_employment_status"]."',
		`applicant_current_employment_poistion` = '".$array["applicant_current_employment_poistion"]."',
		`applicant_current_employer_text` = '".$array["applicant_current_employer_text"]."',
		`applicant_applying_position_id_FK` = '".$array["applicant_applying_position_id_FK"]."',
		`applicant_availibility_FK` = '".$array["applicant_availibility_FK"]."',
		`applicant_profession_FK` = '".$array["applicant_profession_FK"]."',
		`applicant_speciality` = '".$array["applicant_speciality"]."',
		`applicant_education_level_FK` = '".$array["applicant_education_level_FK"]."',
		`applicant_institution_name` = '".$array["applicant_institution_name"]."',
		`applicant_board_certified_id_FK` = '".$array["applicant_board_certified_id_FK"]."',
		`applicant_hold_haad_license` = '".$array["applicant_hold_haad_license"]."',
		`applicant_hold_dha_license` = '".$array["applicant_hold_dha_license"]."',
		`applicant_contact_reference` = '".$array["applicant_contact_reference"]."',
		`applicant_available_start_date` = '".$array["applicant_available_start_date"]."',
		`applicant_cv_id_FK` = '".$array["applicant_cv_id_FK"]."' 
		WHERE `applicant_id`='".$array["applicant_id"]."'";
		
		$db->query($query);
		$db->execute();
		$applicant_id=$db->lastInsertId();
		return $applicant_id;
	}

	function delete_applicant($applicant_id) {
		$db= new Database();
		
		$query="DELETE FROM `module_applicant` WHERE `applicant_id`='".$applicant_id."'";
		$db->query($query);
		$db->execute();
	}

	function list_opning_flow() 
	{
		$db= new Database();
		$query = "SELECT * FROM setup_emp_request_has_opening
INNER JOIN setup_employment_request ON setup_employment_request.request_id = setup_emp_request_has_opening.request_id_FK
INNER JOIN setup_emp_job_opening ON setup_emp_job_opening.opening_id = setup_emp_request_has_opening.opening_id_FK 
WHERE active_status = 1
AND `app_flow_id` not in (SELECT `flow_id_FK` FROM `emp_app_flow_has_applicant` WHERE `applicant_id_FK`='".$this->applicant_id."')";

		$db->query($query);
	 	$result = $db->resultset();
	 	return $result;
	}

	function list_opning_interview() 
	{
		$db= new Database();
		$query = "SELECT * FROM setup_emp_request_has_opening
INNER JOIN setup_employment_request ON setup_employment_request.request_id = setup_emp_request_has_opening.request_id_FK
INNER JOIN setup_emp_job_opening ON setup_emp_job_opening.opening_id = setup_emp_request_has_opening.opening_id_FK 
WHERE active_status = 1 ";

		$db->query($query);
	 	$result = $db->resultset();
	 	return $result;
	}

	function insert_opening_flow ($array,$user_id) {
		$db = new Database();
		//$query="DELETE FROM `emp_app_flow_has_applicant` WHERE `applicant_id_FK`='".$array["applicant_id"]."'";
		//$db->query($query);
		//$db->execute();
		
		$values = explode(",", $array['opening_id_FK']);
		for ($i=0; $i < count($values); $i++) { 
			$query = "INSERT INTO `emp_app_flow_has_applicant` 
			(
				`applicant_id_FK`,
				`flow_id_FK`,
				`assignment_notes`,
				`date_assigned`,
				`user_assigned`
			) 
			VALUES
			(
				'".$array["applicant_id"]."',
				'".$values[$i]."',
				'".$array["opening_description"]."',
				'".Date("Y-m-d H:i:s")."',
				'".$user_id."'
			)";
			
			$db->query($query);
			$db->execute();
			$flow_id=$db->lastInsertId();
			//return $flow_id;
		}
	}

	function nb_applicants_per_flow($app_flow_id){
		$db = new Database();
		$query = "SELECT * FROM emp_app_flow_has_applicant WHERE flow_id_FK = '".$app_flow_id."'";
		$db->query($query);
		$db->execute();
		$db->resultset();

		return count($db->resultset());
	}


	function applicants_per_flow($flow_id) {
		$db = new Database();

		$query = "SELECT * FROM emp_app_flow_has_applicant
INNER JOIN module_applicant ON module_applicant.applicant_id = emp_app_flow_has_applicant.applicant_id_FK WHERE flow_id_FK = '".$flow_id."'";

		$db->query($query);
	 	$result = $db->resultset();
	 	return $result;
	}

	function flow_applicant_details($applicant_id){
		$db		=new Database();
		$query="SELECT * FROM `module_applicant` WHERE applicant_id = '".$applicant_id."'";
		$db->query($query);
	 	$result = $db->resultset();
	 	return $result;
	}

	function assign_new_file($file_id){
		$db=new Database();
		$query="UPDATE  `module_applicant` SET `applicant_cv_id_FK`='".$file_id."' WHERE `applicant_id`='".$this->applicant_id."' ";
		$db->query($query);
		$db->execute();
	}

	function get_applicant_file($file_id){
		$db=new Database();
		$query="SELECT * FROM `setup_uploads` WHERE `upload_id` = '".$file_id."'";
		$db->query($query);
	 	$result = $db->resultset();
	 	return $result;
	}
}
?>