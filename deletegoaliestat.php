<?php
/*
 * Created on Oct 29, 2007
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
// Get required variables
if ($_GET || $_POST) {
    //Must have game id
    if (isset($_GET['gameid']) && $_GET['gameid'] > 0) {
        $GAMEID = $_GET['gameid'];
    } else if (isset($_POST['gameid']) && $_POST['gameid'] > 0) {
        $GAMEID = $_POST['gameid'];
    } else {
        header("Location: gamemanager.php");
    }
    //Must have player id
    if (isset($_GET['playerid']) && $_GET['playerid'] > 0) {
        $PLAYERID = $_GET['playerid'];
    } else if (isset($_POST['playerid']) && $_POST['playerid'] > 0) {
        $PLAYERID = $_POST['playerid'];
    } else {
        header("Location: managegamestats.php?gameid=$GAMEID");
    }
    //Must have team id
    if (isset($_GET['teamid']) && $_GET['teamid'] > 0) {
        $TEAMID = $_GET['teamid'];
    } else if (isset($_POST['teamid']) && $_POST['teamid'] > 0) {
        $TEAMID = $_POST['teamid'];
    } else {
        header("Location: managegamestats.php?gameid=$GAMEID");
    }
} else {
    header("Location: gamemanager.php");
}
$delete = 'DELETE FROM ' . GOALIESTAT . ' WHERE gameID=' . $GAMEID . ' AND playerID=' . $PLAYERID . ' AND teamID=' . $TEAMID;
$result = mysql_query($delete, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
header("Location: managegamestats.php?gameid=$GAMEID");
?>
