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
//$menu_itemObj			=new menu_item($_POST['menu_id']);
$codeTypObj				=new code_type();
$codeTyp_obj			=$codeTypObj->list_of_code_type($_SESSION['employee_id']);
?>
<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php //echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_code_type_from('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Code Type</button>
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
						<th>Type Name</th>
						<th>Type Description</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($codeTyp_obj);$i++) { ?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_code_type_from('<?php echo $codeTyp_obj[$i]['code_type_id']; ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_code_type('<?php echo $codeTyp_obj[$i]["code_type_id"]; ?>')"></i></td>							
								<td><?php echo $codeTyp_obj[$i]["code_type_name"]; ?></td>
								<td><?php echo $codeTyp_obj[$i]["code_type_description"]; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>