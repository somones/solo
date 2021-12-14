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
$surveyObj 				= new survey();
$section_Obj 			= $surveyObj->get_template_section(); 


$templateObj = $surveyObj->get_survey_template_name($_POST['survey_template_id'])?>
<?php if ($_POST['survey_template_id'] == -1) {
	echo "Please select Report template";
} else { ?>
<div class="row">
	<div class="modal-content">
		<div class="modal-header" style="background-color: #287c9f; text-align: center;">
			<h4 class="modal-title"><b style="color: #fff;"><?php echo $templateObj['text_phrase']." Report"; ?></b></h4>
		</div>
		<div class="modal-body">
			<table class="table table-responsive table-bordered table-primary" name="data_grid">
				<thead>
					<th>Section</th>
					<th>Date MM-DD-YYYY</th>
				</thead>
				<tbody id="table_result">
					<?php for ($i=0; $i < count($section_Obj); $i++) { ?>
				<tr>
					<td><?php echo $section_Obj[$i]['section_name']; ?></td>
					<td><?php print_r($surveyObj->get_section_question_count($section_Obj[$i]['section_id'])) ;  ?></td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php } ?>

<div class="modal-header" style="background-color: black; text-align: center;">
	<h6 class="modal-title"><b style="color: #fff;"><?php echo $templateObj['text_phrase']." Report"; ?></b></h6>
</div>
<table class="table table-responsive table-bordered table-primary" name="data_grid">
	<thead>
		<th>Question</th>
		<th>Excellent</th>
		<th>Good</th>
		<th>Fair</th>
		<th>Poor</th>
	</thead>
	<tbody id="table_result">
	<tr>
		<td>How would you rate the services provided by the admission staff</td>
		<td>74</td>
		<td>26</td>
		<td>0</td>
		<td>0</td>
	</tr>
	</tbody>
</table>