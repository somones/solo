<?php
// Google API configuration
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

// Remove token and user data from the session
unset($_SESSION['token']);
unset($_SESSION['userData']);

// Reset OAuth access token
$gClient->revokeToken();

// Destroy entire session data
session_destroy();

// Redirect to homepage
header("Location:index.php");
?>