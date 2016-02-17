<?php
/*
 * Created on Sep 24, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 if(isset($TEAM) && $TEAM > 0) {
 	//Do nothing
 } else {
 	$TEAM = 'ALL';
 }
 
 

 global $Link;
 
 $rosterSelectColumns = ROSTERSOFTEAMSOFSEASONS.'.teamID,'.ROSTERSOFTEAMSOFSEASONS.'.playerID,jerseyNumber,playerFName,playerLName,teamName,teamFGColor,teamBGColor';
 
 $rosterSelect = 'SELECT '.$rosterSelectColumns.' FROM '.ROSTERSOFTEAMSOFSEASONS;
 $rosterSelect .= ' JOIN '.TEAMS.' ON '.ROSTERSOFTEAMSOFSEASONS.'.teamID = '.TEAMS.'.teamID';
 $rosterSelect .= ' JOIN '.PLAYER.' ON '.ROSTERSOFTEAMSOFSEASONS.'.playerID = '.PLAYER.'.playerID'; 
 $rosterSelect .= ' WHERE '.ROSTERSOFTEAMSOFSEASONS.'.seasonID='.$SEASON;
 if($TEAM > 0){
 	 $rosterSelect .= ' AND '.ROSTERSOFTEAMSOFSEASONS.'.teamID='.$TEAM;
 }
 $rosterSelect .= ' ORDER BY '.ROSTERSOFTEAMSOFSEASONS.'.teamID, jerseyNumber';
 
 
	$rosterResult = mysql_query($rosterSelect, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	$seasonSkedName = '';
	if($TEAM > 0) {
		$seasonSkedName .= get_rost_team_name($TEAM).' ';
	}
	$seasonSkedName .= get_season_name($SEASON);
	
	$smarty->assign('seasonName', $seasonSkedName);
	
	$currentTime = time();
	
	if ($rosterResult && mysql_num_rows($rosterResult) > 0) {			
			$smarty->assign('current_team', -1);
		  $smarty->assign('teamID', array ());
		  $smarty->assign('playerID', array ());
		  $smarty->assign('jerseyNumber', array ());
		  $smarty->assign('playerName', array ());
		  $smarty->assign('teamName', array ());
      $smarty->assign('teamFGColor', array ());
      $smarty->assign('teamBGColor', array ());

			while ($team = mysql_fetch_array($rosterResult, MYSQL_ASSOC)) {
				$teamId = $team['teamID'];
				$playerId = $team['playerID'];
				if($team['jerseyNumber'] < 10) {
					$jerseyNumber = "0".$team['jerseyNumber'];
				} else {
				  $jerseyNumber = $team['jerseyNumber'];
				}
				$playerName = $team['playerFName'].' '.$team['playerLName'];
				$teamName = $team['teamName'];
				$teamFGColor = $team['teamFGColor'];
				$teamBGColor = $team['teamBGColor'];
	
				$smarty->append('teamID', $teamId);
				$smarty->append('playerID', $playerId);
				$smarty->append('jerseyNumber', $jerseyNumber);
				$smarty->append('playerName', $playerName);
				$smarty->append('teamName', $teamName);
				$smarty->append('teamFGColor', $teamFGColor);
        $smarty->append('teamBGColor', $teamBGColor); 

			}
		}

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
 function get_rost_team_name($teamId) {
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
  
?>
