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
require_once("../model/consent_request.class.php");
?>

<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Add Edit/Consent Category</h4>
				<?php //print_r($_POST); ?>
			</div>

			<div class="modal-body">	
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-body p-a-4 b-b-4 bg-white darken">
							<?php 
								if ($_POST['file_id'] <> NULL) { ?>
									<object width="100%" height="700" data="<?php echo $_POST['file_id']; ?>"></object>
								<?php } else {
									echo "Sorry There is no File";
								}
							 ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div>
			<button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" style="width: 100%">Close</button>
		</div>
	</div>
</div>
