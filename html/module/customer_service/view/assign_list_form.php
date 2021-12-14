<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/employee.class.php");
require_once("../../../../html/lib/model/module.class.php");
require_once("../../../../html/lib/model/menu_item.class.php");
require_once("../../../../html/lib/model/department.class.php");
require_once("../model/contact.class.php");

$contactObj			=new contact();
$contact_Obj		=$contactObj->list_of_contacts();
$assigned = $contactObj->get_contact_assigned_list($_POST['list_id']);


?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"><?php echo $role_name; ?></h4>
			</div>
			<div class="modal-body">
				<?php
				//print_r($assigned);
				?>
				<table class="table table-primary" name="data_grid">
					<thead>
						<th style="width:10px"></th>
						<th style="width:400px">Contact Name</th>
						<th style="width:200px">Email</th>
						<th style="width:200px">Mobile Number</th>
					</thead>
					<tbody>
						<?php
							for($i=0;$i<count($contact_Obj);$i++)
							{
						?>
						<tr>
							<td><input value="<?php echo $contact_Obj[$i]["contact_id"]; ?>" <?php if(in_array($contact_Obj[$i]["contact_id"],$assigned)){  ?> checked="checked" <?php } ?> type="checkbox" id='contact_id_<?php echo $i; ?>'/></td>
							<td><?php echo $contact_Obj[$i]["contact_name"]; ?></td>
							<td><?php echo $contact_Obj[$i]["contact_email"]; ?></td>
							<td><?php echo $contact_Obj[$i]["contact_mobile_number"]; ?></td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			<?php
			//print_r($contact_Obj);
			?>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12" style="text-align:center">
						<input type="button" class="btn btn-primary" value="Update" onclick="update_contact_list('<?php echo $_POST['list_id']; ?>','<?php echo count($contact_Obj); ?>')">
					</div>
				</div>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12" id="assign_roles_div">
						
					</div>
				</div>
			</div>			
			
		</div>
	</div>
</div>