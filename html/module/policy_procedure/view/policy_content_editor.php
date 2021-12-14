<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
require_once("../model/policy_section.class.php");
require_once("../model/policy_state.class.php");
require_once("../model/tracker.class.php");
require_once("../../../../html/lib/model/department.class.php");
//$menu_itemObj			=new menu_item($_POST['menu_id']);
$employeeObj			=new employee($_SESSION["employee_id"]);

$policy_chapterObj		=new policy_chapter();
$av_chapters			=$policy_chapterObj->get_active_chapters();
$deparmtnetObj			=new department();
$av_department			=$deparmtnetObj->get_active_departments();
$branchObj				=new branch();
$av_branches			=$branchObj->get_active_branches();
$policyObj				=new policy($_POST['policy_id']);
$sectionObj				=new policy_section();
$av_sections			=$sectionObj->get_active_sections();
$policy_sections		=$policyObj->get_added_sections();
$unaddded_sections		=$sectionObj->get_non_added_sections($_POST['policy_id']);

$tracker_id				=$policyObj->policy_state_id_FK;
$trackerObj				=new policy_tracker($tracker_id);
$tracker_state			=$trackerObj->get_tracker_state();
$pStateObj				=new policy_state($tracker_state[0]["state_id_FK"]);
$av_actions				=$pStateObj->get_state_actions();
$pending_details		=$trackerObj->get_pending_details();
?>
<div class="page-header">
    <div class="row">
	
	<?php
	if($pStateObj->read_only==1)
	{
		?>
		<div class="col-lg-12 alert alert-info">
			Kindly note that this policy is in READ ONLY mode thus you can only View it in this state.
		</div>		
		<?php
	}

	?>	
        <div class="col-md-10 text-xs-center text-md-left text-nowrap">
          <h1><i class="page-header-icon ion-ios-pulse-strong"></i>&nbsp;&nbsp;Policy Content Editor [ Current State: "<?php
			if($trackerObj->state_id==3)
				echo "<a href='' Title='View revision notes'>".$trackerObj->state_title."</a>";
			else
				echo $trackerObj->state_title; 
		  
		  ?>" ] " </b> since <b><a href="#" onclick="get_policy_operations_history('<?php echo $_POST['policy_id']; ?>')" title="View History"><?php echo $trackerObj->date_time_inserted; ?></a></b></h1>
        </div>

		<div class="pull-right col-xs-12 col-sm-auto" style="margin-right:50px">
			<div class="btn-group pull-right">
				<button type="button" class="btn" onclick="load_content_editor('<?php echo $_POST['policy_id']; ?>')">Refresh</button>
					<?php
					for($i=0;$i<count($av_actions);$i++)
					{
						if($av_actions[$i]["action_id"]==3) // For the Revision Done Function
						{
							if($employeeObj->employee_has_menu_item(10) && $policyObj->get_pending_record()==$_SESSION['employee_id'] )// if the user has access to review policy and the user exist in pending actions
							{
							?>
							<button type="button" class="btn" onclick="apply_action('<?php echo $_POST['policy_id'] ?>','<?php echo $_SESSION['employee_id']; ?>','<?php echo $av_actions[$i]['action_id']; ?>')"><?php echo $av_actions[$i]["action_title"]; ?></button>
							
							<?php
							}
							
						}
						
						else if($av_actions[$i]["action_id"]==4 || $av_actions[$i]["action_id"]==7) // For the Revision Done Function
						{
							if($employeeObj->employee_has_menu_item(11) && $policyObj->get_pending_record()==$_SESSION['employee_id'])
							{
							?>
							<button type="button" class="btn" onclick="apply_action('<?php echo $_POST['policy_id'] ?>','<?php echo $_SESSION['employee_id']; ?>','<?php echo $av_actions[$i]['action_id']; ?>')"><?php echo $av_actions[$i]["action_title"]; ?></button>
							
							<?php
							}
							
						}
						else
						{
?>
							<button  type="button" class="btn" onclick="apply_action('<?php echo $_POST['policy_id'] ?>','<?php echo $_SESSION['employee_id']; ?>','<?php echo $av_actions[$i]['action_id']; ?>')"><?php echo $av_actions[$i]["action_title"]; ?></button>
<?php							
						}
					}
?>
					<!--Make sure to do it with permission 1- User should have permission to download , 2-Policy is in state published Revised or approved -->
					<button type="button" class="btn" onclick="window.open('../../../lib/TCPDF/source/download_policy.php?pp=<?php echo $_POST['policy_id']; ?>')">PDF</button>

<?php	
				if($pStateObj->read_only==0)
				{
				?>				
				<div class="btn-group">
					<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">Insert New Section&nbsp;<i class="fa fa-caret-down"></i></button>
					<ul class="dropdown-menu">

						<?php
						for($i=0;$i<count($unaddded_sections);$i++)
						{
						?>
						<li><a href="#" onclick="add_section_policy('<?php echo $_POST['policy_id']; ?>','<?php echo $unaddded_sections[$i]["section_id"]; ?>')"><?php echo $unaddded_sections[$i]["section_title"]; ?></a></li>

						<?php						
						}
						?>						
					</ul>
				</div>	
				<?php
				}
				?>
				
			</div> <!-- / .btn-group -->
		
		</div><!--<a href="#" class="btn btn-primary btn-labeled" style="width: 100%;"><span class="btn-label icon fa fa-plus"></span>Create project</a>-->		
		
    </div>
</div>

<div class="row">
	<div class="col-lg-12" id="content_editor_op">
	</div>
</div>

<?php 
if($employeeObj->employee_has_menu_item(10) && $policyObj->get_pending_record()==$_SESSION['employee_id'] && ($tracker_state[0]["state_id_FK"]==2  || $tracker_state[0]["state_id_FK"]==4 ) )// if the user has access to review policy and the user exist in pending actions && state = require revision
{
	if($tracker_state[0]["state_id_FK"]==2)
		$title="Revision Notes";
	else
		$title="Approval / Rejection Notes:"
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel colourable panel-info">
			<div class="panel-heading">
				<span class="panel-title"><?php echo $title; ?></span>
			</div>
			<div class="panel-body" id="editor_notes">
				<textarea id="ëditor_notes_text" class="form-control" rows="10"><?php echo $pending_details[0]["record_notes"]; ?></textarea>
			</div>
			<div class="form-group" style="text-align:center">
				<button class="btn btn-info" onclick="submit_save_revision_notes('<?php echo $_POST['policy_id']; ?>')">Save</button>
			</div>
		</div>
	</div>
</div>
<?php	
}
?>
<div class="row">
</div>
<div class="row">

	<div class="col-lg-12" style="">
		<div class="panel-body" style="border:"0px">
		
				<table width="100%" cellspacing='0' cellspacing='0' border="0" style="border-collapse:collapse;border-color:#f1f2f3">
					<tr>
						<td width="100%">
								<table width="100%"  border="0" style="border-bottom:1px solid #e1e1e1;background-color:#10678c;color:white" cellspacing="5" cellspacing="0">
									<tr>
										<td colspan="4">
											<img src="../../../../html/assets/images/logo-full.png" style="width:180px" />
										</td>
									</tr>
									<tr>
										<td colspan="4" style="text-align:center;border-bottom:1px solid #e1e1e1;background-color:white;color:#10678c">
											<h2><?php echo $policyObj->policy_title; ?></h2>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;font-weight:bold">Department:</td>
										<td>&nbsp;&nbsp;<?php echo $policyObj->department_title; ?></td>
										<td style="text-align:right;font-weight:bold">Ref No.</td>
										<td>&nbsp;&nbsp;<?php echo $policyObj->policy_ref_number; ?></td>
									</tr>
									<tr>
										<td style="text-align:right;font-weight:bold">Approval Date:</td>
										<td></td>
										<td style="text-align:right;font-weight:bold">Effective Date:</td>
										<td>&nbsp;&nbsp;<?php echo $policyObj->policy_effective_date; ?></td>
									</tr>			
									<tr >
										<td style="text-align:right;font-weight:bold">Revision Date:</td>
										<td>&nbsp;&nbsp;<?php echo $policyObj->policy_revision_date; ?></td>
										<td style="text-align:right;font-weight:bold">Current State:</td>
										<td>&nbsp;&nbsp;<?php echo $pStateObj->state_title; ?></td>
									</tr>						
									
								</table>				
						</td>
					</tr>
						
					<tr>
						<td>
							<br/>
						</td>
					</tr>
					
					<tr>
						<td>
							<ul id="uidemo-tabs-default-demo" class="nav nav-tabs">
								<li class="" onclick="server_loader_PP('../view/policy_form.php','content_editor_tab_content','policy_id=<?php echo $_POST['policy_id']; ?>','Loading Policy Properties.')">
									<a href="#uidemo-tabs-default-demo-home" data-toggle="tab"><span class="label label-success">&nbsp;</span>&nbsp;&nbsp;Properties </a>
								</li>
								
								<?php
								
								for($i=0;$i<count($policy_sections);$i++)
								{
									?>
								<li class="" onclick="load_section_content('<?php echo $policy_sections[$i]["content_id"]; ?>')">
									<a href="#uidemo-tabs-default-demo-home" data-toggle="tab"><span class="fa fa-file">&nbsp;</span>&nbsp;<?php echo $policy_sections[$i]["section_title"]; ?> </a>
								</li>	
									<?php
								}
								?>
								
								<li class="">
									<a onclick="get_file_uploader('<?php echo $_POST['policy_id']; ?>')" href="#uidemo-tabs-default-demo-home" data-toggle="tab"><span class="fa fa-file">&nbsp;</span>&nbsp;Attachments </a>
								</li>
								<li class="">
									<a href="#uidemo-tabs-default-demo-home" onclick="preview_policy('<?php echo $_POST['policy_id']; ?>')" data-toggle="tab"><span class="fa fa-file">&nbsp;</span>&nbsp;Preview Layout </a>
								</li								
							</ul>
							<div class="tab-content tab-content-bordered" id="content_editor_tab_content">
							</div>
						</td>
					</tr>
				</table>
		
		
		
		
		</div>
	</div>
	
</div>
