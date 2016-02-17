<?php
/*
 * Created on Sep 10, 2007
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

//Set meta refresh on this page
$smarty->assign('metaRefresh', get_site_variable_value("DRAFT"));

// Setup draft information
$setCurrentRound = 0;
require ('includes/inc_draftstatus.php');
require ('includes/inc_draftresults.php');


// Build the page
//require ('global_begin.php');
$smarty->display('global/includes/inc_draftstatus.tpl');
$smarty->display('global/includes/inc_draftresults.tpl');
//require ('global_end.php');

?>