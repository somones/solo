<?php
class service
{
	public $table_name="rc_services";
	public $service_id;
	public $service_code;
	public $service_name;
	public $service_active;

	function __Construct($service_id=NULL)
	{
		if(isset($service_id))
		{
			$this->service_id=$service_id;
			$this->build_object();
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `service_id`=:service_id";
		$db->query($query);
		$db->bind("service_id",$this->service_id);
		$result			=$db->resultset();
		$prop			=$result[0];
		foreach ($prop as $key => $value) 
			$this->$key=$value;				
	}
	
	function get_active_services()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `service_active`='1'";
		$db->query($query);
		$result			=$db->resultset();
		return $result;
	}
	
	function get_service_price($rate_sheet)
	{
		$db=new Database();
		$query="SELECT * FROM `rc_service_has_price` 
		INNER JOIN `rc_tax_rate` ON `rc_tax_rate`.`tax_id`=`rc_service_has_price`.`tax_id_FK`
		WHERE `rc_service_has_price`.`service_id_FK`='".$this->service_id."' 
		AND `rc_service_has_price`.`rate_sheet_id_FK`='".$rate_sheet."' ";
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function list_of_billing_item()
	{
		$db		=new Database();
		$query	="SELECT * FROM `rc_billing_item` WHERE `item_active`='1'";
		$db->query($query);
		$result			=$db->resultset();
		return $result;
	}
	
}

?>