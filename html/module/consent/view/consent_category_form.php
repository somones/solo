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

if($_POST["consent_category_id"]==-1)
{
		$consent_category_name				="";
		$consent_category_description		="";
}
else {
		$thiscodeObj= new consent_category($_POST['consent_category_id']);

		$consent_category_name			=$thiscodeObj->consent_category_name;
		$consent_category_description	=$thiscodeObj->consent_category_description;
}
?>
<script type="text/javascript" src="../assets/JS/contact.js"/></script>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Consent Category</h4>
				<?php //print_r($employee_Obj); ?>
			</div>

			<div class="modal-body">	
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Consent Category Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="consent_category_name" value="<?php echo $consent_category_name; ?>" placeholder="Consent Category Name">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Consent Category Description: </label>
					<div class="col-md-9">
						<textarea class="form-control" id="consent_category_description" rows="8" placeholder="Consent Category Description"><?php echo $consent_category_description; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_this_consent_category('<?php echo $_POST['consent_category_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="consent_category_form_div"></div>	
			</div>
		</div>
	</div>
</div>
