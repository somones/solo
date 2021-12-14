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

$menu_itemObj				=new menu_item($_POST['menu_id']);
$customerObj				=new customer();
$customer_obj				=$customerObj->list_of_deleted_customer($_SESSION['employee_id']);

$branchObj				=new branch();
?>
<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_customer_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Customer</button>
    </div>
</div>

<div class="row">
    <div class="col-lg-12"></div>
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th style="width:10px">&nbsp;</th>
						<th>Customer Name</th>
						<th>Customer Email</th>
						<th>Customer Number</th>
						<th>Customer Branch</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($customer_obj);$i++) { 
							$customerBranch = $branchObj->get_customer_branch($customer_obj[$i]["branch_id_FK"]);
							?>
							<tr>
								<td><i class="fa fa-plus" style="cursor:pointer" title="Edit Security Group" onclick="reactive_customer('<?php echo $customer_obj[$i]["customer_id"]; ?>')"></i></td>							
								<td><?php echo $customer_obj[$i]["customer_display_name"]; ?></td>
								<td><?php echo $customer_obj[$i]["customer_email"]; ?></td>
								<td><?php echo $customer_obj[$i]["customer_mobile_number"]; ?></td>
								<td><?php echo $customerBranch[0]["branch_name"]; ?></td>
								<td><?php
									if ($customer_obj[$i]["customer_active"] == 1) {
										echo "Active";
									} else {
										echo "inactive";
									}
								?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>