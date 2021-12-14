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
require_once("../model/payments.class.php");
require_once("../model/payment_mode.class.php");
require_once("../model/credit_note.class.php");
require_once("../model/invoiceOrder.class.php");

$invoiceObj				=new invoice($_POST['invoice_id']);
$paymentObj				=new payment();
$invoice_payments		=$paymentObj->load_invoice_payments($_POST['invoice_id']);
$creditnoteObj			=new credit_note();
$invoice_credit_notes	=$creditnoteObj->get_invoice_credit_notes($_POST['invoice_id']);
$total_payments		=0;
for($i=0;$i<count($invoice_payments);$i++)
{
	$total_payments+=$invoice_payments[$i]["payment_amount"];
}
if($_POST['credit_note_id']==-1)
{
	//$credit_note_obj=new credit_note($_POST['credit_note_id']);
	$text=$invoiceObj->invoice_number.">> New credit note";
}
else
{
	$credit_note_obj=new credit_note($_POST['credit_note_id']);
	$text=$invoiceObj->invoice_number."&nbsp;/&nbsp;".$credit_note_obj->credit_note_number;
}
?>

<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title"><?php echo $text; ?></h4>
			<?php //print_r($_POST); ?>
		
		<div class="modal-body">
			<?php
			if($_POST['credit_note_id']==-1)
			{
			?>
			<div class="row">
				<?php
					if($total_payments==0)
						echo "<div class='alert alert-warning'>There are not payments recorded for this invoice , thus you cannot create a credit note</div>";
					else
					{
						$orderObj 			= new invoiceOrder();
						$invoiceObj			=new invoice($_POST['invoice_id']);
						$av_invoice_orders	=$orderObj->load_active_invoice_orders($_POST['invoice_id']);
						$array=array();
				?>
				<table class="table table-primary table-bordered table-hover">
						<thead>
							<th>#</th>
							<th>Billing Item</th>
							<th>rate</th>
							<th>Discount</th>
							<th>Vat</th>
							<th>Price</th>
							<th>Prev. C.note</th>
							<th>Remaining</th>
							<th>Credit Amount</th>
						</thead>   
						<tbody>
							<?php
								
								$total_rate     =0;
								$total_discount =0;
								$total_tax      =0;
								$total_gross    =0;
								$consumption	=($invoiceObj->invoice_amount_paid-$creditnoteObj->get_total_invoice_credit_notes($_POST['invoice_id']));
								for($i=0;$i<count($av_invoice_orders);$i++)
								{
									$total_credit_notes=$creditnoteObj->get_total_credit_notes($av_invoice_orders[$i]["order_id"]);
									
									array_push($array,$av_invoice_orders[$i]["order_id"]);
									$final_price=$av_invoice_orders[$i]["order_rate"]-$av_invoice_orders[$i]["discount_amount"]+ $av_invoice_orders[$i]["tax_amount"];
									$total_rate+=$av_invoice_orders[$i]["order_rate"];
									$total_discount+=$av_invoice_orders[$i]["discount_amount"];
									$total_tax+=$av_invoice_orders[$i]["tax_amount"];
									$allowed	=$final_price-$total_credit_notes;
									$total_gross+=$final_price;
									

									if($consumption < $allowed) 
									{
										$credit_amount=$consumption; 
									}
									else 
										$credit_amount=$allowed;
										
									$consumption	-=$credit_amount;
									?>
									<tr>
										<td style="width:40px"><?php echo $i+1; ?></td>
										<td><?php echo $av_invoice_orders[$i]["item_description"]; ?><br/><span style="font-size:7px"><?php echo $av_invoice_orders[$i]["order_date_created"]; ?></span></td>
										<td style="width:90px"><?php echo $av_invoice_orders[$i]["order_rate"]; ?></td>
										<td style="width:90px"><?php echo $av_invoice_orders[$i]["discount_amount"]; ?></td>
										<td style="width:90px"><?php echo $av_invoice_orders[$i]["tax_amount"]; ?></td>
										<td style="width:90px">
											<?php
											
											echo $final_price; 
											?>
										</td>
										<td style="width:90px"><?php echo $total_credit_notes; ?></td>
										<td style="width:90px"><?php echo $final_price-$total_credit_notes; ?></td>

										<td style="width:90px">
											<input type="text" id="credit_rate_<?php echo $av_invoice_orders[$i]["order_id"]; ?>" value="<?php echo $credit_amount; ?>" class="input-sm form-control">
										</td>
									</tr>
							<?php
								}
							?>
							<tr style="background-color:#e2e3e4">
								<td colspan="4" style="text-align:right">Total Prev. Cr.notes</td>
								<td colspan="1"><b><?php echo $creditnoteObj->get_total_invoice_credit_notes($_POST['invoice_id']); ?></b></td>
								<td colspan="2" style="text-align:right">Allowed Cr. notes</td>
								<td colspan="2" class=""><?php echo $invoiceObj->invoice_amount_paid-$creditnoteObj->get_total_invoice_credit_notes($_POST['invoice_id']); ?></td>
							</tr>							
							
							<tr>

								<td colspan="4" style="text-align:right">Total Rate</td>
								<td colspan="1"><b><?php echo $total_rate; ?></b></td>
								<td colspan="2" style="text-align:right">Total Gross</td>
								<td colspan="2" class="success"><?php echo $total_gross; ?></td>
							</tr>
							
							<tr>
								<td colspan="4" style="text-align:right">Total Discount</td>
								<td colspan="1"><b><?php echo $total_discount; ?></b></td>
								<td colspan="2" style="text-align:right">Total Due</td>
								<td colspan="2" class="danger"><?php echo $invoiceObj->invoice_total_amount-$invoiceObj->invoice_amount_paid; ?></td>
							</tr>	

							<tr>
								<td colspan="4" style="text-align:right">Total VAT</td>
								<td colspan="1"><b><?php echo $total_tax; ?></b></td>
								<td colspan="2" style="text-align:right">Total Paid</td>
								<td colspan="2" class="info"><?php echo $invoiceObj->invoice_amount_paid; ?></td>
							</tr>
						</tbody>
				</table>				
				
			</div>
			<div class="row">
				<hr/>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<textarea id="credit_note_comment" class="form-control"></textarea>
				</div>
			</div>
			
			<div class="row">
				<hr/>
			</div>
			<div class="row">
				<input type="button" class="btn btn-primary pull-right" 
				onclick="submit_save_credit_note('<?php echo $_POST['invoice_id']; ?>','<?php echo $_POST['credit_note_id']; ?>','<?php echo implode(",",$array); ?>','<?php echo $creditnoteObj->get_total_invoice_credit_notes($_POST['invoice_id']); ?>','<?php echo $total_tax; ?>','<?php echo $credit_amount; ?>','<?php echo $credit_amount; ?>')" value="Save Credit note"/>
			</div>

			
			<div class="row">
				<div id="credit_note_form_div" class="col-lg-12">
					
				</div>
			</div>
			<?php
				}
			}
		else
			{
				$credit_note_obj=new credit_note($_POST['credit_note_id']);
				$credit_note_details=$credit_note_obj->get_credit_details();
				?>
				<div class="row">
					<div class="col-lg-12">
						<div class="btn-group pull-right" style="">
							<button type="button" class="btn btn-outline"><span class="fa fa-print" title="refresh page">&nbsp;&nbsp;</span>Print</button>
							<button class="btn btn-danger" onclick="delete_invoice_order(<?php echo $_POST['credit_note_id']; ?>)"><span class="fa fa-remove">&nbsp;&nbsp;</span>Delete Credit note</button>
							<button type="button" class="btn btn-outline" onclick="load_invoice_page('<?php echo $_POST["invoice_id"]; ?>')">Confirme</button>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<hr/>
					</div>
				</div>				
				
				<div class="row">
				<div class="col-lg-12">
				<table class="table table-primary table-bordered table-hover">
					<thead>
						<th>#</th>
						<th>Order</th>
						<th>Billing Item</th>
						<th>Credit rate</th>
						<th>Vat Amount</th>
						<th>Gross</th>
					</thead>
					
					<tbody>
						<?php
						$total_rate=0;
						$total_vat=0;
						$total_gross=0;
						for($i=0;$i<count($credit_note_details);$i++)
						{
							$total_rate+=$credit_note_details[$i]["credit_order_amount"];
							$total_vat+=$credit_note_details[$i]["credit_order_vat"];
							$total_gross+=($credit_note_details[$i]["credit_order_amount"]+$credit_note_details[$i]["credit_order_vat"]);
							?>
							<tr>
								<td style="width:40px"><?php echo ($i+1); ?></td>
								<td style="width:90px"><?php echo $credit_note_details[$i]["order_auto_gen"]; ?></td>
								<td><?php echo $credit_note_details[$i]["item_description"]; ?></td>
								<td style="width:90px"><?php echo $credit_note_details[$i]["credit_order_amount"]; ?></td>
								<td style="width:90px"><?php echo $credit_note_details[$i]["credit_order_vat"]; ?></td>
								<td style="width:90px"><?php echo ($credit_note_details[$i]["credit_order_amount"]+$credit_note_details[$i]["credit_order_vat"]); ?>
							</tr>
							<?php
						}
						?>
					</tbody>
					<tfoot>
							<tr>
								<td colspan="3">&nbsp;</td>
								<td><?php echo $total_rate; ?></td>
								<td><?php echo $total_vat; ?></td>
								<td class="success"><?php echo $total_gross; ?></td>
							</tr>
					</tfoot>
				</table>
				</div>
				</div>
				<?php
			}		
		?>
		</div>
	</div>
</div>