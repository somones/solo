<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");

require_once("../../../../html/lib/model/employee.class.php");
require_once("../../../../html/lib/model/module.class.php");
require_once("../../../../html/lib/model/menu_item.class.php");
require_once("../model/policy_chapter.class.php");
require_once("../model/policy.class.php");
require_once("../model/policy_section.class.php");
require_once("../model/policy_state.class.php");
require_once("../model/tracker.class.php");
require_once("../../../../html/lib/model/department.class.php");

$policyObj=new policy();
$section_details=$policyObj->get_policy_section_details($_POST['content_id']);
$policyObj=new policy($section_details[0]["policy_id_FK"]);

$tracker_id				=$policyObj->policy_state_id_FK;
$trackerObj				=new policy_tracker($tracker_id);
$tracker_state			=$trackerObj->get_tracker_state();
$pStateObj				=new policy_state($tracker_state[0]["state_id_FK"]);
$av_actions				=$pStateObj->get_state_actions();


$sectionObj				=new policy_section();
$av_sections			=$sectionObj->get_active_sections();
$policy_sections		=$policyObj->get_added_sections();
?>
<div class="page-header">
    <div class="row">
        <div class="col-md-4 text-xs-center text-md-left text-nowrap">
          <h1><i class="page-header-icon ion-ios-pulse-strong"></i>&nbsp;&nbsp;<?php echo $section_details[0]["section_title"]; ?></h1>
        </div>	
	<?php
	if($pStateObj->read_only==0)
	{
	?>
		<div class="pull-right col-xs-12 col-sm-auto" style="margin-right:50px">
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-primary" onclick="submit_save_content('<?php echo $_POST['content_id']; ?>','<?php echo $policyObj->policy_id; ?>')">Save Changes</button>
				<div class="btn-group">
					<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">Swap Order With&nbsp;<i class="fa fa-caret-down"></i></button>
					<ul class="dropdown-menu">

						<?php

						for($i=0;$i<count($policy_sections);$i++)
						{
							if($policy_sections[$i]["section_id"] <> $section_details[0]["section_id"])
							{
						?>
						<li><a href="#" onclick="swap_order('<?php echo $policy_sections[$i]["section_id"]; ?>','<?php echo $section_details[0]["section_id"]; ?>','<?php echo $policyObj->policy_id; ?>')"><?php echo $policy_sections[$i]["section_title"]; ?></a></li>

						<?php	
							}
						}
						?>						
					</ul>
				</div>
				<button type="button" class="btn btn-danger" onclick="remove_section_from_policy('<?php echo $_POST['content_id']; ?>','<?php echo $policyObj->policy_id; ?>')">Remove Section</button>
			</div> <!-- / .btn-group -->
		
		</div><!--<a href="#" class="btn btn-primary btn-labeled" style="width: 100%;"><span class="btn-label icon fa fa-plus"></span>Create project</a>-->		
	<?php
	}
?>	
    </div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
				<label class="label-control">Section Content</label>
				<div id="editor">
					<?php echo $section_details[0]["section_content"]; ?>
				</div>
				
		</div>
		

		
	</div>
	<div class="col-lg-12" id="div_section_content"></div>
</div>