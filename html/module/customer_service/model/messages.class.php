<?php
class messages
{
	public $table_name="steup_messages";
	
	function __Construct($message_id=NULL)
	{
		if(isset($message_id))
		{
			$this->message_id=$message_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `message_id`=:message_id";
		$db->query($query);
		$db->bind("message_id",$this->message_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}


	function process_sending($sender_id,$branch_id,$arabic_text)
	{
		$distributionListObj=new distribution_list($this->message_distribution_id_FK);
		$contacts_list		=$distributionListObj->get_active_contacts();
		if($this->message_type_id_FK==1)
		{
			$list=array();
			$emailObj=new email();
			
			for($i=0;$i<count($contacts_list);$i++)
			{
				array_push($list,$contacts_list[$i]["contact_email"]);
				$this->insert_new_message($this->message_subject,$this->message_content,$this->message_distribution_id_FK,$this->message_type_id_FK,$contacts_list[$i]["contact_id"],$sender_id);
				$emailObj->send_email($this->message_subject,$this->message_content,$contacts_list[$i]['contact_email']);
			}
		}
			
		else if($this->message_type_id_FK==2)
		{
			$list=array();
			for($i=0;$i<count($contacts_list);$i++)
			{
				array_push($list,$contacts_list[$i]["contact_mobile_number"]);
				$this->insert_new_message($this->message_subject,$this->message_content,$this->message_distribution_id_FK,$this->message_type_id_FK,$contacts_list[$i]["contact_id"],$sender_id);
			}
			$smsObj = new sms($branch_id);
			if ($arabic_text == 1) {
				echo $smsObj->send_sms("unicode",$this->message_content,$list);
			} else {
				echo $smsObj->send_sms("text",$this->message_content,$list);
			}
		}
	}

	function list_of_all_messages($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."`";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function list_of_email($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE type = 1";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function list_of_sms($user_session=NULL)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE type = 2";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		return $result;
	}

	function update_this_message($message_id){
		//print_r($_POST);
		$query= "UPDATE `".$this->table_name."` SET 
			`message_subject` = '".$this->message_subject."',
			`message_content` = '".$this->message_content."',
			`message_type_id_FK` = '".$this->message_type_id_FK."',
			`message_distribution_id_FK` = '".$this->message_distribution_id_FK."'
		WHERE `message_id`='".$message_id."' ";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function delete_this_message($message_id)
	{
		$db=new Database();
		$query="DELETE FROM `".$this->table_name."` WHERE `message_id`='".$message_id."'";
		$db->query($query);
		$db->execute();
	}

	function list_of_user($list_id,$subject,$content){
		$db		=new Database();
		$query="SELECT * FROM setup_dl_has_contact
		INNER JOIN setup_distribution_contact ON setup_distribution_contact.contact_id = setup_dl_has_contact.contact_id_FK
		WHERE  setup_dl_has_contact.list_id_FK = '".$list_id."'";
		
		$db->query($query);
		$result=$db->resultset();

		for($i=0;$i<count($result);$i++) {
			$this->sendEmail($result[$i]['contact_email'],$subject,$content);
		}
	}

	function list_of_sms_user($list_id,$subject,$content){
		$db		=new Database();
		$query="SELECT * FROM setup_dl_has_contact
		INNER JOIN setup_distribution_contact ON setup_distribution_contact.contact_id = setup_dl_has_contact.contact_id_FK
		WHERE  setup_dl_has_contact.list_id_FK = '".$list_id."'";
		
		$db->query($query);
		$result=$db->resultset();
		$user = array();
		echo "SMS Content: ".$content;
		echo "<br>";
		for($i=0;$i<count($result);$i++) {
			echo "To be send to: ".$result[$i]['contact_mobile_number'];
			echo "<br>";
			//$this->sendSMS($result[$i]['contact_mobile_number'],$subject,$content);
			array_push($user,$result[$i]['contact_mobile_number']);
		}
		print_r($user);
	}

	function sendEmail($email,$subject,$content){
		//echo "executed";
		$to      = $email;
		$subject = $subject;
		$message = $content;
		$headers = 'From: governance@fakihivf.com' . "\r\n" .
		    'Reply-To: governance@fakihivf.com' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		mail($to, $subject, $message, $headers);
	}
//$this->message_subject,$this->message_content,$this->message_distribution_id_FK,$this->message_type_id_FK,$contact,$sender_id)
	function insert_new_message($subject,$content,$list_id,$message_type,$contact,$sender) 
	{
		$query="INSERT INTO `steup_messages` 
		(
			`message_subject`,
			`message_content`,
			`message_sender_user_id_FK`,
			`message_type_id_FK`,
			`message_receiver_contact_id_FK`,
			`message_distribution_id_FK`
		)

		VALUES(
			'".$subject."',
			'".$content."',
			'".$sender."',
			'".$message_type."',
			'".$contact."',
			'".$list_id."'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$message_id=$db->lastInsertId();
		return $message_id;
	}

	function insert_new_sms($user_id) {
		//print_r($_POST);
		$query="INSERT INTO `steup_messages` 
		(
			`message_subject`,
			`message_content`,
			`message_type_id_FK`,
			`message_distribution_id_FK`,
			`type`
		)
		VALUES(
			'".$this->message_subject."',
			'".$this->message_content."',
			'".$this->message_type_id_FK."',
			'".$this->message_distribution_id_FK."',
			'2'
		)";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$billing_item_id=$db->lastInsertId();
		return $billing_item_id;
	}

	function get_message_search_json_test() {

	    $query = "SELECT * FROM steup_messages
	    INNER JOIN `setup_employee` ON `setup_employee`.`employee_id`=`steup_messages`.`message_sender_user_id_FK`
	    INNER JOIN `setup_distribution_contact` ON `setup_distribution_contact`.`contact_id`=`steup_messages`.`message_receiver_contact_id_FK`
	    INNER JOIN `setup_distribution_list` ON `setup_distribution_list`.`list_id`=`steup_messages`.`message_distribution_id_FK` LIMIT 1";
	}

	function get_message_search_json($branch_id,$type_id,$list_type_id,$list_id,$employee_id,$contact_id) {

	    $query = "SELECT * FROM steup_messages
	    INNER JOIN `setup_employee` ON `setup_employee`.`employee_id`=`steup_messages`.`message_sender_user_id_FK`
	    INNER JOIN `setup_distribution_contact` ON `setup_distribution_contact`.`contact_id`=`steup_messages`.`message_receiver_contact_id_FK`
	    INNER JOIN `setup_distribution_list` ON `setup_distribution_list`.`list_id`=`steup_messages`.`message_distribution_id_FK`";
	    
	    $conditions = array();

	    if(! empty($branch_id)) {
	      $conditions[] = "setup_employee.branch_id_FK='$branch_id'";
	    }
	    if(! empty($type_id)) {
	      $conditions[] = "message_type_id_FK='$type_id'";
	    }
	    if(! empty($list_id)) {
	      $conditions[] = "message_distribution_id_FK='$list_id'";
	    }
	    if(! empty($employee_id)) {
	      $conditions[] = "message_sender_user_id_FK='$employee_id'";
	    }
	    if(! empty($contact_id)) {
	      $conditions[] = "setup_distribution_contact.contact_mobile_number LIKE '%".$contact_id."%' OR setup_distribution_contact.contact_email LIKE '%".$contact_id."%' ";
	    }
	    if(! empty($list_type_id)) {
	      $conditions[] = "setup_distribution_list.list_type_id_FK='$list_type_id'";
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