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
require_once("../model/consent_category.class.php");

$menu_itemObj									=new menu_item($_POST['menu_id']);
$consent_categoryObj							=new consent_category();
$consent_category_Obj				    		=$consent_categoryObj->list_of_consent_category($_SESSION['employee_id']);
?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_consent_category_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Consent Category</button>
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
						<th>Consent Name</th>
						<th>Consent Description</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($consent_category_Obj);$i++) { ?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_consent_category_form('<?php echo $consent_category_Obj[$i]['consent_category_id']; ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_this_consent_category('<?php echo $consent_category_Obj[$i]["consent_category_id"]; ?>')"></i></td>
								<td><?php echo $consent_category_Obj[$i]["consent_category_name"]; ?></td>
								<td><?php echo $consent_category_Obj[$i]["consent_category_description"]; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>