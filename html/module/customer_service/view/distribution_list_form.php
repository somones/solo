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
require_once("../model/distribution_list.class.php");
require_once("../model/distribution_list_type.class.php");

$branchObj 	= new branch();
$branch_obj 	= $branchObj->get_active_branches($_SESSION['employee_id']);

$listTypObj 	= new distribution_list_type();
$listTyp_Obj 	= $listTypObj->list_of_distribution_list_type($_SESSION['employee_id']);

if($_POST["list_id"]==-1)
{
		$branch_id_FK				="";
		$list_name					="";
		$list_description			="";
		$list_type_id_FK			="";	
}
else{
		$thiscodeObj= new distribution_list($_POST['list_id']);

		$branch_id_FK			=$thiscodeObj->branch_id_FK;
		$list_name				=$thiscodeObj->list_name;
		$list_description		=$thiscodeObj->list_description;
		$list_type_id_FK		=$thiscodeObj->list_type_id_FK;

}
?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Distribution List</h4>
			</div>

			<div class="modal-body">	
			    <div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">List Branch: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="branch_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($branch_obj);$i++) { ?>
			                <option <?php if($branch_obj[$i]["branch_id"] == $branch_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $branch_obj[$i]["branch_id"]; ?>"><?php echo $branch_obj[$i]["branch_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">List Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="list_name" value="<?php echo $list_name; ?>" placeholder="Distribution List Name">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">List Description: </label>
					<div class="col-md-9">
						<textarea id="list_description" class="form-control" placeholder="Description"><?php echo $list_description; ?></textarea>
					</div>
				</div>
					<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">List Type: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="list_type_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($listTyp_Obj);$i++) { ?>
			                <option <?php if($listTyp_Obj[$i]["list_type_id"] == $list_type_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $listTyp_Obj[$i]["list_type_id"]; ?>"><?php echo $listTyp_Obj[$i]["list_type_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_this_distribution_list('<?php echo $_POST['list_id']; ?>','<?php echo $_POST['menu_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="conact_form_div"></div>	
			</div>
		</div>
	</div>
</div>
