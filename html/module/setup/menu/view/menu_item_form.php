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
require_once("../model/menu_items.class.php");

$categoryObj 	= new category();
$category_obj 	= $categoryObj->list_menu_category($_SESSION['employee_id']);

if($_POST["item_id"]==-1)
{
		$category_id_FK				="";
		$item_title					="";
		$page_path					="";
}
else{
		$thiscodeObj=new menu_items($_POST['item_id']);

		$category_id_FK						=$thiscodeObj->category_id_FK;
		$item_title							=$thiscodeObj->item_title;
		$page_path							=$thiscodeObj->page_path;
}	
?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Code</h4>
			</div>

			<div class="modal-body">
				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Menu Item Category</label>
			        <div class="col-md-9">
			          <select class="form-control" id="category_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($category_obj );$i++) { ?>
			                <option <?php if($category_obj [$i]["category_id"] == $category_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $category_obj [$i]["category_id"]; ?>"><?php echo $category_obj [$i]["category_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Menu Item Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="item_title" value="<?php echo $item_title; ?>" placeholder="Menu Item Name">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Menu Item Page: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="page_path" value="<?php echo $page_path; ?>" placeholder="Menu Item Page">
						<small style="color: red">ex: html/module/setup/menu/view/menu_item_main_view.php</small>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_menu_item('<?php echo $_POST['item_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="modules_form_div"></div>	
			</div>
		</div>
	</div>
</div>
