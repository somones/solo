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

$applicantObj         = 	new applicant();
$applicant_Obj        = 	$applicantObj->list_opning_interview();

$requestObj			=	new employment_request();
$request_obj		=	$requestObj->list_of_employment_requests();

//print_r($applicant_Obj);
?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th>Request Ref</th>
						<th>Title</th>
						<th>Details</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Applicants</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($applicant_Obj);$i++) {
							$id = $applicant_Obj[$i]["app_flow_id"];
							$request_inner_obj		=$requestObj->list_of_employment_requests_inner($applicant_Obj[$i]["request_id"]);
							//print_r($applicant_Obj[$i]['request_state_id_FK']);
							$startDate = explode(' ', $applicant_Obj[$i]["opening_start_date"]);
							$opening_start_date  = $startDate[0];

							$endDate = explode(' ', $applicant_Obj[$i]["opening_end_date"]);
							$opening_end_date  = $endDate[0];
						?>
						<tr>
							<?php if ($request_obj[$i]["request_state_id_FK"] = 4) { ?>
							
							<td>
								<a href="#" onclick="matching_modal('<?php echo $applicant_Obj[$i]["request_id"]; ?>','<?php echo $applicant_Obj[$i]['request_state_id_FK']; ?>')">
									<?php echo $applicant_Obj[$i]["request_ref_number"]; ?></a>
							</td>
							
							<?php } else if ($request_obj[$i]["request_state_id_FK"] = 5){ 
								
								$flow_obj 		= $applicantObj->get_flow_id($applicant_Obj[$i]["request_id"]);
								$flow_id = $flow_obj[0]['app_flow_id'];
								$applicant_obj		=$applicantObj->applicants_per_flow($flow_id); ?>
							
							<td>
								<a href="#" onclick="open_unmatched_modal('<?php echo $applicant_Obj[$i]["request_id"]; ?>','<?php echo $applicant_Obj[$i]['request_state_id_FK']; ?>','<?php echo $applicant_obj[0]["applicant_id"]; ?>','<?php echo $flow_id; ?>')">

									<?php echo $applicant_Obj[$i]["request_ref_number"]; ?></a>
							</td>
							
							<?php } else { ?>
								<td><p>--</p></td>
							<?php } ?>

							<td><?php echo $applicant_Obj[$i]["request_job_title"]; ?></td>
							<td style="width: 50%"><?php echo $applicant_Obj[$i]["request_description"]; ?></td>
							<td><?php echo $opening_start_date ; ?></td>
							<td><?php echo $opening_end_date; ?></td>
							<td><a href="#" onclick="get_list_applicants('<?php echo $id; ?>', '<?php echo $applicant_Obj[$i]["request_state_id_FK"]; ?>','<?php echo  $applicant_Obj[$i]["request_id_FK"]; ?>');">
							<?php 
								echo $applicantObj->nb_applicants_per_flow($id);
							 ?>
							</a></td>
							<td><?php echo $request_inner_obj["state_title"]; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php //print_r($applicant_Obj) ?>
			</div>
		</div>
	</div>
</div>