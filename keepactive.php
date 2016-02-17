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


$smarty->assign('page_name', 'Keep Active');

//******************************************
//************ Build the page***************
//******************************************
//
require ('global_begin.php');
$smarty->display('public/keepactive.tpl');
require ('global_end.php');

?>