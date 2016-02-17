<?php
/*
 * Created on Sep 27, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 
 
 global $Link;
 
 $playerStatsSelectColumns = PLAYERSTAT.'.playerID,playerFName,playerLName,'.PLAYERSTAT.'.teamID, teamName,teamFGColor,teamBGColor,goals,assists,pim';
 
 $playerStatsSelect = 'SELECT '.$playerStatsSelectColumns.' FROM '.PLAYERSTAT;
 
 $playerStatsSelect .= ' JOIN '.PLAYER.' ON '.PLAYERSTAT.'.playerID = '.PLAYER.'.playerID';
 
 $playerStatsSelect .= ' JOIN '.TEAMS.' ON '.PLAYERSTAT.'.teamID = '.TEAMS.'.teamID'; 
 
 $playerStatsSelect .= ' WHERE gameID = '.$GAMEID;
 
 $playerStatsSelect .= ' ORDER BY teamName, playerLName';
 
 $playerStatsResult = mysql_query($playerStatsSelect, $Link)
   or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	$smarty->assign('gameid', $GAMEID);
	$smarty->assign('currentTeam', -1);
	
	if ($playerStatsResult && mysql_num_rows($playerStatsResult) > 0) {
		  $smarty->assign('gameHasPlayerStats', true);
		  $smarty->assign('playerID', array ());
		  $smarty->assign('playerName', array ());
		  $smarty->assign('teamID', array ());		  
		  $smarty->assign('teamName', array ());
		  $smarty->assign('teamFGColor', array());
		  $smarty->assign('teamBGColor', array());		  
		  $smarty->assign('goals', array ());
		  $smarty->assign('assists', array ());
		  $smarty->assign('pts', array ());
		  $smarty->assign('pim', array ());
		  $smarty->assign('teamNameCheck', array());
		  $checkMinusOne = 0;
		  $checkStartDigit = -1;		
            
			while ($stat = mysql_fetch_array($playerStatsResult, MYSQL_ASSOC)) {
				$playerID = $stat['playerID'];
				$playerName = $stat['playerFName'].' '.$stat['playerLName'];
				$teamID = $stat['teamID'];
				$teamName = $stat['teamName'];
				$goals = $stat['goals'];
				$assists = $stat['assists'];
				$pts = $goals + $assists;
				$pim = $stat['pim'];
		
				

				$smarty->append('playerID', $playerID);
				$smarty->append('playerName', $playerName);
				$smarty->append('teamID', $teamID);
				$smarty->append('teamName', $teamName);
				$smarty->append('teamFGColor', $stat['teamFGColor']);		
				$smarty->append('teamBGColor', $stat['teamBGColor']);					
				$smarty->append('goals', $goals);
				$smarty->append('assists', $assists);
				$smarty->append('pim', $pim);
				$smarty->append('pts', $pts);

				if($checkStartDigit > -1) {
					$checkMinusOne++;
					$smarty->append('teamNameCheck', $teamName);
				}
			 $checkStartDigit++;

			}
			$smarty->append('teamNameCheck', 'FINISHED');
		}

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/
 
?>
