<?php
class template_attributes 
{
	public $table_name="emp_interview_rating_template_attributes";
	public $attribute_id;
	public $attribute_name;
	public $attribute_rate;
	public $rating_template_FK;
	
	function __Construct($attribute_id=NULL)
	{
		if(isset($attribute_id))
		{
			$this->attribute_id=$attribute_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `attribute_id`=:attribute_id";
		$db->query($query);
		$db->bind("attribute_id",$this->attribute_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_template_attributes () {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE rating_template_FK = 1";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}
	function list_of_template_attributes_per_template ($rating_template_FK) {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE rating_template_FK = '".$rating_template_FK."'";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function template_attributes($rating_template_FK){
		$db		=new Database();
		$query = "SELECT
					emp_interview_rating_template_attributes.attribute_name,
					emp_interview_rating_template_attributes.attribute_id,
					emp_interview_rating_template_attributes.attribute_rate,
					emp_interview_rating_template_attributes.rating_template_FK
					FROM emp_interview_question_group
		INNER JOIN emp_interview_rating_template ON emp_interview_rating_template.rating_template_id = emp_interview_question_group.rating_template_id_FK
		INNER JOIN emp_interview_rating_template_attributes ON emp_interview_rating_template.rating_template_id = emp_interview_rating_template_attributes.rating_template_FK WHERE emp_interview_question_group.question_group_id = '".$rating_template_FK."' ";

		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}
}
?>

