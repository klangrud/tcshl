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

if(isset($_GET['userid']) || isset($_POST['userid'])) {
	if(isset($_GET['userid']) && $_GET['userid'] > 0) {
		$USERID = $_GET['userid'];
	} else 	if(isset($_POST['userid']) && $_POST['userid'] > 0) {
		$USERID = $_POST['userid'];
	} else {
		header("Location: usermanager.php");
	}	
} else {
		header("Location: usermanager.php");
}

if(isset($_GET['reqplayerid']) && $_GET['reqplayerid'] > 0) {
	$REQUESTPLAYERID = $_GET['reqplayerid'];
}	else {
	$REQUESTPLAYERID = -1;
}

$smarty->assign('userID', $USERID);
$smarty->assign('reqPlayerID', $REQUESTPLAYERID);

if(isset($_POST['action']) && $_POST['action'] == 'Assign Watch Stat') {
	process_watchstat_form();
	header("Location: usermanager.php");
}

$smarty->assign('page_name', 'Edit Watching Stat');

set_user_info();
setup_select_player_candidates();

// Build the page
require ('global_begin.php');
$smarty->display('admin/editwatchstat.tpl');
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
	
	$select = 'SELECT firstName,lastName,registeredDate FROM '.USER.' WHERE userID='.$USERID;
	
	$result = mysql_query($select, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
	  $user = mysql_fetch_assoc($result);
	  
	  $smarty->assign('name', $user['firstName'].' '.$user['lastName']);
	  $smarty->assign('registeredDate', $user['registeredDate']);	
	}	
	
}

function setup_select_player_candidates() {
	global $smarty;	
	global $Link;
	
	$playersSelect = 'SELECT playerID,playerFName,playerLName FROM '.PLAYER.' ORDER BY playerLName';
	
	$playersResult = mysql_query($playersSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
		if ($playersResult && mysql_num_rows($playersResult) > 0) {			
		  $smarty->assign('playerCandidateId', array ());
		  $smarty->assign('playerCandidateName', array ());
            
			while ($player = mysql_fetch_array($playersResult, MYSQL_ASSOC)) {
				$playerId = $player['playerID'];
				$playerName = $player['playerFName'].' '.$player['playerLName'];

				$smarty->append('playerCandidateId', $playerId);
				$smarty->append('playerCandidateName', $playerName);         

			}
		}
	//
}

function process_watchstat_form() {
	global $smarty;	
	global $Link;
	
	$insert = 'UPDATE '.USER.' SET playerId='.$_POST['playerid'].',registeredDate="'.$_POST['regdate'].'" WHERE userID='.$_POST['userid'];
	
	$result = mysql_query($insert, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());	
}
?>
