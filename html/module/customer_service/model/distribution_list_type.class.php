<?php

class distribution_list_type
{
	public $table_name="setup_distribution_list_type";
	public $list_type_id;
	public $list_type_name;
	public $list_type_description;
	
	function __Construct($list_type_id=NULL)
	{
		if(isset($list_type_id))
		{
			$this->list_type_id=$list_type_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `list_type_id`=:list_type_id";
		$db->query($query);
		$db->bind("list_type_id",$this->list_type_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_distribution_list_type($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."`";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function type_per_list($list_type_id)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE list_type_id = '".$list_type_id."'";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_distribution_list_type($user_id) {
		$query="INSERT INTO `".$this->table_name."` 
		(
			`list_type_name`,
			`list_type_description`
		)

		VALUES(
			'".$this->list_type_name."',
			'".$this->list_type_description."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_distribution_list_type($type_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		
		`list_type_name` = '".$this->list_type_name."', 
		`list_type_description` = '".$this->list_type_description."'
		
		WHERE `list_type_id`='".$type_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_distribution_list_type($type_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `list_type_id`='".$type_id."'";
		$db->query($query);
		$db->execute();
	}

	function insert_new_email_category_item ($list_type_name,$type_id) {
		$type_name = "Send Email To ".$list_type_name;
		$append_param = "&type_id=".$type_id."&message_type=".$message_type;
		$query="INSERT INTO `template_menu_item` 
		(
			`category_id_FK`,
			`item_title`,
			`page_path`,
			`append_param`
		)
		VALUES(
			'17',
			'".$type_name."',
			'html/module/customer_service/view/send_email_sms_main_form.php',
			'".$append_param."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$menu_item_id=$db->lastInsertId();
		return $menu_item_id;
	}

	function insert_new_sms_category_item ($list_type_name,$type_id) {
		$type_name = "Send SMS To ".$list_type_name;
		$append_param = "&type_id=".$type_id."&message_type=".$message_type;
		$query="INSERT INTO `template_menu_item` 
		(
			`category_id_FK`,
			`item_title`,
			`page_path`,
			`append_param`
		)
		VALUES(
			'18',
			'".$type_name."',
			'html/module/customer_service/view/send_email_sms_main_form.php',
			'".$append_param."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$menu_item_id=$db->lastInsertId();
		return $menu_item_id;
	}

}
?>