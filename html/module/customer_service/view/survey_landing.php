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
?>
<body class="theme-default main-menu-animated main-navbar-fixed main-menu-fixed page-profile">

<div class="row">
	<div class="col-lg-12" style="text-align:center">
		<a href="survey_form.php?template=<?php echo $_GET['template']; ?>&branch=<?php echo $_GET['branch']; ?>&language=1"><input type="button" class="btn btn-primary btn-lg" value="English" style="width:200px !important;height:50px !important"></a>	
	</div>
</div>
<div class="row">
	<div class="col-lg-12" style="text-align:center">
		&nbsp;
		<br/>
		&nbsp;
		<br/>	
	</div>
</div>


<div class="row">
	<div class="col-lg-12" style="text-align:center">
		<a href="survey_form.php?template=<?php echo $_GET['template']; ?>&branch=<?php echo $_GET['branch']; ?>&language=2"><input type="button" class="btn btn-primary btn-lg" style="font-weight:18px !important;width:200px !important;height:50px !important" value="العربية"></a>
	</div>
</div>


</body>
