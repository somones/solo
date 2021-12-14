<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/employee.class.php");
require_once("../../../../html/lib/model/module.class.php");
require_once("../../../../html/lib/model/menu_item.class.php");
require_once("../../../../html/lib/model/department.class.php");
require_once("../model/policy_section.class.php");

if($_POST["section_id"]==-1)
{
	$section_title			="";
	$section_help_tip		="";
	$section_date_created	="";
	$section_date_updated	="";
	//$section_active_state	="";
}
else{
	$thissectionObj			=new policy_section($_POST['section_id']);
	$section_title			=$thissectionObj->section_title;
	$section_help_tip		=$thissectionObj->section_help_tip;
	$section_date_created	=$thissectionObj->section_date_created;
	$section_date_updated	=$thissectionObj->section_date_updated;
	//$section_active_state	=$thissectionObj->section_active_state;
}	
?>

<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Section</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Section Title: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="section_title" value="<?php echo $section_title; ?>" placeholder="Chapter Title">
					</div>
				</div>

				<div class="form-group">
			        <label for="grid-input-1" class="col-md-3 control-label">Section Help</label>
			        <div class="col-md-9">
			         <textarea id="section_help_tip" class="form-control" placeholder="Meeting Description"><?php echo $section_help_tip; ?></textarea>
			        </div>
			    </div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_section('<?php echo $_POST['section_id']; ?>')">Save</button>
					</div>
				</div>	
				<div id="section_form_div"></div>	
			</div>
		</div>
	</div>
</div>
