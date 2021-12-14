<?php
class interview_question_group 
{
	public $table_name="emp_interview_question_group";
	public $question_group_id;
	public $question_group_name;
	public $question_group_order;
	public $question_group_description;
	public $rating_template_id_FK;
	
	function __Construct($question_group_id=NULL)
	{
		if(isset($question_group_id))
		{
			$this->question_group_id=$question_group_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `question_group_id`=:question_group_id";
		$db->query($query);
		$db->bind("question_group_id",$this->question_group_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_question_groups () {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."`";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function question_per_group($group_id) {
		$db		=new Database();
		$query = "SELECT * FROM emp_interview_question_group
			INNER JOIN emp_interview_template_question ON emp_interview_question_group.question_group_id = emp_interview_template_question.question_group_id_FK 
			WHERE emp_interview_question_group.question_group_id = '".$group_id."' ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>