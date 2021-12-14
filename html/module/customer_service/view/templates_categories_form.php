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
require_once("../model/messages_template_categorie.class.php");

$branchObj 	= new branch();
$branch_Obj	= $branchObj->get_active_branches();

if($_POST["message_templates_categories_id"]==-1)
{
		$message_templates_categories_name						="";
		$message_templates_categories_description				="";
		$message_templates_categories_branch_id_FK				="";
}
else {
		$thiscodeObj= new messages_template_categorie($_POST['message_templates_categories_id']);

		$message_templates_categories_name						=$thiscodeObj->message_templates_categories_name;
		$message_templates_categories_description				=$thiscodeObj->message_templates_categories_description;
		$message_templates_categories_branch_id_FK				=$thiscodeObj->message_templates_categories_branch_id_FK;
}
?>
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
					<label for="grid-input-1" class="col-md-3 control-label">Template Categery Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="message_templates_categories_name" value="<?php echo $message_templates_categories_name; ?>" placeholder="Template Categery Name">
					</div>
				</div>

				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Template Categery Branch: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="message_templates_categories_branch_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($branch_Obj);$i++) { ?>
			                <option <?php if($branch_Obj[$i]["branch_id"] == $message_templates_categories_branch_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $branch_Obj[$i]["branch_id"]; ?>"><?php echo $branch_Obj[$i]["branch_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

			    <div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Template Categery Description: </label>
					<div class="col-md-9">
						<textarea id="message_templates_categories_description" class="form-control" placeholder="Description"><?php echo $message_templates_categories_description; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_this_templates_category('<?php echo $_POST['message_templates_categories_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="conact_form_div"></div>	
			</div>
		</div>
	</div>
</div>
