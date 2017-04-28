<?php
/*
 * Created on Sep 18, 2007
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
if (isset($_POST['gametype'])) {
    $GAME_TYPE = $_POST['gametype'];
} else if (isset($_GET['gametype'])) {
    $GAME_TYPE = $_GET['gametype'];
}
if (isset($GAME_TYPE) && ($GAME_TYPE == 'season' || $GAME_TYPE == 'pre' || $GAME_TYPE == 'post')) {
    //Do nothing
    
} else {
    $GAME_TYPE = get_current_game_type();
}
if ($GAME_TYPE == 'pre') {
    $gametype = 'Pre';
} else if ($GAME_TYPE == 'season') {
    $gametype = 'Regular';
} else if ($GAME_TYPE == 'post') {
    $gametype = 'Post';
} else {
    $gametype = '';
}
$pageName = get_season_name($SEASON) . ' ' . $gametype . ' Season Team Standings';
$smarty->assign('page_name', $pageName);
get_other_seasons();
// Setup schedule
require ('includes/inc_standings.php');
// Build the page
require ('global_begin.php');
$smarty->display('public/standings.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function get_other_seasons() {
    global $SEASON;
    global $smarty;
    $otherActiveSeasons = 'SELECT distinct seasonId FROM ' . GAME . ' WHERE seasonID != ' . $SEASON;
    $query = 'SELECT * FROM ' . SEASONS . ' WHERE seasonId IN (' . $otherActiveSeasons . ') ORDER BY seasonName DESC';
    $result = mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $smarty->assign('seasonID', array());
        $smarty->assign('seasonName', array());
        while ($season = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $smarty->append('seasonID', $season['seasonId']);
            $smarty->append('seasonName', $season['seasonName']);
        }
    }
}
?>