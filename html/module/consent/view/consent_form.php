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

require_once("../model/consent.class.php");
require_once("../model/consent_category.class.php");
require_once("../model/consent_user_group.class.php");
require_once("../model/consent_object_type.class.php");
//print_r($_POST);

$user_groupObj							=new consent_user_group();
$consent_group				    		=$user_groupObj->list_of_consent_user_group($_SESSION['employee_id']);

$consent_categoryObj					=new consent_category();
$consent_category_Obj				    =$consent_categoryObj->list_of_consent_category($_SESSION['employee_id']);

$consentObj								=new consent();
$consent_Obj				    		=$consentObj->get_this_consent(1);


$typObj									=new consent_object_type();
$typ_Obj				    			=$typObj->list_of_all_object_type($_SESSION['employee_id']);

$branchObj 	= new branch();
$branch_Obj	= $branchObj->get_active_branches();

if($_POST["consent_id"]==-1)
{
		$consent_title					="";
		$consent_description			="";
		$category_id_FK					="";
		$category_id_FK					="";
		$branch_id_FK					=array();

		$admin_signature_required		="";
		$patient_signature_required		="";
		$doctor_signature_required		="";

		$admin_x 						="";
		$admin_y						="";
		$admin_w						="";
		$admin_page						="";
		$pat_x							="";
		$pat_y							="";
		$pat_w							="";
		$pat_page						="";
		$doc_x							="";
		$doc_y							="";
		$doc_w							="";
		$doc_page						="";
}
else {
		$thiscodeObj= new consent($_POST['consent_id']);

		$consent_title						=$thiscodeObj->consent_title;
		$consent_description				=$thiscodeObj->consent_description;
		$category_id_FK						=$thiscodeObj->category_id_FK;
		$category_id_FK						=$thiscodeObj->category_id_FK;
		$branch_id_FK						=$thiscodeObj->get_consent_branch($_POST['consent_id']);

		$admin_signature_required			=$thiscodeObj->admin_signature_required;
		$patient_signature_required			=$thiscodeObj->patient_signature_required;
		$doctor_signature_required			=$thiscodeObj->doctor_signature_required;

		$admin_x 							=$thiscodeObj->admin_x;
		$admin_y							=$thiscodeObj->admin_y;
		$admin_w							=$thiscodeObj->admin_w;
		$admin_page							=$thiscodeObj->admin_page;
		$pat_x								=$thiscodeObj->pat_x;
		$pat_y								=$thiscodeObj->pat_y;
		$pat_w								=$thiscodeObj->pat_w;
		$pat_page							=$thiscodeObj->pat_page;
		$doc_x								=$thiscodeObj->doc_x;
		$doc_y								=$thiscodeObj->doc_y;
		$doc_w								=$thiscodeObj->doc_w;
		$doc_page							=$thiscodeObj->doc_page;
}
?>
<style type="text/css">
	.hr-sect {
	display: flex;
	flex-basis: 100%;
	align-items: center;
	color: rgba(0, 0, 0, 0.35);
	margin: 8px 0px;
}
.hr-sect::before,
.hr-sect::after {
	content: "";
	flex-grow: 1;
	background: rgba(0, 0, 0, 0.35);
	height: 1px;
	font-size: 0px;
	line-height: 0px;
	margin: 0px 8px;
}
</style>
<script type="text/javascript" src="../assets/JS/contact.js"/></script>

<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Consent</h4>
				<?php //print_r($consent_group_id_FK); ?>
			</div>

			<div class="modal-body">	
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Consent Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="consent_title" value="<?php echo $consent_title; ?>" placeholder="Consent Name">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Consent Description: </label>
					<div class="col-md-9">
						<textarea class="form-control" id="consent_description" rows="8" placeholder="Consent Description"><?php echo $consent_description; ?></textarea>
					</div>
				</div>

				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Consent Category: </label>
			        <div class="col-md-9">
			          <select class="form-control" id="category_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($consent_category_Obj);$i++) { ?>
			                <option <?php if($consent_category_Obj[$i]["consent_category_id"] == $category_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $consent_category_Obj[$i]["consent_category_id"]; ?>"><?php echo $consent_category_Obj[$i]["consent_category_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

			    <div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label" >Consent Branch: </label>
					<div class="col-md-9">
						<select class="form-control select2-example" id="branch_id_FK" multiple style="width: 100%">
							<?php for($i=0;$i<count($branch_Obj);$i++) { ?>
				            <option <?php if(in_array($branch_Obj[$i]["branch_id"],$branch_id_FK)) { ?> selected="selected" <?php  }   ?> value="<?php echo $branch_Obj[$i]["branch_id"]; ?>"><?php echo $branch_Obj[$i]["branch_name"]; ?></option>
				            <?php } ?>
				        </select>
					</div>
				</div>
				<div class="form-group"></div>

				<?php //get_this_consent ?>
				<!--<div class="form-group">
	            <label class="col-sm-3 control-label">Required Signature</label>
	            <div class="col-sm-9">
	            	<div class="checkbox col-sm-3">
	                	<label>
	                		<input type="checkbox" value="1" id="admin_signature_required"  <?php if ($admin_signature_required == 1 ) { ?>
	                		checked="checked"<?php } ?> ><b>Administration</b>
	            		</label>
	            	</div>
	            	<div class="row col-sm-9" id="admin_par" <?php if ($_POST["consent_id"] == -1) { ?>style="display: none" <?php } ?> >
	            		<div class="col-lg-3">
							<label class="label-control">X Position</label>
							<input type="text" class="input-sm  form-control" id="admin_x" value="<?php echo $admin_x; ?>" />
						</div>
						<div class="col-lg-3">
							<label class="label-control">Y Position</label>
							<input type="text" class="input-sm  form-control" id="admin_y" value="<?php echo $admin_y; ?>"/>
						</div>
						<div class="col-lg-3">
							<label class="label-control">Width</label>
							<input type="text" class="input-sm  form-control" id="admin_w" value="<?php echo $admin_w; ?>"/>
						</div>
						<div class="col-lg-3">
							<label class="label-control">Page</label>
							<input type="text" class="input-sm  form-control" id="admin_page" value="<?php echo $admin_page; ?>"/>
						</div>
	            	</div>
	            </div>
	             <label class="col-sm-3 control-label"></label>
	            <div class="col-sm-9">
	            	<div class="checkbox col-sm-3">
	                	<label><input type="checkbox" id="patient_signature_required" value="1" <?php if ($patient_signature_required == 1 ) { ?>
	                	checked="checked"
	                <?php } ?> ><b>Patient</b></label>
	            	</div>
	            	<div class="row col-sm-9" id="ptient_par" <?php if ($_POST["consent_id"] == -1) { ?>style="display: none" <?php } ?> >
	            		<div class="col-lg-3">
							<label class="label-control">X Position</label>
							<input type="text" class="input-sm  form-control" id="pat_x" value="<?php echo $pat_x; ?>"/>
						</div>
						<div class="col-lg-3">
							<label class="label-control">Y Position</label>
							<input type="text" class="input-sm  form-control" id="pat_y" value="<?php echo $pat_y; ?>"/>
						</div>
						<div class="col-lg-3">
							<label class="label-control">Width</label>
							<input type="text" class="input-sm  form-control" id="pat_w" value="<?php echo $pat_w; ?>"/>
						</div>
						<div class="col-lg-3">
							<label class="label-control">Page</label>
							<input type="text" class="input-sm  form-control" id="pat_page" value="<?php echo $pat_page; ?>"/>
						</div>
	            	</div>
	            </div>
	             <label class="col-sm-3 control-label"></label>
	            <div class="col-sm-9">
	            	<div class="checkbox col-sm-3">
	                	<label><input type="checkbox" id="doctor_signature_required" value="1" <?php if ($doctor_signature_required == 1 ) { ?>
	                	checked="checked"
	                <?php } ?> ><b>Doctor</b></label>
	            	</div>
	            	<div class="row col-sm-9" id="doctor_par" <?php if ($_POST["consent_id"] == -1) { ?>style="display: none" <?php } ?> >
	            		<div class="col-lg-3">
							<label class="label-control">X Position</label>
							<input type="text" class="input-sm  form-control" id="doc_x" value="<?php echo $doc_x; ?>"/>
						</div>
						<div class="col-lg-3">
							<label class="label-control">Y Position</label>
							<input type="text" class="input-sm  form-control" id="doc_y" value="<?php echo $doc_y; ?>"/>
						</div>
						<div class="col-lg-3">
							<label class="label-control">Width</label>
							<input type="text" class="input-sm  form-control" id="doc_w" value="<?php echo $doc_w;  ?>"/>
						</div>
						<div class="col-lg-3">
							<label class="label-control">Page</label>
							<input type="text" class="input-sm  form-control" id="doc_page" value="<?php echo $doc_page; ?>"/>
						</div>
	            	</div>
	            </div>
	          </div>-->

				
				<div class="hr-sect">Define Rules</div>
				<div class="form-group">
					<div class="table-repsonsive">
					    <span id="error"></span>
					    <table class="table table-bordered" id="item_table">
					      <tr>
					       	<th>Send it to</th>
					       	<th>X Position</th>
					       	<th>Y Position</th>
					       	<th>Width</th>
					       	<th>Page</th>
					       	<th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span></button></th>
					      </tr>
					     </table>
					</div>
				</div>

				<div class="form-group pull-right">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_this_consent('<?php echo $_POST['consent_id']; ?>')" name="submit">Save Form</button>
					</div>
					<div class="col-md-offset-3 col-md-9"></div>
				</div>
			</div>
			<div id="consent_form_div"></div>
			<div id="consent_form_div_error"></div>
		</div>
		
	</div>
</div>

<script>
$(document).ready(function(){
	$(document).on('click', '.add', function() {
  		var html = '';
  		html += '<tr>';
  		html += '<td style="width: 30%"><select class="form-control" id="typ_Obj" name="typ_Obj"><option value="" selected="selected">Select...</option><?php for($i=0;$i<count($typ_Obj);$i++) { ?><option value="<?php echo $typ_Obj[$i]["type_id"]; ?>"><?php echo $typ_Obj[$i]["type_name"]; ?></option><?php } ?></select></td>';
  		html += '<td><input type="text" class="form-control" id="position_x" name="position_x[]"></td>';
  		html += '<td><input type="text" class="form-control" id="position_y" name="position_y[]"></td>';
  		html += '<td><input type="text" class="form-control" id="width" name="width[]"></td>';
  		html += '<td><input type="text" class="form-control" id="page" name="page[]"></td>';

  		html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
  		$('#item_table').append(html);
 	});
 
 	$(document).on('click', '.remove', function(){
  		$(this).closest('tr').remove();
 	});
});
</script>
<script type="text/javascript">
	$(function() {
      $('.select2-example').select2({
        placeholder: 'Select value',
      });
    });
</script>

<script type="text/javascript">
	$(function () {
        $("#admin_signature_required").click(function () {
            if ($(this).is(":checked")) {
                $("#admin_par").show();
            } else {
                $("#admin_par").hide();
            }
        });
    });

    $(function () {
        $("#patient_signature_required").click(function () {
            if ($(this).is(":checked")) {
                $("#ptient_par").show();
            } else {
                $("#ptient_par").hide();
            }
        });
    });

    $(function () {
        $("#doctor_signature_required").click(function () {
            if ($(this).is(":checked")) {
                $("#doctor_par").show();
            } else {
                $("#doctor_par").hide();
            }
        });
    });

</script>


