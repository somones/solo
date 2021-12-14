<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../../meeting_module/model/meeting.class.php");

if($_POST['action']==1)
{
	$roleObj			=new meeting();
	$roleObj->update_atendee($_POST['employee_id_FK']);
}
?>