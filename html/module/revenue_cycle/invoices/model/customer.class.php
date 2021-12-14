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
	
	function load_av_customer()
	{
		$db=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE `customer_deleted`='0' ORDER BY `date_added` DESC , `customer_display_name` ASC";
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}


	function get_av_customer_search($search_token){
		$query="SELECT * FROM rc_customer
		WHERE ( customer_id LIKE '%".$search_token."%' OR customer_name LIKE '%".$search_token."%' ) ";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		echo json_encode($result);
	}
}

?>