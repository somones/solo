<?php
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/department.class.php");
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
$av_department			=$deparmtnetObj->get_active_departments();
$branchObj				=new branch();
$av_branches			=$branchObj->get_active_branches();
$policyObj				=new policy();
$av_policies			=$policyObj->list_av_policies();
//print_r($av_department);
?>
<div class="page-header">
    <div class="row">
        <div class="col-md-4 text-xs-center text-md-left text-nowrap">
			<h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
        </div>
    </div>
</div>


<div class="panel-body">
	<ul id="uidemo-tabs-default-demo" class="nav nav-tabs">
		<?php
		for($i=0;$i<count($av_department);$i++)
		{
			$av_dept_policies=$policyObj->list_per_department($av_department[$i]["department_id"]);
		?>
		<li class="<?php  if($i==0) echo "active"; else echo ""; ?>">
			<a href="#uidemo-tabs-<?php echo $av_department[$i]["department_id"]; ?>" data-toggle="tab">
				<?php echo $av_department[$i]["department_title"]; ?>
				<span class="label <?php if(count($av_dept_policies)==0) {  echo "label-danger"; } else { echo "label-success"; } ?>">
					<?php echo count($av_dept_policies); ?>
				</span>
			</a>
		</li>							 
		<?php
		}
		?>
	</ul>

	<div class="tab-content tab-content-bordered">
		<?php
	for($i=0;$i<count($av_department);$i++)
		{
			$av_dept_policies=$policyObj->list_per_department($av_department[$i]["department_id"]);
		?>
			<div class="tab-pane fade <?php  if($i==0) echo "active in"; else echo ""; ?>" id="uidemo-tabs-<?php echo $av_department[$i]["department_id"]; ?>">
				<div class="panel panel-success widget-support-tickets" id="dashboard-support-tickets">
					<div class="panel-heading">
						<span class="panel-title"><i class="panel-title-icon fa fa-bullhorn"></i>Published Policies</span>
						<div class="panel-heading-controls">
							<div class="panel-heading-text"><a href="#"><?php echo count($av_dept_policies)." Policies Found"; ?></a></div>
						</div>
					</div> <!-- / .panel-heading -->
					<div class="panel-body tab-content-padding">
						<!-- Panel padding, without vertical padding -->
							<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="panel-padding no-padding-vr" style="overflow: hidden; width: auto; height: 300px;">

								<?php
									for($j=0;$j<count($av_dept_policies);$j++)
									{
										
								?>
								<div class="ticket">
								<?php
								if($av_dept_policies[$j]["policy_control_type_id_FK"]==2)
								{
									?>
									<span class="ticket-info">
										Controlled Document<a href="#" title="" class="fa fa-lock"></a>
									</span>									
									<?php
								}
								?>		
								

									<a href="#"
									<?php
									if($av_dept_policies[$j]["policy_control_type_id_FK"]==1)
									{
									?>
									onclick="policy_reader('<?php echo $av_dept_policies[$j]['policy_id'];?>','1')" 
									<?php
									}
									else
									{
									?>
									onclick="authenticate_then_proceed('<?php echo $av_dept_policies[$j]['policy_id'];?>')" 
									<?php
									}
									?>
									title="" 
									class="ticket-title">
									<?php echo $av_dept_policies[$j]["policy_title"]; ?><span><?php echo $av_dept_policies[$j]["policy_ref_number"]; ?></span></a>
									<span class="ticket-info">
										Published by  <a href="#" title=""><?php echo $av_dept_policies[$j]["employee_full_name"]; ?></a>
									</span>
								</div> <!-- / .ticket -->
								<?php
									}
								?>

								</div>
								<div class="slimScrollBar" style="background: rgb(136, 136, 136) none repeat scroll 0% 0%; width: 7px; position: absolute; top: 38px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 94.8367px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;">
							</div>
						</div>
					</div> <!-- / .panel-body -->
				</div>
			</div>
		<?php
		}
		?>
	</div>
					
</div>