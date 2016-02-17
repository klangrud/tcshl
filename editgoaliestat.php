<?php
/*
 * Created on Oct 29, 2007
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

// Get required variables
if($_GET || $_POST) {
	//Must have game id
	if(isset($_GET['gameid']) && $_GET['gameid'] > 0) {
		$GAMEID = $_GET['gameid'];
	} else if(isset($_POST['gameid']) && $_POST['gameid'] > 0) {
		$GAMEID = $_POST['gameid'];
	} else {
		header("Location: gamemanager.php");
	}
	
	//Must have player id
	if(isset($_GET['playerid']) && $_GET['playerid'] > 0) {
		$PLAYERID = $_GET['playerid'];
	} else if(isset($_POST['playerid']) && $_POST['playerid'] > 0) {
		$PLAYERID = $_POST['playerid'];
	} else {
		header("Location: managegamestats.php?gameid=$GAMEID");
	}	
	
	//Must have team id
	if(isset($_GET['teamid']) && $_GET['teamid'] > 0) {
		$TEAMID = $_GET['teamid'];
	} else if(isset($_POST['teamid']) && $_POST['teamid'] > 0) {
		$TEAMID = $_POST['teamid'];
	} else {
		header("Location: managegamestats.php?gameid=$GAMEID");
	}		
} else {
	header("Location: gamemanager.php");
}

if ((isset ($_POST['action'])) && ($_POST['action'] == "Edit Goalie Stat")) {
	// If form does not validate, we need to return with errors.
	if ($errors = validate_editgoaliestat_form()) {
		handle_errors($errors);
	} else {
		// If errors occur while trying to create user, we need to return with errors.
		if ($errors = process_editgoaliestat_form()) {
			handle_errors($errors);
		} else {
			header("Location: managegamestats.php?gameid=$GAMEID");
		}		
	}
}

$select = 'SELECT * FROM '.GOALIESTAT.' WHERE gameID='.$GAMEID.' AND playerID='.$PLAYERID.' AND teamID='.$TEAMID;

	$result = mysql_query($select, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
	if ($result && mysql_num_rows($result) > 0) {
	  $stat = mysql_fetch_assoc($result);			

	  $smarty->assign('gameID', $stat['gameID']);
	  $smarty->assign('playerID', $stat['playerID']);
	  $smarty->assign('playerName', get_player_name($stat['playerID']));
	  $smarty->assign('teamID', $stat['teamID']);
	  $smarty->assign('shots', $stat['shots']);
	  $smarty->assign('ga', $stat['goalsagainst']);	  
	}		
	
	
$smarty->assign('page_name', 'Edit Goalie Stat');

// Build the page
require ('global_begin.php');
$smarty->display('admin/editgoaliestat.tpl');
require ('global_end.php');	

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

function validate_editgoaliestat_form() {
		$errors = array();
		if(isset($_POST['shots']) && is_numeric($_POST['shots']) && is_int(intval($_POST['shots'])) && $_POST['shots'] >= 0) {
			//Shots checks out
		} else {
			$errors[] = 'Shots must be a number greater than or equal to zero.';
		}
		if(isset($_POST['ga']) && is_numeric($_POST['ga']) && is_int(intval($_POST['ga'])) && $_POST['ga'] >= 0) {
			//GA checks out
		} else {
			$errors[] = 'Goals Against must be a number greater than or equal to zero.';
		}
		return $errors;
}

function process_editgoaliestat_form() {
	global $smarty;
	global $GAMEID;
	global $PLAYERID;
	global $TEAMID;
	global $Link;
	
	//Process as goalie stat
	$gameid = $_POST['gameid'];
	$playerid = $_POST['playerid'];
	$teamid = $_POST['teamid'];
	$shots = $_POST['shots'];
	$ga = $_POST['ga'];
	
	$update = 'UPDATE '.GOALIESTAT;
	$update .= ' SET';
	$update .= ' shots='.$shots;
	$update .= ', goalsagainst='.$ga;
	$update .= ' WHERE gameID='.$GAMEID.' AND playerID='.$PLAYERID.' AND teamID='.$TEAMID;
	
	// Make insertion into database.
	$result = mysql_query($update, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());	
	
}

?>
