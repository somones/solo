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
require_once("../model/messages_template_categorie.class.php");

$menu_itemObj						=new menu_item($_POST['menu_id']);

$categorieObj  						= new messages_template_categorie();
$categorie_Obj						= $categorieObj->list_of_messages_template_categorie();

$branchobj							=new branch();
?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_templates_category_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Message Template Categorie</button>
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
						<th>Template Category Name</th>
						<th>Template Category Description</th>
						<th>Template Category Branch</th>
						<th>Template Category Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($categorie_Obj);$i++) { 
							$branch_Obj= $branchobj->get_customer_branch($categorie_Obj[$i]["message_templates_categories_branch_id_FK"]);?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_templates_category_form('<?php echo $categorie_Obj[$i]["message_templates_categories_id"]; ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_this_templates_category('<?php echo $categorie_Obj[$i]["message_templates_categories_id"]; ?>')"></i></td>
								<td><?php echo $categorie_Obj[$i]["message_templates_categories_name"]; ?></td>
								<td><?php echo $categorie_Obj[$i]["message_templates_categories_description"]; ?></td>
								<td><?php echo $branch_Obj[0]["branch_name"]; ?></td>
								<td><?php
									if ($categorie_Obj[$i]["message_templates_categories_active"] == 1) {
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