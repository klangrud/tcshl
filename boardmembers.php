<?php
/*
 * Created on Sep 22, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
*/
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');
// Set for every page
require ('engine/common.php');
require_once ('com/tcshl/board/BoardMember.php');
require_once ('com/tcshl/board/BoardMembers.php');
$smarty->assign('div_newboardmember_style', 'display: none');
$smarty->assign('page_name', 'Current League Board');
// Build list of board members
$BoardMembers = new BoardMembers();
$BoardMembersArray = $BoardMembers->get_BoardMemberArray(0);
if (count($BoardMembersArray) > 0) {
    $count = 0;
    $smarty->assign('boardMemberID', array());
    $smarty->assign('boardMemberName', array());
    $smarty->assign('boardMemberFirstName', array());
    $smarty->assign('boardMemberLastName', array());
    $smarty->assign('boardMemberEmail', array());
    $smarty->assign('boardMemberHomePhone', array());
    $smarty->assign('boardMemberWorkPhone', array());
    $smarty->assign('boardMemberCellPhone', array());
    $smarty->assign('boardMemberDuties', array());
    $smarty->assign('boardMemberImageSize', array());
    foreach ($BoardMembersArray as $BoardMember) {
        $count++;
        $smarty->append('boardMemberID', $BoardMember->get_boardMemberID());
        $smarty->append('boardMemberName', $BoardMember->get_boardMemberFirstName() . ' ' . $BoardMember->get_boardMemberLastName());
        $smarty->append('boardMemberFirstName', $BoardMember->get_boardMemberFirstName());
        $smarty->append('boardMemberLastName', $BoardMember->get_boardMemberLastName());
        $smarty->append('boardMemberEmail', strToHex($BoardMember->get_boardMemberEmail()));
        $smarty->append('boardMemberHomePhone', $BoardMember->get_boardMemberHomePhone());
        $smarty->append('boardMemberWorkPhone', $BoardMember->get_boardMemberWorkPhone());
        $smarty->append('boardMemberCellPhone', $BoardMember->get_boardMemberCellPhone());
        $smarty->append('boardMemberDuties', $BoardMember->get_boardMemberDuties());
        if ($BoardMember->get_boardMemberImageWidth() > 0) {
            $smarty->append('boardMemberImageSize', imageSize($BoardMember->get_boardMemberImageWidth(), $BoardMember->get_boardMemberImageWidth(), $BoardMember->get_imageMaxWidth()));
        } else {
            $smarty->append('boardMemberImageSize', 0);
        }
    }
    $smarty->assign('count', $count);
}
// Build the page
require ('global_begin.php');
$smarty->display('public/boardmembers.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
?>
