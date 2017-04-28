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
if (this_season_has_teams()) {
    $playerid = 0;
    $playerName = "";
    $jersey1 = 0;
    $jersey2 = 0;
    $jersey3 = 0;
    $manual = 0;
    $location = 'players';
    if ($_GET || $_POST) {
        if (isset($_GET['playerid']) && $_GET['playerid'] > 0) {
            $playerid = $_GET['playerid'];
        } else if (isset($_POST['playerid']) && $_POST['playerid'] > 0) {
            $playerid = $_POST['playerid'];
        } else {
            header("Location: $location.php");
        }
        if (isset($_GET['manual']) && $_GET['manual'] > 0) {
            $manual = $_GET['manual'];
        } else if (isset($_POST['manual']) && $_POST['manual'] > 0) {
            $manual = $_POST['manual'];
        }
        if (isset($_GET['location'])) {
            $location = $_GET['location'];
        } else if (isset($_POST['location'])) {
            $location = $_POST['location'];
        }
        //Set players jersey choices
        if ($manual > 0) {
            set_manual_player_info();
        } else {
            set_player_info();
        }
        $smarty->assign('playerid', $playerid);
        $smarty->assign('playerName', $playerName);
        $smarty->assign('jersey1', $jersey1);
        $smarty->assign('jersey2', $jersey2);
        $smarty->assign('jersey3', $jersey3);
        $smarty->assign('location', $location);
        setup_jersey_warning_info();
        setup_team_already_on();
        setup_team_select();
        setup_jersey_select();
    }
    if ((isset($_POST['action'])) && ($_POST['action'] == "Add Player to Roster")) {
        process_assignplayerteam_form();
        header("Location: $location.php");
    }
} else {
    $smarty->assign('no_teams_this_season', true);
    $smarty->assign('season', get_season_name($SEASON));
} // If teams exist for this season
$page_name = 'Assign ' . $playerName . ' to Team';
$smarty->assign('page_name', $page_name);
// Build the page
require ('global_begin.php');
$smarty->display('admin/assignplayerteam.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
/*
 * See if this season has teams yet.
*/
function this_season_has_teams() {
    global $SEASON;
    global $Link;
    $teamsThisSeasonExistSQL = 'SELECT count(*) as totalTeamsThisSeason FROM ' . TEAMSOFSEASONS . ' WHERE seasonID=' . $SEASON;
    $teamsThisSeasonExistResult = mysql_query($teamsThisSeasonExistSQL, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    $totalTeamsThisSeason = 0;
    if ($teamsThisSeasonExistResult) {
        if (mysql_num_rows($teamsThisSeasonExistResult) > 0) {
            $teamsThisSeasonCount = mysql_fetch_assoc($teamsThisSeasonExistResult);
            $totalTeamsThisSeason = $teamsThisSeasonCount['totalTeamsThisSeason'];
        }
    }
    if ($totalTeamsThisSeason > 0) {
        return true;
    } else {
        return false;
    }
}
/*
 * Manual player addition.  Not based on registration.
*/
function set_manual_player_info() {
    global $SEASON;
    global $playerid;
    global $playerName;
    global $Link;
    $columns = 'playerFName,playerLName';
    $select = 'SELECT ' . $columns . ' FROM ' . PLAYER . ' WHERE ' . PLAYER . '.playerID=' . $playerid . ' AND ' . PLAYER . '.seasonId=' . $SEASON;
    $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $player = mysql_fetch_assoc($result);
        $playerName = $player['playerFName'] . ' ' . $player['playerLName'];
    }
}
/*
 * Set this players jersey choices
*/
function set_player_info() {
    global $SEASON;
    global $playerid;
    global $playerName;
    global $jersey1;
    global $jersey2;
    global $jersey3;
    global $Link;
    $jerseySelectColumns = 'playerFName,playerLName,jerseyNumberOne,jerseyNumberTwo,jerseyNumberThree';
    $jerseySelect = 'SELECT ' . $jerseySelectColumns . ' FROM ' . PLAYER . ' JOIN ' . REGISTRATION . ' ON ' . PLAYER . '.playerId = ' . REGISTRATION . '.playerId WHERE ' . PLAYER . '.playerId=' . $playerid . ' AND ' . REGISTRATION . '.seasonId=' . $SEASON;
    $jerseyResult = mysql_query($jerseySelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($jerseyResult && mysql_num_rows($jerseyResult) > 0) {
        $player = mysql_fetch_assoc($jerseyResult);
        $playerName = $player['playerFName'] . ' ' . $player['playerLName'];
        $jersey1 = $player['jerseyNumberOne'];
        $jersey2 = $player['jerseyNumberTwo'];
        $jersey3 = $player['jerseyNumberThree'];
    }
}
/*
 *
*/
function setup_jersey_warning_info() {
    global $smarty;
    global $SEASON;
    global $jersey1;
    global $jersey2;
    global $jersey3;
    global $Link;
    $jerseyWarningSelectColumns = ROSTERSOFTEAMSOFSEASONS . '.teamID,teamName,' . ROSTERSOFTEAMSOFSEASONS . '.playerID,playerFName,playerLName,' . ROSTERSOFTEAMSOFSEASONS . '.jerseyNumber';
    $jerseyWarningSelect = 'SELECT ' . $jerseyWarningSelectColumns . ' FROM ' . ROSTERSOFTEAMSOFSEASONS . ' JOIN ' . TEAMS . ' ON ' . TEAMS . '.teamID = ' . ROSTERSOFTEAMSOFSEASONS . '.teamID JOIN ' . PLAYER . ' ON ' . PLAYER . '.playerID = ' . ROSTERSOFTEAMSOFSEASONS . '.playerID WHERE (' . ROSTERSOFTEAMSOFSEASONS . '.jerseyNumber=' . $jersey1 . ' OR ' . ROSTERSOFTEAMSOFSEASONS . '.jerseyNumber=' . $jersey2 . ' OR ' . ROSTERSOFTEAMSOFSEASONS . '.jerseyNumber=' . $jersey3 . ') AND ' . ROSTERSOFTEAMSOFSEASONS . '.seasonID=' . $SEASON;
    $jerseyWarningResult = mysql_query($jerseyWarningSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($jerseyWarningResult && mysql_num_rows($jerseyWarningResult) > 0) {
        $jwConfictsCount = 0;
        $smarty->assign('jwConflictNum', array());
        $smarty->assign('jwTeamName', array());
        $smarty->assign('jwPlayerName', array());
        $smarty->assign('jwJerseyNumber', array());
        while ($jw = mysql_fetch_array($jerseyWarningResult, MYSQL_ASSOC)) {
            $jwConfictsCount++;
            $jwTeamName = $jw['teamName'];
            $jwPlayerName = $jw['playerFName'] . ' ' . $jw['playerLName'];
            $jwJerseyNumber = $jw['jerseyNumber'];
            $smarty->append('jwConflictNum', $jwConfictsCount);
            $smarty->append('jwTeamName', $jwTeamName);
            $smarty->append('jwPlayerName', $jwPlayerName);
            $smarty->append('jwJerseyNumber', $jwJerseyNumber);
        }
        $smarty->assign('jwConfictsCount', $jwConfictsCount);
    }
}
/*
 * Setup team player is already on - Since people can now be on more than one team.
*/
function setup_team_already_on() {
    global $smarty;
    global $SEASON;
    global $playerid;
    global $Link;
    $teamAlreadyOnSelect = 'SELECT teamName FROM ' . ROSTERSOFTEAMSOFSEASONS . ' JOIN ' . TEAMS . ' ON ' . TEAMS . '.teamID = ' . ROSTERSOFTEAMSOFSEASONS . '.teamID WHERE playerID=' . $playerid . ' AND seasonId=' . $SEASON;
    $teamsAlreadyOnResult = mysql_query($teamAlreadyOnSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($teamsAlreadyOnResult && mysql_num_rows($teamsAlreadyOnResult) > 0) {
        $countAlreadyOnTeams = 0;
        $smarty->assign('teamAlreadyOnName', array());
        while ($team = mysql_fetch_array($teamsAlreadyOnResult, MYSQL_ASSOC)) {
            $countAlreadyOnTeams++;
            $aoTeamName = $team['teamName'];
            $smarty->append('teamAlreadyOnName', $aoTeamName);
        }
        $smarty->assign('countAlreadyOnTeams', $countAlreadyOnTeams);
    }
}
/*
 * Setup teams that can be chosen to put this playerId onto.
*/
function setup_team_select() {
    global $smarty;
    global $SEASON;
    global $playerid;
    global $Link;
    $teamCandidatesSelect = 'SELECT teamID, teamName FROM ' . TEAMS . ' WHERE teamID NOT IN (SELECT teamID FROM ' . ROSTERSOFTEAMSOFSEASONS . ' WHERE playerID=' . $playerid . ' AND seasonId=' . $SEASON . ')';
    $teamCandidatesSelect.= ' AND teamID In (SELECT teamID FROM ' . TEAMSOFSEASONS . ' WHERE seasonID=' . $SEASON . ')';
    $teamsCandidatesResult = mysql_query($teamCandidatesSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
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
/*
 * Setup jersey number select
*/
function setup_jersey_select() {
    global $smarty;
    global $jersey1;
    $jerseySelect = '<select name="jerseyNumber">';
    for ($i = 0;$i < 100;$i++) {
        if ($i != $jersey1) {
            $jerseySelect.= '<option value="' . $i . '">' . $i . '</option>';
        } else {
            $jerseySelect.= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
        }
    }
    $jerseySelect.= '</select>';
    $smarty->assign('jerseySelect', $jerseySelect);
}
/*
 * Assign player to a team
*/
function process_assignplayerteam_form() {
    global $SEASON;
    global $playerid;
    global $Link;
    $teamId = $_POST['candidateTeams'];
    $jerseyNumber = $_POST['jerseyNumber'];
    $assignPlayerInsert = 'INSERT INTO ' . ROSTERSOFTEAMSOFSEASONS . ' (`seasonID`,`teamID`,`playerID`,`jerseyNumber`) VALUES (' . $SEASON . ',' . $teamId . ',' . $playerid . ',' . $jerseyNumber . ')';
    mysql_query($assignPlayerInsert, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
}
?>
