<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Google API configuration
require_once("../html/lib/model/database.class.php");
require_once("../html/lib/model/employee.class.php");
define('GOOGLE_CLIENT_ID', '');
define('GOOGLE_CLIENT_SECRET', '');
define('GOOGLE_REDIRECT_URL', '');
// Start session
if(!session_id()){
    session_start();
}
// Include Google API client library
require_once 'google-api-php-client/Google_Client.php';
require_once 'google-api-php-client/contrib/Google_Oauth2Service.php';
// Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login');
$gClient->setClientId(GOOGLE_CLIENT_ID);
$gClient->setClientSecret(GOOGLE_CLIENT_SECRET);
$gClient->setRedirectUri(GOOGLE_REDIRECT_URL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
//--------------- -------------------------------------------------------------

if(isset($_GET['code']))
{
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var(GOOGLE_REDIRECT_URL, FILTER_SANITIZE_URL));
}

if(isset($_SESSION['token']))
{
	$gClient->setAccessToken($_SESSION['token']);
}

if($gClient->getAccessToken())
{
	// Get user profile data from google
	$gpUserProfile = $google_oauthV2->userinfo->get();
	
	// Getting user profile info
	$gpUserData = array();
	$gpUserData['oauth_uid']  = !empty($gpUserProfile['id'])?$gpUserProfile['id']:'';
	$gpUserData['first_name'] = !empty($gpUserProfile['given_name'])?$gpUserProfile['given_name']:'';
	$gpUserData['last_name']  = !empty($gpUserProfile['family_name'])?$gpUserProfile['family_name']:'';
	$gpUserData['email'] 	  = !empty($gpUserProfile['email'])?$gpUserProfile['email']:'';
	$gpUserData['gender'] 	  = !empty($gpUserProfile['gender'])?$gpUserProfile['gender']:'';
	$gpUserData['locale'] 	  = !empty($gpUserProfile['locale'])?$gpUserProfile['locale']:'';
	$gpUserData['picture'] 	  = !empty($gpUserProfile['picture'])?$gpUserProfile['picture']:'';
	$gpUserData['link'] 	  = !empty($gpUserProfile['link'])?$gpUserProfile['link']:'';
	$_SESSION['user_picture']	=$gpUserData['picture'] ;
	
	// Get the User infos
    $gpUserData['oauth_provider'] = 'google';
   // print_r($gpUserData);
	$emplyeeObj=new employee();
	$resultSet=$emplyeeObj->validate_email($gpUserData["email"]);
	if(count($resultSet)==1)
	{
		$_SESSION['employee_id']=$resultSet[0]["employee_id"];
		$_SESSION['company_id']	=$resultSet[0]["company_id_FK"];
		header("location:../");
	}
	else
	{
	//	$login_domain=$emplyeeObj->validate_domain($gpUserData["email"]);
	//	if($login_domain <> "fakihivf.com")
	//		header("location:logout.php");	
	//	else
	//	{
				$emplyeeObj->register_new_user($gpUserProfile);
				$resultSet=$emplyeeObj->validate_email($gpUserData["email"]);
				if(count($resultSet)==1)
				{
					$_SESSION['employee_id']=$resultSet[0]["employee_id"];
					$_SESSION['company_id']	=$resultSet[0]["company_id_FK"];
				}			
	//	}
	}
    $output = '<a href="logout.php">LOUGOUT</a>';
    echo $output;
}
else
{
	// Get login url
	$authUrl = $gClient->createAuthUrl();
?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> 
<html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Sign In - SOLO</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<!-- Open Sans font from Google CDN -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

	<!-- Pixel Admin's stylesheets -->
	<link href="../html/assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../html/assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="../html/assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
	<link href="../html/assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="../html/assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">

	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->
</head>



<body class="theme-default page-signup">
<!-- Demo script --> <script src="../html/assets/demo/demo.js"></script> <!-- / Demo script -->

	<!-- Page background -->
	<div id="page-signup-bg">
		<!-- Background overlay -->
		<div class="overlay" style="background:#087498"></div>
		<!-- Replace this with your bg image -->
		<img src="" alt="">
	</div>
	<!-- / Page background -->

	<!-- Container -->
	<div class="signup-container">
		<!-- Header -->
		<div class="signup-header">
			<a href="#" class="logo">
				<img src="../html/assets/demo/logo-big.png" alt="" style="margin-top: -5px;">&nbsp;
				SOLO
			</a> <!-- / .logo -->
			<div class="slogan">
				Available. Flexible. Powerful.
			</div> <!-- / .slogan -->
		</div>
		<!-- / Header -->

		<!-- Form -->
		<div class="signup-form">
			<form action="" id="signup-form_id" method="post">
				
				<div class="signup-text">
					<span>Sign In</span>
				</div>
				<div class="form-group" style="text-align:center">
					<?php
						$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/google-sign-in-btn.png" alt=""/></a>';
						echo $output;
					?>
				</div>
				<div class="signup-with">
				</div>				
				
			</form>
			<!-- / Form -->


		</div>
		<!-- Right side -->
	</div>


<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->


<!-- Pixel Admin's javascripts -->
<script src="../html/assets/javascripts/bootstrap.min.js"></script>
<script src="../html/assets/javascripts/pixel-admin.min.js"></script>

<script type="text/javascript">
	window.PixelAdmin.start(init);
</script>

</body>
</html>



<?php
	// Render google login button
	//$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/google-sign-in-btn.png" alt=""/></a>';
	//echo $output;
}
?>