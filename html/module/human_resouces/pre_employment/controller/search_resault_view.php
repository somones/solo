<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../../../../../html/lib/model/employee.class.php");
require_once("../model/employment_request.class.php");



$requestObj			=new employment_request();
$request_Obj		=$requestObj->get_request_search($_POST['ref_request'],$_POST['date_start'],$_POST['date_end'],$_POST['branch_id']);
$emplyeeObj = new employee();
//print_r($request_Obj);
//print_r($request_Obj);

if (count($request_Obj)==0) { ?>
	<p>Sorry There is No Results for this Search</p>
<?php }else {


for($i=0;$i<count($request_Obj);$i++) {
	$request_inner_obj	=$emplyeeObj->get_this_employee($request_Obj[$i]["request_user_id_FK"]); ?>
	<?php print_r($request_inner_obj); ?>
	<tr>
		<td><?php echo $request_Obj[$i]["request_ref_number"]; ?></td>
		<td><?php echo $request_inner_obj["employee_full_name"]; ?></td>
		<td><?php echo $request_Obj[$i]["request_date_created"]; ?></td>
		<td><?php echo $request_Obj[$i]["request_job_title"]; ?></td>
		<td><?php echo $request_Obj[$i]["emp_group_name"]; ?></td>
		<td><?php echo $request_Obj[$i]["request_reason"]; ?></td>
		<td><?php echo $request_Obj[$i]["state_title"]; ?></td>
	</tr>
<?php	
}
}

?>