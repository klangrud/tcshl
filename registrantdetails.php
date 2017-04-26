<?php
/*
 * Created on Aug 29, 2007
 *
*/
// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');
// Set for every page
require ('engine/common.php');
$smarty->assign('page_name', 'Registrant Details');
$registrantid = 0;
if ($_GET) {
    if (isset($_GET['registrantid']) && $_GET['registrantid'] > 0) {
        $registrantid = $_GET['registrantid'];
    } else {
        header("Location: manageregistrations.php");
    }
}
setup_registrant_details();
// Build the page
require ('global_begin.php');
$smarty->display('admin/registrantdetails.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_registrant_details() {
    global $smarty;
    global $registrantid;
    global $Link;
    $registrantSelect = 'SELECT * FROM ' . REGISTRATION . ' JOIN ' . SKILLLEVELS . ' ON ' . REGISTRATION . '.skillLevel = ' . SKILLLEVELS . '.skillLevelID AND registrationId=' . $registrantid;
    $registrantResult = mysql_query($registrantSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($registrantResult && mysql_num_rows($registrantResult) > 0) {
        $registrant = mysql_fetch_assoc($registrantResult);
        $smarty->assign('seasonId', get_season_name($registrant['seasonId']));
        $smarty->assign('registrationId', $registrant['registrationId']);
        $smarty->assign('playerId', $registrant['playerId']);
        if (isset($registrant['playerId']) && $registrant['playerId'] > 0) {
            $smarty->assign('playerName', get_player_name($registrant['playerId']));
        }
        $smarty->assign('fname', $registrant['fName']);
        $smarty->assign('lname', $registrant['lName']);
        $smarty->assign('address', $registrant['addressOne'] . ' ' . $registrant['addressTwo'] . '; ' . $registrant['city'] . ', ' . $registrant['state'] . '  ' . $registrant['postalCode']);
        $smarty->assign('email', $registrant['eMail']);
        $smarty->assign('position', $registrant['position']);
        $smarty->assign('jerseySize', $registrant['jerseySize']);
        $smarty->assign('jerseyNumberOne', $registrant['jerseyNumberOne']);
        $smarty->assign('jerseyNumberTwo', $registrant['jerseyNumberTwo']);
        $smarty->assign('jerseyNumberThree', $registrant['jerseyNumberThree']);
        $smarty->assign('homePhone', $registrant['homePhone']);
        $smarty->assign('workPhone', $registrant['workPhone']);
        $smarty->assign('cellPhone', $registrant['cellPhone']);
        $smarty->assign('skillLevel', $registrant['skillLevelName']);
        $smarty->assign('wantToSub', $registrant['wantToSub']);
        $smarty->assign('subSunday', $registrant['subSunday']);
        $smarty->assign('subMonday', $registrant['subMonday']);
        $smarty->assign('subTuesday', $registrant['subTuesday']);
        $smarty->assign('subWednesday', $registrant['subWednesday']);
        $smarty->assign('subThursday', $registrant['subThursday']);
        $smarty->assign('subFriday', $registrant['subFriday']);
        $smarty->assign('subSaturday', $registrant['subSaturday']);
        $smarty->assign('travelingWithWho', $registrant['travelingWithWho']);
        $smarty->assign('wantToBeATeamRep', $registrant['wantToBeATeamRep']);
        $smarty->assign('wantToBeARef', $registrant['wantToBeARef']);
        $smarty->assign('paymentPlan', $registrant['paymentPlan']);
        $smarty->assign('registrationApproved', $registrant['registrationApproved']);
        $smarty->assign('additionalNotes', $registrant['notes']);
        $smarty->assign('drilLeague', $registrant['drilLeague']);
        $smarty->assign('payToday', $registrant['payToday']);
        if (strlen($registrant['usaHockeyMembership']) > 0) {
            $smarty->assign('usaHockeyMembership', $registrant['usaHockeyMembership']);
        } else {
            $smarty->assign('usaHockeyMembership', 'NONE');
        }
        $skillDiv = "";
        if ($registrant['skillLevelID'] == 1) {
            $skillDiv = "beginDiv";
        } else if ($registrant['skillLevelID'] == 2) {
            $skillDiv = "leveloneDiv";
        } else if ($registrant['skillLevelID'] == 3) {
            $skillDiv = "leveltwoDiv";
        } else if ($registrant['skillLevelID'] == 4) {
            $skillDiv = "levelthreeDiv";
        } else if ($registrant['skillLevelID'] == 5) {
            $skillDiv = "levelfourDiv";
        }
        $smarty->assign('skillDivId', $skillDiv);
    }
}
?>
