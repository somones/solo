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
require_once("../model/user.class.php");

$menu_itemObj			=new menu_item($_POST['menu_id']);
$userObj				=new user();
$user_Obj				=$userObj->list_of_user($_SESSION['employee_id']);

$branchObj				=new branch();
$branch_Obj				=$branchObj->get_active_branches();

$role_Obj				=$userObj->get_list_roles($_SESSION['employee_id']);

$departmentObj			=new department();
$department_Obj			=$departmentObj->get_active_departments($_SESSION['employee_id']);

?>
<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
</div>
<div class="row">
	<div class="col-lg-12">

		<div class="panel-body">
			<div class="row">
				<div class="col-lg-2">
					<label class="label-control">Employee Name</label>
					<input type="text" class="input-sm  form-control" id="employee_name"/>
				</div>
				<div class="col-lg-2">
					<label class="label-control">Jobe Title</label>
					<input type="text" class="input-sm  form-control" id="job_title"/>
				</div>
				<!--<div class="col-lg-2">
					<label class="label-control">User Role</label>
					<select class="form-control" id="role_id">
			            <option value="" selected="selected">Select...</option>
			            <?php for($i=0;$i<count($role_Obj);$i++) { ?>
			            <option value="<?php echo $role_Obj[$i]["role_id"]; ?>">
			            	<?php echo $role_Obj[$i]["role_name"]; ?>
			            </option>
			            <?php } ?>
			        </select>
				</div>-->
				<div class="col-lg-2">
					<label class="label-control">Hr Number</label>
					<input type="text" class="input-sm  form-control" id="hr_number"/>
				</div>
				<div class="col-lg-2">
					<label class="label-control">Email</label>
					<input type="text" class="input-sm  form-control" id="employee_email"/>
				</div>
				<div class="col-lg-2">
					<label class="label-control">User Branch</label>
					<select class="form-control" id="branch_id">
			            <option value="" selected="selected">Select...</option>
			            <?php for($i=0;$i<count($branch_Obj);$i++) { ?>
			            <option value="<?php echo $branch_Obj[$i]["branch_id"]; ?>">
			            	<?php echo $branch_Obj[$i]["branch_name"]; ?>
			            </option>
			            <?php } ?>
			        </select>
				</div>
				<div class="col-lg-2">
					<label class="label-control">User Department</label>
					<select class="form-control" id="department_id">
			            <option value="" selected="selected">Select...</option>
			            <?php for($i=0;$i<count($department_Obj);$i++) { ?>
			            <option value="<?php echo $department_Obj[$i]["department_id"]; ?>">
			            	<?php echo $department_Obj[$i]["department_title"]; ?>
			            </option>
			            <?php } ?>
			        </select>
				</div>
				<div class="col-lg-2">
					<label class="label-control">Profile</label>
					<select class="form-control" id="isComplete">
			            <option value="" selected="selected">Select...</option>
			            <option value="1">Profile Completed</option>
			            <option value="0">Incomplete profile</option>
			        </select>
				</div>
				<div class="col-lg-2">
					<label class="label-control">Status</label>
					<select class="form-control" id="isActive">
			            <option value="" selected="selected">Select...</option>
			            <option value="1">Active</option>
			            <option value="0">Inactive profile</option>
			        </select>
				</div>
				
				<div class="col-lg-2">
					<label class="label-control">&nbsp;</label>
					<div class="form-control" style="border:none;bg-color:none"><input type="button" class="input-sm btn btn-primary" onclick="get_result()" value="Search"/></div>
				</div>
			</div>
			<hr>
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th style="width:10px">&nbsp;</th>
						<th>Employee Name</th>
						<th>Job Title</th>
						<th>User Role</th>
						<th>HR Number</th>
						<th>Email</th>
						<th>Branch</th>
						<th>Department</th>
						<th>Profile Completed</th>
						<th>Status</th>
						<th>Login</th>
					</thead>
					<tbody id="table_result">
						<?php for($i=0;$i<count($user_Obj);$i++) { ?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" onclick="get_user_form('<?php echo $user_Obj[$i]['employee_id']; ?>')"></i></td>		
								<td><?php echo $user_Obj[$i]["employee_full_name"]; ?></td>
								<td><?php echo $user_Obj[$i]["employee_job_title"]; ?></td>
								<td><?php echo $userObj->get_user_role($user_Obj[$i]["employee_id"]); ?></td>
								<td><?php echo $user_Obj[$i]["employee_number"]; ?></td>
								<td><?php echo $user_Obj[$i]["employee_email"]; ?></td>
								<td><?php echo $user_Obj[$i]["branch_name"]; ?></td>
								<td><?php echo $user_Obj[$i]["department_title"]; ?></td>
								<td><?php 
									if ($user_Obj[$i]["profile_completed"] == 1) { ?>
										<p style="color: green">Profile Completed</p>
									<?php } else { ?>
										<p style="color: red">Incomplete profile</p>
									<?php } ?>
								</td>
								<td><?php
									if ($user_Obj[$i]["employee_active"] == 1) { ?>
										<p style="color: green">Active</p>
									<?php } else { ?>
										<p style="color: red">Inactive</p>
									<?php } ?>
								</td>
								<td><a href="#" onclick="new_session('<?php echo $user_Obj[$i]["employee_id"]; ?>')">Login</a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>