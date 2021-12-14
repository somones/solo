<?php

class consent
{
	public $table_name="consent_setup";
	public $consent_id;
	public $consent_title;
	public $consent_description;
	public $admin_signature_required;
	public $patient_signature_required;
	public $doctor_signature_required;
	public $category_id_FK;
	public $consent_active;
	
	function __Construct($consent_id=NULL)
	{
		if(isset($consent_id))
		{
			$this->consent_id=$consent_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `consent_id`=:consent_id";
		$db->query($query);
		$db->bind("consent_id",$this->consent_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_consent($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE consent_active=1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_this_consent($consent_id_FK)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE consent_id='".$consent_id_FK."'";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function get_this_consentObj($consent_id_FK)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE consent_id='".$consent_id_FK."'";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function get_consent_category($consent_id)
	{
		$query="SELECT * FROM `consent_category` WHERE consent_category_id='".$consent_id."'";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function insert_new_consent($user_id) {

		$query="INSERT INTO `".$this->table_name."` 
		(
			`consent_title`,
			`consent_description`,
			`admin_signature_required`,
			`patient_signature_required`,
			`doctor_signature_required`,
			`category_id_FK`,
			`consent_active`
		)

		VALUES(
			'".$this->consent_title."',
			'".$this->consent_description."',
			'".$this->admin_signature_required."',
			'".$this->patient_signature_required."',
			'".$this->doctor_signature_required."',
			'".$this->category_id_FK."',
			'1'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function insert_new_param() {

		$query="INSERT INTO `consent_signature_param` 
		(
			`consent_id_FK`,
			`param_x`,
			`pram_y`,
			`param_w`,
			`param_page`,
			`admin_x`,
			`admin_y`,
			`admin_w`,
			`admin_page`,
			`pat_x`,
			`pat_y`,
			`pat_w`,
			`pat_page`,
			`doc_x`,
			`doc_y`,
			`doc_w`,
			`doc_page`
		)

		VALUES(
			'".$this->consent_id."',
			'".$this->consent_description."',
			'".$this->admin_signature_required."',
			'".$this->patient_signature_required."',
			'".$this->doctor_signature_required."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_consent($consent_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		`consent_title` = '".$this->consent_title."', 
		`consent_description` = '".$this->consent_description."',
		`admin_signature_required` = '".$this->admin_signature_required."',
		`patient_signature_required` = '".$this->patient_signature_required."',
		`doctor_signature_required` = '".$this->doctor_signature_required."',
		`category_id_FK` = '".$this->category_id_FK."',

		`admin_x` = '".$this->admin_x."',
		`admin_y` = '".$this->admin_y."',
		`admin_w` = '".$this->admin_w."',
		`admin_page` = '".$this->admin_page."',
		`pat_x` = '".$this->pat_x."',
		`pat_y` = '".$this->pat_y."',
		`pat_w` = '".$this->pat_w."',
		`pat_page` = '".$this->pat_page."',
		`doc_x` = '".$this->doc_x."',
		`doc_y` = '".$this->doc_y."',
		`doc_w` = '".$this->doc_w."',
		`doc_page` = '".$this->doc_page."'
		
		WHERE `consent_id`='".$consent_id."' ";
		
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_consent($consent_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `consent_id`='".$consent_id."'";
		$db->query($query);
		$db->execute();
	}

	function get_doctor_request($user_id)
	{	
		$db=new Database();
		
		$query="SELECT * FROM `consent_request_has_doctor` 
		INNER JOIN `consent_request` ON `consent_request`.`consent_request_id` = `consent_request_has_doctor`.`request_id_FK`
		INNER JOIN `consent_doctor` ON `consent_doctor`.`doctor_id` = `consent_request_has_doctor`.`doctor_id_FK`
		WHERE `doctor_id_FK`='".$user_id."' ";
		
		$db->query($query);
		$result=$db->resultset();
		
		return $result;
	}

	function get_admin_request($user_id)
	{	
		$db=new Database();
		
		$query="SELECT * FROM `consent_request_has_admin` 
		INNER JOIN `consent_request` ON `consent_request`.`consent_request_id` = `consent_request_has_admin`.`request_id_FK`
		INNER JOIN `setup_employee` ON `setup_employee`.`employee_id` = `consent_request_has_admin`.`employee_id_FK`
		WHERE `employee_id_FK`='".$user_id."' ";
		
		$db->query($query);
		$result=$db->resultset();
		
		return $result;
	}

	function get_consent_branch($consent_id)
	{
		$array_single=array();
		
		$db=new Database();
		
		$query="SELECT * FROM `consent_branch_has_consent` 
		INNER JOIN `setup_company_branch` ON `setup_company_branch`.`branch_id` = `consent_branch_has_consent`.`branch_id_FK` WHERE `consent_id_FK`='".$consent_id."'";
		
		$db->query($query);
		$result=$db->resultset();
		
		for($i=0;$i<count($result);$i++)
		{
			array_push($array_single,$result[$i]["branch_id"]);
		}
		return $array_single;
	}

	function add_consent_branch($consent_id,$branch_id_FK)
	{
		$query="INSERT INTO `consent_branch_has_consent` 
		(
			`consent_id_FK`,
			`branch_id_FK`
		) 
		VALUES(
			'".$consent_id."',
			'".$branch_id_FK."'
		)";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function remove_all_branch($consent_id)
	{
		$db=new Database();
		$query="DELETE FROM `consent_branch_has_consent` WHERE `consent_id_FK`='".$consent_id."'";
		$db->query($query);
		$db->execute();
	}

	function new_concent_stepes($consent_id) {
		$query="INSERT INTO `consent_has_stepes` 
		(
			`consent_id_FK`,
			`consent_group_id_FK`,
			`user_stepe`,
			`stepe_title`
		)

		VALUES(
			'".$consent_id."',
			'".$this->consent_group_id_FK."',
			'".$this->user_stepe."',
			'".$this->stepe_title."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}


	function remove_all_stepes($consent_id)
	{
		$db=new Database();
		$query="DELETE FROM `consent_has_stepes` WHERE `consent_id_FK`='".$consent_id."'";
		$db->query($query);
		$db->execute();
	}

	function get_consent_stepes($consent_id)
	{
		$array_single=array();
		
		$db=new Database();
		
		$query="SELECT * FROM `consent_has_stepes` 
		INNER JOIN `setup_company_branch` ON `setup_company_branch`.`branch_id` = `consent_branch_has_consent`.`branch_id_FK` WHERE `consent_id_FK`='".$consent_id."'";
		
		$db->query($query);
		$result=$db->resultset();
		
		for($i=0;$i<count($result);$i++)
		{
			array_push($array_single,$result[$i]["branch_id"]);
		}
		return $array_single;
	}
	
}
?>