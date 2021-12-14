<?php
require_once("../model/invoiceOrder.class.php");
class invoice
{
	public $table_name="rc_invoice";
	public $invoice_id;
	public $invoice_number;
	public $branch_id_FK;
	public $customer_id_FK;
	public $rate_plan_id_FK;
	public $discount_plan_id_FK;
	public $invoice_total_amount;
	public $invoice_amount_paid;
	public $invoice_paid;
	public $invoice_note;
	public $invoice_date_created;
	public $invoice_user_created;
	public $invoice_time_stamp;
	public $invoice_user_stamp;
	public $invoice_deleted;
	
	function __construct($invoice_id=NULL)
	{
		if(isset($invoice_id))
		{
			$this->invoice_id=$invoice_id;
			$this->build_object();
		}
	}
	
	
	function build_object()
	{
		
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `invoice_id`='".$this->invoice_id."'";
		$db->query($query);
		$result			=$db->resultset();
		$prop			=$result[0];
		foreach ($prop as $key => $value) 
			$this->$key=$value;				
	}
	
	function create_new_invoice($customer_id,$rate_plan,$discount_plan,$user_id)
	{
		$db=new Database();
		$query="INSERT INTO `".$this->table_name."` 
		(
			`branch_id_FK`,
			`customer_id_FK`,
			`rate_plan_id_FK`,
			`discount_plan_id_FK`,
			`invoice_note`,
			`invoice_date_created`,
			`invoice_user_created`,
			`invoice_user_stamp`,
			`invoice_deleted`
		)
		
		VALUES
		(
			'1',
			'".$customer_id."',
			'".$rate_plan."',
			'".$discount_plan."',
			'',
			'".date("Y-m-d G:i:s")."',
			'".$user_id."',
			'".$user_id."',
			'0'
		) ";
		
		$db->query($query);
		$db->execute();
		$inserted_id=$db->lastInsertId();
		$invoice_auto_number="0000".$inserted_id;
		$length=strlen($invoice_auto_number);
		
		if($length>5)
		{
			$to_remove=$length-5;
			$invoice_auto_number=substr($invoice_auto_number,$to_remove);
		}
		$query="UPDATE `".$this->table_name."` SET `invoice_number` = 'INV".$invoice_auto_number."' WHERE `invoice_id`='".$inserted_id."'";
		$db->query($query);
		$db->execute();		
		return $inserted_id;
	}
	
	function update_invoice_rates($invoice_id,$new_rate_id,$user_id)
	{
		$db=new Database();
		$orderObj=new invoiceOrder();
		$invoice_orders=$orderObj->load_active_invoice_orders($invoice_id);
		$query="UPDATE `".$this->table_name."` SET `rate_plan_id_FK`='".$new_rate_id."' WHERE `invoice_id`='".$invoice_id."'";
		$db->query($query);
		$db->execute();
		for($i=0;$i<count($invoice_orders);$i++)
		{
			$orderObj		=new invoiceOrder($invoice_orders[$i]["order_id"]);
			$serviceObj		=new billing_item($orderObj->service_id_FK);
			$service_price	=$serviceObj->get_billing_item_price($orderObj->service_id_FK,$new_rate_id);
			$orderObj->update_rates_only($new_rate_id,$service_price[0]["billing_item_price"],$user_id);
		}
	}
	
	function updat_discount_rates($new_discount_id,$user_id)
	{
		$db=new Database();
		$discountplanObj	=new discount_plan($new_discount_id);
		//print_r($discountplanObj);

		$orderObj=new invoiceOrder();
		$invoice_orders=$orderObj->load_active_invoice_orders($this->invoice_id);
		$query="UPDATE `".$this->table_name."` SET `discount_plan_id_FK`='".$new_discount_id."' WHERE `invoice_id`='".$this->invoice_id."'";
		$db->query($query);
		$db->execute();

		for($i=0;$i<count($invoice_orders);$i++)
		{	
			//$discount_amount = "";
			//echo "this".$i." and ".$discountplanObj->discount_type;
			$orderObj		=new invoiceOrder($invoice_orders[$i]["order_id"]);
			$order_rate		=$orderObj->order_rate;
			if($discountplanObj->discount_type==1)
				$discount_amount=($discountplanObj->discount_value*$order_rate)/100;
			if($discountplanObj->discount_type==2)
				$discount_amount=$discountplanObj->discount_value;
			//else $discount_amount = 23;
			$orderObj->update_discount_only($new_discount_id,$discount_amount,$user_id);
		}
	}
	
	function load_active_invoices()
	{
		$db=new Database();
		$query="SELECT * FROM `rc_invoice` 
		INNER JOIN `rc_customer` ON `rc_customer`.`customer_id`=`rc_invoice`.`customer_id_FK`
		INNER JOIN `rc_price_rate_sheet` ON `rc_price_rate_sheet`.`rate_sheet_id`=`rc_invoice`.`rate_plan_id_FK`
		WHERE `invoice_deleted`='0' ORDER BY `invoice_date_created` DESC";
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function load_active_invoices_list()
	{
		$db=new Database();
		$query="SELECT * FROM `rc_invoice` ORDER BY `invoice_date_created` DESC";
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
	
	
	function record_payment($payment_type,$payment_amount,$payment_mode,$reference,$payment_notes,$user_id)
	{
		//print_r($_POST);
		if($payment_type==2)
			$payment_amount=$payment_amount*(-1);
		$paymentObj = new payment();
		$payment_id=$paymentObj->insert_new_payment($this->invoice_id,$payment_amount,$payment_mode,$reference,$payment_notes,$user_id);
		$paymentObj=new payment($payment_id);
		$amount_paid=$this->invoice_amount_paid+$paymentObj->payment_amount;
		$query="UPDATE `".$this->table_name."` SET `invoice_amount_paid`='".$amount_paid."', `invoice_user_stamp`='".$user_id."' WHERE `invoice_id`='".$this->invoice_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$this->tune_paid_flag($this->invoice_id);
		return $payment_id;
	}
	
	function update_invoice_amount($amount,$user_id)
	{
		$db=new Database();
		$query="UPDATE `".$this->table_name."` SET `invoice_total_amount`='".$amount."',`invoice_user_stamp`='".$user_id."' WHERE `invoice_id`='".$this->invoice_id."'";
		$db->query($query);
		$db->execute($query);
	}
	
	function submit_save_invoice_comment($comment)
	{
		$db=new Database();
		$query="UPDATE `".$this->table_name."` SET `invoice_note`='".urlencode($comment)."' WHERE `invoice_id`='".$this->invoice_id."'";
		$db->query($query);
		$db->execute();
	}
	
	function evaluate_invoice($user_id)
	{
		$orderObj=new invoiceorder();
		$invoice_amount=$orderObj->load_total_orders_amount($this->invoice_id);
		$this->update_invoice_amount($invoice_amount,$user_id);
	}
	
	function tune_paid_flag($invoice_id)
	{
		$invoiceObj 	=new invoice($invoice_id);
		
		$db=new Database();
		$amount_paid	=$invoiceObj->invoice_amount_paid;
		$invoice_total	=$invoiceObj->invoice_total_amount;
		$amount_due		=$invoice_total-$amount_paid;

		if($amount_due==0)
			$query="UPDATE `".$invoiceObj->table_name."` SET `invoice_paid`='1' WHERE `invoice_id`='".$invoiceObj->invoice_id."'";
		else
			$query="UPDATE `".$invoiceObj->table_name."` SET `invoice_paid`='0' WHERE `invoice_id`='".$invoiceObj->invoice_id."'";
		$db->query($query);
		$db->execute();
	}

	function delete_invoice(){
		$query= "UPDATE `".$this->table_name."` SET 
		`invoice_deleted` = '1'
		WHERE `invoice_id`='".$this->invoice_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function get_invoice_search($search_token){
		$query="SELECT * FROM rc_invoice
		WHERE ( invoice_id LIKE '%".$search_token."%' OR invoice_number LIKE '%".$search_token."%' ) ";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		echo json_encode($result);
	}

	function get_invoice_search_json($search_token,$costumer_id,$rate_plan,$paid_status,$date_start) {

	    $query = "SELECT * FROM rc_invoice
	    INNER JOIN `rc_customer` ON `rc_customer`.`customer_id`=`rc_invoice`.`customer_id_FK`
		INNER JOIN `rc_price_rate_sheet` ON `rc_price_rate_sheet`.`rate_sheet_id`=`rc_invoice`.`rate_plan_id_FK` ";
	    
	    $conditions = array();

	    if(! empty($search_token)) {
	      $conditions[] = "(invoice_id LIKE '%".$search_token."%' OR invoice_number LIKE '%".$search_token."%')";
	    }
	    if(! empty($costumer_id)) {
	      $conditions[] = "customer_id_FK='$costumer_id'";
	    }
	    if(! empty($rate_plan)) {
	      $conditions[] = "rate_plan_id_FK='$rate_plan'";
	    }
	    if(! empty($paid_status)) {
	      $conditions[] = "invoice_paid='$paid_status'";
	    }
	    if(! empty($date_start)) {
	      $conditions[] = "invoice_date_created LIKE '%".$date_start."%' ";
	    }

	    $sql = $query;
	    if (count($conditions) > 0) {
	      $sql .= " WHERE " . implode(' AND ', $conditions);
	    }
		
		$db=new Database();
		$db->query($sql);
		$result=$db->resultset();
		return $result;
	}
}


?>