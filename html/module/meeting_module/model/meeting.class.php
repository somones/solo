<?php

class meeting
{
	public $table_name="module_meeting";
	public $meeting_id;
	public $meeting_title;
	public $meeting_room_id_FK;
	public $meeting_start_date_time;
	public $meeting_end_date_time;
	public $meeting_description;
	public $meeting_active;
	public $user_added;
	public $date_time_added;
	public $date_time_updated;
	
	function __Construct($meeting_id=NULL)
	{
		if(isset($meeting_id))
		{
			$this->meeting_id=$meeting_id;
			$this->build_object();			
		}
	}
	
	
	function get_meeting_attendee()
	{
		$array_single=array();
		$db=new Database();
		$query="SELECT `employee_id` FROM `module_meeting_attendee` 
		INNER JOIN `setup_employee` ON `setup_employee`.`employee_id` = `module_meeting_attendee`.`employee_id_FK`
		INNER JOIN `module_meeting` ON `module_meeting`.`meeting_id` = `module_meeting_attendee`.`meeting_id_FK` WHERE `meeting_id`=:meeting_id";
		$db->query($query);
		$db->bind("meeting_id",$this->meeting_id);
		$result=$db->resultset();
		for($i=0;$i<count($result);$i++)
		{
			array_push($array_single,$result[$i]["employee_id"]);
		}
		return $array_single;
	}
	
	function remove_all_attendee()
	{
		
		$db=new Database();
		$query="DELETE FROM `module_meeting_attendee` WHERE `meeting_id_FK`='".$this->meeting_id."'";
		$db->query($query);
		$db->execute();
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` WHERE `meeting_id`=:meeting_id";
		$db->query($query);
		$db->bind("meeting_id",$this->meeting_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;		

		$employee=array();
		
		$query ="SELECT * FROM `module_meeting_attendee` 
		INNER JOIN `setup_employee` ON `setup_employee`.`employee_id` = `module_meeting_attendee`.`employee_id_FK`
		INNER JOIN `module_meeting` ON `module_meeting`.`meeting_id` = `module_meeting_attendee`.`meeting_id_FK` WHERE `meeting_id`=:meeting_id AND `attended`='1'";
		$db->query($query);
		$db->bind("meeting_id",$this->meeting_id);
		
		$result=$db->resultset();
		for($i=0;$i<count($result);$i++)
		{
			array_push($employee,$result[$i]["employee_id"]);
		}
		$this->employee=$employee;		
	}	
	
	function insert_new_meeting($array,$user_id)
	{
		$query="INSERT INTO `".$this->table_name."` 
		(`meeting_title`,`meeting_room_id_FK`,`meeting_start_date_time`,`meeting_end_date_time`,`meeting_description`,`meeting_active`,`user_added`,`date_time_added`) 
		VALUES('".$array["meeting_title"]."','".$array["meeting_room"]."','".$array["meeting_start_date_time"]."','".$array["meeting_end_date_time"]."','".$array["meeting_description"]."','1','".$user_id."','".Date("Y-m-d H:i:s")."')";
		$db=new Database();
		$db->query($query);
		$db->execute();
		$meeting_id=$db->lastInsertId();
		return $meeting_id;
	}

	function update_meeting($array,$meeting_id)
	{
		$query= "UPDATE `module_meeting` SET `meeting_title` = '".$array["meeting_title"]."', `meeting_room_id_FK` = '".$array["meeting_room"]."',`meeting_start_date_time` = '".$array["meeting_start_date_time"]."',`meeting_end_date_time` = '".$array["meeting_end_date_time"]."',`meeting_description` = '".$array["meeting_description"]."' WHERE `meeting_id`='".$array["meeting_id"]."'";
		$db=new Database();
		$db->query($query);
		$db->execute();
		//$meeting_id=$db->lastInsertId();
		return $meeting_id;
	}

	function update_mom_meeting($text)
	{
		$query= "UPDATE `module_meeting` SET `meeting_mom` = '".$text."' WHERE `meeting_id`='".$this->meeting_id."'";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}

	function attended_per_meeting($meeting_id){
		$employee=array();
		
		$db		=new Database();
		$query ="SELECT * FROM `module_meeting_attendee` 
		INNER JOIN `setup_employee` ON `setup_employee`.`employee_id` = `module_meeting_attendee`.`employee_id_FK`
		INNER JOIN `module_meeting` ON `module_meeting`.`meeting_id` = `module_meeting_attendee`.`meeting_id_FK` WHERE `meeting_id`='".$meeting_id."' AND `attended`='1'";

		$db->query($query);
		$result=$db->resultset();
		for($i=0;$i<count($result);$i++)
		{
			array_push($employee,$result[$i]["employee_id"]);
		}
		$this->employee=$employee;
	}

	function abscent_per_meeting($meeting_id){
		$db		=new Database();
		$query ="SELECT * FROM `module_meeting_attendee` 
		INNER JOIN `setup_employee` ON `setup_employee`.`employee_id` = `module_meeting_attendee`.`employee_id_FK`
		INNER JOIN `module_meeting` ON `module_meeting`.`meeting_id` = `module_meeting_attendee`.`meeting_id_FK` WHERE `meeting_id`='".$meeting_id."' AND `attended`='0'";
		$db->query($query);
		return $db->resultset();
	}
	
	function add_meeting_attendee($attendee_id,$attendee_type)
	{
		$checkin_code=$this->generate_code(6);
		$query="INSERT INTO `module_meeting_attendee` (`meeting_id_FK`,`employee_id_FK`,`attendee_type_id_FK`,`attended`,`checkin_code`) 
		VALUES('".$this->meeting_id."','".$attendee_id."','".$attendee_type."','0','".$checkin_code."')";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}
	
	function generate_code($length)
	{
		$characters = '123456789';
        $randomString = '';
        for ($i=0; $i < $length; $i++) { 
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
	}

	function sendEmail($email,$code){
		/*
		$mail = new PHPMailer;
		$mail->isSMTP();                            // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                     // Enable SMTP authentication
		$mail->Username = 'email'; // your email id
		$mail->Password = 'password'; // your password
		$mail->SMTPSecure = 'tls';                  
		$mail->Port = 587;     //587 is used for Outgoing Mail (SMTP) Server.
		$mail->setFrom('belkahla.samir@gmail.com', 'Name');
		$mail->addAddress($email);   // Add a recipient
		$mail->isHTML(true);  // Set email format to HTML

		$bodyContent = '<h1>HeY!,</h1>';
		$bodyContent .= '<p>Your Code is '.$code.'</p>';
		$mail->Subject = 'Meeting PIN';
		$mail->Body    = $bodyContent;
		*/
	}

	function list_meetings($user_session=NULL)
	{
	 $query="SELECT * FROM `module_meeting` ORDER BY `meeting_start_date_time` DESC";
	 //echo $query;
	 $db=new Database();
	 $db->query($query);
	 $result=$db->resultset();
	 return $result;
	}

	function delete_meeting($meeting_id)
	{
		$db=new Database();
		$query= "UPDATE `module_meeting` SET `meeting_active`=2 WHERE meeting_id='".$meeting_id."'";
		//$db->bind("meeting_id",$this->meeting_id);
		//$db->query($query);
		//$db->execute()
		//$query="DELETE FROM `module_meeting` WHERE `meeting_id`='".$meeting_id."'";
		$db->query($query);
		$db->execute();
		
		//$query="DELETE FROM `module_meeting_attendee` WHERE `meeting_id_FK`='".$meeting_id."'";
		//$db->query($query);
		//$db->execute();
	}

	function if_exist($meeting_room_id_FK,$meeting_start_date_time)
	{
		$db		=new Database();
		$query	="SELECT * FROM `module_meeting` WHERE 
		`meeting_room_id_FK`=:meeting_room_id_FK 
		AND `meeting_start_date_time`<=:meeting_start_date_time AND meeting_end_date_time>=:meeting_start_date_time";
		$db->query($query);
		$db->bind("meeting_room_id_FK",$this->meeting_room_id_FK);
		$db->bind("meeting_start_date_time",$this->meeting_start_date_time);
		$result			= $db->single();
		//print_r("This is The result: ".$result);
		// Check row
		$rowCount = $db->rowCount();
	    if($db->rowCount() > 0){
	    	return true;
	    } else {
	    	return false;
	    }
	}

	function current_meeting($room_id){
		date_default_timezone_set("Asia/Dubai");
		$current_date_time= date("Y-m-d H:i:s");

		$db		=	new Database();
		$query  = 	"SELECT DISTINCT * FROM module_meeting
    	INNER JOIN module_meeting_room ON module_meeting_room.room_id = module_meeting.meeting_room_id_FK WHERE module_meeting.meeting_room_id_FK='".$room_id."' AND module_meeting.meeting_start_date_time <='$current_date_time' AND module_meeting.meeting_end_date_time >='$current_date_time'";

	 	$db->query($query);
	 	$result=$db->resultset();
	 	return $result;

	}

	function next_meeting($room_id){
		//date_default_timezone_set("Asia/Dubai");
		$current_date_time= date("Y-m-d H:i:s");

		$db		=new Database();
		$query = "SELECT * FROM module_meeting
    	INNER JOIN module_meeting_room ON module_meeting_room.room_id = module_meeting.meeting_room_id_FK WHERE module_meeting.meeting_room_id_FK='".$room_id."' AND module_meeting.meeting_start_date_time >'$current_date_time' ORDER BY `module_meeting`.`meeting_start_date_time` ASC";

    	$db->query($query);
	 	$result=$db->resultset();
	 	return $result;
	}

	function get_atendees_info($checkin_code) {
		$db		=new Database();
		$query = "SELECT * FROM module_meeting_attendee
			INNER JOIN module_attendee_type ON module_attendee_type.attendee_type_id = module_meeting_attendee.attendee_type_id_FK
			INNER JOIN module_meeting ON module_meeting.meeting_id = module_meeting_attendee.meeting_id_FK
			INNER JOIN setup_employee ON setup_employee.employee_id = module_meeting_attendee.employee_id_FK
			WHERE module_meeting_attendee.checkin_code = '$checkin_code' ";
    	$db->query($query);
	 	$result=$db->single();
	 	return $result;
	}

	function update_atendee ($employee_id_FK){
		date_default_timezone_set("Asia/Dubai");
		$current_date_time= date("Y-m-d H:i:s");
		$db		=new Database();
		$query= "UPDATE `module_meeting_attendee` SET 
		`date_time_checked_in` = '".$current_date_time."',
		`attended` = '1'
		WHERE `employee_id_FK`='".$employee_id_FK."'";
		$db->query($query);
		$db->execute();
	}
}
?>

