<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../model/survey.class.php");

$surveyObj				=new survey();
$recordObj				=new survey();
//$survey_obj				=$surveyObj->get_survey_search_json($_POST['survey_template_id'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id'],1,1);
//$survey_obj_test		=$surveyObj->get_survey_search_json_test($_POST['survey_template_id'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id'],1,1);
$section_Obj 				= $surveyObj->get_template_section(); 
//print_r($survey_obj);
/*
if (count($survey_obj)==0) { ?>
	<p>Sorry There is No Results for this Search</p>
<?php } else {

	for($i=0;$i<count($survey_obj);$i++) {  
		$survey_sec				= $surveyObj->get_this_section($survey_obj[$i]['section_id_FK']); ?>
		<tr>
			<td><?php echo $survey_obj[$i]['record_id_FK']; ?></td>
			<td><?php echo $survey_obj[$i]['question_id_FK']; ?></td>
			<td><?php echo $survey_obj[$i]['answer_id_FK']; ?></td>
			<td><?php echo $survey_obj[$i]['date_answered']; ?></td>
			<td><?php echo $survey_obj[$i]['record_doctor_id_FK']; ?></td>
			<td><?php echo $survey_obj[$i]['branch_id_FK']; ?></td>
			<td><?php echo $survey_obj[$i]['survey_id_FK']; ?></td>
			<td><?php echo $survey_obj[$i]['record_name']; ?></td>
			<td><?php echo $survey_obj[$i]['record_file_number']; ?></td>
			<td><?php echo $survey_obj[$i]['question_rating_id_FK']; ?></td>
			<td><?php echo $survey_obj[$i]['section_id_FK']; ?></td>
			<td><?php echo $survey_obj[$i]['text_id']; ?></td>
			<td><?php echo $survey_obj[$i]['text_language_id_FK']; ?></td>
			<td><?php echo $survey_obj[$i]['object_type']; ?></td>
			<td><?php echo $survey_obj[$i]['object_id_FK']; ?></td>
			<td><?php echo $survey_obj[$i]['text_phrase']; ?></td>
			<td><b><?php echo $survey_sec['section_name']; ?></b></td>
		</tr>
	<?php
	 } 
}
*/
?>

<div class="modal-body">
	<div><b>Record Number : </b><?php echo $surveyObj->get_count_record($_POST['survey_template_id'],$_POST['branch_id'],$_POST['date_start'],$_POST['date_end']); ?></div>
	<table class="table table-responsive table-bordered table-primary" name="data_grid">
		<thead>
			<th>Section</th>
			<th>Excellent</th>
			<th>Excellent & Good</th>
			<th>Percentage</th>
			<th>Total</th>
		</thead>
		<tbody>
			<?php for ($i=0; $i < count($section_Obj); $i++) { 
				$ex = $surveyObj->get_survey_search($_POST['survey_template_id'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id'],1,1,$section_Obj[$i]['section_id'],1);
				$good = $surveyObj->get_survey_search($_POST['survey_template_id'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id'],1,1,$section_Obj[$i]['section_id'],2);
				$ans = $ex + $good;
				$total = $surveyObj->get_survey_total($_POST['survey_template_id'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id'],1,1,$section_Obj[$i]['section_id']);
				if ($ans <> 0) {
					$percentage = ($ex * 100) / $ans;
				} else {
					$percentage = 0;
				}
				
				?>
		<tr>
			<td><?php echo $section_Obj[$i]['section_name']; ?></td>
			<td><?php echo $surveyObj->get_survey_search($_POST['survey_template_id'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id'],1,1,$section_Obj[$i]['section_id'],1); ?></td>
			<td><?php echo $ex+$good; ?></td>
			<td><?php echo $percentage." %"; ?></td>
			<td><?php echo $surveyObj->get_survey_total($_POST['survey_template_id'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id'],1,1,$section_Obj[$i]['section_id']);  ?></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
<?php $section_Obj_tab 	= $surveyObj->get_template_section();  ?>
<?php for ($i=0; $i < count($section_Obj_tab); $i++) { ?>
<div class="modal-header" style="background-color: black; text-align: center;">
	<h6 class="modal-title"><b style="color: #fff;"><?php echo $section_Obj_tab[$i]['section_name']; ?></b></h6>
</div>
<table class="table table-responsive table-bordered table-primary" name="data_grid">
	<thead>
		<th>Question</th>
		<th>Excellent</th>
		<th>Good</th>
		<th>Fair</th>
		<th>Poor</th>
	</thead>
	<tbody id="table_result">
		<?php $question_obj=$surveyObj->get_section_question($section_Obj_tab[$i]['section_id']); 
		//print_r($question_obj);?>
	<?php for ($y=0; $y < count($question_obj); $y++) { ?>
	<tr>
		<td><?php echo $question_obj[$y]['text_phrase']; ?></td>
		<td><?php echo $surveyObj->get_survey_search_json($_POST['survey_template_id'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id'],1,1,$section_Obj_tab[$i]['section_id'],$question_obj[$y]['question_id'],1); ?></td>
		<td><?php echo $surveyObj->get_survey_search_json($_POST['survey_template_id'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id'],1,1,$section_Obj_tab[$i]['section_id'],$question_obj[$y]['question_id'],2); ?></td>
		<td><?php echo $surveyObj->get_survey_search_json($_POST['survey_template_id'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id'],1,1,$section_Obj_tab[$i]['section_id'],$question_obj[$y]['question_id'],3); ?></td>
		<td><?php echo $surveyObj->get_survey_search_json($_POST['survey_template_id'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id'],1,1,$section_Obj_tab[$i]['section_id'],$question_obj[$y]['question_id'],4); ?></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>