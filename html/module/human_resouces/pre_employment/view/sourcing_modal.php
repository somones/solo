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
require_once("../model/job_opening.class.php");

$actionObj			=	new employment_request();
$action_obj		    =	$actionObj->get_action($_POST['request_state_id']);

$openingObj         = 	new emp_job_opening();
$opening_Obj        = 	$openingObj->list_of_job_opning();

?>

<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Request Action</h4>
				<h1><?php //echo $_POST['request_id']; ?></h1>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Opening Request</label>
					<div class="col-md-9">
						<select class="form-control" id="opening_id_FK">
							<option value="">Select ...</option>
							<option value="-1">Other</option>
							<?php for($i=0;$i<count($opening_Obj);$i++){ ?>
								<option value="<?php echo $opening_Obj[$i]["opening_id"]; ?>"><?php echo $opening_Obj[$i]["opening_title"]; ?></option>
								<?php } ?>
						</select>
					</div>
					<script type="text/javascript">
						$(document).ready(function() {
								$('#opning_title').prop( "disabled", true );
						       	$('#opening_description').prop( "disabled", true );
						 	$('#opening_id_FK').change(function() {
						  	if( $(this).val() == -1) {
						       	$('#opning_title').prop( "disabled", false );
						       	$('#opening_description').prop( "disabled", false );
						    } else {       
						      $('#opning_title').prop( "disabled", true );
						      $('#opening_description').prop( "disabled", true );
						    }
						  });
						});
					</script>
				</div>
				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Title</label>
			        <div class="col-md-9">
			          <input type="text" class="form-control" id="opning_title" value="">
			        </div>
			     </div>
				<div class="form-group">
			        <label for="grid-input-1" class="col-md-3 control-label">Description</label>
			        <div class="col-md-9">
			         <textarea id="opening_description" class="form-control"></textarea>
			        </div>
			    </div>
			    <div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Start Date</label>
					<div class="col-md-9">
						<input type="text" class="form-control" value="" name="datefield" id="opening_start_date">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">End Date</label>
					<div class="col-md-9">
						<input type="text"  class="form-control" value="" name="datefield" id="opening_end_date">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<?php for($i=0;$i<count($action_obj);$i++) { 
							$action_id = $action_obj[$i]["action_id"];
							?>
							<button type="button" class="btn btn-primary" onclick="save_request_opening('<?php echo $action_id; ?>','<?php echo $_POST['request_id']; ?>')"><?php echo $action_obj[$i]["action_title"]; ?></button>
						<?php } ?>
					</div>
				</div>	
				<div id="div_section_content"></div>
			</div>
		</div>
	</div>
</div>
