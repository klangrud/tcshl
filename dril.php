<?php
/*
 * Created on Aug 19, 2009
 *
*/
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');
// Set for every page
require ('engine/common.php');
$smarty->assign('page_name', 'TCSHL D.R.I.L.');
// Build the page
require ('global_begin.php');
$smarty->display('public/dril.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
//None needed

?>

