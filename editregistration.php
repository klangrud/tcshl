<?php
/*
 * Created on Oct 7, 2009
 *
 */
 

// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');

// Set for every page
require ('engine/common.php');

require_once('com/tcshl/registration/Registration.php');

if ((isset ($_GET['id'])) && ($_GET['id'] > 0)) {
	$registration = new Registration($_GET['id']);
	$registration->formPreLoad($smarty);
	$smarty->assign('id',$registration->get_registrationID());
} else if ((isset ($_POST['action'])) && ($_POST['action'] == "Edit Registration")) {
	$registration = new Registration($_POST['id']);
	$smarty->assign('id',$registration->get_registrationID());
	// If form does not validate, we need to return with errors.
	if ($registration->formValidation()) {
		handle_errors($registration->get_formErrors());
		$registration->formReposts($smarty);
	} else {
		// If errors occur while trying to create user, we need to return with errors.
		if ($registration->formProcessUpdate()) {
			handle_errors($registration->get_formErrors());
		 	$registration->formReposts($smarty);
		} else {
			$registration->formPreLoad($smarty);
			handle_success($registration->get_formSuccess());
		}		
	}
} else {
	header("Location: manageregistrations.php");
}


$smarty->assign('page_name', 'Edit '.$registration->get_fName().' '.$registration->get_lName().'\'s Season Registration');
$smarty->assign('type', 'EDIT');

// Build the page
require ('global_begin.php');
$smarty->display('admin/editregistration.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/
 
?>
