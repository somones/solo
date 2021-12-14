<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/user.class.php");

$userObj			=new user();
$user_Obj			=$userObj->get_search_result($_POST['employee_name'],$_POST['job_title'],$_POST['hr_number'],$_POST['employee_email'],$_POST['branch_id'],$_POST['department_id'],$_POST['isComplete'],$_POST['isActive']);

if (count($user_Obj)==0) { ?>
	<br>
	<td colspan="11">Sorry There is No Results for this Search</td>
<?php } else {

for($i=0;$i<count($user_Obj);$i++) { ?>
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
<?php } 
}
?>