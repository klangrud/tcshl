<?php
/*
 * Created on Aug 23, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 1);
define('PAGE_TYPE', 'USER');

// Set for every page
require ('engine/common.php');

$PasswordChanged = false;

if ((isset ($_POST['action'])) && ($_POST['action'] == "Change Password")) {
	// If form does not validate, we need to return with errors.
	if ($errors = validate_change_password_form()) {
		handle_errors($errors);
	} else {
		// If errors occur while trying to change password, we need to return with errors.
		if ($errors = process_change_password_form($smarty)) {
			handle_errors($errors);
		} else {
			$PasswordChanged = true;
		}		
	}
}

$smarty->assign('page_name', 'Change Password');
$smarty->assign('PasswordChanged', $PasswordChanged);

// Build the page
require ('global_begin.php');
$smarty->display('user/changepassword.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/ 

/*
 * Validate Reset Password Form
 */ 
function validate_change_password_form() {
	$errors = array();
	
	// Validate password fields
	if ($_POST['password1'] || $_POST['password2']) {
		if (strlen($_POST['password1']) < 4 || strlen($_POST['password1']) >= 10) {
			$errors[] = "Please choose a password between 4-10 characters in length.";
		}
		if ($_POST['password1'] != $_POST['password2']) {
			$errors[] = "Password and Confirmation Password do not match.";
		}
	} else {
		$errors[] = "Must provide password and confirmation password.";
	}
	
	return $errors;
}

/*
 * Process Reset Password Form
 */ 
function process_change_password_form() {
	global $Link;
	
	$pass = md5($_POST['password1']);
	$email = $_SESSION['username'];
	
	$Query = 'UPDATE '.USER.' SET password="'.$pass.'" WHERE eMail="'.$email.'"';
	$Result = mysql_query($Query, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
}

?>
