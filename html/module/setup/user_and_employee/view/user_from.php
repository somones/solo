<?php
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
require_once("../model/user.class.php");

$branchObj 			= new branch();
$branch_Obj			= $branchObj->get_active_branches();

$departmentObj  	= new department();
$department_Obj 	= $departmentObj->get_active_departments();

$userObj 			= new user();
$user_Obj			= $userObj->get_list_roles();	
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
<div class="page-header">
    <div class="row">
        <div class="col-md-4 text-xs-center text-md-left text-nowrap">
          <h1><i class="page-header-icon ion-ios-pulse-strong"></i>Add New User</h1>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-lg-12" id="meeting_op_div">
	
	</div>
</div>
<div>
	<div class="panel">
	  <div class="panel-heading">
	    <div class="panel-title"></div>
	  </div>
	  <div class="panel-body">
	    <form class="form-horizontal" method="post" action=""> 
	    <div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label" >Employee Branch: </label>
			<div class="col-md-9">
				<select class="form-control" id="branch_id">
	            	<option value="" selected="selected">Select...</option>
	              	<?php for($i=0;$i<count($branch_Obj);$i++) { ?>
	                <option value="<?php echo $branch_Obj[$i]["branch_id"]; ?>"><?php echo $branch_Obj[$i]["branch_name"]; ?></option>
	              <?php } ?>
	          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label" >Employee department: </label>
			<div class="col-md-9">
				<select class="form-control" id="department_id">
	            	<option value="" selected="selected">Select...</option>
	              	<?php for($i=0;$i<count($department_Obj);$i++) { ?>
	                <option value="<?php echo $department_Obj[$i]["department_id"]; ?>"><?php echo $department_Obj[$i]["department_title"]; ?></option>
	              <?php } ?>
	          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label">Employee Full Name: </label>
			<div class="col-md-9">
				<input type="text" class="form-control" id="employee_full_name">
			</div>
		</div>
		<div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label">Employee Date Of Birth: </label>
			<div class="col-md-9">
				<input type="text" class="form-control" name="datefield" id="employee_dob">
			</div>		
		</div>
		<div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label">Employee Job Title: </label>
			<div class="col-md-9">
				<input type="text" class="form-control" id="employee_job_title" >
			</div>
		</div>
		<div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label">Employee HR Number: </label>
			<div class="col-md-9">
				<input type="text" class="form-control" id="employee_number" >
			</div>
		</div>
		<div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label">Employee Email: </label>
			<div class="col-md-9">
				<input type="text" class="form-control" id="employee_email" >
			</div>
		</div>

		<div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label" >Employee Roles: </label>
			<div class="col-md-9">
				<select class="form-control select2-example" id="roles_id_FK" multiple style="width: 100%">
					<?php for($i=0;$i<count($user_Obj);$i++) { ?>
			        <option value="<?php echo $user_Obj[$i]["role_id"]; ?>"><?php echo $user_Obj[$i]["role_name"]; ?></option>
			        <?php } ?>
			    </select>
			</div>
		</div>
	    <div class="form-group">
	        <label for="grid-input-3" class="col-md-3 control-label">Employee active: </label>
	        <div class="col-md-9">
	          <select class="form-control" id="employee_active">
	            	<option value="" selected="selected">Select...</option>
	                <option value="0">Inactive</option>
	                <option value="1">Active</option>
	          </select>
	        </div>
	    </div>
		<div class="form-group">
	        <label for="grid-input-3" class="col-md-3 control-label">Profile Complete: </label>
	        <div class="col-md-9">
		        <select class="form-control" id="profile_completed">
		           	<option value="" selected="selected">Select...</option>
		            <option value="0">Incomplete</option>
		            <option value="1">Complete</option>
		        </select>
	        </div>
	    </div>
		
		<div class="form-group">
			<div class="col-md-offset-3 col-md-9">
				<button type="button" class="btn btn-primary" onclick="save_this_user('-1')">Save Form</button>
			</div>
		</div>	
		<div id="user_form_div"></div>
		</form>
	  </div>
	</div>
</div>

<script>
    $(function() {
      $('.select2-example').select2({
        placeholder: 'Select value',
      });
    });	
  </script>
  <script type="text/javascript">
  	$("[name='datefield']").datepicker({format: 'yyyy-mm-dd'});
  </script>