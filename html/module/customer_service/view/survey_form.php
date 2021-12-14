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
require_once("../../../lib/model/branch.class.php");
require_once("../model/survey.class.php");
$companyObj				=new company(1);
$templateObj 			=new template('../../../../html/');
$templateObj->start_head("Survey");
$str_questions="";
?>
<script type="text/javascript" src="../assets/JS/survey.js"></script>
<?php
$templateObj->close_head();
?>
<body <?php if($_GET['language']==2){  ?> style="font-size:20px" <?php  } ?> class="theme-default main-menu-animated main-navbar-fixed main-menu-fixed page-profile <?php if(isset($_GET['language']) && $_GET['language']==2) echo " right-to-left"; ?>">
<?php
if(isset($_GET['template']) && isset($_GET['language']))
{
	$branchObj			=new branch($_GET['branch']);
	$surveyObj			=new survey($_GET['template']);
	$survey_ratings		=$surveyObj->get_survey_rating($_GET['language']);
	$survey_questions	=$surveyObj->get_survey_questions($_GET['language']);
	$av_doctors			=$surveyObj->get_survey_doctors($_GET['branch']);
?>
	<div class="main-wrapper">
			<div class="row">
				<div class="col-lg-12">
					&nbsp;
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
				
				<div class="panel panel-default">
				  <div class="panel-heading">&nbsp;</div>
				  <div class="panel-body">
					<div class="form-group">
						<label class="label-control"><?php echo $surveyObj->get_label_text(4,1001,$_GET['language']); ?></label>
						<input type="text" class="form-control" disabled="disabled" value="<?php echo $branchObj->branch_name; ?>" id="branch"/>
					</div>
					
					<div class="form-group">
						<label class="label-control"><?php echo $surveyObj->get_label_text(4,1000,$_GET['language']); ?></label>
						<select  id="gender" class="form-control">
							<option  value="1"><?php echo $surveyObj->get_label_text(4,1002,$_GET['language']); ?></option>
							<option value="2"><?php echo $surveyObj->get_label_text(4,1003,$_GET['language']); ?></option>
						</select>						

					</div>	


					<?php
					if($_GET['template']==2)
					{
					?>
					<div class="form-group">
						<label class="label-control"><?php echo $surveyObj->get_label_text(4,1010,$_GET['language']); ?></label>
						<select id="doctor_id" class="form-control">
						<?php
						for($i=0;$i<count($av_doctors);$i++)
						{
							?>
							<option style="font-size:24px" value="<?php echO $av_doctors[$i]["doctor_id_FK"]; ?>"><?php echo $surveyObj->get_label_text(5,$av_doctors[$i]["doctor_id_FK"],$_GET['language']); ?></option>
							<?php
						}
						?>
						</select>
					</div>
					<?php
					}
					?>
					
				  </div>
				
				</div>
			</div>

			<div>
				<div class="col-lg-12">
				
				<div class="panel panel-default">
				  <div class="panel-heading"><?php echo $surveyObj->get_label_text(2,$_GET['template'],$_GET['language']); ?></div>
				  <div class="panel-body">
				  
					<table class="table table-primary table-bordered table-hovered table-responsive" >

							<tbody>
								<?php
								//print_r($survey_questions);
								for($i=0;$i<count($survey_questions);$i++)
								{
									$str_questions.=$survey_questions[$i]["question_id_FK"].",";
									?>
									<tr>
										<td style='width:60%'><?php echo $survey_questions[$i]["text_phrase"]; ?></td>
										<td>
											<div class="btn-group" data-toggle="buttons">
												<?php 
												//print_r($survey_ratings);
												for($j=0;$j<count($survey_ratings);$j++)
												{
													?>
													<label class="btn btn-default" <?php if($_GET['language']==2){  ?> style="font-size:20px !important;" <?php  } ?> >
														<input type="radio" name="option_<?php echo $survey_questions[$i]["question_id_FK"]; ?>" value="<?php echo $survey_ratings[$j]["attribute_id"]; ?>" autocomplete="off">
													<?php echo $survey_ratings[$j]["text_phrase"]; ?>
														</label>
													</label>
													<?php
												}
												?>	
											</div>
										</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>				  
						<div class="col-lg-12" style="text-align:center">
							<input type="button" class="btn btn-primary" onclick="submit_save_survey('<?php echo $_GET['template']; ?>','<?php echo $_GET['branch']; ?>','<?php echo $str_questions; ?>','<?php echo $_GET['language']; ?>')" value="<?php echo $surveyObj->get_label_text(4,1005,$_GET['language']); ?>">
						</div>				  
				  </div>
				  

				  
				</div>				
				
					
					
				
				</div>

			</div>
			


	</div>
</div>
<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<?php
}
?>
<style>
.btn-group .btn-default.active, .btn-group .btn-default:active, .btn-group .btn.active, .btn-group .btn:active, .input-group-btn .btn-default.active, .input-group-btn .btn-default:active, .input-group-btn .btn.active, .input-group-btn .btn:active {

    border-left-color: #c6c6c6;
    border-right-color: #c6c6c6;
    background:#3ea984 !important;
	color:#FFFFFF !important;

}
	

</style>
<script type="text/javascript">
function on_password_entry(policy_id)
{
	var pass=$('#auth_token').val();
	var encoded_str=encodeURIComponent(pass);
	//alert(encoded_str);
	str="read_main_view.php?pp="+policy_id+"&auth_token="+encoded_str;
	//var res = encodeURIComponent(str);
	//alert(res);
	window.location.replace(str);
}

$(document).ready(function () {
    //Disable full page
    $("body").on("contextmenu",function(e){
        return false;
    });
    
    //Disable part of page
    $("#id").on("contextmenu",function(e){
        return false;
    });
	
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
    
    //Disable part of page
    $('#id').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });
	
});
</script>