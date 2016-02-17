<?php

/*
 * Created on Aug 5, 2011
 *
*/

// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');

// Set for every page
require ('engine/common.php');

$smarty->assign('page_name', 'League Payment Status');

if ((isset ($_GET)) && ($_GET['status'] == "success")) {
	$smarty->assign('paymentsuccess', 1);	
} else if ((isset ($_GET)) && ($_GET['status'] == "cancel")) {
	$smarty->assign('paymentcancel', 1);	
}


// Build the page
require ('global_begin.php');
$smarty->display('public/paymentstatus.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

?>