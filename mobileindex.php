<?php
/*
 * Created on Oct 23, 2009
 *
 * Mobile Version of TCSHL.com
*/
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');
require ('engine/common_mobile.php');
$smarty->assign('page_name', 'Mobile Links');
// Build the page
require ('global_mobile_header.php');
$smarty->display('public/mobile/index.tpl');
require ('global_mobile_footer.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
?>
