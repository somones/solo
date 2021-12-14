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
require_once("../model/policy_chapter.class.php");

if($_POST["chapter_id"]==-1)
{
	$chapter_title="";
	$chapter_active="";
}
else{
	$thischapterObj=new policy_chapter($_POST['chapter_id']);
	$chapter_title	=$thischapterObj->chapter_title;
	$chapter_active	=$thischapterObj->chapter_active;
}	
?>

<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Chapter</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Chapter Title: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="chapter_title" value="<?php echo $chapter_title; ?>" placeholder="Chapter Title">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_chapter('<?php echo $_POST['chapter_id']; ?>')">Save</button>
					</div>
				</div>	
				<div id="chapter_form_div"></div>	
			</div>
		</div>
	</div>
</div>
