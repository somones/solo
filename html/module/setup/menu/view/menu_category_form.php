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

require_once("../model/category.class.php");
require_once("../model/modules.class.php");

$modulesObj 	= new modules();
$modules_obj 	= $modulesObj->list_of_modules($_SESSION['employee_id']);

if($_POST["category_id"]==-1)
{
		$category_name				="";
		$module_id_FK				="";
		$display_order				="";
}
else{
		$thiscodeObj=new category($_POST['category_id']);

		$category_name						=$thiscodeObj->category_name;
		$module_id_FK						=$thiscodeObj->module_id_FK;
		$display_order						=$thiscodeObj->display_order;
}	
?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Category</h4>
			</div>

			<div class="modal-body">
				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Menu Category Module</label>
			        <div class="col-md-9">
			          <select class="form-control" id="module_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($modules_obj);$i++) { ?>
			                <option <?php if($modules_obj[$i]["module_id"] == $module_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $modules_obj[$i]["module_id"]; ?>"><?php echo $modules_obj[$i]["module_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Category Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="category_name" value="<?php echo $category_name; ?>" placeholder="Category Name">
					</div>
				</div>

				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Display Order</label>
			        <div class="col-md-9">
			          <select class="form-control" id="display_order">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=1;$i<=10;$i++) { ?>
			                <option <?php if($display_order == $i) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_menu_category('<?php echo $_POST['category_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="modules_form_div"></div>	
			</div>
		</div>
	</div>
</div>
