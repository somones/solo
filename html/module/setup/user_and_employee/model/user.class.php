<?php

class user
{
	public $table_name="setup_employee";
	public $employee_id;
	public $branch_id_FK;
	public $department_id_FK;
	public $employee_full_name;
	public $employee_job_title;
	public $employee_dob;
	public $employee_number;
	public $employee_email;
	public $employee_active;
	public $profile_completed;
	
	function __Construct($employee_id=NULL)
	{
		if(isset($employee_id))
		{
			$this->employee_id=$employee_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `employee_id`=:employee_id";
		$db->query($query);
		$db->bind("employee_id",$this->employee_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function get_user_role ($user_id) {
		
		$query="SELECT * FROM `setup_employee_has_role`
		
		INNER JOIN `setup_user_role` ON `setup_user_role`.`role_id` = `setup_employee_has_role`.`role_id_FK` 
		WHERE `employee_id_FK` = '".$user_id."' ";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result['role_name'];
	}

	function get_user_roles($user_id)
	{
		$array_single=array();
		
		$db=new Database();
		
		$query="SELECT * FROM `setup_employee_has_role` 
		INNER JOIN `setup_user_role` ON `setup_user_role`.`role_id` = `setup_employee_has_role`.`role_id_FK` WHERE `employee_id_FK`='".$user_id."'";
		
		$db->query($query);
		$result=$db->resultset();
		
		for($i=0;$i<count($result);$i++)
		{
			array_push($array_single,$result[$i]["role_id"]);
		}
		return $array_single;
	}

	function get_list_roles() {
		
		$db=new Database();
		
		$query="SELECT * FROM `setup_user_role` ";
		
		$db->query($query);
		$result=$db->resultset();
		
		return $result;
	}

	function list_of_user($user_session=NULL)
	{
		$query="SELECT * FROM `setup_employee`
		INNER JOIN `setup_company_branch` ON `setup_company_branch`.`branch_id` = `setup_employee`.`branch_id_FK` 
		INNER JOIN `setup_department` ON `setup_department`.`department_id` = `setup_employee`.`department_id_FK` ";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_user()
	{
		$query="INSERT INTO `setup_employee` 
		(
			`branch_id_FK`,
			`department_id_FK`,
			`employee_full_name`,
			`employee_job_title`,
			`employee_dob`,
			`employee_number`,
			`employee_email`,
			`employee_active`,
			`profile_completed`
		) 
		VALUES
		(
			'".$this->branch_id."',
			'".$this->department_id."',
			'".$this->employee_full_name."',
			'".$this->employee_job_title."',
			'".$this->employee_dob."',
			'".$this->employee_number."',
			'".$this->employee_email."',
			'".$this->employee_active."',
			'".$this->profile_completed."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$employee_id=$db->lastInsertId();
		return $employee_id;
	}

	function update_this_user ($user_id) {
		$query= "UPDATE `setup_employee` 
		SET 
			branch_id_FK = '".$this->branch_id."', 
			department_id_FK = '".$this->department_id."', 
			employee_full_name = '".$this->employee_full_name."', 
			employee_job_title = '".$this->employee_job_title."', 
			employee_dob = '".$this->employee_dob."', 
			employee_number = '".$this->employee_number."', 
			employee_email = '".$this->employee_email."', 
			employee_active = '".$this->employee_active."', 
			profile_completed = '".$this->profile_completed."'
			
		WHERE `employee_id`='".$user_id."'";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_user($user_id)
	{
		$db=new Database();
		$query="DELETE FROM `setup_employee` WHERE `employee_id`='".$user_id."'";
		$db->query($query);
		$db->execute();
	}
	
	function remove_all_permissions($user_id)
	{
		$db=new Database();
		$query="DELETE FROM `setup_employee_has_role` WHERE `employee_id_FK`='".$user_id."'";
		$db->query($query);
		$db->execute();
	}
	

	function add_user_roles($user_id,$role_id)
	{
		$query="INSERT INTO `setup_employee_has_role` 
		(
			`employee_id_FK`,
			`role_id_FK`
		) 
		VALUES(
			'".$user_id."',
			'".$role_id."'
		)";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}



	function get_search_result($employee_name,$job_title,$hr_number,$employee_email,$branch_id,$department_id,$isComplete,$isActive) {
	    $query = "SELECT * FROM `setup_employee`
		INNER JOIN `setup_company_branch` ON `setup_company_branch`.`branch_id` = `setup_employee`.`branch_id_FK` 
		INNER JOIN `setup_department` ON `setup_department`.`department_id` = `setup_employee`.`department_id_FK` ";
	    
	    $conditions = array();

	    if(! empty($employee_name)) {
	      $conditions[] = "(employee_full_name LIKE '%".$employee_name."%')";
	    }
	    if(! empty($job_title)) {
	      $conditions[] = "(employee_job_title LIKE '%".$job_title."%')";
	    }

	    if(! empty($hr_number)) {
	      $conditions[] = "(employee_number LIKE '%".$hr_number."%')";
	    }

	    if(! empty($employee_email)) {
	      $conditions[] = "(employee_email LIKE '%".$employee_email."%')";
	    }

	    if(! empty($branch_id)) {
	      $conditions[] = "branch_id_FK='$branch_id'";
	    }
	    if(! empty($department_id)) {
	      $conditions[] = "department_id_FK='$department_id'";
	    }
	    if(! empty($isComplete)) {
	      $conditions[] = "profile_completed='$isComplete'";
	    }
	    if(! empty($isActive)) {
	      $conditions[] = "employee_active='$isActive'";
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


