<?php
// Google API configuration
//print_r($_SESSION);
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
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId(GOOGLE_CLIENT_ID);
$gClient->setClientSecret(GOOGLE_CLIENT_SECRET);
$gClient->setRedirectUri(GOOGLE_REDIRECT_URL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
//--------------- -------------------------------------------------------------

if(isset($_GET['code'])){
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var(GOOGLE_REDIRECT_URL, FILTER_SANITIZE_URL));
}

if(isset($_SESSION['token'])){
	$gClient->setAccessToken($_SESSION['token']);
}

if($gClient->getAccessToken()){
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
	
	// Get the User infos
    $gpUserData['oauth_provider'] = 'google';
    //print_r($gpUserData);
    echo "<b>First Name:</b> ".$gpUserData['first_name'];
    echo "<br>";
    echo "<b>Last Name:</b> ".$gpUserData['last_name'];
    echo "<br>";
    echo "<b>Email:</b> ".$gpUserData['email'];
    echo "<br>";
    echo "<b>Gender:</b> ".$gpUserData['gender'];
    echo "<br>";
    echo "<b>Locale:</b> ".$gpUserData['locale'];
    echo "<br>";
    echo "<b>Picture link:</b> ".$gpUserData['picture'];
    echo "<br>";
    echo "<b>Google + Link:</b> ".$gpUserData['link'];
    echo "<br>";
    echo "<br>";
	// Button for lougout
    $output = '<a href="logout.php">LOUGOUT</a>';
    echo $output;
}else{
	// Get login url
	$authUrl = $gClient->createAuthUrl();

	// Render google login button
	$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'">
	 <img src="images/google-sign-in-btn.png" alt=""/></a>';
	echo $output;
}
?>