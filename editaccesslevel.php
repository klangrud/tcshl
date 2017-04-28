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
if (isset($_GET['userid']) || isset($_POST['userid'])) {
    if (isset($_GET['userid']) && $_GET['userid'] > 0) {
        $USERID = $_GET['userid'];
    } else if (isset($_POST['userid']) && $_POST['userid'] > 0) {
        $USERID = $_POST['userid'];
    } else {
        header("Location: usermanager.php");
    }
} else {
    header("Location: usermanager.php");
}
$smarty->assign('userID', $USERID);
if (isset($_POST['action']) && $_POST['action'] == 'Assign Access Level') {
    process_accesslevel_form();
    header("Location: usermanager.php");
}
$smarty->assign('page_name', 'Edit Site Access Level');
set_user_info();
setup_select_level_candidates();
// Build the page
require ('global_begin.php');
$smarty->display('admin/editaccesslevel.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function set_user_info() {
    global $smarty;
    global $USERID;
    global $Link;
    $select = 'SELECT firstName,lastName,registeredDate,accessLevel FROM ' . USER . ' WHERE userID=' . $USERID;
    $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $user = mysql_fetch_assoc($result);
        $smarty->assign('name', $user['firstName'] . ' ' . $user['lastName']);
        $smarty->assign('registeredDate', $user['registeredDate']);
        $smarty->assign('userLevel', $user['accessLevel']);
    }
}
function setup_select_level_candidates() {
    global $smarty;
    $levelID = array();
    $levelID[] = 0;
    $levelID[] = 1;
    $levelID[] = 2;
    $levelName = array();
    $levelName[] = 'Not Active';
    $levelName[] = 'User';
    $levelName[] = 'Admin';
    $smarty->assign('accessLevelId', $levelID);
    $smarty->assign('accessLevelName', $levelName);
}
function process_accesslevel_form() {
    global $smarty;
    global $SEASON;
    global $Link;
    $insert = 'UPDATE ' . USER . ' SET accessLevel=' . $_POST['userlevel'] . ',registeredDate="' . $_POST['regdate'] . '" WHERE userID=' . $_POST['userid'];
    $result = mysql_query($insert, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
}
?>
