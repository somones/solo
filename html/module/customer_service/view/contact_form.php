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
require_once("../model/contact.class.php");

$employeeObj 	= new employee();
$employee_Obj	= $employeeObj->list_of_all_employee();

$branchObj 	= new branch();
$branch_Obj	= $branchObj->get_active_branches();

if($_POST["contact_id"]==-1)
{
		$contact_name				="";
		$contact_email				="";
		$contact_mobile_number		="";
		$contact_user_id_FK			="";
		$extension_number			="";
		$branch_id_FK				="";
}
else {
		$thiscodeObj= new contact($_POST['contact_id']);

		$contact_name			=$thiscodeObj->contact_name;
		$contact_email			=$thiscodeObj->contact_email;
		$contact_mobile_number	=$thiscodeObj->contact_mobile_number;
		$contact_user_id_FK		=$thiscodeObj->contact_user_id_FK;
		$extension_number		=$thiscodeObj->extension_number;
		$branch_id_FK			=$thiscodeObj->branch_id_FK;
}
?>
<script type="text/javascript" src="../assets/JS/contact.js"/></script>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Contact</h4>
				<?php //print_r($employee_Obj); ?>
			</div>

			<div class="modal-body">	
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Contact Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="contact_name" value="<?php echo $contact_name; ?>" placeholder="Enter Contact Name">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Contact Email: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="contact_email" value="<?php echo $contact_email; ?>" placeholder="Contact Email">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Contact Phone Number: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="contact_mobile_number" value="<?php echo $contact_mobile_number; ?>" placeholder="Phone Number">
					</div>
				</div>

				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">User: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="contact_user_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($employee_Obj);$i++) { ?>
			                <option <?php if($employee_Obj[$i]["employee_id"] == $contact_user_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $employee_Obj[$i]["employee_id"]; ?>"><?php echo $employee_Obj[$i]["employee_full_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

			    <div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Extension Number: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="extension_number" value="<?php echo $extension_number; ?>" placeholder="Extension Number">
					</div>
				</div>

				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">User Branch: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="branch_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($branch_Obj);$i++) { ?>
			                <option <?php if($branch_Obj[$i]["branch_id"] == $branch_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $branch_Obj[$i]["branch_id"]; ?>"><?php echo $branch_Obj[$i]["branch_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>


				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_this_contact('<?php echo $_POST['contact_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="conact_form_div"></div>	
			</div>
		</div>
	</div>
</div>
