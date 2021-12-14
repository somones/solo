<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/employee.class.php");
require_once("../../../../html/lib/model/module.class.php");
require_once("../../../../html/lib/model/menu_item.class.php");
require_once("../../../../html/lib/model/department.class.php");

require_once("../model/consent_user_group.class.php");

$employeeObj			=new employee();
$employee_Obj			=$employeeObj->list_of_all_employee();

$groupObj = new consent_user_group();
$assigned = $groupObj->get_assigned_users($_POST['consent_group_id']);


?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"><?php //echo $role_name; ?></h4>
			</div>
			<div class="modal-body">
				<?php //print_r($assigned); ?>
				<table class="table table-primary" name="data_grid">
					<thead>
						<th style="width:10px"></th>
						<th style="width:400px">Employee Name</th>
						<th style="width:200px">Employee Position</th>
						<th style="width:200px">Employee Branch</th>
						<th style="width:200px">Employee Department</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($employee_Obj);$i++) { ?>
						<tr>
							<td><input value="<?php echo $employee_Obj[$i]["employee_id"]; ?>" <?php if(in_array($employee_Obj[$i]["employee_id"],$assigned)){  ?> checked="checked" <?php } ?> type="checkbox" id='employee_id_<?php echo $i; ?>'/></td>
							<td><?php echo $employee_Obj[$i]["employee_full_name"]; ?></td>
							<td><?php echo $employee_Obj[$i]["employee_job_title"]; ?></td>
							<td><?php echo $employee_Obj[$i]["branch_id_FK"]; ?></td>
							<td><?php echo $employee_Obj[$i]["department_id_FK"]; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php //print_r($employee_Obj); ?>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12" style="text-align:center">
						<input type="button" class="btn btn-primary" value="Update" onclick="update_contact_list_group('<?php echo $_POST['consent_group_id']; ?>','<?php echo count($employee_Obj); ?>')">
					</div>
				</div>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12" id="assign_roles_div"></div>
				</div>
			</div>			
		</div>
	</div>
</div>