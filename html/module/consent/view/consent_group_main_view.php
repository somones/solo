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
require_once("../model/consent_user_group.class.php");

$menu_itemObj								=new menu_item($_POST['menu_id']);
$consent_user_groupObj						=new consent_user_group();
$consent_user_group_Obj				    	=$consent_user_groupObj->list_of_consent_user_group($_SESSION['employee_id']);


?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_consent_group_form_modal('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Group</button>
        
    </div>
    <?php //print_r($group['rows_nb']); ?>
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
						<th style="width:10px">&nbsp;</th>
						<th>Group Name</th>
						<th>Group Description</th>
						<th>Group Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($consent_user_group_Obj);$i++) { ?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_consent_group_form_modal('<?php echo $consent_user_group_Obj[$i]['consent_group_id']; ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_this_consent_group('<?php echo $consent_user_group_Obj[$i]["consent_group_id"]; ?>')"></i></td>
								<td><i class="fa fa-users" style="cursor:pointer" title="Assign Users" onclick="assign_user_to_group('<?php echo $consent_user_group_Obj[$i]['consent_group_id']; ?>')"></i></td>
								<td><?php echo $consent_user_group_Obj[$i]["consent_group_title"]; ?></td>
								<td><?php echo $consent_user_group_Obj[$i]["consent_group_description"]; ?></td>
								<td>
									<?php if ($consent_user_group_Obj[$i]["consent_group_active"] == 1) {
										echo "Active";
									} else {
										echo "Inactive";
									} ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>