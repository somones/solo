<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../../../../html/lib/model/employee.class.php");
require_once("../model/messages.class.php");
require_once("../model/distribution_list.class.php");
require_once("../model/distribution_list_type.class.php");
require_once("../model/messages.class.php");
require_once("../model/contact.class.php");

$messageObj			=new messages();
$message_obj		=$messageObj->get_message_search_json($_POST['branch_id'],$_POST['type_id'],$_POST['list_type_id'],$_POST['list_id'],$_POST['employee_id'],$_POST['contact_id']);


$branchObj									=new branch();
$ListBranch 								= $branchObj->get_active_branches();

$distribution_list_type 					= new distribution_list_type();
$distribution_listTypObj 					= $distribution_list_type->list_of_distribution_list_type();

$distribution_list 							= new distribution_list();
$distribution_listObj 						= $distribution_list->list_of_distribution_list();

$employee 									= new employee();
$employeeObj 								= $employee->get_active_employee();

$contact 									= new contact();
$contact_obj 								= $contact->list_of_contacts();


if (count($message_obj)==0) { ?>
	<p>Sorry There is No Results for this Search</p>
<?php }else {

for($i=0;$i<count($message_obj);$i++)
{
	$employeeUserObj = $employee->get_messge_employee($message_obj[$i]["message_sender_user_id_FK"]);
	$distribution_list_Obj= $distribution_list->get_dl_list_name($message_obj[$i]["message_distribution_id_FK"]);
	$contactObj = $contact->list_reciever_contacts($message_obj[$i]["message_receiver_contact_id_FK"]);
?>
	<tr>
		<td><?php echo $message_obj[$i]["message_subject"]; ?></td>
		<td><?php echo $employeeUserObj["employee_full_name"]; ?></td>
		<td><?php 
			if ($message_obj[$i]["message_type_id_FK"] == 1) {
				echo "EMAIL";
			}else if ($message_obj[$i]["message_type_id_FK"] == 2) {
				echo "SMS";
			}
		?></td>
		<td><?php echo $contactObj["contact_name"]; ?></td>
		<td><?php 
			if ($message_obj[$i]["message_type_id_FK"] == 1) {
				echo $contactObj["contact_email"];
			}else if ($message_obj[$i]["message_type_id_FK"] == 2) {
				echo $contactObj["contact_mobile_number"];
			} ?>
		</td>
		<td><?php 
			if ($distribution_list_Obj == NULL) {
				echo "Standrad List";
			} else {
				echo $distribution_list_Obj[0]["list_name"];
			}?>
		</td>
		<td><?php echo $message_obj[$i]["date_time_sent"]; ?></td>
	</tr>
<?php	
}
}
?>