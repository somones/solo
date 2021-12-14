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
require_once("../model/code_type.class.php");
$menu_itemObj			=new menu_item($_POST['menu_id']);
$codeTypObj				=new code_type();
$codeTyp_obj			=$codeTypObj->list_of_code_type($_SESSION['employee_id']);
?>
<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
</div>
<div class="row">
    <div class="col-lg-12"></div>
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th>Type Name</th>
						<th>Type Description</th>
						<th>Category</th>
						<th>Insurance</th>
						
					</thead>
					<tbody>
						<?php for($i=0;$i<count($codeTyp_obj);$i++) { 
							$category = $codeTypObj->get_category_of_code_type($codeTyp_obj[$i]["code_type_category_id_FK"]);
							?>
							<tr>							
								<td><?php echo $codeTyp_obj[$i]["code_type_name"]; ?></td>
								<td><?php echo $codeTyp_obj[$i]["code_type_description"]; ?></td>
								<td><?php if (isset($category[0]["category_description"])) {
								echo $category[0]["category_description"]; 
							} else { echo "--"; }?></td>
								<td><?php echo $codeTyp_obj[$i]["code_type_insurance_id_FK"]; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>