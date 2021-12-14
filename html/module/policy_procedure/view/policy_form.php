<?php
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");

require_once("../../../../html/lib/model/employee.class.php");
require_once("../../../../html/lib/model/module.class.php");
require_once("../../../../html/lib/model/menu_item.class.php");
require_once("../model/policy_chapter.class.php");
require_once("../model/policy.class.php");
require_once("../model/policy_state.class.php");
require_once("../model/tracker.class.php");

require_once("../../../../html/lib/model/department.class.php");
if(isset($_POST['menu_id']))
{
	$menu_itemObj		=new menu_item($_POST['menu_id']);
	$page_title			=$menu_itemObj->item_title;
}
else
{
	$page_title			="Change Policy Properties";
}


$policy_chapterObj	=new policy_chapter();
$av_chapters		=$policy_chapterObj->get_active_chapters();
$deparmtnetObj		=new department();
$av_department		=$deparmtnetObj->get_active_departments();
$branchObj			=new branch();
$av_branches		=$branchObj->get_active_branches();
if(isset($_POST['policy_id']))
{
	$thisPolicyObj	=new policy($_POST['policy_id']);
	$this_p_title	=$thisPolicyObj->policy_title;
	$this_p_desc	=$thisPolicyObj->policy_description;
	$this_p_chapter	=$thisPolicyObj->policy_chapter_id_FK;
	$this_p_dept	=$thisPolicyObj->policy_department_id_FK;
	$this_p_ed		=substr($thisPolicyObj->policy_effective_date,0,10);
	$this_p_rd		=substr($thisPolicyObj->policy_revision_date,0,10);
	$this_control_type=$thisPolicyObj->policy_control_type_id_FK;
	$policy_control_password=$thisPolicyObj->policy_control_password;
	$branches		=$thisPolicyObj->branches;
	
	
	$tracker_id				=$thisPolicyObj->policy_state_id_FK;
	$trackerObj				=new policy_tracker($tracker_id);
	$tracker_state			=$trackerObj->get_tracker_state();
	$pStateObj				=new policy_state($tracker_state[0]["state_id_FK"]);
	$av_actions				=$pStateObj->get_state_actions();	
	$read_only				=$pStateObj->read_only;
}
else
{
	$this_p_title		="";
	$this_p_desc		="";
	$this_p_chapter		="";
	$this_p_dept		="";
	$this_p_ed			="";
	$this_p_rd			="";	
	$this_control_type	="";
	$policy_control_password="";
	$branches		=array();
	$read_only				=0;	
}

?>
<div class="page-header">
    <div class="row">
        <div class="col-md-4 text-xs-center text-md-left text-nowrap">
          <h1><i class="page-header-icon ion-ios-pulse-strong"></i><?php echo $page_title; ?></h1>
        </div>
    </div>
</div>
<div class="col-lg-12" id="policy_div">
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel-body">
			<div class="form-group">
					<label class="label-control">Policy Title</label>
					<input type="text" class="form-control" id="policy_title" value="<?php echo $this_p_title; ?>">
			</div>		
			
			<div class="form-group">
					<label class="label-control">Policy Description</label>
					<textarea type="text" class="form-control" id="policy_description"><?php echo $this_p_desc; ?></textarea>
			</div>		

			<div class="form-group">
					<label class="label-control">Policy Chapter</label>
					<select class="form-control" id="policy_chapter">
						<option value=""></option>
						<?php
						for($i=0;$i<count($av_chapters);$i++)
						{
							?>
							<option <?php if($this_p_chapter==$av_chapters[$i]["chapter_id"]) {  ?> selected="selected" <?php  } ?> value="<?php echo $av_chapters[$i]["chapter_id"]; ?>"><?php echo $av_chapters[$i]["chapter_title"]; ?></option>
							<?php
						}
						?>
					</select>
			</div>	
			
			<div class="form-group">
					<label class="label-control">Department</label>
					<select class="form-control" id="policy_department">
						<option value=""></option>
						<?php
						for($i=0;$i<count($av_department);$i++)
						{
							?>
							<option  <?php if($this_p_dept==$av_department[$i]["department_id"]) {  ?> selected="selected" <?php  } ?>  value="<?php echo $av_department[$i]["department_id"]; ?>"><?php echo $av_department[$i]["department_title"]; ?></option>
							<?php
						}
						?>
					</select>
			</div>	
			
			<div class="form-group">
					<label class="label-control" >Branch applied for</label>
					<select class="form-control" id="policy_branch"  multiple="multiple" size="8">
						<?php
						for($i=0;$i<count($av_branches);$i++)
						{
							?>
							<option <?php if(in_array($av_branches[$i]["branch_id"],$branches)){  ?> selected="selected"   <?php } ?> value="<?php echo $av_branches[$i]["branch_id"]; ?>"><?php echo $av_branches[$i]["branch_name"]; ?></option>
							<?php
						}
						?>
					</select>
			</div>			

			<div class="form-group">
					<label class="label-control">Effective Date</label>
					<input type="text" value="<?php echo $this_p_ed; ?>" class="form-control" name="date_value" id="policy_effective_date">
			</div>

			<div class="form-group">
					<label class="label-control">Revision Date</label>
					<input type="text" class="form-control" value="<?php echo $this_p_rd; ?>" name="date_value" id="policy_revision_date">
			</div>
			
			<div class="form-group" onchange="disable_enable_password_field()">
					<label class="label-control">Policy Control Type</label>
					<select class="form-control" id="policy_control_type">
						<option value=""></option>
						<option value="1" <?php if($this_control_type==1) {  ?>selected="selected"<?php  } ?>>Public</option>
						<option value="2" <?php if($this_control_type==2) {  ?>selected="selected"<?php  } ?>>Controlled with Password</option>
					</select>
			</div>	

			<div class="form-group">
					<label class="label-control">Policy Password</label>
					<input class="form-control" type="password" value="<?php echo $policy_control_password; ?>" id="policy_control_password" disabled="disabled">
			</div>				
		<?php
				//if($read_only==0)
				//{
					if(isset($_POST['policy_id']))
						$policy_id=$_POST['policy_id'];
					else
						$policy_id=-1;
		?>		
			<div class="col-md-offset-6 col-md-6">
              <button type="submit" class="btn btn-primary" onclick="submit_save_policy('<?php echo $policy_id; ?>')">Submit</button>
            </div>
		<?php
				//}
			?>
		</div>
		
	</div>
	
</div>


<?php
?>