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
require_once("../model/rateplan.class.php");
require_once("../model/customer.class.php");

$menu_itemObj			=new menu_item($_POST['menu_id']);
$ratesheetObj		=new rateplan();
$av_ratesheets		=$ratesheetObj->get_active_rate_sheets();

$invoiceObj			=new invoice();
$av_invoices		=$invoiceObj->load_active_invoices();
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel-body">
<div class="page-header">
	<h1>&nbsp;&nbsp;<?php echo $menu_itemObj->item_title; ?></h1>
	<div class="btn-toolbar pull-right" onclick="start_new_order('1')" style="margin-right:80px"><button class="btn btn-danger" Value="New Account"><span class="fa fa-plus">&nbsp;&nbsp;</span>New Invoice</button></div>
	<div class="btn-toolbar pull-right" style="margin-right:10px"><button class="btn btn-default" Value="New Account"><span class="fa fa-list-ul"></span></button></div>
</div>	
<script type="text/javascript">
	$(document).ready(function(){
    $("#customer_search").keyup(function(){
        var search_token = $(this).val();
        if(search_token != "") {
            $.ajax({
                url: 'invoices/controller/invoices_controller.php',
				method: 'post',
				data: 'search_token='+search_token+'&action=8',
				dataType: 'json',
                success:function(result) {
                	
                    var len = result.length;
                    var name = "";
                   	$("#search_result").empty();
                    for( var i = 0; i<len; i++){
                        var costumer_id   		= result[i]['customer_id'];
                        var costumer_name  		= result[i]['customer_display_name'];
                        name = result[i]['customer_name'];
 						$("#search_result").append("<p value='"+costumer_id+"'>"+costumer_name+"</p>");
                    }
                    $("#search_result p").bind("click",function() { 
                    	$('#customer_search').val(costumer_id);
                    	$("#search_result").empty();
                	});
                }
            });
        }
    });
});
$(document).ready(function(){
    $("#invoice_search").keyup(function(){
        var search_token = $(this).val();
        if(search_token != "") {
            $.ajax({
                url: 'invoices/controller/invoices_controller.php',
				method: 'post',
				data: 'search_token='+search_token+'&action=9',
				dataType: 'json',
                success:function(result) {
                    var len = result.length;
                   	$("#search_result_invoice").empty();
                    for( var i = 0; i<len; i++){
                        var invoice_id   			= result[i]['invoice_id'];
                        var invoice_number  		= result[i]['invoice_number'];
 						$("#search_result_invoice").append("<option value='"+invoice_number+"'>"+invoice_number);
                    }
                    $("#search_result_invoice option").bind("click",function() { 
                    	$('#invoice_search').val(invoice_number);
                    	$("#search_result_invoice").empty();
                    });
                }
            });
        }
    });
});
</script>
<div id="search_div_result"></div>
<div class="row">

	<div class="col-lg-3">
		<label class="label-control">Customer ID</label>
		<input type="text" class="input-sm  form-control" id="customer_search" list="search_result"/>
		<div id="search_result" ></div>
	</div>
	
	<div class="col-lg-3">
		<label class="label-control">Paid Status</label>
		<Select class="input-sm  form-control" name="paid_status" id="paid_status">
			<option value="">All</option>
			<option value="0">Un paid</option>
			<option value="1">paid</option>
		</select>
	</div>	
	<script type="text/javascript">//$("[id='bs-datepicker-range']").datepicker({format: 'yyyy-mm-dd'});</script>
	<div class="col-lg-6">
		<label class="label-control">Date Created</label>
		<div class="input-daterange input-group" id="bs-datepicker-range" >
			<input type="text" class="input-sm form-control" id="date_start" name="date_time_value" placeholder="date from">
			
			<span class="input-group-addon">to</span>
			<input type="text" class="input-sm form-control" id="date_end" name="date_time_value" placeholder="date till">
		</div>
	</div>
	
	<div class="col-lg-3">
		<label class="label-control">rate plan</label>
		<select  class='input-sm custom-select form-control' id="rate_plan">
			<option value="">All rate plans</option>
			<?php 
			for($i=0;$i<count($av_ratesheets);$i++)
			{
			?>
				<option value="<?php echo $av_ratesheets[$i]["rate_sheet_id"]; ?>"><?php echo $av_ratesheets[$i]["rate_sheet_name"]; ?></option>
			<?php
			}
			?>
		</select>	
	</div>	
	
	<div class="col-lg-3">
		<label class="label-control">Invoice #</label>
		<input type="text" class="input-sm  form-control" id="invoice_search" list="search_result_invoice" />
		<datalist id="search_result_invoice"></datalist>
	</div>	
	
	<div class="col-lg-3">
		<label class="label-control">&nbsp;</label>
		<div class="form-control" style="border:none;bg-color:none"><input type="button" class="input-sm btn btn-primary" onclick="get_result_of_invoice_search()" value="search"/></div>
	</div>
	
</div>
<div class="row">
	<hr/>
</div>
<?php
if(count($av_invoices)==0)
{
	echo "<div class='alert alert-info'>There are no Sales Orders Created , Click on New Sales Order to start Managing your sales activity</div>";
}
else
{
?>
<table class="table table-primary table-bordered table-hover">

<thead>
	<th>Invoice #</th>
	<th>rate plan</th>
	<th>Customer</th>
	<th>Mobile</th>
	<th>Data Created</th>
	<th>Amount Gross</th>
	<th>Amount Paid</th>
	<th>Due</th>
</thead>

<tbody id="table_result">
<?php
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
?>
</tbody>

</table>
<?php	
}
?>
</div>
</div>
</div>