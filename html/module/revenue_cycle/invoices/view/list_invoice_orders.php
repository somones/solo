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
require_once("../model/invoiceOrder.class.php");
//print_r($_POST);
$orderObj = new invoiceOrder();
$av_invoice_orders=$orderObj->load_active_invoice_orders($_POST['invoice_id']);
$invoiceObj=new invoice($_POST['invoice_id']);

if(count($av_invoice_orders)==0)
{
	echo "<br/><br/><div class='alert alert-info'>There are no Services Added , Select a service from the search box and click on add , inorder to start Billing</div>";
}
else
{
	$array=array();
    ?>
	<?php //print_r($av_invoice_orders); ?>
<table class="table table-primary table-bordered table-hover">
    <thead>
            <th></th>
            <th>#</th>
            <th>Date</th>    
            <th>Billing Item</th>
            <th>rate</th>
            <th>Discount</th>
            <th>Vat</th>
            <th>Price</th>
        </thead>   
        <tbody>
            <?php
                $total_rate     =0;
                $total_discount =0;
                $total_tax      =0;
                $total_gross    =0;
                for($i=0;$i<count($av_invoice_orders);$i++)
                {
					array_push($array,$av_invoice_orders[$i]["order_id"]);
                    $final_price=$av_invoice_orders[$i]["order_rate"]-$av_invoice_orders[$i]["discount_amount"]+ $av_invoice_orders[$i]["tax_amount"];
                    $total_rate+=$av_invoice_orders[$i]["order_rate"];
                    $total_discount+=$av_invoice_orders[$i]["discount_amount"];
                    $total_tax+=$av_invoice_orders[$i]["tax_amount"];
                    $total_gross+=$final_price;
                    ?>
                    <tr>
                        <td style="width:40px"><i class="fa fa-remove"></i></td>
                        <td style="width:40px"><?php echo $i+1; ?></td>
                        <td style="width:150px"><?php echo $av_invoice_orders[$i]["order_date_created"]; ?></td>
                        <td><?php echo $av_invoice_orders[$i]["item_description"]; ?></td>
                        <td style="width:90px;padding:0px;margin:0px"><input id="order_rate_<?php echo $av_invoice_orders[$i]["order_id"]; ?>" style="width:90px" class="input-sm form-control" type="text" value="<?php echo $av_invoice_orders[$i]["order_rate"]; ?>" /></td>
                        <td style="width:90px;padding:0px;margin:0px"><input id="order_discount_<?php echo $av_invoice_orders[$i]["order_id"]; ?>" style="width:90px" class="input-sm form-control" type="text" value="<?php echo $av_invoice_orders[$i]["discount_amount"]; ?>" /></td>
                        <td style="width:90px"><?php echo $av_invoice_orders[$i]["tax_amount"]; ?></td>
                        <td style="width:90px">
                            <?php
                            echo $final_price; 
                            ?>
                        </td>
                    </tr>
            <?php
                }
            ?>
			<tr>
				<td colspan="5" id="update_orders_div"></td>
				<td colspan="2">
						<button style="width:100%" class="btn btn-primary" onclick="submit_update_order_rates('<?php echo $_POST['invoice_id']; ?>','<?php echo implode(",",$array); ?>')"><span class="fa fa-save">&nbsp;&nbsp;</span>Update rates</button>
				</td>
				<td colspan="2">&nbsp;</td>
			</tr>
            <tr>

                <td colspan="4" style="text-align:right">Total Rate</td>
                <td><b><?php echo $total_rate; ?></b></td>
				<td colspan="2" style="text-align:right">Total Gross</td>
				<td colspan="2" class="success"><?php echo $total_gross; ?></td>
            </tr>
			
            <tr>
				<td colspan="4" style="text-align:right">Total Discount</td>
                <td><b><?php echo $total_discount; ?></b></td>
				<td colspan="2" style="text-align:right">Total Due</td>
                <td colspan="2" class="danger"><?php echo $invoiceObj->invoice_total_amount-$invoiceObj->invoice_amount_paid; ?></td>
            </tr>	

            <tr>
				<td colspan="4" style="text-align:right">Total VAT</td>
                <td><b><?php echo $total_tax; ?></b></td>
				<td colspan="2" style="text-align:right">Total Paid</td>
                <td colspan="2" class="info"><?php echo $invoiceObj->invoice_amount_paid; ?></td>
            </tr>						
        </tbody>
    </table>
<?php    
}
?>