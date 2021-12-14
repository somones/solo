<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/employee.class.php");
require_once("../../../../../html/lib/model/module.class.php");
require_once("../../../../../html/lib/model/menu_item.class.php");
require_once("../../../../../html/lib/model/department.class.php");
require_once("../model/applicant.class.php");

$applicantObj       =new applicant();
$applicant_obj    =$applicantObj->list_applicants($_SESSION['employee_id']);
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
            <th>Availability</th>
            <th>Source</th>
            <th>Delete</th>
          </thead>
          <tbody>
            <?php for($i=0;$i<count($applicant_obj);$i++) { 

            $applicantinner_obj =$applicantObj->liste_applicants_inner($applicant_obj[$i]["applicant_id"]);
              ?>
            <tr>              
              <td><?php echo $applicant_obj[$i]["application_ref_number"]; ?></td>
              <td><?php echo $applicant_obj[$i]["applicant_first_name"]; ?>
                <?php echo $applicant_obj[$i]["applicant_last_name"]; ?>
                <?php echo $applicant_obj[$i]["applicant_suffix"]; ?>
              </td>
              <td><?php echo $applicant_obj[$i]["date_created"]; ?></td>
              <td><?php echo $applicant_obj[$i]["applicant_email"]; ?></td>
              <td><?php echo $applicant_obj[$i]["applicant_phone_number"]; ?></td>
              <td><?php echo $applicantinner_obj["profession_title"]; ?></td>
              <td><?php echo $applicantinner_obj["availability_type_name"]; ?></td>
              <td><?php echo $applicantinner_obj["source_name"]; ?></td>
              <td><button type="button" class="btn btn-danger" onclick="submit_delete_applicant('<?php echo $applicant_obj[$i]["applicant_id"]; ?>')">Delete</button></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>