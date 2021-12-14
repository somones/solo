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
require_once("../model/consent_request.class.php");
require_once("../model/request_has_signee.class.php");


//$employeeObj 	= new employee();
//$employee_Obj 	= $employeeObj->get_this_employee($_POST['user_id']);

$file_id = $_POST['file_id'];
$consent_requestObj 	= new consent_request();
$consent_fileObj 	    = new request_has_signee();

if ($_POST['signed_doc_id'] <> 0 ) {

	$consent_request_pdf	=$consent_fileObj->get_consent_file($_POST['signed_doc_id']);
	$pdf = '../upload_files/new_pdf_consent/'.$consent_request_pdf[0]['consent_signed_name'].$consent_request_pdf[0]['consent_signed_extension'];

} else {

	$consent_request_pdf	=$consent_requestObj->get_consent_pdf($_POST['file_id']);
	$pdf = '../../../assets/uploads/'.$consent_request_pdf['file_new_name'].".".$consent_request_pdf['file_extension'];
}


$pdf_file = '7-1554179074.pdf ';


?>
<style type="text/css">
  .hr-sect {
  display: flex;
  flex-basis: 100%;
  align-items: center;
  color: rgba(0, 0, 0, 0.35);
  margin: 8px 0px;
}
.hr-sect::before,
.hr-sect::after {
  content: "";
  flex-grow: 1;
  background: rgba(0, 0, 0, 0.35);
  height: 1px;
  font-size: 0px;
  line-height: 0px;
  margin: 0px 8px;
}
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $sig = $("#signature").jSignature();
        $('#save').click(function() {
            datapair = $sig.jSignature("getData", "svg");
            $('#sigstring').text(datapair[1]);

            var canvas = document.querySelector("canvas")
            context = canvas.getContext("2d");

            var image = new Image;
            image.src = "data:" + datapair[0] + "," + datapair[1];
            $(image).appendTo($("#PNGsignature"));

            context.drawImage(image, 0, 0);
            var a = document.createElement("a");

            a.href = canvas.toDataURL("image/png");
            $.ajax({
                url:'../controller/save_config.php', 
                type:'POST', 
                data:{
                    data:a.href,
                    pdf:'<?php echo $pdf; ?>',
                    request_id: '<?php echo $_POST["request_id"] ; ?>',
                    employee_id:'<?php echo $_POST["employee_id"]; ?>',
                    file_id:'<?php echo $_POST['file_id']; ?>',
                    user_type:'<?php echo $_POST['user_type']; ?>',
                    p_x:'<?php echo $_POST['x']; ?>',
                    p_y:'<?php echo $_POST['y']; ?>',
                    p_w:'<?php echo $_POST['w']; ?>',
                    p_page:'<?php echo $_POST['page']; ?>',
                    user_name:'<?php echo $_POST['user_name']; ?>',
                    hr_num:'<?php echo $_POST['hr_num']; ?>'
                }
            });
        });
        $('#clear').click(function() {
            $sig.jSignature("clear");
        });
    });
</script>
<?php //print_r($_POST); ?>
<div id="modal-sizes-2" class="modal fade in" tabindex="-1" role="dialog" style="display: block;" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Consent Request Document</h4>
			</div>
			<?php //print_r($_POST); ?>
			<div class="modal-body">	
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-body p-a-4 b-b-4 bg-white darken">
							<?php 
								if ($_POST['consent_partially_signed'] == 1 ) {
									if ($_POST['signed_doc_id'] <> 0) {

										$file_id =  $_POST['signed_doc_id'];
										$consent_file_Obj	=$consent_fileObj->get_consent_file($file_id);
										for($i=0;$i<count($consent_file_Obj);$i++) {
											$path = "../upload_files/new_pdf_consent/";
											$file = $path.$consent_file_Obj[0]['consent_signed_name'].$consent_file_Obj[0]['consent_signed_extension'];
											?>
											<object width="100%" height="700" data="<?php echo $file ?>"></object>
											<?php
										}
									} else {
										echo "Sorry There is no File To show";
									}
								} else {
									if ($_POST['file_id'] <> 0) {
										$file_id =  $_POST['file_id'];
										$consent_request_Obj	=$consent_requestObj->get_consent_file($file_id);
										for($i=0;$i<count($consent_request_Obj);$i++) {
											$path = "../../../assets/uploads/";
											$file = $path.$consent_request_Obj[0]['file_new_name'].".".$consent_request_Obj[0]['file_extension'];
											?>
											<object width="100%" height="700" data="<?php echo $file ?>"></object>
											<?php
										}
									} else {
										echo "Sorry There is no File To show";
									}
								}
							 ?>
						</div>
					</div>
				</div>
				<?php if ($_POST['signed'] ==1) {
					echo "This Request is Signed Already";
				} else { ?>
					<div class="col-lg-12">
						<div class="hr-sect"><b>This Document Requires your Signature</b></div>

						<div class="panel-body p-a-4 b-b-4 bg-white darken">
							<div class="form-group">
								<!-- <div class="col-md-offset-3 col-md-9">
									<button type="button" class="btn btn-primary" onclick="Sign_this_doc('<?php echo $_POST["request_id"]; ?>','<?php echo $_POST["user_id"]; ?>','<?php echo $_POST["suffix"]; ?>')">Sign this doc</button>
								</div> -->
								<div id="signature" style="background-color: #f2f2f2"></div>
								<hr>
				        		<button class="btn" id="clear">Clear</button>
				        		<button class="btn" id="save" onclick="Sign_this_doc('<?php echo $_POST["request_id"]; ?>','<?php echo $_POST["employee_id"]; ?>','<?php echo $_POST['file_id']; ?>', '<?php echo $_POST['user_type']; ?>','<?php echo $_SESSION['employee_id'] ?>')">Sign this document</button>
				        		<!--<button class="btn btn-danger" id="save">Reject</button>-->
							</div>
						</div>

				<?php } ?>
				<div id="consent_category_form_div"></div>	
			</div>
		</div>
	</div>
</div>
