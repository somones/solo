<?php
class employment_request 
{
	public $table_name="setup_employment_request";
	public $request_id;
	public $request_job_title;
	public $request_group_id_FK;
	public $request_description;
	public $request_state_id_FK;
	public $request_date_created;
	public $request_user_id_FK;

	public $branch_id_FK;
	public $gender_id_FK;
	public $request_reason;
	public $request_type_id_FK;
	public $nationality_id_FK;
	public $request_experience;
	
	function __Construct($request_id=NULL)
	{
		if(isset($request_id))
		{
			$this->request_id=$request_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `request_id`=:request_id";
		$db->query($query);
		$db->bind("request_id",$this->request_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_employment_requests () {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE request_state_id_FK <> 5";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function list_of_selected_employment_requests () {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE request_state_id_FK = 5";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function list_of_my_employment_requests ($user_id) {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE `request_user_id_FK`='".$user_id."' ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}


	function list_of_employment_requests_inner($request_id_id){
		$db		=new Database();
		$query="SELECT * FROM
		setup_employment_request
		INNER JOIN setup_employee ON setup_employee.employee_id = setup_employment_request.request_user_id_FK
		INNER JOIN setup_request_state ON setup_request_state.state_id = setup_employment_request.request_state_id_FK

		INNER JOIN setup_emp_request_group ON setup_emp_request_group.emp_group_id = setup_employment_request.request_group_id_FK

		WHERE  setup_employment_request.request_id = '".$request_id_id."'";
		$db->query($query);
	 	$result = $db->single();
	 	return $result;
	}


	function insert_new_request($array,$user_id) {
		//print_r($_POST);
		$query = "INSERT INTO `setup_employment_request` 
		(
			`request_job_title`,
			`request_group_id_FK`,
			`request_description`,
			`request_state_id_FK`,
			`branch_id_FK`,
			`gender_id_FK`,
			`request_reason`,
			`request_type_id_FK`,
			`nationality_id_FK`,
			`request_experience`,
			`request_date_created`,
			`request_user_id_FK`
		) 
		VALUES
		(
			'".$array["request_job_title"]."',
			'".$array["request_group_id_FK"]."',
			'".$array["request_description"]."',
			'1',
			'".$array["branch_id_FK"]."',
			'".$array["gender_id_FK"]."',
			'".$array["request_reason"]."',
			'".$array["request_type_id_FK"]."',
			'".$array["nationality_id_FK"]."',
			'".$array["request_experience"]."',
			'".Date("Y-m-d")."',
			'".$user_id."'
		)";

		$db = new Database();
		$db->query($query);
		$db->execute();
		$request_id=$db->lastInsertId();

		//echo "The Ref number :".$request_id;
		$request_ref_number = sprintf('%04d',$request_id);
		$ref = "RQFK".$request_ref_number;
		$query= "UPDATE `setup_employment_request` SET 
		`request_ref_number` = '".$ref."' WHERE request_id = '".$request_id."'";
		
		$db->query($query);
		$db->execute();
		return $request_id;
	}

	function update_request($array,$user_id){
		//print_r($_POST);
		$db=new Database();

		$query= "UPDATE `setup_employment_request` SET 
		`request_job_title` = '".$array["request_job_title"]."',
		`request_group_id_FK` = '".$array["request_group_id_FK"]."',
		`request_description` = '".$array["request_description"]."',
		`branch_id_FK` = '".$array["branch_id_FK"]."',
		`gender_id_FK` = '".$array["gender_id_FK"]."',
		`request_reason` = '".$array["request_reason"]."',
		`request_type_id_FK` = '".$array["request_type_id_FK"]."',
		`nationality_id_FK` = '".$array["nationality_id_FK"]."',
		`request_experience` = '".$array["request_experience"]."'

		WHERE `request_id`='".$array["request_id"]."' ";
		
		$db->query($query);
		$db->execute();
		$request_id=$db->lastInsertId();
		return $request_id;
	}

	function delete_request($request_id) {
		$db= new Database();
		
		$query="DELETE FROM `setup_employment_request` WHERE `request_id`='".$request_id."'";
		$db->query($query);
		$db->execute();
	}

	function get_action($request_id){
		$db		=new Database();
		$query="SELECT * FROM setup_request_state
		INNER JOIN setup_request_state_has_action ON setup_request_state_has_action.state_id_FK = setup_request_state.state_id
		INNER JOIN setup_request_action ON setup_request_action.action_id = setup_request_state_has_action.action_id_FK 
		WHERE setup_request_state.state_id = '".$request_id."' ";
		
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function save_action($array,$user_id){
		$query = "INSERT INTO `setup_request_actions_log` 
		(
			`action_id_FK`,
			`user_id_FK`,
			`date_time_inserted`,
			`action_comment`
		) 
		VALUES
		(
			'".$array["action_id"]."',
			'".$user_id."',
			'".Date("Y-m-d H:i:s")."',
			'".$array["action_comment"]."'
		)";

		$db = new Database();
		$db->query($query);
		$db->execute();
		$action_id=$db->lastInsertId();

		$query= "UPDATE `setup_employment_request` SET 
		`request_state_id_FK` = '".$array["action_id"]."' WHERE request_id = '".$array["request_id"]."'";
		
		$db->query($query);
		$db->execute();
		return $action_id;
	}

	function save_unmatched_action($array,$user_id){
		$query = "INSERT INTO `setup_request_actions_log` 
		(
			`action_id_FK`,
			`user_id_FK`,
			`date_time_inserted`
		) 
		VALUES
		(
			'".$array["action_id"]."',
			'".$user_id."',
			'".Date("Y-m-d H:i:s")."'
		)";

		$db = new Database();
		$db->query($query);
		$db->execute();
		$action_id=$db->lastInsertId();

		$query= "UPDATE `setup_employment_request` SET 
		`request_state_id_FK` = '".$array["action_id"]."' WHERE request_id = '".$array["request_id"]."'";
		
		$db->query($query);
		$db->execute();
		
		$this->delet_unmatching_applicant($array["flow_id"],$array["applicant_id"]);
		
	}

	function delet_unmatching_applicant($flow_id,$applicant_id){
		$db = new Database();
		$query="DELETE FROM `emp_app_flow_has_matching` WHERE `flow_id_FK`='".$flow_id."' AND `applicant_id_FK` = '".$applicant_id."' ";
		$db->query($query);
		$db->execute();
	}

	function save_job_opning($array,$user_id){
		$db = new Database();
		if ($array["opening_id_FK"] == -1) {
			$query = "INSERT INTO `setup_emp_job_opening` 
			(
				`opening_title`,
				`opening_description`
			) 
			VALUES
			(
				'".$array["opning_title"]."',
				'".$array["opening_description"]."'
			)";

			$db->query($query);
			$db->execute();
			$opning_id=$db->lastInsertId();

			$query = "INSERT INTO `setup_emp_request_has_opening` 
			(
				`request_id_FK`,
				`opening_id_FK`,
				`opening_start_date`,
				`opening_end_date`,
				`user_added`,
				`date_added`
			) 
			VALUES
			(
				'".$array["request_id"]."',
				'".$opning_id."',
				'".$array["opening_start_date"]." 00:00:00',
				'".$array["opening_end_date"]." 00:00:00',
				'".$user_id."',
				'".Date("Y-m-d H:i:s")."'
			)";

			$db->query($query);
			$db->execute();


			$query = "INSERT INTO `setup_request_actions_log` 
		(
			`action_id_FK`,
			`user_id_FK`,
			`date_time_inserted`
		) 
		VALUES
		(
			'".$array["action_id"]."',
			'".$user_id."',
			'".Date("Y-m-d H:i:s")."'
		)";

		
		$db->query($query);
		$db->execute();
		$action_id=$db->lastInsertId();

		$query= "UPDATE `setup_employment_request` SET 
		`request_state_id_FK` = '".$array["action_id"]."' WHERE request_id = '".$array["request_id"]."'";
		
		$db->query($query);
		$db->execute();

		} else {

			$query = "INSERT INTO `setup_emp_request_has_opening` 
			(
				`request_id_FK`,
				`opening_id_FK`,
				`opening_start_date`,
				`opening_end_date`,
				`user_added`,
				`date_added`
			) 
			VALUES
			(
				'".$array["request_id"]."',
				'".$array["opening_id_FK"]."',
				'".$array["opening_start_date"]." 00:00:00',
				'".$array["opening_end_date"]." 00:00:00',
				'".$user_id."',
				'".Date("Y-m-d H:i:s")."'
			)";

			$db->query($query);
			$db->execute();


			$query = "INSERT INTO `setup_request_actions_log` 
		(
			`action_id_FK`,
			`user_id_FK`,
			`date_time_inserted`
		) 
		VALUES
		(
			'".$array["action_id"]."',
			'".$user_id."',
			'".Date("Y-m-d H:i:s")."'
		)";

		
		$db->query($query);
		$db->execute();
		$action_id=$db->lastInsertId();

		$query= "UPDATE `setup_employment_request` SET 
		`request_state_id_FK` = '".$array["action_id"]."' WHERE request_id = '".$array["request_id"]."'";
		
		$db->query($query);
		$db->execute();

		}
	}

	function save_matching ($array,$user_id) {
		//print_r($_POST);
		$db= new Database();
		$query = "INSERT INTO `emp_app_flow_has_matching` 
		(
			`flow_id_FK`,
			`applicant_id_FK`,
			`applicant_score`,
			`date_selected`,
			`user_selected`,
			`matching_notes`
		) 
		VALUES
		(
			'".$array["flow_id"]."',
			'".$array["applicant_id"]."',
			'".$array["GlobalScore"]."',
			'".Date("Y-m-d H:i:s")."',
			'".$user_id."',
			'".$array["matching_notes"]."'
		)";

		$db->query($query);
		$db->execute();



		$query = "INSERT INTO `setup_request_actions_log` 
		(
			`action_id_FK`,
			`user_id_FK`,
			`date_time_inserted`
		) 
		VALUES
		(
			'".$array["action_id"]."',
			'".$user_id."',
			'".Date("Y-m-d H:i:s")."'
		)";

		
		$db->query($query);
		$db->execute();
		$action_id=$db->lastInsertId();

		$query= "UPDATE `setup_employment_request` SET 
		`request_state_id_FK` = '".$array["action_id"]."' WHERE request_id = '".$array["request_id"]."'";
		
		$db->query($query);
		$db->execute();

	}

	function get_request_search($ref_request,$date_start,$date_end,$branch_id) {

	    $query = "SELECT * FROM `setup_employment_request`
	    INNER JOIN `setup_emp_request_group` ON `setup_emp_request_group`.`emp_group_id`=`setup_employment_request`.`request_group_id_FK`
		INNER JOIN `setup_company_branch` ON `setup_company_branch`.`branch_id`=`setup_employment_request`.`branch_id_FK` 
		INNER JOIN `setup_request_state` ON `setup_request_state`.`state_id`=`setup_employment_request`.`request_state_id_FK` ";
	    
	    $conditions = array();

	    if(! empty($ref_request)) {
	      $conditions[] = "(request_ref_number LIKE '%".$ref_request."%' )";
	    }
	    if(! empty($branch_id)) {
	      $conditions[] = "branch_id_FK = '$branch_id'";
	    }
	    if(! empty($date_start)) {
	      $conditions[] = "request_date_created > '$date_start'";
	    }
	    if(! empty($date_end)) {
	      $conditions[] = "request_date_created < '$date_end'";
	    }

	    $sql = $query;
	    if (count($conditions) > 0) {
	      $sql .= " WHERE " . implode(' AND ', $conditions);
	    }
		
		$db=new Database();
		$db->query($sql);
		$result=$db->resultset();
		return $result;
	}
}


?>