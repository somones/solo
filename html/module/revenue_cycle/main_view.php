<?php
session_start();
require_once("../../lib/model/database.class.php");
require_once("../../lib/model/company.class.php");
require_once("../../lib/model/employee.class.php");
require_once("../../lib/model/module.class.php");
require_once("../../lib/model/item_category.class.php");
require_once("../../lib/model/template.inc.php");

$templateObj 	=new template('../../../../html/');
$moduleObj		=new module($_GET['module']);
$templateObj->start_head($moduleObj->module_name);?>
<script type="text/javascript" src="master_settings/assets/JS/master_settings.js"></script>
<script type="text/javascript" src="billing_settings/assets/JS/billing_cycle.js"></script>
<script type="text/javascript" src="invoices/assets/JS/invoices.js"></script>
<script type="text/javascript" src="customer/assets/JS/customer.js"></script>
<!--
<script src="../Lib/ckeditor/ckeditor.js"></script>
<script src="../Lib/ckeditor/samples/js/sample.js"></script>
<link rel="stylesheet" href="../Lib/ckeditor/samples/css/samples.css">
<link rel="stylesheet" href="../Lib/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
-->
<?php
$templateObj->close_head();
$templateObj->start_body($_GET['module']);
$templateObj->draw_main_menu($_GET['module']);
?>
<div id="content-wrapper">
<?php 
	$templateObj->draw_breadcrumb($_GET['module']);
	$moduleObj		=new module($_GET['module']);
	$x				=$moduleObj->get_all_menu_item_categories();
	$categoryObj	=new item_category(1);
	$av_menu_items	=$categoryObj->get_active_menu_items();	
?>
</div>
<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<div id="sub-content-wrapper" style="margin-top:-30px !important">
</div>
<div id="main-menu-bg"></div>

<?php
$templateObj->close_body();
?>
<script src="../../../../html/assets/demo/demo.js"></script>
<script type="text/javascript">
//show_loading_gif("content-wrapper","Loading...");
	var init = [];
	init.push(function () {
		// Javascript code here
		$('#profile-tabs').tabdrop();
	})
	window.PixelAdmin.start(init);
</script>
