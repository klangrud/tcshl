<?php

/*
 * Created on Sep 18, 2007
 *
 * This file is not meant to be hit on its own.  It is to be an include only.
 */

if(isset($GAME_TYPE) && ($GAME_TYPE == 'season' || $GAME_TYPE == 'pre' || $GAME_TYPE == 'post')) {
	//Do nothing
} else {
	$GAME_TYPE = 'season';
}


global $Link;

get_standings();

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/


/*
 * Get Team Name
 */
function get_sked_team_name($teamId) {
	$teamName = "";
	
	global $Link;

	$teamSelect = 'SELECT teamName FROM ' . TEAMS . ' WHERE teamID=' . $teamId;

	$teamResult = mysql_query($teamSelect, $Link);

	if ($teamResult && mysql_num_rows($teamResult) > 0) {
		$team = mysql_fetch_assoc($teamResult);
		$teamName = $team['teamName'];
	}
	

	return $teamName;
}

/*
 * This gets the current standings and puts them into smarty.  WARNING: This 
 * function is a complicated.
 */
function get_standings() {
	global $smarty;
	global $SEASON;
	global $GAME_TYPE;
	$currentTime = time();
	
	global $Link;

	$i = 0;
  $teamsThatHavePlayedCount = 0;
	$smarty->assign('teamid', array ());
	$smarty->assign('teamname', array ());
	$smarty->assign('gamesplayed', array ());
	$smarty->assign('wins', array ());
	$smarty->assign('losses', array ());
	$smarty->assign('ties', array ());
	$smarty->assign('points', array ());
	$smarty->assign('winningpercentage', array ());
	$smarty->assign('goalsfor', array ());
	$smarty->assign('goalsagainst', array ());


	$teamsOfSeasonSubquery = 'SELECT teamID FROM ' . TEAMSOFSEASONS . ' WHERE seasonID=' . $SEASON.' AND teamID != 7 AND teamID != 14';

	$teamHasPlayedAsGuest = 'SELECT gameGuestTeam FROM ' . GAME . ' WHERE seasonId=' . $SEASON . ' AND gameGuestScore >= 0 AND gameHomeScore >= 0';
	$teamHasPlayedAsHome = 'SELECT gameHomeTeam FROM ' . GAME . ' WHERE seasonId=' . $SEASON . ' AND gameGuestScore >= 0 AND gameHomeScore >= 0';

	$teamsSelect = 'SELECT teamID,teamName FROM ' . TEAMS;
	$teamsSelect .=  ' WHERE teamID IN (' . $teamsOfSeasonSubquery . ')';
	$teamsSelect .= ' AND (teamID IN (' . $teamHasPlayedAsGuest . ') or teamID IN (' . $teamHasPlayedAsHome . '))';

	$teamsResult = mysql_query($teamsSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

	if ($teamsResult && mysql_num_rows($teamsResult) > 0) {

		$teamID = array ();

		$smarty->assign('teamID', array ());

		while ($team = mysql_fetch_array($teamsResult, MYSQL_ASSOC)) {
			$teamsThatHavePlayedCount++;
			$teamID[] = $team['teamID'];
		}
	}

	if (isset ($teamID)) {
		foreach ($teamID as $tid) {
			
			global $Link;

			$teamStatsSelectColumns = 'gameGuestTeam,gameGuestScore,gameHomeTeam,gameHomeScore';
			$teamStatsSelect = 'SELECT ' . $teamStatsSelectColumns . ' FROM ' . GAME;
			$teamStatsSelect .= ' WHERE gameGuestScore >= 0 AND gameHomeScore >= 0';
			$teamStatsSelect .= ' AND seasonId = ' . $SEASON;
			$teamStatsSelect .= ' AND (gameGuestTeam = ' . $tid . ' OR gameHomeTeam =' . $tid . ')';
			$teamStatsSelect .= ' AND gameTime < ' . $currentTime;
			$teamStatsSelect .= ' AND gameType="'.$GAME_TYPE.'"';

			$teamStatsResult = mysql_query($teamStatsSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

			if ($teamStatsResult && mysql_num_rows($teamStatsResult) > 0) {
				//$i++; Moved to later in the sequence
				$gp = 0;
				$wins = 0;
				$losses = 0;
				$ties = 0;
				$pts = 0;
				$pct = 0;
				$gf = 0;
				$ga = 0;

				while ($game = mysql_fetch_array($teamStatsResult, MYSQL_ASSOC)) {
					$gp++;
					//If this team is the home team do following code, otherwise do else code
					if (is_home_team($tid, $game['gameHomeTeam'])) {
						// Add a win
						if ($game['gameGuestScore'] < $game['gameHomeScore']) {
							$wins++;
						}
						// Add a loss
						else
							if ($game['gameGuestScore'] > $game['gameHomeScore']) {
								$losses++;
							}
						// Add a tie
						else {
							$ties++;
						}
						// Add to goals for
						$gf += $game['gameHomeScore'];
						// Add to goals against
						$ga += $game['gameGuestScore'];
					} else {
						// Add a win
						if ($game['gameGuestScore'] > $game['gameHomeScore']) {
							$wins++;
						}
						// Add a loss
						else
							if ($game['gameGuestScore'] < $game['gameHomeScore']) {
								$losses++;
							}
						// Add a tie
						else {
							$ties++;
						}
						// Add to goals for
						$gf += $game['gameGuestScore'];
						// Add to goals against
						$ga += $game['gameHomeScore'];
					}

				}
				// Determine points
				$pts = $wins * 2;
				$pts += $ties;

				// Determine percentage
				$pct = (($ties / 2) + $wins) / $gp;
				$pct = number_format($pct,3);
				
				//Create each teams stat array.  All the arrays will be sorted later by points.
				$teamStatsArray[$i]['points'] = $pts;
				$teamStatsArray[$i]['teamid'] = $tid;
				$teamStatsArray[$i]['teamname'] = get_sked_team_name($tid);
				$teamStatsArray[$i]['gamesplayed'] = $gp;
				$teamStatsArray[$i]['wins'] = $wins;
				$teamStatsArray[$i]['losses'] = $losses;
				$teamStatsArray[$i]['ties'] = $ties;
				//points was here but i moved it to top so that it could be used as a sort by later.
				$teamStatsArray[$i]['winningpercentage'] = $pct;
				$teamStatsArray[$i]['goalsfor'] = $gf;
				$teamStatsArray[$i]['goalsagainst'] = $ga;
				$i++;
			}
		}
	}	
	// Sort the array by team points
	  if(isset($teamStatsArray) && count($teamStatsArray) > 0) {
		usort($teamStatsArray, 'compare_points');
	  
		  //Smartyify the array of stats
		  for($i = 0; $i < count($teamStatsArray); $i++) {
		  		$smarty->append('teamid', $teamStatsArray[$i]['teamid']);
					$smarty->append('teamname', $teamStatsArray[$i]['teamname']);
					$smarty->append('gamesplayed', $teamStatsArray[$i]['gamesplayed']);
					$smarty->append('wins', $teamStatsArray[$i]['wins']);
					$smarty->append('losses', $teamStatsArray[$i]['losses']);
					$smarty->append('ties', $teamStatsArray[$i]['ties']);
					$smarty->append('points', $teamStatsArray[$i]['points']);
					$smarty->append('winningpercentage', $teamStatsArray[$i]['winningpercentage']);
					$smarty->append('goalsfor', $teamStatsArray[$i]['goalsfor']);
					$smarty->append('goalsagainst', $teamStatsArray[$i]['goalsagainst']);
		  }
	  }
	//----------------------------------------------------------------------------
	//Create filler for teams without any game results.
			
			global $Link;
	
			$teamGuestStatsSubSelectColumns = 'gameGuestTeam';
			$teamGuestStatsSubSelect = 'SELECT ' . $teamGuestStatsSubSelectColumns . ' FROM ' . GAME;
			$teamGuestStatsSubSelect .= ' WHERE gameGuestScore >= 0 AND gameHomeScore >= 0';
			$teamGuestStatsSubSelect .= ' AND seasonId = ' . $SEASON;
			$teamGuestStatsSubSelect .= ' AND gameTime < ' . $currentTime;
			$teamGuestStatsSubSelect .= ' AND gameType="'.$GAME_TYPE.'"';
			
			$teamHomeStatsSubSelectColumns = 'gameHomeTeam';
			$teamHomeStatsSubSelect = 'SELECT ' . $teamHomeStatsSubSelectColumns . ' FROM ' . GAME;
			$teamHomeStatsSubSelect .= ' WHERE gameGuestScore >= 0 AND gameHomeScore >= 0';
			$teamHomeStatsSubSelect .= ' AND seasonId = ' . $SEASON;
			$teamHomeStatsSubSelect .= ' AND gameTime < ' . $currentTime;
			$teamHomeStatsSubSelect .= ' AND gameType="'.$GAME_TYPE.'"';			
			
			$teamsWithoutGameResultsSelect = 'SELECT '.TEAMSOFSEASONS.'.teamID, teamName FROM '.TEAMSOFSEASONS;
			$teamsWithoutGameResultsSelect .= ' JOIN '.TEAMS.' ON '.TEAMSOFSEASONS.'.teamID = '.TEAMS.'.teamID';
			$teamsWithoutGameResultsSelect .= ' WHERE '.TEAMSOFSEASONS.'.teamID NOT IN ('.$teamGuestStatsSubSelect.')';
			$teamsWithoutGameResultsSelect .= ' AND '.TEAMSOFSEASONS.'.teamID NOT IN ('.$teamHomeStatsSubSelect.')';
			$teamsWithoutGameResultsSelect .= ' AND seasonID = ' . $SEASON;
			$teamsWithoutGameResultsSelect .= ' AND '.TEAMSOFSEASONS.'.teamID != 7 AND '.TEAMSOFSEASONS.'.teamID != 14';
			$teamsWithoutGameResultsSelect .= ' ORDER BY teamName';
			
			$teamsWithoutGameResultsResults = mysql_query($teamsWithoutGameResultsSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

			if ($teamsWithoutGameResultsResults && mysql_num_rows($teamsWithoutGameResultsResults) > 0) {

				while ($team = mysql_fetch_array($teamsWithoutGameResultsResults, MYSQL_ASSOC)) {
					//Append our results to the smarty arrays			
					$smarty->append('teamid', $team['teamID']);
					$smarty->append('teamname', get_sked_team_name($team['teamID']));
					$smarty->append('gamesplayed', 0);
					$smarty->append('wins', 0);
					$smarty->append('losses', 0);
					$smarty->append('ties', 0);
					$smarty->append('points', 0);
					$smarty->append('winningpercentage', number_format(0,3));
					$smarty->append('goalsfor', 0);
					$smarty->append('goalsagainst', 0);			
				}
			}
}

function is_home_team($teamID, $homeTeamID) {
	if ($teamID == $homeTeamID) {
		return true;
	} else {
		return false;
	}
}

/*
 * Function that helps sort standings
 */
 
function compare_points($a, $b) {
	$retval = strnatcmp($b['points'], $a['points']);
	if(!$retval)
	    $retval = strnatcmp($b['winningpercentage'], $a['winningpercentage']);
	if(!$retval)
		return strnatcmp($a['teamname'], $b['teamname']);
	return $retval;
}
?>
