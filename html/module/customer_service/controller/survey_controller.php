<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once("../../../lib/model/database.class.php");
require_once("../../../lib/model/company.class.php");
require_once("../../../lib/model/employee.class.php");
require_once("../../../lib/model/module.class.php");
require_once("../../../lib/model/item_category.class.php");
require_once("../../../lib/model/template.inc.php");
require_once("../../../lib/model/branch.class.php");
require_once("../model/survey.class.php");
?>
<div id="modal-sizes-3" class="modal fade in" tabindex="-1" role="dialog" style="display: block;width:100%" aria-hidden="false" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Submission Completed</h4>
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-lg-12">
					<div class="alert alert-success">
						<?php
							//print_r($_POST);
							$av_questions	=explode(",",$_POST['survey_questions']);
							$av_answers		=explode(",",$_POST["str"]);
							$surveyObj		=new survey($_POST['template_id']);
							$record_id=$surveyObj->insert_new_submission($_POST['branch_id'],$_POST['gender'],$_POST['template_id'],$_POST['doctor_id']);
							
							for($i=0;$i<count($av_questions)-1;$i++)
							{
								$surveyObj->insert_into_record($record_id,$av_questions[$i],$av_answers[$i]);
							}
							
							echo $surveyObj->get_label_text(6,2000,$_POST['language']);//();"Thank you For your Time";
							
						?>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<a href="survey_landing.php?branch=<?php echo $_POST['branch_id']; ?>&template=<?php echo $_POST['template_id']; ?>">
					<input type="button" class="btn btn-primary" Value="<?php echo $surveyObj->get_label_text(6,2001,$_POST['language']); ?>"></a>
					</a>
				</div>
			</div>			
			
		</div>
	</div>
</div>