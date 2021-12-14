<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/employee.class.php");
require_once("../../../../../html/lib/model/module.class.php");
require_once("../../../../../html/lib/model/menu_item.class.php");
require_once("../../../../../html/lib/model/department.class.php");
require_once("../model/applicant.class.php");

$aapplicantObj = new applicant();



?>

<div class="px-content">
    <div class="page-header">
	<div class="btn-group pull-right col-xs-12 col-sm-auto">
		<div class="btn-group pull-right">
			<div class="form-group">
				<button type="button" class="btn" onclick="back_to_pool()">Back</button>
			</div>

		</div>
	</div> 
</div>
	
<div class="row">
		<div class="col-lg-12">
			<div class="panel">
				<div class="panel-body p-a-4 b-b-4 bg-white darken">
					<?php 
						$applicant_obj	=$aapplicantObj->get_applicant_file($_POST['file']);
						for($i=0;$i<count($applicant_obj);$i++) {
							$path = "../../assets/uploads/";
							$file = $path.$applicant_obj[0]['file_new_name'].".".$applicant_obj[0]['file_extension']; ?>
							<?php
						} 
					?>
					<object width="100%" height="700" data="<?php echo $file ?>"></object>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="sub-content-wrapper"></div>
