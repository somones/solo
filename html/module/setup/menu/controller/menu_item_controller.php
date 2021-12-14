<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");
require_once("../model/menu_items.class.php");

//print_r($_POST);
if($_POST['action']==1) 
{
	if($_POST['item_id']==-1)
	{
		$category_id_FK 	 			=trim($_POST["category_id_FK"]);
		$item_title 	 				=trim($_POST["item_title"]);
		$page_path 	 					=trim($_POST["page_path"]);
		$menu_itemsObj					=new menu_items();

		$val=new Validation();
		$val->setRules("category_id_FK","Menu Item Category is a required Field.",array("required"));
		$val->setRules("item_title","Menu Item Name is a required Field.",array("required"));
		$val->setRules("page_path","Menu Item Page is a required Field.",array("required"));
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$menu_itemsObj->category_id_FK        		=$category_id_FK;
			$menu_itemsObj->item_title             		=$item_title;
			$menu_itemsObj->page_path             		=$page_path;
			$item_id	                     			=$menu_itemsObj->insert_new_menu_item($_SESSION['employee_id']);
			$result["success"]		=1;
			$result["return_value"]	=$item_id;
			$result["return_html"]	=$val->draw_success_chart("Added Successfully",1);
		}
	}
 
	else
	{
		$category_id_FK 	 				=trim($_POST["category_id_FK"]);
		$item_title 	 					=trim($_POST["item_title"]);
		$page_path 	 						=trim($_POST["page_path"]);
		$menu_itemsObj						=new menu_items();

		$val=new Validation();
		$val->setRules("category_id_FK","Menu Item Category is a required Field.",array("required"));
		$val->setRules("item_title","Menu Item Name is a required Field.",array("required"));
		$val->setRules("page_path","Menu Item Page is a required Field.",array("required"));
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$menu_itemsObj->category_id_FK        	=$category_id_FK;
			$menu_itemsObj->item_title         		=$item_title;
			$menu_itemsObj->page_path        		=$page_path;
			$menu_itemsObj->update_menu_item($_POST['item_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['item_id'];
			$result["return_html"]	=$val->draw_success_chart("Updated Successfully",1);
		}		
		
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$menu_itemsObj			=new menu_items();
	$menu_itemsObj->delete_menu_item($_POST['item_id']);
}

?>