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

require_once("../model/speciality.class.php");

if($_POST["speciality_id"]==-1)
{
	$speciality_title			="";
	$speciality_description		="";
}
else {
		$specialityObj= new speciality($_POST['speciality_id']);

		$speciality_title					=$specialityObj->speciality_title;
		$speciality_description				=$specialityObj->speciality_description;
}
?>
<script type="text/javascript" src="../assets/JS/contact.js"/></script>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit / Speciality</h4>
				<?php //print_r($branch_id_FK); ?>
			</div>

			<div class="modal-body">
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Speciality Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="speciality_title" value="<?php echo $speciality_title; ?>" placeholder="Consent Name">
					</div>
				</div>

				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Speciality Description: </label>
					<div class="col-md-9">
						<textarea class="form-control" id="speciality_description" rows="8" placeholder="Consent Description"><?php echo $speciality_description; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_this_speciality('<?php echo $_POST['speciality_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="speciality_form_div"></div>	
			</div>
		</div>
	</div>
</div>