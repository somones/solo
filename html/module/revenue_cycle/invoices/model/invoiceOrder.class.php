<?php
require_once("../model/invoice.class.php");
require_once("../model/service.class.php");
require_once("../model/discount_plan.class.php");
require_once("../../billing_settings/model/billing_items.class.php");

class invoiceOrder
{
	public $table_name="rc_invoice_order";
	public $order_id;
	public $order_auto_gen;
	public $service_id_FK;
	public $invoice_id_FK;
	public $order_rate_plan_id_FK;
	public $order_rate;
	public $tax_rate_id_FK;
	public $tax_amount;
	public $order_discount_plan_id_FK;
	public $discount_amount;
	public $order_created_by;
	public $order_date_created;
	public $order_timestamp;
	public $order_userstamp;
	public $order_deleted;
	
	function __construct($order_id=NULL)
	{
		if(isset($order_id))
		{
			$this->order_id=$order_id;
			$this->build_object();
		}
	}
	
	
	function build_object()
	{
		
		$db		=new Database();
		$query	="SELECT * FROM `rc_invoice_order` WHERE `order_id`='".$this->order_id."'";
		$db->query($query);
		$result			=$db->resultset();
		$prop			=$result[0];
		
		foreach ($prop as $key => $value) 
			$this->$key=$value;				
	}

	
	function load_active_invoice_orders($invoice_id)
	{
		$db=new Database();
		$query="SELECT * FROM `rc_invoice_order`
        INNER JOIN `rc_billing_item` on `item_id`=`service_id_FK`
        WHERE `order_deleted`='0' AND `invoice_id_FK`='".$invoice_id."' ORDER BY `order_date_created` ASC";
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}
    
    function add_new_order($invoice_id,$service_id,$user)
    {
        $invoiceObj= new invoice($invoice_id);
        $serviceObj= new billing_item($service_id); 

        $service_price  = $serviceObj->get_billing_item_price($service_id,$invoiceObj->rate_plan_id_FK);
        $discountplanObj=new discount_plan($invoiceObj->discount_plan_id_FK);
        $service_price  = $serviceObj->get_billing_item_price($service_id,$invoiceObj->rate_plan_id_FK);
        $discountplanObj=new discount_plan($invoiceObj->discount_plan_id_FK);
       
        $service_rate=$service_price[0]["billing_item_price"];
        if($discountplanObj->discount_type==1)
            $discount_amount=($service_rate*$discountplanObj->discount_value)/100;
        else
            $discount_amount=$discountplanObj->discount_value; 
        
        $final_rate=$service_rate-$discount_amount;
        $tax_amount=($service_price[0]["tax_value"]*$final_rate)/100;
        $query="INSERT INTO `rc_invoice_order` 
        (`service_id_FK`,`invoice_id_FK`,`order_rate_plan_id_FK`,`order_rate`,`tax_rate_id_FK`,`tax_amount`,`order_discount_plan_id_FK`,`discount_amount`,`order_created_by`,`order_date_created`,`order_userstamp`)
        
        VALUES('".$service_id."','".$invoice_id."','".$invoiceObj->rate_plan_id_FK."','".$service_rate."','".$service_price[0]['tax_profile_id_FK']."','".$tax_amount."','".$invoiceObj->discount_plan_id_FK."','".$discount_amount."','".$user."','".date("Y-m-d G:i:s")."','".$user."')";
        
        $db=new Database();
        $db->query($query);
        $db->execute();
		
		
		$inserted_id=$db->lastInsertId();
		$order_auto_number="0000".$inserted_id;
		$length=strlen($order_auto_number);
		
		if($length>5)
		{
			$to_remove=$length-5;
			$order_auto_number=substr($order_auto_number,$to_remove);
		}
		$query="UPDATE `rc_invoice_order` SET `order_auto_gen` = 'or".$order_auto_number."' WHERE `order_id`='".$inserted_id."'";
		$db->query($query);
		$db->execute();	
		
		$invoiceOb= new invoice($invoice_id);
		$invoiceObj->update_invoice_amount($this->load_total_orders_amount($invoice_id),$user);
		
		$invoiceObj->tune_paid_flag($invoice_id);
		return $inserted_id;
    }
	
	function load_total_orders_amount($invoice_id)
	{
		$av_invoice_orders=$this->load_active_invoice_orders($invoice_id);
		        $total_rate     =0;
                $total_discount =0;
                $total_tax      =0;
                $total_gross    =0;
                for($i=0;$i<count($av_invoice_orders);$i++)
                {
                    $final_price=$av_invoice_orders[$i]["order_rate"]-$av_invoice_orders[$i]["discount_amount"]+ $av_invoice_orders[$i]["tax_amount"];
                    $total_rate+=$av_invoice_orders[$i]["order_rate"];
                    $total_discount+=$av_invoice_orders[$i]["discount_amount"];
                    $total_tax+=$av_invoice_orders[$i]["tax_amount"];
                    $total_gross+=$final_price;
				}
		return $total_gross;		
		
	}
	
	function update_rates($rate,$discount,$user_id)
	{
		$db=new Database();
		$query="update `rc_invoice_order` SET `order_rate`='".$rate."',`discount_amount`='".$discount."',`order_userstamp`='".$user_id."' WHERE `order_id`='".$this->order_id."'";
		$db->query($query);
		$db->execute();
		$this->evaluate_order_rates($user_id);
	}
	
	
	function update_rates_only($rate_id,$rate,$user_id)
	{
		$db=new Database();
		$query="update `rc_invoice_order` SET `order_rate_plan_id_FK`='".$rate_id."',`order_rate`='".$rate."',`order_userstamp`='".$user_id."' WHERE `order_id`='".$this->order_id."'";
		$db->query($query);
		$db->execute();
		$this->evaluate_order_rates($user_id);
	}
	
	function update_discount_only($new_discount_id,$discount_amount,$user_id)
	{
		$db=new Database();
		$query="update `rc_invoice_order` SET `order_discount_plan_id_FK`='".$new_discount_id."',`discount_amount`='".$discount_amount."',`order_userstamp`='".$user_id."' WHERE `order_id`='".$this->order_id."'";
		$db->query($query);
		$db->execute();
		$this->evaluate_order_rates($user_id);		
	}
	
	function evaluate_order_rates($user_id)
	{
		$updatedOrder=new invoiceorder($this->order_id);
		$query="SELECT * FROM `rc_tax_rate` WHERE `tax_id`='".$updatedOrder->tax_rate_id_FK."'";
		$db=new Database();
		$db->query($query);
		$result=$db->single();
		$tax_rate=$result["tax_rate"];
		$price=($updatedOrder->order_rate)-($updatedOrder->discount_amount);
		$tax_amount=($price*$tax_rate)/100;
		$query="UPDATE `rc_invoice_order` SET `tax_amount`='".$tax_amount."'  WHERE `order_id`='".$this->order_id."'";
		$db->query($query);
		$db->execute();
		$invoiceObj=new invoice($this->invoice_id_FK);
		$invoiceObj->evaluate_invoice($user_id);
		$invoiceObj->tune_paid_flag($this->invoice_id_FK);
	}
	
}


?>