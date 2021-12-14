<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once("../../../../../html/lib/model/database.class.php");
require_once("../../../../../html/lib/model/item_category.class.php");
require_once("../../../../../html/lib/model/company.class.php");
require_once("../../../../../html/lib/model/branch.class.php");
require_once("../../../../../html/lib/model/employee.class.php");
require_once("../../../../../html/lib/model/module.class.php");
require_once("../../../../../html/lib/model/menu_item.class.php");
require_once("../../../../../html/lib/model/department.class.php");
require_once("../../../../../html/lib/model/template.inc.php");

//Local Classes
require_once("../model/applicant_license.class.php");
require_once("../model/applicant.class.php");
require_once("../model/country.class.php");
require_once("../model/personal_title.class.php");
require_once("../model/marital_status.class.php");
require_once("../model/visa_type.class.php");
require_once("../model/employment_request.class.php");
require_once("../model/availability_type.class.php");
require_once("../model/profession.class.php");
require_once("../model/education.class.php");
require_once("../model/board.class.php");

if (isset($_GET['source'])) {
  $source = $_GET['source'];
} else {
  $source = 0;
}
$source = $_GET['source'];
if(isset($_GET['source']) && $_GET['source']==2)
{
	$str="";
	
		$path_to_assets="../../../../";
		$str='<!DOCTYPE html>';
		$str.='<head>';
		$str.='<meta charset="utf-8">';
		$str.='<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
		$str.='<title>Applicant</title>';
		$str.='<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">';
		$str.='<link href="'.$path_to_assets.'assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">';
		$str.='<link href="'.$path_to_assets.'assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">';
		$str.='<link href="'.$path_to_assets.'assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">';
		$str.='<link href="'.$path_to_assets.'assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">';
		$str.='<link href="'.$path_to_assets.'assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">';
		$str.='<link href="'.$path_to_assets.'assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">';
		$str.='<link href="'.$path_to_assets.'assets/stylesheets/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">';
		$str.='<link href="'.$path_to_assets.'assets/stylesheets/ribbon.css" rel="stylesheet" type="text/css">';

		
		$str.='<!--[if lt IE 9]>';
		$str.='<script src="'.$path_to_assets.'assets/javascripts/ie.min.js"></script>';
		$str.='<![endif]-->';
		$str.='<script src="'.$path_to_assets.'assets/javascripts/jquery.min.js"></script>';
		$str.='<script src="'.$path_to_assets.'assets/javascripts/bootstrap.min.js"></script>';
		$str.='<script src="'.$path_to_assets.'assets/javascripts/pixel-admin.min.js"></script>';
		$str.='<script src="'.$path_to_assets.'assets/javascripts/jquery.mockjax.js"></script>';
		$str.='<script src="'.$path_to_assets.'assets/javascripts/demo-mock.js"></script>';

		$str.='<script src="'.$path_to_assets.'assets/javascripts/jquery.autocomplete.js"></script>';
		$str.='<script src="'.$path_to_assets.'assets/javascripts/bootstrap-datetimepicker.min.js"></script>';
		$str.='<script src="'.$path_to_assets.'assets/js/composer.js"></script>';	
		$str.='<script src="'.$path_to_assets.'lib/CKLIB/ckeditor.js"></script>';
		$str.='<script src="'.$path_to_assets.'lib/CKLIB/js/sample.js"></script>';
		$str.='<script src="'.$path_to_assets.'assets/javascripts/common.js"></script>';
		$str.='<script src="'.$path_to_assets.'lib/CKLIB/js/sample.js"></script>';
		$str.='<script src="'.$path_to_assets.'assets/JS/human_ressource.js"></script>';

		echo $str; ?>
    
    <script type="text/javascript" src="../assets/JS/human_ressource.js"/></script>
    <script type="text/javascript" src="../assets/JS/employment_request.js"/></script>
<?php
}




$countryObj = new country();
$country_obj = $countryObj->list_of_countries();

$titleObj = new title();
$title_obj = $titleObj->list_of_titles();

$maritalObj = new marital_status();
$marital_obj = $maritalObj->list_of_marital_status();

$visaObj = new visa_type();
$visa_obj = $visaObj->list_of_visa();

$positionObj = new employment_request();
$position_obj = $positionObj->list_of_employment_requests();

$availabilityObj = new availability_type();
$availability_obj = $availabilityObj->list_of_availability_type();

$profissionObj = new profission();
$profission_obj = $profissionObj->list_of_professions();

$educationObj = new education_level();
$education_obj = $educationObj->list_of_education_level();

$boardObj = new board();
$board_obj = $boardObj->list_of_boards();

$applicant_licenseObj  = new applicant_license();
$applicant_license_Obj = $applicant_licenseObj->get_active_license();


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
  $applicant_llicense_id_FK               =array();
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
  $applicant_llicense_id_FK               = $applicantObj->get_applicant_license($_POST['applicant_id']);

  $file = $applicantObj->get_applicant_file($applicant_cv_id_FK);
}
  
?>
<div class="panel">
  <div class="page-header">
    <div class="row">
        <div class="col-md-4 text-xs-center text-md-left text-nowrap">
          <h1><i class="page-header-icon ion-ios-pulse-strong"></i>Add New Applicant</h1>
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
            <input type="text" class="form-control" id="applicant_first_name" value="<?php echo $applicant_first_name; ?>" placeholder="First Name">
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
        <div class="col-md-3">
          <select class="form-control" name="countryCode" id="countryCode">
          <option value="">Select ...</option>
          <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
          <optgroup label="Other countries">
            <option data-countryCode="DZ" value="213">Algeria (+213)</option>
            <option data-countryCode="AD" value="376">Andorra (+376)</option>
            <option data-countryCode="AO" value="244">Angola (+244)</option>
            <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
            <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
            <option data-countryCode="AR" value="54">Argentina (+54)</option>
            <option data-countryCode="AM" value="374">Armenia (+374)</option>
            <option data-countryCode="AW" value="297">Aruba (+297)</option>
            <option data-countryCode="AU" value="61">Australia (+61)</option>
            <option data-countryCode="AT" value="43">Austria (+43)</option>
            <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
            <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
            <option data-countryCode="BH" value="973">Bahrain (+973)</option>
            <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
            <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
            <option data-countryCode="BY" value="375">Belarus (+375)</option>
            <option data-countryCode="BE" value="32">Belgium (+32)</option>
            <option data-countryCode="BZ" value="501">Belize (+501)</option>
            <option data-countryCode="BJ" value="229">Benin (+229)</option>
            <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
            <option data-countryCode="BT" value="975">Bhutan (+975)</option>
            <option data-countryCode="BO" value="591">Bolivia (+591)</option>
            <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
            <option data-countryCode="BW" value="267">Botswana (+267)</option>
            <option data-countryCode="BR" value="55">Brazil (+55)</option>
            <option data-countryCode="BN" value="673">Brunei (+673)</option>
            <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
            <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
            <option data-countryCode="BI" value="257">Burundi (+257)</option>
            <option data-countryCode="KH" value="855">Cambodia (+855)</option>
            <option data-countryCode="CM" value="237">Cameroon (+237)</option>
            <option data-countryCode="CA" value="1">Canada (+1)</option>
            <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
            <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
            <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
            <option data-countryCode="CL" value="56">Chile (+56)</option>
            <option data-countryCode="CN" value="86">China (+86)</option>
            <option data-countryCode="CO" value="57">Colombia (+57)</option>
            <option data-countryCode="KM" value="269">Comoros (+269)</option>
            <option data-countryCode="CG" value="242">Congo (+242)</option>
            <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
            <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
            <option data-countryCode="HR" value="385">Croatia (+385)</option>
            <option data-countryCode="CU" value="53">Cuba (+53)</option>
            <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
            <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
            <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
            <option data-countryCode="DK" value="45">Denmark (+45)</option>
            <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
            <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
            <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
            <option data-countryCode="EC" value="593">Ecuador (+593)</option>
            <option data-countryCode="EG" value="20">Egypt (+20)</option>
            <option data-countryCode="SV" value="503">El Salvador (+503)</option>
            <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
            <option data-countryCode="ER" value="291">Eritrea (+291)</option>
            <option data-countryCode="EE" value="372">Estonia (+372)</option>
            <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
            <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
            <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
            <option data-countryCode="FJ" value="679">Fiji (+679)</option>
            <option data-countryCode="FI" value="358">Finland (+358)</option>
            <option data-countryCode="FR" value="33">France (+33)</option>
            <option data-countryCode="GF" value="594">French Guiana (+594)</option>
            <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
            <option data-countryCode="GA" value="241">Gabon (+241)</option>
            <option data-countryCode="GM" value="220">Gambia (+220)</option>
            <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
            <option data-countryCode="DE" value="49">Germany (+49)</option>
            <option data-countryCode="GH" value="233">Ghana (+233)</option>
            <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
            <option data-countryCode="GR" value="30">Greece (+30)</option>
            <option data-countryCode="GL" value="299">Greenland (+299)</option>
            <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
            <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
            <option data-countryCode="GU" value="671">Guam (+671)</option>
            <option data-countryCode="GT" value="502">Guatemala (+502)</option>
            <option data-countryCode="GN" value="224">Guinea (+224)</option>
            <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
            <option data-countryCode="GY" value="592">Guyana (+592)</option>
            <option data-countryCode="HT" value="509">Haiti (+509)</option>
            <option data-countryCode="HN" value="504">Honduras (+504)</option>
            <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
            <option data-countryCode="HU" value="36">Hungary (+36)</option>
            <option data-countryCode="IS" value="354">Iceland (+354)</option>
            <option data-countryCode="IN" value="91">India (+91)</option>
            <option data-countryCode="ID" value="62">Indonesia (+62)</option>
            <option data-countryCode="IR" value="98">Iran (+98)</option>
            <option data-countryCode="IQ" value="964">Iraq (+964)</option>
            <option data-countryCode="IE" value="353">Ireland (+353)</option>
            <option data-countryCode="IL" value="972">Israel (+972)</option>
            <option data-countryCode="IT" value="39">Italy (+39)</option>
            <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
            <option data-countryCode="JP" value="81">Japan (+81)</option>
            <option data-countryCode="JO" value="962">Jordan (+962)</option>
            <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
            <option data-countryCode="KE" value="254">Kenya (+254)</option>
            <option data-countryCode="KI" value="686">Kiribati (+686)</option>
            <option data-countryCode="KP" value="850">Korea North (+850)</option>
            <option data-countryCode="KR" value="82">Korea South (+82)</option>
            <option data-countryCode="KW" value="965">Kuwait (+965)</option>
            <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
            <option data-countryCode="LA" value="856">Laos (+856)</option>
            <option data-countryCode="LV" value="371">Latvia (+371)</option>
            <option data-countryCode="LB" value="961">Lebanon (+961)</option>
            <option data-countryCode="LS" value="266">Lesotho (+266)</option>
            <option data-countryCode="LR" value="231">Liberia (+231)</option>
            <option data-countryCode="LY" value="218">Libya (+218)</option>
            <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
            <option data-countryCode="LT" value="370">Lithuania (+370)</option>
            <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
            <option data-countryCode="MO" value="853">Macao (+853)</option>
            <option data-countryCode="MK" value="389">Macedonia (+389)</option>
            <option data-countryCode="MG" value="261">Madagascar (+261)</option>
            <option data-countryCode="MW" value="265">Malawi (+265)</option>
            <option data-countryCode="MY" value="60">Malaysia (+60)</option>
            <option data-countryCode="MV" value="960">Maldives (+960)</option>
            <option data-countryCode="ML" value="223">Mali (+223)</option>
            <option data-countryCode="MT" value="356">Malta (+356)</option>
            <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
            <option data-countryCode="MQ" value="596">Martinique (+596)</option>
            <option data-countryCode="MR" value="222">Mauritania (+222)</option>
            <option data-countryCode="YT" value="269">Mayotte (+269)</option>
            <option data-countryCode="MX" value="52">Mexico (+52)</option>
            <option data-countryCode="FM" value="691">Micronesia (+691)</option>
            <option data-countryCode="MD" value="373">Moldova (+373)</option>
            <option data-countryCode="MC" value="377">Monaco (+377)</option>
            <option data-countryCode="MN" value="976">Mongolia (+976)</option>
            <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
            <option data-countryCode="MA" value="212">Morocco (+212)</option>
            <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
            <option data-countryCode="MN" value="95">Myanmar (+95)</option>
            <option data-countryCode="NA" value="264">Namibia (+264)</option>
            <option data-countryCode="NR" value="674">Nauru (+674)</option>
            <option data-countryCode="NP" value="977">Nepal (+977)</option>
            <option data-countryCode="NL" value="31">Netherlands (+31)</option>
            <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
            <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
            <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
            <option data-countryCode="NE" value="227">Niger (+227)</option>
            <option data-countryCode="NG" value="234">Nigeria (+234)</option>
            <option data-countryCode="NU" value="683">Niue (+683)</option>
            <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
            <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
            <option data-countryCode="NO" value="47">Norway (+47)</option>
            <option data-countryCode="OM" value="968">Oman (+968)</option>
            <option data-countryCode="PW" value="680">Palau (+680)</option>
            <option data-countryCode="PA" value="507">Panama (+507)</option>
            <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
            <option data-countryCode="PY" value="595">Paraguay (+595)</option>
            <option data-countryCode="PE" value="51">Peru (+51)</option>
            <option data-countryCode="PH" value="63">Philippines (+63)</option>
            <option data-countryCode="PL" value="48">Poland (+48)</option>
            <option data-countryCode="PT" value="351">Portugal (+351)</option>
            <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
            <option data-countryCode="QA" value="974">Qatar (+974)</option>
            <option data-countryCode="RE" value="262">Reunion (+262)</option>
            <option data-countryCode="RO" value="40">Romania (+40)</option>
            <option data-countryCode="RU" value="7">Russia (+7)</option>
            <option data-countryCode="RW" value="250">Rwanda (+250)</option>
            <option data-countryCode="SM" value="378">San Marino (+378)</option>
            <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
            <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
            <option data-countryCode="SN" value="221">Senegal (+221)</option>
            <option data-countryCode="CS" value="381">Serbia (+381)</option>
            <option data-countryCode="SC" value="248">Seychelles (+248)</option>
            <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
            <option data-countryCode="SG" value="65">Singapore (+65)</option>
            <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
            <option data-countryCode="SI" value="386">Slovenia (+386)</option>
            <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
            <option data-countryCode="SO" value="252">Somalia (+252)</option>
            <option data-countryCode="ZA" value="27">South Africa (+27)</option>
            <option data-countryCode="ES" value="34">Spain (+34)</option>
            <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
            <option data-countryCode="SH" value="290">St. Helena (+290)</option>
            <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
            <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
            <option data-countryCode="SD" value="249">Sudan (+249)</option>
            <option data-countryCode="SR" value="597">Suriname (+597)</option>
            <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
            <option data-countryCode="SE" value="46">Sweden (+46)</option>
            <option data-countryCode="CH" value="41">Switzerland (+41)</option>
            <option data-countryCode="SI" value="963">Syria (+963)</option>
            <option data-countryCode="TW" value="886">Taiwan (+886)</option>
            <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
            <option data-countryCode="TH" value="66">Thailand (+66)</option>
            <option data-countryCode="TG" value="228">Togo (+228)</option>
            <option data-countryCode="TO" value="676">Tonga (+676)</option>
            <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
            <option data-countryCode="TN" value="216">Tunisia (+216)</option>
            <option data-countryCode="TR" value="90">Turkey (+90)</option>
            <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
            <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
            <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
            <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
            <option data-countryCode="UG" value="256">Uganda (+256)</option>
            <option data-countryCode="GB" value="44">UK (+44)</option>
            <option data-countryCode="UA" value="380">Ukraine (+380)</option>
            <option data-countryCode="UY" value="598">Uruguay (+598)</option>
            <option data-countryCode="US" value="1">USA (+1)</option>
            <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
            <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
            <option data-countryCode="VA" value="379">Vatican City (+379)</option>
            <option data-countryCode="VE" value="58">Venezuela (+58)</option>
            <option data-countryCode="VN" value="84">Vietnam (+84)</option>
            <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
            <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
            <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
            <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
            <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
            <option data-countryCode="ZM" value="260">Zambia (+260)</option>
            <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
          </optgroup>
        </select>
        </div>
        <div class="col-md-6">
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
<!--
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
-->
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
           <select class="form-control" id="applicant_visa_type_FK" onchange="
           if ($(this).val()==-1){this.form['other_visa_type'].style.visibility='visible'} else {this.form['other_visa_type'].style.visibility='hidden'};" >
              <option value="" selected="selected">Select...</option>
              <option <?php if($applicant_visa_type_FK == -1) {  ?> selected="selected" <?php  } ?> value="-1">Other</option>
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
          <?php 
              $visaType = new visa_type();
              $visa_type = $visaType->get_employment_visa($applicant_visa_type_FK);
           ?>
          <input class="form-control" type="textbox" id="other_visa_type" name="other_visa_type" value="<?php echo $visa_type['type_title']; ?>" <?php if ($visa_type['type_title']<> 0 ) { ?>style="display: show" <?php } ?> />
        </div>
      </div>

      <div class="form-group">
        <label for="grid-input-3" class="col-md-3 control-label">Are you currently employed?</label>
        <div class="col-md-9">
           <select class="form-control" id="applicant_hold_dha_license">
            <option value="" selected="selected">Select...</option>
            <option <?php if ($applicant_current_employment_status == 1) { echo "selected"; } ?>
            value="1" >YES</option>
            <option <?php if ($applicant_current_employment_status == 0) { echo "selected"; } ?> value="0">NO</option>
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
        <?php //print_r($position_obj); ?>
        <div class="col-md-9">
           <select class="form-control" id="applicant_applying_position_id_FK" onchange="if ($(this).val()==-1){this.form['other_position'].style.visibility='visible'}else {this.form['other_position'].style.visibility='hidden'};">
            <option value="" selected="selected">Select...</option>
            <option value="-1">Other</option>
              <?php for($i=0;$i<count($position_obj);$i++) { ?>
                <option <?php if($position_obj[$i]["request_id"] == $applicant_applying_position_id_FK) {  ?> selected="selected" <?php  } ?> value="<?php echo $position_obj[$i]["request_id"]; ?>"><?php echo $position_obj[$i]["request_job_title"]; ?></option>
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
        <label for="grid-input-3" class="col-md-3 control-label">Employment Type</label>
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
          <?php 
              $profissiondType = new profission();
              $profissiond_type = $profissiondType->get_applicant_profission($applicant_profession_FK);
           ?>
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
          <?php 
              $boardType = new board();
              $board_type = $boardType->get_applicant_board($applicant_board_certified_id_FK);
           ?>
          <input class="form-control" type="textbox" id="other_board" name="other_board" style="visibility:hidden;"/>
        </div>
      </div>

      <!--<div class="form-group">
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
      </div>-->

      <div class="form-group">
          <label for="grid-input-1" class="col-md-3 control-label" >license: </label>
          <div class="col-md-9">
            <select class="form-control select2-example" id="applicant_llicense_id_FK" multiple style="width: 100%">
              <?php for($i=0;$i<count($applicant_license_Obj);$i++) { ?>
                    <option <?php if(in_array($applicant_license_Obj[$i]["license_id"],$applicant_llicense_id_FK)) { ?> selected="selected" <?php  }   ?> value="<?php echo $applicant_license_Obj[$i]["license_id"]; ?>"><?php echo $applicant_license_Obj[$i]["license_name"]; ?></option>
                    <?php } ?>
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
		<input type="hidden" id="applicant_cv_id_FK" value="<?php echo $applicant_cv_id_FK; ?>">
    <?php if (isset($file) && $file <> NULL) { echo $file[0]['file_new_name'].".".$file[0]['file_extension'];} ?>
        </div>
      </div>
      <?php 
      if ($source ==2) { ?>
        <div class="form-group">
          <div class="col-md-offset-3 col-md-12">
            <button type="button" class="btn btn-primary col-md-9" onclick="submit_save_web_form('<?php echo $applicant_id; ?>')">Save my application</button>
          </div>
        </div>
     <?php } else {?>
      <div class="form-group">
        <div class="col-md-offset-3 col-md-12">
            <button type="button" class="btn btn-primary col-md-9" onclick="submit_save_applicant('<?php echo $applicant_id; ?>')">Save</button>
          </div>
      </div>
    <?php } ?>
      <div id="applicant_op_div"></div>
    </form>
  </div>
</div>

<script type="text/javascript">
  $(function() {
      $('.select2-example').select2({
        placeholder: 'Select value',
      });
    });
</script>