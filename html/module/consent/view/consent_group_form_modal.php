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

require_once("../model/consent_user_group.class.php");

if($_POST["consent_group_id"]==-1)
{
		$consent_group_title				="";
		$consent_group_description			="";
}
else {
		$user_groupObj= new consent_user_group($_POST['consent_group_id']);

		$consent_group_title			=$user_groupObj->consent_group_title;
		$consent_group_description		=$user_groupObj->consent_group_description;
}
?>
<script type="text/javascript" src="../assets/JS/contact.js"/></script>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Consent</h4>
				<?php //print_r($branch_id_FK); ?>
			</div>

			<div class="modal-body">	
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Consent Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="consent_group_title" value="<?php echo $consent_group_title; ?>" placeholder="Consent Name">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Consent Description: </label>
					<div class="col-md-9">
						<textarea class="form-control" id="consent_group_description" rows="8" placeholder="Consent Description"><?php echo $consent_group_description; ?></textarea>
					</div>
				</div>


				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_this_consent_group('<?php echo $_POST['consent_group_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="consent_form_div"></div>	
			</div>
		</div>
	</div>
</div>
