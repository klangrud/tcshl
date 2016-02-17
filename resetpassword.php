<?php
/*
 * Created on Aug 23, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');

// Set for every page
require ('engine/common.php');

$PasswordSent = false;

if ((isset ($_POST['action'])) && ($_POST['action'] == "Reset Password")) {
	// If form does not validate, we need to return with errors.
	if ($errors = validate_reset_password_form()) {
		handle_errors($errors);
		handle_reposts();
	} else {
		// If errors occur while trying to reset password, we need to return with errors.
		if ($errors = process_reset_password_form($smarty)) {
			handle_errors($errors);
			handle_reposts();
		} else {
			$PasswordSent = true;
		}		
	}
}

$smarty->assign('page_name', 'Reset Password');
$smarty->assign('PasswordSent', $PasswordSent);

// Build the page
require ('global_begin.php');
$smarty->display('public/resetpassword.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/ 

/*
 * Handle Reposts for Reset Password Form
 */ 
function handle_reposts() {
	global $smarty;
	$em = "";

	if ($_POST) {
		if ($_POST['email']) {
			$em = format_trim(strtolower($_POST['email']));
		}
	}
	
	$smarty->assign('em', $em);
}

/*
 * Validate Reset Password Form
 */ 
function validate_reset_password_form() {
	$errors = array();
	
	// Validate email field
	if ($_POST['email']) {
		if (validate_email(format_trim($_POST['email']))) {
			//Do Nothing
		} else {
			$errors[] = "Email is not valid.";
		}
	} else {
		$errors[] = "Must provide a valid email address.";
	}	
	
	return $errors;
}

/*
 * Process Reset Password Form
 */ 
function process_reset_password_form() {
	$errors = array();
	
	$Email = $_POST['email'];
	
	$randomPassword = generate_random_password(8);
	
	$Link = '';
	global $Link;
	
	$md5RandomPassword = md5($randomPassword);
	
	$Query = 'UPDATE '.USER.' SET password="'.$md5RandomPassword.'" WHERE eMail="'.$Email.'"';
	$Result = mysql_query($Query, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
	if($Result) {
		send_reset_password_email($Email, $randomPassword);
	} else {
		$errors[] = 'Unable to reset password.';
	}
	
	return $errors;
}

/*
 * Generate a new random password
 */ 
function generate_random_password($length) {
  srand(date("s"));
  $CandidateChars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  $RandomString = "";
  while(strlen($RandomString)<$length) {
      $RandomString .= substr($CandidateChars, rand()%(strlen($CandidateChars)),1);
  }
  return($RandomString);
}

/*
 * Send Reset Password Email
 */ 
 function send_reset_password_email($emailAddress, $randomPassword) {
 	require_once('com/tcshl/mail/Mail.php');
 	$emailBody = 'Your password has been reset to '.$randomPassword;

	//$sender,$recipients,$subject,$body
	$Mail = new Mail(VERIFICATION_EMAIL_SENDER,$emailAddress,RESET_PASSWORD_EMAIL_SUBJECT,$emailBody);
 	$Mail->sendMail();	
 }
?>
