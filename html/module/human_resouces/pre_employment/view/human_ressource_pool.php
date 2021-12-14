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
require_once("../model/applicant.class.php");

$applicantObj				=new applicant();
$applicant_obj		=$applicantObj->list_applicants($_SESSION['employee_id']);
?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th>Ref</th>
						<th>Name</th>
						<th>Date</th>
						<th>Email</th>
						<th>Mobile</th>
						<th>Profession</th>
						<th>Resume</th>
						<th>Availability</th>
						<th>Source</th>
						<th>Assigning</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($applicant_obj);$i++) {
						$applicantinner_obj	=$applicantObj->liste_applicants_inner($applicant_obj[$i]["applicant_id"]);
						$professionObj = $applicantObj->get_profession($applicant_obj[$i]["applicant_profession_FK"]);
						$sourceObj = $applicantObj->get_source($applicant_obj[$i]["source_id_FK"]);
	$availabilityObj = $applicantObj->get_availability_type($applicant_obj[$i]["applicant_availibility_FK"]);
							?>
						<tr>
							<?php //print_r($availabilityObj) ; ?>
							<td><?php echo $applicant_obj[$i]["application_ref_number"]; ?></td>
							<td><?php echo $applicant_obj[$i]["applicant_first_name"]; ?>
								<?php echo $applicant_obj[$i]["applicant_last_name"]; ?>
								<?php echo $applicant_obj[$i]["applicant_suffix"]; ?>
							</td>
							<td><?php echo $applicant_obj[$i]["date_created"]; ?></td>
							<td><?php echo $applicant_obj[$i]["applicant_email"]; ?></td>
							<td><?php echo $applicant_obj[$i]["applicant_phone_number"]; ?></td>
							<td><?php if (isset($professionObj[0]['profession_title'])) {
								echo $professionObj[0]['profession_title']; 
							} else { echo "--"; }?></td>

							<td>
								<?php 
								$file_obj	= $applicantObj->get_applicant_file($applicant_obj[$i]["applicant_cv_id_FK"]);
								if ($applicant_obj[$i]["applicant_cv_id_FK"] != 0 ) { 
										$path = "../../assets/uploads/";
										$file = $path.$file_obj[0]['file_new_name'].".".$file_obj[0]['file_extension'];
									?>
									<a href="<?php echo $file; ?>" download>Resume</a>
								<?php } else if ($applicant_obj[$i]["applicant_cv_id_FK"] == 0) {
									echo "--";
								} ?>
							</td>

							<td><?php if (isset($availabilityObj[0]['availability_type_name'])) {
								echo $availabilityObj[0]['availability_type_name']; 
							} else { echo "--"; }?></td>

							<td><?php if (isset($sourceObj[0]['source_name'])) {
								echo $sourceObj[0]['source_name']; 
							} else { echo "--"; }?></td>


							<td><button type="button" class="btn btn-warning" onclick="assign_to_applicants('<?php echo $applicant_obj[$i]["applicant_id"]; ?>')">assign</button></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>