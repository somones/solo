<?php
class Flow
{
	public $table_name="flow_interview";
	public $interview_id;
	public $template_id_FK;
	public $applicant_id_FK;
	public $flow_id_FK;
	public $date_time_created;
	public $user_conducted;
	public $interview_completion;
	
	function __Construct($interview_id=NULL)
	{
		if(isset($interview_id))
		{
			$this->interview_id=$interview_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `interview_id`=:interview_id";
		$db->query($query);
		$db->bind("interview_id",$this->interview_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_flows () {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function save_interview($array,$user_id){
		//print_r($_POST);
		$db = new Database();
		$query = "INSERT INTO `flow_interview` 
		(
			`template_id_FK`,
			`applicant_id_FK`,
			`flow_id_FK`,
			`date_time_created`,
			`user_conducted`,
			`interview_completion`
		) VALUES (
			'".$array["template_id"]."',
			'".$array["applicant_id"]."',
			'".$array["flow_id"]."',
			'".Date("Y-m-d")."',
			'".$user_id."',
			'1'
		) ";
		
		$db->query($query);
		$db->execute();
		$interview_id=$db->lastInsertId();
		return $interview_id;
	}

	function save_flow_interview_results($question_id,$question_answer,$user_id) {
		date_default_timezone_set("Asia/Dubai");
		//print_r($_POST);
		$db = new Database();
		$query= "SELECT MAX(interview_id) AS interview_id FROM flow_interview";
		$db->query($query);
	 	$interview_id=$db->single();
		
		$query = "INSERT INTO `flow_interview_results` 
		(
			`interview_id_FK`,
			`question_id_FK`,
			`question_answer`,
			`date_time_inserted`,
			`user_inserted`
		) VALUES (
			'".$interview_id["interview_id"]."',
			'".$question_id."',
			'".$question_answer."',
			'".Date("Y-m-d")."',
			'".$user_id."'
		) ";
		
		$db->query($query);
		$db->execute();
		$interview_id=$db->lastInsertId();
		return $interview_id;
	}

	function update_flow_interview_results($interview_id,$question_id,$question_answer) {
		//print_r($_POST);
		$db=new Database();
		$query = "UPDATE flow_interview_results SET question_answer = '".$question_answer."' WHERE interview_id_FK = '".$interview_id."' AND question_id_FK = '".$question_id."'  ";
		echo $query;
		echo '<br>';
		$db->query($query);
		$db->execute();
		$applicant_id=$db->lastInsertId();
		return $applicant_id;
	}

	function average_scour($interview_id){
		$db = new Database();

		$query = "SELECT AVG(attribute_rate) AS AverageScour FROM flow_interview_results
INNER JOIN emp_interview_rating_template_attributes ON flow_interview_results.question_answer = emp_interview_rating_template_attributes.attribute_id WHERE flow_interview_results.interview_id_FK = '".$interview_id."' ";
		$db->query($query);
	 	$AverageScour=$db->single();
//print_r($scour);
	 	
	 	$query= "UPDATE `flow_interview` SET 
		`interview_score` = '".$AverageScour['AverageScour']."' WHERE interview_id = '".$interview_id."' ";
		$db->query($query);
		$db->execute();
		return $AverageScour;
	}

	function global_score($applicant_id,$flow_id) {
		$db = new Database();
		$query = "SELECT AVG(interview_score) AS GlobalScore FROM flow_interview WHERE  	applicant_id_FK = '".$applicant_id."' AND flow_id_FK = '".$flow_id."'";
		$db->query($query);
		$GlobalScore=$db->single();
		return $GlobalScore;
	}

	function interview_per_applicant($applicant_id,$flow_id) {
		$db = new Database();
		$query = "SELECT * FROM flow_interview WHERE applicant_id_FK = '".$applicant_id."' AND flow_id_FK = '".$flow_id."' ORDER BY `interview_id` ASC";
		$db->query($query);
	 	$result = $db->resultset();
	 	return $result;
	}

}
?>