<?php
/*
 * Created on Aug 23, 2007
 *
*/
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');
// Set for every page
require ('engine/common.php');
$smarty->assign('page_name', 'Welcome to TCSHL');
setup_announcements();
setup_sponsorships();
setup_boardmembers();
// Setup schedule for next ten days
require ('includes/inc_tenday_schedule.php');
// Build the page
require ('global_begin.php');
$smarty->display('public/index.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
/*
 * Setup announcements
*/
function setup_announcements() {
    global $smarty;
    global $Link;
    $currentTimeEpoch = time();
    $announceSelectColumns = 'announceId, announceTitle, announcement, ' . ANNOUNCEMENTS . '.userID, ' . USER . '.userID, firstName, lastName ';
    $announceSelect = "SELECT " . $announceSelectColumns . " FROM " . ANNOUNCEMENTS . " JOIN " . USER . " ON " . ANNOUNCEMENTS . ".userID = " . USER . ".userID WHERE announceBeginDate <= '" . $currentTimeEpoch . "' AND announceEndDate >= '" . $currentTimeEpoch . "' ORDER BY announceID DESC";
    $announceResult = mysql_query($announceSelect, $Link);
    if ($announceResult && mysql_num_rows($announceResult) > 0) {
        $smarty->assign('announcements', 1);
        $smarty->assign('announcementId', array());
        $smarty->assign('announcementTitle', array());
        $smarty->assign('announcementBody', array());
        $smarty->assign('userSubmitted', array());
        while ($announcement = mysql_fetch_array($announceResult, MYSQL_ASSOC)) {
            $announcementId = $announcement['announceId'];
            $announcementTitle = $announcement['announceTitle'];
            $announcementBody = $announcement['announcement'];
            $userSubmitted = format_initial($announcement['firstName']) . '. ' . $announcement['lastName'];
            $smarty->append('announcementId', $announcementId);
            $smarty->append('announcementTitle', $announcementTitle);
            $smarty->append('announcementBody', $announcementBody);
            $smarty->append('userSubmitted', $userSubmitted);
        }
    } else {
        $smarty->assign('announcements', 0);
    }
}
/*
 * Setup Sponsorships
*/
function setup_sponsorships() {
    global $smarty;
    global $Link;
    global $SEASON;
    $smarty->assign('SPONSOR_GROUP', 'League');
    $foundSeasonWithSponsors = false;
    $seasonTest = $SEASON;
    while (!$foundSeasonWithSponsors) {
        $select = 'SELECT * FROM ' . SPONSORSOFSEASONS . ' WHERE seasonID=' . $seasonTest . ' LIMIT 1';
        $result = mysql_query($select, $Link);
        if ($result && mysql_num_rows($result) > 0) {
            $foundSeasonWithSponsors = true;
        } else {
            $seasonTest--;
            if ($seasonTest == 0) {
                $foundSeasonWithSponsors = true;
            }
        }
    }
    if ($foundSeasonWithSponsors && $seasonTest != 0) {
        $selectColumns = 'sponsorID,sponsorName,sponsorLogoWidth, sponsorLogoHeight';
        $subQuery = 'SELECT distinct sponsorID FROM ' . SPONSORSOFSEASONS . ' WHERE seasonID=' . $seasonTest;
        $sponsorsSelect = 'SELECT ' . $selectColumns . ' FROM ' . SPONSORS . ' WHERE sponsorID IN (' . $subQuery . ') ORDER BY sponsorName';
        $sponsorsResult = mysql_query($sponsorsSelect, $Link);
        if ($sponsorsResult) {
            if (mysql_num_rows($sponsorsResult) > 0) {
                $countSponsors = 0;
                $smarty->assign('sponsorID', array());
                $smarty->assign('sponsorName', array());
                $smarty->assign('imageSize', array());
                while ($sponsor = mysql_fetch_array($sponsorsResult, MYSQL_ASSOC)) {
                    $countSponsors++;
                    $sponsorId = $sponsor['sponsorID'];
                    $sponsorName = $sponsor['sponsorName'];
                    $logoWidth = $sponsor['sponsorLogoWidth'];
                    $logoHeight = $sponsor['sponsorLogoHeight'];
                    $smarty->append('sponsorID', $sponsorId);
                    $smarty->append('sponsorName', $sponsorName);
                    if ($logoWidth > 0) {
                        $smarty->append('imageSize', imageSize($logoWidth, $logoHeight, 200));
                    } else {
                        $smarty->append('imageSize', 0);
                    }
                }
                $smarty->assign('countSponsors', $countSponsors);
            }
        }
    }
}
/*
 * Setup Board Members
*/
function setup_boardmembers() {
    global $smarty;
    require_once ('com/tcshl/board/BoardMember.php');
    require_once ('com/tcshl/board/BoardMembers.php');
    // Build list of board members
    $BoardMembers = new BoardMembers();
    $BoardMembersArray = $BoardMembers->get_BoardMemberArray(0);
    if (count($BoardMembersArray) > 0) {
        $boardMemberCount = 0;
        $smarty->assign('boardMemberID', array());
        $smarty->assign('boardMemberName', array());
        $smarty->assign('boardMemberFirstName', array());
        $smarty->assign('boardMemberLastName', array());
        $smarty->assign('boardMemberEmail', array());
        $smarty->assign('boardMemberHomePhone', array());
        $smarty->assign('boardMemberWorkPhone', array());
        $smarty->assign('boardMemberCellPhone', array());
        $smarty->assign('boardMemberDuties', array());
        foreach ($BoardMembersArray as $BoardMember) {
            $boardMemberCount++;
            $smarty->append('boardMemberID', $BoardMember->get_boardMemberID());
            $smarty->append('boardMemberName', $BoardMember->get_boardMemberFirstName() . ' ' . $BoardMember->get_boardMemberLastName());
            $smarty->append('boardMemberFirstName', $BoardMember->get_boardMemberFirstName());
            $smarty->append('boardMemberLastName', $BoardMember->get_boardMemberLastName());
            $smarty->append('boardMemberEmail', strToHex($BoardMember->get_boardMemberEmail()));
            $smarty->append('boardMemberHomePhone', $BoardMember->get_boardMemberHomePhone());
            $smarty->append('boardMemberWorkPhone', $BoardMember->get_boardMemberWorkPhone());
            $smarty->append('boardMemberCellPhone', $BoardMember->get_boardMemberCellPhone());
            $smarty->append('boardMemberDuties', $BoardMember->get_boardMemberDuties());
        }
        $smarty->assign('boardMemberCount', $boardMemberCount);
    }
}
?>

