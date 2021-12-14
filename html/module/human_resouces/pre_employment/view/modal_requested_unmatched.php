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

$actionObj			=	new employment_request();
$action_obj		=	$actionObj->get_action($_POST['request_state_id']);

?>

<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Request Action</h4>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<p>Request Has A matching Profile</p>
					<?php //print_r($_POST) ?>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<?php for($i=0;$i<count($action_obj);$i++) { 
							$action_id = $action_obj[$i]["action_id"];
							?>
							<button type="button" class="btn btn-primary" onclick="actions_unmatched_log('<?php echo $action_id; ?>','<?php echo $_POST['request_id']; ?>','<?php echo $_POST['request_state_id']; ?>','<?php echo $_POST['applicant_id']; ?>','<?php echo $_POST['flow_id']; ?>')"><?php echo $action_obj[$i]["action_title"]; ?></button>
						<?php } ?>
					</div>
				</div>	
				<div id="div_section_content"></div>
			</div>
		</div>
	</div>
</div>