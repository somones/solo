<?php
class discount_plan
{
	public $table_name="rc_discount_plan";
	public $discount_plan_id;
	public $discount_plan_name;
	public $discount_value;
	public $discount_type;
	public $plan_active;
	public $plan_deleted;

	function __Construct($discount_plan_id=NULL)
	{
		if(isset($discount_plan_id))
		{
			$this->discount_plan_id=$discount_plan_id;
			$this->build_object();
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `discount_plan_id`=:discount_plan_id";
		$db->query($query);
		$db->bind("discount_plan_id",$this->discount_plan_id);
		$result			=$db->resultset();
		$prop			=$result[0];
		foreach ($prop as $key => $value) 
			$this->$key=$value;				
	}
	
	function get_active_discount_plans()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `plan_active`='1'";
		$db->query($query);
		$result			=$db->resultset();
		return $result;
	}
	
}

?>