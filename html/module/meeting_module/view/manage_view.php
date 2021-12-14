<?php
session_start();
require_once("../../../lib/model/database.class.php");
require_once("../../../lib/model/company.class.php");
require_once("../../../lib/model/employee.class.php");
require_once("../../../lib/model/module.class.php");
require_once("../../../lib/model/item_category.class.php");
require_once("../../../lib/model/template.inc.php");

$templateObj 	=new template('../../../../html/');
$templateObj->start_head();
?>
<script type="text/javascript" src="../assets/JS/meetings.js"/></script>
<?php
$templateObj->close_head();
$templateObj->start_body($_GET['module']);
$templateObj->draw_main_menu($_GET['module']);
?>
<div id="content-wrapper">
<?php 
	$templateObj->draw_breadcrumb($_GET['module']);
	$moduleObj		=new module($_GET['module']);
	$x				=$moduleObj->get_menu_item_categories();
	$categoryObj	=new item_category(1);
	$av_menu_items	=$categoryObj->get_active_menu_items();	
?>
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
<div class="page-wide-block">
	<div class="box border-radius-0 bg-success" style="height: 100vh;">
<div class="box-cell col-lg-12 p-a-4 bg-danger darken">
<div class="col-lg-8">
	<span class="font-size-17 font-weight-light"><strong>Meeting</strong></span></br>
	<span class="font-size-17 font-weight-light"></span>
</div>
<div class="col-lg-8">
	<span class="font-size-17 font-weight-light"><strong>Room</strong></span></br>
	<span class="font-size-17 font-weight-light"></span>
</div>
<div class="col-lg-4">
	<span class="font-size-17 font-weight-light"><strong>Until</strong></span></br>
	<span class="font-size-17 font-weight-light"></span>
</div>
<div style="font-size: 96px;"><strong>BOOKED</strong></div>
<div style="font-size: 26px; text-align: justify;">Check in</div>
<!-- Chart -->
<div class="p-t-4">
	<form class="form-horizontal" method="post" action="<?= $form_location?>">
		<div class="form-group" >
			<div class="col-md-12" style="padding-bottom: 10px;">
				<input type="number" name="code" class="form-control" id="text-basic" placeholder="Enter a number" required>
			</div>
          	<!-- here buttons of chck in -->
	        <div class="col-md-12">
	        	<button type="submit" name="submit" value="Submit" class="btn btn-lg btn-warning btn-block" ><strong>CHECK IN</strong></button>
	      	</div>
      	</div>
	</form>
</div>
</div>
<!-- ------------------------NEXXT MEETING-------------------------------------------------->
<hr class="m-a-0 visible-xs visible-sm">
    <!-- Expenses -->
    <div class="box-cell col-lg-6 p-a-12">
    	<div style="font-size: 46px;">Next Meeting</div>
    	<div class="p-t-4">
        	<div id="owl-carousel-auto-width" class="owl-carousel">
  					<div class="demo-item bg-primary" style="width:100%">
  						<strong>Title: </strong>
  						<br>
  						<strong>At: </strong>
  					</div>
			</div>
		</div>
    </div>
</div>
</div>