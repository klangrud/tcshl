<?php
/*
 * Created on Aug 28, 2007
 *
*/
// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');
// Set for every page
require ('engine/common.php');
require_once ('com/tcshl/registration/Registration.php');
// Delete Registration
if ((isset($_GET['deleteregistrationid'])) && ($_GET['deleteregistrationid'] > 0)) {
    $registration = new Registration($_GET['deleteregistrationid']);
    $registration->delete_registration();
    handle_errors($registration->get_formErrors());
    handle_success($registration->get_formSuccess());
}
$smarty->assign('page_name', 'Manage Registrations - ' . get_season_name($SEASON) . ' Season');
setup_registration_lists();
// Build the page
require ('global_begin.php');
$smarty->display('admin/manageregistrations.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_registration_lists() {
    global $smarty;
    global $SEASON;
    global $Link;
    $selectColumns = 'registrationId,playerId,fName,lName,addressOne,addressTwo,city,state,postalCode,eMail,homePhone,workPhone,cellPhone';
    $approvedRegistrations = 'SELECT ' . $selectColumns . ' FROM ' . REGISTRATION . ' WHERE registrationApproved=1 AND SeasonId=' . $SEASON . ' ORDER BY fName,lName';
    $approvedResult = mysql_query($approvedRegistrations, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($approvedResult) {
        if (mysql_num_rows($approvedResult) > 0) {
            $countApproved = 0;
            $smarty->assign('approvedRegistrations', "TRUE");
            $smarty->assign('registrationId', array());
            $smarty->assign('playerName', array());
            $smarty->assign('fname', array());
            $smarty->assign('lname', array());
            $smarty->assign('address', array());
            $smarty->assign('email', array());
            $smarty->assign('homephone', array());
            $smarty->assign('workphone', array());
            $smarty->assign('cellphone', array());
            while ($registrant = mysql_fetch_array($approvedResult, MYSQL_ASSOC)) {
                $countApproved++;
                $registrationId = $registrant['registrationId'];
                if (isset($registrant['playerId']) && $registrant['playerId'] > 0) {
                    $playername = get_player_name($registrant['playerId']);
                } else {
                    $playername = 'None Assigned';
                }
                $fname = $registrant['fName'];
                $lname = $registrant['lName'];
                $address = $registrant['addressOne'] . ' ' . $registrant['addressTwo'] . '<br />' . $registrant['city'] . ', ' . $registrant['state'] . '  ' . $registrant['postalCode'];
                if (strlen($registrant['eMail']) > 0) {
                    $email = $registrant['eMail'];
                } else {
                    $email = "&nbsp;";
                }
                if (strlen($registrant['homePhone']) > 0) {
                    $homephone = $registrant['homePhone'];
                } else {
                    $homephone = "&nbsp;";
                }
                if (strlen($registrant['workPhone']) > 0) {
                    $workphone = $registrant['workPhone'];
                } else {
                    $workphone = "&nbsp;";
                }
                if (strlen($registrant['cellPhone']) > 0) {
                    $cellphone = $registrant['cellPhone'];
                } else {
                    $cellphone = "&nbsp;";
                }
                $smarty->append('registrationId', $registrationId);
                $smarty->append('playerName', $playername);
                $smarty->append('fname', $fname);
                $smarty->append('lname', $lname);
                $smarty->append('address', $address);
                $smarty->append('email', $email);
                $smarty->append('homephone', $homephone);
                $smarty->append('workphone', $workphone);
                $smarty->append('cellphone', $cellphone);
            }
            $smarty->assign('countApproved', $countApproved);
        }
    }
    $unapprovedRegistrations = 'SELECT ' . $selectColumns . ' FROM ' . REGISTRATION . ' WHERE registrationApproved=0 AND SeasonId=' . $SEASON . ' ORDER BY fName,lName';
    $unapprovedResult = mysql_query($unapprovedRegistrations, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($unapprovedResult) {
        if (mysql_num_rows($unapprovedResult) > 0) {
            $countUnapproved = 0;
            $smarty->assign('unapprovedRegistrations', "TRUE");
            $smarty->assign('naregistrationId', array());
            $smarty->assign('nafname', array());
            $smarty->assign('nalname', array());
            $smarty->assign('naaddress', array());
            $smarty->assign('naemail', array());
            $smarty->assign('nahomephone', array());
            $smarty->assign('naworkphone', array());
            $smarty->assign('nacellphone', array());
            while ($registrant = mysql_fetch_array($unapprovedResult, MYSQL_ASSOC)) {
                $countUnapproved++;
                $registrationId = $registrant['registrationId'];
                $fname = $registrant['fName'];
                $lname = $registrant['lName'];
                $address = $registrant['addressOne'] . ' ' . $registrant['addressTwo'] . '<br />' . $registrant['city'] . ', ' . $registrant['state'] . '  ' . $registrant['postalCode'];
                if (strlen($registrant['eMail']) > 0) {
                    $email = $registrant['eMail'];
                } else {
                    $email = "&nbsp;";
                }
                if (strlen($registrant['homePhone']) > 0) {
                    $homephone = $registrant['homePhone'];
                } else {
                    $homephone = "&nbsp;";
                }
                if (strlen($registrant['workPhone']) > 0) {
                    $workphone = $registrant['workPhone'];
                } else {
                    $workphone = "&nbsp;";
                }
                if (strlen($registrant['cellPhone']) > 0) {
                    $cellphone = $registrant['cellPhone'];
                } else {
                    $cellphone = "&nbsp;";
                }
                $smarty->append('naregistrationId', $registrationId);
                $smarty->append('nafname', $fname);
                $smarty->append('nalname', $lname);
                $smarty->append('naaddress', $address);
                $smarty->append('naemail', $email);
                $smarty->append('nahomephone', $homephone);
                $smarty->append('naworkphone', $workphone);
                $smarty->append('nacellphone', $cellphone);
            }
            $smarty->assign('countUnapproved', $countUnapproved);
        }
    }
}
?>