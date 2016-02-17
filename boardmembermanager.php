<?php
/*
 * Created on Sep 18, 2009
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

require_once('com/tcshl/board/BoardMember.php');
require_once('com/tcshl/board/BoardMembers.php');

$smarty->assign('div_newobject_style', 'display: none');
$smarty->assign('page_name', 'Board Member Manager');

// Handle posts
if(isset ($_POST['action'])) {
	// if Form post of a new board member
	if ($_POST['action'] == "Add New Board Member") {
		$boardMember = new BoardMember(0);
		// If form does not validate, we need to return with errors.
		if ($boardMember->formValidation()) {
			handle_errors($boardMember->get_boardMemberFormErrors());
			$boardMember->formReposts($smarty);
			$smarty->assign('div_newobject_style', 'display: block');
		} else {
			// If errors occur while trying to create board member, we need to return with errors.
			if ($boardMember->formProcessInsert()) {
				handle_errors($boardMember->get_boardMemberFormErrors());
				$boardMember->formReposts($smarty);
				$smarty->assign('div_newobject_style', 'display: block');
			} else {
				handle_success($boardMember->get_boardMemberFormSuccess());
			}		
		}
	}
	// else if Form post of an edit to a board member
	else if ($_POST['action'] == "Edit Board Member") {
		$boardMember = new BoardMember($_POST['boardMemberID']);
		// If form does not validate, we need to return with errors.
		if ($boardMember->formValidation()) {
			handle_errors($boardMember->get_boardMemberFormErrors());
			$boardMember->formReposts($smarty);
		} else {
			// If errors occur while trying to create board member, we need to return with errors.
			if ($boardMember->formProcessUpdate()) {
				handle_errors($boardMember->get_boardMemberFormErrors());
				$boardMember->formReposts($smarty);
			} else {
				handle_success($boardMember->get_boardMemberFormSuccess());
			}		
		}
	}
}


// if GET request to Delete board member
if(isset($_GET['boardMemberID']) && $_GET['boardMemberID'] > 0 && $_GET['delete'] == 1) {
	$boardMember = new BoardMember($_GET['boardMemberID']);
	if ($boardMember->formProcessDelete()) {
		handle_errors($boardMember->get_boardMemberFormErrors());
		$boardMember->formReposts($smarty);
	} else {
		handle_success($boardMember->get_boardMemberFormSuccess());
	}	
}


// Build list of board members
$BoardMembers = new BoardMembers();
$BoardMembersArray = $BoardMembers->get_BoardMemberArray(0);

if(count($BoardMembersArray) > 0) {
	$count=0;
	$smarty->assign('boardMemberID', array ());
	$smarty->assign('boardMemberName', array ());	
	$smarty->assign('boardMemberFirstName', array ());
	$smarty->assign('boardMemberLastName', array ());	
	$smarty->assign('boardMemberEmail', array ());
	$smarty->assign('boardMemberHomePhone', array ());
	$smarty->assign('boardMemberWorkPhone', array ());
	$smarty->assign('boardMemberCellPhone', array ());
	$smarty->assign('boardMemberDuties', array ());
	$smarty->assign('boardMemberImageSize', array ());
	$smarty->assign('div_editobject_style', array());     
	foreach($BoardMembersArray as $BoardMember) {				
		$count++;
		$smarty->append('boardMemberID', $BoardMember->get_boardMemberID());
		$smarty->append('boardMemberName', $BoardMember->get_boardMemberFirstName().' '.$BoardMember->get_boardMemberLastName());
		$smarty->append('boardMemberFirstName', $BoardMember->get_boardMemberFirstName());
		$smarty->append('boardMemberLastName', $BoardMember->get_boardMemberLastName());	
		$smarty->append('boardMemberEmail', $BoardMember->get_boardMemberEmail());				
		$smarty->append('boardMemberHomePhone', $BoardMember->get_boardMemberHomePhone());
		$smarty->append('boardMemberWorkPhone', $BoardMember->get_boardMemberWorkPhone());
		$smarty->append('boardMemberCellPhone', $BoardMember->get_boardMemberCellPhone());
		$smarty->append('boardMemberDuties', $BoardMember->get_boardMemberDuties());
		if($BoardMember->get_boardMemberImageWidth() > 0) {
			$smarty->append('boardMemberImageSize', imageSize($BoardMember->get_boardMemberImageWidth(), $BoardMember->get_boardMemberImageWidth(), $BoardMember->get_imageMaxWidth()));
		} else {
			$smarty->append('boardMemberImageSize', 0);
		}
		if(isset($boardMember) && $boardMember->get_boardMemberID() > 0 && $boardMember->get_boardMemberID() == $BoardMember->get_boardMemberID() && count($boardMember->get_boardMemberFormErrors()) > 0 && count($boardMember->get_boardMemberFormSuccess()) == 0) {
			$smarty->append('div_editobject_style', 'display: block');
		} else {
			$smarty->append('div_editobject_style', 'display: none');
		}		
	}
	$smarty->assign('count', $count);
}

// Build the page
require ('global_begin.php');
$smarty->display('admin/boardmembermanager.tpl');
require ('global_end.php');
?>
