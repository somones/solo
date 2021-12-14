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

$menu_itemObj			=new menu_item($_POST['menu_id']);
$meetingObj				=new meeting();
$meetins_obj		=$meetingObj->list_meetings($_SESSION['meeting_id']);
?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
    </div>
    <?php $meetingObj->if_exist(2,'2019-01-29 13:00:00');?>
</div>


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
						$current_date_time= date("Y-m-d H:i:s");
						for($i=0;$i<count($meetins_obj);$i++) { 
							$current_date_time= date("Y-m-d H:i:s");

							?>
							<tr>
								<td><?php echo $meetins_obj[$i]["meeting_title"]; ?></td>
								<td><?php echo $meetins_obj[$i]["meeting_start_date_time"]; ?></td>
								<td><?php echo $meetins_obj[$i]["meeting_end_date_time"]; ?></td>
								<td>
								<?php if ($current_date_time > $meetins_obj[$i]["meeting_end_date_time"]) { ?>
									<a href="#"><span class="label label-success" style="width: 200px" onclick="meeting_info('<?php echo $meetins_obj[$i]["meeting_id"]; ?>')">Completed <small>( Check Info )</small></span></a>
								<?php } else if ($current_date_time > $meetins_obj[$i]["meeting_start_date_time"] && $current_date_time < $meetins_obj[$i]["meeting_end_date_time"]){?>
									<span class="label label-warning" style="width: 200px">Runing</span>
								<?php } else if ($meetins_obj[$i]["meeting_active"] == 1){?>
									<span class="label label-info" style="width: 200px">Pending</span>
								<?php } else if ($meetins_obj[$i]["meeting_active"] == 2) {?>
									<span class="label label-danger" style="width: 200px">Canceled</span>
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