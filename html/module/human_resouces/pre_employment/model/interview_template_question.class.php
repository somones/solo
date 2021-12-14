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
		$query="SELECT
				*
				FROM emp_interview_template_has_question
		INNER JOIN emp_interview_template ON emp_interview_template.template_id = emp_interview_template_has_question.template_id_FK
		INNER JOIN emp_interview_template_question ON emp_interview_template_question.question_id = emp_interview_template_has_question.question_id_FK ";
		
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_rating_attributes($question_id) {
		$db		=new Database();
		$query="SELECT
			emp_interview_template_question.question_id,
			emp_interview_rating_template_attributes.attribute_name,
			emp_interview_rating_template_attributes.attribute_id
		FROM
			emp_interview_template_question
		INNER JOIN emp_interview_rating_template ON emp_interview_rating_template.rating_template_id = emp_interview_template_question.rating_template_FK
		INNER JOIN emp_interview_rating_template_attributes ON emp_interview_rating_template_attributes.rating_template_FK = emp_interview_rating_template.rating_template_id
		WHERE emp_interview_template_question.question_id = '".$question_id."'";
		
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function rating_attributes($template_id) {
		$db		=new Database();
		$query="SELECT
emp_interview_rating_template_attributes.attribute_id,
emp_interview_rating_template_attributes.attribute_name,
emp_interview_rating_template_attributes.attribute_rate,
emp_interview_rating_template_attributes.rating_template_FK
FROM
emp_interview_rating_template
INNER JOIN emp_interview_rating_template_attributes ON emp_interview_rating_template.rating_template_id = emp_interview_rating_template_attributes.rating_template_FK

WHERE emp_interview_rating_template.rating_template_id = '".$template_id."'  ORDER BY `emp_interview_rating_template_attributes`.`attribute_id` ASC";
		//print_r($query);
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_template_question($group_id){
		$db = new Database();
		
		$query = "SELECT
				emp_interview_template_question.question_text FROM emp_interview_template
			INNER JOIN emp_interview_template_has_question ON emp_interview_template.template_id = emp_interview_template_has_question.template_id_FK
			INNER JOIN emp_interview_question_group ON emp_interview_question_group.question_group_id = emp_interview_template_has_question.group_id_FK
			INNER JOIN emp_interview_template_question ON emp_interview_template_question.question_id = emp_interview_template_has_question.question_id_FK
			WHERE emp_interview_question_group.question_group_id = '".$group_id."' ";
		
			$db->query($query);
	 		$result=$db->resultset();
	 		return $result;
	}

	function get_question_per_group ($group_id) {
		$db = new Database();
		
		$query = "SELECT
			emp_interview_template_question.question_id,
			emp_interview_template_question.question_text,
			emp_interview_template_question.question_type_FK,
			emp_interview_template_question.question_order
		FROM emp_interview_question_group
		INNER JOIN emp_interview_template_question ON emp_interview_question_group.question_group_id = emp_interview_template_question.question_group_id_FK WHERE emp_interview_question_group.question_group_id = '".$group_id."'";

		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function interview_results($question_id_FK,$interview_id){
		$array=array();
		$db=new Database();
		$query="SELECT * FROM `flow_interview_results` WHERE `question_id_FK`='".$question_id_FK."' AND interview_id_FK = '".$interview_id."' LIMIT 1";
		$db->query($query);
		$result=$db->resultset();
		for($i=0;$i<count($result);$i++)
		{
			array_push($array,$result[$i]["question_answer"]);
		}
		return $array;
	}

}
?>