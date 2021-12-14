<?php
session_start();
require_once("../../../lib/model/database.class.php");
require_once("../../../lib/model/company.class.php");
require_once("../../../lib/model/employee.class.php");
require_once("../../../lib/model/module.class.php");
require_once("../../../lib/model/item_category.class.php");
require_once("../../../../html/lib/model/menu_item.class.php");

require_once("../../../lib/model/template.inc.php");
require_once("../model/survey.class.php");
$menu_itemObj				=new menu_item($_POST['menu_id']);
$surveyObj 			= new survey();
$survey_list		=$surveyObj->get_active_templates();
$available_lang		=$surveyObj->get_available_lang();
?>
<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary" onclick="get_section_form('-1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Section</button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12"></div>
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="table table-responsive">
				<table class="table table-responsive table-bordered table-primary" name="data_grid">
					<thead>
						<th width="100px">Title</th>
						<?php
						for($i=0;$i<count($available_lang);$i++)
						{
							?>
							<th width="200px"><?php echo $available_lang[$i]["langauage_name"]; ?></th>
							<?php
						}
						?>
					</thead>
					<tbody>
						<?php
						for($i=0;$i<count($survey_list);$i++)
						{
							$thissurvey=new survey($survey_list[$i]["survey_id"]);
							
						?>
						<tr>
							<td><?php echo $survey_list[$i]["text_phrase"]; ?></td>
							<?php
							for($j=0;$j<count($available_lang);$j++)
							{
							?>
							<td><a href="survey_form.php?template=<?php echo $survey_list[$i]["survey_id"]; ?>&language=<?php echo $available_lang[$j]["language_id"]; ?>" target="_"><input type="button" class="btn btn-primary" value="Start Survey&nbsp;-&nbsp;<?php echo $available_lang[$j]["langauage_name"]; ?>"></a></td>
							<?php								
							}
							?>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>