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
require_once("../model/messages_template.class.php");
require_once("../model/messages_template_categorie.class.php");

$menu_itemObj								=new menu_item($_POST['menu_id']);

$msgtemplateObj								=new messages_template();
$msgtemplate_Obj				    		=$msgtemplateObj->list_of_messages_template($_SESSION['employee_id']);

$categoryObj								=new messages_template_categorie();
?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_message_templates_form('-1','<?php echo $_POST['menu_id'] ?>')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Template</button>
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
						<th>Message Template Message Name</th>
						<th>Message Template Description</th>
						<th>Message Template Category</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($msgtemplate_Obj);$i++) { 
							$category = $categoryObj->get_messages_template_categorie($msgtemplate_Obj[$i]["message_template_categorie_id_FK"]);
							?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_message_templates_form('<?php echo $msgtemplate_Obj[$i]['message_template_id']; ?>','<?php echo $_POST['menu_id'] ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_this_templates('<?php echo $msgtemplate_Obj[$i]["message_template_id"]; ?>')"></i></td>
								<td><?php echo $msgtemplate_Obj[$i]["message_template_name"]; ?></td>
								<td><?php echo $msgtemplate_Obj[$i]["message_template_description"]; ?></td>
								<td><?php echo $category['message_templates_categories_name']; ?></td>
								<td><?php if ($msgtemplate_Obj[$i]["message_template_active"] ==1) {
									echo "active";
								} else {
									echo "inactive";
								}?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>