<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/validation.class.php");
require_once("../../../../html/lib/model/sms.class.php");
require_once("../../../../html/lib/model/email.class.php");

require_once("../model/distribution_list.class.php");
require_once("../model/contact.class.php");
require_once("../model/distribution_list_type.class.php");
require_once("../model/messages.class.php");

if($_POST['action']==1) 
{
	if($_POST['list_id']==-1)
	{
		$branch_id_FK 	 					=trim($_POST["branch_id_FK"]);
		$list_name 	 						=trim($_POST["list_name"]);
		$list_description	 				=trim($_POST["list_description"]);
		$list_type_id_FK	 				=trim($_POST["list_type_id_FK"]);

		$billing_itemObj					=new distribution_list();

		$val=new Validation();
			
		$val->setRules("branch_id_FK","List Branch is a required Field.",array("required"));
		$val->setRules("list_type_id_FK","List Type is a required Field.",array("required"));
		$val->setRules("list_name","List Name is a required Field.",array("required"));
		$val->setRules("list_description","List Description is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->branch_id_FK  			=$branch_id_FK;
			$billing_itemObj->list_name      			=$list_name;
			$billing_itemObj->list_description 			=$list_description;
			$billing_itemObj->list_type_id_FK 			=$list_type_id_FK;

			$list_id	            =$billing_itemObj->insert_new_distribution_list($_SESSION['employee_id']);
			
			$result["success"]		=1;
			$result["return_value"]	=$list_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		$branch_id_FK 	 					=trim($_POST["branch_id_FK"]);
		$list_name 	 						=trim($_POST["list_name"]);
		$list_description	 				=trim($_POST["list_description"]);
		$list_type_id_FK	 				=trim($_POST["list_type_id_FK"]);

		$billing_itemObj					=new distribution_list();

		$val=new Validation();

		$val->setRules("branch_id_FK","List Branch is a required Field.",array("required"));
		$val->setRules("list_type_id_FK","List Type is a required Field.",array("required"));
		$val->setRules("list_name","List Name is a required Field.",array("required"));
		$val->setRules("list_description","List Description is a required Field.",array("required"));
		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->branch_id_FK        		=$branch_id_FK;
			$billing_itemObj->list_name             	=$list_name;
			$billing_itemObj->list_description 			=$list_description;
			$billing_itemObj->list_type_id_FK 			=$list_type_id_FK;

			$billing_itemObj->update_this_distribution_list($_POST['list_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['list_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
	echo json_encode($result);	
} 
else if($_POST['action']==2)
{
	$item_categoryObj	=new distribution_list();
	$item_categoryObj->delete_this_distribution_list($_POST['list_id']);
} else if($_POST['action']==3) {
	$contactObj=new distribution_list($_POST['list_id']);	
	$contactObj->delete_contact_from_list();
	$contactObj->add_contact_to_list($_POST['array']);
	echo "<div class='alert alert-success'>Well Done</div>";
	
} 
elseif ($_POST['action']==4) 
{
	if ($_POST['distribution_list_type'] == 0) {
		//---------------------------------------------------------------------------------------
		$receiver_number 	 				=trim($_POST["receiver_number"]);
		$message_subject 	 				=trim($_POST["message_subject"]);
		$message_content	 				=trim($_POST["message_content"]);
		$message_type_id_FK	 				=trim($_POST["message_type_id_FK"]);
		$val								=new Validation();
		if($message_type_id_FK==1)
		{
			$term_t="Email";
		}
		else if($message_type_id_FK==2)
		{
			$term_t="SMS";
		}
		
		$val->setRules("receiver_number","Receiver Number is a required Field.",array("required"));
		$val->setRules("message_subject",$term_t." Subject is a required Field.",array("required"));
		$val->setRules("message_content",$term_t." Content is a required Field.",array("required"));

		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			echo $val->draw_errors_list(1);
		}
		else
		{
			$contacts_list=explode(";",$receiver_number);
			$list=array();
			for($i=0;$i<count($contacts_list);$i++)
			{
				array_push($list,$contacts_list[$i]);
				$messageObj=new messages();
				$messageObj->insert_new_message($message_subject,$message_content,0,$message_type_id_FK,$contacts_list[$i],$_SESSION['employee_id']);
			}
			$smsObj = new sms();
			if ($_POST['arabic_text']== 1) {
				echo $smsObj->send_sms("unicode",$message_content,$list);
			} else {
				echo $smsObj->send_sms("text",$message_content,$list);
			}
			 ?>
			}
			<div id="modal-sizes-3" class="modal fade in" tabindex="-1" role="dialog" style="display: block;width:100%" aria-hidden="false" >
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo $term_t." "; ?>Processed Successfully</h4>
						</div>
						<div class="modal-body">
						<div class="row">
							<div class="col-lg-12">
								<?php
									echo $val->draw_success_chart($term_t." Processed Successfully",1);
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<button type="button" class="btn btn-primary" onclick="get_new_email_form('<?php echo $_POST['message_type_id_FK'] ?>','<?php echo $_POST['message_distribution_id_FK'] ?>','<?php echo $_POST['menu_id']; ?>')">Main Menu</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php }
		//---------------------------------------------------------------------------------------
	} else {
		//---------------------------------------------------------------------------------------
		$message_distribution_id_FK 	 	=trim($_POST["message_distribution_id_FK"]);
		$message_subject 	 				=trim($_POST["message_subject"]);
		$message_content	 				=trim($_POST["message_content"]);
		$message_type_id_FK	 				=trim($_POST["message_type_id_FK"]);
		$messageObj							=new messages();
		$val								=new Validation();

		$distribution_listObj = new distribution_list(); 
		$branch_id = $distribution_listObj->get_branch_id($message_distribution_id_FK);

		if($message_type_id_FK==1)
		{
			$term_t="Email";
		}
		else if($message_type_id_FK==2)
		{
			$term_t="SMS";
		}
		
		$val->setRules("message_distribution_id_FK","Distribution List is a required Field.",array("required"));
		$val->setRules("message_subject",$term_t." Subject is a required Field.",array("required"));
		$val->setRules("message_content",$term_t." Content is a required Field.",array("required"));

		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			echo $val->draw_errors_list(1);
		}
		else
		{
			$messageObj->message_distribution_id_FK  			=$message_distribution_id_FK;
			$messageObj->message_subject      					=$message_subject;
			$messageObj->message_content 						=$message_content;
			$messageObj->message_type_id_FK 					=$message_type_id_FK;
			$messageObj->process_sending($_SESSION['employee_id'],$branch_id['branch_id_FK'],$_POST['arabic_text']); ?>
			<div id="modal-sizes-3" class="modal fade in" tabindex="-1" role="dialog" style="display: block;width:100%" aria-hidden="false" >
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo $term_t." "; ?>Processed Successfully</h4>
						</div>
						<div class="modal-body">
						<div class="row">
							<div class="col-lg-12">
								<?php
									echo $val->draw_success_chart($term_t." Processed Successfully",1);
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<button type="button" class="btn btn-primary" onclick="get_new_email_form('<?php echo $_POST['message_type_id_FK'] ?>','<?php echo $_POST['message_distribution_id_FK'] ?>','<?php echo $_POST['menu_id']; ?>')">Main Menu</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php }
		//---------------------------------------------------------------------------------------
	}
}  
elseif ($_POST['action']==5) {
	//print_r($_POST);
	if($_POST['type_id']==-1)
	{
		$list_type_name 	 						=trim($_POST["list_type_name"]);
		$list_type_description 	 					=trim($_POST["list_type_description"]);;

		$billing_itemObj							=new distribution_list_type();

		$val=new Validation();
			
		$val->setRules("list_type_name","List Name is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->list_type_name  					=$list_type_name;
			$billing_itemObj->list_type_description      		=$list_type_description;

			$type_id	            =$billing_itemObj->insert_new_distribution_list_type($_SESSION['employee_id']);
			$email_id 	= $billing_itemObj->insert_new_email_category_item($list_type_name,$type_id);
			$sms_id 	= $billing_itemObj->insert_new_sms_category_item($list_type_name,$type_id);
			
			$result["success"]		=1;
			$result["return_value"]	=$type_id;
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
 
	else
	{
		$list_type_name 	 						=trim($_POST["list_type_name"]);
		$list_type_description 	 					=trim($_POST["list_type_description"]);

		$billing_itemObj							=new distribution_list_type();

		$val=new Validation();

		$val->setRules("list_type_name","List Name is a required Field.",array("required"));
		
		if(!$val->validate())
		{
			$result["success"]		=0;
			$result["return_value"]	=-1;
			$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->list_type_name        		=$list_type_name;
			$billing_itemObj->list_type_description         =$list_type_description;

			$billing_itemObj->update_this_distribution_list_type($_POST['type_id']);
			$result["success"]		=1;
			$result["return_value"]	=$_POST['type_id'];
			$result["return_html"]	=$val->draw_success_chart("Role added Successfully",1);
		}
	}
	echo json_encode($result);	
} else if($_POST['action']==6) {
	$item_categoryObj	=new distribution_list_type();
	$item_categoryObj->delete_this_distribution_list_type($_POST['type_id']);
} elseif ($_POST['action']==7) {
	if($_POST['list_id']==-1)
	{	//print_r($_POST);
		$message_distribution_id_FK 	 	=trim($_POST["message_distribution_id_FK"]);
		$message_subject 	 				=trim($_POST["message_subject"]);
		$message_content	 				=trim($_POST["message_content"]);
		$message_type_id_FK	 				=trim($_POST["message_type_id_FK"]);

		$billing_itemObj					=new messages();

		$val=new Validation();
		
		$val->setRules("message_distribution_id_FK","Distribution List is a required Field.",array("required"));
		$val->setRules("message_subject","Message Subject is a required Field.",array("required"));
		$val->setRules("message_content","Message Content is a required Field.",array("required"));

		if(!$val->validate())
		{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
		}
		else
		{
			$billing_itemObj->message_distribution_id_FK  			=$message_distribution_id_FK;
			$billing_itemObj->message_subject      					=$message_subject;
			$billing_itemObj->message_content 						=$message_content;
			$billing_itemObj->message_type_id_FK 					=$message_type_id_FK;

			$list_id	            =$billing_itemObj->insert_new_sms($_SESSION['employee_id']);
			$sms_item_id 			=$billing_itemObj->list_of_sms_user($message_distribution_id_FK,$message_subject,$message_content);
			
			$result["success"]		=1;
			$result["return_value"]	=1;
			$result["return_html"]	=$val->draw_success_chart("Message Send and Saved Successfully",1);
		}
	}
	echo json_encode($result);
} elseif ($_POST['action']==8) {
	if($_POST['message_type_id_FK']==1)
	{
		$term_t="Email";
	}
	else if($_POST['message_type_id_FK']==2)
	{
		$term_t="SMS";
	}
	$val=new Validation();
	if (isset($_POST['receiver_number'])) {
		$val->setRules("receiver_number","Receiver Number is a required Field.",array("required"));
	}
	if (isset($_POST['message_distribution_id_FK'])) {
		$val->setRules("message_distribution_id_FK","Distribution List is a required Field.",array("required"));
	}
	$val->setRules("message_subject",$term_t." Subject is a required Field.",array("required"));
	$val->setRules("message_content",$term_t." Content is a required Field.",array("required"));

	if(!$val->validate())
	{
		$result["success"]		=0;
		$result["return_value"]	=-1;
		$result["return_html"]	=$val->draw_errors_list(1);
	}else {
		$result["success"]		=1;
		$result["return_value"]	=1;
		$result["return_html"]	=$val->draw_success_chart("Added",1);
	}
	echo json_encode($result);
}
?>