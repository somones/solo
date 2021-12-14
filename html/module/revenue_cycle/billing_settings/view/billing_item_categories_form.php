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
require_once("../model/billing_item_categories.class.php");

if($_POST["category_id"]==-1)
{
	$category_description			="";
		
}
else{
	$thiscodeObj=new billing_item_category($_POST['category_id']);
	$category_description			=$thiscodeObj->category_description;
}
?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/ Billing Item Category</h4>
				<?php //print_r($profile_Obj); ?>
			</div>

			<div class="modal-body">
			    <div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Billing Item Category Description: </label>
					<div class="col-md-9">
						<textarea id="category_description" class="form-control" placeholder="Billing Item Description"><?php echo $category_description; ?></textarea>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_billing_item_categories('<?php echo $_POST['category_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="code_form_div"></div>	
			</div>
		</div>
	</div>
</div>
