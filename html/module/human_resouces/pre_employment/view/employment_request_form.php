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

//Local Classes
require_once("../model/employment_request.class.php");
require_once("../model/request_group.class.php");
require_once("../model/country.class.php");
require_once("../model/availability_type.class.php");



$request_groupObj     = new request_group();
$request_groupObj_obj = $request_groupObj->list_of_request_groups();

$availabilityObj = new availability_type();
$availability_obj = $availabilityObj->list_of_availability_type();

$countryObj = new country();
$country_obj = $countryObj->list_of_countries();

$branchObj = new branch();
$branch_obj = $branchObj->get_active_branches();

if(isset($_POST['request_id']))
    $request_id=$_POST['request_id'];
else
    $request_id=-1;
  
if($request_id==-1)
{
  $request_job_title                 ="";
  $request_group_id_FK               ="";
  $request_description               ="";
  
  $branch_id_FK                      ="";
  $gender_id_FK                      ="";
  $request_reason                    ="";
  $request_type_id_FK                ="";
  $nationality_id_FK                 ="";
  $request_experience                ="";
}
else
{
  $employment_requestObj=new employment_request($request_id);
  
  $request_job_title                  =$employment_requestObj->request_job_title;
  $request_group_id_FK                =$employment_requestObj->request_group_id_FK;
  $request_description                =$employment_requestObj->request_description;
  
  $branch_id_FK                       =$employment_requestObj->branch_id_FK;
  $gender_id_FK                       =$employment_requestObj->gender_id_FK;
  $request_reason                     =$employment_requestObj->request_reason;
  $request_type_id_FK                 =$employment_requestObj->request_type_id_FK;
  $nationality_id_FK                  =$employment_requestObj->nationality_id_FK;
  $request_experience                 =$employment_requestObj->request_experience;
}

?>

<div class="page-header">
  <div class="row">
    <div class="col-md-4 text-xs-center text-md-left text-nowrap">
      <h1><i class="page-header-icon ion-ios-pulse-strong"></i>New Request</h1>
      <?php //print_r($country_obj); ?>
    </div>
  </div>
</div>

<div>
  <div class="panel">
    <div class="panel-heading"><div class="panel-title"></div></div>
    <div class="panel-body">
      <form class="form-horizontal" method="post" action=""> 
        <div class="form-group">
          <label for="grid-input-1" class="col-md-3 control-label">Job Title</label>
          <div class="col-md-9">
            <input type="text" class="form-control" id="request_job_title" value="<?php echo $request_job_title ; ?>">
          </div>
        </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Request Group</label>
        <div class="col-md-9">
          <select class="form-control" id="request_group_id_FK">
            <option value="" selected="selected">Select...</option>
              <?php for($i=0;$i<count($request_groupObj_obj);$i++) { ?>
                <option <?php if($request_groupObj_obj[$i]["emp_group_id"] == $request_group_id_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $request_groupObj_obj[$i]["emp_group_id"]; ?>"><?php echo $request_groupObj_obj[$i]["emp_group_name"]; ?></option>
              <?php } ?>
          </select>
        </div>
      </div>

        <div class="form-group">
          <label for="grid-input-1" class="col-md-3 control-label">Job Description</label>
          <div class="col-md-9">
            <textarea id="request_description" class="form-control" ><?php echo $request_description; ?></textarea>
          </div>
        </div>

        <!--------- ----->

        <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Region</label>
        <div class="col-md-9">
          <select class="form-control" id="branch_id_FK">
            <option value="" selected="selected">Select...</option>
              <?php for($i=0;$i<count($branch_obj);$i++) { ?>
                <option <?php if($branch_obj[$i]["branch_id"] == $branch_id_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $branch_obj[$i]["branch_id"]; ?>"><?php echo $branch_obj[$i]["branch_name"]; ?></option>
              <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Gender</label>
        <div class="col-md-9">
          <select class="form-control" id="gender_id_FK">
            <option value="" selected="selected">Select...</option>
                <option value="1">Male</option>
                <option value="2">Female</option>
          </select>
        </div>
      </div>

      <div class="form-group">
          <label for="grid-input-1" class="col-md-3 control-label">Reason for Vacancy</label>
          <div class="col-md-9">
            <select class="form-control" id="request_reason">
                <option value="" selected="selected">Select...</option>
                  <option <?php if ($request_reason == "Remplacement") { ?> selected="selected" <?php } ?> value="Remplacement"> Remplacement </option>
                  <option <?php if ($request_reason == "New Vacancy") { ?> selected="selected" <?php } ?> value="New Vacancy"> New Vacancy </option>
            </select>
          </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Request Type</label>
        <div class="col-md-9">
          <select class="form-control" id="request_type_id_FK">
            <option value="" selected="selected">Select...</option>
              <?php for($i=0;$i<count($availability_obj);$i++) { ?>
                <option <?php if($availability_obj[$i]["availability_type_id"] == $request_type_id_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $availability_obj[$i]["availability_type_id"]; ?>"><?php echo $availability_obj[$i]["availability_type_name"]; ?></option>
              <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Nationality</label>
        <div class="col-md-9">
          <select class="form-control" id="nationality_id_FK">
            <option value="" selected="selected">Select...</option>
              <?php for($i=0;$i<count($country_obj);$i++) { ?>
                <option <?php if($country_obj[$i]["country_id"] == $nationality_id_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $country_obj[$i]["country_id"]; ?>"><?php echo $country_obj[$i]["country_name"]; ?></option>
              <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Experience</label>
        <div class="col-md-9">
          <select class="form-control" id="request_experience">
            <option value="" selected="selected">Select...</option>
              <?php for($i=1;$i<=10;$i++) { ?>
                <option <?php if($request_experience == $i) {  ?> selected="selected" <?php  } ?> 
                value="<?php echo $i; ?>"><?php echo $i; ?>
                </option>
              <?php } ?>
              <option value="<?php echo $i+1; ?>">10+</option>
          </select>
        </div>
      </div>

        <div class="form-group">
          <div class="col-md-offset-3 col-md-9">
            <button type="button" class="btn btn-primary" onclick="submit_save_request('<?php echo $request_id; ?>')">Save Job Request</button>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12" id="request_op_div"></div>
        </div>
      </form>
    </div>
  </div>
</div>