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
require_once("../model/consent.class.php");

$menu_itemObj						=new menu_item($_POST['menu_id']);
$consentObj							=new consent();
$consent_Obj				    	=$consentObj->list_of_consent($_SESSION['employee_id']);

$branchObj 	= new branch();
?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_consent_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Consent</button>
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
						<th>Consent Title</th>
						<th>Consent Description</th>
						<th>Consent category</th>
						<th>Consent Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($consent_Obj);$i++) { 
								$consent_categoryObj = $consentObj->get_consent_category($consent_Obj[$i]['category_id_FK']); ?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_consent_form('<?php echo $consent_Obj[$i]['consent_id']; ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_this_consent('<?php echo $consent_Obj[$i]["consent_id"]; ?>')"></i></td>
								<td><?php echo $consent_Obj[$i]["consent_title"]; ?></td>
								<td><?php echo $consent_Obj[$i]["consent_description"]; ?></td>
								<td><?php echo $consent_categoryObj["consent_category_name"]; ?></td>
								
								<td><?php if ($consent_Obj[$i]["consent_active"]==1) {
									echo "Active";
								} else{
									echo "inactive";
								} ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>