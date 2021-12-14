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

$requestObj			=new employment_request();
$request_obj		=$requestObj->list_of_employment_requests();
?>


<div class="page-header">
  <div class="row">
    <div class="col-md-4 text-xs-center text-md-left text-nowrap">
      <h1><i class="page-header-icon ion-ios-pulse-strong"></i>Edit Job Request</h1>
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
						<th>Edit</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($request_obj);$i++) { 
						$request_inner_obj		=$requestObj->list_of_employment_requests_inner($request_obj[$i]["request_id"]);
						//print_r($request_inner_obj);
							?>
						<tr>							
							<td><?php echo $request_obj[$i]["request_ref_number"]; ?></td>
							<td><?php echo $request_inner_obj["employee_full_name"]; ?></td>
							<td><?php echo $request_obj[$i]["request_date_created"]; ?></td>
							<td><?php echo $request_obj[$i]["request_job_title"]; ?></td>
							<td><?php echo $request_inner_obj["emp_group_name"]; ?></td>
							<td><?php echo $request_obj[$i]["request_description"]; ?></td>
							<td><?php echo $request_inner_obj["state_title"]; ?></td>
							<td><button type="button" class="btn btn-success" onclick="edit_request('<?php echo $request_obj[$i]["request_id"]; ?>')">Edit</button></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>