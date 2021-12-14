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

require_once("../model/survey.class.php");


$menu_itemObj			=new menu_item($_POST['menu_id']);

$surveyObj 				= new survey();
$survey_Obj				= $surveyObj->get_survey_template();


?>
<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right"></div>
</div>
<div class="row">
	<div class="modal-content">
		<div class="modal-body">	
			<div class="panel">
				<div class="form-group">
		        	<select class="form-control" id="survey_template_id">
			            <option value="-1" selected="selected">Select...</option>
			            <?php for($i=0;$i<count($survey_Obj);$i++) { ?>
			            <option value="<?php echo $survey_Obj[$i]["survey_id"]; ?>">
			            	<?php echo $survey_Obj[$i]["text_phrase"]; ?>
			            </option>
			            <?php } ?>
			        </select>
		      	</div>
		      	<hr class="panel-wide-block">
		      	<div class="text-md-right">
		        	<button type="button" class="btn btn-primary" onclick="get_survy_report_details()">Send Form</button>
		      	</div>
		      	<hr class="panel-wide-block">
		      	<div id="email_div"></div>
			</div>	
		</div>
	</div>
</div>
