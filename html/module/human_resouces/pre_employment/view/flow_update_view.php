<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/employee.class.php");
require_once("../../../../../html/lib/model/module.class.php");
require_once("../../../../../html/lib/model/menu_item.class.php");
require_once("../../../../../html/lib/model/department.class.php");
require_once("../model/interview_template_question.class.php");
require_once("../model/interview_question_group.class.php");
require_once("../model/template_attributes.class.php");
require_once("../model/applicant.class.php");
require_once("../model/flow_interview.class.php");
require_once("../model/interview_template_question.class.php");

$template_id 				 = $_POST['template_id'];
$questionObj    			= new interview_question();
$question_Obj   			= $questionObj->get_template_question($template_id);
$question_groupObj  		= new interview_question_group();
$av_question_groups 		= $question_groupObj->list_of_question_groups($template_id);
$template_attributesObj   	= new template_attributes();
$template_attributes_Obj  	= $template_attributesObj->list_of_template_attributes();
$questions_count			=0;
$applicantObj				=new applicant($_POST['applicant_id']);
$applicant_f_name = $applicantObj->applicant_first_name;
$applicant_l_name = $applicantObj->applicant_last_name;
$applicant_name = $applicant_f_name." ".$applicant_l_name;
$array_values				=array();
$str_values					="";
$str_type					="";

$questionObj = new interview_question();
?>

<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Update Applicant Interview</h4>
				<h1></h1>
				<?php //print_r($flow_Obj_RS); ?>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
            <div class="panel-title" style="text-align: center; border:1px solid #ddd; background: #10678c; color: #fff"><h4>Competency Profile</h4></div>
            <table summary="" cellPadding="4" cellSpacing="0" class="table" data-component="matrix">
            <tbody>
				<?php
					for($i=0;$i<count($av_question_groups);$i++)
					{
						$group_questions 	= $questionObj->get_question_per_group($av_question_groups[$i]['question_group_id']);	
						$rating_template 	=$av_question_groups[$i]["rating_template_id_FK"];
						$rating_attributes	=$questionObj->rating_attributes($rating_template);
						$string_attributes	=array();
					?>
					<tr>
						<td style="background: #000; color: #fff" ><?php echo $av_question_groups[$i]["question_group_name"]; ?></td>
						<!-- <td colspan="<?php echo count($rating_attributes); ?>">&nbsp;</td>-->
						<?php
							if($av_question_groups[$i]["rating_template_id_FK"]<>0) { ?>
							<!--<td></td>-->
						<?php
							
							for($k=0;$k<count($rating_attributes);$k++)
							{
								array_push($string_attributes,$rating_attributes[$k]["attribute_id"]);
							?>
							<td style="background: #10678c; color: #fff"><?php echo $rating_attributes[$k]["attribute_name"]; ?></td> <!-- This -->
							<?php
							}
						}
						?>
					</tr>
				<!--	<tr>
						<?php
							if($av_question_groups[$i]["rating_template_id_FK"]<>0) { ?>
							<td></td>
						<?php
							
							for($k=0;$k<count($rating_attributes);$k++)
							{
								array_push($string_attributes,$rating_attributes[$k]["attribute_id"]);
							?>
							<td style="background: #10678c; color: #fff"><?php echo $rating_attributes[$k]["attribute_name"]; ?></td>
							<?php
							}
						}
						?>
					</tr>
					<tr>
						<td style="background: #000; color: #fff" ><?php echo $av_question_groups[$i]["question_group_name"]; ?></td>
						<td colspan="<?php echo count($rating_attributes); ?>">&nbsp;</td>
					</tr>
-->
					<?php
					for($j=0;$j<count($group_questions);$j++)
					{
						array_push($array_values,$group_questions[$j]["question_id"]);
						$str_values.=$group_questions[$j]["question_id"].",";
						$str_type.=$av_question_groups[$i]["rating_template_id_FK"].",";
					?>
					<tr>
						<td><?php echo $group_questions[$j]["question_text"]; 
						$question_Obj = $questionObj->interview_results($group_questions[$j]["question_id"],$_POST['interview_id']); ?></td>
						<?php if($av_question_groups[$i]["rating_template_id_FK"]==0) { 
							$id = $group_questions[$j]["question_id"]?>
						<td colspan="100">
							<textarea id="answer_<?php echo $questions_count; ?>" style="width:100%;height:150px" id="tec" value="<?php echo $group_questions[$j]["question_text"]; ?>">
								<?php if (isset($question_Obj[0])) {
									echo $question_Obj[0];
								} else {
									echo "Empty";
								} ?>
							</textarea>
						</td>
						<?php }
						else {
						for($k=0;$k<count($rating_attributes);$k++) { 
							?>
							<td><input id="answer_<?php echo $questions_count; ?>" name="radio_<?php echo $questions_count; ?>" <?php if(in_array($rating_attributes[$k]["attribute_id"],$question_Obj)){  ?> checked="checked" <?php } ?> type="radio" value="<?php echo $rating_attributes[$k]["attribute_id"]; ?>" >
							</td>
						<?php } } ?>	
					</tr>
					<?php $questions_count++; } ?>
					<?php } ?>
              </tbody>
            </table>

			<div id="save_interview_div"></div>
            </div>
				<div class="form-group">
					<button type="button" class="btn btn-lg btn-warning btn-block" 
						onclick="submit_update_applicant_interview('<?php echo $_POST['applicant_id']; ?>','<?php echo $_POST['template_id']; ?>','<?php echo $_POST['flow_id']; ?>','<?php echo $questions_count; ?>','<?php echo $str_values; ?>','<?php echo $str_type; ?>','<?php echo $_POST['interview_id'] ?>')">Update</button>
				</div>	
				<div id="div_section_content"></div>
			</div>
		</div>
	</div>
</div>
