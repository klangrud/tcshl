<?php
/*
 * Created on Sep 20, 2007
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
if ((isset($_POST['action'])) && ($_POST['action'] == "Add Ref To Season")) {
    //No validation needed since we give them the values to post.
    process_addreftoseason_form($smarty);
}
$pageName = 'Referee Manager';
$smarty->assign('page_name', $pageName);
$smarty->assign('seasonName', get_season_name($SEASON));
setup_refs_this_season();
setup_ref_select();
// Build the page
require ('global_begin.php');
$smarty->display('admin/managereferees.tpl');
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
function process_addreftoseason_form($smarty) {
    global $SEASON;
    global $Link;
    $errors = array();
    $playerCandidateID = $_POST['candidatePlayers'];
    $level = $_POST['level'];
    //Check if user exists with accessLevel > 0.  If true, then we will just error out registration and explain that user exists.
    $query = 'INSERT INTO ' . REFEREESOFSEASONS . ' (`seasonID`, `playerID`, `level`) VALUES (' . $SEASON . ',' . $playerCandidateID . ',' . $level . ')';
    mysql_query($query, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
} // End of function
function setup_refs_this_season() {
    global $smarty;
    global $SEASON;
    global $Link;
    $refsThisSeasonSelect = 'SELECT ' . REFEREESOFSEASONS . '.playerID, level FROM ' . REFEREESOFSEASONS . ' JOIN ' . PLAYER . ' ON  ' . REFEREESOFSEASONS . '.playerID = ' . PLAYER . '.playerID WHERE ' . REFEREESOFSEASONS . '.playerID AND ' . REFEREESOFSEASONS . '.seasonID=' . $SEASON . ' ORDER BY level DESC, playerLName';
    $refsThisSeasonResult = mysql_query($refsThisSeasonSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($refsThisSeasonResult && mysql_num_rows($refsThisSeasonResult) > 0) {
        $countRefs = 0;
        $smarty->assign('playerID', array());
        $smarty->assign('playerName', array());
        $smarty->assign('level', array());
        while ($player = mysql_fetch_array($refsThisSeasonResult, MYSQL_ASSOC)) {
            $countRefs++;
            $playerId = $player['playerID'];
            $playerName = get_player_name($player['playerID']);
            $level = $player['level'];
            $smarty->append('playerID', $playerId);
            $smarty->append('playerName', $playerName);
            $smarty->append('level', $level);
        }
        $smarty->assign('countRefs', $countRefs);
    }
}
function setup_ref_select() {
    global $smarty;
    global $SEASON;
    global $Link;
    $subQuery = 'SELECT registrationId FROM ' . REGISTRATION . ' WHERE seasonId=' . $SEASON . ' AND wantToBeARef=1';
    $refCandidatesSelect = 'SELECT playerID, playerFName,playerLName FROM ' . PLAYER . ' WHERE playerID NOT IN (SELECT playerID FROM ' . REFEREESOFSEASONS . ' WHERE seasonID=' . $SEASON . ') AND seasonID=' . $SEASON . ' AND registrationId IN (' . $subQuery . ') ORDER BY playerLName';
    $refCandidatesResult = mysql_query($refCandidatesSelect, $Link);
    if ($refCandidatesResult && mysql_num_rows($refCandidatesResult) > 0) {
        $countCandidateRefs = 0;
        $smarty->assign('playerCandidateID', array());
        $smarty->assign('playerCandidateName', array());
        while ($player = mysql_fetch_array($refCandidatesResult, MYSQL_ASSOC)) {
            $countCandidateRefs++;
            $playerId = $player['playerID'];
            $playerName = $player['playerFName'] . ' ' . $player['playerLName'];
            $smarty->append('playerCandidateID', $playerId);
            $smarty->append('playerCandidateName', $playerName);
        }
        $smarty->assign('countCandidateRefs', $countCandidateRefs);
    }
}
?>
