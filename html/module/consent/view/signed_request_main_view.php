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

require_once("../model/doctor.class.php");
require_once("../model/consent_request.class.php");
require_once("../model/consent_category.class.php");
require_once("../model/request_has_signee.class.php");
require_once("../model/consent_request_pending.class.php");

$menu_itemObj									=new menu_item($_POST['menu_id']);
$consent_request_pendingObj						=new request_has_signee();
$consent_request_pending_Obj				    =$consent_request_pendingObj->get_list_request($_SESSION['employee_id']);

$doctorObj = new doctor();
$employeeObj = new employee();

$consent_requestObj = new consent_request();
$consent_request_Obj = $consent_requestObj->list_of_consent_request_full();

?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <?php //print_r($consent_request_Obj); ?>
</div>

<div class="row">
    <div class="col-lg-12"></div>
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th>Patient File</th>
						<th>Concent Request</th>
						<th>Consent</th>
						<th>Branch</th>
						<th>Date</th>
						<th>Consent Request File</th>
						<th>Signed Request</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($consent_request_Obj);$i++) { ?>
							<tr>
								<td><?php echo $consent_request_Obj[$i]['patient_file']; ?></td>
								<td><?php echo $consent_request_Obj[$i]['consent_request_title']; ?></td>
								<td><?php echo $consent_request_Obj[$i]['consent_title']; ?></td></td>
								<td><?php echo $consent_request_Obj[$i]['branch_name']; ?></td>
								<td><?php echo $consent_request_Obj[$i]['consent_request_date_time']; ?></td>
								<td>
									<?php 
										$path = "../../../assets/uploads/";
										$file = $path.$consent_request_Obj[$i]['file_new_name'].".".$consent_request_Obj[$i]['file_extension'];
									?>
									<a href="#" onclick="show_required_file('<?php echo $file; ?>')">
									<?php echo $consent_request_Obj[$i]['file_new_name']; ?></a>
								</td>
								<td>
									<?php 
										$signed_file_Obj = $consent_requestObj->get_signed_file($consent_request_Obj[$i]['signed_file_id_FK']);
										if ($signed_file_Obj <> NULL ) {
											$file =  $signed_file_Obj['consent_signed_path'].$signed_file_Obj['consent_signed_name'].$signed_file_Obj['consent_signed_extension']; ?>
											<a href="#" onclick="show_required_file('<?php echo $file; ?>')"><?php echo $signed_file_Obj['consent_signed_name']; ?></a>
										<?php
										} else {
											echo "The File is Not Yet Signed";
										}
										
									 ?>
								</td>
								<td><?php echo $consent_request_Obj[$i]['consent_status_name']; ?></a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

