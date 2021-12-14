<?php
session_start();
//error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../lib/model/database.class.php");
require_once("../../../lib/model/company.class.php");
require_once("../../../lib/model/employee.class.php");
require_once("../../../lib/model/department.class.php");
require_once("../../../lib/model/branch.class.php");
require_once("../../../lib/model/module.class.php");
require_once("../../../lib/model/item_category.class.php");
require_once("../../../lib/model/template.inc.php");

$templateObj 	  =new template('../../../../html/');
$templateObj->path_to_root="../../../../";
$templateObj->start_head("My Profile");
$employeeObj	 =new employee($_SESSION['employee_id']);
$branchObj		  =new branch();
$departmentObj	=new department();
$av_branches	 =$branchObj->get_active_branches();
$av_departments   =$departmentObj->get_active_departments();

$employee_id = $_SESSION['employee_id'];
?>
<script type="text/javascript" src="../assets/JS/profile.js"></script>
<!--

<script src="../Lib/ckeditor/ckeditor.js"></script>
<script src="../Lib/ckeditor/samples/js/sample.js"></script>
<link rel="stylesheet" href="../Lib/ckeditor/samples/css/samples.css">
<link rel="stylesheet" href="../Lib/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
-->
<?php
$templateObj->close_head();
$templateObj->start_body();
$templateObj->draw_main_menu();
?>
<div id="content-wrapper">
 <div class="px-content">
  <div class="page-header m-b-0 p-b-0 b-b-0">
      <h1>Account <span class="text-muted font-weight-light"></span></h1>
      <ul class="nav nav-tabs page-block m-t-4" id="account-tabs">
        <li class="active">
          <a href="#account-profile" data-toggle="tab">
          	<?php echo $employeeObj->employee_full_name; ?>	
          </a>
        </li>
      </ul>
    </div>
    <div id="profile_form_div"></div>
    <div class="tab-content p-y-4">
      <!-- Profile tab -->
      	<div class="tab-pane fade in active" id="account-profile">
		<div class="row">
			<div class="col-lg-12">
				<?php if($employeeObj->profile_completed==0)
				{
					echo "<div class='alert alert-danger'><b>".$employeeObj->employee_full_name."</b>, Your profile is incomplete , Kindly take a minute to complete it.</div>";
				}?>
			</div>
		</div>
        <div class="row">
			<div class="col-md-4 col-lg-3">
	            <div class="panel bg-transparent">
	              <div class="panel-body text-xs-center">
	                <img src="<?php echo $_SESSION['user_picture'].'.jpg'; ?>" alt="" class="" style="max-width: 100%;">
	              </div>
	            </div>
          	</div>

          	<form action="" class="col-md-8 col-lg-9">
            <div class="p-x-1">
              <fieldset class="form-group form-group-lg">
                <label for="account-name">Name: </label>
                <input type="text" class="form-control" id="employee_full_name" value="<?php echo $employeeObj->employee_full_name; ?>">
              </fieldset>
              <fieldset class="form-group form-group-lg">
                <label for="account-username">Date Of Brith</label>
                <input type="text" class="form-control" name="date_value" id="employee_dob" value="<?php echo $employeeObj->employee_dob; ?>">
                <script type="text/javascript">
                </script>
              </fieldset>
              <fieldset class="form-group form-group-lg">
                <label for="account-email">E-mail</label>
                <input type="email" class="form-control" id="employee_email" disabled="disabled" value="<?php echo $employeeObj->employee_email; ?>">
              </fieldset>
              <fieldset class="form-group form-group-lg">
                <label for="account-location">Branch</label>
                <select id="branch_id_FK" class="form-control">
                	<option value=""></option>
                	<?php
                	for($i=0;$i<count($av_branches);$i++)
                	{ ?>
                		<option <?php if($employeeObj->branch_id_FK==$av_branches[$i]["branch_id"]) {  echo "selected='selected'"; } ?> value="<?php echo $av_branches[$i]["branch_id"]; ?>"><?php echo $av_branches[$i]["branch_name"]; ?></option>
                		<?php
                	} ?>                	
                </select>
              </fieldset>
              <fieldset class="form-group form-group-lg">
                <label for="account-url">Department</label>
                <select id="department_id_FK" class="form-control">
                	<option value=""></option>
                	<?php
                	for($i=0;$i<count($av_departments);$i++)
                	{?>
                		<option <?php if($employeeObj->department_id_FK==$av_departments[$i]["department_id"]) {  echo "selected='selected'"; } ?>  value="<?php echo $av_departments[$i]["department_id"]; ?>"><?php echo $av_departments[$i]["department_title"]; ?></option>
                		<?php
                	} ?>
                </select>
              </fieldset>
              <fieldset class="form-group form-group-lg">
                <label for="account-bio">Job Title</label>
                <input type="text" class="form-control" id="employee_job_title" value="<?php echo $employeeObj->employee_job_title; ?>">
              </fieldset>
              <fieldset class="form-group form-group-lg">
                <label for="account-bio">Employee Number</label>
                <input type="text" class="form-control" id="employee_number" value="<?php echo $employeeObj->employee_number; ?>">
              </fieldset>
              <button type="button" class="btn btn-lg btn-primary m-t-3" onclick="update_profile(<?php echo $employee_id ?>)">Update profile</button>
            </div>
          </form>
          <!-- Spacer -->
          <div class="m-t-4 visible-xs visible-sm"></div>
          <!-- Avatar -->
        </div>
      </div>
      <!-- / Profile tab -->
    </div>
  </div>
</div>

<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<div id="main-menu-bg"></div>

<?php
$templateObj->close_body();
?>
<script src="../../../../html/assets/demo/demo.js"></script>
<script type="text/javascript">
//show_loading_gif("content-wrapper","Loading...");
	var init = [];
	init.push(function () {
		//alert();
$("[name='date_value']").datepicker({format: 'yyyy-mm-dd'});
		// Javascript code here
		$('#profile-tabs').tabdrop();
	})
	window.PixelAdmin.start(init);
</script>