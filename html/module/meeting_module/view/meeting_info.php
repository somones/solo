<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../../../../html/lib/model/database.class.php");
require_once("../../../../html/lib/model/item_category.class.php");
require_once("../../../../html/lib/model/company.class.php");
require_once("../../../../html/lib/model/branch.class.php");
require_once("../../../../html/lib/model/employee.class.php");
require_once("../../../../html/lib/model/module.class.php");
require_once("../../../../html/lib/model/menu_item.class.php");
require_once("../../../../html/lib/model/department.class.php");
require_once("../model/room.class.php");
require_once("../model/meeting.class.php");
date_default_timezone_set("Asia/Dubai"); 

$employeeObj=new employee();
$roomObj=new meeting_room();

//$branchObj=new branch();
//print_r($av_branch);

$meetingObj					=new meeting($_POST['meeting_id']);
$meeting_id 				=$meetingObj->meeting_id;
$meeting_title				=$meetingObj->meeting_title;
$meeting_start_date_time	=$meetingObj->meeting_start_date_time;
$meeting_end_date_time		=$meetingObj->meeting_end_date_time;
$meeting_room				=$meetingObj->meeting_room_id_FK;
$meeting_description		=$meetingObj->meeting_description;

$meeting=new meeting();
$meeting_attended = $meeting->attended_per_meeting($meeting_id );
$meeting_abscent = $meeting->abscent_per_meeting($meeting_id );
$av_rooms=$roomObj->get_active_rooms();
$room = $av_rooms[0]['room_title'];
$branch_id = $av_rooms[0]['branch_id_FK'];

$hiDate = new DateTime($meeting_end_date_time);
$loDate = new DateTime($meeting_start_date_time);
$diff = $hiDate->diff($loDate);
$secs = ((($diff->format("%a") * 24) + $diff->format("%H")) * 60 + $diff->format("%i")) * 60 + $diff->format("%s");
//var_dump($meetingObj);
?>
<div class="px-content">
    <div class="page-header">
      <h1><?= $meeting_title; ?></h1>
      <a href='../../../lib/TCPDF/source/download_meeting_info.php?mid=<?php echo $_POST['meeting_id']; ?>' class="pull-right btn btn-primary" target="_blank"><i class="fa fa-print"></i>&nbsp;&nbsp;Print version</a>
    </div>

    <div class="panel">
      	<div class="panel-body p-a-4 b-b-4 bg-white darken">
        	<div class="box m-a-0 border-radius-0 bg-white darken">
	          	<div class="box-row valign-middle">
	            	<div class="box-cell col-md-6">
		              	<div class="display-inline-block px-demo-brand px-demo-brand-lg valign-middle">
		                	<span class="px-demo-logo m-y-0 m-r-2 bg-primary"><span class="px-demo-logo-1"></span><span class="px-demo-logo-2"></span><span class="px-demo-logo-3"></span><span class="px-demo-logo-4"></span><span class="px-demo-logo-5"></span><span class="px-demo-logo-6"></span><span class="px-demo-logo-7"></span><span class="px-demo-logo-8"></span><span class="px-demo-logo-9"></span></span>
		              	</div>

		              	<div class="display-inline-block m-r-3 valign-middle">
		                	<div class="text-muted"><strong><?= $room ?></strong></div>
		                	<div class="font-size-18 font-weight-bold line-height-1">Document: <?= "mom-".$meeting_id ?></div>
		              	</div>

		              	<!-- Spacer -->
		              	<div class="m-t-3 visible-xs visible-sm"></div>

		              	<div class="display-inline-block p-l-1 b-l-3 valign-middle font-size-12 text-muted">
		                	<div></div>
		                	<div>Fakih IVF - Head Quarter</div>
		              	</div>
	            	</div>

	            	<!-- Spacer -->
	            	<div class="m-t-3 visible-xs visible-sm"></div>
		            <div class="box-cell col-md-6">
		              	<div class="pull-md-right font-size-15">
		                	<div class="text-muted font-size-13 line-height-1"><strong>Start Date</strong></div>
		               		<strong><?= $meeting_start_date_time ?></strong>
		              	</div>
		              	<div class="pull-md-right font-size-15">
		                	<div class="text-muted font-size-13 line-height-1"><strong>End Date</strong></div>
		                	<strong><?= $meeting_end_date_time ?></strong>
		              	</div>
		              	<div class="pull-md-right font-size-15">
		                	<div class="text-muted font-size-13 line-height-1"><strong>Duration:</strong></div>
		                	<strong><?= gmdate('H:i:s', $secs); ?></strong>
		              	</div>
		            </div>
	          	</div>
        	</div>

        	<div class="row">
        		<div class="col-lg-12">
        			<hr/>	
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-lg-6">
	              	<div class="display-inline-block m-r-3 valign-middle">
	                	<div class="text-muted"><strong>Checked In Attendees</strong></div>
	              	</div>    			
        			<ol>
        				<?php for($i=0;$i<count($meeting_attended);$i++) { ?>
        				<li><?= $meeting_attended[$i]["employee_full_name"]; ?></li>
        				<?php } ?>
        			</ol>
        		</div>

				<div class="col-lg-6">
	              	<div class="display-inline-block m-r-3 valign-middle">
	                	<div class="text-muted"><strong>Abscent Attendees</strong></div>
	              	</div> 
	                <ol>
        				<?php for($i=0;$i<count($meeting_abscent);$i++) { ?>
        				<li><?= $meeting_abscent[$i]["employee_full_name"]; ?></li>
        				<?php } ?>
        			</ol>	
        		</div>
        	</div>	

<div class="row">
	<div class="col-lg-12" id="meeting_info_div">
		
	</div>
</div>
        	<div class="row">
				<div id="editor">
					<?php
					if(strlen($meetingObj->meeting_mom)==0)
					{
					?>
<p>&nbsp;</p>

<table border="1" cellpadding="1" cellspacing="1" style="height:103px; width:1797px">
	<tbody>
		<tr>
			<td colspan="4" style="background-color:#cccccc; text-align:center"><strong>Decisions</strong></td>
		</tr>
		<tr>
			<td style="background-color:#eeeeee; text-align:center">Desicion Description</td>
			<td style="background-color:#eeeeee; text-align:center; width:300px">Action Required</td>
			<td style="background-color:#eeeeee; text-align:center">Responsible</td>
			<td style="background-color:#eeeeee; text-align:center; width:300px">Traget Date</td>
		</tr>
		<tr>
			<td style="text-align:left; vertical-align:top; width:300px">
			<p>&nbsp;</p>
			</td>
			<td>&nbsp;</td>
			<td style="width:300px">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
			<p>&nbsp;</p>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>

<p>&nbsp;</p>					
					<?php					
					}
					else
					{
					echo $meetingObj->meeting_mom;
					}
					?>
				</div>
        	</div>
			
			
        	<div class="row">
				<div class="col-lg-12" style="text-align:center;margin-top:50px">
					<input type="button" onclick="submit_save_html_content('<?php echo $_POST['meeting_id']; ?>')" class="btn btn-primary" value="Save Minutes of Meetings" />
				</div>
        	</div>			
			
      	</div>
	</div>
</div>