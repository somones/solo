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

$requestObj			=	new employment_request();
$request_obj		=	$requestObj->list_of_selected_employment_requests();

$applicantObj	=new applicant();
?>
<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<div class="page-header">
  <div class="row">
    <div class="col-md-4 text-xs-center text-md-left text-nowrap">
      <h1><i class="page-header-icon ion-ios-pulse-strong"></i>All Selected Request List</h1>
    </div>
  </div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th>Ref</th>
						<th>Name</th>
						<th>Date</th>
						<th>Title</th>
						<th>Group</th>
						<th>Description</th>
						<th>Status</th>
						<th>Match</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($request_obj);$i++) { 
						$request_inner_obj		=$requestObj->list_of_employment_requests_inner($request_obj[$i]["request_id"]);
							//print_r($request_inner_obj);
							$request_id = $request_obj[$i]["request_id"];
							$request_state_id = $request_obj[$i]["request_state_id_FK"];
							?>
						<tr>	
							<?php 
								$flow_obj 		= $applicantObj->get_flow_id($request_id);
								$flow_id = $flow_obj[0]['app_flow_id'];
								$applicant_obj		=$applicantObj->applicants_per_flow($flow_id); ?>
								<td><a href="#" onclick="open_unmatched_modal('<?php echo $request_id; ?>','<?php echo $request_state_id; ?>','<?php echo $applicant_obj[0]["applicant_id"]; ?>','<?php echo $flow_id; ?>')"><?php echo $request_obj[$i]["request_ref_number"]; ?><a></td>
							<td><?php echo $request_inner_obj["employee_full_name"]; ?></td>
							<td><?php echo $request_obj[$i]["request_date_created"]; ?></td>
							<td><?php echo $request_obj[$i]["request_job_title"]; ?></td>
							<td><?php echo $request_inner_obj["emp_group_name"]; ?></td>
							<td><?php echo $request_obj[$i]["request_description"]; ?></td>
							<td>
								<?php  
								if ($request_inner_obj["state_title"] == "Approved by management") {?>
									<p style="color: green"><?php echo $request_inner_obj["state_title"]; ?></p>
								<?php } elseif ($request_inner_obj["state_title"] == "Requested") {?>
									<p style="color: blue"><?php echo $request_inner_obj["state_title"]; ?></p>
								<?php } elseif ($request_inner_obj["state_title"] == "Rejected by management") {?>
									<p style="color: red"><?php echo $request_inner_obj["state_title"]; ?></p>
								<?php } else { echo $request_inner_obj["state_title"]; } ?>
							</td>
							<?php if ($request_obj[$i]["request_state_id_FK"] == 5) { ?>
								<td><?php echo $applicant_obj[0]['applicant_first_name']; ?></td>
							<?php }else{ ?>
								<td>--</td>
							<?php } ?>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>