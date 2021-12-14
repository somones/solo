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

require_once("../model/messages_template_categorie.class.php");
require_once("../model/distribution_list.class.php");
require_once("../model/messages.class.php");


$menu_itemObj						=new menu_item($_POST['menu_id']);

$messageObj							=new messages();
$distlistObj 						= new distribution_list();
$distlist_Obj						= $distlistObj->list_of_dl_per_type($_POST['type_id']);

$template_categorieObj 				= new messages_template_categorie();
$template_categorie_Obj				= $template_categorieObj->list_of_messages_template_categorie();


if($_POST['message_type']==1)
{
	$header_text="Send New Email";
	$button_text="Send Email";
}	
else if($_POST['message_type']==2)
{
	$header_text="Create New SmS";
	$button_text="Send SMS";
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#category").change(function(){
			var aid = $("#category").val();
			$.ajax({
				url: '../model/templates.conf.php',
				method: 'post',
				data: 'aid='+aid
			}).done(function(templates){
				//console.log(templates);
				templates = JSON.parse(templates);
				$('#templates').empty();
				templates.forEach(function(template){
				$('#templates').append('<option value="'+ template.message_template_description +'">'+ template.message_template_name +'</option>');
					$("#message_content").empty("");
					$("#templates option").bind("click",function() { 
						var template_description = this.value;
                		$('#message_content').val(template_description);
                	});
				})
			})
		})
	})
</script>

<div class="page-header">
    <h1><i class="page-header-icon ion-ios-pulse-strong">&nbsp;&nbsp;</i><?php echo $menu_itemObj->item_title; ?></h1>
    <div class="btn-group pull-right">
    </div>
    <?php //print_r($_POST); ?>
</div>
<div>
	<div class="panel">
	  	<div class="panel-heading"><div class="panel-title"></div></div>
	  	<div class="panel-body">
	    	<form class="form-horizontal" method="post" action=""> 
				<div class="form-group">
		        	<label for="page-messages-new-to">Template Category</label>
		        	<select class="form-control" id="category">
			            <option value="-1" selected="selected">Select...</option>
			            <?php for($i=0;$i<count($template_categorie_Obj);$i++) { ?>
			            <option value="<?php echo $template_categorie_Obj[$i]["message_templates_categories_id"]; ?>">
			            	<?php echo $template_categorie_Obj[$i]["message_templates_categories_name"]; ?>
			            </option>
			            <?php } ?>
			        </select>
		      	</div>
		      	<div class="form-group">
		        	<label for="page-messages-new-to">Message Template</label>
		        	<select class="form-control" id="templates">
			            <option value="-1" selected="selected">Select...</option>
			        </select>
		      	</div>
		      	<div class="form-group">
		        	<label for="page-messages-new-to">To</label>
		        	<select class="form-control" id="message_distribution_id_FK">
			            <option value="" selected="selected">Select...</option>
			            <?php for($i=0;$i<count($distlist_Obj);$i++) { ?>
			            <option value="<?php echo $distlist_Obj[$i]["list_id"]; ?>">
			            	<?php echo $distlist_Obj[$i]["list_name"]; ?>
			            </option>
			            <?php } ?>
			        </select>
		      	</div>

		      	<div class="form-group">
		        	<label for="page-messages-new-subject">Subject</label>
		        	<input type="text" class="form-control" id="message_subject">
		      	</div>

		      	<hr class="panel-wide-block">
		      	<div class="form-group">
		        	<textarea class="form-control" id="message_content" rows="8" onkeyup="charcountupdate(this.value)"></textarea>
		        	<?php if ($_POST['message_type'] == 2) { ?>
		        		<input type="checkbox" name="arabic_text" id="arabic_text" value="1"> <b>ARABIC TEXT</b>
		        		<span id=charcount class="pull-right"></span>
			        	<script type="text/javascript">
			        		function charcountupdate(str) {
								var lng = str.length;
								document.getElementById("charcount").innerHTML = lng + ' out of 400 characters';
								if (lng>400) {
									var sms = lng / 400;
									var smsNbr = parseInt(sms, 10) + 1;
									document.getElementById("charcount").innerHTML = lng + ' out of 400 Characters /'+ ' SMS '+ smsNbr;
								}
							}
			        	</script>
		        	<?php } ?>
		      	</div>
		      	<hr class="panel-wide-block">
		      	<div class="text-md-right">
		        	<button type="button" class="btn btn-primary" onclick="confirm_email_form('<?php echo $_POST['message_type']; ?>','<?php echo $_POST['type_id']; ?>','<?php echo $_POST['menu_id']; ?>')"><?php echo $button_text;?></button>
		      	</div>
		      	<hr class="panel-wide-block">
		      	<div id="email_div"></div>
			</form>
		</div>
	</div>
</div>
