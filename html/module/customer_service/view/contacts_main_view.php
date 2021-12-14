<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/employee.class.php");
require_once("../../../../html/lib/model/module.class.php");
require_once("../../../../html/lib/model/menu_item.class.php");
require_once("../../../../html/lib/model/department.class.php");
require_once("../model/contact.class.php");

$menu_itemObj						=new menu_item($_POST['menu_id']);
$contactObj							=new contact();
$contact_Obj				    	=$contactObj->list_of_contacts($_SESSION['employee_id']);
?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_contact_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Contact</button>
        <?php //print_r($contact_Obj); ?>
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
						<th style="width:10px">&nbsp;</th>
						<th>Contact Name</th>
						<th>Contact Email</th>
						<th>Contact Mobile Number</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($contact_Obj);$i++) { ?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_contact_form('<?php echo $contact_Obj[$i]['contact_id']; ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_this_contact('<?php echo $contact_Obj[$i]["contact_id"]; ?>')"></i></td>
								<td><?php echo $contact_Obj[$i]["contact_name"]; ?></td>
								<td><?php echo $contact_Obj[$i]["contact_email"]; ?></td>
								<td><?php echo $contact_Obj[$i]["contact_mobile_number"]; ?></td>
								<td><?php
									if ($contact_Obj[$i]["contact_active"] == 1) {
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