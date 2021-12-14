<?php

class billing_item
{
	public $table_name="rc_billing_item";
	public $item_id;
	public $item_category_id_FK;
	public $item_description;
	public $item_code_id_FK;
	public $item_code_value;
	public $tax_profile_id_FK;
	public $tax_value;
	public $item_active;
	
	function __Construct($item_id=NULL)
	{
		if(isset($item_id))
		{
			$this->item_id=$item_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `item_id`=:item_id";
		$db->query($query);
		$db->bind("item_id",$this->item_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_billing_item($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."`";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_billing_item($user_id) {
		$query="INSERT INTO `".$this->table_name."` 
		(
			`item_category_id_FK`,
			`item_description`,
			`item_code_id_FK`,
			`item_code_value`,
			`tax_profile_id_FK`,
			`tax_value`,
			`item_active`
		)

		VALUES(
			'".$this->item_category_id_FK."',
			'".$this->item_description."',
			'".$this->item_code_id_FK."',
			'".$this->item_code_value."',
			'".$this->tax_profile_id_FK."',
			'".$this->tax_value."',
			'1'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_the_billing_item($billing_item_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		
		`item_category_id_FK` = '".$this->item_category_id_FK."', 
		`item_description` = '".$this->item_description."',
		`item_code_id_FK` = '".$this->item_code_id_FK."',
		`item_code_value` = '".$this->item_code_value."',
		`tax_profile_id_FK` = '".$this->tax_profile_id_FK."',
		`tax_value` = '".$this->tax_value."'
		
		WHERE `item_id`='".$billing_item_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_billing_item($service_id,$billing_item_id)
	{
		$db=new Database();
		$query="DELETE FROM `rc_billing_item` WHERE `item_id`='".$billing_item_id."'";
		$db->query($query);
		$db->execute();
	}

	function get_billing_item_price($service_id,$rate_sheet)
	{
		/*$db=new Database();
		$query="SELECT * FROM `rc_billing_item_has_price` 
		INNER JOIN `rc_tax_rate` ON `rc_tax_rate`.`tax_id`=`rc_billing_item_has_price`.`tax_id_FK`
		WHERE `rc_billing_item_has_price`.`billing_item_id_FK`='".$service_id."' 
		AND `rc_billing_item_has_price`.`rate_sheet_id_FK`='".$rate_sheet."' ";
		$db->query($query);
		$result=$db->resultset();
		return $result;*/
		//echo "=> ".$service_id." && ".$rate_sheet;
		$db=new Database();
		$query="SELECT * FROM `rc_billing_item_has_price` 
		INNER JOIN `rc_billing_item` ON `item_id` = `billing_item_id_FK`
		WHERE `billing_item_id_FK`='".$service_id."' AND `rate_sheet_id_FK`='".$rate_sheet."' ";
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
}
?>