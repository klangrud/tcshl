<?php
/*
 * Created on Oct 30, 2007
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
setup_rep_info();
$smarty->assign('page_name', 'Team Rep Manager');
// Build the page
require ('global_begin.php');
$smarty->display('admin/teamrepmanager.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_rep_info() {
    global $smarty;
    global $Link;
    global $SEASON;
    $columns = TEAMS . '.teamID, teamName, teamFGColor, teamBGColor, ' . TEAMSOFSEASONS . '.teamRep, playerFName, playerLName, ' . PLAYER . '.registrationId, eMail, homePhone, workPhone, cellPhone';
    $select = 'SELECT ' . $columns . ' FROM ' . TEAMSOFSEASONS;
    $select.= ' JOIN ' . PLAYER . ' ON ' . TEAMSOFSEASONS . '.teamRep = ' . PLAYER . '.playerID';
    $select.= ' JOIN ' . REGISTRATION . ' ON ' . PLAYER . '.registrationId = ' . REGISTRATION . '.registrationId';
    $select.= ' JOIN ' . TEAMS . ' ON ' . TEAMSOFSEASONS . '.teamID = ' . TEAMS . '.teamID';
    $select.= ' WHERE ' . TEAMSOFSEASONS . '.seasonID=' . $SEASON;
    $teamsResult = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    $teamCount = 0;
    $smarty->assign('teamId', array());
    $smarty->assign('teamName', array());
    $smarty->assign('teamFGColor', array());
    $smarty->assign('teamBGColor', array());
    $smarty->assign('teamRep', array());
    $smarty->assign('playerName', array());
    $smarty->assign('registrationId', array());
    $smarty->assign('eMail', array());
    $smarty->assign('homePhone', array());
    $smarty->assign('workPhone', array());
    $smarty->assign('cellPhone', array());
    if ($teamsResult && mysql_num_rows($teamsResult) > 0) {
        while ($team = mysql_fetch_array($teamsResult, MYSQL_ASSOC)) {
            $teamCount++;
            $teamId = $team['teamID'];
            $teamName = $team['teamName'];
            $teamFGColor = $team['teamFGColor'];
            $teamBGColor = $team['teamBGColor'];
            $teamRep = $team['teamRep'];
            $name = $team['playerFName'] . ' ' . $team['playerLName'];
            $regId = $team['registrationId'];
            $email = $team['eMail'];
            $homePhone = $team['homePhone'];
            $workPhone = $team['workPhone'];
            $cellPhone = $team['cellPhone'];
            $smarty->append('teamId', $teamId);
            $smarty->append('teamName', $teamName);
            $smarty->append('teamFGColor', $teamFGColor);
            $smarty->append('teamBGColor', $teamBGColor);
            $smarty->append('teamRep', $teamRep);
            $smarty->append('playerName', $name);
            $smarty->append('registrationId', $regId);
            $smarty->append('eMail', $email);
            $smarty->append('homePhone', $homePhone);
            $smarty->append('workPhone', $workPhone);
            $smarty->append('cellPhone', $cellPhone);
        }
    }
    //Setup teams without a team rep yet this season
    $columns = TEAMS . '.teamID, teamName, teamFGColor, teamBGColor';
    $subQuery = 'SELECT ' . TEAMSOFSEASONS . '.teamID FROM ' . TEAMSOFSEASONS;
    $subQuery.= ' JOIN ' . PLAYER . ' ON ' . TEAMSOFSEASONS . '.teamRep = ' . PLAYER . '.playerID';
    $subQuery.= ' WHERE ' . TEAMSOFSEASONS . '.seasonID=' . $SEASON;
    $select = 'SELECT ' . $columns . ' FROM ' . TEAMSOFSEASONS;
    $select.= ' JOIN ' . TEAMS . ' ON ' . TEAMSOFSEASONS . '.teamID = ' . TEAMS . '.teamID';
    $select.= ' WHERE ' . TEAMSOFSEASONS . '.seasonID=' . $SEASON;
    $select.= ' AND ' . TEAMSOFSEASONS . '.teamID NOT IN (' . $subQuery . ')';
    $teamsResult = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($teamsResult && mysql_num_rows($teamsResult) > 0) {
        while ($team = mysql_fetch_array($teamsResult, MYSQL_ASSOC)) {
            $teamCount++;
            $teamId = $team['teamID'];
            $teamName = $team['teamName'];
            $teamFGColor = $team['teamFGColor'];
            $teamBGColor = $team['teamBGColor'];
            $smarty->append('teamId', $teamId);
            $smarty->append('teamName', $teamName);
            $smarty->append('teamFGColor', $teamFGColor);
            $smarty->append('teamBGColor', $teamBGColor);
            $smarty->append('teamRep', 0);
            $smarty->append('playerName', '&nbsp;');
            $smarty->append('registrationId', '&nbsp;');
            $smarty->append('eMail', '&nbsp;');
            $smarty->append('homePhone', '&nbsp;');
            $smarty->append('workPhone', '&nbsp;');
            $smarty->append('cellPhone', '&nbsp;');
        }
    }
    $smarty->append('teamCount', $teamCount);
}
?>
