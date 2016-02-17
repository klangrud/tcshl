<?php

/*
 * Created on Sep 25, 2009
 *
*/

// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');

// Set for every page
require ('engine/common.php');

require_once('com/tcshl/registration/Registration.php');

$smarty->assign('page_name', get_season_name($SEASON).' Season Registration');
$smarty->assign('registrationPage', 'TRUE');
$smarty->assign('ns', 'CHECKED'); // Will sub = no
$smarty->assign('nt', 'CHECKED'); // No Team Rep
$smarty->assign('nr', 'CHECKED'); // Will not ref
$smarty->assign('p1', 'CHECKED'); // Payment Plan 1
$smarty->assign('OPEN_REGISTRATION', get_site_variable_value("REGISTRATION"));


if ((isset ($_POST['action'])) && ($_POST['action'] == "Register")) {
	$registration = new Registration(0);
	// If form does not validate, we need to return with errors.
	if ($registration->formValidation()) {
		handle_errors($registration->get_formErrors());
		$registration->formReposts($smarty);
	} else {
		// If errors occur while trying to create user, we need to return with errors.
		if ($registration->formProcessInsert()) {
			handle_errors($registration->get_formErrors());
		 	$registration->formReposts($smarty);
		} else {
			$registration->emailRegistrationAdmin();
			if($registration->get_payToday() == "1") {
		      header("Location: payment.php?registrationid=".$registration->get_registrationID());
			} else {
			  header("Location: registrationok.php");	
			}
		}		
	}
} else {
  $smarty->assign('fw', 'CHECKED'); // Position = Forward
  $smarty->assign('jsxl', 'CHECKED'); // Jersey Size XL
  $smarty->assign('sl3', 'CHECKED'); // Skill Level Intermediate
  $smarty->assign('dl1', 'CHECKED'); // D.R.I.L. - Only TCSHL
}


// Build the page
require ('global_begin.php');
$smarty->display('public/registration.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

?>