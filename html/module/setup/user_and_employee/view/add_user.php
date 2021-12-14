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

?>
<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_user_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New User</button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12"><?php //print_r($_POST); ?></div>
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th style="width:10px">&nbsp;</th>
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
					</thead>
					<tbody>
						<?php for($i=0;$i<count($user_Obj);$i++) { ?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" onclick="get_user_form('<?php echo $user_Obj[$i]['employee_id']; ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer"  onclick="delete_this_user('<?php echo $user_Obj[$i]['employee_id']; ?>')"></i></td>	
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
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>