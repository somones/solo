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
require_once("../model/policy_section.class.php");
require_once("../model/policy_state.class.php");
require_once("../model/tracker.class.php");
require_once("../../../../html/lib/model/department.class.php");
$policyObj				=new policy($_POST['policy_id']);
$pStateObj				=new policy_state($policyObj->policy_state_id_FK);
$av_actions				=$pStateObj->get_action_attributes($_POST['action_id']);
?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"><?php echo $av_actions[0]["action_title"]; ?></h4>
			</div>
			<div class="modal-body">
			<?php
			//print_r($_POST);
			if($_POST['action_id']==1) // Send for revision
			{
				$employeeObj	=new employee();
				$av_list		=$employeeObj->get_reviewers_list();
			?>
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label class="label-control">Select Reviewer</label>
							<select type="text" class="form-control" id="action_form_employee_id">
								<option value=""></option>
								<?php
								for($i=0;$i<count($av_list);$i++)
								{
									$thisEmployee=new employee($av_list[$i]["employee_id_FK"]);
									?>
									<option value="<?php echo $thisEmployee->employee_id ?>"><?php echo $thisEmployee->employee_full_name; ?></option>
									<?php
								}
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label class="label-control">Enter Notification Text:</label>
							<textarea class="form-control" id="action_form_text_notification"></textarea>
						</div>
						
						<div class="form-group">
							<button onclick="submit_save_policy_flow_action('<?php echo $av_actions[0]["action_id"]; ?>','<?php echo $_POST['policy_id']; ?>')" class="btn btn-primary"><?php echo $av_actions[0]["action_title"]; ?></button>
						</div>
					</div>
				</div>
				<?php
				
					
			}	
			else if($_POST['action_id']==3)
			{
				?>
				<div class="row">
					<div class="col-lg-12">
						<?php
							$policyObj							=new policy($_POST['policy_id']);
							$tracker_id							=$policyObj->policy_state_id_FK;
							$trackerObj							=new policy_tracker($tracker_id);
							$pending_details					=$trackerObj->get_pending_details();
							$tracker_array						=array();
							$tracker_array["policy_id"]			=$_POST['policy_id'];
							$tracker_array["action_id"]			=$_POST['action_id'];
							$tracker_array["text_notification"]	=$pending_details[0]["record_notes"];
							$tracker_id							=$policyObj->insert_tracker($tracker_array,$_SESSION['employee_id']);
							$policyObj->update_policy_state($tracker_id);	
							$pending_id							=$policyObj->process_pending_record($pending_details[0]["pending_id"]);
							echo "<div class='alert alert-success'>Action Successfully Done</div>";						
						?>
					</div>
				</div>
				<?php
			}
			
			else if($_POST['action_id']==2)
			{
				$employeeObj	=new employee();
				$av_list		=$employeeObj->get_approvers_list();
			?>
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label class="label-control">Select Who needs to approve</label>
							<select type="text" class="form-control" id="action_form_employee_id">
								<option value=""></option>
								<?php
								for($i=0;$i<count($av_list);$i++)
								{
									$thisEmployee=new employee($av_list[$i]["employee_id_FK"]);
									?>
									<option value="<?php echo $thisEmployee->employee_id ?>"><?php echo $thisEmployee->employee_full_name; ?></option>
									<?php
								}
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label class="label-control">Enter Notification Text:</label>
							<textarea class="form-control" id="action_form_text_notification"></textarea>
						</div>
						
						<div class="form-group">
							<button onclick="submit_save_policy_flow_action('<?php echo $av_actions[0]["action_id"]; ?>','<?php echo $_POST['policy_id']; ?>')" class="btn btn-primary"><?php echo $av_actions[0]["action_title"]; ?></button>
						</div>
					</div>
				</div>				
			<?php	
			}
			
			else if($_POST['action_id']==4)
			{
				?>
				<div class="row">
					<div class="col-lg-12">
						<?php
							$policyObj							=new policy($_POST['policy_id']);
							$tracker_id							=$policyObj->policy_state_id_FK;
							$trackerObj							=new policy_tracker($tracker_id);
							$pending_details					=$trackerObj->get_pending_details();
							$tracker_array						=array();
							$tracker_array["policy_id"]			=$_POST['policy_id'];
							$tracker_array["action_id"]			=$_POST['action_id'];
							$tracker_array["text_notification"]	=$pending_details[0]["record_notes"];
							$tracker_id							=$policyObj->insert_tracker($tracker_array,$_SESSION['employee_id']);
							$policyObj->update_policy_state($tracker_id);	
							$pending_id							=$policyObj->process_pending_record($pending_details[0]["pending_id"]);
							echo "<div class='alert alert-success'>Action Successfully Done</div>";						
						?>
					</div>
				</div>	
			<?php				
			}
			else if($_POST['action_id']==7)
			{
				?>
				<div class="row">
					<div class="col-lg-12">
						<?php
							$policyObj							=new policy($_POST['policy_id']);
							$tracker_id							=$policyObj->policy_state_id_FK;
							$trackerObj							=new policy_tracker($tracker_id);
							$pending_details					=$trackerObj->get_pending_details();
							$tracker_array						=array();
							$tracker_array["policy_id"]			=$_POST['policy_id'];
							$tracker_array["action_id"]			=$_POST['action_id'];
							$tracker_array["text_notification"]	=$trackerObj->record_notes;
							$tracker_id							=$policyObj->insert_tracker($tracker_array,$_SESSION['employee_id']);
							$policyObj->update_policy_state($tracker_id);	
							$pending_id							=$policyObj->process_pending_record($pending_details[0]["pending_id"]);
							echo "<div class='alert alert-success'>Action Successfully Done</div>";						
						?>
					</div>
				</div>	
			<?php				
			}	
			else if($_POST['action_id']==8)
			{
				$policyObj							=new policy($_POST['policy_id']);
				$tracker_id							=$policyObj->policy_state_id_FK;
				$trackerObj							=new policy_tracker($tracker_id);
				//$pending_details					=$trackerObj->get_pending_details();
				$tracker_array						=array();
				$tracker_array["policy_id"]			=$_POST['policy_id'];
				$tracker_array["action_id"]			=$_POST['action_id'];
				$tracker_array["text_notification"]	="";
				$tracker_id							=$policyObj->insert_tracker($tracker_array,$_SESSION['employee_id']);
				$policyObj->update_policy_state($tracker_id);	
				echo "<div class='alert alert-success'>Action Successfully Done</div>";						
				
			}
			else if($_POST['action_id']==5)
			{
				?>
				<div class="row">
					<div class="col-lg-12">
							<div class="checkbox">
							<div class="checkbox">
								<label>
									<input type="checkbox" id="notify_checkbox" class="px"> <span class="lbl">Send Email Notification.</span>
								</label>
							</div>						
						
							<div class="form-group">
								<label class="form-group">Notification Template:</label>
								<select class="form-control">
									<option value="">Custom Text</option>
									<option value="1">New Policy Created</option>
									<option value="2">Policy Updated</option>
								</select>
							</diV>
						<div class="form-group">
							<label class="label-control">Enter Notification Text:</label>
							<textarea class="form-control" id="action_form_text_notification"></textarea>
						</div>
						
						<div class="form-group">
							<button onclick="submit_publish_action('<?php echo $av_actions[0]["action_id"]; ?>','<?php echo $_POST['policy_id']; ?>')" class="btn btn-primary"><?php echo $av_actions[0]["action_title"]; ?></button>
						</div>
					</div>
				</div>					
				<?php
			}

			
				?>
			<div class="row">
				<div class="col-lg-12"	id="div_submit_action">
				</div>
			</div>
			</div>
		</div> <!-- / .modal-content -->
	</div> <!-- / .modal-dialog -->
</div>