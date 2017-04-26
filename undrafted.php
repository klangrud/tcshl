<?php
/*
 * Created on Sep 13, 2007
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
//Set meta refresh on this page
$smarty->assign('metaRefresh', get_site_variable_value("DRAFT"));
$smarty->assign('seasonName', get_season_name($SEASON));
$smarty->assign('page_name', 'Undrafted Players');
$smarty->assign('currentDate', date('l, F j, Y  g:i:s a'));
// Setup draft information
setup_undrafted_list();
// Build the page
require ('global_begin.php');
$smarty->display('admin/undrafted.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_undrafted_list() {
    global $smarty;
    global $SEASON;
    global $Link;
    $draftedListSubQuery = 'SELECT playerId FROM ' . DRAFT . ' WHERE seasonId=' . $SEASON;
    $undraftedListSubQueryColumns = 'playerFName,playerLName,skillLevelName,position';
    $undraftedListSelect = 'SELECT ' . $undraftedListSubQueryColumns;
    $undraftedListSelect.= ' FROM ' . PLAYER;
    $undraftedListSelect.= ' JOIN ' . REGISTRATION . ' ON ' . PLAYER . '.registrationId = ' . REGISTRATION . '.registrationId';
    $undraftedListSelect.= ' JOIN ' . SKILLLEVELS . ' ON ' . PLAYER . '.playerSkillLevel = ' . SKILLLEVELS . '.skillLevelID';
    $undraftedListSelect.= ' WHERE ' . PLAYER . '.seasonId=' . $SEASON;
    $undraftedListSelect.= ' AND ' . PLAYER . '.playerID NOT IN (' . $draftedListSubQuery . ')';
    $undraftedListSelect.= ' ORDER BY playerSkillLevel DESC ,playerLName';
    $undraftedListResult = mysql_query($undraftedListSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($undraftedListResult && mysql_num_rows($undraftedListResult) > 0) {
        $countPlayers = 0;
        $smarty->assign('playerFName', array());
        $smarty->assign('playerLName', array());
        $smarty->assign('skillLevelName', array());
        $smarty->assign('position', array());
        while ($player = mysql_fetch_array($undraftedListResult, MYSQL_ASSOC)) {
            $countPlayers++;
            $playerFName = $player['playerFName'];
            $playerLName = $player['playerLName'];
            $skillLevelName = $player['skillLevelName'];
            $playerPosition = $player['position'];
            $smarty->append('countPlayers', $countPlayers);
            $smarty->append('playerFName', $playerFName);
            $smarty->append('playerLName', $playerLName);
            $smarty->append('skillLevelName', $skillLevelName);
            $smarty->append('position', $playerPosition);
        }
        $smarty->assign('countPlayers', $countPlayers);
    }
}
?>
