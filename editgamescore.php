<?php
/*
 * Created on Sep 18, 2007
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

$gameid = 0;
$gameGuestScore = 0;
$gameHomeScore = 0;

if($_GET || $_POST) {
	if(isset($_GET['gameid']) && $_GET['gameid'] > 0) {
		$gameid = $_GET['gameid'];
	} else if(isset($_POST['gameid']) && $_POST['gameid'] > 0) {
		$gameid = $_POST['gameid'];
	} else {
		header("Location: gamemanager.php");
	}	
}

if ((isset ($_POST['action'])) && ($_POST['action'] == "Edit Game Score")) {
	// If form does not validate, we need to return with errors.
		// If errors occur while trying to create user, we need to return with errors.
		if ($errors = process_editscore_form($smarty)) {
			handle_errors($errors);
			//handle_reposts();
		} else {
			$success = array ();
			$success[] = 'Game score updated successfully.';
			handle_success($success);
		}
}

$smarty->assign('page_name', 'Edit Game Score');

setup_game_info();
setup_score_form();

// Build the page
require ('global_begin.php');
$smarty->display('admin/editgamescore.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

function setup_game_info() {
	global $smarty;
	global $gameid;
  global $gameGuestScore;
  global $gameHomeScore;	
	
	global $Link;
	
	$gameInfoSelect = 'SELECT gameID,gameTime,gameGuestTeam,gameHomeTeam,gameGuestScore,gameHomeScore FROM '.GAME;
	$gameInfoSelect .= ' WHERE gameID='.$gameid;
	
	$gameInfoResult = mysql_query($gameInfoSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
	if ($gameInfoResult && mysql_num_rows($gameInfoResult) > 0) {
	  $game = mysql_fetch_assoc($gameInfoResult);			

    $gameGuestID = $game['gameGuestTeam'];
    $gameHomeID = $game['gameHomeTeam'];
	  $gameGuestScore = $game['gameGuestScore'];
		$gameHomeScore = $game['gameHomeScore'];    

	  $smarty->assign('gameID', $game['gameID']);
    $smarty->assign('gameTime', date('D, M j, Y g:i a',$game['gameTime']));
	  $smarty->assign('gameGuestTeam', get_score_team_name($gameGuestID));
	  $smarty->assign('gameHomeTeam', get_score_team_name($gameHomeID));
		$smarty->assign('gameGuestScore', $gameGuestScore);
		$smarty->assign('gameHomeScore', $gameHomeScore); 
	  
	}
	//	
		
}

function setup_score_form() {
	global $smarty;
	global $gameid;
  global $gameGuestScore;
  global $gameHomeScore;
  
  $gameGuestScoreSelect = '<select name="gameGuestScore">';
  for($i = 0; $i <= 30; $i++) {
  	if($i == $gameGuestScore) {
  		$gameGuestScoreSelect .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
  	} else {
  		$gameGuestScoreSelect .= '<option value="'.$i.'">'.$i.'</option>';
  	}
  }
  $gameGuestScoreSelect .= '</select>';
  $smarty->assign('gameGuestScoreSelect',$gameGuestScoreSelect);
  
  $gameHomeScoreSelect = '<select name="gameHomeScore">';
  for($i = 0; $i <= 30; $i++) {
  	if($i == $gameHomeScore) {
  		$gameHomeScoreSelect .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
  	} else {  	
  		$gameHomeScoreSelect .= '<option value="'.$i.'">'.$i.'</option>';
  	}
  }
  $gameHomeScoreSelect .= '</select>';
  $smarty->assign('gameHomeScoreSelect',$gameHomeScoreSelect); 
}

/*
 * Get Team Name
 */
 function get_score_team_name($teamId) {
	$teamName = "";
	
	global $Link;
	
	$teamSelect = 'SELECT teamName FROM '.TEAMS.' WHERE teamID='.$teamId;
	
	$teamResult = mysql_query($teamSelect, $Link);
	
	if ($teamResult && mysql_num_rows($teamResult) > 0) {
		$team = mysql_fetch_assoc($teamResult);
		$teamName = $team['teamName'];
	}
	

	return $teamName;
} 

function process_editscore_form() {
	global $gameid;
	$errors = array();
	
	global $Link;

  $gameGuestScore = 0;
	$gameHomeScore = 0;
	
	if(isset($_POST['gameGuestScore']) && $_POST['gameGuestScore'] >= 0) {
		$gameGuestScore = $_POST['gameGuestScore'];
	}
	if(isset($_POST['gameHomeScore']) && $_POST['gameHomeScore'] >= 0) {
		$gameHomeScore = $_POST['gameHomeScore'];
	}	

  $editScoreUpdate = 'UPDATE '.GAME;
	$editScoreUpdate .= ' SET';	
  $editScoreUpdate .= ' `gameGuestScore` = '.$gameGuestScore;
  $editScoreUpdate .= ', `gameHomeScore` = '.$gameHomeScore;
	$editScoreUpdate .= ' WHERE gameID='.$gameid;

	$editScoreUpdateResult = mysql_query($editScoreUpdate, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	
		
	return $errors;	
}
?>
