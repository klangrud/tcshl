<?php

/*
 * Created on Sep 06, 2007
 *
*/

// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');

// Set for every page
require ('engine/common.php');

$Title = "Page Cannot Be Found";
$Error = "We're sorry, but the page you are looking for cannot be accessed. It may have been removed, had its name changed or may be temporarily unavailable. Please <a href=\"index.php\">click here</a> to continue. <br /><br /> If this problem persists, please notify <a href=\"mailto:webmaster@tcshl.com\">webmaster@tcshl.com</a>.";

$smarty->assign('page_name', 'TCSHL::Server Error');
$smarty->assign('404Title', $Title);
$smarty->assign('404Error', $Error);


// Build the page
require ('global_begin.php');
$smarty->display('public/404error.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

/*
 * Setup announcements
 */
 


?>

