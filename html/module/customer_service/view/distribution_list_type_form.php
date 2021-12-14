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

require_once("../model/distribution_list_type.class.php");

if($_POST["type_id"]==-1)
{
		$list_type_name					="";
		$list_type_description			="";
}
else{
		$thiscodeObj= new distribution_list_type($_POST['type_id']);

		$list_type_id				=$thiscodeObj->list_type_id;
		$list_type_name				=$thiscodeObj->list_type_name;
		$list_type_description		=$thiscodeObj->list_type_description;


}
?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Distribution List Type</h4>
			</div>

			<div class="modal-body">	
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Type Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="list_type_name" value="<?php echo $list_type_name; ?>" placeholder="Distribution Type Name">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Type Description: </label>
					<div class="col-md-9">
						<textarea class="form-control" id="list_type_description" placeholder="Distribution Type Description" ><?php echo $list_type_description; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_this_distribution_list_type('<?php echo $_POST['type_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="email_div"></div>	
			</div>
		</div>
	</div>
</div>
