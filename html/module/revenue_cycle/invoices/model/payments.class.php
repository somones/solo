<?php

class payment
{
	public $table_name="rc_payments_received";
	public $payment_id;
	public $reciept_number;
	public $invoice_id_FK;
	public $payment_amount;
	public $payment_reference_number;
	public $payment_mode_id_FK;
	public $payment_notes;
	public $payment_date_created;
	public $payment_user_created;
	public $payment_time_stamp;
	public $payment_user_stamp;
	public $payment_deleted;
	
	function __construct($payment_id=NULL)
	{
		if(isset($payment_id))
		{
			$this->payment_id=$payment_id;
			$this->build_object();
		}
	}
	
	
	function build_object()
	{
		
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `payment_id`='".$this->payment_id."'";
		$db->query($query);
		$result			=$db->resultset();
		$prop			=$result[0];
		
		foreach ($prop as $key => $value) 
			$this->$key=$value;				
	}
	
	
	function load_invoice_payments($invoice_id)
	{
		$db=new Database();
		$query="SELECT * FROM `rc_payments_received` 
		INNER JOIN `rc_payment_mode` ON `rc_payment_mode`.`payment_mode_id` = `payment_mode_id_FK`
		WHERE `payment_deleted`='0' AND `invoice_id_FK`='".$invoice_id."' ORDER BY `payment_date_created` ASC";
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
	
	function insert_new_payment($invoice_id,$payment_amount,$payment_mode,$reference,$payment_notes,$user_id)
	{
		$db	=new Database();
		$query="INSERT INTO `".$this->table_name."` (`invoice_id_FK`,`payment_amount`,`payment_reference_number`,`payment_mode_id_FK`,
		`payment_notes`,`payment_date_created`,`payment_user_created`,`payment_user_stamp`) 
		VALUES('".$invoice_id."','".$payment_amount."','".$reference."','".$payment_mode."','".urlencode($payment_notes)."','".date("Y-m-d G:i:s")."',
		'".$user_id."','".$user_id."')
		";
		$db->query($query);
		$db->execute();
		$inserted_id=$db->lastInsertId();
		
		$payment_auto_number="0000".$inserted_id;
		$length=strlen($payment_auto_number);
		
		if($length>5)
		{
			$to_remove=$length-5;
			$payment_auto_number=substr($payment_auto_number,$to_remove);
		}
		$query="UPDATE `".$this->table_name."` SET `reciept_number` = 'rc".$payment_auto_number."' WHERE `payment_id`='".$inserted_id."'";
		$db->query($query);
		$db->execute();	
		
		$invoiceObj=new invoice($invoice_id);
		$invoiceObj->tune_paid_flag($invoice_id);
		
		return $inserted_id;
		
		
	}
	
}


?>