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

//Local Classes
require_once("../model/applicant.class.php");
require_once("../model/country.class.php");
require_once("../model/personal_title.class.php");
require_once("../model/marital_status.class.php");
require_once("../model/visa_type.class.php");
require_once("../model/position.class.php");
require_once("../model/availability_type.class.php");
require_once("../model/profession.class.php");
require_once("../model/education.class.php");
require_once("../model/board.class.php");

$countryObj = new country();
$country_obj = $countryObj->list_of_countries();

$titleObj = new title();
$title_obj = $titleObj->list_of_titles();

$maritalObj = new marital_status();
$marital_obj = $maritalObj->list_of_marital_status();

$visaObj = new visa_type();
$visa_obj = $visaObj->list_of_visa();

$positionObj = new position();
$position_obj = $positionObj->list_of_positions();

$availabilityObj = new availability_type();
$availability_obj = $availabilityObj->list_of_availability_type();

$profissionObj = new profission();
$profission_obj = $profissionObj->list_of_professions();

$educationObj = new education_level();
$education_obj = $educationObj->list_of_education_level();

$boardObj = new board();
$board_obj = $boardObj->list_of_boards();


if(isset($_POST['applicant_id']))
    $applicant_id=$_POST['applicant_id'];
else
    $applicant_id=-1;
  
if($applicant_id==-1)
{
  $applicant_title__id_FK                 ="";
  $applicant_first_name                   ="";
  $applicant_last_name                    ="";
  $applicant_suffix                       ="";
  $applicant_email                        ="";
  $applicant_phone_number                 ="";
  $applicant_nationality_id_FK            ="";
  $applicant_citizen_id_FK                ="";
  $applicant_marital_status_FK            ="";
  $applicant_residency_FK                 ="";
  $applicant_visa_type_FK                 ="";
  $applicant_current_employment_status    ="";
  $applicant_current_employment_poistion  ="";
  $applicant_current_employer_text        ="";
  $applicant_applying_position_id_FK      ="";
  $applicant_availibility_FK              ="";
  $applicant_profession_FK                ="";
  $applicant_speciality                   ="";
  $applicant_education_level_FK           ="";
  $applicant_institution_name             ="";
  $applicant_board_certified_id_FK        ="";
  $applicant_hold_haad_license            ="";
  $applicant_hold_dha_license             ="";
  $applicant_contact_reference            ="";
  $applicant_available_start_date         ="";
  $applicant_cv_id_FK                     ="";
}
else
{
  $applicantObj=new applicant($applicant_id);
  
  $applicant_title__id_FK                 =$applicantObj->applicant_title__id_FK;
  $applicant_first_name                   =$applicantObj->applicant_first_name;
  $applicant_last_name                    =$applicantObj->applicant_last_name;
  $applicant_suffix                       =$applicantObj->applicant_suffix;
  $applicant_email                        =$applicantObj->applicant_email;
  $applicant_phone_number                 =$applicantObj->applicant_phone_number;
  $applicant_nationality_id_FK            =$applicantObj->applicant_nationality_id_FK;
  $applicant_citizen_id_FK                =$applicantObj->applicant_citizen_id_FK;
  $applicant_marital_status_FK            =$applicantObj->applicant_marital_status_FK;
  $applicant_residency_FK                 =$applicantObj->applicant_residency_FK;
  $applicant_visa_type_FK                 =$applicantObj->applicant_visa_type_FK;
  $applicant_current_employment_status    =$applicantObj->applicant_current_employment_status;
  $applicant_current_employment_poistion  =$applicantObj->applicant_current_employment_poistion;
  $applicant_current_employer_text        =$applicantObj->applicant_current_employer_text;
  $applicant_applying_position_id_FK      =$applicantObj->applicant_applying_position_id_FK;
  $applicant_availibility_FK              =$applicantObj->applicant_availibility_FK;
  $applicant_profession_FK                =$applicantObj->applicant_profession_FK;
  $applicant_speciality                   =$applicantObj->applicant_speciality;
  $applicant_education_level_FK           =$applicantObj->applicant_education_level_FK;
  $applicant_institution_name             =$applicantObj->applicant_institution_name;
  $applicant_board_certified_id_FK        =$applicantObj->applicant_board_certified_id_FK;
  $applicant_hold_haad_license            =$applicantObj->applicant_hold_haad_license;
  $applicant_hold_dha_license             =$applicantObj->applicant_hold_dha_license;
  $applicant_contact_reference            =$applicantObj->applicant_contact_reference;
  $applicant_available_start_date         =$applicantObj->applicant_available_start_date;
  $applicant_cv_id_FK                     =$applicantObj->applicant_cv_id_FK;
}
?>
<title>Applicant Form</title>
    <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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

<script type="text/javascript" src="../assets/JS/human_ressource.js"/></script>
<script type="text/javascript" src="../assets/JS/employment_request.js"/></script>
<?php
//$templateObj->close_head();
//$templateObj->start_body($_GET['module']);

?>

<div id="sub-content-wrapper" style="margin-top:-30px !important">
</div>
<div id="main-menu-bg"></div>

<?php
//$templateObj->close_body();
?>




<!-- Content -------------------------------------------------------------------------->
<div class="panel">
  <div class="page-header">
    <div class="row">
        <div class="col-md-4 text-xs-center text-md-left text-nowrap">
          <h1><i class="page-header-icon ion-ios-pulse-strong"></i>Add/ Edit Applicant</h1>
        </div>
    </div>
</div>
<div class="panel-body">
    <form class="form-horizontal">
      <div class="form-group">
        <label for="grid-input-1" class="col-md-3 control-label">Full Name</label>
        <div class="col-md-9">
          <div class="col-md-2">
          <select class="form-control" id="applicant_title__id_FK">
            <option value="" selected="selected">Select...</option>
              <?php for($i=0;$i<count($title_obj);$i++) { ?>
                <option <?php if($title_obj[$i]["personal_id"] == $applicant_title__id_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $title_obj[$i]["personal_id"]; ?>"><?php echo $title_obj[$i]["personal_title"]; ?></option>
              <?php } ?>
          </select>
          </div>
          <div class="col-md-4">
            <input type="text" class="form-control" id="applicant_first_name" value="<?php echo $applicant_first_name; ?>" placeholder="Fisrt Name">
          </div>
          <div class="col-md-4">
            <input type="text" class="form-control" id="applicant_last_name" value="<?php echo $applicant_last_name; ?>" placeholder="Last Name">
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control" id="applicant_suffix" value="<?php echo $applicant_suffix; ?>" placeholder="Suffix">
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Email</label>
        <div class="col-md-9">
          <input type="email" class="form-control" id="applicant_email" value="<?php echo $applicant_email; ?>" placeholder="Email">
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Phone Number</label>
        <div class="col-md-9">
          <input type="text" class="form-control" id="applicant_phone_number" value="<?php echo $applicant_phone_number; ?>" placeholder="Phone Number">
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Nationality</label>
        <div class="col-md-9">
          <select class="form-control" id="applicant_nationality_id_FK">
            <option value="" selected="selected">Select...</option>
              <?php for($i=0;$i<count($country_obj);$i++) { ?>
                <option <?php if($country_obj[$i]["country_id"] == $applicant_nationality_id_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $country_obj[$i]["country_id"]; ?>"><?php echo $country_obj[$i]["country_name"]; ?></option>
              <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Citizenship</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_citizen_id_FK">
            <option value="" selected="selected">Select...</option>
              <?php for($i=0;$i<count($country_obj);$i++) { ?>
                <option <?php if($country_obj[$i]["country_id"] == $applicant_citizen_id_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $country_obj[$i]["country_id"]; ?>"><?php echo $country_obj[$i]["country_name"]; ?></option>
              <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Marital Status</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_marital_status_FK">
            <option value="" selected="selected">Select...</option>
              <?php for($i=0;$i<count($marital_obj);$i++) { ?>
                <option <?php if($marital_obj[$i]["marital_status_id"] == $applicant_marital_status_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $marital_obj[$i]["marital_status_id"]; ?>"><?php echo $marital_obj[$i]["marital_status_title"]; ?></option>
              <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">In which country are you currently residing? *</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_residency_FK">
            <option value="" selected="selected">Select...</option>
              <?php for($i=0;$i<count($country_obj);$i++) { ?>
                <option <?php if($country_obj[$i]["country_id"] == $applicant_residency_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $country_obj[$i]["country_id"]; ?>"><?php echo $country_obj[$i]["country_name"]; ?></option>
              <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Do you have a UAE Visa?</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_visa_type_FK" onchange="if ($(this).val()==-1){this.form['other_visa_type'].style.visibility='visible'}else {this.form['other_visa_type'].style.visibility='hidden'};">
            <option value="" selected="selected">Select...</option>
            <option value="-1">Other</option>
              <?php for($i=0;$i<count($visa_obj);$i++) { ?>
                <?php if ($visa_obj[$i]["display_to_all"] == '1') { ?> 
                <option <?php if($visa_obj[$i]["type_id"] == $applicant_visa_type_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $visa_obj[$i]["type_id"]; ?>"><?php echo $visa_obj[$i]["type_title"]; ?></option>
                <?php } ?>
              <?php } ?>
          </select>
          <small>If your choice is not in the list , Click on Other and enter it</small>
        </div>
        
        <label for="grid-input-3" class="col-md-3 control-label"></label>
        <div class="col-md-9">
          <input class="form-control" type="textbox" id="other_visa_type" name="other_visa_type" style="visibility:hidden;"/>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Are you currently employed?</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_hold_dha_license">
            <option value="" selected="selected">Select...</option>
            <option value="1"
            <?php if ($applicant_current_employment_status == 1) {
              echo "selected";
            } ?>
            >YES</option>
            <option value="0"
            <?php if ($applicant_current_employment_status == 0) {
              echo "selected";
            } ?>
            >NO</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Current Position</label>
        <div class="col-md-9">
          <input type="text" class="form-control" id="applicant_current_employment_poistion" value="<?php echo $applicant_current_employment_poistion; ?>" placeholder="Current Position">
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Current Employer</label>
        <div class="col-md-9">
          <input type="text" class="form-control" id="applicant_current_employer_text" value="<?php echo $applicant_current_employer_text; ?>" placeholder="Current Employer">
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">What position are you applying for?</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_applying_position_id_FK" onchange="if ($(this).val()==-1){this.form['other_position'].style.visibility='visible'}else {this.form['other_position'].style.visibility='hidden'};">
            <option value="" selected="selected">Select...</option>
            <option value="-1">Other</option>
              <?php for($i=0;$i<count($position_obj);$i++) { ?>
                <?php if ($position_obj[$i]["position_display_to_all"] == '1') { ?>
                <option <?php if($position_obj[$i]["position_id"] == $applicant_applying_position_id_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $position_obj[$i]["position_id"]; ?>"><?php echo $position_obj[$i]["position_title"]; ?></option>
                <?php } ?>
              <?php } ?>
          </select>
          <small>If your choice is not in the list , Click on Other and enter it</small>
        </div>
        
        <label for="grid-input-3" class="col-md-3 control-label"></label>
        <div class="col-md-9">
          <input class="form-control" type="textbox" id="other_position" name="other_position" style="visibility:hidden;"/>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Please indiate your availability</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_availibility_FK">
            <option value="" selected="selected">Select...</option>
              <?php for($i=0;$i<count($availability_obj);$i++) { ?>
                <option <?php if($availability_obj[$i]["availability_type_id"] == $applicant_availibility_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $availability_obj[$i]["availability_type_id"]; ?>"><?php echo $availability_obj[$i]["availability_type_name"]; ?></option>
              <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">What is your profession?</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_profession_FK" onchange="if ($(this).val()==-1){this.form['other_profession'].style.visibility='visible'}else {this.form['other_profession'].style.visibility='hidden'};">
            <option value="" selected="selected">Select...</option>
            <option value="-1">Other</option>
              <?php for($i=0;$i<count($profission_obj);$i++) { ?>
                <?php if ($profission_obj[$i]["profession_display_to_all"] == '1') { ?>
                <option <?php if($profission_obj[$i]["profession_id"] == $applicant_profession_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $profission_obj[$i]["profession_id"]; ?>"><?php echo $profission_obj[$i]["profession_title"]; ?></option>
                <?php } ?>
              <?php } ?>
          </select>
          <small>If your choice is not in the list , Click on Other and enter it</small>
        </div>
        
        <label for="grid-input-3" class="col-md-3 control-label"></label>
        <div class="col-md-9">
          <input class="form-control" type="textbox" id="other_profession" name="other_profession" style="visibility:hidden;"/>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">What is your specialty / field?</label>
        <div class="col-md-9">
          <input type="text" class="form-control" id="applicant_speciality" value="<?php echo $applicant_speciality; ?>" placeholder="Speciality">
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Indicate your Highest Education</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_education_level_FK">
            <option value="" selected="selected">Select...</option>
              <?php for($i=0;$i<count($education_obj);$i++) { ?>
                <option <?php if($education_obj[$i]["education_level_id"] == $applicant_education_level_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $education_obj[$i]["education_level_id"]; ?>"><?php echo $education_obj[$i]["education_level_title"]; ?></option>
              <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Name of Education Institution</label>
        <div class="col-md-9">
          <input type="text" class="form-control" id="applicant_institution_name" value="<?php echo $applicant_institution_name; ?>" placeholder="Institution Name">
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Are you Board Certified</label>
        <div class="col-md-9">
          <select class="form-control" id="applicant_board_certified_id_FK" onchange="if ($(this).val()==-1){this.form['other_board'].style.visibility='visible'}else {this.form['other_board'].style.visibility='hidden'};">
            <option value="" selected="selected">Select...</option>
            <option value="-1">Other</option>
              <?php for($i=0;$i<count($board_obj);$i++) { ?>
                <?php if ($board_obj[$i]["display_to_all"] == '1') { ?>
                <option <?php if($board_obj[$i]["board_id"] == $applicant_board_certified_id_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $board_obj[$i]["board_id"]; ?>"><?php echo $board_obj[$i]["board_name"]; ?></option>
                <?php } ?>
              <?php } ?>
          </select>
          <small>If your choice is not in the list , Click on Other and enter it</small>
        </div>
        
        <label for="grid-input-3" class="col-md-3 control-label"></label>
        <div class="col-md-9">
          <input class="form-control" type="textbox" id="other_board" name="other_board" style="visibility:hidden;"/>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Do you hold a DHA license?</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_hold_dha_license">
            <option value="" selected="selected">Select...</option>
            <option value="1"
            <?php if ($applicant_hold_dha_license == 1) {
              echo "selected";
            } ?>
            >YES</option>
            <option value="0"
            <?php if ($applicant_hold_dha_license == 0) {
              echo "selected";
            } ?>
            >NO</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Do you hold a HAAD license?</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_hold_haad_license">
            <option value="" selected="selected">Select...</option>
            <option value="1"
            <?php if ($applicant_hold_haad_license == 1) {
              echo "selected";
            } ?>>YES</option>
            <option value="0"
            <?php if ($applicant_hold_haad_license == 0) {
              echo "selected";
            } ?>>NO</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Contact References</label>
        <div class="col-md-9">
          <textarea class="form-control" id="applicant_contact_reference"><?php echo $applicant_contact_reference; ?></textarea>
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">What date are you available to start work? *</label>
        <div class="col-md-9">
          <input type="text" class="form-control" id="applicant_available_start_date" value="<?php echo $applicant_available_start_date; ?>">
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-6" class="col-md-3 control-label">Upload Your CV</label>
        <div class="col-md-9">
          <label class="custom-file px-file" for="grid-input-6">
    <input type="button" class="btn btn-primary" onclick="upload_new_file('applicant_id','<?php echo $applicant_id; ?>','2','../','applicant_cv_id_FK')" value="Add new File"/>
    <input type="text" id="applicant_cv_id_FK" value="<?php echo $applicant_cv_id_FK; ?>">
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-md-offset-3 col-md-12">
            <button type="button" class="btn btn-primary col-md-9" onclick="submit_save_applicant('<?php echo $applicant_id; ?>')">Save</button>
          </div>
      </div>

      <div id="applicant_op_div"></div>
    </form>
  </div>
</div>





















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