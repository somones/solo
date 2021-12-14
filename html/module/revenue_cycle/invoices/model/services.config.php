<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
/*
require_once("../model/service.class.php");
$serviceObj			=new service();
$av_services		=$serviceObj->get_active_services();

for($i=0;$i<count($av_services);$i++)
{
	$array[$i]["value"]=$av_services[$i]["service_code"]."  ".$av_services[$i]["service_name"];
	$array[$i]["data"]=$av_services[$i]["service_id"];
}
echo json_encode($array);
*/


require_once("../model/service.class.php");
$serviceObj			=new service();
$av_services		=$serviceObj->list_of_billing_item();

for($i=0;$i<count($av_services);$i++)
{
	$array[$i]["value"]=$av_services[$i]["item_code_value"]."  ".$av_services[$i]["item_description"];
	$array[$i]["data"]=$av_services[$i]["item_id"];
}
echo json_encode($array);

?>