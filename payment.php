<?php

/*
 * Created on Aug 3, 2011
 *
*/

// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');

// Set for every page
require ('engine/common.php');

require_once('com/tcshl/registration/Registration.php');

$seasonName = get_season_name($SEASON);

$smarty->assign('page_name', 'League Payment: '.$seasonName.' Season');

if ((isset ($_GET)) && ($_GET['registrationid'] > 0)) {
	$registration = new Registration($_GET['registrationid']);

	$smarty->assign('name', $registration->get_fName().' '.$registration->get_lName());
	$smarty->assign('regid', $registration->get_registrationID());
	
	
	// Determine which Payment Cart Button to add
	if($registration->get_drilLeague() == 1 || $registration->get_drilLeague() == 3) {
		// Determine if special goalie pricing applies
		if($registration->get_position() == 'Goalie') {
			if($registration->get_paymentPlan() == 1) {
				$smarty->assign('paymentOptionSpecialOne',1);
			} else if($registration->get_paymentPlan() == 2) {
				$smarty->assign('paymentOptionSpecialTwo',1);
			} else if($registration->get_paymentPlan() == 3) {
				$smarty->assign('paymentOptionSpecialThree',1);
			} else if($registration->get_paymentPlan() == 4) {
				$smarty->assign('paymentOptionSpecialFour',1);
			}			
		} else {		
			if($registration->get_paymentPlan() == 1) {
				$smarty->assign('paymentOptionOne',1);
			} else if($registration->get_paymentPlan() == 2) {
				$smarty->assign('paymentOptionTwo',1);
			} else if($registration->get_paymentPlan() == 3) {
				$smarty->assign('paymentOptionThree',1);
			} else if($registration->get_paymentPlan() == 4) {
				$smarty->assign('paymentOptionFour',1);
			}
		}
	}
	
	// Add DRIL Payment Cart Button?
	if($registration->get_drilLeague() == 2 || $registration->get_drilLeague() == 3) {
		$smarty->assign('paymentOptionDril',1);
	}
	
	
}


// Build the page
require ('global_begin.php');
$smarty->display('public/payment.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

?>