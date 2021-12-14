<?php
session_start();
date_default_timezone_set("Asia/Dubai");

//$_SESSION['company_id']		=1;
//$_SESSION['employee_id']	=3;
if(!isset($_SESSION['employee_id']))
	header("location:googleLogin/index.php");
else
{
require_once("html/lib/model/database.class.php");
require_once("html/lib/model/employee.class.php");
$employeeObj=new employee($_SESSION['employee_id']);
if($employeeObj->profile_completed==0)
	header("location:html/module/profile/view/profile_view.php");
	
}	



require_once("html/lib/model/database.class.php");
require_once("html/lib/model/item_category.class.php");
require_once("html/lib/model/company.class.php");
require_once("html/lib/model/employee.class.php");
require_once("html/lib/model/module.class.php");
require_once("html/lib/model/template.inc.php");
$templateObj 	=new template('html/');
$templateObj->start_head("HOME");
$templateObj->close_head();
$templateObj->start_body();
$templateObj->draw_main_menu();
?>
<div id="content-wrapper">
<?php
//print_r($_SESSION);
//$gpUserProfile = $google_oauthV2->userinfo->get();
?>
</div>
<div id="main-menu-bg"></div>
<?php
$templateObj->close_body();
?>
<script src="html/assets/demo/demo.js"></script>
<script type="text/javascript">
	var init = [];
	init.push(function () {
		// Javascript code here
		$('#profile-tabs').tabdrop();
	})
	window.PixelAdmin.start(init);
</script>