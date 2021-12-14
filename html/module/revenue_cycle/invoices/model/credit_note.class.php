<?php

class credit_note
{
	public $table_name="rc_credit_note";
	public $credit_note_id;
	public $credit_note_number;
	public $invoice_id_FK;
	public $credit_amount;
	public $credit_vat;
	public $credit_gross_amount;
	public $credit_user_stamp;
	public $credit_time_stamp;
	public $credit_date_created;
	public $credit_user_created;
	public $credit_deleted;
	public $amount_paid;
	public $payment_id_FK;
	public $amount_remaining;
	
	function __construct($credit_note_id=NULL)
	{
		if(isset($credit_note_id))
		{
			$this->credit_note_id=$credit_note_id;
			$this->build_object();
		}
	}
	
	
	function build_object()
	{
		
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `credit_note_id`='".$this->credit_note_id."'";
		$db->query($query);
		$result			=$db->resultset();
		$prop			=$result[0];
		
		foreach ($prop as $key => $value) 
			$this->$key=$value;				
	}
	
	function get_invoice_credit_notes($invoice_id)
	{
		$db=new Database();
		$query="SELECT * FROM `rc_credit_note` WHERE `invoice_id_FK`='".$invoice_id."' AND `credit_deleted`='0'";
		$db->query($query);
		$resultset=$db->resultset();
		return $resultset;
	}
	
	function get_total_invoice_credit_notes($invoice_id)
	{
		$db=new Database();
		$query="SELECT SUM(`credit_gross_amount`) as `credit_gross_amount`  FROM `rc_credit_note` 
		WHERE `invoice_id_FK`='".$invoice_id."' AND `credit_deleted`='0'";
		$db->query($query);
		$result=$db->resultset();
		return ($result[0]["credit_gross_amount"]);		
	}
	
	function get_total_credit_notes($order_id)
	{
		$db=new Database();
		$query="SELECT SUM(`credit_order_amount`) as `sum_credit_amount` , SUM(`credit_order_vat`) as `sum_credit_vat` FROM `rc_credit_note_details` 
		WHERE `order_id_FK`='".$order_id."'";
		$db->query($query);
		$result=$db->resultset();
		return ($result[0]["sum_credit_amount"]+$result[0]["sum_credit_vat"]);
	}
	
	function insert_new_credit_note($invoice_id,$credit_note_rate,$credit_note_vat,$gross_amount,$user_id,$credit_amount)
	{
		//print_r($_POST);
		$db=new Database();
		$query="INSERT INTO `rc_credit_note`
		(`invoice_id_FK`,`credit_amount`,`credit_vat`,`credit_gross_amount`,`credit_user_stamp`,`credit_date_created`,`credit_user_created`)
		VALUES('".$invoice_id."','".$credit_amount."','".$credit_note_vat."','".$gross_amount."','".$user_id."','".date("Y-m-d G:i:s")."','".$user_id."')";
		//echo $query;
		$db->query($query);
		$db->execute();
		$inserted_id=$db->lastInsertId();
		return $inserted_id;
	}
	
	function insert_credit_note_detail($order_id,$credit_order_amount,$credit_order_vat)
	{
		$query="INSERT INTO `rc_credit_note_details` (`credit_note_id_FK`,`order_id_FK`,`credit_order_amount`,`credit_order_vat`)
VALUES('".$this->credit_note_id."','".$order_id."','".$credit_order_amount."','".$credit_order_vat."')";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}
	
	function get_credit_details()
	{
		$query="SELECT * FROM `rc_credit_note_details` 
		INNER JOIN `rc_invoice_order` ON `rc_invoice_order`.`order_id`=`rc_credit_note_details`.`order_id_FK`
		INNER JOIN `rc_billing_item` ON `rc_billing_item`.`item_id`=`rc_invoice_order`.`service_id_FK`
		WHERE `credit_note_id_FK`='".$this->credit_note_id."'";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
	
}