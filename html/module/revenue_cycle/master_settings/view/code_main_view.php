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
require_once("../model/code.class.php");
require_once("../model/code_type.class.php");
$menu_itemObj			=new menu_item($_POST['menu_id']);
$codeObj				=new rc_code();
$code_obj				=$codeObj->list_of_code($_SESSION['employee_id']);

$codetypeObj				=new code_type();
?>
<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_code_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Code</button>
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
						<th>Code Value</th>
						<th>Code Description</th>
						<th>Code Type</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($code_obj);$i++) { 
$codeType = $codetypeObj->get_code_type($code_obj[$i]["code_type_id_FK"]);


							?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_code_form('<?php echo $code_obj[$i]['code_id']; ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_role('<?php echo $code_obj[$i]["code_id"]; ?>')"></i></td>							
								<td><?php echo $code_obj[$i]["code_value"]; ?></td>
								<td><?php echo $code_obj[$i]["code_short_description"]; ?></td>

								<td><?php if (isset($codeType[0]["code_type_name"])) {
								echo $codeType[0]["code_type_name"]; 
							} else { echo "--"; }?></td>
								<td><?php
									if ($code_obj[$i]["code_active"] == 1) {
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