<?php

class doctor
{
	public $table_name="consent_doctor";
	public $doctor_id;
	public $doctor_title;
	public $doctor_name;
	public $doctor_email;
	public $doctor_phone_number;
	public $doctor_extension;
	public $doctor_hr_number;
	public $doctor_branch_FK;
	public $doctor_departement_FK;
	public $doctor_specialty_FK;
	public $doctor_experience;
	public $doctor_nationality;
	public $doctor_gender;
	public $doctor_active;
	public $user_id_FK;
	
	function __Construct($doctor_id=NULL)
	{
		if(isset($doctor_id))
		{
			$this->doctor_id=$doctor_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `doctor_id`=:doctor_id";
		$db->query($query);
		$db->bind("doctor_id",$this->doctor_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_doctors($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE doctor_active=1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_this_doctors($doctor_id)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE doctor_id='".$doctor_id."'";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function get_linked_doctor($user_id)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE user_id_FK='".$user_id."'";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function list_no_assigned_doctors($request_id)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE doctor_active=1 AND `doctor_id` not in (SELECT `doctor_id_FK` FROM `consent_request_has_doctor` WHERE `request_id_FK`='".$request_id."')";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_doctor($user_id) {

		$query="INSERT INTO `".$this->table_name."` 
		(
			`doctor_title`,
			`doctor_name`,
			`doctor_email`,
			`doctor_phone_number`,
			`doctor_extension`,
			`doctor_hr_number`,
			`doctor_branch_FK`,
			`doctor_departement_FK`,
			`doctor_specialty_FK`,
			`doctor_experience`,
			`doctor_nationality`,
			`doctor_gender`,
			`user_id_FK`,
			`doctor_active`
		)

		VALUES(
			'".$this->doctor_title."',
			'".$this->doctor_name."',
			'".$this->doctor_email."',
			'".$this->doctor_phone_number."',
			'".$this->doctor_extension."',
			'".$this->doctor_hr_number."',
			'".$this->doctor_branch_FK."',
			'".$this->doctor_departement_FK."',
			'".$this->doctor_specialty_FK."',
			'".$this->doctor_experience."',
			'".$this->doctor_nationality."',
			'".$this->doctor_gender."',
			'".$this->user_id_FK."',
			'1'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_doctor($doctor_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		`doctor_title` = '".$this->doctor_title."', 
		`doctor_name` = '".$this->doctor_name."', 
		`doctor_email` = '".$this->doctor_email."',
		`doctor_phone_number` = '".$this->doctor_phone_number."',
		`doctor_extension` = '".$this->doctor_extension."',
		`doctor_hr_number` = '".$this->doctor_hr_number."',
		`doctor_branch_FK` = '".$this->doctor_branch_FK."',
		`doctor_departement_FK` = '".$this->doctor_departement_FK."',
		`doctor_specialty_FK` = '".$this->doctor_specialty_FK."',
		`doctor_experience` = '".$this->doctor_experience."',
		`doctor_nationality` = '".$this->doctor_nationality."',
		`doctor_gender` = '".$this->doctor_gender."',
		`user_id_FK` = '".$this->user_id_FK."'
		
		WHERE `doctor_id`='".$doctor_id."' ";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_doctor($doctor_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `doctor_id`='".$doctor_id."'";
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

	function get_titles_list () {
		$db		=new Database();
		$query="SELECT * FROM `setup_personal_title` ";
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

	function get_doctor_branch($doctor_id)
	{
		$array_single=array();
		
		$db=new Database();
		
		$query="SELECT * FROM `doctor_branch_has_doctor` 
		INNER JOIN `setup_company_branch` ON `setup_company_branch`.`branch_id` = `doctor_branch_has_doctor`.`branch_id_FK` WHERE `doctor_id_FK`='".$doctor_id."'";
		
		$db->query($query);
		$result=$db->resultset();
		
		for($i=0;$i<count($result);$i++)
		{
			array_push($array_single,$result[$i]["branch_id"]);
		}
		return $array_single;
	}

	function add_doctor_branch($doctor_id,$branch_id)
	{
		$query="INSERT INTO `doctor_branch_has_doctor` 
		(
			`doctor_id_FK`,
			`branch_id_FK`
		) 
		VALUES(
			'".$doctor_id."',
			'".$branch_id."'
		)";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function remove_all_branch($doctor_id)
	{
		$db=new Database();
		$query="DELETE FROM `doctor_branch_has_doctor` WHERE `doctor_id_FK`='".$doctor_id."'";
		$db->query($query);
		$db->execute();
	}

}
?>