<?php
/*
 * Created on Sep 18, 2007
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
$gameid = 0;
$gameGuestID = 0;
$gameHomeID = 0;
if ($_GET || $_POST) {
    if (isset($_GET['gameid']) && $_GET['gameid'] > 0) {
        $gameid = $_GET['gameid'];
    } else if (isset($_POST['gameid']) && $_POST['gameid'] > 0) {
        $gameid = $_POST['gameid'];
    } else {
        header("Location: gamemanager.php");
    }
}
if ((isset($_POST['action'])) && ($_POST['action'] == "Edit Refs")) {
    // If form does not validate, we need to return with errors.
    if ($errors = validate_editref_form()) {
        handle_errors($errors);
        //handle_reposts();
        
    } else {
        // If errors occur while trying to create user, we need to return with errors.
        if ($errors = process_editref_form($smarty)) {
            handle_errors($errors);
            //handle_reposts();
            
        } else {
            $success = array();
            $success[] = 'Game referees updated successfully.';
            handle_success($success);
        }
    }
}
$smarty->assign('page_name', 'Edit Game Referees');
setup_game_info();
setup_current_game_refs();
setup_ref_form();
// Build the page
require ('global_begin.php');
$smarty->display('admin/editgamerefs.tpl');
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
function setup_ref_form() {
    global $smarty;
    setup_select_referee_candidates();
}
function setup_game_info() {
    global $smarty;
    global $gameid;
    global $gameGuestID;
    global $gameHomeID;
    global $Link;
    $gameInfoSelect = 'SELECT gameID,gameTime,gameGuestTeam,gameHomeTeam FROM ' . GAME;
    $gameInfoSelect.= ' WHERE gameID=' . $gameid;
    $gameInfoResult = mysql_query($gameInfoSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($gameInfoResult && mysql_num_rows($gameInfoResult) > 0) {
        $game = mysql_fetch_assoc($gameInfoResult);
        $smarty->assign('gameID', $game['gameID']);
        $smarty->assign('gameTime', date('D, M j, Y g:i a', $game['gameTime']));
        $gameGuestID = $game['gameGuestTeam'];
        $gameHomeID = $game['gameHomeTeam'];
        $smarty->assign('gameGuestTeam', get_editrefs_team_name($gameGuestID));
        $smarty->assign('gameHomeTeam', get_editrefs_team_name($gameHomeID));
    }
    //
    
}
function setup_current_game_refs() {
    global $smarty;
    global $gameid;
    global $Link;
    //$playersSelect = 'SELECT '.REFEREESOFSEASONS.'.playerID,playerFName,playerLName FROM '.REFEREESOFSEASONS.' JOIN '.PLAYER.' ON '.REFEREESOFSEASONS.'.playerID = '.PLAYER.'.playerID WHERE '.REFEREESOFSEASONS.'.seasonID='.$SEASON.' ORDER BY playerLName';
    $refSelect = 'SELECT gameReferee1,gameReferee2,gameReferee3 FROM ' . GAME;
    $refSelect.= ' WHERE gameID=' . $gameid;
    $refResult = mysql_query($refSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($refResult && mysql_num_rows($refResult) > 0) {
        $ref = mysql_fetch_assoc($refResult);
        $refOnePlayerId = $ref['gameReferee1'];
        $refTwoPlayerId = $ref['gameReferee2'];
        $refThreePlayerId = $ref['gameReferee3'];
        $refOnePlayerName = get_player_name($refOnePlayerId);
        $refTwoPlayerName = get_player_name($refTwoPlayerId);
        $refThreePlayerName = get_player_name($refThreePlayerId);
        $smarty->assign('refOnePlayerId', $refOnePlayerId);
        $smarty->assign('refTwoPlayerId', $refTwoPlayerId);
        $smarty->assign('refThreePlayerId', $refThreePlayerId);
        $smarty->assign('refOnePlayerName', $refOnePlayerName);
        $smarty->assign('refTwoPlayerName', $refTwoPlayerName);
        $smarty->assign('refThreePlayerName', $refThreePlayerName);
    }
    //
    
}
function setup_select_referee_candidates() {
    global $smarty;
    global $SEASON;
    global $gameGuestID;
    global $gameHomeID;
    global $Link;
    $playersSelectSubquery = 'SELECT playerID FROM ' . ROSTERSOFTEAMSOFSEASONS . ' WHERE (teamID = ' . $gameGuestID . ' || teamID = ' . $gameHomeID . ') AND seasonID=' . $SEASON;
    $playersSelect = 'SELECT ' . REFEREESOFSEASONS . '.playerID,playerFName,playerLName FROM ' . REFEREESOFSEASONS . ' JOIN ' . PLAYER . ' ON ' . REFEREESOFSEASONS . '.playerID = ' . PLAYER . '.playerID WHERE ' . REFEREESOFSEASONS . '.seasonID=' . $SEASON . ' AND ' . PLAYER . '.playerID NOT IN (' . $playersSelectSubquery . ') ORDER BY playerLName';
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
    //
    
}
/*
 * Get Team Name
*/
function get_editrefs_team_name($teamId) {
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
function validate_editref_form() {
    $errors = array();
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
function process_editref_form() {
    global $gameid;
    $errors = array();
    global $Link;
    $gameRef1 = 0;
    $gameRef2 = 0;
    $gameRef3 = 0;
    if (isset($_POST['ref1']) && ($_POST['ref1'] == 'delete' || $_POST['ref1'] > 0)) {
        $gameRef1 = $_POST['ref1'];
    }
    if (isset($_POST['ref2']) && ($_POST['ref2'] == 'delete' || $_POST['ref2'] > 0)) {
        $gameRef2 = $_POST['ref2'];
    }
    if (isset($_POST['ref3']) && ($_POST['ref3'] == 'delete' || $_POST['ref3'] > 0)) {
        $gameRef3 = $_POST['ref3'];
    }
    // Update Ref 1
    if ((isset($_POST['ref1']) && $_POST['ref1'] != "") && ($gameRef1 > 0 || $gameRef1 == 'delete')) {
        $editRefUpdate = 'UPDATE ' . GAME . ' SET';
        if ($gameRef1 == 'delete') {
            $gameRef1 = 0;
        }
        $editRefUpdate.= ' `gameReferee1` = ' . $gameRef1 . ' WHERE gameID=' . $gameid;
        mysql_query($editRefUpdate, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    }
    // Update Ref 2
    if ((isset($_POST['ref2']) && $_POST['ref2'] != "") && ($gameRef2 > 0 || $gameRef2 == 'delete')) {
        $editRefUpdate = 'UPDATE ' . GAME . ' SET';
        if ($gameRef2 == 'delete') {
            $gameRef2 = 0;
        }
        $editRefUpdate.= ' `gameReferee2` = ' . $gameRef2 . ' WHERE gameID=' . $gameid;
        mysql_query($editRefUpdate, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    }
    // Update Ref 3
    if ((isset($_POST['ref3']) && $_POST['ref3'] != "") && ($gameRef3 > 0 || $gameRef3 == 'delete')) {
        $editRefUpdate = 'UPDATE ' . GAME . ' SET';
        if ($gameRef3 == 'delete') {
            $gameRef3 = 0;
        }
        $editRefUpdate.= ' `gameReferee3` = ' . $gameRef3 . ' WHERE gameID=' . $gameid;
        mysql_query($editRefUpdate, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    }
    return $errors;
}
?>
