<?php

/*
 * Created on Aug 23, 2007
 *
*/

// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');

// Set for every page
require ('engine/common.php');

$smarty->assign('page_name', get_season_name($SEASON).' Season Registration Successful');

// Build the page
require ('global_begin.php');
$smarty->display('public/registrationok.tpl');
require ('global_end.php');

?>