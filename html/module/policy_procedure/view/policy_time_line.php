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
$policyObj				=new policy($_POST['policy_id']);
$policy_actions_log		=$policyObj->get_actions_log();
?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"><?php echo "Actions Log"; ?></h4>
			</div>
			<div class="modal-body">
			<?php
			for($i=0;$i<count($policy_actions_log);$i++)
			{
				echo " On <b>".$policy_actions_log[$i]["date_time_inserted"]."</b> User : <b>".$policy_actions_log[$i]["employee_full_name"]."</b> -  Action Performed : <b>".$policy_actions_log[$i]["action_title"]."</b>";
				echo "<br/>";
				if(strlen($policy_actions_log[$i]["tracker_comment"]))
				{
					echo "<span style='font-style:italic'>".$policy_actions_log[$i]["tracker_comment"]."</span>";
					echo "<br/>";
				}
				echo "<hr/>";
				
				
			}
			?>
			</div>
		</div>
	</div>
</div>