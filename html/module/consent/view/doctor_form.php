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
require_once("../model/speciality.class.php");

$doctorObj							= new doctor();

$countryObj 						= $doctorObj->get_countries_list();
$titleObj 							= $doctorObj->get_titles_list();
$genderObj 							= $doctorObj->get_gender_list();

$branchObj 	= new branch();
$branch_Obj	= $branchObj->get_active_branches();

$departmentObj 	= new department();
$department_Obj	= $departmentObj->get_active_departments();

$specialityObj 	= new speciality();
$speciality_Obj	= $specialityObj->get_active_speciality();

$employeeObj 	= new employee();
$employee_Obj	= $employeeObj->get_active_employee();


if($_POST["doctor_id"]==-1)
{
	$doctor_title				="";
	$doctor_name				="";
	$doctor_email				="";
	$doctor_phone_number		="";
	$doctor_extension			="";
	$doctor_hr_number			="";
	$doctor_branch_FK			=array();
	$doctor_departement_FK		="";
	$doctor_specialty_FK		="";
	$doctor_experience			="";
	$doctor_nationality			="";
	$doctor_gender				="";
	$user_id_FK					="";

}
else {

	$doctorObj= new doctor($_POST['doctor_id']);

	$doctor_title					=$doctorObj->doctor_title;
	$doctor_name					=$doctorObj->doctor_name;
	$doctor_email					=$doctorObj->doctor_email;
	$doctor_phone_number			=$doctorObj->doctor_phone_number;
	$doctor_extension				=$doctorObj->doctor_extension;
	$doctor_hr_number				=$doctorObj->doctor_hr_number;
	$doctor_branch_FK				=$doctorObj->get_doctor_branch($_POST['doctor_id']);
	$doctor_departement_FK			=$doctorObj->doctor_departement_FK;
	$doctor_specialty_FK			=$doctorObj->doctor_specialty_FK;
	$doctor_experience				=$doctorObj->doctor_experience;
	$doctor_nationality				=$doctorObj->doctor_nationality;
	$doctor_gender					=$doctorObj->doctor_gender;
	$user_id_FK						=$doctorObj->user_id_FK;
}
?>
<script type="text/javascript" src="../assets/JS/contact.js"/></script>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit / Doctor</h4>
				<?php //print_r($branch_id_FK); ?>
			</div>

			<div class="modal-body">
				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Title: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="doctor_title">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($titleObj);$i++) { ?>
			                <option <?php if($titleObj[$i]["personal_id"] == $doctor_title) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $titleObj[$i]["personal_id"]; ?>"><?php echo $titleObj[$i]["personal_title"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Doctor Full Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="doctor_name" value="<?php echo $doctor_name; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Doctor HR Number: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="doctor_hr_number" value="<?php echo $doctor_hr_number; ?>">
					</div>
				</div>
				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Doctor Gender: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="doctor_gender">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($genderObj);$i++) { ?>
			                <option <?php if($genderObj[$i]["gender_id"] == $doctor_gender) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $genderObj[$i]["gender_id"]; ?>"><?php echo $genderObj[$i]["Gender_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Doctor Email: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="doctor_email" value="<?php echo $doctor_email; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Doctor Phone Number: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="doctor_phone_number" value="<?php echo $doctor_phone_number; ?>" >
					</div>
				</div>

				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Doctor Extension: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="doctor_extension" value="<?php echo $doctor_extension; ?>">
					</div>
				</div>

				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Doctor Nationality: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="doctor_nationality">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($countryObj);$i++) { ?>
			                <option <?php if($countryObj[$i]["country_id"] == $doctor_nationality) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $countryObj[$i]["country_id"]; ?>"><?php echo $countryObj[$i]["country_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

			    <div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label" >Doctor Branch: </label>
					<div class="col-md-9">
						<select class="form-control select2-example" id="doctor_branch_FK" multiple style="width: 100%">
							<?php for($i=0;$i<count($branch_Obj);$i++) { ?>
				            <option <?php if(in_array($branch_Obj[$i]["branch_id"],$doctor_branch_FK)) { ?> selected="selected" <?php  }   ?> value="<?php echo $branch_Obj[$i]["branch_id"]; ?>"><?php echo $branch_Obj[$i]["branch_name"]; ?></option>
				            <?php } ?>
				        </select>
					</div>
				</div>

			    <div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Doctor Department: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="doctor_departement_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($department_Obj);$i++) { ?>
			                <option <?php if($department_Obj[$i]["department_id"] == $doctor_departement_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $department_Obj[$i]["department_id"]; ?>"><?php echo $department_Obj[$i]["department_title"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

			    <div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Doctor Specialty: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="doctor_specialty_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($speciality_Obj);$i++) { ?>
			                <option <?php if($speciality_Obj[$i]["speciality_id"] == $doctor_specialty_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $speciality_Obj[$i]["speciality_id"]; ?>"><?php echo $speciality_Obj[$i]["speciality_title"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

			    <div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Years Of Experience: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="doctor_experience" value="<?php echo $doctor_experience; ?>" >
					</div>
				</div>

				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">User: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="user_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($employee_Obj);$i++) { ?>
			                <option <?php if($employee_Obj[$i]["employee_id"] == $user_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $employee_Obj[$i]["employee_id"]; ?>"><?php echo $employee_Obj[$i]["employee_full_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_this_doctor('<?php echo $_POST['doctor_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="doctor_form_div"></div>	
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
      $('.select2-example').select2({
        placeholder: 'Select value',
      });
    });
</script>