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



	
    // If form has been submitted.
  	if ((isset ($_POST['action'])) && ($_POST['action'] == "Register")) {
	  // Pass recaptcha
      // Setup recaptcha response object
	  $resp = recaptcha_check_answer (RECAPTCHA_PRIVATE_KEY,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);	  
	  if (!$resp->is_valid) {
	    // What happens when the CAPTCHA was entered incorrectly
	    $errors = array();
	    $errors[] = "The reCAPTCHA wasn't entered correctly.  Go back and try it again.  (reCAPTCHA said: " . $resp->error . ")";
	    handle_errors($errors);
	    handle_reposts();
	  } else {
	  	// Recaptcha successful, now onto the rest of the form.		
		// If form does not validate, we need to return with errors.
		if ($errors = validate_registration_form()) {
			handle_errors($errors);
			handle_reposts();
		} else {
			// If errors occur while trying to create user, we need to return with errors.
			if ($errors = process_registration_form($smarty)) {
				handle_errors($errors);
				handle_reposts();
			} else {
				header("Location: pending.php");
			}		
		}
	  }
  	}

$smarty->assign('page_name', 'Site Registration');
$smarty->assign('recaptcha_html', recaptcha_get_html(RECAPTCHA_PUBLIC_KEY));


// Build the page
require ('global_begin.php');
$smarty->display('public/siteregistration.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

function handle_reposts() {
	global $smarty;
	$fn = "";
	$ln = "";
	$em = "";

	if ($_POST) {
		if ($_POST['firstname']) {
			$fn = format_uppercase_text($_POST['firstname']);
		}
		if ($_POST['lastname']) {
			$ln = format_uppercase_text($_POST['lastname']);
		}
		if ($_POST['email']) {
			$em = format_trim(strtolower($_POST['email']));
		}
	}
	$smarty->assign('fn', $fn);
	$smarty->assign('ln', $ln);
	$smarty->assign('em', $em);
}

function validate_registration_form() {
	$errors = array ();
	if ($_POST['firstname']) {
		if (strlen($_POST['firstname']) < 2) {
			$errors[] = "First name must be at least 2 characters long.";
		}
		if (!valid_text($_POST['firstname'])) {
			$errors[] = "First name contains invalid characters. Check for quotes.";
		}
	} else {
		$errors[] = "First name is a required field";
	}

	if ($_POST['lastname']) {
		if (strlen($_POST['lastname']) < 2) {
			$errors[] = "Last name must be at least 2 characters long.";
		}
		if (!valid_text($_POST['lastname'])) {
			$errors[] = "Last name contains invalid characters. Check for quotes.";
		}
	} else {
		$errors[] = "Last name is a required field";
	}

	if ($_POST['password'] || $_POST['password2']) {
		if (strlen($_POST['password']) < 4 || strlen($_POST['password']) >= 10) {
			$errors[] = "Please choose a password between 4-10 characters in length.";
		}
		if ($_POST['password'] != $_POST['password2']) {
			$errors[] = "Password and Confirmation Password do not match.";
		}
	} else {
		$errors[] = "Must provide password and confirmation password.";
	}

	if ($_POST['email']) {
		if (validate_email(format_trim($_POST['email']))) {
			//Do nothing
		} else {
			$errors[] = "Email is not valid.";
		}
	} else {
		$errors[] = "Must provide a valid email address.";
	}

	if (count($errors) > 0) {
		
		global $Link;
		$uname = $_POST['email'];
		$check_user_query = "SELECT eMail, accessLevel FROM " . USER . " WHERE eMail='" . $uname . "' AND accessLevel > 0";
		$check_result = mysql_query($check_user_query, $Link);
		if ($check_result && mysql_num_rows($check_result) > 0) {
			$errors[] = 'Email already exists.  Please choose a different one.';
		}
		
	}

	return $errors;
}

/*
 * Process Form Data
 */

function process_registration_form($smarty) {
	global $Link;

	$errors = array();

	$fname = format_uppercase_text($_POST['firstname']);
	$lname = format_uppercase_text($_POST['lastname']);
	$email = format_trim(strtolower($_POST['email']));
	$pass = md5($_POST['password']);
	$verificationKey = createVerificationKey($email);

	//Check if user exists with accessLevel > 0.  If true, then we will just error out registration and explain that user exists.
	$query = 'SELECT email, accessLevel FROM '. USER . ' WHERE email = "'.$email.'" AND accessLevel > 0';
	$result = mysql_query($query, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

	if ($result && mysql_num_rows($result) > 0) {
		$errors[] = 'User already exists.  If you forgot your password, <a href="resetpassword.php">click here</a> to have it reset.';
		
		handle_errors($errors);
		handle_reposts();
	}

	if(count($errors) == 0) {
		//Check if user exists with accessLevel 0.  If true, then we will just resend validation email
		$query = 'SELECT email, accessLevel, verificationKey FROM '. USER . ' WHERE email = "'.$email.'" AND accessLevel = 0';
		$result = mysql_query($query, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

		if ($result && mysql_num_rows($result) > 0 && $row = mysql_fetch_array($result)) {
			$verificationKey = $row['verificationKey'];
			send_validation_email($email, $verificationKey);
			
			header("Location: pending.php");		
		} else {
			// Insert new user query
			$query = "INSERT INTO " . USER . " (firstname, lastname, email, password, verificationKey) ";
			$query .= "VALUES ('$fname', '$lname', '$email', '$pass', '$verificationKey')";
	
			$result = mysql_query($query, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
			if ($result) {
				send_validation_email($email, $verificationKey);
				send_admin_email();
			} else {
				$errors[] = "No user was created.";
			}
			
		} // End of else
	} // if (!errors)
	return $errors;
} // End of function


/*
 * Create Verification Key
 */

function createVerificationKey($email) {
	return md5($email . time());
}

/*
 * Send Validation Email
 */
 
 function send_validation_email($emailAddress, $verificationKey) {
 	require_once('com/tcshl/mail/Mail.php');
 	$VerificationLink = DOMAIN_NAME.'/verification.php?email='.$emailAddress.'&verificationKey='.$verificationKey;
 	
 	$emailBody = 'To activate your account either click on the following link or copy and paste the link into a browser: ';
 	$emailBody .= $VerificationLink; 	
 	
	//$sender,$recipients,$subject,$body
 	$Mail = new Mail(VERIFICATION_EMAIL_SENDER,$emailAddress,VERIFICATION_EMAIL_SUBJECT,$emailBody);
 	$Mail->sendMail();
 }
 
 
 /*
 * Send Admin Email - For Site Registration
 */
 
 function send_admin_email() {
 	require_once('com/tcshl/mail/Mail.php');
 	$emailAddress = SITEREG_EMAIL;
 	$VerificationLink = DOMAIN_NAME.'/account.php';
 	
 	$fn = format_uppercase_text($_POST['firstname']);
	$ln = format_uppercase_text($_POST['lastname']);
	$em = format_trim(strtolower($_POST['email']));
 	
 	$emailBody = $fn.' '.$ln.'('.$em.') has just registered for TCSHL site membership.  Click on the following link if you need to give this account admin privileges: ';
 	$emailBody .= $VerificationLink;

	//$sender,$recipients,$subject,$body
 	$Mail = new Mail(VERIFICATION_EMAIL_SENDER,$emailAddress,VERIFICATION_EMAIL_SUBJECT,$emailBody);
 	$Mail->sendMail();	
 }
?>
