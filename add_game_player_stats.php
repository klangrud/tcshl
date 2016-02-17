<?php
/*
 * Created on Sep 27, 2007
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

$GAMEID = 0;
$GUESTTEAM = 0;
$HOMETEAM = 0;
$allPlayersIDArray = array();
$allPlayersNamesArray = array();
$statsnum = 0;
$success = array();
$markedRepostArray = array();
$goalsRepostArray = array();
$assistsRepostArray = array();
$pimRepostArray = array();
$playerActiveRepostArray = array();
$statPlayerRepostArray = array();
$statGoalieRepostArray = array();
$shotsRepostArray = array();
$gaRepostArray = array();
$goalieActiveRepostArray = array();


if($_GET || $_POST) {
	if(isset($_GET['gameid']) && $_GET['gameid'] > 0) {
		$GAMEID = $_GET['gameid'];
	} else if(isset($_POST['gameid']) && $_POST['gameid'] > 0) {
		$GAMEID = $_POST['gameid'];
	} else {
		header("Location: gamemanager.php");
	}	
}

if(isset($_POST['action']) && $_POST['action'] == 'Add Game Stats') {
	// If form does not validate, we need to return with errors.
	if ($errors = validate_stats_form()) {
		handle_errors($errors);
	} else {
		// If errors occur while trying to create user, we need to return with errors.
		if ($errors = process_stats_form()) {
			handle_errors($errors);
		} else {
			header("Location: managegamestats.php?gameid=".$GAMEID);
		}		
	}	
	
}

$smarty->assign('page_name', 'Edit Game Player Stats');

$smarty->assign('gameid', $GAMEID);

//Setup this game's information
setup_game_info();

/*
 * This sets the variable arrays used by default load and repost.  Since the
 * stats are an all or none deal we can do this here.  Must happen after 
 * gameid, and team IDs are set.  This acts like a handle_repost method, except
 * that it will initialize the correct values if there is no post.
 */
$guestTeamPlayerArray = get_guest_team_players_without_game_stats();
$homeTeamPlayerArray = get_home_team_players_without_game_stats(); 
initialize_form_values();

// Setup players to enter stats for form
setup_players_stat_form();


$smarty->assign('statsnum',$statsnum);

// Build the page
require ('global_begin.php');
$smarty->display('admin/add_game_player_stats.tpl');
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
	global $GAMEID;
	global $GUESTTEAM;
	global $HOMETEAM;

	
	global $Link;
	
	$gameInfoSelect = 'SELECT gameID,gameTime,gameGuestTeam,gameHomeTeam FROM '.GAME;
	$gameInfoSelect .= ' WHERE gameID='.$GAMEID;
	
	$gameInfoResult = mysql_query($gameInfoSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
	if ($gameInfoResult && mysql_num_rows($gameInfoResult) > 0) {
	  $game = mysql_fetch_assoc($gameInfoResult);			

    $GUESTTEAM = $game['gameGuestTeam'];
    $HOMETEAM = $game['gameHomeTeam']; 

    $smarty->assign('gameTime', date('D, M j, Y g:i a',$game['gameTime']));
	  $smarty->assign('gameGuestTeam', get_team_name_stats($GUESTTEAM));
	  $smarty->assign('gameHomeTeam', get_team_name_stats($HOMETEAM));
	  
	}		
}

/*
 * Get Team Name
 */
 function get_team_name_stats($teamId) {
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

function setup_players_stat_form() {
	global $smarty;
	global $allPlayersIDArray;
	global $allPlayersNamesArray;
	global $statsnum;
	global $GUESTTEAM;
	global $HOMETEAM;
	global $guestTeamPlayerArray;
	global $homeTeamPlayerArray;
	global $markedRepostArray;
	global $goalsRepostArray;
	global $assistsRepostArray;
	global $pimRepostArray;
	global $playerActiveRepostArray;
	global $statPlayerRepostArray;
	global $statGoalieRepostArray;
	global $shotsRepostArray;
	global $gaRepostArray;
  global $goalieActiveRepostArray;	
	
	$overallStatNumber= -1;
	$statForm = '';
	
	$guestTeamPlayerArray = get_guest_team_players_without_game_stats();
	$homeTeamPlayerArray = get_home_team_players_without_game_stats();
	get_all_players();
	
  //Determine number of stat fields we have to sort throught
  $statsnum += (count($guestTeamPlayerArray) + 3) + (count($homeTeamPlayerArray) + 3);

	// Setup Guest Team Stat Form
	$statForm .= '<fieldset><legend>'.get_team_name_stats($GUESTTEAM).' Stats</legend>';
	$statForm .= '<table border="1" width="100%">';
	$statForm .= '<tr class="globalStatSectionHead"><td></td><td>Mark</td><td class="globalCenter">Name</td><td class="globalCenter">Player Stats</td><td class="globalCenter">P / G</td><td class="globalCenter">Goalie Stats</td></tr>';
	for($i = 0; $i < count($guestTeamPlayerArray) + 3; $i++) {
		$overallStatNumber++;
		$statForm .= '<tr><td class="globalCenter">';
		$statForm .= ($overallStatNumber + 1).'. ';
		$statForm .= '</td><td class="globalCenter">';
		$statForm .= '<input type="checkbox" name="submitstat'.$overallStatNumber.'" value="1" '.$markedRepostArray[$overallStatNumber].' />';
		$statForm .= '</td><td>';		
		$statForm .= '<select name="playerid'.$overallStatNumber.'">';
		
		//foreach statement to propogate players on team
		$statForm .= '<option value="0">&nbsp;</option>';
		for($j = 0; $j < count($allPlayersIDArray); $j++) {
			$statForm .= '<option value="'.$allPlayersIDArray[$j].'"';
			if($i < count($guestTeamPlayerArray)) {
				if($allPlayersIDArray[$j] == $guestTeamPlayerArray[$i]) {
					$statForm .= ' selected="selected"';
				}
			}
			$statForm .= ' >'.$allPlayersNamesArray[$j].'</option>';
		}		
		
		$statForm .= '</select>';
		$statForm .= '<input type="hidden" name="teamid'.$overallStatNumber.'" value="'.$GUESTTEAM.'" />';
		$statForm .= '</td><td>';
		$statForm .= '<label for="goals"> G: </label><input type="text" id="goals'.$overallStatNumber.'" name="goals'.$overallStatNumber.'" value="'.$goalsRepostArray[$overallStatNumber].'" size="3" '.$playerActiveRepostArray[$overallStatNumber].' />';
		$statForm .= '<label for="assists"> A: </label><input type="text" id="assists'.$overallStatNumber.'" name="assists'.$overallStatNumber.'" value="'.$assistsRepostArray[$overallStatNumber].'" size="3" '.$playerActiveRepostArray[$overallStatNumber].' />';
		$statForm .= '<label for="pim"> PIM: </label><input type="text" id="pim'.$overallStatNumber.'" name="pim'.$overallStatNumber.'" value="'.$pimRepostArray[$overallStatNumber].'" size="3" '.$playerActiveRepostArray[$overallStatNumber].' />';
		$statForm .= '</td><td class="globalCenter">';
		$statForm .= '<input name="stattype'.$overallStatNumber.'" type="radio" value="1" '.$statPlayerRepostArray[$overallStatNumber].' onmouseup="toggle_stat_type('.$overallStatNumber.',1)" onchange="toggle_stat_type('.$overallStatNumber.',1)" /> / <input name="stattype'.$overallStatNumber.'" type="radio" value="2" '.$statGoalieRepostArray[$overallStatNumber].' onmouseup="toggle_stat_type('.$overallStatNumber.',2)" onchange="toggle_stat_type('.$overallStatNumber.',2)" />';		
		$statForm .= '</td><td>';
		$statForm .= '<label for="shots"> SO: </label><input type="text" id="shots'.$overallStatNumber.'" name="shots'.$overallStatNumber.'" value="'.$shotsRepostArray[$overallStatNumber].'" size="3" '.$goalieActiveRepostArray[$overallStatNumber].' />';
		$statForm .= '<label for="ga"> GA: </label><input type="text" id="ga'.$overallStatNumber.'" name="ga'.$overallStatNumber.'" value="'.$gaRepostArray[$overallStatNumber].'" size="3" '.$goalieActiveRepostArray[$overallStatNumber].' />';
		$statForm .= '</td></tr>';
	}
	$statForm .= '</table>'; 
	$statForm .= '</fieldset>'; 
	
	$statForm .= '<br /><br />';
	
	// Setup Home Team Stat Form 
	$statForm .= '<fieldset><legend>'.get_team_name_stats($HOMETEAM).' Team Stats</legend>';
	$statForm .= '<table border="1" width="100%">';
	$statForm .= '<tr class="globalStatSectionHead"><td></td><td>Mark</td><td class="globalCenter">Name</td><td class="globalCenter">Player Stats</td><td class="globalCenter">P / G</td><td class="globalCenter">Goalie Stats</td></tr>';
	for($i = 0; $i < count($homeTeamPlayerArray) + 3; $i++) {
		$overallStatNumber++;
		$statForm .= '<tr><td class="globalCenter">';
		$statForm .= ($overallStatNumber + 1).'. ';
		$statForm .= '</td><td class="globalCenter">';
		$statForm .= '<input type="checkbox" name="submitstat'.$overallStatNumber.'" value="1" '.$markedRepostArray[$overallStatNumber].' />';
		$statForm .= '</td><td>';			
		$statForm .= '<select name="playerid'.$overallStatNumber.'">';
		
		//foreach statement to propogate players on team
		$statForm .= '<option value="0">&nbsp;</option>';
		for($j = 0; $j < count($allPlayersIDArray); $j++) {
			$statForm .= '<option value="'.$allPlayersIDArray[$j].'"';
			if($i < count($homeTeamPlayerArray)) {
				if($allPlayersIDArray[$j] == $homeTeamPlayerArray[$i]) {
					$statForm .= ' selected="selected"';
				}
			}
			$statForm .= ' >'.$allPlayersNamesArray[$j].'</option>';
		}		
		
		$statForm .= '</select>';
		$statForm .= '<input type="hidden" name="teamid'.$overallStatNumber.'" value="'.$HOMETEAM.'" />';
		$statForm .= '</td><td>';
		$statForm .= '<label for="goals"> G: </label><input type="text" id="goals'.$overallStatNumber.'" name="goals'.$overallStatNumber.'" value="'.$goalsRepostArray[$overallStatNumber].'" size="3" '.$playerActiveRepostArray[$overallStatNumber].' />';
		$statForm .= '<label for="assists"> A: </label><input type="text" id="assists'.$overallStatNumber.'" name="assists'.$overallStatNumber.'" value="'.$assistsRepostArray[$overallStatNumber].'" size="3" '.$playerActiveRepostArray[$overallStatNumber].' />';
		$statForm .= '<label for="pim"> PIM: </label><input type="text" id="pim'.$overallStatNumber.'" name="pim'.$overallStatNumber.'" value="'.$pimRepostArray[$overallStatNumber].'" size="3" '.$playerActiveRepostArray[$overallStatNumber].' />';
		$statForm .= '</td><td class="globalCenter">';
		$statForm .= '<input name="stattype'.$overallStatNumber.'" type="radio" value="1" CHECKED onmouseup="toggle_stat_type('.$overallStatNumber.',1)" onchange="toggle_stat_type('.$overallStatNumber.',1)" /> / <input name="stattype'.$overallStatNumber.'" type="radio" value="2" onmouseup="toggle_stat_type('.$overallStatNumber.',2)" onchange="toggle_stat_type('.$overallStatNumber.',2)" />';		
		$statForm .= '</td><td>';
		$statForm .= '<label for="shots"> SO: </label><input type="text" id="shots'.$overallStatNumber.'" name="shots'.$overallStatNumber.'" value="'.$shotsRepostArray[$overallStatNumber].'" size="3" '.$goalieActiveRepostArray[$overallStatNumber].' />';
		$statForm .= '<label for="ga"> GA: </label><input type="text" id="ga'.$overallStatNumber.'" name="ga'.$overallStatNumber.'" value="'.$gaRepostArray[$overallStatNumber].'" size="3" '.$goalieActiveRepostArray[$overallStatNumber].' />';
		$statForm .= '</td></tr>';
	}
	$statForm .= '</table>'; 
	$statForm .= '</fieldset>'; 
	
/*
<select name="candidatePlayers">
	<option value="{$teamCandidateID[team]}">{$teamCandidateName[team]}</option>
</select>	
	*/
	
	//$statForm .= '</form>';
	//$statForm .= '</table>';
	$smarty->assign('statForm', $statForm);
}

//Return playerid array
function get_guest_team_players_without_game_stats() {
	global $SEASON;
	global $GAMEID;
	global $GUESTTEAM;
	
  
  global $Link;	
	
	$guestArray = array();
	

	$subQuery = 'SELECT playerID FROM '.PLAYERSTAT.' WHERE gameID='.$GAMEID;
  $subQuery2 = 'SELECT playerID FROM '.GOALIESTAT.' WHERE gameID='.$GAMEID;	
	$subQuery3 = 'SELECT playerID FROM '.ROSTERSOFTEAMSOFSEASONS.' WHERE teamID='.$GUESTTEAM.' AND seasonID='.$SEASON;

  $select = 'SELECT playerID FROM '.PLAYER;
  $select .= ' WHERE playerID NOT IN ('.$subQuery.')';
  $select .= ' AND playerID NOT IN ('.$subQuery2.')';
  $select .= ' AND playerID IN ('.$subQuery3.')';
  $select .= ' ORDER BY playerLName';  
  

  
  $result = mysql_query($select, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
		if ($result && mysql_num_rows($result) > 0) {			

			$i = -1;
			while ($player = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$i++;
				$guestArray[$i] = $player['playerID'];
			}
		}
		return $guestArray;
}

//Return playerid array
function get_home_team_players_without_game_stats() {
	global $SEASON;
	global $GAMEID;
	global $HOMETEAM;
	
  
  global $Link;	
	
	$homeArray = array();
	

	$subQuery = 'SELECT playerID FROM '.PLAYERSTAT.' WHERE gameID='.$GAMEID;
	$subQuery2 = 'SELECT playerID FROM '.GOALIESTAT.' WHERE gameID='.$GAMEID;
	$subQuery3 = 'SELECT playerID FROM '.ROSTERSOFTEAMSOFSEASONS.' WHERE teamID='.$HOMETEAM.' AND seasonID='.$SEASON;
  
  $select = 'SELECT playerID FROM '.PLAYER;
  $select .= ' WHERE playerID NOT IN ('.$subQuery.')';
  $select .= ' AND playerID NOT IN ('.$subQuery2.')';  
  $select .= ' AND playerID IN ('.$subQuery3.')';
  $select .= ' ORDER BY playerLName';   
  

  
  $result = mysql_query($select, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
		if ($result && mysql_num_rows($result) > 0) {			

			$i = -1;
			while ($player = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$i++;
				$homeArray[$i] = $player['playerID'];
			}
		}
		return $homeArray;	
	
}

//Return all players who belong to a roster this season
function get_all_players() {
	global $SEASON;
	global $allPlayersIDArray;
	global $allPlayersNamesArray;

  
  global $Link;	
	
	$select = 'SELECT '.ROSTERSOFTEAMSOFSEASONS.'.playerID,playerFName,playerLName FROM '.ROSTERSOFTEAMSOFSEASONS;
	$select .= ' JOIN '.PLAYER.' ON '.ROSTERSOFTEAMSOFSEASONS.'.playerID = '.PLAYER.'.playerID';
  $select .= ' WHERE '.ROSTERSOFTEAMSOFSEASONS.'.seasonID='.$SEASON;
  $select .= ' GROUP BY playerID';
  $select .= ' ORDER BY playerLName';
  
 
  $result = mysql_query($select, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
		if ($result && mysql_num_rows($result) > 0) {			

			$i = -1;
			while ($player = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$i++;
				$allPlayersIDArray[$i] = $player['playerID'];
				$allPlayersNamesArray[$i] = $player['playerFName'].' '.$player['playerLName'];
			}
		}	
}

/*
 * Handle reposts
 */
function initialize_form_values() {
	global $guestTeamPlayerArray;
	global $homeTeamPlayerArray;
	global $markedRepostArray;
	global $goalsRepostArray;
	global $assistsRepostArray;
	global $pimRepostArray;
	global $playerActiveRepostArray;
	global $statPlayerRepostArray;
	global $statGoalieRepostArray;
	global $shotsRepostArray;
	global $gaRepostArray;
  global $goalieActiveRepostArray;
	
  $statsNumber = (count($guestTeamPlayerArray) + 3) + (count($homeTeamPlayerArray) + 3);	

	for($i = 0; $i < $statsNumber; $i++) {
		//Marked stat
		if(isset($_POST['submitstat'.$i])) {
			$markedRepostArray[$i] = 'CHECKED';
		} else {
			$markedRepostArray[$i] = '';
		}
		
		//Goals Value
		if(isset($_POST['goals'.$i])) {
			$goalsRepostArray[$i] = $_POST['goals'.$i];
		} else {
			$goalsRepostArray[$i] = 0;
		}
		//Assists Value
		if(isset($_POST['assists'.$i])) {
			$assistsRepostArray[$i] = $_POST['assists'.$i];
		} else {
			$assistsRepostArray[$i] = 0;
		}
		//PIM Value
		if(isset($_POST['pim'.$i])) {
			$pimRepostArray[$i] = $_POST['pim'.$i];
		} else {
			$pimRepostArray[$i] = 0;
		}
		
		//Game Type
		$playerActiveRepostArray[$i] = '';
		if(isset($_POST['stattype'.$i]) && $_POST['stattype'.$i] == '2') {
			$goalieActiveRepostArray[$i] = '';			
			$statPlayerRepostArray[$i] = '';
			$statGoalieRepostArray[$i] = 'CHECKED';
		} else {
			$goalieActiveRepostArray[$i] = 'disabled="disabled"';			
			$statPlayerRepostArray[$i] = 'CHECKED';
			$statGoalieRepostArray[$i] = '';			
		}
		
		//Shots Value
		if(isset($_POST['shots'.$i])) {
			$shotsRepostArray[$i] = $_POST['shots'.$i];
		} else {
			$shotsRepostArray[$i] = 0;
		}
		//GA Value
		if(isset($_POST['ga'.$i])) {
			$gaRepostArray[$i] = $_POST['ga'.$i];
		} else {
			$gaRepostArray[$i] = 0;
		}
	}
}
 

/*
 * Validate form
 */
function validate_stats_form() {
	$errors = array();	
	$statsRowsToProcess = $_POST['statsnum'];
	$statsRowsSkipped = 0;
	
	for($i = 0; $i < $statsRowsToProcess; $i++) {
		if(isset($_POST['submitstat'.$i]) && isset($_POST['playerid'.$i]) && $_POST['submitstat'.$i] == '1' && $_POST['playerid'.$i] > 0) {

				//Validate as player stat
				if(isset($_POST['goals'.$i]) && is_numeric($_POST['goals'.$i]) && is_int(intval($_POST['goals'.$i])) && $_POST['goals'.$i] >= 0) {
					//Goals checks out
				} else {
					$errors[] = 'Goals on submitted player stat number '.($i+1).' must be a number greater than or equal to zero.';
				}
				if(isset($_POST['assists'.$i]) && is_numeric($_POST['assists'.$i]) && is_int(intval($_POST['assists'.$i])) && $_POST['assists'.$i] >= 0) {
					//Assists checks out
				} else {
					$errors[] = 'Assists on submitted player stat number '.($i+1).' must be a number greater than or equal to zero.';
				}
				if(isset($_POST['pim'.$i]) && is_numeric($_POST['pim'.$i]) && is_int(intval($_POST['pim'.$i])) && $_POST['pim'.$i] >= 0) {
					//PIM checks out
				} else {
					$errors[] = 'PIM on submitted player stat number '.($i+1).' must be a number greater than or equal to zero.';
				}

			//Validate as goalie stat
			if(isset($_POST['stattype'.$i]) && $_POST['stattype'.$i] == '2') {
				if(isset($_POST['shots'.$i]) && is_numeric($_POST['shots'.$i]) && is_int(intval($_POST['shots'.$i])) && $_POST['shots'.$i] >= 0) {
					//Shots checks out
				} else {
					$errors[] = 'Shots on submitted goalie stat number '.($i+1).' must be a number greater than or equal to zero.';
				}
				if(isset($_POST['ga'.$i]) && is_numeric($_POST['ga'.$i]) && is_int(intval($_POST['ga'.$i])) && $_POST['ga'.$i] >= 0) {
					//GA checks out
				} else {
					$errors[] = 'Goals Against on submitted goalie stat number '.($i+1).' must be a number greater than or equal to zero.';
				}				
			}
		} else {
			//Skip this stat
			$statsRowsSkipped++;
		}
	}

	if($statsRowsToProcess == $statsRowsSkipped) {
		$errors[] = 'No stats were marked to be submitted.  Please mark at least one stat to submit.';
	}

	return $errors;
}

/*
 * Process form
 */
function process_stats_form() {
	global $success;
	$errors = array();	
	$statsRowsToProcess = $_POST['statsnum'];
	
	
  global $Link;
	
	for($i = 0; $i < $statsRowsToProcess; $i++) {

		if(isset($_POST['submitstat'.$i]) && isset($_POST['playerid'.$i]) && $_POST['submitstat'.$i] == '1' && $_POST['playerid'.$i] > 0) {
			//Process as player stat
			$gameid = $_POST['gameid'];
			$playerid = $_POST['playerid'.$i];
			$teamid = $_POST['teamid'.$i];
			$goals = $_POST['goals'.$i];
			$assists = $_POST['assists'.$i];
			$pim = $_POST['pim'.$i];
			
			$query = 'INSERT INTO '.PLAYERSTAT.' (gameID,playerID,teamID,goals,assists,pim) VALUES('.$gameid.','.$playerid.','.$teamid.','.$goals.','.$assists.','.$pim.')';
					
			// Make insertion into database.
			$result = mysql_query($query, $Link)
				or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

			if(isset($_POST['stattype'.$i]) && $_POST['stattype'.$i] == '2') {
				//Process as goalie stat
				$gameid = $_POST['gameid'];
				$playerid = $_POST['playerid'.$i];
				$teamid = $_POST['teamid'.$i];
				$shots = $_POST['shots'.$i];
				$ga = $_POST['ga'.$i];
				
				$query = 'INSERT INTO '.GOALIESTAT.' (gameID,playerID,teamID,shots,goalsagainst) VALUES('.$gameid.','.$playerid.','.$teamid.','.$shots.','.$ga.')';
				
				// Make insertion into database.
				$result = mysql_query($query, $Link)
					or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
			}			
		} else {
			//Skip this stat, it will not be entered into the database.
		}

	}	

	
	return $errors;
}

?>
