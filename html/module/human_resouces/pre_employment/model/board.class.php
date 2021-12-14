<?php
class board 
{
	public $table_name="setup_board_certified";
	public $board_id;
	public $board_name;
	public $board_exist_tag;
	public $display_to_all;
	
	function __Construct($board_id=NULL)
	{
		if(isset($board_id))
		{
			$this->board_id=$board_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `board_id`=:board_id";
		$db->query($query);
		$db->bind("board_id",$this->board_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_boards () {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` ";
		$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_applicant_board ($board_id) {
		$db		=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE  board_id = '".$board_id."'";
		$db->query($query);
	 	$result=$db->single();
	 	return $result;
	}

}
?>