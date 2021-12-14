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
$request_obj		=$requestObj->list_of_my_employment_requests($_SESSION['employee_id']);

$branchObj			=new branch();
$branch_obj			=$branchObj->get_active_branches();
?>

<div class="page-header">
  <div class="row">
    <div class="col-md-4 text-xs-center text-md-left text-nowrap">
      <h1><i class="page-header-icon ion-ios-pulse-strong"></i>My Job Requests</h1>
      <?php //print_r($branch_obj); ?>
    </div>
  </div>
</div>



<div class="row">
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="row">
	<div class="col-lg-3">
	<label class="label-control">Branch</label>
	<select class="form-control select2-example" id="branch_id" >
		<option  value="">All Branch</option>
        <?php for($i=0;$i<count($branch_obj);$i++) { ?>
            <option  value="<?php echo $branch_obj[$i]["branch_id"]; ?>"><?php echo $branch_obj[$i]["branch_name"]; ?></option>
        <?php } ?>
    </select>	
</div>	

	<div class="col-lg-3">
		<label class="label-control">Reference</label>
		<input type="text" class="input-sm  form-control" id="ref_request" list="search_result"/>
		<div id="search_result" ></div>
	</div>
		
	<script type="text/javascript">//$("[id='bs-datepicker-range']").datepicker({format: 'yyyy-mm-dd'});</script>
	<div class="col-lg-5">
		<label class="label-control">Date Created</label>
		<div class="input-daterange input-group" id="bs-datepicker-range" >
			<input type="text" class="input-sm form-control" id="date_start" name="date_time_value">
			
			<span class="input-group-addon">to</span>
			<input type="text" class="input-sm form-control" id="date_end" name="date_time_value" >
		</div>
	</div>
	
	
	
	<div class="col-lg-1">
		<label class="label-control">&nbsp;</label>
		<div class="form-control" style="border:none;bg-color:none"><input type="button" class="input-sm btn btn-primary" onclick="get_result_of_this_search()" value="search"/></div>
	</div>
	
</div>
<div class="row">
	<hr/>
</div>
<?php //print_r($request_obj); ?>
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th>Ref</th>
						<th>Name</th>
						<th>YYYY-MM-DD</th>
						<th>Title</th>
						<th>Group</th>
						<th>Description</th>
						<th>Status</th>
					</thead>
					<tbody id="table_result">
						<?php for($i=0;$i<count($request_obj);$i++) { 
							$request_inner_obj	=$requestObj->list_of_employment_requests_inner($request_obj[$i]["request_id"]); ?>
						<tr>							
							<td><?php echo $request_obj[$i]["request_ref_number"]; ?></td>
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
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>