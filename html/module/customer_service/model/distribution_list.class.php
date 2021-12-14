<?php
class distribution_list
{
	public $table_name="setup_distribution_list";
	public $list_id;
	public $branch_id_FK;
	public $list_type_id_FK;
	public $list_name;
	public $list_description;
	
	function __Construct($list_id=NULL)
	{
		if(isset($list_id))
		{
			$this->list_id=$list_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `list_id`=:list_id";
		$db->query($query);
		$db->bind("list_id",$this->list_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_distribution_list($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."`";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function list_of_dl_per_type($type_id)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE list_type_id_FK = '".$type_id."'";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_dl_list_name($list_id)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE list_id = '".$list_id."'";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function get_branch_id($list_id)
	{
		$query="SELECT branch_id_FK FROM `".$this->table_name."` WHERE list_id = '".$list_id."'";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function insert_new_distribution_list($user_id) {
		$query="INSERT INTO `".$this->table_name."` 
		(
			`branch_id_FK`,
			`list_type_id_FK`,
			`list_name`,
			`list_description`
		)

		VALUES(
			'".$this->branch_id_FK."',
			'".$this->list_type_id_FK."',
			'".$this->list_name."',
			'".$this->list_description."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_distribution_list($list_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		
		`branch_id_FK` = '".$this->branch_id_FK."', 
		`list_type_id_FK` = '".$this->list_type_id_FK."',
		`list_name` = '".$this->list_name."',
		`list_description` = '".$this->list_description."'
		
		WHERE `list_id`='".$list_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_distribution_list($list_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `list_id`='".$list_id."'";
		$db->query($query);
		$db->execute();
	}

	function delete_contact_from_list()
	{
		$db=new Database();
		$query="DELETE FROM `setup_dl_has_contact` WHERE `list_id_FK`='".$this->list_id."'";
		$db->query($query);
		$db->execute();		
	}

	function add_contact_to_list($array)
	{
		$db=new Database();
		if(strlen($array)>0)
		{
			$values=explode(",",$array);
			for($i=0;$i<count($values);$i++)
			{
				$query="INSERT INTO `setup_dl_has_contact` (`list_id_FK`,`contact_id_FK`) VALUES('".$this->list_id."','".$values[$i]."')";
				$db->query($query);
				$db->execute();
				
			}
		}		
	}
	
	function get_active_contacts()
	{
		$db=new Database();
		$query="SELECT * FROM `setup_dl_has_contact` INNER JOIN `setup_distribution_contact` ON `setup_distribution_contact`.`contact_id`=`setup_dl_has_contact`.`contact_id_FK` 
		WHERE `list_id_FK`='".$this->list_id."' AND `setup_distribution_contact`.`contact_active`='1'";
		$db->query($query);
		return $db->resultset();
	}

	function get_contacts_list($list_id)
	{
		$db=new Database();
		$query="SELECT * FROM `setup_dl_has_contact` INNER JOIN `setup_distribution_contact` ON `setup_distribution_contact`.`contact_id`=`setup_dl_has_contact`.`contact_id_FK` 
		WHERE `list_id_FK`='".$list_id."' AND `setup_distribution_contact`.`contact_active`='1'";
		$db->query($query);
		return $db->resultset();
	}
}
?>