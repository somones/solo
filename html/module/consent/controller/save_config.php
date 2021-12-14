<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	set_time_limit(2);
	date_default_timezone_set('Asia/Dubai');
	require_once("../../../../html/lib/model/database.class.php");
	require_once("../../../../html/lib/model/item_category.class.php");
	require_once("../../../../html/lib/model/company.class.php");
	require_once("../../../../html/lib/model/branch.class.php");
	require_once("../../../../html/lib/model/employee.class.php");
	require_once("../../../../html/lib/model/module.class.php");
	require_once("../../../../html/lib/model/menu_item.class.php");
	require_once("../../../../html/lib/model/department.class.php");

	use setasign\Fpdi;
	use setasign\fpdf;

	require_once '../assets/vendor/autoload.php';
	require_once '../assets/vendor/setasign/fpdf/fpdf.php';

	$x 		= $_POST['p_x'];
	$y 		= $_POST['p_y'];
	$w 		= $_POST['p_w'];
	$page 	= $_POST['p_page'];

	$length = 4;
	$characters = '123456789';
	$randomString = '';
	
	for ($i=0; $i < $length; $i++) { 
	    $randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	
	$file_name = "FILE".$randomString.$_POST['file_id'];

	$data = $_POST['data'];
	$data = substr($data,strpos($data,",")+1);
	$data = base64_decode($data); 
	
	$file = '../upload_files/signatures/'.$file_name.'.png';
	$file_blanck = '../assets/blank.png';
	file_put_contents($file, $data);

if ($_POST['user_type'] == 1) {

	$start = microtime(true);
	$pdf = new Fpdi\Fpdi();
	$pagecount = $pdf->setSourceFile($_POST['pdf']);

	for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
		$tpl = $pdf->importPage($pageNo);
    	$pdf->AddPage();
    	$pdf->useTemplate($tpl);

    	if ($pageNo == $page) {
    		$pdf->SetFont('Helvetica');
   	 		$signature = $file;
   	 		//$pdf->Image($file,-5,245,80);
   	 		$pdf->Image($file_blanck,$x,$y,$w);
    		$pdf->Image($file,$x,$y,$w);
    		$pdf->SetFont('Helvetica','',8); // Font Name, Font Style (eg. 'B' for Bold), Font Size
			$pdf->SetTextColor(0,0,0); // RGB 
			$pdf->SetXY($x, $y+20); // X start, Y start in mm
			$pdf->Write(0, $_POST['user_name']." - ".$_POST['hr_num']);
    	}
	}
	$pdf->Output('F', '../upload_files/new_pdf_consent/'.$file_name.'.pdf');

} else if ($_POST['user_type'] == 2) {

	$start = microtime(true);
	$pdf = new Fpdi\Fpdi();
	$pagecount = $pdf->setSourceFile($_POST['pdf']);

	for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
		$tpl = $pdf->importPage($pageNo);
    	$pdf->AddPage();
    	$pdf->useTemplate($tpl);

    	if ($pageNo == $page) {
    		$pdf->SetFont('Helvetica');
   	 		$signature = $file;
   	 		//$pdf->Image($file,65,245,80);
   	 		$pdf->Image($file_blanck,$x,$y,$w);
    		$pdf->Image($file,$x,$y,$w);
    		$pdf->SetFont('Helvetica','',8); // Font Name, Font Style (eg. 'B' for Bold), Font Size
			$pdf->SetTextColor(0,0,0); // RGB 
			$pdf->SetXY($x+10, $y+20); // X start, Y start in mm
			$pdf->Write(0, $_POST['user_name']." - ".$_POST['hr_num']);
    	}
	}
	$pdf->Output('F', '../upload_files/new_pdf_consent/'.$file_name.'.pdf');

} else if ($_POST['user_type'] == 3) {

	$start = microtime(true);
	$pdf = new Fpdi\Fpdi();
	$pagecount = $pdf->setSourceFile($_POST['pdf']);

	for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
		$tpl = $pdf->importPage($pageNo);
    	$pdf->AddPage();
    	$pdf->useTemplate($tpl);

    	if ($pageNo == $page) {
    		$pdf->SetFont('Helvetica');
   	 		$signature = $file;
   	 		//$pdf->Image($file,135,245,80);
   	 		$pdf->Image($file_blanck,$x,$y,$w);
    		$pdf->Image($file,$x,$y,$w);
    		$pdf->SetFont('Helvetica','',8); // Font Name, Font Style (eg. 'B' for Bold), Font Size
			$pdf->SetTextColor(0,0,0); // RGB 
			$pdf->SetXY($x+10, $y+20); // X start, Y start in mm
			$pdf->Write(0, "Patient Signature");
    	}
	}
	$pdf->Output('F', '../upload_files/new_pdf_consent/'.$file_name.'.pdf');
}
//unlink($file);

$db=new Database();

$query="INSERT INTO `consent_signed_file` 
	(
		`consent_signed_name`,
		`consent_signed_path`,
		`consent_signed_extension`
	)

	VALUES(
		'".$file_name."',
		'../upload_files/new_pdf_consent/',
		'.pdf'
	)";

	$db->query($query);
	$db->execute();
	$document_id=$db->lastInsertId();


	$Update_query= "UPDATE `consent_request_has_signee` SET `signed_doc_id` = '".$document_id."'
		WHERE `request_id_FK`='".$_POST["request_id"]."' AND `document_id_FK` = '".$_POST['file_id']."' ";
	$db=new Database();
	$db->query($Update_query);
	$db->execute();


	$request_query="SELECT COUNT(*) AS `rows_nb` FROM `consent_request_has_signee` WHERE `signed` = 0 AND `request_id_FK` = '".$_POST["request_id"]."' ";
	
	$db->query($request_query);
	$result=$db->single();

	if ($result['rows_nb'] == 0 ) {
		
		$Update_query= "UPDATE `consent_request` SET `signed_file_id_FK` = '".$document_id."', `status_id_FK` = 3
		WHERE `consent_request_id`='".$_POST["request_id"]."' ";
		$db=new Database();
		$db->query($Update_query);
		$db->execute();
	} else {
		$Update_query= "UPDATE `consent_request` SET `signed_file_id_FK` = '".$document_id."', `status_id_FK` = 2
		WHERE `consent_request_id`='".$_POST["request_id"]."' ";
		$db=new Database();
		$db->query($Update_query);
		$db->execute();
	}
 ?>