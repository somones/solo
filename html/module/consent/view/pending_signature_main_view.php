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
require_once("../model/consent.class.php");
require_once("../model/consent_request.class.php");
require_once("../model/request_has_signee.class.php");

$menu_itemObj						=new menu_item($_POST['menu_id']);
$consentObj							=new request_has_signee();
$consent_Obj				    	=$consentObj->get_doc_request();

$branchObj 							= new branch();
$conObj								=new consent(); 

$employeeObj						=new employee();
$doctorObj							=new doctor();
?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <br>
    Remove This
</div>

<div class="row">
    <div class="col-lg-12"></div>
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th>Patient File</th>
						<th>Request</th>
						<th>Patient</th>
						<th>Administration</th>
						<th>Doctor</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($consent_Obj);$i++) { 
							$con_Obj =$conObj->get_this_consent($consent_Obj[$i]['consent_id_FK']); ?>
							<tr>
								<td><?php echo $consent_Obj[$i]["patient_file"]; ?></td>
								<td><?php echo $consent_Obj[$i]["consent_request_title"]; ?></td>

								<td>
									<?php if ($con_Obj['patient_signature_required'] == 1) {
											$pat_obj = $consentObj->get_consent_patient(3,$consent_Obj[$i]['request_id_FK']);
											if ($pat_obj['signed'] == 1) { ?>
												<i class="fa fa-check-circle fa-2x" style="color: green"></i> Signed by the patient
											<?php } else { ?>
												
												<?php if ($pat_obj['document_id_FK'] != 0) {
												$file = $pat_obj['signed_doc_id']; ?>
													<a href="#" onclick="show_admin_required_file('<?php echo $pat_obj["signed_doc_id"]; ?>','<?php echo $pat_obj["document_id_FK"]; ?>','<?php echo $pat_obj["request_id_FK"]; ?>','<?php echo $pat_obj["user_id_FK"]; ?>','<?php echo $pat_obj["signed"]; ?>','<?php echo $pat_obj["user_type_id_FK"]; ?>','<?php echo $pat_obj["consent_partially_signed"]; ?>')"><i class="fa fa-times-circle fa-2x" style="color: red; font-size: 18px"></i>&nbsp;Take Patient Signature</a><br>
											<?php } else {
												$file = $pat_obj['document_id_FK'];
											}
											 }
									} else if ($con_Obj['patient_signature_required'] == 0) {
										echo "Signature Not Required";
									} ?>

								</td>
								<td>
									<?php if ($con_Obj['admin_signature_required'] == 1) {
										$pat_obj = $consentObj->get_consent_patient(1,$consent_Obj[$i]['request_id_FK']);

											if ($pat_obj['signed'] == 1) { ?>
												<i class="fa fa-check-circle fa-2x" style="color: green"></i> Signed by <b><?php 
													$employee_Obj = $employeeObj->get_this_employee($pat_obj['user_id_FK']);
													echo $employee_Obj['employee_full_name']; ?></b>
											<?php } else { ?>
												<i class="fa fa-times-circle fa-2x" style="color: red"></i> Sent to <b><?php 
													$employee_Obj = $employeeObj->get_this_employee($pat_obj['user_id_FK']);
													echo $employee_Obj['employee_full_name']; ?></b>
											<?php }
									} else if ($con_Obj['admin_signature_required'] == 0) {
										echo "Signature Not Required";
									}?>
								</td>
								<td>
									<?php if ($con_Obj['doctor_signature_required'] == 1) {
										$pat_obj = $consentObj->get_consent_patient(2,$consent_Obj[$i]['request_id_FK']);
											if ($pat_obj['signed'] == 1) { ?>
												<i class="fa fa-check-circle fa-2x" style="color: green"></i> Signed By <b><?php 
												$doctor_Obj = $doctorObj->get_linked_doctor($pat_obj['user_id_FK']);
												echo $doctor_Obj['doctor_name']; ?></b>
											<?php } else { ?>
												<i class="fa fa-times-circle fa-2x" style="color: red"></i> Sent to <b><?php 
												$doctor_Obj = $doctorObj->get_linked_doctor($pat_obj['user_id_FK']);
												echo $doctor_Obj['doctor_name']; ?></b>
											<?php }
									} else if ($con_Obj['doctor_signature_required'] == 0) {
										echo "Signature Not Required";
									}?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>