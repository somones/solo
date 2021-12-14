<?php

class uploaded_file
{
	public $table_name="setup_uploads";
	
	
	
	function __Construct($upload_id=NULL)
	{
		if(isset($upload_id))
		{
			$this->upload_id=$upload_id;
			$this->build_object();			
		}
	}
	
	function build_object()
	{
		$db		=new Database();
		$query	="SELECT * FROM `".$this->table_name."` 
	    INNER JOIN `setup_employee` on `employee_id`=`file_user_uploaded`
		WHERE `upload_id`=:upload_id";
		$db->query($query);
		$db->bind("upload_id",$this->upload_id);
		$result			=$db->resultset();
		$facility_prop	=$result[0];
		foreach ($facility_prop as $key => $value) 
			$this->$key=$value;				
	}	
	
	function encrypt_file_name($file_name,$user_id)
	{
		$time_value=strtotime(Date("Y-m-d H:i:s"));
		$new_name=$user_id."-".$time_value;
		return $new_name;
	}
	
	function insert_new_file()
	{
		$db=new Database();
		$query="INSERT INTO `setup_uploads` (`file_original_name`,`file_display_name`,`file_new_name`,`file_extension`,`file_size`,`file_date_uploaded`,`file_user_uploaded`)
		VALUES('".$this->file_original_name."','".$this->file_display_name."','".$this->file_new_name."','".$this->file_extension."','".$this->file_size."','".$this->file_date_uploaded."','".$this->file_user_uploaded."')";
		$db->query($query);
		$db->execute();
		return $db->lastInsertId();
	}
}	
	
?>	