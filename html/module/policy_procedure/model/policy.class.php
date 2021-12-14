<?php

class policy
{
	public $table_name="pp_policy";
	public $policy_id;
	public $policy_title;
	public $policy_description;
	public $policy_chapter_id_FK;
	public $policy_department_id_FK;
	public $policy_effective_date;
	public $policy_revision_date;
	public $policy_user_created;
	public $policy_date_created;
	public $policy_date_updated;
	public $policy_active_state;
	
	
	
	function __Construct($policy_id=NULL)
	{
		if(isset($policy_id))
		{
			$this->policy_id=$policy_id;
			$this->build_object();			
		}
	}
	
	function list_per_department($department_id)
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` 
		INNER JOIN `setup_department` ON `department_id`=`policy_department_id_FK`
	    INNER JOIN `pp_policy_chapter` ON `chapter_id`=`policy_chapter_id_FK`
	    INNER JOIN `setup_employee` on `employee_id`=`policy_user_created`
		INNER JOIN `pp_policy_action_log` ON `".$this->table_name."`.`policy_state_id_FK`=`pp_policy_action_log`.`tracker_id`
		INNER JOIN `pp_policy_action` ON `pp_policy_action`.`action_id`=`pp_policy_action_log`.`action_id_FK`
		WHERE `".$this->table_name."`.`policy_department_id_FK`='".$department_id."' AND `state_id_FK`='6'";
		$db->query($query);		
		return $db->resultset();
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` 
		INNER JOIN `setup_department` ON `department_id`=`policy_department_id_FK`
	    INNER JOIN `pp_policy_chapter` ON `chapter_id`=`policy_chapter_id_FK`
	    INNER JOIN `setup_employee` on `employee_id`=`policy_user_created`
		WHERE `policy_id`=:policy_id";
		$db->query($query);
		$db->bind("policy_id",$this->policy_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
			
		$branches=array();	
		
		$query="SELECT * FROM `pp_policy_has_branch` WHERE `policy_id_FK`='".$this->policy_id."'";
		$db->query($query);
		$result=$db->resultset();
		
		for($i=0;$i<count($result);$i++)
		{
			array_push($branches,$result[$i]["branch_id_FK"]);
		}
		$this->branches=$branches;
		
	}	
	
	function insert_new_file($file_id)
	{
		$db=new Database();
		$query="INSERT INTO `policy_has_attachment` (`policy_id_FK`,`attachment_id_FK`) VALUES('".$this->policy_id."','".$file_id."')";
		$db->query($query);
		$db->execute();

	}
	
	function update_existing($array)
	{
		extract($array);
		//$policy_control_password=md5($policy_control_password);
		$db=new Database();	
		$query="UPDATE `".$this->table_name."`
		SET 
		`policy_title`='".$policy_title."',
		 `policy_description`='".$policy_description."',
		 `policy_chapter_id_FK`='".$policy_chapter."',
		 `policy_department_id_FK`='".$policy_department."',
		 `policy_effective_date`='".$policy_effective_date."',
		 `policy_revision_date`='".$policy_revision_date."',
		 `policy_active_state`='1',
		 `policy_control_type_id_FK`='".$policy_control_type."',
		 `policy_control_password`='".$policy_control_password."'
		WHERE `policy_id`='".$this->policy_id."'";
		$db->query($query);
		$db->execute();
	}
	
	function get_active_chapters()
	{
	/*	$db=new Database();
		$query="SELECT * FROM `".$this->table_name."` WHERE `chapter_active`='1'";
		$db->query($query);
		return $db->resultset();
	*/	
		
	}
	
	
	function get_available_attachments()
	{
		$db=new Database();
		$query="SELECT * FROM `policy_has_attachment` 
		INNER JOIN `setup_uploads` ON `attachment_id_FK`=`upload_id` 
		INNER JOIN `setup_employee` ON `file_user_uploaded`=`employee_id` 
		WHERE `policy_id_FK`='".$this->policy_id."'";
		$db->query($query);
		return $db->resultset();
	}
	
	function insert_new_policy($array,$user_id)
	{
		extract($array);
		//$policy_control_password=md5($policy_control_password);
		$db=new Database();
		$ref=$this->generate_policy_ref($policy_department);
		//$ref="test";
		$query="INSERT INTO `".$this->table_name."` 
		(`policy_ref_number`,`policy_title`,`policy_description`,`policy_chapter_id_FK`,`policy_department_id_FK`,`policy_effective_date`,`policy_revision_date`,`policy_user_created`,`policy_date_created`,`policy_active_state`,`policy_state_id_FK`,`policy_control_type_id_FK`,`policy_control_password`)
		VALUES('".$ref."','".$policy_title."','".$policy_description."','".$policy_chapter."','".$policy_department."','".$policy_effective_date."','".$policy_revision_date."','".$user_id."','".date("Y-m-d H:i:s")."','1','1','".$policy_control_type."','".$policy_control_password."')
		";
		$db->query($query);
		$db->execute();
		$policy_id=$db->lastInsertId();
		$policyObj=new policy($policy_id);
		$policyObj->unsign_from_all_branches();
		$policyObj->assign_policy_to_branches($policy_branches);
		
		
		$query="INSERT INTO `pp_policy_action_log` (`policy_id_FK`,`action_id_FK`,`tracker_comment`,`user_id_FK`) 
		VALUES('".$policy_id."','6','Auto Inserted','".$user_id."')";
		$db->query($query);
		$db->execute();
		$tracker_id=$db->lastInsertId();
		
		$query="UPDATE `pp_policy` SET `policy_state_id_FK`='".$tracker_id."' WHERE `policy_id`='".$policy_id."'";
		$db->query($query);
		$db->execute();
		
		return $policy_id;
		
	}
	
	
	function assign_policy_to_branches($branches_str)
	{
		$db=new Database();
		$array=explode(",",$branches_str);
		$query=" INSERT INTO `pp_policy_has_branch` (`policy_id_FK`,`branch_id_FK`) VALUES ";
		for($i=0;$i<count($array);$i++)
		{
			$query.=" ('".$this->policy_id."','".$array[$i]."') ";
			if($i< (count($array)-1) )
				$query.=" , ";
		}
		$db->query($query);
		$db->execute();
	}
	
	
	function generate_policy_ref($policy_department)
	{
		$query="SELECT * FROM `".$this->table_name."` WHERE `policy_department_id_FK`='".$policy_department."' ";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		$total_per_dep=count($result);
		$total_per_dep++;
		$sub_word=$this->return_chars($total_per_dep);
		//$sub_word="hello";
		$query="SELECT * FROM `setup_department` WHERE `department_id`='".$policy_department."'";
		$db->query($query);
		$result=$db->resultset();
		$department_abb=$result[0]["department_abbv"];
		
		$policy_reference="FIVF/".$department_abb."/".$sub_word;
		return $policy_reference;
	}
	
	function return_chars($digit)
	{
		$value=3;
		$string_length	=strlen($digit);
		//echo $string_length;
		
		$remaining		=$value-$string_length;
		$str="";
		
		for($i=0;$i<$remaining;$i++)
		{
			$str.="0";
		}
		
		$str.=$digit;
		return $str;
	}
	
	function unsign_from_branch($policy_id,$branch_id)
	{
		$db=new Database();
		$query="DELETE FROM `pp_policy_has_branch` 
		WHERE `policy_id`='".$policy_id."' AND `branch_id_FK`='".$branch_id."'";
		$db->query($query);
		$db->execute();
	}
	
	function unsign_from_all_branches()
	{
		$db=new Database();
		$query="DELETE FROM `pp_policy_has_branch` WHERE `policy_id_FK`='".$this->policy_id."' ";
		$db->query($query);
		$db->execute();		
	}
	
	function list_av_policies($user_session=NULL)
	{
	 $query="SELECT * FROM `".$this->table_name."` 
	 INNER JOIN `setup_department` ON `department_id`=`policy_department_id_FK`
	 INNER JOIN `pp_policy_chapter` ON `chapter_id`=`policy_chapter_id_FK`
	 INNER JOIN `setup_employee` on `employee_id`=`policy_user_created`
	 INNER JOIN `pp_policy_action_log` ON `pp_policy_action_log`.`tracker_id`=`".$this->table_name."`.`policy_state_id_FK`
	 INNER JOIN `pp_policy_action` ON `pp_policy_action`.`action_id`=`pp_policy_action_log`.`action_id_FK`
	 INNER JOIN `pp_policy_state` ON `pp_policy_state`.`state_id` =`pp_policy_action`.`state_id_FK`
	 ";
	 if(isset($user_session))
		 $query.=" WHERE `policy_user_created`='".$user_session."'";

	 $query.=" ORDER BY `policy_department_id_FK`,`policy_chapter_id_FK`";
	 $db=new Database();
	 $db->query($query);
	 $result=$db->resultset();
	 return $result;
	}
	
	function insert_new_section($section_id,$user_id)
	{
		$db=new Database();
		$query="SELECT * FROM `pp_policy_version_content` WHERE `policy_id_FK`='".$this->policy_id."' ORDER BY `section_order` DESC";
		$db->query($query);
		$result=$db->resultset();
		if(count($result)==0)
			$new_order=1;
		else
			$new_order=($result[0]["section_order"])+1;

		$query="INSERT INTO `pp_policy_version_content` (`policy_id_FK`,`section_id_FK`,`section_content`,`content_date_added`,`content_user_added`,`content_active`,`section_order`) 
		VALUES('".$this->policy_id."','".$section_id."','','".date("Y-m-d H:i:s")."','".$user_id."','1','".$new_order."')";
		//echo $query;
		
		$db->query($query);
		$db->execute();
		
	}
	
	function get_added_sections()
	{
		$db=new Database();
		$query="SELECT * FROM `pp_policy_version_content` INNER JOIN `pp_policy_section` ON `section_id_FK`=`section_id` WHERE `policy_id_FK`='".$this->policy_id."' ORDER BY `section_order` ASC";
		$db->query($query);
		$result=$db->resultset();	
		return $result;	
	}
	
	
	function get_policy_section_details($content_id)
	{
		$db=new Database();
		$query="SELECT * FROM `pp_policy_version_content`
		INNER JOIN `pp_policy_section` ON `section_id_FK`=`section_id`
		WHERE `content_id`='".$content_id."'";
		$db->query($query);
		$result=$db->resultset();
		return $result;
		
	}
	
	function update_policy_section_content($content_id,$content)
	{
		$db=new Database();
		$query="UPDATE `pp_policy_version_content` SET `section_content` = '".$content."' WHERE `content_id`='".$content_id."'";
		$db->query($query);
		$db->execute();
		
	}
	
	function remove_section_from_policy($content_id)
	{
		$db=new Database();
		$query="DELETE FROM `pp_policy_version_content` WHERE `content_id`='".$content_id."'";
		$db->query($query);
		$db->execute();
	}

    function insert_tracker($array,$user_id)
	{
		$db=new Database();
		$query="INSERT INTO `pp_policy_action_log` (`policy_id_FK`,`action_id_FK`,`tracker_comment`,`user_id_FK`) 
		VALUES('".$array["policy_id"]."','".$array["action_id"]."','".$array["text_notification"]."','".$user_id."')";
		$db->query($query);
		$db->execute();
		$inserted_id=$db->lastInsertId();
		return $inserted_id;
	}
	
	function update_policy_state($tracker_id)
	{
		$db=new Database();
		$query="UPDATE `pp_policy` SET `policy_state_id_FK` = '".$tracker_id."' WHERE `policy_id`='".$this->policy_id."'";
		$db->query($query);
		$db->execute();
	}
	
	function insert_into_pending_actions($array,$user_id,$tracker_id)
	{
		$stateObj  	=new policy_state();
		$action_att	=$stateObj->get_action_attributes($array['action_id']);
		$db			=new Database();
		$query		="INSERT INTO `pp_policy_pending_actions` 
		(`policy_id_FK`,`state_id_FK`,`employee_id_FK`,`date_time_inserted`,`user_inserted`,`record_notes`,`tracker_id_FK`) 
		VALUES('".$this->policy_id."','".$action_att[0]["state_id_FK"]."','".$array["employee_id"]."','".date("Y-m-d H:i:s")."','".$user_id."','','".$tracker_id."')";
		$db->query($query);
		$db->execute();
		return $db->lastInsertId();
	}
	
	function get_pending_action_policies($state_id,$employee_id)
	{
		$db			=new Database();
		$query		="SELECT * FROM `pp_policy_pending_actions`
		INNER JOIN `".$this->table_name."` ON `policy_id`=`pp_policy_pending_actions`.`policy_id_FK`
		 INNER JOIN `setup_department` ON `department_id`=`policy_department_id_FK`
		 INNER JOIN `pp_policy_chapter` ON `chapter_id`=`policy_chapter_id_FK`
		 INNER JOIN `setup_employee` on `employee_id`=`policy_user_created`
		 INNER JOIN `pp_policy_action_log` ON `pp_policy_action_log`.`tracker_id`=`".$this->table_name."`.`policy_state_id_FK`
		 INNER JOIN `pp_policy_action` ON `pp_policy_action`.`action_id`=`pp_policy_action_log`.`action_id_FK`
		 INNER JOIN `pp_policy_state` ON `pp_policy_state`.`state_id` =`pp_policy_action`.`state_id_FK`		
		WHERE `record_processed`='0' AND `employee_id_FK`='".$employee_id."'";
		$db->query($query);
		$db->execute();
		return $db->resultset();			
	}
	
	function update_pending_notes($pending_id,$notes)
	{
		$query="UPDATE `pp_policy_pending_actions` SET `record_notes` = '".$notes."' WHERE `pending_id`='".$pending_id."'";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}
	
	function process_pending_record($pending_id)
	{
		$query="UPDATE `pp_policy_pending_actions` SET `record_processed`='1' WHERE `pending_id`='".$pending_id."'";
		$db=new Database();
		$db->query($query);
		$db->execute();
	}
	
	function get_pending_record()
	{
		$query="SELECT * FROM `pp_policy_pending_actions` WHERE `policy_id_FK`='".$this->policy_id."' AND `record_processed`='0'";
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		if(count($result)==0)
			return -1;
		else
		{
			$employee_id=$result[0]["employee_id_FK"];
			return $employee_id;
		}
	}
	
	function get_actions_log()
	{
		$query="SELECT * FROM `pp_policy_action_log` 
		INNER JOIN `pp_policy_action` ON `pp_policy_action`.`action_id` = `pp_policy_action_log`.`action_id_FK`
		INNER JOIN `setup_employee` ON `setup_employee`.`employee_id` = `pp_policy_action_log`.`user_id_FK`
		WHERE `policy_id_FK`='".$this->policy_id."' ORDER BY `date_time_inserted` DESC";
		$db=new Database();
		$db->query($query);
		return $db->resultset();
	}
	
	function notify_employee($message)
	{
		
	}
	
	function swap_sections($array)
	{
		$db=new Database();
		$query="SELECT * FROM `pp_policy_version_content` WHERE `section_id_FK`='".$array['section_id_1']."' AND `policy_id_FK`='".$array['policy_id']."' ";
		$db->query($query);
		$result=$db->resultset();
		$order1=$result[0]["section_order"];

		$query="SELECT * FROM `pp_policy_version_content` WHERE `section_id_FK`='".$array['section_id_2']."' AND `policy_id_FK`='".$array['policy_id']."' ";

		$db->query($query);
		$result=$db->resultset();
		$order2=$result[0]["section_order"];
		
		$query="UPDATE `pp_policy_version_content` SET `section_order`='".$order1."' WHERE `section_id_FK`='".$array['section_id_2']."' AND `policy_id_FK`='".$array['policy_id']."'";

		$db->query($query);
		$db->execute();
		

		
		$query="UPDATE `pp_policy_version_content` SET `section_order`='".$order2."' WHERE `section_id_FK`='".$array['section_id_1']."' AND `policy_id_FK`='".$array['policy_id']."'";
		$db->query($query);
		$db->execute();
		
		
		
		
	}
	
	function get_last_tracker($action_id)
	{
		$db=new Database();
		$query="SELECT * FROM `pp_policy_action_log` 
		INNER JOIN `setup_employee` ON `setup_employee`.`employee_id` = `pp_policy_action_log`.`user_id_FK`
		WHERE `action_id_FK`='".$action_id."' AND `policy_id_FK`='".$this->policy_id."' ORDER BY `pp_policy_action_log`.`date_time_inserted` DESC";
		$db->query($query);
		return $db->resultset();
	}
	function log_view($user_id,$ip_address)
	{
		$db=new Database();
		$query="INSERT INTO `pp_policy_has_view` 
		(`viewer_id_FK`,`policy_id_FK`,`viewer_ip_address`) VALUES('".$user_id."','".$this->policy_id."','".$ip_address."')";
		$db->query($query);
		$db->execute();
	}

	function get_viewers()
	{
		$db=new Database();
		$query="SELECT distinct(`viewer_id_FK`) FROM `pp_policy_has_view` WHERE `policy_id_FK`='".$this->policy_id."'";
		$db->query($query);
		$result=$db->resultset();
		return count($result);;
	}
	
	function get_view_count()
	{
		$db=new Database();
		$query="SELECT * FROM `pp_policy_has_view` WHERE `policy_id_FK`='".$this->policy_id."'";
		$db->query($query);
		$result=$db->resultset();
		return count($result);		
	}

	function get_section($chapter_id){
		$query="SELECT * FROM `pp_policy` WHERE `policy_chapter_id_FK`= '".$chapter_id."' ";
		//echo $query;
		$db=new Database();
		$db->query($query);
		$result=$db->resultset();
		
		return $result;
	}

	

	/*if (isset($_POST["user_name"])) {
		$sql = "SELECT * FROM table WHERE id = '".$_POST["user_name"]."'";
		$result = mysqli_query($connect, $sql);
		if (mysqli_num_rows($result > 0)) {
			# code...
		}
	}*/

}

?>

