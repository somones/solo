<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once("../../../lib/model/database.class.php");
require_once("../../../lib/model/company.class.php");
require_once("../../../lib/model/employee.class.php");
require_once("../../../lib/model/module.class.php");
require_once("../../../lib/model/item_category.class.php");
require_once("../../../lib/model/template.inc.php");
require_once("../model/policy_chapter.class.php");
require_once("../model/policy.class.php");
require_once("../model/policy_section.class.php");
require_once("../model/policy_state.class.php");
require_once("../model/tracker.class.php");
if(isset($_GET['pp']))
	$policy_id=$_GET['pp'];
if(isset($_POST['policy_id']))
	$policy_id=$_POST['policy_id'];

$companyObj				=new company(1);
$policyObj				=new policy($policy_id);
?>
<div id="modal-sizes-3" class="modal fade in" tabindex="-1" role="dialog" style="display: block;width:100%" aria-hidden="false" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Authenticate to View</h4>
			</div>
			<div class="modal-body">
			<div class="alert alert-info">
				Kindly note that this is a controlled Document , You cannot read this Document unless you have the Control Password ,<br/>
				If you wish to read this document , Contact the owner of the policy <b>[<?php echo $policyObj->employee_email; ?>]</b> , and ask for the authentication password.<br/>
				Thank you :)
				<?php
				//var_dump($policyObj);
				?>
			</div>
			 <div class="form-group">
				<label class="label-control">Please type your Password here</label>
				<input type="password" id="policy_password" class="form-control"/>
			 </div>
			 
			 <div class="row">
				<div class="col-lg-12 col-md-12">
				  <button type="submit" class="btn btn-primary" onclick="submit_authenticate_reading('<?php echo $policy_id; ?>')">Submit</button>
				</div>
			 </div>	

			 <div class="row">
				<div class="col-lg-12 col-md-12" id="authenticate_div">
				  
				</div>
			 </div>	
			
			</div>
		</div>
	</div>
</div>