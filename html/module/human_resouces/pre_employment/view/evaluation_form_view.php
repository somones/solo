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
?>

<div class="px-content">
	<div class="page-header"><?php //print_r($_POST);?>
	<div class="btn-group pull-right col-xs-12 col-sm-auto">
		<div class="btn-group pull-right">
			<div class="form-group">
				<button type="button" class="btn" onclick="get_applicant_details('<?php echo $_POST['applicant_id']; ?>','<?php echo $_POST['flow_id']; ?>','<?php echo $_POST['status_id']; ?>')">Back</button>
			</div>
		</div>
	</div> 
</div>

    <div class="page-header">
    	<div class="btn-group pull-left col-xs-12 col-sm-auto">
    		<h4>APPLICANT NAME: <b><?php echo $applicant_name; ?></b></h4>
    	</div>
    	<div id="sub-content-wrapper"></div>
    </div>
    <div class="row">
    <div class="col-lg-12">
      <div class="panel">
        <div class="panel-body p-a-4 b-b-4 bg-white darken">
        	<form class="form-horizontal" id="validation-form">
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
					

					<?php
					for($j=0;$j<count($group_questions);$j++)
					{
						array_push($array_values,$group_questions[$j]["question_id"]);
						$str_values.=$group_questions[$j]["question_id"].",";
						$str_type.=$av_question_groups[$i]["rating_template_id_FK"].",";
					?>
					<tr>
						<td><?php echo $group_questions[$j]["question_text"]; ?></td>
						<?php if($av_question_groups[$i]["rating_template_id_FK"]==0) { ?>
						<td colspan="100">
							<textarea id="answer_<?php echo $questions_count; ?>" style="width:100%;height:150px" id="tec"></textarea>
						</td>
						<?php }
						else {
						for($k=0;$k<count($rating_attributes);$k++) { ?>
							<td><input id="answer_<?php echo $questions_count; ?>" name="radio_<?php echo $questions_count; ?>" type="radio" value="<?php echo $rating_attributes[$k]["attribute_id"]; ?>" required></td>
						<?php } } ?>	
					</tr>
					<?php $questions_count++; } ?>
					<?php } ?>
              </tbody>
            </table>
			<div class="row">
				<div class="col-lg-12" style="text-align:center">
					<input type="button" value="Save Interview" class="btn btn-primary" onclick="submit_save_applicant_interview('<?php echo $_POST['applicant_id']; ?>','<?php echo $_POST['template_id']; ?>','<?php echo $_POST['flow_id']; ?>','<?php echo $questions_count; ?>','<?php echo $str_values; ?>','<?php echo $str_type; ?>')">
				</div>
			</div>
			<div id="save_interview_div"></div>
            </div>
        </div>
      </div>
    </div>
	</form>
  </div>
</div>


