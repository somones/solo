<?php
session_start();
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

require_once("../model/distribution_list.class.php");
require_once("../model/distribution_list_type.class.php");
require_once("../model/messages.class.php");
require_once("../model/contact.class.php");

$menu_itemObj								= new menu_item($_POST['menu_id']);

$branchObj									= new branch();
$ListBranch 								= $branchObj->get_active_branches();

$distribution_list_type 					= new distribution_list_type();
$distribution_listTypObj 					= $distribution_list_type->list_of_distribution_list_type();

$distribution_list 							= new distribution_list();
$distribution_listObj 						= $distribution_list->list_of_distribution_list();

$employee 									= new employee();
$employeeObj 								= $employee->get_active_employee();

$contact 									= new contact();
$contact_obj 								= $contact->list_of_contacts();



$message 									= new messages();
$messageListObj 							= $message->list_of_all_messages();
$messageObj 								= $message->get_message_search_json_test();
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="page-header">
				<h1>&nbsp;&nbsp;<?php echo $menu_itemObj->item_title; ?></h1>
			</div>	
			<div id="search_div_result"></div>
				<div class="row">
					<div class="col-lg-3">
						<label class="label-control">Branch</label>
						<Select class="input-sm  form-control" name="branch_id" id="branch_id">
							<option value="">All Branchs</option>
							<?php 
							for($i=0;$i<count($ListBranch);$i++) { ?>
								<option value="<?php echo $ListBranch[$i]["branch_id"]; ?>">
									<?php echo $ListBranch[$i]["branch_name"]; ?>	
								</option>
							<?php } ?>
						</select>
					</div>
					
					<div class="col-lg-3">
						<label class="label-control">Sending Type</label>
						<Select class="input-sm  form-control" name="type_id" id="type_id">
							<option value="">All</option>
							<option value="1">EMAIL</option>
							<option value="2">SMS</option>
						</select>
					</div>
					<div class="col-lg-3">
						<label class="label-control">Distribution List Type</label>
						<Select class="input-sm  form-control" name="list_type_id" id="list_type_id">
							<option value="">All Distribution List Type</option>
							<?php 
							for($i=0;$i<count($distribution_listTypObj);$i++) { ?>
								<option value="<?php echo $distribution_listTypObj[$i]["list_type_id"]; ?>">
									<?php echo $distribution_listTypObj[$i]["list_type_name"]; ?>	
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="col-lg-3">
						<label class="label-control">Distribution List</label>
						<Select class="input-sm  form-control" name="list_id" id="list_id">
							<option value="">All Distribution List</option>
							<?php 
							for($i=0;$i<count($distribution_listObj);$i++) { ?>
								<option value="<?php echo $distribution_listObj[$i]["list_id"]; ?>">
									<?php echo $distribution_listObj[$i]["list_name"]; ?>	
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="col-lg-3">
						<label class="label-control">Sender</label>
						<select  class='input-sm custom-select form-control' id="employee_id">
							<option value="">All User</option>
							<?php for($i=0;$i<count($employeeObj);$i++) { ?>
								<option value="<?php echo $employeeObj[$i]["employee_id"]; ?>"><?php echo $employeeObj[$i]["employee_full_name"]; ?></option>
							<?php } ?>
						</select>	
					</div>	
					
					<div class="col-lg-3">
						<label class="label-control">Receiver Value</label>
						<input type="text" class="input-sm  form-control" id="contact_id" />
					</div>
					
					<div class="col-lg-3">
						<label class="label-control">&nbsp;</label>
						<div class="form-control" style="border:none;bg-color:none"><input type="button" class="input-sm btn btn-primary" onclick="get_result_of_message_search()" value="search"/></div>
					</div>
					
				</div>
				<div class="row">
					<hr/>
				</div>
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
				<thead>
					<th>Message Subject</th>
					<th>Message Sender</th>
					<th>Message Type</th>
					<th>Message Receiver</th>
					<th>Receiver Number</th>
					<th>Message List</th>
					<th>Date Sent</th>
				</thead>

				<tbody id="table_result">
				<?php for($i=0;$i<count($messageListObj);$i++) { 
					$employeeUserObj = $employee->get_messge_employee($messageListObj[$i]["message_sender_user_id_FK"]);
					$distribution_list_Obj= $distribution_list->get_dl_list_name($messageListObj[$i]["message_distribution_id_FK"]);
					$contactObj = $contact->list_reciever_contacts($messageListObj[$i]["message_receiver_contact_id_FK"]);
					?>
					<tr>
						<td><?php echo $messageListObj[$i]["message_subject"]; ?></td>
						<td><?php echo $employeeUserObj["employee_full_name"]; ?></td>
						<td><?php 
							if ($messageListObj[$i]["message_type_id_FK"] == 1) {
								echo "EMAIL";
							}else if ($messageListObj[$i]["message_type_id_FK"] == 2) {
								echo "SMS";
							}
						?></td>
						<td>
							<?php 
							if($contactObj["contact_name"] == NULL){
								echo "Standard Receiver";
							}else {
								echo $contactObj["contact_name"];
							} ?>
						</td>
						<td><?php
						if($contactObj["contact_name"] != NULL){
								if ($messageListObj[$i]["message_type_id_FK"] == 1) {
									echo $contactObj["contact_email"];
								}else if ($messageListObj[$i]["message_type_id_FK"] == 2) {
									echo $contactObj["contact_mobile_number"];
								}
							}else {
								echo "---";
							}
							
						?></td>
						<td><?php 
							if ($distribution_list_Obj == NULL) {
								echo "Standrad List";
							} else {
								echo $distribution_list_Obj[0]["list_name"];
							}?>
						</td>
						<td><?php echo $messageListObj[$i]["date_time_sent"]; ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>