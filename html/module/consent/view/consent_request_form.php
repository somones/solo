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

//Local Classes
require_once("../model/consent_request.class.php");
require_once("../model/doctor.class.php");
require_once("../model/consent.class.php");

$doctorObj     = new doctor();
$doctor_obj    = $doctorObj->list_of_doctors();

$consentObj     = new consent();
$consent_obj    = $consentObj->list_of_consent();

$branchObj     = new branch();
$branch_obj    = $branchObj->get_active_branches();

$employeeObj    = new employee();
$employee_Obj   = $employeeObj->get_active_employee();
 

 if(isset($_POST['consent_request_id']))
    $consent_request_id=$_POST['consent_request_id'];
else
    $consent_request_id=-1;

if($consent_request_id==-1)
{
  $consent_request_title                    ="";
  $patient_id_FK                            ="";
  $consent_request_date_time                ="";
  $consent_id_FK                            ="";
  $consent_file_id_FK                       ="";
  $patient_file                             ="";
}
else
{
  $consent_requestObj=new consent_request($consent_request_id);
  
  $consent_request_title                    =$consent_requestObj->consent_request_title;
  $patient_id_FK                            =$consent_requestObj->patient_id_FK;
  $consent_request_date_time                =$consent_requestObj->consent_request_date_time;
  $consent_id_FK                            =$consent_requestObj->consent_id_FK;
  $consent_file_id_FK                       =$consent_requestObj->consent_file_id_FK;
  $patient_file                             =$consent_requestObj->patient_file;

  $file = $applicantObj->get_consent_requiest_file($consent_file_id_FK);
}
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

<script type="text/javascript">
  $(document).ready(function(){
    $("#branch_id_FK").change(function(){
      var aid = $("#branch_id_FK").val();
      $.ajax({
        url: '../model/consent_config.php',
        method: 'post',
        data: 'aid='+aid
      }).done(function(templates){
        templates = JSON.parse(templates);
        console.log(templates);
        $('#consent_id_FK').empty();
        templates.forEach(function(template){
          $('#consent_id_FK').append('<option value="'+ template.consent_id +'">'+ template.consent_title +'</option>');

          $("#consent_id_FK").change(function() {
            var Js_id = this.value;
          })
        })
      })
    })
  })
</script>
<div class="page-header">
  <div class="row">
    <div class="col-md-4 text-xs-center text-md-left text-nowrap">
      <h1><i class="page-header-icon ion-ios-pulse-strong"></i>Add/ Edit Consent Request</h1>
    </div>
  </div>
</div>

<div>
  <div class="panel">
    <div class="panel-heading"><div class="panel-title"></div></div>
    <div class="panel-body">
      <form class="form-horizontal" method="post" action="">
        <div class="form-group">
          <label for="grid-input-3" class="col-md-3 control-label">Branch</label>
          <div class="col-md-9">
            <select class="form-control" id="branch_id_FK">
              <option value="" selected="selected">Select...</option>
                <?php for($i=0;$i<count($branch_obj);$i++) { ?>
                  <option <?php if($branch_obj[$i]["branch_id"] == $patient_id_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $branch_obj[$i]["branch_id"]; ?>"><?php echo $branch_obj[$i]["branch_name"]; ?></option>
                <?php } ?>
            </select>
          </div>
        </div>

        
      <div class="form-group">
          <label for="grid-input-3" class="col-md-3 control-label">Consent</label>
          <div class="col-md-9">
            <select class="form-control" id="consent_id_FK">
                <option value="-1" selected="selected">Select...</option>
            </select>
          </div>
      </div>

      <div class="form-group">
          <label for="grid-input-1" class="col-md-3 control-label">Patient File Number: </label>
          <div class="col-md-9">
            <input type="text" class="form-control" id="patient_file">
          </div>
      </div>

      <div class="form-group">
        <label for="grid-input-6" class="col-md-3 control-label">Upload Consent File</label>
        <div class="col-md-9">
          <label class="custom-file px-file" for="grid-input-6">
          <input type="button" class="btn btn-primary" id="file_up" onclick="upload_new_file('consent_request_id','<?php echo $consent_request_id; ?>','3','../../','consent_file_id_FK')" value="Add new File"/>
          <input type="hidden" id="consent_file_id_FK" value="<?php echo $consent_file_id_FK; ?>">
          <?php if (isset($file) && $file <> NULL) { echo $file[0]['file_new_name'].".".$file[0]['file_extension'];} ?>
        </div>
      </div>
        <div class="form-group pull-left">
          <div class="col-md-offset-3 col-md-9">
            <button type="button" class="btn btn-primary" id="save_btn" onclick="save_consent_request('<?php echo $consent_request_id; ?>')">Save Request</button>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12" id="request_op_div"></div>
        </div>

        <div class="col-lg-12"  id="required_signature"></div>
      </form>
    </div>
  </div>
</div>
