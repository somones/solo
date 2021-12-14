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
require_once("../model/billing_items.class.php");
require_once("../model/billing_item_categories.class.php");
require_once("../model/tax_profile.class.php");

//require_once("../model/code_type.class.php");
$menu_itemObj						=new menu_item($_POST['menu_id']);
$billingItemObj						=new billing_item();
$billingItem_Obj				    =$billingItemObj->list_of_billing_item($_SESSION['employee_id']);
//print_r($billingItem_Obj);

$categorieObj 	= new billing_item_category();
$profileObj 	= new tax_profile();

//$codetypeObj				=new code_type();
?>
<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php //echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_biiling_item_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Billing Item</button>
        <?php //print_r($billingItem_Obj); ?>
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
						<th>Code Description</th>
						<th>Code Category</th>
						<th>Tax Profile</th>
						<th>Tax value</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($billingItem_Obj);$i++) { 
							//$codeType = $codetypeObj->get_code_type($code_obj[$i]["code_type_id_FK"]);
							$categorie_Obj 	= $categorieObj->billing_item_category($billingItem_Obj[$i]["item_category_id_FK"]);

							$profile_Obj 	= $profileObj->billing_item_profile($billingItem_Obj[$i]["tax_profile_id_FK"]);
							?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_biiling_item_form('<?php echo $billingItem_Obj[$i]['item_id']; ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_billing_item('<?php echo $billingItem_Obj[$i]["item_id"]; ?>')"></i></td>							
								<td><?php echo $billingItem_Obj[$i]["item_description"]; ?></td>
								<td><?php echo $categorie_Obj[0]["category_description"]; ?></td>
								<td><?php echo $profile_Obj[0]["profile_name"]; ?></td>
								<td><?php echo $billingItem_Obj[$i]["tax_value"]; ?></td>
								<!--<td><?php //if (isset($codeType[0]["code_type_name"])) {
								//echo $codeType[0]["code_type_name"]; 
							//} else { echo "--"; }?></td>-->
								<td><?php
									if ($billingItem_Obj[$i]["item_active"] == 1) {
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