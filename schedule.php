<?php
/*
 * Created on Sep 11, 2007
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
$TEAM = 'ALL';
setup_team_candidates();
setup_other_seasons('SCHEDULE');
if ((isset($_POST['action'])) && ($_POST['action'] == "Get Schedule")) {
    if (isset($_POST['teamid']) && $_POST['teamid'] > 0) {
        $TEAM = $_POST['teamid'];
    }
} else if ((isset($_GET['teamid'])) && ($_GET['teamid'] > 0)) {
    $TEAM = $_GET['teamid'];
} else {
    $TEAM = 0;
}
$pageName = '';
if ($TEAM > 0) {
    $pageName.= get_this_team_name($TEAM) . ' ';
}
$pageName.= get_season_name($SEASON) . ' Season Schedule';
$smarty->assign('page_name', $pageName);
$smarty->assign('managermode', 0);
$smarty->assign('TEAM', $TEAM);
// Setup schedule
require ('includes/inc_schedule.php');
// Build the page
require ('global_begin.php');
$smarty->display('public/schedule.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
/*
 * Get Team Name
*/
function get_this_team_name($teamId) {
    $teamName = "";
    global $Link;
    $teamSelect = 'SELECT teamName FROM ' . TEAMS . ' WHERE teamID=' . $teamId;
    $teamResult = mysql_query($teamSelect, $Link);
    if ($teamResult && mysql_num_rows($teamResult) > 0) {
        $team = mysql_fetch_assoc($teamResult);
        $teamName = $team['teamName'];
    }
    return $teamName;
}
?>