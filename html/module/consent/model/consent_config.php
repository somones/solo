<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../../../../html/lib/model/employee.class.php");

if(isset($_POST['aid'])) {
	
	$query="SELECT * FROM `consent_branch_has_consent` 
			INNER JOIN `consent_setup` ON `consent_setup`.`consent_id` = `consent_branch_has_consent`.`consent_id_FK` 
			WHERE branch_id_FK = '".$_POST['aid']."'";

	$db=new Database();
	$db->query($query);
	$templates=$db->resultset();
	echo json_encode($templates);
}

?>


