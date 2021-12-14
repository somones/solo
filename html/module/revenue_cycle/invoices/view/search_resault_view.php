<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/invoice.class.php");

$invoiceObj			=new invoice();
$av_invoices		=$invoiceObj->get_invoice_search_json($_POST['invoice_search'],$_POST['customer_search'],$_POST['rate_plan'],$_POST['paid_status'],$_POST['date_start']);

//print_r($av_invoices);
if (count($av_invoices)==0) { ?>
	<p>Sorry There is No Results for this Search</p>
<?php }else {

for($i=0;$i<count($av_invoices);$i++)
{
?>
	<tr>
		<td><a onclick="load_invoice_page('<?php echo $av_invoices[$i]["invoice_id"]; ?>')"><?php echo $av_invoices[$i]["invoice_number"]; ?></a></td>
		<td><?php echo $av_invoices[$i]["rate_sheet_name"]; ?></td>
		<td><?php echo $av_invoices[$i]["customer_display_name"]; ?></td>
		<td><?php echo $av_invoices[$i]["customer_mobile_number"]; ?></td>
		<td><?php echo $av_invoices[$i]["invoice_date_created"]; ?></td>
		<td><?php echo $av_invoices[$i]["invoice_total_amount"]; ?></td>
		<td <?php if($av_invoices[$i]["invoice_paid"]==1){  ?> class="success" <?php } else { ?> class="danger" <?php  } ?>><?php echo $av_invoices[$i]["invoice_amount_paid"]; ?></td>
		<td <?php if($av_invoices[$i]["invoice_paid"]==1){  ?> class="success" <?php } else { ?> class="danger" <?php  } ?>><?php echo $av_invoices[$i]["invoice_total_amount"]-$av_invoices[$i]["invoice_amount_paid"]; ?></td>
	</tr>
<?php	
}
}
?>

