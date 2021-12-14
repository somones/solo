<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/validation.class.php");

require_once("../model/invoice.class.php");
require_once("../model/credit_note.class.php");
require_once("../model/invoiceOrder.class.php");
require_once("../model/payments.class.php");
require_once("../model/customer.class.php");

if($_POST['action']==1) 
{
	if($_POST['invoice_id']==-1)
	{
		$customer_id 	 			=trim($_POST["customer_id"]);
		$rate_sheet 	 			=trim($_POST["rate_sheet"]);
		$discount_plan	 			=trim($_POST["discount_plan"]);
		$invoiceObj					=new invoice();

		$val=new Validation();
		$val->setRules("customer_id","The Code Type is a required Field.",array("required"));
		$val->setRules("rate_sheet","Code Value is a required Field.",array("required"));	
		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$invoiceObj->customer_id        		=$customer_id;
			$invoiceObj->rate_sheet             	=$rate_sheet;
			$invoiceObj->discount_plan 				=$discount_plan;
			$invoice_id	                     		=$invoiceObj->create_new_invoice($_POST['customer_id'],$_POST['rate_sheet'],$_POST['discount_plan'],$_SESSION['employee_id']);
			
			$result["success"]		=1;
			$result["return_value"]	=$invoice_id;
			$result["return_html"]	=$val->draw_success_chart("added Successfully",1);
		}
	}
 
	else
	{
		$customer_id 	 			=	trim($_POST["customer_id"]);
		$rate_sheet 	 			=	trim($_POST["rate_sheet"]);
		$discount_plan	 			=	trim($_POST["discount_plan"]);
		$invoiceObj					=	new invoice($_POST["invoice_id"]);

		$val=new Validation();
		$val->setRules("customer_id","The Code Type is a required Field.",array("required"));
		$val->setRules("rate_sheet","Code Value is a required Field.",array("required"));	
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$invoiceObj->customer_id        		=$customer_id;
			$invoiceObj->rate_sheet             	=$rate_sheet;
			$invoiceObj->discount_plan 				=$discount_plan;

			if($_POST['rate_sheet'] <> $invoiceObj->rate_plan_id_FK)
				$invoiceObj->update_invoice_rates($_POST['invoice_id'],$_POST['rate_sheet'],$_SESSION['employee_id']);
			if($_POST['discount_plan'] <> $invoiceObj->discount_plan_id_FK)
				$invoiceObj->updat_discount_rates($_POST['discount_plan'],$_SESSION['employee_id']);

			$result["success"]		=1;
			$result["return_value"]	=$_POST['invoice_id'];
			$result["return_html"]	=$val->draw_success_chart("Updated",1);
		}		
		
	}
	echo json_encode($result);

} elseif ($_POST['action']==2) {
	$val=new Validation();
	
	$invoiceObj			=new invoice($_POST['invoice_id']);
	$invoiceObj->submit_save_invoice_comment($_POST['comment']);

	
	$result["success"]		=1;
	$result["return_value"]	=$_POST['invoice_id'];
	$result["return_html"]	=$val->draw_success_chart("Updated",1);

} elseif ($_POST['action']==3) {

	$orderObj           	=new invoiceOrder();
	if($_POST['order_id']	==-1)
    $orderObj->add_new_order($_POST['invoice_id'],$_POST['service_id'],$_SESSION['employee_id']);

} elseif ($_POST['action']==4) {
	$val=new validation();
	$creditnoteObj=new credit_note();// create new credit note 
	$invoiceObj	=new invoice($_POST['invoice_id']); // Get invoice and all data 
	$av_orders	=explode(",",$_POST['index']); // explode the index 
	$av_values	=explode("***",$_POST["concat"]); //  Get the credit amounth from the previous form
	$error=0;
	$error_array=array();
	for($i=0;$i<count($av_orders);$i++)
	{
		if(!is_numeric(trim($av_values[$i])))
		{
			$error++;
			array_push($error_array,"credit amount should be numeric. (check line : ".($i+1)." )");
		}	
	}
	if($error==0)
	{
		for($i=0;$i<count($av_orders);$i++)
		{
			$total_credit_notes=$creditnoteObj->get_total_credit_notes($av_orders[$i]);
			$orderObj=new invoiceOrder(trim($av_orders[$i]));
			$order_value=((($orderObj->order_rate)-($orderObj->discount_amount))+($orderObj->tax_amount))-$total_credit_notes;
			if(trim($av_values[$i]) > $order_value)
			{
				$error++;
				array_push($error_array,"Credit amount cannot be greater than the allowed credit amount per line(check line : ".($i+1).")");
			}
		}
	}

	if($error==0)
	{
		$result["success"]		=1;
		$result["return_value"]	=$creditnoteObj->insert_new_credit_note($_POST['invoice_id'],$_POST['total_credit_notes'],$_POST['total_credit_vat'],$_POST['total_gross'],$_SESSION['employee_id'],$_POST['credit_amount']);
		$result["return_html"]	=$val->draw_success_chart("Credit note saved successfully",1);
		$credit_noteObj=new credit_note($result["return_value"]);	
		for($i=0;$i<count($av_orders);$i++)
		{
			if(trim($av_values[$i])>0)
			{
				
				$orderObj				=new invoiceOrder(trim($av_orders[$i]));
				$credit_value			=trim($av_values[$i]);
				$order_rate				=(($orderObj->order_rate)-($orderObj->discount_amount));
				$credit_tax_value		=(($orderObj->tax_amount)*($credit_value))/$order_rate;			
				$credit_order_value		=($credit_value-$credit_tax_value);
				$credit_noteObj->insert_credit_note_detail($av_orders[$i],$credit_order_value,$credit_tax_value);	
			}
		}
		$result["return_html"]	="<div class='alert alert-success'>Well Done!!</div>";
		$result["return_value"]	=1;
		$result["success"]		=1;
	}
	else
	{
		$result["return_html"]	="<div class='alert alert-danger'>Credit amount cannot be greater than the allowed credit amount per line</div>";
		$result["return_value"]	=-1;
		$result["success"]		=0;
	}
	echo json_encode($result);
} elseif ($_POST['action']==5) {
	$invoiceObj	=new invoice($_POST['invoice_id']);
	$av_orders	=explode(",",$_POST['index']);
	$av_values	=explode("~!~!",$_POST["concat"]);

	$error=0;
	for($i=0;$i<count($av_orders);$i++)
	{
		$rates			=explode("***",$av_values[$i]);
		$order_rate		=trim($rates[0]);
		$discount_rate	=trim($rates[1]);
		for($j=0;$j<2;$j++)
		{
			if(is_numeric($rates[$j]))
			{
				if($rates[$j]<0)
				{
					$error++;
					break;
				}
			}
			else
			{
				$error++;
				break;
			}
			if(strlen(trim($rates[$j]))==0 && $error==0)
			{
				$error++;
				break;
			}
		}
		if($error>0)
			break;
		
		if($discount_rate>$order_rate)
		{
			$error++;
			break;
		}
	}
	if($error==1)
	{
		$result["return_html"]	="<div class='alert alert-danger'>Could not Update rates <br/> Some Fields are either empty or not numeric or has negative values.</div>";
		$result["success"]		=0;
	}
	else
	{
		for($i=0;$i<count($av_orders);$i++)
		{
			$rates			=explode("***",$av_values[$i]);
			$order_rate		=trim($rates[0]);
			$discount_rate	=trim($rates[1]);
		
			$orderObj=new invoiceOrder($av_orders[$i]);
			$orderObj->update_rates($order_rate,$discount_rate,$_SESSION['employee_id']);
		}
		$result["return_html"]	="<div class='alert alert-success'>rates updated successfully</div>";
		$result["success"]		=1;
	}
	echo json_encode($result);
} elseif ($_POST['action']==6) {
	$val = new Validation();
	$val->setRules("payment_mode","Payment mode is a required Field",array("required"));
	$val->setRules("payment_amount","Payment Amount is a required Field",array("required"));
	$val->setRules("payment_amount","Payment Amount should be numeric",array("numeric"));
	$invoiceObj			= new invoice($_POST['invoice_id']);
	if($val->validate())
	{
		$invoiceObj=new invoice($_POST['invoice_id']);
		if($_POST['payment_type']==1)
		{
			$default_value	=($invoiceObj->invoice_total_amount)-($invoiceObj->invoice_amount_paid);
			$default_text	="Payment amount cannot exceed the due amount";
		}
		else	
		{
			$default_value=($invoiceObj->invoice_amount_paid);
			$default_text	="Payment amount cannot exceed the paid amount";
		}
		
		if($_POST['payment_amount']>$default_value)
		{
			$result["return_html"]		=$val->draw_custom_error($default_text,1);
			$result["success"]			=0;
			$result["return_value"]		=0;		
		}
		else
		{
			$result["return_html"]		=$val->draw_success_chart("Payment recorded Successfully",1);
			$result["success"]			=1;
			$result["return_value"]		=0;
			$invoiceObj->record_payment($_POST['payment_type'],$_POST['payment_amount'],$_POST['payment_mode'],$_POST['reference'],$_POST['payment_notes'],$_SESSION['employee_id']);
		}
	}
	else
	{
		$result["return_html"]		=$val->draw_errors_list(1);
		$result["success"]			=0;
		$result["return_value"]		=0;
	}

	echo json_encode($result);
} elseif ($_POST['action']==7) {
	$invoiceObj					=new invoice($_POST['invoice_id']);
	$invoiceObj->delete_invoice();
} elseif ($_POST['action']==8) {
	$invoiceObj					=new customer();
	$invoiceObj->get_av_customer_search($_POST['search_token']);
} elseif ($_POST['action']==9) {
	$invoiceObj					=new invoice();
	$invoiceObj->get_invoice_search($_POST['search_token']);
}

?>