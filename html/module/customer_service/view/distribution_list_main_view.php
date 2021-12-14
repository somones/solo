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
require_once("../model/distribution_list.class.php");
require_once("../model/distribution_list_type.class.php");


$menu_itemObj								=new menu_item($_POST['menu_id']);
$distributionlistObj						=new distribution_list();
$distributionlist_Obj				    	=$distributionlistObj->list_of_distribution_list($_SESSION['employee_id']);

$branchObj				=new branch();
$listTypeObj			=new distribution_list_type();

?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_distribution_list_form('-1','<?php echo $_POST['menu_id'] ?>')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Distribution List</button>
        <?php //print_r($distributionlist_Obj); ?>
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
						<th style="width:10px">&nbsp;</th>
						<th>Distribution List Branch</th>
						<th>Distribution List Name</th>
						<th>Distribution List Description</th>
						<th>Distribution List Type</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($distributionlist_Obj);$i++) { 
							$ListBranch = $branchObj->get_customer_branch($distributionlist_Obj[$i]["branch_id_FK"]);
							$listType = $listTypeObj->type_per_list($distributionlist_Obj[$i]["list_type_id_FK"])

							?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_distribution_list_form('<?php echo $distributionlist_Obj[$i]['list_id']; ?>','<?php echo $_POST['menu_id'] ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_this_distribution_list('<?php echo $distributionlist_Obj[$i]["list_id"]; ?>')"></i></td>
								<td><i class="fa fa-users" style="cursor:pointer" title="Assign Users" onclick="assign_contact_to_list('<?php echo $distributionlist_Obj[$i]["list_id"]; ?>')"></i></td>
								<td><?php echo $ListBranch[0]["branch_name"]; ?></td>
								<td><?php echo $distributionlist_Obj[$i]["list_name"]; ?></td>
								<td><?php echo $distributionlist_Obj[$i]["list_description"]; ?></td>
								<td><?php echo $listType[0]["list_type_name"]; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>