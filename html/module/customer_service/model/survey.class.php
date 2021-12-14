<?php
class survey 
{
	public $table_name="survey_template";
	
	function __Construct($survey_id=NULL)
	{
		if(isset($survey_id))
		{
			$this->survey_id=$survey_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `survey_id`=:survey_id";
		$db->query($query);
		$db->bind("survey_id",$this->survey_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;		
	}
	
	function get_survey_doctors($branch_id)
	{
		$db=new Database();
		$query="SELECT * FROM `survey_branch_has_doctor` WHERE `branch_id_FK`='".$branch_id."'";
		$db->query($query);
		return $db->resultset();
		
	}
	
	function insert_new_submission($branch_id,$gender_id,$survey_id,$doctor_id)
	{
		$db=new Database();
		$query="INSERT INTO `survey_record` (`record_gender_id_FK`,`record_doctor_id_FK`,`branch_id_FK`,`survey_id_FK`,`record_date`,`record_name`,`record_file_number`,
		`record_email`,`record_phone_number`,`record_tracker`)
		VALUES('".$gender_id."','".$doctor_id."','".$branch_id."','".$survey_id."','".date("Y-m-d G:i:s")."','','','','','1')";
		$db->query($query);
		$db->execute();
		return $db->lastInsertId();
	}
	
	function insert_into_record($record_id,$question_id,$answer_id)
	{
		
		$db=new Database();
		$query="INSERT INTO `survey_record_has_answer` (`record_id_FK`,`question_id_FK`,`answer_id_FK`) 
		VALUES('".$record_id."','".$question_id."','".$answer_id."')";
		$db->query($query);
		$db->execute();
	}
	
	function get_survey_questions($language_id)
	{
		$db=new Database();
		$query="SELECT * FROM `survey_has_question`
		INNER JOIN `survey_question` ON `survey_question`.`question_id`=`survey_has_question`.`question_id_FK`
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_question`.`question_id`
		WHERE `object_type`='1' AND `text_language_id_FK`='".$language_id."' 
		AND `survey_has_question`.`survey_id_FK`='".$this->survey_id."'
		ORDER BY `survey_has_question`.`question_order`";
		
		$db->query($query);
		return $db->resultset();
	}
	
	function get_survey_rating($language_id)
	{
		
		$db=new Database();
		$query="SELECT * FROM `survey_rating_attribute` 
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_rating_attribute`.`attribute_id`
		WHERE `object_type`='3' AND `text_language_id_FK`='".$language_id."' AND `rating_type_id_FK`='".$this->rating_id_FK."'
		ORDER BY `survey_rating_attribute`.`value` ASC";
		$db->query($query);
		return $db->resultset();
		
	}
	
	function get_active_templates($default_lang=1)
	{
		$db=new Database();
		$query="SELECT * FROM `".$this->table_name."` 
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_id`
		WHERE `text_language_id_FK`='".$default_lang."'
		AND `object_type`='2'
		AND  `survey_active`='1'";
		$db->query($query);
		return $db->resultset();
		
	}
	
	function get_label_text($object_type,$object_id,$language)
	{
		$db=new Database();
		$query="SELECT `text_phrase` FROM `survey_language_text` WHERE `object_type`='".$object_type."' AND `object_id_FK`='".$object_id."' AND `text_language_id_FK`='".$language."'";
		$db->query($query);
		$result=$db->resultset();
		return $result[0]["text_phrase"];
	}
	
	function get_available_lang()
	{
		$db=new Database();
		$query="SELECT * FROM `survey_language`";
		$db->query($query);
		return $db->resultset();
	}

	function get_survey_template()
	{
		$db=new Database();
		$query="SELECT * FROM `survey_template`
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_template`.`survey_id`
		WHERE `object_type`='2' AND `text_language_id_FK`='1' ";
		
		$db->query($query);
		return $db->resultset();
	}

	function get_survey_template_name($survey_id)
	{
		$db=new Database();
		$query="SELECT * FROM `survey_template`
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_template`.`survey_id`
		WHERE `object_type`='2' AND `text_language_id_FK`='1' AND survey_id = '".$survey_id."'";
		
		$db->query($query);
		return $db->single();
	}

	function get_survey_template_questions($survey_id_FK) 
	{
		$db=new Database();

		$query="SELECT * FROM `survey_has_question`
		INNER JOIN `survey_question` ON `survey_question`.`question_id`=`survey_has_question`.`question_id_FK`
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_question`.`question_id`
		WHERE `survey_id_FK`='".$survey_id_FK."' AND `object_type`='1' AND `text_language_id_FK`='1'";
		
		$db->query($query);
		return $db->resultset();
	}

	function get_template_section () 
	{
		$db=new Database();
		$query="SELECT * FROM `survey_question_section` ";
		
		$db->query($query);
		return $db->resultset();
	}

	function get_section_question ($section_id_FK) 
	{
		$db=new Database();
		$query="SELECT * FROM `survey_question` 
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_question`.`question_id`
		WHERE `section_id_FK`='".$section_id_FK."' AND `object_type`='1' AND `text_language_id_FK`='1'";
		
		$db->query($query);
		return $db->resultset();
	}

	function get_this_section ($section_id_FK) 
	{
		$db=new Database();
		$query="SELECT * FROM `survey_question_section` 
		WHERE `section_id`='".$section_id_FK."' ";
		
		$db->query($query);
		return $db->single();
	}

	function survy_html_report_query(){
		$db=new Database();

		$query="SELECT * FROM `survey_record_has_answer`
		INNER JOIN `survey_record` ON `record_id_FK`=`record_id`
		INNER JOIN `survey_question` ON `question_id_FK`=`question_id`
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_record_has_answer`.`question_id_FK` 
		WHERE `object_type`='1' AND `text_language_id_FK`='1'
		AND `record_date`>'2019-03-01 00:00:01' AND `record_date` < '2019-03-31 23:59:59' ";
		
		$db->query($query);
		return $db->resultset();
	}
	function survy_html_report_query_2(){
		$db=new Database();

		$query="SELECT * FROM `survey_record_has_answer`
		INNER JOIN `survey_record` ON `record_id_FK`=`record_id`
		INNER JOIN `survey_question` ON `question_id_FK`=`question_id`
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_record_has_answer`.`question_id_FK` 
		WHERE `object_type`='1' AND `text_language_id_FK`='1'
		AND `record_date`>'2019-03-01 00:00:01' AND `record_date` < '2019-03-31 23:59:59' LIMIT 1";
		
		$db->query($query);
		return $db->resultset();
	}

	function get_section_question_count($section_id) {
		$db=new Database();

		$request_query="SELECT COUNT(*) AS `rows_nb` FROM `survey_record_has_answer` 
		INNER JOIN `survey_question` ON `question_id_FK`=`survey_record_has_answer`.`question_id_FK`

		WHERE `section_id_FK` = '".$section_id."' ";
	
		$db->query($request_query);
		$result=$db->single();
		
		return $result['rows_nb'];
	}

	function get_section_question__i($section_id) {
		$db=new Database();

		$request_query="SELECT * FROM `survey_record` 

		WHERE `survey_id_FK` = '".$section_id."' ";
	
		$db->query($request_query);
		$result=$db->resultset();
		
		return $result;
		
	}


	function get_survey_search_json($survey_template_id,$date_start,$date_end,$branch_id,$object_type,$text_language_id_FK,$section_id,$question_id,$answer_id) {

	    $query="SELECT COUNT(*) AS `rows_nb` FROM `survey_record_has_answer`
		INNER JOIN `survey_record` ON `record_id_FK`=`record_id`
		INNER JOIN `survey_question` ON `question_id_FK`=`question_id`
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_record_has_answer`.`question_id_FK` ";
	    
	    $conditions = array();

	    if(! empty($object_type)) {
	      $conditions[] = "object_type='$object_type'";
	    }

	    if(! empty($text_language_id_FK)) {
	      $conditions[] = "text_language_id_FK='$text_language_id_FK'";
	    }

	    if(! empty($survey_template_id)) {
	      $conditions[] = "survey_id_FK='$survey_template_id'";
	    }
	    if(! empty($date_start)) {
	      $conditions[] = "record_date > '$date_start'";
	    }
	    if(! empty($date_end)) {
	      $conditions[] = "record_date < '$date_end'";
	    }
	    if(! empty($branch_id)) {
	      $conditions[] = "branch_id_FK ='$branch_id'";
	    }
	    if(! empty($section_id)) {
	      $conditions[] = "section_id_FK ='$section_id'";
	    }
	    if(! empty($question_id)) {
	      $conditions[] = "question_id_FK ='$question_id'";
	    }
	    if(! empty($answer_id)) {
	      $conditions[] = "answer_id_FK ='$answer_id'";
	    }

	    $sql = $query;
	    if (count($conditions) > 0) {
	      $sql .= " WHERE " . implode(' AND ', $conditions);
	    }
		
		$db=new Database();
		$db->query($sql);
		$result=$db->single();
		return $result['rows_nb'];
	}

	function get_survey_search($survey_template_id,$date_start,$date_end,$branch_id,$object_type,$text_language_id_FK,$section_id,$answer_id) {

	    $query="SELECT COUNT(*) AS `rows_nb` FROM `survey_record_has_answer`
		INNER JOIN `survey_record` ON `record_id_FK`=`record_id`
		INNER JOIN `survey_question` ON `question_id_FK`=`question_id` 
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_record_has_answer`.`question_id_FK`";
	    
	    $conditions = array();

	    if(! empty($object_type)) {
	      $conditions[] = "object_type='$object_type'";
	    }

	    if(! empty($text_language_id_FK)) {
	      $conditions[] = "text_language_id_FK='$text_language_id_FK'";
	    }

	    if(! empty($survey_template_id)) {
	      $conditions[] = "survey_id_FK='$survey_template_id'";
	    }
	    if(! empty($date_start)) {
	      $conditions[] = "record_date > '$date_start'";
	    }
	    if(! empty($date_end)) {
	      $conditions[] = "record_date < '$date_end'";
	    }
	    if(! empty($branch_id)) {
	      $conditions[] = "branch_id_FK ='$branch_id'";
	    }
	    if(! empty($section_id)) {
	      $conditions[] = "section_id_FK ='$section_id'";
	    }
	    if(! empty($answer_id)) {
	      $conditions[] = "answer_id_FK ='$answer_id'";
	    }

	    $sql = $query;
	    if (count($conditions) > 0) {
	      $sql .= " WHERE " . implode(' AND ', $conditions);
	    }
		
		$db=new Database();
		$db->query($sql);
		$result=$db->single();
		return $result['rows_nb'];
	}

	function get_survey_total($survey_template_id,$date_start,$date_end,$branch_id,$object_type,$text_language_id_FK,$section_id) {

	    $query="SELECT COUNT(*) AS `rows_nb` FROM `survey_record_has_answer`
		INNER JOIN `survey_record` ON `record_id_FK`=`record_id`
		INNER JOIN `survey_question` ON `question_id_FK`=`question_id` 
		INNER JOIN `survey_language_text` ON `survey_language_text`.`object_id_FK`=`survey_record_has_answer`.`question_id_FK`";
	    
	    $conditions = array();

	    if(! empty($object_type)) {
	      $conditions[] = "object_type='$object_type'";
	    }

	    if(! empty($text_language_id_FK)) {
	      $conditions[] = "text_language_id_FK='$text_language_id_FK'";
	    }

	    if(! empty($survey_template_id)) {
	      $conditions[] = "survey_id_FK='$survey_template_id'";
	    }
	    if(! empty($date_start)) {
	      $conditions[] = "record_date > '$date_start'";
	    }
	    if(! empty($date_end)) {
	      $conditions[] = "record_date < '$date_end'";
	    }
	    if(! empty($branch_id)) {
	      $conditions[] = "branch_id_FK ='$branch_id'";
	    }
	    if(! empty($section_id)) {
	      $conditions[] = "section_id_FK ='$section_id'";
	    }

	    $sql = $query;
	    if (count($conditions) > 0) {
	      $sql .= " WHERE " . implode(' AND ', $conditions);
	    }
		
		$db=new Database();
		$db->query($sql);
		$result=$db->single();
		return $result['rows_nb'];
	}

	function get_count_record($template_id,$branch_id,$date_start,$date_end) {
		
		$query="SELECT COUNT(*) AS `rows_nb` FROM `survey_record` ";
	    
	    $conditions = array();

	    if(! empty($date_start)) {
	      $conditions[] = "record_date > '$date_start'";
	    }
	    if(! empty($date_end)) {
	      $conditions[] = "record_date < '$date_end'";
	    }
	    if(! empty($branch_id)) {
	      $conditions[] = "branch_id_FK ='$branch_id'";
	    }
	    if(! empty($template_id)) {
	      $conditions[] = "survey_id_FK ='$template_id'";
	    }

	    $sql = $query;
	    if (count($conditions) > 0) {
	      $sql .= " WHERE " . implode(' AND ', $conditions);
	    }
		
		$db=new Database();
		$db->query($sql);
		$result=$db->single();
		return $result['rows_nb'];
	}

}
