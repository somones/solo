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
require_once("../model/messages_template_categorie.class.php");
require_once("../model/messages_template.class.php");

$messages_template_categorieObj 	= new messages_template_categorie();
$messages_template_categorie_Obj	= $messages_template_categorieObj->list_of_messages_template_categorie();

if($_POST["message_template_id"]==-1)
{
		$message_template_name							="";
		$message_template_description					="";
		$message_template_categorie_id_FK				="";
}
else {
		$thiscodeObj= new messages_template($_POST['message_template_id']);

		$message_template_name							=$thiscodeObj->message_template_name;
		$message_template_description					=$thiscodeObj->message_template_description;
		$message_template_categorie_id_FK				=$thiscodeObj->message_template_categorie_id_FK;
}
?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Contact</h4>
				<?php //print_r($employee_Obj); ?>
			</div>

			<div class="modal-body">	
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Message Template Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="message_template_name" value="<?php echo $message_template_name; ?>" placeholder="Message Template Name">
					</div>
				</div>

				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Message Template Categery: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="message_template_categorie_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($messages_template_categorie_Obj);$i++) { ?>
			                <option <?php if($messages_template_categorie_Obj[$i]["message_templates_categories_id"] == $message_template_categorie_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $messages_template_categorie_Obj[$i]["message_templates_categories_id"]; ?>"><?php echo $messages_template_categorie_Obj[$i]["message_templates_categories_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

			    <div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Message Template Description: </label>
					<div class="col-md-9">
						<textarea id="message_template_description" class="form-control" placeholder="Description"><?php echo $message_template_description; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_this_templates('<?php echo $_POST['message_template_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="conact_form_div"></div>	
			</div>
		</div>
	</div>
</div>
