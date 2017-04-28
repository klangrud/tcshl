<?php
/*
 * Created on Aug 30, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
*/
// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');
// Set for every page
require ('engine/common.php');
if ((isset($_POST['action'])) && ($_POST['action'] == "Add Team To Season")) {
    //No validation needed since we give them the values to post.
    process_addteamtoseason_form($smarty);
}
$pageName = 'Add Team to ' . get_season_name($SEASON) . ' Season';
$smarty->assign('page_name', $pageName);
$smarty->assign('seasonName', get_season_name($SEASON));
setup_teams_this_season();
setup_team_select();
// Build the page
require ('global_begin.php');
$smarty->display('admin/addteamtoseason.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
/*
 * Process Form Data
*/
function process_addteamtoseason_form($smarty) {
    global $SEASON;
    global $Link;
    $errors = array();
    $teamCandidateID = $_POST['candidateTeams'];
    //Check if user exists with accessLevel > 0.  If true, then we will just error out registration and explain that user exists.
    $query = 'INSERT INTO ' . TEAMSOFSEASONS . ' (`seasonID`, `teamID`) VALUES (' . $SEASON . ',' . $teamCandidateID . ')';
    mysql_query($query, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
} // End of function
function setup_teams_this_season() {
    global $smarty;
    global $SEASON;
    global $Link;
    $teamsThisSeasonSelect = 'SELECT teamID, teamName FROM ' . TEAMS . ' WHERE teamID IN (SELECT teamID FROM ' . TEAMSOFSEASONS . ' WHERE seasonID=' . $SEASON . ')';
    $teamsThisSeasonResult = mysql_query($teamsThisSeasonSelect, $Link);
    if ($teamsThisSeasonResult && mysql_num_rows($teamsThisSeasonResult) > 0) {
        $countTeams = 0;
        $smarty->assign('teamID', array());
        $smarty->assign('teamName', array());
        while ($team = mysql_fetch_array($teamsThisSeasonResult, MYSQL_ASSOC)) {
            $countTeams++;
            $teamId = $team['teamID'];
            $teamName = $team['teamName'];
            $smarty->append('teamID', $teamId);
            $smarty->append('teamName', $teamName);
        }
        $smarty->assign('countTeams', $countTeams);
    }
}
function setup_team_select() {
    global $smarty;
    global $SEASON;
    global $Link;
    $teamCandidatesSelect = 'SELECT teamID, teamName FROM ' . TEAMS . ' WHERE teamID NOT IN (SELECT teamID FROM ' . TEAMSOFSEASONS . ' WHERE seasonID=' . $SEASON . ')';
    $teamsCandidatesResult = mysql_query($teamCandidatesSelect, $Link);
    if ($teamsCandidatesResult && mysql_num_rows($teamsCandidatesResult) > 0) {
        $countCandidateTeams = 0;
        $smarty->assign('teamCandidateID', array());
        $smarty->assign('teamCandidateName', array());
        while ($team = mysql_fetch_array($teamsCandidatesResult, MYSQL_ASSOC)) {
            $countCandidateTeams++;
            $teamId = $team['teamID'];
            $teamName = $team['teamName'];
            $smarty->append('teamCandidateID', $teamId);
            $smarty->append('teamCandidateName', $teamName);
        }
        $smarty->assign('countCandidateTeams', $countCandidateTeams);
    }
}
?>