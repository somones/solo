<?php
session_start();
if(!isset($_GET['room_id']))
{

  die("Room ID is required");
}
else
 $room_id=$_GET['room_id'];

require_once("../../../lib/model/database.class.php");
require_once("../../../lib/model/company.class.php");
require_once("../../../lib/model/employee.class.php");
require_once("../../../lib/model/department.class.php");
require_once("../../../lib/model/branch.class.php");
require_once("../../../lib/model/module.class.php");
require_once("../../../lib/model/item_category.class.php");
require_once("../../../lib/model/template.inc.php");
require_once("../../meeting_module/model/meeting.class.php");

$meeting = new meeting();
$current_date_time= date("Y-m-d H:i:s");
$current_meeting = $meeting->current_meeting($room_id);
$next_meeting = $meeting->next_meeting($room_id);

$templateObj  =new template('../../../../html/');
$templateObj->start_head();

$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$lastUriSegment = array_pop($uriSegments);
?>
<title>Meeting Screen</title>
    <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <!--<meta http-equiv="refresh" content="50000000" />-->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">
  <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
  <!-- Core stylesheets -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/pixeladmin.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/widgets.min.css" rel="stylesheet" type="text/css">
  <!-- Theme -->
  <link href="../assets/css/themes/clean.min.css" rel="stylesheet" type="text/css">
  <!-- Pace.js -->
  <script src="../assets/pace/pace.min.js"></script>
  <!-- jQuery.NumPad -->
  <script src="../assets/js/jquery.numpad.js"></script>
  <link rel="stylesheet" href="../assets/css/jquery.numpad.css">
  <script type="text/javascript">
      // Set NumPad defaults for jQuery mobile. 
      // These defaults will be applied to all NumPads within this document!
      $.fn.numpad.defaults.gridTpl = '<table class="table modal-content"></table>';
      $.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in"></div>';
      $.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" />';
      $.fn.numpad.defaults.buttonNumberTpl =  '<button type="button" class="btn btn-default"></button>';
      $.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="width: 100%;"></button>';
      $.fn.numpad.defaults.onKeypadCreate = function(){$(this).find('.done').addClass('btn-primary');};
      // Instantiate NumPad once the page is ready to be shown
      $(document).ready(function(){
        $('#checkin_code').numpad();
      });
    </script>
    <style type="text/css">
      .nmpd-grid {border: none; padding: 20px;}
      .nmpd-grid>tbody>tr>td {border: none;}
      /* Some custom styling for Bootstrap */
      .qtyInput {display: block;
        width: 100%;
        padding: 6px 12px;
        color: #555;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
      }
    </style>
  <!-- Custom styling -->
  <style>
  .demo-item {
    padding: 30px;
  }
  .demo-item h4 {
    margin: 0;
  }
  </style>
<script type="text/javascript" src="../assets/JS/screen.js"/></script>
<?php
$templateObj->close_head();
//$templateObj->start_body($_GET['module']);

?>

<div id="sub-content-wrapper" style="margin-top:-30px !important">
</div>
<div id="main-menu-bg"></div>

<?php
$templateObj->close_body();
?>


<div id="modal_default" class="modal fade" tabindex="-1" role="dialog" style="display: none;width:100%">
</div>
<div id="security_form_div"></div>
<?php if(count($current_meeting)>0){ ?>
<div class="page-wide-block">
  <div class="box border-radius-0 bg-success" style="height: 100vh;">

<div class="box-cell col-lg-12 p-a-4 bg-danger darken">
<div class="col-lg-8">
  <span class="font-size-17 font-weight-light"><strong>Meeting</strong></span></br>
  <span class="font-size-17 font-weight-light"><?php echo $current_meeting['0']["meeting_title"]; ?></span>
</div>
<div class="col-lg-8">
  <span class="font-size-17 font-weight-light"><strong>Room</strong></span></br>
  <span class="font-size-17 font-weight-light"><?php echo $current_meeting['0']["room_title"]; ?></span>
</div>
<div class="col-lg-4">
  <span class="font-size-17 font-weight-light"><strong>Until</strong></span></br>
  <span class="font-size-17 font-weight-light"><?php echo $current_meeting['0']["meeting_end_date_time"]; ?></span>
</div>
<div style="font-size: 96px;"><strong>BOOKED</strong></div>
<div style="font-size: 26px; text-align: justify;">Check in</div>
<!-- Chart -->
<div class="p-t-4">
  <div class="form-group" >
    <div class="col-md-12" style="padding-bottom: 10px;">
      <input type="number" name="code" class="form-control" id="checkin_code" placeholder="Enter a number" required>
    </div>
          <!-- here buttons of chck in -->
    <div class="col-md-12">
      <button type="button" name="submit" value="Submit" class="btn btn-lg btn-warning btn-block" onclick="check_code()"><strong>CHECK IN</strong></button>
    </div>
  </div>
</div>
</div>
<?php } else{ ?>

<div class="page-wide-block">
<!-- here we will choose also the color of the Room success info danger warning -->
<div class="box border-radius-0 bg-success" style="height: 100vh;">
  <!-- Revenue -->
  <div class="box-cell col-lg-12 p-a-4 bg-success darken"> 
    <div class="col-lg-8">
      <span class="font-size-17 font-weight-light"><strong>Room</strong></span></br>
      <span class="font-size-17 font-weight-light"></span>
    </div>
    <div style="font-size: 96px;"><strong>AVAILABLE</strong></div>
    <!-- Chart -->
  </div>
  <?php } ?>
<!-- ------------------------NEXXT MEETING-------------------------------------------------->
<hr class="m-a-0 visible-xs visible-sm">
    <!-- Expenses -->
    <div class="box-cell col-lg-6 p-a-12">
      <div style="font-size: 46px;">Next Meeting</div>
      <div class="p-t-4">
        <div id="owl-carousel-auto-width" class="owl-carousel">
          <?php
          if(count($next_meeting) > 0){
            for($i=0;$i<count($next_meeting);$i++) { ?>
          <div class="demo-item bg-primary" style="width:100%">
              <strong>Title: </strong><?php echo $next_meeting[$i]["meeting_title"]; ?>
              <br>
              <strong>At: </strong><?php echo $next_meeting[$i]["meeting_start_date_time"]; ?>
          </div>
        <?php } 
      } else {?>
        </div>
        <strong>There </strong>is No Next Meeting
      <?php } ?>
      </div>
    </div>
</div>
</div>

<!-- Content -------------------------------------------------------------------------->
  <!-- Core scripts -->
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="../assets/js/pixeladmin.min.js"></script>
  <!-- Your scripts -->
  <script src="../assets/js/app.js"></script>
  <script>
    // Initialize Owl Carousel
    $('#owl-carousel-with-loop').owlCarousel({
      center: true,
      items:  1,
      loop:   true,
      margin: 10,
      responsive: {
        600: { items: 4 },
      },

        rtl: $('html').attr('dir') === 'rtl',
      });

      $('#owl-carousel-auto-width').owlCarousel({
        margin:    10,
        loop:      true,
        autoWidth: true,
        items:     1,

        rtl: $('html').attr('dir') === 'rtl',
      });
  </script>
</body>
</html>