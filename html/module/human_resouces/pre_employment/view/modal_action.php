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
require_once("../model/employment_request.class.php");
require_once("../model/applicant.class.php");
require_once("../model/flow_interview.class.php");

$actionObj			=	new employment_request();
$action_obj		=	$actionObj->get_action($_POST['request_state_id']);


//print_r($_POST);
$applicantObj				=new applicant();
$flow_obj 					= $applicantObj->get_flow_id($_POST['request_id']);

$flow_id = $flow_obj[0]['app_flow_id'];
$applicant_obj				=$applicantObj->applicants_per_flow($flow_id);


$flowObj = new Flow();

?>

<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Request Action</h4>
				<?php //print_r($flow_obj); ?>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Selected Applicants</label>
					<div class="col-md-9">
						<select class="form-control" id="applicant_id">
							<option value="">Select ...</option>
							<?php for($i=0;$i<count($applicant_obj);$i++){ 	
							$flow_Obj = $flowObj->global_score($applicant_obj[$i]["applicant_id"],$flow_id ); ?>
							<option value="<?php echo $applicant_obj[$i]["applicant_id"]; ?>">
								<?php echo $applicant_obj[$i]["applicant_first_name"]." ".$flow_Obj["GlobalScore"]; ?>
							</option>
							<?php } ?>
						</select>
						<input type="hidden" id="GlobalScore" value="<?php echo $flow_Obj["GlobalScore"]; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Comments: </label>
					<div class="col-md-9">
						<textarea id="matching_notes" class="form-control" placeholder="Comments"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<?php for($i=0;$i<count($action_obj);$i++) { 
							$action_id = $action_obj[$i]["action_id"];
							?>
							<button type="button" class="btn btn-primary" onclick="save_matching_opening('<?php echo $flow_id; ?>','<?php echo $action_id ?>','<?php echo $_POST['request_id'] ?>')"><?php echo $action_obj[$i]["action_title"]; ?></button>
						<?php } ?>
					</div>
				</div>	
				<div id="div_section_content"></div>
			</div>
		</div>
	</div>
</div>