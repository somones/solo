<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../model/policy.class.php");
require_once("../model/policy_state.class.php");
require_once("../model/tracker.class.php");
require_once("../model/uploaded_file.class.php");
$policyObj	=new policy($_POST['policy_id']);
?>
<div class="row">
	<div class="col-lg-12">
		<?php
			print_r($_POST);
			$file_ext		=array("docx","pdf","docx","jpg","jpeg","xls");
			if ($_FILES["att"]["error"] == UPLOAD_ERR_OK )
			{
					$uploadObj	=new uploaded_file();
					$file_name_parts=explode(".",$_FILES["att"]["name"]);
					
					if(in_array($file_name_parts[count($file_name_parts)-1],$file_ext))
					{
						$uploadObj->file_original_name		=$file_name_parts[0];
						$uploadObj->file_display_name 		=$file_name_parts[0];
						$uploadObj->file_new_name	  		=$uploadObj->encrypt_file_name($file_name_parts[0],$_SESSION['employee_id']);
						$uploadObj->file_extension	  		=$file_name_parts[count($file_name_parts)-1];
						$uploadObj->file_size		  		=$_FILES["att"]["size"];
						$uploadObj->file_date_uploaded		=Date("Y-m-d H:i:s");
						$uploadObj->file_user_uploaded		=$_SESSION['employee_id'];
						$new_file_id=$uploadObj->insert_new_file();
						$policyObj->insert_new_file($new_file_id);
						if(move_uploaded_file($_FILES["att"]["tmp_name"],"../../../assets/uploads/".$uploadObj->file_new_name.".".$uploadObj->file_extension))
							echo "<div class='alert alert-success'>File Uploaded successfully</div>";
						else
							echo "<div class='alert alert-danger'>Could not upload File.</div>";					
					}
					else
					{
						echo "<div class='alert alert-danger'>File Type not supported</div>";
					}
					
			}
			else
			{
				echo "<div class='alert alert-danger'>Check Errors , Error Code:".$_FILES["att"]["error"]."</div>";
			}
			//$max_file_size	=
		?>
	</div>
</div>
