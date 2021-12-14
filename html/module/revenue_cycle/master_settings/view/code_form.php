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
require_once("../model/code.class.php");
require_once("../model/code_type.class.php");

$codetypeObj 	= new code_type();
$codetype_obj 	= $codetypeObj->list_of_code_type($_SESSION['employee_id']);

if($_POST["code_id"]==-1)
{
		$role_description		="";
		$code_type_id_FK		="";
		$code_value				="";
		$code_short_description	="";
		$code_description       ="";
		$code_active			="";
}
else{
		$thiscodeObj=new rc_code($_POST['code_id']);

		$code_type_id_FK		=$thiscodeObj->code_type_id_FK;
		$code_value				=$thiscodeObj->code_value;
		$code_short_description	=$thiscodeObj->code_short_description;
		$code_description       =$thiscodeObj->code_description;
		$code_active			=$thiscodeObj->code_active;

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
			    </div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Code Value: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="code_value" value="<?php echo $code_value; ?>" placeholder="Code Value">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Code Short Description: </label>
					<div class="col-md-9">
						<textarea id="code_short_description" class="form-control" placeholder="Short Description"><?php echo $code_short_description; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Code Description: </label>
					<div class="col-md-9">
						<textarea id="code_description" class="form-control" placeholder="Code Description"><?php echo $code_description; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_code('<?php echo $_POST['code_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="code_form_div"></div>	
			</div>
		</div>
	</div>
</div>
