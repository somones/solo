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
require_once("../model/credit_note.class.php");
require_once("../model/payments.class.php");

$paymentObj          =new payment();
$av_payments         =$paymentObj->load_invoice_payments($_POST['invoice_id']);
$creditnoteObj		 =new credit_note();
$invoice_credit_notes=$creditnoteObj->get_invoice_credit_notes($_POST['invoice_id']);
?>
<hr>
<?php

if(count($av_payments)==0)
{
    	echo "<div class='alert alert-info'>There are no payments recorded yet for this invoice..</div>";

}
else
{
	?>
		<table class="table table-responsive table-bordered table-primary table-hover">
			<thead>
				<th colspan="9">Payments Recorded</th>
			</thead>			
			<thead>
					<th></th>
					<th></th>
					<th>#</th>
					<th>Reciept</th>
					<th>Date</th>
					<th>Amount</th>
					<th>Mode</th>
					<th>Reference</th>
					<th>Notes</th>
				</thead>
				<tbody>
					<?php
					for($i=0;$i<count($av_payments);$i++)
					{
					?>
						<tr>
							<td style="width:40px"><i class="fa fa-edit"></i></td>
							<td style="width:40px"><i class="fa fa-remove"></i></td>
							<td style="width:40px"><?php echo $i+1; ?></td>
							<td style="width:90px"><?php echo $av_payments[$i]["reciept_number"]; ?></td>
							<td style="width:200px"><?php echo $av_payments[$i]["payment_time_stamp"]; ?></td>
							<td style="width:90px" class="info"><?php echo $av_payments[$i]["payment_amount"]; ?></td>
							<td style="width:150px"><?php echo $av_payments[$i]["payment_mode_name"]; ?></td>
							<td style="width:90px"><?php echo $av_payments[$i]["payment_reference_number"]; ?></td>
							<td><?php echo $av_payments[$i]["payment_notes"]; ?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
		</table>
	<?php
}
if(count($invoice_credit_notes)>0)
{
	?>
		<table class="table table-responsive table-bordered table-primary table-hover">
			<thead>
				<th colspan="9">Credit Notes</th>
			</thead>			
			<thead>
					<th></th>
					<th></th>
					<th>#</th>
					<th>Trans. #</th>
					<th>Date</th>
					<th>Amount</th>
					<th>Notes</th>
				</thead>
				<tbody>
					<?php
					for($i=0;$i<count($invoice_credit_notes);$i++)
					{
					?>
						<tr>
							<td style="width:40px"><i class="fa fa-edit"></i></td>
							<td style="width:40px"><i class="fa fa-remove"></i></td>
							<td style="width:40px"><?php echo $i+1; ?></td>
							<td style="width:90px"><?php echo $invoice_credit_notes[$i]["credit_note_number"]; ?></td>
							<td style="width:150px"><?php echo $invoice_credit_notes[$i]["credit_date_created"]; ?></td>
							<td style="width:90px" class="info"><?php echo $invoice_credit_notes[$i]["credit_gross_amount"]; ?></td>
							<td style="width:90px"></td>
						</tr>
					<?php
					}
					?>
				</tbody>
		</table>
	<?php
	
}