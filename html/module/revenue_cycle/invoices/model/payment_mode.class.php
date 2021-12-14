<?php

class paymentMode
{
	public $table_name="rc_payment_mode";
	public $payment_mode_id;
	public $payment_mode_name;
	public $reference_number_required;
	public $apply_on_refund;
	
	function __construct($mode_id=NULL)
	{
		if(isset($mode_id))
		{
			$this->mode_id=$mode_id;
			$this->build_object();
		}
	}
	
	
	function build_object()
	{
		
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `mode_id`='".$this->mode_id."'";
		$db->query($query);
		$result			=$db->resultset();
		$prop			=$result[0];
		
		foreach ($prop as $key => $value) 
			$this->$key=$value;				
	}
	
	function load_payment_modes()
	{
		$db=new Database();
		$query="SELECT * FROM `".$this->table_name."`ORDER BY `payment_mode_name` ASC";
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
	
}


?>