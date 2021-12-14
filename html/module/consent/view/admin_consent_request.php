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
$consent_Obj				    	=$consentObj->get_user_request($_SESSION['employee_id']);

$conObj								=new consent();
$employeeObj						=new employee();
$doctorObj							=new doctor();

$consent_requestObj = new consent_request();
$consent_request_Obj = $consent_requestObj->list_of_consent_request_full();


$branchObj 	= new branch();
?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <br>
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
						<th>File</th>
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
											$employee_Obj = $employeeObj->get_this_employee($pat_obj['toked_by']);
											if ($pat_obj['signed'] == 1) { ?>
												<a href="#" onclick="show_admin_required_file('<?php echo $pat_obj["signed_doc_id"]; ?>','<?php echo $pat_obj["document_id_FK"]; ?>','<?php echo $pat_obj["request_id_FK"]; ?>','<?php echo $pat_obj["user_id_FK"]; ?>','0','<?php echo $pat_obj["user_type_id_FK"]; ?>','<?php echo $pat_obj["consent_partially_signed"]; ?>','<?php echo $con_Obj["pat_x"]; ?>','<?php echo $con_Obj["pat_y"]; ?>','<?php echo $con_Obj["pat_w"]; ?>','<?php echo $con_Obj["pat_page"]; ?>','Patient','0')"><i class="fa fa-refresh fa-2x" style="color: red; font-size: 18px"></i></a>
												<i class="fa fa-check-circle fa-2x" style="color: green; font-size: 18px"></i>&nbsp;(<b><?php echo $employee_Obj['employee_full_name']; ?>)</b>
											<?php } else { ?>
												<?php if ($pat_obj['document_id_FK'] <> 0) { ?>
													<?php //print_r($con_Obj); ?>
													<a href="#" onclick="show_admin_required_file('<?php echo $pat_obj["signed_doc_id"]; ?>','<?php echo $pat_obj["document_id_FK"]; ?>','<?php echo $pat_obj["request_id_FK"]; ?>','<?php echo $pat_obj["user_id_FK"]; ?>','<?php echo $pat_obj["signed"]; ?>','<?php echo $pat_obj["user_type_id_FK"]; ?>','<?php echo $pat_obj["consent_partially_signed"]; ?>','<?php echo $con_Obj["pat_x"]; ?>','<?php echo $con_Obj["pat_y"]; ?>','<?php echo $con_Obj["pat_w"]; ?>','<?php echo $con_Obj["pat_page"]; ?>','Patient','0')"><i class="fa fa-times-circle fa-2x" style="color: red; font-size: 18px"></i>&nbsp;<b>(Take Patient Signature)</b></a><br>
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
										$admin_obj = $consentObj->get_consent_patient(1,$consent_Obj[$i]['request_id_FK']);
											if ($_SESSION['employee_id'] == $admin_obj['user_id_FK']) {
												$employee_Obj = $employeeObj->get_this_employee($admin_obj['user_id_FK']);
												if ($admin_obj['signed'] == 1) { ?>
													
													<a href="#" onclick="show_admin_required_file('<?php echo $consent_Obj[$i]["signed_doc_id"]; ?>','<?php echo $consent_Obj[$i]["consent_file_id_FK"]; ?>','<?php echo $consent_Obj[$i]["request_id_FK"]; ?>','<?php echo $admin_obj['user_id_FK']; ?>','0','1','<?php echo $consent_Obj[$i]["consent_partially_signed"]; ?>','<?php echo $con_Obj["admin_x"]; ?>','<?php echo $con_Obj["admin_y"]; ?>','<?php echo $con_Obj["admin_w"]; ?>','<?php echo $con_Obj["admin_page"]; ?>','<?php echo $employee_Obj['employee_full_name']; ?>','<?php echo $employee_Obj['employee_number']; ?>')"><i class="fa fa-refresh fa-2x" style="color: red; font-size: 18px"></i></a>

													<i class="fa fa-check-circle fa-2x" style="color: green; font-size: 18px"></i>&nbsp;<b>(<b><?php echo $employee_Obj['employee_full_name']; ?>) </b>

											<?php } else { ?>
												<a href="#" onclick="show_admin_required_file('<?php echo $consent_Obj[$i]["signed_doc_id"]; ?>','<?php echo $consent_Obj[$i]["consent_file_id_FK"]; ?>','<?php echo $consent_Obj[$i]["request_id_FK"]; ?>','<?php echo $admin_obj['user_id_FK']; ?>','<?php echo $admin_obj['signed']; ?>','1','<?php echo $consent_Obj[$i]["consent_partially_signed"]; ?>','<?php echo $con_Obj["admin_x"]; ?>','<?php echo $con_Obj["admin_y"]; ?>','<?php echo $con_Obj["admin_w"]; ?>','<?php echo $con_Obj["admin_page"]; ?>','<?php echo $employee_Obj['employee_full_name']; ?>','<?php echo $employee_Obj['employee_number']; ?>')"><i class="fa fa-times-circle fa-2x" style="color: red; font-size: 18px"></i>&nbsp;<b>(<b><?php echo $employee_Obj['employee_full_name']; ?>)</b>
												</a>
											<?php }
											} else {
												if ($admin_obj['signed'] == 1) { 
													$employee_Obj = $employeeObj->get_this_employee($admin_obj['user_id_FK']); ?>
												<i class="fa fa-check-circle fa-2x" style="color: green; font-size: 18px"> </i>&nbsp;<b>(<?php echo $employee_Obj['employee_full_name']; ?>) </b>
											<?php } else { 
												$employee_Obj = $employeeObj->get_this_employee($admin_obj['user_id_FK']); ?>
												<i class="fa fa-times-circle fa-2x" style="color: red; font-size: 18px"></i>&nbsp;<b>(<?php echo $employee_Obj['employee_full_name']; ?>) </b>
											<?php }
											}
									} else if ($con_Obj['admin_signature_required'] == 0) {
										echo "Admin Signature Not Required";
									}?>
								</td>
								<td>
									<?php if ($con_Obj['doctor_signature_required'] == 1) {
										$doc_obj = $consentObj->get_consent_patient(2,$consent_Obj[$i]['request_id_FK']);
											if ($_SESSION['employee_id'] == $doc_obj['user_id_FK']) {
												$doctor_Obj = $doctorObj->get_linked_doctor($doc_obj['user_id_FK']);
												if ($doc_obj['signed'] == 1) { ?>
												<a href="#" onclick="show_admin_required_file('<?php echo $consent_Obj[$i]["signed_doc_id"]; ?>','<?php echo $consent_Obj[$i]["consent_file_id_FK"]; ?>','<?php echo $consent_Obj[$i]["request_id_FK"]; ?>','<?php echo $doc_obj['user_id_FK']; ?>','0','2','<?php echo $consent_Obj[$i]["consent_partially_signed"]; ?>','<?php echo $con_Obj["doc_x"]; ?>','<?php echo $con_Obj["doc_y"]; ?>','<?php echo $con_Obj["doc_w"]; ?>','<?php echo $con_Obj["doc_page"]; ?>','<?php echo $doctor_Obj['doctor_name']; ?>','<?php echo $doctor_Obj['doctor_hr_number']; ?>')"><i class="fa fa-refresh fa-2x" style="color: red; font-size: 18px">&nbsp;</i></a>


												<i class="fa fa-check-circle fa-2x" style="color: green; font-size: 18px"></i>&nbsp;<b>(<?php 
												$doctor_Obj = $doctorObj->get_linked_doctor($doc_obj['user_id_FK']);
												echo $doctor_Obj['doctor_name']; ?>)</b>
											<?php } else { 
												$doctor_Obj = $doctorObj->get_linked_doctor($doc_obj['user_id_FK']); ?>
												<a href="#" onclick="show_admin_required_file('<?php echo $consent_Obj[$i]["signed_doc_id"]; ?>','<?php echo $consent_Obj[$i]["consent_file_id_FK"]; ?>','<?php echo $consent_Obj[$i]["request_id_FK"]; ?>','<?php echo $doc_obj['user_id_FK']; ?>','<?php echo $doc_obj['signed']; ?>','2','<?php echo $consent_Obj[$i]["consent_partially_signed"]; ?>','<?php echo $con_Obj["doc_x"]; ?>','<?php echo $con_Obj["doc_y"]; ?>','<?php echo $con_Obj["doc_w"]; ?>','<?php echo $con_Obj["doc_page"]; ?>','<?php echo $doctor_Obj['doctor_name']; ?>','<?php echo $doctor_Obj['doctor_hr_number']; ?>')"><i class="fa fa-check-circle fa-2x" style="color: red; font-size: 18px">&nbsp;</i><b>(<?php echo $doctor_Obj['doctor_name']; ?>)</b></a>
											<?php }
											} else {
												if ($doc_obj['signed'] == 1) { ?>
												<i class="fa fa-check-circle fa-2x" style="color: green; font-size: 18px"></i>&nbsp;<b>(<?php 
												$doctor_Obj = $doctorObj->get_linked_doctor($doc_obj['user_id_FK']);
												echo $doctor_Obj['doctor_name']; ?>)</b>
											<?php } else { ?>
												<i class="fa fa-times-circle fa-2x" style="color: red; font-size: 18px"></i>&nbsp;<b>(<?php 
												$doctor_Obj = $doctorObj->get_linked_doctor($doc_obj['user_id_FK']);
												echo $doctor_Obj['doctor_name']; ?>)</b>
											<?php }
											}
									} else if ($con_Obj['doctor_signature_required'] == 0) {
										echo "Doctor Signature Not Required";
									}?>
								</td>
								<td>
									<?php 
										$signed_file_Obj = $consent_requestObj->get_signed_file($consent_Obj[$i]["signed_doc_id"]);
										if ($signed_file_Obj <> NULL ) {
											$file =  $signed_file_Obj['consent_signed_path'].$signed_file_Obj['consent_signed_name'].$signed_file_Obj['consent_signed_extension']; ?>
											<a href="<?php echo $file; ?>" target="_blank">Signed File</a>
										<?php
										} else {
											echo "The File is Not Yet Signed";
										}
										
									 ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>