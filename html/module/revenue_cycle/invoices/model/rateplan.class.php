<?php
class rateplan
{
	public $table_name="rc_price_rate_sheet";
	public $rate_sheet_id;
	public $rate_sheet_name;
	public $rate_sheet_description;
	public $branch_id_FK;
	public $rate_sheet_active;
	public $deleted;
	public $date_added;
	public $user_added;
	public $time_stamp;	
	public $user_stamp;		

	function __Construct($rate_sheet_id=NULL)
	{
		if(isset($rate_sheet_id))
		{
			$this->rate_sheet_id=$rate_sheet_id;
			$this->build_object();
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `rate_sheet_id`=:rate_sheet_id";
		$db->query($query);
		$db->bind("rate_sheet_id",$this->rate_sheet_id);
		$result			=$db->resultset();
		$prop			=$result[0];
		foreach ($prop as $key => $value) 
			$this->$key=$value;				
	}
	
	function get_active_rate_sheets()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `rate_sheet_active`='1'";
		$db->query($query);
		$result			=$db->resultset();
		return $result;
	}
	
}

?>