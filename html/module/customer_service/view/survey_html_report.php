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
$survey_Obj				= $surveyObj->survy_html_report_query();
$survey_tmp_Obj			= $surveyObj->get_survey_template();

$branchObj 				= new branch();
$branch_Obj				= $branchObj->get_active_branches();

 ?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-2">
					<label class="label-control">Template</label>
					<select class="form-control" id="survey_template_id">
			            <option value="-1" selected="selected">Select...</option>
			            <?php for($i=0;$i<count($survey_tmp_Obj);$i++) { ?>
			            <option value="<?php echo $survey_tmp_Obj[$i]["survey_id"]; ?>">
			            	<?php echo $survey_tmp_Obj[$i]["text_phrase"]; ?>
			            </option>
			            <?php } ?>
			        </select>
				</div>
				<div class="col-lg-2">
					<label class="label-control">Branch</label>
					<select class="form-control" id="branch_id">
			            <option value="-1" selected="selected">Select...</option>
			            <?php for($i=0;$i<count($branch_Obj);$i++) { ?>
			            <option value="<?php echo $branch_Obj[$i]["branch_id"]; ?>">
			            	<?php echo $branch_Obj[$i]["branch_name"]; ?>
			            </option>
			            <?php } ?>
			        </select>
				</div>	
				<script type="text/javascript">//$("[id='bs-datepicker-range']").datepicker({format: 'yyyy-mm-dd'});</script>
				<div class="col-lg-6">
					<label class="label-control">Date Created</label>
					<div class="input-daterange input-group" id="bs-datepicker-range" >
						<input type="text" class="input-sm form-control" id="date_start" name="date_time_value" placeholder="date from">
						
						<span class="input-group-addon">to</span>
						<input type="text" class="input-sm form-control" id="date_end" name="date_time_value" placeholder="date till">
					</div>
				</div>
				
				<div class="col-lg-2">
					<label class="label-control">&nbsp;</label>
					<div class="form-control" style="border:none;bg-color:none"><input type="button" class="input-sm btn btn-primary" onclick="get_result()" value="Generate"/></div>
				</div>
			</div>
			</div>

			<!--
			<table class="table table-responsive table-bordered table-primary" name="data_grid">
				<thead>
					<th>record_id_FK</th>
					<th>question_id_FK</th>
					<th>answer_id_FK</th>
					<th>date_answered</th>
					<th>record_doctor_id_FK</th>
					<th>branch_id_FK</th>
					<th>survey_id_FK</th>
					<th>record_name
					<th>record_file_number</th>
					<th>question_rating_id_FK</th>
					<th>section_id_FK</th>
					<th>text_id</th>
					<th>text_language_id_FK</th>
					<th>object_type</th>
					<th>object_id_FK</th>
					<th>text_phrase</th>
				</thead>
				<tbody id="table_result">
					<?php //print_r($survey_Obj); ?>
				</tbody>
			</table>-->

			<div class="col-lg-12" id="table_result"></div>
		</div>
	</div>
