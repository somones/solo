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
require_once("../model/payment_mode.class.php");



$invoiceObj			= new invoice($_POST['invoice_id']);
$paymentModeObj		=new paymentMode();
$av_payment_modes	=$paymentModeObj->load_payment_modes();

?>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title"><?php if($_POST['payment_type']==1) echo "Payment"; else echo "Refund"; ?></h4>
		</div>

				
<?php

if($_POST['payment_type']==2)
{
	$text="Enter Amount ( Amount should not exceed Payments = ".$invoiceObj->invoice_amount_paid.")";
	$default_value=$invoiceObj->invoice_amount_paid;
}
else
{
	$text="Enter Amount ( Amount Should not exceed Dues ".($invoiceObj->invoice_total_amount-$invoiceObj->invoice_amount_paid).")";
	$default_value=$invoiceObj->invoice_total_amount-$invoiceObj->invoice_amount_paid;

}
?>
<div class="modal-body">
			<div class="row">
				<div class="col-lg-6">
					<label class="label-control required"><?php echo $text; ?></label>
					<input type="text" id="payment_amount" class="form-control" value="<?php echo $default_value; ?>">
				</div>
				
				
				<div class="col-lg-6">
					<label class="label-control required">Select Payment Mode</label>
					<select id='payment_mode_id' name='standard' class='custom-select form-control'>
						<option value="">Select Payment Mode</option>
						<?php 
						for($i=0;$i<count($av_payment_modes);$i++)
						{
							if($_POST['payment_type'] ==2  && $av_payment_modes[$i]["apply_on_refund"]==0)
								continue;
						?>
							<option value="<?php echo $av_payment_modes[$i]["payment_mode_id"]; ?>"><?php echo $av_payment_modes[$i]["payment_mode_name"]; ?></option>
						<?php
						}
						?>
					</select>
				</div>
				
				<div class="col-lg-6">
					<label class="label-control required">Reference #</label>
					<input type="text" id="payment_reference_number" class="form-control">
				</div>
				<div class="col-lg-6">
					<label class="label-control">Payment Notes</label>
					<textarea class="form-control" id="payment_notes"></textarea>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<hr/>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
					<div class="btn-toolbar pull-right" onclick="submit_save_payment('<?php echo $_POST['invoice_id']; ?>','<?php echo $_POST['payment_type']; ?>')"><button class="btn btn-primary" Value="New Account">Save Payment</button></div>
			</div>
		</div>
		<hr/>
		<div id="payment_div" class="row"></div>		
	</div>
</div>	



