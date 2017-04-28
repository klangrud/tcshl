<?php
/*
 * Created on Sep 24, 2007
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
if (isset($_POST['teamid']) && $_POST['teamid'] > 0) {
    $TEAM = $_POST['teamid'];
} else if ((isset($_GET['teamid'])) && ($_GET['teamid'] > 0)) {
    $TEAM = $_GET['teamid'];
} else {
    $TEAM = 0;
}
$pageName = '';
if (isset($TEAM) && $TEAM > 0) {
    $pageName.= get_team_name($TEAM) . ' ';
}
$pageName.= get_season_name($SEASON) . ' Season Team Roster';
$smarty->assign('page_name', $pageName);
setup_team_candidates();
setup_other_seasons('ROSTER');
// Setup roster
require ('includes/inc_roster.php');
// Build the page
require ('global_begin.php');
$smarty->display('public/roster.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
?>
