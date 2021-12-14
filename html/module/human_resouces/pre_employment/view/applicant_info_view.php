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
require_once("../model/interview_template.class.php");
require_once("../model/flow_interview.class.php");

require_once("../model/employment_request.class.php");

$actionObj			=	new employment_request();
$action_obj		=	$actionObj->get_action($_POST['status_id']);


$applicantObj	= new applicant($_POST['applicant_id']);
$applicant_f_name = $applicantObj->applicant_first_name;
$applicant_l_name = $applicantObj->applicant_last_name;
$applicant_name = $applicant_f_name." ".$applicant_l_name;
$applicant_obj	=$applicantObj->flow_applicant_details($_POST['applicant_id']);

$interview_templateObj = new interview_template();
$av_templates = $interview_templateObj->list_of_templates();

$interviewObj 	= new Flow();
$interview_obj 	= $interviewObj->interview_per_applicant($_POST['applicant_id'], $_POST['flow_id']);


?>

<div class="px-content">
    <div class="page-header"><?php //print_r($_POST);?>
	<div class="btn-group pull-right col-xs-12 col-sm-auto">
		<div class="btn-group pull-right">
			<div class="form-group">
				<button type="button" class="btn" onclick="get_list_applicants('<?php echo $_POST['flow_id']; ?>', '<?php echo $_POST['status_id']; ?>')">Back</button>
				<?php if ($_POST['status_id'] == 5) { ?>
				<?php for($i=0;$i<count($action_obj);$i++) { 
							$action_id = $action_obj[$i]["action_id"];
							?>
							<button type="button" class="btn btn-primary" onclick="actions_log('<?php echo $action_id; ?>','<?php echo $_POST['request_id']; ?>')"><?php echo $action_obj[$i]["action_title"]; ?></button>
						<?php } ?>
				<?php } else {?>
				<label for="grid-input-3" class="col-md-3 control-label">Interview Type</label>
				<div class="col-md-6">
					<select class="form-control" id="template_id" onchange="get_template_form('<?php echo $applicantObj->applicant_id; ?>','<?php echo $_POST['flow_id']; ?>','<?php echo $_POST['status_id']; ?>')">
						<option value="" selected="selected">Select...</option>
						<?php for($i=0;$i<count($av_templates);$i++) { ?>
						<option value="<?php echo $av_templates[$i]["template_id"]; ?>">
							<?php echo $av_templates[$i]["template_name"]; ?>
						</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<?php } ?>
		</div>
	</div> 
</div>
	
<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body p-a-4 b-b-4 bg-white darken">
				<h1>
				      	<?php echo $applicant_name; ?>
				      	<?php echo $applicantObj->applicant_suffix; ?>
				   </h1>		
			</div>
		</div>
	</div>
	<div class="col-lg-6">
			<div class="panel">
				<div class="panel-body p-a-4 b-b-4 bg-white darken">
					<div class="box m-a-0 border-radius-0 bg-white darken">
						<div class="box-row valign-middle">
							<div class="box-cell col-md-6">
								<div class="display-inline-block m-r-3 valign-middle">
									<div class="font-size-18 font-weight-bold line-height-1">
										<strong>Email:</strong> 
										<?php echo $applicantObj->applicant_email; ?>
									</div>
									<div class="font-size-18 font-weight-bold line-height-1">
										<strong>Contact Number:</strong>
											<?php echo $applicantObj->applicant_phone_number; ?>
									</div>
								</div>

								<!-- Spacer -->
								<div class="m-t-3 visible-xs visible-sm"></div>

								<div class="display-inline-block p-l-1 b-l-3 valign-middle font-size-12 text-muted">
									<div></div>
									<div></div>
								</div>
							</div>

							<!-- Spacer -->
							<div class="m-t-3 visible-xs visible-sm"></div>
							<div class="box-cell col-md-6">
								<div class="pull-md-right font-size-15">
									<div class="text-muted font-size-13 line-height-1"><strong></strong></div>
									<strong></strong>
								</div>
								<div class="pull-md-right font-size-15">
									<div class="text-muted font-size-13 line-height-1"><strong></strong></div>
									<strong></strong>
								</div>
								<div class="pull-md-right font-size-15">
									<div class="text-muted font-size-13 line-height-1"><strong></strong></div>
									<strong></strong>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<table class="table table-responsive table-bordered table-primary" name="data_grid">
				<thead>
					<th>Number</th>
					<th>Interview</th>
					<th>Date</th>
					<th>Score</th>
				</thead>
				<tbody>
					<?php for($i=0;$i<count($interview_obj);$i++) { 
$template_obj = $interview_templateObj->template_per_interview($interview_obj[$i]["template_id_FK"]);
						$scourObj = $interviewObj->average_scour($interview_obj[$i]["interview_id"]);
					?>
					<tr>
						<td><?php echo $interview_obj[$i]["interview_id"]; ?></td>
						<td>
							<a href="#" onclick="updated_assigned_flow('<?php echo $interview_obj[$i]["template_id_FK"] ?>','<?php echo $applicantObj->applicant_id; ?>','<?php echo $interview_obj[$i]["interview_id"]; ?>','<?php echo $_POST['flow_id']; ?>')">
							<?php echo $template_obj[0]["template_name"]; ?>
							</a>
						</td>
						<td><?php echo $interview_obj[$i]["date_time_created"]; ?></td>
						<td>
							<?php if ($scourObj["AverageScour"] <> 0) {
								echo $scourObj["AverageScour"]; 
							} else {
								echo "--";
							} ?>
						</td>	
					</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
		
		<div class="col-lg-6">
			<div class="panel">
				<div class="panel-body p-a-4 b-b-4 bg-white darken">
					<?php 
						if ($applicantObj->applicant_cv_id_FK <> 0) {
							$file_id =  $applicantObj->applicant_cv_id_FK;

							$aapplicantObj = new applicant();
							$applicant_obj	=$aapplicantObj->get_applicant_file($file_id);
							for($i=0;$i<count($applicant_obj);$i++) {
								$path = "../../assets/uploads/";
								$file = $path.$applicant_obj[0]['file_new_name'].".".$applicant_obj[0]['file_extension'];
								?>
								
								<object width="100%" height="700" data="<?php echo $file ?>"></object>
								<?php
							}
						}
					 ?>
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="panel">
				<div class="panel-body p-a-4 b-b-4 bg-white darken"></div>
			</div>
		</div>
	</div>
</div>