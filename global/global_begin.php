<?php
/*
 * Set Environment.  This is used by global_head.tpl to determine
 * if a dev background image should be inserted so that environments
 * are not mistaken.
 */
$smarty->assign('environment', ENVIRONMENT);
/*
 * Determine css style and javascript dynamically
 */
 
// If for a public page
if(PAGE_TYPE == 'PUBLIC')
{
	$smarty->assign('css_file', 'public');
	$smarty->assign('js_file', 'public');	
}
// If for a user page
else if(PAGE_TYPE == 'USER')
{
	$smarty->assign('css_file', 'user');
	$smarty->assign('js_file', 'user');
}
// If for a admin page
else if(PAGE_TYPE == 'ADMIN')
{
	$smarty->assign('css_file', 'admin');
	$smarty->assign('js_file', 'admin');	
}
// If for a security page
else if(PAGE_TYPE == 'SECURITY')
{
	$smarty->assign('css_file', 'security');
	$smarty->assign('js_file', 'security');
}
// If for an undetermined page
else
{
	$smarty->assign('css_file', 'none');
	$smarty->assign('js_file', 'none');
}

//Determine User Session
if($_SESSION) {
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
		$smarty->assign('user', $_SESSION['firstname']);
		$smarty->assign('logged_in', $_SESSION['logged_in']);
		$smarty->assign('site_access', $_SESSION['site_access']);
	} else {
		$smarty->clear_assign('user');
		$smarty->clear_assign('logged_in');
		$smarty->clear_assign('site_access');
	}
}

/*
 * Select teams for team select in menu
 */
require_once('includes/inc_team_select.php');

/*
 * Select teams for team select in menu
 */
require_once('includes/inc_marquee.php');

//Creates the header
$smarty->display('global/global_begin.tpl');
?>
