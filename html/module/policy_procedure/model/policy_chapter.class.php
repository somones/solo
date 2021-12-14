<?php

class policy_chapter
{
	public $table_name="pp_policy_chapter";
	public $chapter_id;
	public $chapter_title;
	public $chapter_active;
	
	function __Construct($chapter_id=NULL)
	{
		if(isset($chapter_id))
		{
			$this->chapter_id=$chapter_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `chapter_id`=:chapter_id";
		$db->query($query);
		$db->bind("chapter_id",$this->chapter_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}	
	
	function get_active_chapters()
	{
		$db=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE `chapter_active`='1'";
		$db->query($query);
		return $db->resultset();
	}

	function get_chapters($user_session=NULL)
	{
		$db=new Database();
		$query="SELECT * FROM `".$this->table_name."`";
		$db->query($query);
		return $db->resultset();
	}

	function insert_new_chapter($user_id)
	{
		$query="INSERT INTO `".$this->table_name."` 
		(`chapter_title`,`chapter_active`) 
		VALUES('".$this->chapter_title."','1')";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$chapter_id=$db->lastInsertId();
		return $chapter_id;
	}

	function update_the_chapter($user_id){
		$query= "UPDATE `pp_policy_chapter` 
		SET 
		`chapter_title` = '".$this->chapter_title."'
		WHERE `chapter_id`='".$this->chapter_id."'";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_chapter()
	{
		$db=new Database();
		$query="DELETE FROM `pp_policy_chapter` WHERE `chapter_id`='".$this->chapter_id."'";
		$db->query($query);
		$db->execute();
	}

}

?>

