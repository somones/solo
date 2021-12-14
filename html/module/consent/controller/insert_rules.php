<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	set_time_limit(2);
	date_default_timezone_set('Asia/Dubai');
	require_once("../../../../html/lib/model/database.class.php");
	require_once("../../../../html/lib/model/item_category.class.php");
	require_once("../../../../html/lib/model/company.class.php");
	require_once("../../../../html/lib/model/branch.class.php");
	require_once("../../../../html/lib/model/employee.class.php");
	require_once("../../../../html/lib/model/module.class.php");
	require_once("../../../../html/lib/model/menu_item.class.php");
	require_once("../../../../html/lib/model/department.class.php");

 	for($i = 0; $i < 2; $i++)
 	{  
  		$query="INSERT INTO `consent_requested_signatures` 
		(
			consent_id_FK,
			object_type_FK,
			signature_x_position,
			signature_y_position,
			signature_width,
			signature_page
		)

		VALUES(
			1,
			1,
			1,
			1,
			1,
			1
		)";
  		$statement = $connect->prepare($query);
 	 	$statement->execute();
 	}



	
 ?>