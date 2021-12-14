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

require_once("../model/modules.class.php");

//$codetypeObj 	= new code_type();
//$codetype_obj 	= $codetypeObj->list_of_code_type($_SESSION['employee_id']);

if($_POST["module_id"]==-1)
{
		$module_name			="";
		$module_base_url		="";
		$module_url				="";
		$path_to_assets			="";
		$display_order       	="";
}
else{
		$thiscodeObj=new modules($_POST['module_id']);

		$module_name					=$thiscodeObj->module_name;
		$module_base_url				=$thiscodeObj->module_base_url;
		$module_url						=$thiscodeObj->module_url;
		$path_to_assets       			=$thiscodeObj->path_to_assets;
		$display_order					=$thiscodeObj->display_order;

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
				<!--<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Code Type</label>
			        <div class="col-md-9">
			          <select class="form-control" id="code_type_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($codetype_obj);$i++) { ?>
			                <option <?php if($codetype_obj[$i]["code_type_id"] == $code_type_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $codetype_obj[$i]["code_type_id"]; ?>"><?php echo $codetype_obj[$i]["code_type_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>-->
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Module Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="module_name" value="<?php echo $module_name; ?>" placeholder="Code Value">
					</div>
				</div>

				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Module URL: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="module_url" value="<?php echo $module_url; ?>" placeholder="Code Value">
						<small style="color: red">ex: html/module/setup/setup_main_view.php</small>
					</div>

				</div>

				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_module('<?php echo $_POST['module_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="modules_form_div"></div>	
			</div>
		</div>
	</div>
</div>
