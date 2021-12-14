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
require_once("../../meeting_module/model/meeting.class.php");


$meeting = new meeting();
$current_date_time= date("Y-m-d H:i:s");
$current_meeting = $meeting->get_atendees_info($_POST['checkin_code']);
$code = $_POST['checkin_code'];
	
?>

<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" style="color: red">Please Check Your Informations Blow</h4>
				
			</div>
			<div id="check_in_div"></div>
			<?php if ($code == NULL) { ?>
				<div class="modal-body">
					<div class="panel-body p-a-4 b-b-1">
				      <div class="box m-a-0">
				        <div class="box-row valign-middle">
				          <div class="box-cell col-xs-6 font-size-14">
				            <h1 style="text-align: center;">Please enter a valide Code</h1>
				          </div>
				          </div>
				        </div>
					</div>
				</div>

				<?php } else if($current_meeting == NULL) { ?>
				<div class="modal-body">
					<div class="panel-body p-a-4 b-b-1">
				      <div class="box m-a-0">
				        <div class="box-row valign-middle">
				          <div class="box-cell col-xs-6 font-size-14">
				            <h1 style="text-align: center;">Your Code is Not Valide</h1>
				          </div>
				          </div>
				        </div>
					</div>
				</div>
				<?php } else { ?>
				<div class="modal-body">
					<div style="min-width: 768px;">
					    <div class="panel-body p-a-4 b-b-1">
					      <div class="box m-a-0">
					        <div class="box-row valign-middle">
					          <div class="box-cell col-xs-8">
					            <div class="display-inline-block p-l-1 b-l-1 valign-middle font-size-12">
					              <div><strong>TITLE:</strong> <?php  echo $current_meeting['meeting_title'];?></div>
					              <div><strong>START AT:</strong> <?php  echo $current_meeting['meeting_start_date_time'];?></div>
					            </div>
					          </div>
					          <div class="box-cell col-xs-4">
					            <div class="pull-xs-right font-size-15">
					              <div class="font-size-13 line-height-1">UNTIL</div>
					              <strong><?php  echo $current_meeting['meeting_end_date_time'];?></strong>
					            </div>
					          </div>
					        </div>
					      </div>
					    </div>
					    <div class="panel-body p-a-4 b-b-1">
					      <div class="box m-a-0">
					        <div class="box-row valign-middle">
					          <div class="box-cell col-xs-6 font-size-14">
					            <div><strong><?php  echo $current_meeting['employee_full_name'];?></strong></div>
					            <div><strong>EMAIL: </strong><?php  echo $current_meeting['employee_email'];?></div>
					            <div><strong>POSITION: </strong><?php  echo $current_meeting['employee_job_title'];?></div>
					            <div><strong>NUMBER: </strong><?php  echo $current_meeting['employee_number'];?></div>
					          </div>
					          <div class="box-cell col-xs-6 p-y-2">
					            <div class="pull-xs-right font-size-24"><strong><?php  echo $current_meeting['checkin_code'];?></strong></div>
					            <div class="pull-xs-right m-y-1 p-r-2 font-size-12"><strong>PIN:</strong></div>
					          </div>
					        </div>
					      </div>
					    </div>
					    <button type="button" name="submit" value="Submit" class="btn btn-lg btn-danger btn-block" onclick="update_atendee(<?php  echo $current_meeting['employee_id'] ; ?>)"><strong>CONFERM !!</strong></button>
					  </div>
				</div>
			<?php } ?> 
		</div>
	</div>
</div>