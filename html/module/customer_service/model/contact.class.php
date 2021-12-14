<?php

class contact
{
	public $table_name="setup_distribution_contact";
	public $contact_id;
	public $contact_name;
	public $contact_email;
	public $contact_user_id_FK;
	public $contact_mobile_number;
	public $contact_active;
	public $extension_number;
	public $branch_id_FK;
	
	function __Construct($contact_id=NULL)
	{
		if(isset($contact_id))
		{
			$this->contact_id=$contact_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `contact_id`=:contact_id";
		$db->query($query);
		$db->bind("contact_id",$this->contact_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}

	function list_of_contacts($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE contact_active=1";

		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function list_reciever_contacts($contact_id)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE contact_id='".$contact_id."'";

		$db=new Database();
		$db->query($query);
		$result=$db->single();
		return $result;
	}

	function insert_new_contact($user_id) {

		$query="INSERT INTO `".$this->table_name."` 
		(
			`contact_name`,
			`contact_email`,
			`contact_user_id_FK`,
			`contact_mobile_number`,
			`contact_active`,
			`extension_number`,
			`branch_id_FK`
		)

		VALUES(
			'".$this->contact_name."',
			'".$this->contact_email."',
			'".$this->contact_user_id_FK."',
			'".$this->contact_mobile_number."',
			'1',
			'".$this->extension_number."',
			'".$this->branch_id_FK."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function update_this_contact($contact_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
		`contact_name` = '".$this->contact_name."', 
		`contact_user_id_FK` = '".$this->contact_user_id_FK."',
		`contact_email` = '".$this->contact_email."',
		`contact_mobile_number` = '".$this->contact_mobile_number."',
		`extension_number` = '".$this->extension_number."',
		`branch_id_FK` = '".$this->branch_id_FK."'
		WHERE `contact_id`='".$contact_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_contact($contact_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `contact_id`='".$contact_id."'";
		$db->query($query);
		$db->execute();
	}



	function get_contact_assigned_list($list_id)
	{
		$array=array();
		$db=new Database();
		$query="SELECT * FROM `setup_dl_has_contact` WHERE `list_id_FK`='".$list_id."'";
		$db->query($query);
		$result=$db->resultset();
		for($i=0;$i<count($result);$i++)
		{
			array_push($array,$result[$i]["contact_id_FK"]);
		}
		return $array;		
	}

	
}
?>