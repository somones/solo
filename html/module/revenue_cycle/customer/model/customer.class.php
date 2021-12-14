<?php

class customer
{
	public $table_name="rc_customer";
	public $customer_id;
	public $customer_name;
	public $customer_display_name;
	public $customer_email;
	public $customer_mobile_number;	
	public $customer_active;
	public $customer_deleted;
	public $branch_id;
	public $date_added;		
	public $user_added;	
	public $time_stamp;
	public $user_stamp;
	
	function __Construct($customer_id=NULL)
	{
	if(isset($customer_id))
		{
			$this->customer_id=$customer_id;
			$this->build_object();
		}
	}

	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `customer_id`=:customer_id ";
		$db->query($query);
		$db->bind("customer_id",$this->customer_id);
		$result			=$db->resultset();
		if(count($result)>0)
		{
			$prop			=$result[0];
			foreach ($prop as $key => $value) 
				$this->$key=$value;				
		}
	}

	function list_of_customer($user_session=NULL)
	{
		$query="SELECT * FROM `rc_customer` WHERE customer_active = 1";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function list_of_deleted_customer($user_session=NULL)
	{
		$query="SELECT * FROM `rc_customer` WHERE customer_active = 0";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function insert_new_customer($user_id) {
		
		$query="INSERT INTO `".$this->table_name."` 
		(
			`customer_name`,
			`customer_display_name`,
			`customer_email`,
			`customer_mobile_number`,
			`customer_active`,
			`customer_deleted`,
			`branch_id_FK`,
			`date_added`,
			`user_added`,
			`time_stamp`,
			`user_stamp`
		)

		VALUES(
			'".$this->customer_name."',
			'".$this->customer_display_name."',
			'".$this->customer_email."',
			'".$this->customer_mobile_number."',
			'1',
			'0',
			'".$this->branch_id_FK."',
			'".Date("Y-m-d H:i:s")."',
			'".$user_id."',
			'".Date("Y-m-d H:i:s")."',
			'".$user_id."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$customer_id=$db->lastInsertId();
		return $customer_id;
	}

	function update_the_customer($customer_id) {
		//print_r($_POST);
		
		$query= "UPDATE `rc_customer` SET 
		
		`customer_name` = '".$this->customer_name."', 
		`customer_display_name` = '".$this->customer_display_name."',
		`customer_email` = '".$this->customer_email."',
		`customer_mobile_number` = '".$this->customer_mobile_number."',
		`branch_id_FK` = '".$this->branch_id_FK."'
		
		WHERE `customer_id`='".$customer_id."' ";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_customer($customer_id)
	{
		$query= "UPDATE `rc_customer` SET 
		`customer_deleted` = '1',
		`customer_active` = '0'
		WHERE `customer_id`='".$customer_id."' ";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function reactive_customer($customer_id)
	{
		$query= "UPDATE `rc_customer` SET 
		`customer_deleted` = '0',
		`customer_active` = '1'
		WHERE `customer_id`='".$customer_id."' ";

		$db=new Database();
		$db->query($query);
		$db->execute();
	}
}
?>

