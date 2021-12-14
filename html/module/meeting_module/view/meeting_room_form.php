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

$branchObj 	= new branch();
$branch_obj 	= $branchObj->get_active_branches($_SESSION['employee_id']);

if($_POST["room_id"]==-1)
{
		$room_title					="";
		$room_description			="";
		$branch_id_FK				="";
		$room_capacity				="";
}
else{
		$thiscodeObj=new meeting_room($_POST['room_id']);

		$room_title						=$thiscodeObj->room_title;
		$room_description				=$thiscodeObj->room_description;
		$branch_id_FK					=$thiscodeObj->branch_id_FK;
		$room_capacity       			=$thiscodeObj->room_capacity;

}	
?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Room</h4>
			</div>

			<div class="modal-body">
				
				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Room Name: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="room_title" value="<?php echo $room_title; ?>" placeholder="Room Name">
					</div>
				</div>

				<div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Room Description: </label>
					<div class="col-md-9">
						<textarea type="text" class="form-control" id="room_description" value="<?php echo $module_url; ?>"><?php echo $room_description; ?></textarea>
					</div>

				</div>

				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Room Branch</label>
			        <div class="col-md-9">
			          <select class="form-control" id="branch_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($branch_obj);$i++) { ?>
			                <option <?php if($branch_obj[$i]["branch_id"] == $branch_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $branch_obj[$i]["branch_id"]; ?>"><?php echo $branch_obj[$i]["branch_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

			    <div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Room Capacity: </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="room_capacity" value="<?php echo $room_capacity; ?>" placeholder="Room Capacity">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_meeting_room('<?php echo $_POST['room_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="modules_form_div"></div>	
			</div>
		</div>
	</div>
</div>
