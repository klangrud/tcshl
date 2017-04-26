<?php
/*
 * Created on Sep 14, 2007
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
$smarty->assign('page_name', 'Registration Notes');
setup_registration_notes();
// Build the page
require ('global_begin.php');
$smarty->display('admin/viewregistrationnotes.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_registration_notes() {
    global $smarty;
    global $SEASON;
    global $Link;
    $notesSelectColumns = 'registrationId,fName,lName,travelingWithWho,notes';
    $notesSelect = 'SELECT ' . $notesSelectColumns . ' FROM ' . REGISTRATION . ' WHERE seasonId=' . $SEASON . ' AND (travelingWithWho != "" OR notes != "") ORDER BY lName';
    $notesResult = mysql_query($notesSelect, $Link);
    if ($notesResult && mysql_num_rows($notesResult) > 0) {
        $smarty->assign('registrationId', array());
        $smarty->assign('fname', array());
        $smarty->assign('lname', array());
        $smarty->assign('travelingWithWho', array());
        $smarty->assign('notes', array());
        while ($registrant = mysql_fetch_array($notesResult, MYSQL_ASSOC)) {
            $registrationId = $registrant['registrationId'];
            $fname = $registrant['fName'];
            $lname = $registrant['lName'];
            if (strlen($registrant['travelingWithWho']) > 0) {
                $travelingWithWho = $registrant['travelingWithWho'];
            } else {
                $travelingWithWho = '';
            }
            if (strlen($registrant['notes']) > 0) {
                $notes = $registrant['notes'];
            } else {
                $notes = '';
            }
            $smarty->append('registrationId', $registrationId);
            $smarty->append('fname', $fname);
            $smarty->append('lname', $lname);
            $smarty->append('travelingWithWho', $travelingWithWho);
            $smarty->append('notes', $notes);
        }
    }
}
?>
