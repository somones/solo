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
require_once("../../master_settings/model/code.class.php");
require_once("../model/billing_items.class.php");
require_once("../model/billing_item_categories.class.php");
require_once("../model/tax_profile.class.php");


$codetypeObj 	= 	new billing_item_category();
$codetype_obj 	= 	$codetypeObj->list_of_billing_item_category($_SESSION['employee_id']);

$profileObj 	= 	new tax_profile();
$profile_Obj 	= 	$profileObj->list_of_tax_profile($_SESSION['employee_id']);

$codeObj		=	new rc_code();
$code_Obj 		= 	$codeObj->list_of_code();


if($_POST["billing_item_id"]==-1)
{
	$item_category_id_FK			=	"";
	$item_description				=	"";
	$item_code_id_FK				=	"";
	$item_code_value				=	"";
	$tax_profile_id_FK				=	"";
	$tax_value						=	"";
}
else{
	$thiscodeObj=new billing_item($_POST['billing_item_id']);

	$item_category_id_FK			=	$thiscodeObj->item_category_id_FK;
	$item_description				=	$thiscodeObj->item_description;
	$item_code_id_FK				=	$thiscodeObj->item_code_id_FK;
	$item_code_value       			=	$thiscodeObj->item_code_value;
	$tax_profile_id_FK       		=	$thiscodeObj->tax_profile_id_FK;
	$tax_value						=	$thiscodeObj->tax_value;
}
?>

<script type="text/javascript">

$(document).ready(function(){
    $("#search_data").keyup(function(){
        var search_token = $(this).val();
        if(search_token != "") {
            $.ajax({
                url: 'billing_settings/controller/billing_settings_controller.php',
				method: 'post',
				data: 'category_id=1'+'&search_token='+search_token+'&action=6',
				dataType: 'json',
                success:function(result) {
                	console.log(result)
                    var len = result.length;
                   	$("#search_result").empty();
                    for( var i = 0; i<len; i++){
                        
                        var code_id 	= result[i]['code_id'];
 						var code_value 	= result[i]['code_value'];
 						var code_desc 	= result[i]['code_description'];
 						$("#search_result").append("<p value='"+code_id+"'>"+code_value+"</p>");
                    }
                    $("#search_result p").bind("click",function() { 
                    	$('#search_data').val(code_value);
                    	$('#item_description').val(code_desc);
                    	$('#item_code_value').val(code_value);
                    	$('#item_code_id_FK').val(code_id);
                    	
                    	$("#item_code_id_FK").attr("disabled", true);
                    	$("#search_result").empty();
                	});
                }
            });
        }
    });
});
</script>

<script type="text/javascript">
	$("#item_code_id_FK").change(function(){
		var code_id = $("#item_code_id_FK").val();
		$.ajax({
			url: 'billing_settings/controller/billing_settings_controller.php',
			method: 'post',
			data: 'category_id=1'+'&code_id='+code_id+'&action=5',
			dataType: 'json'
		}).done(function(results) {
			if (results.length != 0) {
				//console.log(results[0]['code_description']);

				$('#item_description').text(results[0]['code_description']);
				$('#item_code_value').text(results[0]['item_code_value']);
				$('#tax_profile_id_FK').text(results[0]['tax_profile_id_FK']);
			} else {
				$('#item_description').html('No result');
			}
		})
	})
</script>

<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
				<h4 class="modal-title">Add Edit/ Billing Item</h4>
				<?php //print_r($_POST['results']); ?>
			</div>

			<div class="modal-body">
				<div class="form-group">
					<div class="col-md-12">
						<input type="text" class="form-control input-lg m-b-2" id="search_data" placeholder="Search for..." autocomplete="off">
					</div>
					<div id="search_result"></div>
				</div>
				<hr>
				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Billing Item Category</label>
			        <div class="col-md-9">
			          <select class="form-control" id="item_category_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($codetype_obj);$i++) { ?>
			                <option <?php if($codetype_obj[$i]["category_id"] == $item_category_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $codetype_obj[$i]["category_id"]; ?>"><?php echo $codetype_obj[$i]["category_description"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

				<div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Item Code : </label>
			        <div class="col-md-9">
			          <select class="form-control" id="item_code_id_FK" >
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($code_Obj);$i++) { ?>
			                <option <?php if($code_Obj[$i]["code_id"] == $item_code_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $code_Obj[$i]["code_id"]; ?>"><?php echo $code_Obj[$i]["code_value"];
			                	$code_value = $code_Obj[$i]["code_value"];
			                	?>
			                </option>
			              <?php } ?>
			          </select>
						<input type="hidden" id="item_code_value" value="<?php echo $code_value; ?>">
			        </div>
			    </div>

				
				
			    <div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Billing Item Description: </label>
					<div class="col-md-9">
						<textarea id="item_description" class="form-control" placeholder="Billing Item Description"><?php echo $item_description; ?></textarea>
					</div>
				</div>

			    <div class="form-group">
			        <label for="grid-input-3" class="col-md-3 control-label">Tax Profile</label>
			        <div class="col-md-9">
			          <select class="form-control" id="tax_profile_id_FK">
			            <option value="" selected="selected">Select...</option>
			              <?php for($i=0;$i<count($profile_Obj);$i++) { ?>
			                <option <?php if($profile_Obj[$i]["profile_id"] == $tax_profile_id_FK) {  ?> 
			                	selected="selected" <?php  } ?> value="<?php echo $profile_Obj[$i]["profile_id"]; ?>"><?php echo $profile_Obj[$i]["profile_name"]; ?></option>
			              <?php } ?>
			          </select>
			        </div>
			    </div>

			    <div class="form-group">
					<label for="grid-input-1" class="col-md-3 control-label">Tax Value : </label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="tax_value" value="<?php echo $tax_value; ?>" placeholder="Tax Value">
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="save_billing_item('<?php echo $_POST['billing_item_id']; ?>')">Save Form</button>
					</div>
				</div>	
				<div id="code_form_div"></div>	
			</div>
		</div>
	</div>
</div>
