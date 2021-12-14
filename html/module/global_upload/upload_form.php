<?php
session_start();
/*
require_once("../../lib/model/database.class.php");
require_once("../../lib/model/item_category.class.php");
require_once("../../lib/model/company.class.php");
require_once("../../lib/model/branch.class.php");
require_once("../../lib/model/employee.class.php");
require_once("../../lib/model/module.class.php");
require_once("../../lib/model/menu_item.class.php");
require_once("../../lib/model/department.class.php");
require_once("../model/policy_chapter.class.php");
require_once("../model/policy.class.php");
require_once("../model/policy_section.class.php");
require_once("../model/policy_state.class.php");
require_once("../model/tracker.class.php");
*/
//$policyObj				=new policy($_POST['policy_id']);
?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Upload New File</h4>
			</div>
			<div class="modal-body">
				<div class="form-group col-lg-12" >
					<label for="exampleInputFile">File input</label>
					<input type="file" id="file_uploader" name="att">
					<p class="help-block">Only PDF or word Files allowed.</p>
				</div>	
				<div class="form-group col-lg-12" id="upload_fie_div">
				</div>					
			</div>
            <button type="button" id="btn_visible" class="btn btn-primary col-md-9" class="close" data-dismiss="modal" style="width: 100%" hidden="hidden">Save</button>
		</div>
	</div>
</div>