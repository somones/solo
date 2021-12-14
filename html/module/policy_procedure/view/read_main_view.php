<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();
if(!isset($_SESSION['employee_id']))
{
	header("location:../../../../");
}
require_once("../../../lib/model/database.class.php");
require_once("../../../lib/model/company.class.php");
require_once("../../../lib/model/employee.class.php");
require_once("../../../lib/model/module.class.php");
require_once("../../../lib/model/item_category.class.php");
require_once("../../../lib/model/template.inc.php");
require_once("../model/policy_chapter.class.php");
require_once("../model/policy.class.php");
require_once("../model/policy_section.class.php");
require_once("../model/policy_state.class.php");
require_once("../model/tracker.class.php");
if(isset($_GET['pp']))
	$policy_id=$_GET['pp'];
if(isset($_POST['policy_id']))
	$policy_id=$_POST['policy_id'];

$companyObj				=new company(1);
$policyObj				=new policy($policy_id);

$policy_sections		=$policyObj->get_added_sections();

$revision_data			=$policyObj->get_last_tracker(3);
$approval_data			=$policyObj->get_last_tracker(4);
$templateObj 			=new template('../../../../html/');
$templateObj->start_head("Preview Policy");
?>
<script type="text/javascript" src="../assets/JS/pp.js"></script>
<!--

<script src="../Lib/ckeditor/ckeditor.js"></script>
<script src="../Lib/ckeditor/samples/js/sample.js"></script>
<link rel="stylesheet" href="../Lib/ckeditor/samples/css/samples.css">
<link rel="stylesheet" href="../Lib/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
-->
<?php
$templateObj->close_head();

?>
<body>
<?php
$allowed_to_view=0;
if($policyObj->policy_control_type_id_FK==2)
{
  if(isset($_GET['auth_token']))
  {
	if(urldecode($_GET['auth_token'])== $policyObj->policy_control_password)
	{
		$allowed_to_view=1;
	}
  }	
}
else
{
$allowed_to_view=1;	
}	
if($allowed_to_view==1)
{
	$policyObj->log_view($_SESSION['employee_id'],$_SERVER['REMOTE_ADDR']);
?>
<div id="modal-sizes-3" class="modal fade in" tabindex="-1" role="dialog" style="display: block;width:100%" aria-hidden="false" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"><?php echo $policyObj->policy_title;  ?></h4>
			</div>
			<div class="modal-body">
			
			
<div class="row">
	<div class="col-lg-12" style="background-color:#10678c">
		<img src="../../../../html/assets/images/logo-full.png" style="width:180px" />
	</div>
</div>
<div class="row">

	<div class="col-lg-12" style="border-bottom:1px solid #e1e1e1">
		<div class="col-lg-5" style="text-align:left">
			<?php echo $policyObj->chapter_title; ?>
		</div>
		<div class="col-lg-6" style="text-align:right">
			<?php echo $companyObj->company_name; ?>
		</div>
	</div>
	
</div>

<div class="row">
	<div class="col-lg-12">
		<table width="100%" border="1">
			<tr>
				<td>
					 Document ID<br/>
					 <b><?php echo $policyObj->policy_ref_number; ?></b>
				</td>
				<td>
					Title<br/>
					<b><?php echo $policyObj->policy_title; ?></b>
				</td>
				<td>
					Print Date<br/>
					<b><?php echo Date("Y-m-d H:i:s"); ?></b>
				</td>				
			</tr>
			
			<tr>
				<td>
					&nbsp;
				</td>
				<td>
					Prepared By<br/>
					<b><?php echo $policyObj->employee_full_name; ?></b>
				</td>
				<td>
					Date Prepared<br/>
					<b><?php echo $policyObj->policy_date_created; ?></b>
				</td>				
			</tr>	

			<tr>
				<td>
					 &nbsp;
				</td>
				<td>
					Reviewed By<br/>
					 <b>
					 <?php 
					 if(count($revision_data)>0)
						 echo $revision_data[0]["employee_full_name"];
					 else
						 echo "Not Yet Reviewed";
					 ?>
					 </b>
				</td>
				<td>
					Date Reviewed<br/>
					 <b>
					 <?php 
					 if(count($revision_data)>0)
						 echo $revision_data[0]["date_time_inserted"];
					 else
						 echo "Not Yet Reviewed";
					 ?>
					 </b>				
				</td>				
			</tr>	
			
			<tr>
				<td>
					&nbsp;
				</td>
				<td>
					Approved By<br/>
					 <b>
					 <?php 
					 if(count($approval_data)>0)
						 echo $approval_data[0]["employee_full_name"];
					 else
						 echo "Not Yet Reviewed";
					 ?>
					 </b>					
				</td>
				<td>
					Date Approved<br/>
					 <b>
					 <?php 
					 if(count($approval_data)>0)
						 echo $approval_data[0]["date_time_inserted"];
					 else
						 echo "Not Yet Reviewed";
					 ?>
					 </b>	
				</td>				
			</tr>	
			<tr>
				<td colspan="2">&nbsp;</td>
				<td><b>Next Revision</b><br><?php echo substr($policyObj->policy_revision_date,0,10); ?></td>
			</tr>
			
			<tr>
				<td colspan="3">
					<b>Standard:</b>
				</td>
			</tr>
			
		</table>
		<?php	
		?>
	</div>
</div>

<div class="row">
<ol>
<?php 
for($i=0;$i<count($policy_sections);$i++)
{
?>
	<li style="font-size:18px"><?php echo $policy_sections[$i]["section_title"]; ?></li>
	<div class="col-lg-12">
		<?php 
			echo $policy_sections[$i]["section_content"];
		?>
	</div>
<?php	
}
?>	
</ol>
</div>			
			
			
			
			</div>
		</div>
	</div>
</div>
<?php
}
else
{
?>	
<div id="modal-sizes-3" class="modal fade in" tabindex="-1" role="dialog" style="display: block;width:100%" aria-hidden="false" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"><?php echo $policyObj->policy_title;  ?></h4>
			</div>
			<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">	
							<div class="form-group">
								<label class="label-control">Enter Authorization password</label>
								<input type="password" class="form-control" id="auth_token" />
								<input type="hidden" value="<?php echo $_GET['pp'] ?>" name="pp" />
							</div>
							
							<div class="form-group">
								<input type="button" class="btn btn-primary" value="Submit" onclick="on_password_entry('<?php echo $_GET['pp']; ?>')" />
							</div>						
						</div>	
					</div>
			</div>
		</div>
	</div>
</div>
<?php	
}
?>




</body>

<script type="text/javascript">
function on_password_entry(policy_id)
{
	var pass=$('#auth_token').val();
	var encoded_str=encodeURIComponent(pass);
	//alert(encoded_str);
	str="read_main_view.php?pp="+policy_id+"&auth_token="+encoded_str;
	//var res = encodeURIComponent(str);
	//alert(res);
	window.location.replace(str);
}

$(document).ready(function () {
    //Disable full page
    $("body").on("contextmenu",function(e){
        return false;
    });
    
    //Disable part of page
    $("#id").on("contextmenu",function(e){
        return false;
    });
	
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
    
    //Disable part of page
    $('#id').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });
	
});
</script>