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
require_once("../model/consent_category.class.php");

//Local Classes
require_once("../model/consent_request.class.php");
require_once("../model/doctor.class.php");
require_once("../model/consent.class.php");
require_once("../model/request_has_signee.class.php");

$patientObj         = new request_has_signee();
$patient_Obj        = $patientObj->get_this_patient($_POST['patient_id'],$_POST['request_id']);

$doctorObj          = new doctor();
$doctor_obj         = $doctorObj->list_of_doctors();

$consentObj         = new consent();
$consent_obj 	      = $consentObj->list_of_consent();

$branchObj          = new branch();
$branch_obj         = $branchObj->get_active_branches();

$employeeObj        = new employee();
$employee_session   = $employeeObj->get_this_employee($_SESSION['employee_id']);
$employee_Obj       = $employeeObj->get_active_employee();


?>

<style type="text/css">
  .hr-sect {
  display: flex;
  flex-basis: 100%;
  align-items: center;
  color: rgba(0, 0, 0, 0.35);
  margin: 8px 0px;
}
.hr-sect::before,
.hr-sect::after {
  content: "";
  flex-grow: 1;
  background: rgba(0, 0, 0, 0.35);
  height: 1px;
  font-size: 0px;
  line-height: 0px;
  margin: 0px 8px;
}
</style>
<div class="form-group">
<?php 
//print_r($_POST);
$consentObjct = $consentObj->get_this_consentObj($_POST['consent_id_FK']);
//print_r($consentObjct);
if ($consentObjct['doctor_signature_required'] == 1) { ?>
  <div class="hr-sect">This Consent Require Doctor's Signature</div>
  <div class="form-group">
    <label for="grid-input-3" class="col-md-3 control-label">Select a Doctor</label>
    <div class="col-md-6">
      <select class="form-control" id="doctor_id">
        <option value="" selected="selected">Select...</option>
          <?php for($i=0;$i<count($doctor_obj);$i++) { ?>
            <option value="<?php echo $doctor_obj[$i]["user_id_FK"]; ?>"><?php echo $doctor_obj[$i]["doctor_name"]; ?></option>
          <?php } ?>
      </select>
    </div>
  </div>
<?php }
if ($consentObjct['admin_signature_required'] == 1) { ?>
  <div class="hr-sect">This Consent Require Administrator Signature</div>
  <div class="form-group">
    <label for="grid-input-3" class="col-md-3 control-label">Select an Admin</label>
    <div class="col-md-6">
      <select class="form-control" id="admin_id">
        <option value="" selected="">Select...</option>
        <option value="<?php echo $_SESSION['employee_id']; ?>" selected="selected"><?php echo $employee_session["employee_full_name"]; ?></option>
          <?php for($i=0;$i<count($employee_Obj);$i++) { ?>
            <option value="<?php echo $employee_Obj[$i]["employee_id"]; ?>"><?php echo $employee_Obj[$i]["employee_full_name"]; ?></option>
          <?php } ?>
      </select>
    </div> 
  </div>
<?php } ?>
<hr>
<?php if ($consentObjct['doctor_signature_required'] == 1 OR $consentObjct['admin_signature_required'] == 1) { ?>
  <button type="button" class="btn btn-primary" id="send_btn" onclick="send_for_signature('<?php echo $_POST["request_id"]; ?>','<?php echo $_POST["consent_file_id_FK"]; ?>')">Send for Signature</button>
<?php } else { ?>
    <br>
    <br>
    <p>This Consent Not Request Doctor or Admin signator</p>
<?php } ?>
<hr>
<div id="signateur_error"></div>

<?php if ($consentObjct['patient_signature_required'] ==1) { ?>
  <div class="hr-sect">This Consent Require Patient Signature</div>
  <p style="color: red">Only Allowed Person can take the Patient Signature</p>
<?php } else { ?>
  <p style="color: green">This Consent Not Request Patient signator</p>
<?php } ?>
</div> 