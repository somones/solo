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
require_once("../../../../html/lib/model/department.class.php");
require_once("../model/policy.class.php");
//$menu_itemObj			=new menu_item($_POST['menu_id']);
$employeeObj			=new employee($_SESSION["employee_id"]);
$policyObj				=new policy($_POST['policy_id']);
$av_attachaments		=$policyObj->get_available_attachments();
//print_r($_POST);
?>
<div class="row" style="margin-top:50px">
	<div class="col-lg-12">
		<input type="button" class="btn btn-primary" onclick="upload_new_file('policy_id','<?php echo $_POST['policy_id']; ?>','1','../../','')" value="Add new File"/>
	</div>
	<div class="col-lg-12" style="margin-top:20px">
		<div class="panel panel-success widget-support-tickets" id="dashboard-support-tickets">
			<div class="panel-heading">
				<span class="panel-title"><i class="panel-title-icon fa fa-bullhorn"></i>Policy realted documents</span>
				<div class="panel-heading-controls">
					<div class="panel-heading-text"><a href="#"><?php echo count($av_attachaments)." Files related"; ?></a></div>
				</div>
			</div> <!-- / .panel-heading -->
			<div class="panel-body tab-content-padding">
				<!-- Panel padding, without vertical padding -->
					<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="panel-padding no-padding-vr" style="overflow: hidden; width: auto; height: 300px;">

						<?php
							for($j=0;$j<count($av_attachaments);$j++)
							{
								
						?>
						<div class="ticket">
							<a href="../../../assets/uploads/<?php echo $av_attachaments[$j]["file_new_name"].".".$av_attachaments[$j]["file_extension"]; ?>" target="_blank" onclick="" title="" class="ticket-title"><?php echo $av_attachaments[$j]["file_display_name"].".".$av_attachaments[$j]["file_extension"]; ?></a>
							<span class="ticket-info">
								Published by  <a href="#" title=""><?php echo $av_attachaments[$j]["employee_full_name"]." on ".$av_attachaments[$j]["file_date_uploaded"]; ?></a>
							</span>
							<span class="ticket-info" style="cursor:pointer" title="Remove Attachement" onclick="unsign_att('<?php echo $_POST['policy_id']; ?>','<?php echo $av_attachaments[$j]["upload_id"]; ?>')">
								remove Document
							</span>							
						</div> <!-- / .ticket -->
						<?php
							}
						?>

						</div>
						<div class="slimScrollBar" style="background: rgb(136, 136, 136) none repeat scroll 0% 0%; width: 7px; position: absolute; top: 38px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 94.8367px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;">
					</div>
				</div>
			</div> <!-- / .panel-body -->

			</div>
		</div>	
	</div>
</div>
	