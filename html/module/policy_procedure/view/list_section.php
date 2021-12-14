<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/employee.class.php");
require_once("../../../../html/lib/model/module.class.php");
require_once("../../../../html/lib/model/menu_item.class.php");
require_once("../../../../html/lib/model/department.class.php");
require_once("../model/policy_section.class.php");
$menu_itemObj				=new menu_item($_POST['menu_id']);
$sectionObj					=new policy_section();
$section_obj				=$sectionObj->get_sections($_SESSION['section_id']);
?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_section_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Section</button>
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
						<th>section_title Title</th>
						<th>section_help_tip</th>
						<th>section_date_created</th>
						<th>section_date_updated</th>
						<th>section_active_state</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($section_obj);$i++) { ?>
						<tr>
							<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_section_form('<?php echo $section_obj[$i]['section_id']; ?>')"></i></td>
							<!--<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_section('<?php echo $section_obj[$i]['section_id']; ?>')"></i></td>-->
							<td>
								<?php 
								$section_assigned = $sectionObj->has_section($section_obj[$i]["section_id"]);
								if (count($section_assigned) > 0) {?>
									<i class="fa fa-ban" aria-hidden="true"></i>
									<?php } else {?>
									<i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_chapter('<?php echo $chapterObj_obj[$i]['chapter_id']; ?>')"></i>
								<?php } ?>
							</td>							
							<td><?php echo $section_obj[$i]["section_title"]; ?></td>
							<td><?php echo $section_obj[$i]["section_help_tip"]; ?></td>
							<td><?php echo $section_obj[$i]["section_date_created"]; ?></td>
							<td><?php echo $section_obj[$i]["section_date_updated"]; ?></td>
							<td>
								<?php if ($section_obj[$i]["section_active_state"] == 1) {?>
									<span class="label label-success">Active</span>
								<?php }else { ?>
									<span class="label label-danger">inactive </span></a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>