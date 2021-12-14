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
$employeeObj=new employee();
$roomObj=new meeting_room();
$av_rooms=$roomObj->get_active_rooms();
$av_employee=$employeeObj->get_active_employee();



	$meetingObj					=new meeting($_POST['meeting_id']);
	$meeting_id 				=$meetingObj->meeting_id;
	$meeting_title				=$meetingObj->meeting_title;
	$meeting_start_date_time	=$meetingObj->meeting_start_date_time;
	$meeting_end_date_time		=$meetingObj->meeting_end_date_time;
	$meeting_room				=$meetingObj->meeting_room_id_FK;
	$meeting_description		=$meetingObj->meeting_description;
	//$emploiyees                 =$meetingsObj->employee;
	$meeting_attendees			=$meetingObj->get_meeting_attendee();
	//print_r($meeting_attendees);
	//$meeting_attendees			=$meetingObj->get_meeting_attendee();

?>
<div class="page-header">
    <div class="row">
        <div class="col-md-4 text-xs-center text-md-left text-nowrap">
          <h1><i class="page-header-icon ion-ios-pulse-strong"></i>Edit Meeting</h1>
        </div>
    </div>
</div>
<div>
	<div class="panel">
	  <div class="panel-body">
	    <form class="form-horizontal" method="post" action=""> 
	      	<div class="form-group">
	        	<label for="grid-input-1" class="col-md-3 control-label">Title</label>
	        	<div class="col-md-9">
	          		<input type="text" class="form-control" id="meeting_title" value="<?= $meeting_title ?>" placeholder="Title of Meeting">
	        	</div>
	      	</div>
		<div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label">ROOM</label>
			<div class="col-md-9">
				<select class="form-control" id="meeting_room">
					<option value=""></option>
					<?php for($i=0;$i<count($av_rooms);$i++) { ?>
						<option <?php if($meeting_room==$av_rooms[$i]["room_id"]) {  ?> selected="selected" <?php  } ?> value="<?php echo $av_rooms[$i]["room_id"]; ?>"><?php echo $av_rooms[$i]["room_title"]; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

	    <div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label">Start Date</label>
			<div class="col-md-9">
				<input type="text" value="<?= $meeting_start_date_time ?>" class="form-control" name="date_time_value" id="meeting_start_date_time">
			</div>		
		</div>

		<div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label">End Date</label>
			<div class="col-md-9">
				<input type="text" value="<?= $meeting_end_date_time ?>" class="form-control" name="date_time_value" id="meeting_end_date_time">
			</div>		
		</div>

	    <div class="form-group">
			<label for="grid-input-1" class="col-md-3 control-label" >Attendees</label>
			<div class="col-md-9">
				<select class="form-control select2-example" id="meeting_attendees" multiple style="width: 100%">
					<?php for($i=0;$i<count($av_employee);$i++) { ?>
		            <option <?php if(in_array($av_employee[$i]["employee_id"],$meeting_attendees)){  ?> selected="selected"   <?php } ?> value="<?php echo $av_employee[$i]["employee_id"]; ?>"><?php echo $av_employee[$i]["employee_full_name"]; ?></option>
		            <?php } ?>
		        </select>
			</div>
		</div>

		<div class="form-group">
	        <label for="grid-input-1" class="col-md-3 control-label">Description</label>
	        <div class="col-md-9">
	         <textarea id="meeting_description" class="form-control" placeholder="Meeting Description"><?= $meeting_description ?></textarea>
	        </div>
	    </div>

	    <div class="form-group">
	        <div class="col-md-offset-3 col-md-9">
	          <button type="button" class="btn btn-primary" onclick="submit_edit_meeting('<?php echo $meeting_id; ?>')">Update</button>
	        </div>
	   	</div>
	    </form>
	  </div>
	</div>
</div>

<script>

    // Initialize Select2

    $(function() {
      $('.select2-example').select2({
        placeholder: 'Select value',
      });
    });
/*
    // -------------------------------------------------------------------------
    // Initialize Dropzone

    $(function() {
      $('#dropzonejs').dropzone({
        parallelUploads: 2,
        maxFilesize:     50,
        filesizeBase:    1000,

        resize: function(file) {
          return {
            srcX:      0,
            srcY:      0,
            srcWidth:  file.width,
            srcHeight: file.height,
            trgWidth:  file.width,
            trgHeight: file.height,
          };
        },
      });

      // Mock the file upload progress (only for the demo)
      //
      Dropzone.prototype.uploadFiles = function(files) {
        var minSteps         = 100;
        var maxSteps         = 60;
        var timeBetweenSteps = 100;
        var bytesPerStep     = 100000;
        var isUploadSuccess  = Math.round(Math.random());

        var self = this;

        for (var i = 0; i < files.length; i++) {

          var file = files[i];
          var totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));

          for (var step = 0; step < totalSteps; step++) {
            var duration = timeBetweenSteps * (step + 1);

            setTimeout(function(file, totalSteps, step) {
              return function() {
                file.upload = {
                  progress: 100 * (step + 1) / totalSteps,
                  total: file.size,
                  bytesSent: (step + 1) * file.size / totalSteps
                };

                self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
                if (file.upload.progress == 100) {

                  if (isUploadSuccess) {
                    file.status =  Dropzone.SUCCESS;
                    self.emit('success', file, 'success', null);
                  } else {
                    file.status =  Dropzone.ERROR;
                    self.emit('error', file, 'Some upload error', null);
                  }

                  self.emit('complete', file);
                  self.processQueue();
                }
              };
            }(file, totalSteps, step), duration);
          }
        }
      };
    });
	*/
  </script>