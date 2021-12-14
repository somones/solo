<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/employee.class.php");
require_once("../../../../../html/lib/model/module.class.php");
require_once("../../../../../html/lib/model/menu_item.class.php");
require_once("../../../../../html/lib/model/department.class.php");
require_once("../model/role.class.php");

$thisroleObj		=new role($_POST['role_id']);
$role_name			=$thisroleObj->role_name;
$role_description	=$thisroleObj->role_description;
$employeeObj		=new employee();
$av_employee		=$employeeObj->get_all_employee();
$role_empl			=$thisroleObj->get_role_assigned_list();

?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"><?php echo $role_name; ?></h4>
			</div>
			<div class="modal-body">
				<?php
				//print_r($role_empl);
				?>
				<table class="table table-primary" name="data_grid">
					<thead>
						<th style="width:10px"></th>
						<th style="width:400px">User</th>
						<th style="width:200px">Department</th>
						<th style="width:200px">Job Title</th>
					</thead>
					<tbody>
						<?php
							for($i=0;$i<count($av_employee);$i++)
							{
						//echo $av_employee[$i]["employee_id"];
						?>
						<tr>
							<td><input value="<?php echo $av_employee[$i]["employee_id"]; ?>" <?php if(in_array($av_employee[$i]["employee_id"],$role_empl)){  ?> checked="checked" <?php } ?> type="checkbox" id='employee_checkbox_<?php echo $i; ?>'/></td>
							<td><?php echo $av_employee[$i]["employee_email"]; ?></td>
							<td></td>
							<td><?php echo $av_employee[$i]["employee_job_title"]; ?></td>
							
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			<?php
			//print_r($av_employee);
			?>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12" style="text-align:center">
						<input type="button" class="btn btn-primary" value="Update" onclick="update_role_users('<?php echo $_POST['role_id']; ?>','<?php echo count($av_employee); ?>')">
					</div>
				</div>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12" id="assign_roles_div">
						
					</div>
				</div>
			</div>			
			
		</div>
	</div>
</div>