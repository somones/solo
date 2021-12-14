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
require_once("../model/messages.class.php");
require_once("../model/distribution_list.class.php");

$distlistObj 						= new distribution_list();
$distlist_Obj						= $distlistObj->get_dl_list_name($_POST['message_distribution_id_FK']);
$distlist_Objct						= $distlistObj->get_contacts_list($_POST['message_distribution_id_FK']);
?>
<div class="row">
	<?php if ($_POST['distribution_list_type'] != 0) { ?>
	<div class="modal-content">
		<div class="modal-header" style="background-color: #287c9f; text-align: center;">
			<?php if ($_POST['message_type_id_FK'] ==1) { ?>
				<h4 class="modal-title"><b style="color: #fff;">Send Email to <?php echo $distlist_Obj[0]['list_name']; ?> List</b></h4>
			<?php } else if ($_POST['message_type_id_FK'] ==2){ ?>
				<h4 class="modal-title"><b style="color: #fff;">Send SMS to <?php //echo $distlist_Obj[0]['list_name']; ?> List</b></h4>
				<?php //print_r($_POST); ?>
			<?php } ?>
			<?php //echo $_POST['arabic_text']; ?>
		</div>
		<div class="modal-body">

			<div class="panel">
			    	<div class="form-group">
			        	<label for="page-messages-new-subject">Subject</label>
			        	<input type="text" class="form-control" id="message_subject" value="<?php echo $_POST['message_subject'] ?>">
			      	</div>
			      	<hr class="panel-wide-block">
			      	<div class="form-group">
			        	<textarea class="form-control" id="message_content" rows="8"><?php echo $_POST['message_content'] ?></textarea>
			      	</div>
			      	<hr class="panel-wide-block">

			      	<hr class="panel-wide-block">
					<div id="email_div"></div>
			      	<hr class="panel-wide-block">
					<div>
						<div class="text-md-right">
							<button type="button" class="btn btn-primary" onclick="send_and_save_this_messages('<?php echo $_POST['message_distribution_id_FK']; ?>','<?php echo $_POST['message_type_id_FK']; ?>','<?php echo $_POST['distribution_list_type']; ?>','<?php echo $_POST['menu_id']; ?>','<?php echo $_POST['arabic_text']; ?>')">Confirm and send</button>
							<button type="button" class="btn btn-danger pull-right" onclick="get_new_email_form('<?php echo $_POST['message_type_id_FK'] ?>','<?php echo $_POST['distribution_list_type'] ?>','<?php echo $_POST['menu_id']; ?>','<?php echo $_POST['distribution_list_type']; ?>')">Cancel</button>
						</div>			
					</div>		
			      	<hr class="panel-wide-block">
			      	<div class="form-group">
			      		<label for="page-messages-new-subject">List Of Email included in</label><?php echo " ".$distlist_Obj[0]['list_name']; ?>
			      	</div>					
			      	<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<?php if ($_POST['message_type_id_FK'] ==1) { ?>
					<thead>
						<th>Contact Name</th>
						<th>Contact Email</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($distlist_Objct);$i++) { 
							?>
							<tr>
								<td><?php echo $distlist_Objct[$i]["contact_name"]; ?></td>
								<td><?php echo $distlist_Objct[$i]["contact_email"]; ?></td>
							</tr>
						<?php } ?>
					</tbody>
					<?php } else if ($_POST['message_type_id_FK'] ==2){ ?>
					<thead>
						<th>Contact Name</th>
						<th>Contact Mobile Phone</th>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($distlist_Objct);$i++) { 
							?>
							<tr>
								<td><?php echo $distlist_Objct[$i]["contact_name"]; ?></td>
								<td><?php echo $distlist_Objct[$i]["contact_mobile_number"]; ?></td>
							</tr>
						<?php } ?>
					</tbody>
					<?php } ?>
				</table>
			</div>	
		</div>
	</div>
	<?php } else { ?>
		<div class="modal-content">
		<div class="modal-header" style="background-color: #287c9f; text-align: center;">
				<h4 class="modal-title"><b style="color: #fff;">Send Standard SMS</b></h4>
				<?php //echo $_POST['arabic_text']; ?>
				<?php //print_r($_POST); ?>
		</div>
		<div class="modal-body">
			<div class="panel">
				<div class="form-group">
		        	<label for="page-messages-new-subject">Number</label>
		        	<input type="text" class="form-control" id="receiver_number" value="<?php echo $_POST['receiver_number'] ?>">
		      	</div>
		    	<div class="form-group">
		        	<label for="page-messages-new-subject">Subject</label>
		        	<input type="text" class="form-control" id="message_subject" value="<?php echo $_POST['message_subject'] ?>">
		      	</div>
		      	<hr class="panel-wide-block">
		      	<div class="form-group">
		        	<textarea class="form-control" id="message_content" rows="8"><?php echo $_POST['message_content'] ?></textarea>
		      	</div>
		      	<hr class="panel-wide-block">
				<div id="email_div"></div>
		      	<hr class="panel-wide-block">
				<div>
					<div class="text-md-right">
						<button type="button" class="btn btn-primary" onclick="send_and_save_this_messages('<?php echo $_POST['message_distribution_id_FK']; ?>','<?php echo $_POST['message_type_id_FK']; ?>','<?php echo $_POST['distribution_list_type']; ?>','<?php echo $_POST['menu_id']; ?>','<?php echo $_POST['arabic_text']; ?>')">
						Confirm and send</button>
						<button type="button" class="btn btn-danger pull-right" onclick="get_new_email_form('<?php echo $_POST['message_type_id_FK'] ?>','<?php echo $_POST['distribution_list_type'] ?>','<?php echo $_POST['menu_id']; ?>')">Cancel</button>
					</div>			
				</div>		
		      	<hr class="panel-wide-block">
			</div>	
		</div>
	</div>
	<?php } ?>
</div>

<div id="modal_default_confirm" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%"></div>