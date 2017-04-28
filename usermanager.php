<?php
/*
 * Created on Oct 3, 2007
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
$smarty->assign('page_name', 'Site User Manager');
setup_user_list();
// Build the page
require ('global_begin.php');
$smarty->display('admin/usermanager.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_user_list() {
    global $smarty;
    global $Link;
    $selectColumns = 'userID,firstName,lastName,eMail,registeredDate,accessLevel,requestedPlayerStats,playerId';
    $userSelect = 'SELECT ' . $selectColumns . ' FROM ' . USER . ' WHERE userID > 1 ORDER BY accessLevel DESC,lastName';
    $userResult = mysql_query($userSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($userResult && mysql_num_rows($userResult) > 0) {
        $countUsers = 0;
        $smarty->assign('userID', array());
        $smarty->assign('name', array());
        $smarty->assign('userName', array());
        $smarty->assign('registeredDate', array());
        $smarty->assign('accessLevel', array());
        $smarty->assign('reqPlayerId', array());
        $smarty->assign('reqPlayerName', array());
        $smarty->assign('playerId', array());
        $smarty->assign('playerName', array());
        while ($user = mysql_fetch_array($userResult, MYSQL_ASSOC)) {
            $countUsers++;
            $userID = $user['userID'];
            $name = $user['firstName'] . ' ' . $user['lastName'];
            $userName = $user['eMail'];
            $registeredDate = $user['registeredDate'];
            $accessLevel = $user['accessLevel'];
            $reqPlayerId = $user['requestedPlayerStats'];
            if ($reqPlayerId > 0) {
                $reqPlayerName = get_player_name($reqPlayerId);
            } else {
                $reqPlayerId = - 1;
                $reqPlayerName = 'NO ONE';
            }
            $playerId = $user['playerId'];
            if ($playerId > 0) {
                $playerName = get_player_name($playerId);
            } else {
                $playerId = - 1;
                $playerName = 'NO ONE';
            }
            $smarty->append('userID', $userID);
            $smarty->append('name', $name);
            $smarty->append('userName', $userName);
            $smarty->append('registeredDate', $registeredDate);
            $smarty->append('accessLevel', $accessLevel);
            $smarty->append('reqPlayerId', $reqPlayerId);
            $smarty->append('reqPlayerName', $reqPlayerName);
            $smarty->append('playerId', $playerId);
            $smarty->append('playerName', $playerName);
        }
        $smarty->assign('countUsers', $countUsers);
    }
}
?>
