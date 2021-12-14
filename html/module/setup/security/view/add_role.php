<?php
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
require_once("../model/role.class.php");

if($_POST["role_id"]==-1)
{
		$role_name="";
		$role_description="";
}
else{
		$thisroleObj=new role($_POST['role_id']);
		$role_name	=$thisroleObj->role_name;
		$role_description=$thisroleObj->role_description;

}	
?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Security Group</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Role Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="role_name" value="<?php echo $role_name; ?>" placeholder="Role">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Role Description: </label>
					<div class="col-md-9">
						<textarea id="role_description" class="form-control" placeholder="Role Description"><?php echo $role_description; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_role('<?php echo $_POST['role_id']; ?>')">Save Role</button>
					</div>
				</div>	
				<div id="security_form_div"></div>	
			</div>
		</div>
	</div>
</div>

