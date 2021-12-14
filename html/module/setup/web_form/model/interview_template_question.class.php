<?php
class interview_question
{
	public $table_name="emp_interview_template_question";
	public $question_id;
	public $question_text;
	public $question_type_FK;
	public $question_active;
	public $question_order;
	public $question_date_added;
	public $question_user_added;
	public $rating_type_FK;
	
	function __Construct($question_id=NULL)
	{
		if(isset($question_id))
		{
			$this->question_id=$question_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `question_id`=:question_id";
		$db->query($query);
		$db->bind("question_id",$this->question_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_question () {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function question_per_template() {
		$db		=new Database();
		$query="SELECT * FROM emp_interview_template_has_question
INNER JOIN emp_interview_template ON emp_interview_template.template_id = emp_interview_template_has_question.template_id_FK
INNER JOIN emp_interview_template_question ON emp_interview_template_question.question_id = emp_interview_template_has_question.question_id_FK";
		
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_rating_attributes() {
		$db		=new Database();
		$query="SELECT * FROM emp_interview_rating_template_attributes WHERE rating_template_FK = 1 ";
		
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

}
?>