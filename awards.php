<?php
/*
 * Created on Sep 16, 2008
 *
*/
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');
// Set for every page
require ('engine/common.php');
$smarty->assign('page_name', 'League Awards');
setup_award_list();
// Build the page
require ('global_begin.php');
$smarty->display('public/awards.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_award_list() {
    global $smarty;
    global $Link;
    $selectColumns = 'awardID, award, recipient, seasonName';
    $awardsSelect = 'SELECT ' . $selectColumns . ' FROM ' . AWARDS;
    $awardsSelect.= ' JOIN ' . SEASONS . ' ON ' . AWARDS . '.seasonID=' . SEASONS . '.seasonId';
    $awardsSelect.= ' ORDER BY seasonName DESC, priority, award';
    $awardsResult = mysql_query($awardsSelect, $Link);
    if ($awardsResult) {
        if (mysql_num_rows($awardsResult) > 0) {
            $countAwards = 0;
            $smarty->assign('awardID', array());
            $smarty->assign('awardName', array());
            $smarty->assign('seasonName', array());
            while ($award = mysql_fetch_array($awardsResult, MYSQL_ASSOC)) {
                $countAwards++;
                $awardId = $award['awardID'];
                $awardName = $award['award'];
                $recipient = $award['recipient'];
                $seasonName = $award['seasonName'];
                $smarty->append('awardID', $awardId);
                $smarty->append('awardName', $awardName);
                $smarty->append('recipient', $recipient);
                $smarty->append('seasonName', $seasonName);
            }
            $smarty->assign('countAwards', $countAwards);
        }
    }
}
?>