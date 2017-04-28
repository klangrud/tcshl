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
if ($_GET || $_POST) {
    //Must have team id
    if (isset($_GET['teamid']) && $_GET['teamid'] > 0) {
        $TEAMID = $_GET['teamid'];
    } else if (isset($_POST['teamid']) && $_POST['teamid'] > 0) {
        $TEAMID = $_POST['teamid'];
    } else {
        header("Location: teamrepmanager.php");
    }
    //Check for Rep Id
    if (isset($_GET['teamrep']) && $_GET['teamrep'] > 0) {
        $TEAMREP = $_GET['teamrep'];
    } else if (isset($_POST['teamrep']) && $_POST['teamrep'] > 0) {
        $TEAMREP = $_POST['teamrep'];
    } else {
        $TEAMREP = 0;
    }
} else {
    header("Location: teamrepmanager.php");
}
$teamName = get_team_name($TEAMID);
$smarty->assign('teamName', $teamName);
$smarty->assign('currentTeamRep', $TEAMREP);
$smarty->assign('teamid', $TEAMID);
setup_rep_form();
if ((isset($_POST['action'])) && ($_POST['action'] == "Edit Rep")) {
    process_editrep_form();
    header("Location: teamrepmanager.php");
}
$pageName = 'Edit Team Rep for ' . $teamName;
$smarty->assign('page_name', $pageName);
// Build the page
require ('global_begin.php');
$smarty->display('admin/editteamrep.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
/*
 * Setup Rep Form
*/
function setup_rep_form() {
    global $smarty;
    global $Link;
    global $SEASON;
    global $TEAMID;
    $select = 'SELECT playerID, playerFName, playerLName FROM ' . PLAYER . ' WHERE seasonId=' . $SEASON . ' ORDER BY playerLName';
    $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $smarty->assign('playerId', array());
        $smarty->assign('playerName', array());
        while ($rep = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $playerId = $rep['playerID'];
            $playerName = $rep['playerFName'] . ' ' . $rep['playerLName'];
            $smarty->append('playerId', $playerId);
            $smarty->append('playerName', $playerName);
        }
    }
}
/*
 * Process Rep Form
*/
function process_editrep_form() {
    global $Link;
    global $SEASON;
    global $TEAMREP;
    global $TEAMID;
    $update = 'UPDATE ' . TEAMSOFSEASONS . ' SET teamRep=' . $TEAMREP . ' WHERE seasonID=' . $SEASON . ' AND teamID=' . $TEAMID;
    $result = mysql_query($update, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
}
?>
