<?php
session_start();

require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/employee.class.php");
require_once("../../../../../html/lib/model/module.class.php");
require_once("../../../../../html/lib/model/menu_item.class.php");
require_once("../../../../../html/lib/model/department.class.php");
require_once("../model/role.class.php");
$roleObj=new role($_POST['role_id']);
$av_items	=$roleObj->get_role_menu_items();
$module=new module();
$av_modules=$module->get_all_modules();
?>
<div class="page-header">
    <div class="row">
		<h1>
			<i class="page-header-icon ion-ios-pulse-strong"></i>&nbsp;&nbsp;<?php echo $roleObj->role_name; ?>
		</h1>		
	</div>
</div>

<div class="row">
	<div class="col-lg-12">

		<div class="panel-body">
			<ul id="uidemo-tabs-default-demo" class="nav nav-tabs">
			<?php
			
			for($i=0;$i<count($av_modules);$i++)
			{
				
			?>
				<li class="<?php if($i==0) { echo "active"; } ?>">
					<a href="#tabs-<?php echo $av_modules[$i]["module_id"]; ?>" data-toggle="tab"><?php echo $av_modules[$i]["module_name"];?></a>
				</li>
			<?php
			}
			?>
			</ul>
			<div class="tab-content tab-content-bordered">

		<?php
			$counter=0;
			for($i=0;$i<count($av_modules);$i++)
			{
				$thismoduleObj=new module($av_modules[$i]["module_id"]);
				$av_categories=$thismoduleObj->get_all_menu_item_categories();	
			?>
				<div class="tab-pane fade <?php if($i==0) { echo "active in"; } ?>" id="tabs-<?php echo $av_modules[$i]["module_id"]; ?>">
					<ul>
					<?php
					
					for($j=0;$j<count($av_categories);$j++)
					{
						$categoryObj=new item_category($av_categories[$j]["category_id"]);
						$menu_items=$categoryObj->get_all_menu_items();
						?>
						<li><input type="checkbox" id="<?php echo $counter; ?>" />&nbsp;<?php echo $av_categories[$j]["category_name"]; ?></li>
						<ul>
						<?php
						for($m=0;$m<count($menu_items);$m++)
						{
							?>
							<li><input <?php if(in_array($menu_items[$m]["item_id"],$av_items)) echo "checked='checked'"; ?> type="checkbox" value="<?php echo $menu_items[$m]["item_id"]; ?>" id="menu_item_checkbox_<?php echo $counter; ?>" /><?php echo $counter; ?>&nbsp;<?php echo $menu_items[$m]["item_title"]; ?>	
							<?php
							$counter++;
						}
						?>
						</ul>
						<?php
					}
					?>
					</ul>
				</div>
			<?php
			}
			?>
			</div>



				
			</div>
		</div>
		
		<div class="panel-body">
			<div class="col-lg-12" style="text-align:center">
				<input type="button" value="Submit Changes" class="btn btn-primary" onclick="submit_save_permissions('<?php echo $counter ?>','<?php echo $_POST['role_id']; ?>')"/>
			</div>
		</div>	

		<div class="panel-body">
			<div class="col-lg-12" id="permissions_div">
			</div>
		</div>
		
		
	</div>
</div>


	