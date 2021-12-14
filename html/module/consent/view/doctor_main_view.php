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

require_once("../model/speciality.class.php");
require_once("../model/doctor.class.php");

$menu_itemObj									=new menu_item($_POST['menu_id']);
$doctorObj										=new doctor();
$doctor_Obj				    					=$doctorObj->list_of_doctors($_SESSION['employee_id']);

$branchObj 	= new branch();
$departmentObj 	= new department();
$specialityObj 	= new speciality();

?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_doctor_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Doctor</button>
        <?php //print_r($doctor_Obj); ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-12"></div>
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th style="width:10px">&nbsp;</th>
						<th style="width:10px">&nbsp;</th>
						<th>HR Number</th>
						<th>doctor Name</th>
						<th>doctor Email</th>
						<th>doctor Phone Number</th>
						<th>doctor Extension</th>
						<th>doctor Speciality</th>
						<th>doctor Branch</th>
						<th>doctor Department</th>
						<th>doctor Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($doctor_Obj);$i++) { 
							$branch_Obj	= $branchObj->get_customer_branch($doctor_Obj[$i]["doctor_branch_FK"]);
							$department_Obj	= $departmentObj->get_customer_departments($doctor_Obj[$i]["doctor_departement_FK"]);
							$speciality_Obj	= $specialityObj->get_doctor_speciality($doctor_Obj[$i]["doctor_specialty_FK"]);
						?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_doctor_form('<?php echo $doctor_Obj[$i]['doctor_id']; ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_this_doctor('<?php echo $doctor_Obj[$i]["doctor_id"]; ?>')"></i></td>
								
								<td><?php echo $doctor_Obj[$i]["doctor_hr_number"]; ?></td>
								<td><?php echo $doctor_Obj[$i]["doctor_name"]; ?></td>
								<td><?php echo $doctor_Obj[$i]["doctor_email"]; ?></td>
								<td><?php echo $doctor_Obj[$i]["doctor_phone_number"]; ?></td>
								<td><?php echo $doctor_Obj[$i]["doctor_extension"]; ?></td>
								<td><?php echo $speciality_Obj["speciality_title"]; ?></td>
								<td><?php echo $branch_Obj[0]["branch_name"]; ?></td>
								<td><?php echo $department_Obj["department_title"]; ?></td>
								<td>
								<?php if ($doctor_Obj[$i]["doctor_active"] ==1) {
									echo "Active";
								} else {
									echo "Inactive";
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