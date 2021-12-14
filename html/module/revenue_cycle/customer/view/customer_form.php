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
require_once("../model/customer.class.php");

$branchObj 	= new branch();
$branch_obj 	= $branchObj->get_active_branches($_SESSION['employee_id']);

if($_POST["customer_id"]==-1)
{
	$customer_name				="";
	$customer_display_name		="";
	$customer_email				="";
	$customer_mobile_number		="";
	$branch_id_FK       		="";
}
else{
	$thiscodeObj=new customer($_POST['customer_id']);
	
	$customer_name				=$thiscodeObj->customer_name;
	$customer_display_name		=$thiscodeObj->customer_display_name;
	$customer_email				=$thiscodeObj->customer_email;
	$customer_mobile_number		=$thiscodeObj->customer_mobile_number;
	$branch_id_FK       		=$thiscodeObj->branch_id_FK;
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
			        <label for="grid-input-3" class="col-md-3 control-label">Customer Branch</label>
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
					<label for="grid-input-1" class="col-md-3 control-label">Customer Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="customer_name" value="<?php echo $customer_name; ?>" placeholder="Customer Name">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Customer Display Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="customer_display_name" value="<?php echo $customer_display_name; ?>" placeholder="Customer Display Name">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Customer Email: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="customer_email" value="<?php echo $customer_email; ?>" placeholder="Customer Email">
					</div>
				</div>
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Customer Number: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="customer_mobile_number" value="<?php echo $customer_mobile_number; ?>" placeholder="Customer Number">
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_customer('<?php echo $_POST['customer_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="customer_form_div"></div>	
			</div>
		</div>
	</div>
</div>