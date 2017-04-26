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
$registrantid = 0;
if ($_GET) {
    if (isset($_GET['registrantid']) && $_GET['registrantid'] > 0) {
        $registrantid = $_GET['registrantid'];
    } else {
        header("Location: manageregistrations.php");
    }
}
activate_registration();
header("Location: manageregistrations.php");
// Build the page
//require ('global_begin.php');
//$smarty->display('admin/registrantdetails.tpl');
//require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function activate_registration() {
    global $registrantid;
    global $SEASON;
    $playerExists = true; //We will asume true to avoid any accidental duplicate insertion
    global $Link;
    #See if player already exists.  Do not wanna any duplicates.
    $playerExistsCheckSQL = 'SELECT playerID FROM ' . PLAYER . ' WHERE registrationId=' . $registrantid . ' AND seasonId=' . $SEASON;
    $playerExistsCheckResult = mysql_query($playerExistsCheckSQL, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($playerExistsCheckResult) {
        if (mysql_num_rows($playerExistsCheckResult) > 0) {
            $playerExists = true;
        } else {
            $playerExists = false;
        }
    } else {
        //Error selecting from database
        
    }
    #Create new player
    if (!$playerExists) {
        $newPlayerSQL = 'SELECT fName, lName, skillLevel, paymentPlan FROM ' . REGISTRATION . ' WHERE registrationId=' . $registrantid;
        $newPlayerResult = mysql_query($newPlayerSQL, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if ($newPlayerResult) {
            if (mysql_num_rows($newPlayerResult) > 0) {
                $newPlayer = mysql_fetch_assoc($newPlayerResult);
                $newPlayerFName = $newPlayer['fName'];
                $newPlayerLName = $newPlayer['lName'];
                $newPlayerSkillLevel = $newPlayer['skillLevel'];
                $newPlayerPaymentPlan = $newPlayer['paymentPlan'];
                $createPlayerColumns = '`playerFName`,`playerLName`,`playerSkillLevel`,`registrationId`,`seasonId`';
                $createPlayerSQL = 'INSERT INTO ' . PLAYER . ' (' . $createPlayerColumns . ') ';
                $createPlayerSQL.= 'VALUES("' . $newPlayerFName . '",';
                $createPlayerSQL.= '"' . $newPlayerLName . '",';
                $createPlayerSQL.= '' . $newPlayerSkillLevel . ',';
                $createPlayerSQL.= '' . $registrantid . ',';
                $createPlayerSQL.= '' . $SEASON;
                $createPlayerSQL.= ')';
                $createPlayerResult = mysql_query($createPlayerSQL, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
                #If new player was created we want to set the playerId for that registrant in registration table.
                if ($createPlayerResult) {
                    $playerId = mysql_insert_id();
                    $setPlayerIdSQL = 'UPDATE ' . REGISTRATION . ' SET playerId=' . $playerId . ', registrationApproved=1 WHERE registrationId=' . $registrantid;
                    $setPlayerIdResult = mysql_query($setPlayerIdSQL, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
                    // Insert player into payment table
                    insert_player_into_payment_table($registrantid, $newPlayerPaymentPlan);
                }
            }
        }
    }
}
?>
