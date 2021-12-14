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
require_once("../model/room.class.php");
$menu_itemObj			=new menu_item($_POST['menu_id']);
$roomObj				=new meeting_room();
$room_obj				=$roomObj->get_active_rooms($_SESSION['employee_id']);

$branchObj				=new branch();
?>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_meeting_room_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Meeting Room</button>
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
						<th>Room Name</th>
						<th>Room Description</th>
						<th>Room Branch</th>
						<th>Room Capacity</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($room_obj);$i++) { 
						$branch_Obj = $branchObj->get_customer_branch($room_obj[$i]["branch_id_FK"]);
							?>
							<tr>
								<td><i class="fa fa-edit" style="cursor:pointer" title="Edit Security Group" onclick="get_meeting_room_form('<?php echo $room_obj[$i]['room_id']; ?>')"></i></td>
								<td><i class="fa fa-times" style="cursor:pointer" title="Edit Security Group" onclick="delete_meeting_room('<?php echo $room_obj[$i]["room_id"]; ?>')"></i></td>							
								<td><?php echo $room_obj[$i]["room_title"]; ?></td>
								<td><?php echo $room_obj[$i]["room_description"]; ?></td>
								<td><?php echo $branch_Obj[0]["branch_name"]; ?></td>
								<td><?php echo $room_obj[$i]["room_capacity"]; ?></td>
								<td><?php if ($room_obj[$i]["room_active"] == 1 ) { ?>
										<p>Active</p>
									<?php } else {?>
										<p>Inactive</p>
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