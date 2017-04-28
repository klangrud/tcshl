<?php
/*
 * Created on Sep 16, 2008
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
$pageName = get_season_name($SEASON) . ' Referee Balances';
$smarty->assign('page_name', $pageName);
setup_balances();
// Build the page
require ('global_begin.php');
$smarty->display('admin/refereebalance.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_balances() {
    global $smarty;
    global $SEASON;
    global $Link;
    $select = 'SELECT ' . REFEREESOFSEASONS . '.playerID, level FROM ' . REFEREESOFSEASONS . ' JOIN ' . PLAYER . ' ON  ' . REFEREESOFSEASONS . '.playerID = ' . PLAYER . '.playerID WHERE ' . REFEREESOFSEASONS . '.seasonID=' . $SEASON . ' ORDER BY level DESC, playerLName';
    $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $countRefs = 0;
        $smarty->assign('playerID', array());
        $smarty->assign('playerName', array());
        $smarty->assign('level', array());
        $smarty->assign('gamesReffed', array());
        $smarty->assign('balance', array());
        while ($player = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $countRefs++;
            $playerId = $player['playerID'];
            $playerName = get_player_name($player['playerID']);
            $level = $player['level'];
            $gamesReffed = get_games_reffed($playerId);
            $balance = calculate_balance($level, $gamesReffed);
            $smarty->append('playerID', $playerId);
            $smarty->append('playerName', $playerName);
            $smarty->append('level', $level);
            $smarty->append('gamesReffed', $gamesReffed);
            $smarty->append('balance', $balance);
        }
        $smarty->assign('countRefs', $countRefs);
    }
}
function get_games_reffed($pid) {
    global $SEASON;
    global $Link;
    $gr_select = 'SELECT count(*) AS GAMES_REFFED FROM ' . GAME . ' WHERE seasonId=' . $SEASON . ' AND (gameReferee1 = ' . $pid . ' OR gameReferee2 = ' . $pid . ' OR gameReferee3 = ' . $pid . ') AND gameGuestScore >= 0 AND gameHomeScore >= 0';
    $gr_result = mysql_query($gr_select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($gr_result && mysql_num_rows($gr_result) > 0) {
        $games = mysql_fetch_assoc($gr_result);
        return $games['GAMES_REFFED'];
    } else {
        return 0;
    }
}
function calculate_balance($level, $gamesReffed) {
    //setlocale(LC_MONETARY, 'en_US');
    if ($level == 1) {
        return '$' . number_format(10.00 * $gamesReffed, 2);
    } else if ($level == 2) {
        return '$' . number_format(15.00 * $gamesReffed, 2);
    } else if ($level == 3) {
        return '$' . number_format(20.00 * $gamesReffed, 2);
    } else {
        return '$' . number_format(0.00, 2);
    }
}
?>
