<?php
session_start();
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");

require_once("../../../../html/lib/model/employee.class.php");
require_once("../../../../html/lib/model/module.class.php");
require_once("../../../../html/lib/model/menu_item.class.php");
require_once("../model/policy_chapter.class.php");
require_once("../model/policy.class.php");
require_once("../../../../html/lib/model/department.class.php");

$menu_itemObj			=new menu_item($_POST['menu_id']);
$policy_chapterObj		=new policy_chapter();
$av_chapters			=$policy_chapterObj->get_active_chapters();
$deparmtnetObj			=new department();
$av_department=$deparmtnetObj->get_active_departments();
$branchObj				=new branch();
$av_branches			=$branchObj->get_active_branches();
$policyObj				=new policy();
$av_policies			=$policyObj->list_av_policies($_SESSION['employee_id']);
?>
<div class="page-header">
    <div class="row">
        <div class="col-md-4 text-xs-center text-md-left text-nowrap">
			<h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-12">
		
				
		
	</div>
	<div class="col-lg-12">
		<div class="panel-body">
			
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th></th>
						<th>Policy Title</th>
						<th>Department	</th>
						<th>Chapter</th>
						<th>Created By</th>
						<th>Date Created</th>
						<th>Last Updated</th>
						<th>Policy Status</th>
						<th>Viewers</th>						
						<th>Views</th>						
					</thead>
					
					<tbody>
						<?php
						for($i=0;$i<count($av_policies);$i++)
						{
							$thispolicyObj=new policy($av_policies[$i]["policy_id"]);

						?>
							<tr>
								<th><input type="checkbox" id="<?php echo 'policy_index_'.$i; ?>" value="<?php echo $av_policies[$i]["policy_id"]; ?>" /></td>
								<td><a href="#"  onclick="load_content_editor('<?php echo  $av_policies[$i]["policy_id"]; ?>')"><?php echo $av_policies[$i]["policy_title"]; ?></a></td>
								<td><?php echo $av_policies[$i]["department_title"]; ?></td>
								<td><?php echo $av_policies[$i]["chapter_title"]; ?></td>
								<td><?php echo $av_policies[$i]["employee_full_name"]; ?></td>
								<td><?php echo $av_policies[$i]["policy_date_created"]; ?></td>
								<td><?php echo $av_policies[$i]["policy_date_updated"]; ?></td>
								<td><?php echo $av_policies[$i]["state_title"]." since ".$av_policies[$i]["date_time_inserted"]; ?></td>
								<td><?php echo $thispolicyObj->get_viewers();?></td>
								<td><?php echo $thispolicyObj->get_view_count();?></td>								
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>