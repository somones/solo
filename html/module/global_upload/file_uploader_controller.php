<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once("../../lib/model/database.class.php");
require_once("../../lib/model/item_category.class.php");
require_once("../../lib/model/company.class.php");
require_once("../../lib/model/branch.class.php");
require_once("../../lib/model/validation.class.php");
require_once("../policy_procedure/model/policy.class.php");
require_once("../human_resouces/pre_employment/model/applicant.class.php");
require_once("../policy_procedure/model/policy_state.class.php");
require_once("../policy_procedure/model/tracker.class.php");
require_once("../../lib/model/uploaded_file.class.php");
require_once("../consent/model/consent_request.class.php");

$result["return_value"]	=0;
$result["return_html"]	="";
$result["success"]		=0;
//print_r($_POST);
if($_POST['action']==1)
{
	$policyObj	=new policy($_POST['policy_id']);
	$file_ext	=array("docx","pdf","docx","jpg","jpeg","xls");
}
else if($_POST['action']==2)
{
	$file_ext	=array("docx","pdf","docx");
}
else if($_POST['action']==3)
{
	$file_ext	=array("docx","pdf","docx");
}
?>
<div class="row">
	<div class="col-lg-12">
		<?php
			
			if ($_FILES["att"]["error"] == UPLOAD_ERR_OK )
			{
					//print_r($_FILES);
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
						$result["return_value"]	=$new_file_id;

						if($_POST['action']==1)
						{
							$policyObj->insert_new_file($new_file_id);
							
						}
						else if($_POST['action']==2)
						{
							//print_r($_POST);
							if($_POST['applicant_id'] <> -1)
							{
								$applicantObj=new applicant($_POST['applicant_id']);
								$applicantObj->assign_new_file($new_file_id);
							}
						}

						else if($_POST['action']==3)
						{
							//print_r($_POST);
							if($_POST['consent_request_id'] <> -1)
							{
								$applicantObj=new consent_request($_POST['consent_request_id']);
								$applicantObj->assign_new_file($new_file_id);
							}
						}
						
						if(move_uploaded_file($_FILES["att"]["tmp_name"],"../../assets/uploads/".$uploadObj->file_new_name.".".$uploadObj->file_extension))
						{
							$result["return_html"]	="<div class='alert alert-success'>File Uploaded successfully</div>";
							$result["success"]		=1	;					
						}
						else
						{
							$result["return_html"]	="<div class='alert alert-danger'>Contact Administrator.</div>";
							$result["success"]		=0	;								
						}
					}
					else
					{
						$result["return_html"]	="<div class='alert alert-danger'>Not recognizing DOC files</div>";
						$result["success"]	=0;
					}
					
			}
			else
			{
				$result["return_html"]	="<div class='alert alert-danger'>Check Errors , Error Code:".$_FILES["att"]["error"]."</div>";
				$result["success"]	=0;				
			}
			echo "<input type='hidden' id='uploader_return_value' value='".$result["return_value"]."' >
			      <input type='hidden' id='uploader_success' value='".$result["success"]."'>";
			echo $result["return_html"];
		?>
	</div>
</div>
