<?php
/*
 * Created on Sep 12, 2007
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

if ((isset ($_POST['action'])) && ($_POST['action'] == "Draft Player")) {
	process_draftmode_form($smarty);
	$success = array ();
	$success[] = 'Player successfully Picked.';
	handle_success($success);
} else if ((isset ( $_GET )) &&
           ((isset ( $_GET['deletepick'] )) && (( $_GET['deletepick'] ) == 'true')) &&
           ((isset ( $_GET['seasonId'] )) && (( $_GET['seasonId'] ) > 0)) &&
		   ((isset ( $_GET['playerId'] )) && (( $_GET['playerId'] ) > 0)) &&
		   ((isset ( $_GET['round'] )) && (( $_GET['round'] ) > 0)) &&
		   ((isset ( $_GET['teamId'] )) && (( $_GET['teamId'] ) > 0))) {
           	delete_draft_pick($_GET['seasonId'],$_GET['playerId'],$_GET['round'],$_GET['teamId']);
			$success = array ();
			$success[] = 'Draft pick successfully deleted.';
			handle_success($success);           	
}

// Setup draft information
$setCurrentRound = 0;
require ('includes/inc_draftstatus.php');
require ('includes/inc_draftresults.php');
setup_draft_form();

// Build the page
require ('global_begin.php');
$smarty->display('global/includes/inc_draftstatus.tpl');
$smarty->display('admin/draftmode.tpl');
$smarty->display('global/includes/inc_draftresults.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

/*
 * Setup game submit form
 */
function setup_draft_form() {
	global $smarty;
	setup_select_team_candidates();
	setup_select_player_candidates();
}


function setup_select_team_candidates() {
	global $smarty;
	global $SEASON;
	global $currentRound;
	
	global $Link;
	
	$teamsWithThisRoundPickQuery = 'SELECT teamId FROM '.DRAFT.' WHERE round='.$currentRound.' AND seasonId='.$SEASON;
	
	$teamsSelect = 'SELECT '.TEAMSOFSEASONS.'.teamID,teamName FROM '.TEAMSOFSEASONS.' JOIN '.TEAMS.' ON '.TEAMSOFSEASONS.'.teamID = '.TEAMS.'.teamID WHERE seasonID='.$SEASON.' AND '.TEAMS.'.teamId != 7 AND '.TEAMS.'.teamId != 14 AND '.TEAMS.'.teamId NOT IN ('.$teamsWithThisRoundPickQuery.') ORDER BY teamName';
		
	$teamsResult = mysql_query($teamsSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
		if ($teamsResult && mysql_num_rows($teamsResult) > 0) {			
		  $smarty->assign('teamCandidateId', array ());
		  $smarty->assign('teamCandidateName', array ());
            
			while ($team = mysql_fetch_array($teamsResult, MYSQL_ASSOC)) {
				$teamId = $team['teamID'];
				$teamName = $team['teamName'];

				$smarty->append('teamCandidateId', $teamId);
				$smarty->append('teamCandidateName', $teamName);         

			}
		}
	
}

function setup_select_player_candidates() {
	global $smarty;
	global $SEASON;
	
	global $Link;
	
	$playersSelect = 'SELECT playerID,playerFName,playerLName FROM '.PLAYER.' WHERE seasonID='.$SEASON.' ORDER BY playerLName';
	
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
	
}

function process_draftmode_form() {
	global $SEASON;	
	
	$errors = array();
	
	global $Link;
	
	$draftInsert = 'INSERT INTO '.DRAFT.' (`seasonId`,`playerID`,`teamID`,`round`)';
	$draftInsert .= ' VALUES('.$SEASON.','.$_POST['player'].','.$_POST['team'].','.$_POST['currentRound'].')';
	
	$draftInsertResult = mysql_query($draftInsert, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

	return $errors;		
}

function delete_draft_pick($delSeasonId='',$delPlayerId='',$delRound='',$delTeamId='') {
	$errors = array();
	
	global $Link;
	
	$draftDelete = 'DELETE FROM '.DRAFT.' WHERE seasonId='.$delSeasonId.' AND playerID='.$delPlayerId.' AND teamID='.$delTeamId.' AND round='.$delRound;
	
	mysql_query($draftDelete, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());	
	
	return $errors;		
}
?>
