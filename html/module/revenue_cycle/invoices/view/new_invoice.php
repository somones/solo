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

require_once("../model/invoice.class.php");
require_once("../model/customer.class.php");
require_once("../model/rateplan.class.php");
require_once("../model/discount_plan.class.php");
require_once("../model/service.class.php");

$customerObj		=new customer();
$ratesheetObj		=new rateplan();
$discountPlabObj	=new discount_plan();
$serviceObj			=new service();
$av_customers		=$customerObj->load_av_customer();
$av_ratesheets		=$ratesheetObj->get_active_rate_sheets();
$av_discount_plans	=$discountPlabObj->get_active_discount_plans();
$av_services		=$serviceObj->get_active_services();

if(isset($_POST["customer_id"]))
		$customer_id=$_POST["customer_id"];
if(isset($_POST['invoice_id']) && $_POST['invoice_id'] <> -1)
{
	$invoice_id			=$_POST['invoice_id'];
	$invoiceObj			=new invoice($_POST['invoice_id']);
	$customer_id		=$invoiceObj->customer_id_FK;
	$rate_plan_id		=$invoiceObj->rate_plan_id_FK;
	$discount_plan_id	=$invoiceObj->discount_plan_id_FK;
}	
else
{
	$invoice_id			=-1;
	$customer_id		="";
	$rate_plan_id		="";
	$discount_plan_id	="";	
}

?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">Overview</h4>
			<?php //print_r($_POST); ?>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-lg-6">
					<label class="label-control required">Select Customer</label>
					<select id='customer_id' name='standard' class='custom-select form-control'>
						<option value="">Select Customer</option>
						<?php 
						for($i=0;$i<count($av_customers);$i++)
						{
						?>
							<option <?php if($av_customers[$i]["customer_id"]==$customer_id){ ?> selected="selected" <?php }  ?> value="<?php echo $av_customers[$i]["customer_id"]; ?>"><?php echo $av_customers[$i]["customer_display_name"]." [".$av_customers[$i]["customer_mobile_number"]."]" ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="col-lg-6">
					<label class="label-control required">Rate sheet</label>
					<select id='rate_sheet_id' name='standard' class='custom-select form-control'>
						<option value="">Select rate sheet</option>
						<?php 
						for($i=0;$i<count($av_ratesheets);$i++)
						{ 
						?>
							<option <?php if($av_ratesheets[$i]["rate_sheet_id"]==$rate_plan_id){ ?> selected="selected" <?php }  ?> value="<?php echo $av_ratesheets[$i]["rate_sheet_id"]; ?>"><?php echo $av_ratesheets[$i]["rate_sheet_name"]; ?></option>
						<?php
						}
						?>
					</select>		
				</div>	

				<div class="col-lg-6">
					<label class="label-control required">Discount Plan</label>
					<select id='discount_plan' name='standard' class='custom-select form-control'>
						<option value="">Select Discount Plan</option>
						<?php 
						for($i=0;$i<count($av_discount_plans);$i++)
						{
						?>
							<option <?php if($av_discount_plans[$i]["discount_plan_id"]==$discount_plan_id){ ?> selected="selected" <?php }  ?>  value="<?php echo $av_discount_plans[$i]["discount_plan_id"]; ?>"><?php echo $av_discount_plans[$i]["discount_plan_name"]; ?></option>
						<?php
						}
						?>
					</select>	
				</div>	
			</div>
		<hr/>
		<div id="procedure_div"></div>
		<div class="row">
			<div class="col-lg-12">
				<div class="btn-toolbar pull-right" onclick="submit_create_invoice('<?php echo $invoice_id; ?>','<?php echo $_POST['branch_id']; ?>')"><button class="btn btn-primary" Value="New Account">Save & Proceed</button></div>
			</div>
		</div>		
		<hr/>
	</div>
	</div>
</div>	



