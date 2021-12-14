
<style>
.autocomplete-suggestions { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-no-suggestion { padding: 2px 5px;}
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: bold; color: #000; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { font-weight: bold; font-size: 16px; color: #000; display: block; border-bottom: 1px solid #000; }	

  </style>


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

$invoiceObj 		= new invoice($_POST['invoice_id']);
?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel-body">
<div class="page-header">
	<h1>&nbsp;&nbsp;<?php echo "Invoice # : ".$invoiceObj->invoice_number; ?></h1>
	<div class="btn-group pull-right" style="margin-right:80px">
		<button type="button" class="btn btn-outline" onclick="load_invoice_page('<?php echo $_POST['invoice_id']; ?>')" ><span class="fa fa-refresh" title="refresh page" ></span></button>
		<button type="button" class="btn btn-outline"><span class="fa fa-envelope-o" title="refresh page" ></span></button>
		<button type="button" class="btn btn-outline"><span class="fa fa-print" title="refresh page" ></span></button>
		<button class="btn btn-danger" Value="New Account" onclick="load_payment_form('<?php echo $_POST['invoice_id'] ;?>','1')"><span class="fa fa-plus">&nbsp;&nbsp;</span>Record Payment</button>
		<div class="btn-group">
			<button type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown">more&nbsp;<i class="fa fa-caret-down"></i></button>
			<ul class="dropdown-menu">
				<li><a href="#" onclick="edit_invoice_overveiw('<?php echo $_POST['invoice_id']; ?>','1');"><span class="fa fa-edit" >&nbsp;&nbsp;</span>Edit Overview</a></li>
				<li class="divider"></li>
				<li><a href="#" onclick="start_new_order()"><span class="fa fa-plus">&nbsp;&nbsp;</span>New Invoice</a></li>
				<li><a href="#" onclick="credit_note_form('<?php echo $_POST['invoice_id']; ?>','-1')"><span class="fa fa-plus">&nbsp;&nbsp;</span>New Credit Note</a></li>
				<li class="divider"></li>
				<li><a href="#" onclick="delete_invoice('<?php echo $_POST['invoice_id'] ;?>')"><span class="fa fa-remove">&nbsp;&nbsp;</span>Delete Invoice</a></li>
				<li><a href="#" onclick="load_payment_form('<?php echo $_POST['invoice_id'] ;?>','2')"><span class="fa fa-remove">&nbsp;&nbsp;</span>Refund</a></li>
			</ul>
		</div>
	</div>
</div>
<ol class="breadcrumb page-breadcrumb">
  <li><a href="#">Invoices</a></li>
  <li class="active"><?php echo $invoiceObj->invoice_number; ?></li>
</ol>
<div id="saved_note"></div>
<div class="panel">
	<div class="panel-heading">
		<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-info-example" href="#collapseThree-info">
			<?php
			if(strlen(trim($invoiceObj->invoice_note))==0)
				echo "Add Invoice Notes";
			else
				echo substr(urldecode($invoiceObj->invoice_note),0,100)."...";
			?>
		</a>
	</div> <!-- / .panel-heading -->
	<div id="collapseThree-info" class="panel-collapse collapse">
		<div class="panel-body">
			<textarea class="form-control" style="width:100%" id="invoice_comment"><?php echo urldecode($invoiceObj->invoice_note); ?></textarea>
		</div> <!-- / .panel-body -->
		<div class="panel-footer" style="text-align:right">
			<input type="button" class="btn btn-primary" value="Save Note" onclick="submit_save_invoice_note('<?php echo $_POST['invoice_id']; ?>')">
		</div>
		<div id="save_note_div"></div>
	</div> <!-- / .collapse -->
</div>	
<div class="row">
	<div class="col-lg-12">
		<div class="input-group">
			<span class="input-group-addon no-background"><i class="fa fa-search"></i></span>
			<input name="s" class="form-control" placeholder="Type your search here and click on the add Icon to add a new service..." id="diagnosis_text" autocomplete="off" type="text">
			<input id="diagnosis_id" value="-1" type="hidden"> <!-- value -1 alwase!!! -->
			<span class="input-group-btn">
				<button id="button_diagnosis_add" onclick="add_new_service('<?php echo $_POST['invoice_id'] ?>','-1')" class="btn btn-danger"><i class="fa fa-plus"></i></button>
			</span>
		</div>	
	</div>	
</div>
<div class="row">
    <div class="col-lg-12"  id="invoice_operations"></div>
</div>
<div class="row">
    <div class="col-lg-12" id="invoice_items" id="invoice_items"></div>
</div>
<div class="row">
    <div class="col-lg-12"  id="list_invoice_payments"></div>
</div>
</div>
</div>
</div>






