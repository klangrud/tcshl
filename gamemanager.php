<?php
/*
 * Created on Sep 11, 2007
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
setup_game_form();
if ((isset($_POST['action'])) && ($_POST['action'] == "Add Game")) {
    // If form does not validate, we need to return with errors.
    if ($errors = validate_addgame_form()) {
        handle_errors($errors);
        //handle_reposts();
        
    } else {
        // If errors occur while trying to create user, we need to return with errors.
        if ($errors = process_addgame_form($smarty)) {
            handle_errors($errors);
            //handle_reposts();
            
        } else {
            $success = array();
            $success[] = 'Game was added successfully.';
            handle_success($success);
        }
    }
}
if ((isset($_GET['teamid'])) && ($_GET['teamid'] > 0)) {
    $TEAM = $_GET['teamid'];
}
$smarty->assign('page_name', 'Game Manager');
$smarty->assign('managermode', 1);
// Setup schedule
require ('includes/inc_schedule.php');
// Build the page
require ('global_begin.php');
$smarty->display('admin/gamemanager.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
/*
 * Setup game submit form
*/
function setup_game_form() {
    global $smarty;
    $smarty->assign('monthSelect', select_month('1'));
    $smarty->assign('daySelect', select_day('1'));
    $smarty->assign('yearSelect', select_year('1'));
    $smarty->assign('hourSelect', select_hour('1'));
    $smarty->assign('minuteSelect', select_minute('1'));
    $smarty->assign('ampmSelect', select_ampm('1'));
    setup_select_team_candidates();
    setup_select_referee_candidates();
}
function setup_select_team_candidates() {
    global $smarty;
    global $SEASON;
    global $Link;
    $teamsSelect = 'SELECT ' . TEAMSOFSEASONS . '.teamID,teamName FROM ' . TEAMSOFSEASONS . ' JOIN ' . TEAMS . ' ON ' . TEAMSOFSEASONS . '.teamID = ' . TEAMS . '.teamID WHERE seasonID=' . $SEASON . ' ORDER BY teamName';
    $teamsResult = mysql_query($teamsSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($teamsResult && mysql_num_rows($teamsResult) > 0) {
        $smarty->assign('teamCandidateId', array());
        $smarty->assign('teamCandidateName', array());
        while ($team = mysql_fetch_array($teamsResult, MYSQL_ASSOC)) {
            $teamId = $team['teamID'];
            $teamName = $team['teamName'];
            $smarty->append('teamCandidateId', $teamId);
            $smarty->append('teamCandidateName', $teamName);
        }
    }
}
function setup_select_referee_candidates() {
    global $smarty;
    global $SEASON;
    global $Link;
    $playersSelect = 'SELECT ' . REFEREESOFSEASONS . '.playerID,playerFName,playerLName FROM ' . REFEREESOFSEASONS . ' JOIN ' . PLAYER . ' ON ' . REFEREESOFSEASONS . '.playerID = ' . PLAYER . '.playerID WHERE ' . REFEREESOFSEASONS . '.seasonID=' . $SEASON . ' ORDER BY playerLName';
    $playersResult = mysql_query($playersSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($playersResult && mysql_num_rows($playersResult) > 0) {
        $smarty->assign('playerCandidateId', array());
        $smarty->assign('playerCandidateName', array());
        while ($player = mysql_fetch_array($playersResult, MYSQL_ASSOC)) {
            $playerId = $player['playerID'];
            $playerName = $player['playerFName'] . ' ' . $player['playerLName'];
            $smarty->append('playerCandidateId', $playerId);
            $smarty->append('playerCandidateName', $playerName);
        }
    }
}
function validate_addgame_form() {
    $errors = array();
    if (isset($_POST['guest']) && isset($_POST['home'])) {
        if ($_POST['guest'] == $_POST['home']) {
            $errors[] = 'Teams cannot play themselves.';
        }
    }
    if (isset($_POST['ref1']) && $_POST['ref1'] > 0 && isset($_POST['ref2']) && $_POST['ref2'] > 0) {
        if ($_POST['ref1'] == $_POST['ref2']) {
            $errors[] = 'Referee 1 and 2 are the same person.';
        }
    }
    if (isset($_POST['ref1']) && $_POST['ref1'] > 0 && isset($_POST['ref3']) && $_POST['ref3'] > 0) {
        if ($_POST['ref1'] == $_POST['ref3']) {
            $errors[] = 'Referee 1 and 3 are the same person.';
        }
    }
    if (isset($_POST['ref2']) && $_POST['ref2'] > 0 && isset($_POST['ref3']) && $_POST['ref3'] > 0) {
        if ($_POST['ref2'] == $_POST['ref3']) {
            $errors[] = 'Referee 2 and 3 are the same person.';
        }
    }
    return $errors;
}
function process_addgame_form() {
    global $SEASON;
    $errors = array();
    global $Link;
    $hour = $_POST['hour'];
    if ($_POST['ampm'] == "PM") {
        $hour = $hour + 12;
    }
    $gameTimeEpoch = mktime($hour, $_POST['minute'], 0, $_POST['month'], $_POST['day'], $_POST['year'], -1);
    $gameRef1 = 0;
    $gameRef2 = 0;
    $gameRef3 = 0;
    $postponed = 0;
    if (isset($_POST['ref1']) && $_POST['ref1'] > 0) {
        $gameRef1 = $_POST['ref1'];
    }
    if (isset($_POST['ref2']) && $_POST['ref2'] > 0) {
        $gameRef2 = $_POST['ref2'];
    }
    if (isset($_POST['ref3']) && $_POST['ref3'] > 0) {
        $gameRef3 = $_POST['ref3'];
    }
    $addGameInsert = 'INSERT INTO ' . GAME . ' (`seasonId`,`gameType`,`gameTime`,`gameGuestTeam`,`gameHomeTeam`,`gameReferee1`,`gameReferee2`,`gameReferee3`,`postponed`)';
    $addGameInsert.= ' VALUES(' . $SEASON . ',"' . $_POST['gametype'] . '",' . $gameTimeEpoch . ',' . $_POST['guest'] . ',' . $_POST['home'] . ',' . $gameRef1 . ',' . $gameRef2 . ',' . $gameRef3 . ',' . $postponed . ')';
    $addGameInsertResult = mysql_query($addGameInsert, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    return $errors;
}
?>
