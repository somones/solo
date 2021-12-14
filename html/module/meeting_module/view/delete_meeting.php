<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/employee.class.php");
require_once("../../../../html/lib/model/module.class.php");
require_once("../../../../html/lib/model/menu_item.class.php");
require_once("../../../../html/lib/model/department.class.php");
require_once("../model/room.class.php");
require_once("../model/meeting.class.php");
date_default_timezone_set("Asia/Dubai");
$meetingObj				=new meeting();
$meetins_obj		=$meetingObj->list_meetings($_SESSION['meeting_id']);
?>
<div class="row">
    <div class="col-lg-12">
	</div>
	<div class="col-lg-12">
		<div class="panel-body">
			
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th>Meeting Title</th>
						<th>Start Time	</th>
						<th>End Time</th>
						<th>Action</th>
					</thead>
					
					<tbody>
						<?php
						// strtotime to compare DATE and TIME
						$current_date_time=date("Y-m-d H:i:s");
						for($i=0;$i<count($meetins_obj);$i++){
							if ($meetins_obj[$i]["meeting_start_date_time"]>$current_date_time && $meetins_obj[$i]["meeting_active"] == 1) {?>
								<tr>
									<td><?php echo $meetins_obj[$i]["meeting_title"]; ?></td>
									<td><?php echo $meetins_obj[$i]["meeting_start_date_time"]; ?></td>
									<td><?php echo $meetins_obj[$i]["meeting_end_date_time"]; ?></td>
									<td>
										<?php if ($meetins_obj[$i]["meeting_active"] == 1) {?>
											<button type="button" class="btn btn-danger" onclick="submit_delete_meeting('<?php echo $meetins_obj[$i]["meeting_id"]; ?>')" style="width: 200px">Cancel The Meeting</button>
										<?php }else { ?>
											<button type="button" class="btn btn-warning">The Meeting is Cancelled</button>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div id="div_section_content">
</div>
