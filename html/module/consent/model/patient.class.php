<?php

class patient
{
	public $table_name="consent_patients";
	public $patient_id;
	public $patient_designation_FK;
	public $patient_full_name;
	public $patient_adress;
	public $patient_phone_number;
	public $patient_email;
	public $patient_country_FK;
	public $patient_residence_country_FK;
	public $patient_gender_FK;
	public $patient_birth_day;
	public $patient_marital_status_FK;
	public $patient_visa_status_FK;
	public $patient_insurance_FK;
	public $patient_active;
	
	function __Construct($patient_id=NULL)
	{
		if(isset($patient_id))
		{
			$this->patient_id=$patient_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `patient_id`=:patient_id";
		$db->query($query);
		$db->bind("patient_id",$this->patient_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_patients($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE patient_active=1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_this_patient($patient_id)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE patient_id='".$patient_id."'";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function insert_new_patient($user_id) {

		$query="INSERT INTO `".$this->table_name."` 
		(
			`patient_designation_FK`,
			`patient_full_name`,
			`patient_adress`,
			`patient_phone_number`,
			`patient_email`,
			`patient_country_FK`,
			`patient_residence_country_FK`,
			`patient_gender_FK`,
			`patient_birth_day`,
			`patient_marital_status_FK`,
			`patient_visa_status_FK`,
			`patient_insurance_FK`,
			`patient_active`
		)

		VALUES(
			'".$this->patient_designation_FK."',
			'".$this->patient_full_name."',
			'".$this->patient_adress."',
			'".$this->patient_phone_number."',
			'".$this->patient_email."',
			'".$this->patient_country_FK."',
			'".$this->patient_residence_country_FK."',
			'".$this->patient_gender_FK."',
			'".$this->patient_birth_day."',
			'".$this->patient_marital_status_FK."',
			'".$this->patient_visa_status_FK."',
			'".$this->patient_insurance_FK."',
			'1'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_patient($patient_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		
		`patient_designation_FK` = '".$this->patient_designation_FK."', 
		`patient_full_name` = '".$this->patient_full_name."',
		`patient_adress` = '".$this->patient_adress."',
		`patient_phone_number` = '".$this->patient_phone_number."',
		`patient_email` = '".$this->patient_email."',
		`patient_country_FK` = '".$this->patient_country_FK."',
		`patient_residence_country_FK` = '".$this->patient_residence_country_FK."',
		`patient_gender_FK` = '".$this->patient_gender_FK."',
		`patient_birth_day` = '".$this->patient_birth_day."',
		`patient_marital_status_FK` = '".$this->patient_marital_status_FK."',
		`patient_visa_status_FK` = '".$this->patient_visa_status_FK."',
		`patient_insurance_FK` = '".$this->patient_insurance_FK."'
		
		WHERE `patient_id`='".$patient_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_patient($patient_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `patient_id`='".$patient_id."'";
		$db->query($query);
		$db->execute();
	}

	function get_countries_list () {
		$db		=new Database();
		$query="SELECT * FROM `setup_country` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_visa_list () {
		$db		=new Database();
		$query="SELECT * FROM `setup_visa_type` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_titles_list () {
		$db		=new Database();
		$query="SELECT * FROM `setup_personal_title` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_marital_status_list () {
		$db		=new Database();
		$query="SELECT * FROM `setup_marital_status` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_gender_list () {
		$db		=new Database();
		$query="SELECT * FROM `setup_gender` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>