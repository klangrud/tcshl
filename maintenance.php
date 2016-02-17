<?php
/*
 * Created on Sep 4, 2008
 *
 * Site Maintenance Page
 */
 
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');

// Set for every page
require ('engine/common.php');

$smarty->assign('page_name', 'Site Maintenance');

// Build the page
require ('global_begin.php');
$smarty->display('public/maintenance.tpl');
require ('global_end.php'); 
?>
