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
require_once("../model/applicant.class.php");
require_once("../model/employment_request.class.php");

$applicantObj         = 	new applicant($_POST['applicant_id']);
$applicant_Obj        = 	$applicantObj->list_opning_flow();
$applicant_id 		  = 	$_POST['applicant_id'];

?>

<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Assign To Request</h4>
				<h1><?php //echo $_POST['applicant_id']; ?></h1>
			</div>
			<div class="modal-body">
				<div class="table table-responsive">
					<table class="table table-responsive table-bordered table-primary" name="data_grid">
						<thead>
							<th>--</th>
							<th>Request Ref</th>
							<th>Title</th>
							<th>Start Date</th>
							<th>End Date</th>
						</thead>
						<tbody>
							<?php for($i=0;$i<count($applicant_Obj);$i++) { ?>
							<tr>				
								<td><input class="Get_this" type="checkbox" id="opening_id_FK" value="<?php echo $applicant_Obj[$i]["app_flow_id"]; ?>"></td>
								<td><?php echo $applicant_Obj[$i]["request_ref_number"]; ?></td>
								<td><?php echo $applicant_Obj[$i]["opening_title"]; ?></td>
								<td><?php echo $applicant_Obj[$i]["opening_start_date"]; ?></td>
								<td><?php echo $applicant_Obj[$i]["opening_end_date"]; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="form-group">
			        <div class="col-md-12">
			         <textarea id="opening_description" class="form-control" placeholder="Notes"></textarea>
			        </div>
			    </div>
			    <?php //print_r($applicant_Obj); ?>
				<div class="form-group">
					<button type="button" class="btn btn-lg btn-warning btn-block" 
						onclick="save_assigned_flow('<?php echo $applicant_id; ?>')">Save</button>
				</div>	
				<div id="div_section_content"></div>
			</div>
		</div>
	</div>
</div>
