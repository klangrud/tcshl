<?php
/*
 * Created on Sep 27, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 
 
 global $Link;
 
 $goalieStatsSelectColumns = GOALIESTAT.'.playerID,playerFName,playerLName,'.GOALIESTAT.'.teamID,teamName,teamFGColor,teamBGColor,shots,goalsagainst';
 
 $goalieStatsSelect = 'SELECT '.$goalieStatsSelectColumns.' FROM '.GOALIESTAT;
 
 $goalieStatsSelect .= ' JOIN '.PLAYER.' ON '.GOALIESTAT.'.playerID = '.PLAYER.'.playerID';
 
 $goalieStatsSelect .= ' JOIN '.TEAMS.' ON '.GOALIESTAT.'.teamID = '.TEAMS.'.teamID';  
 
 $goalieStatsSelect .= ' WHERE gameID = '.$GAMEID;
 
 $goalieStatsSelect .= ' ORDER BY teamName, playerLName';
 
 $goalieStatsResult = mysql_query($goalieStatsSelect, $Link)
   or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	$smarty->assign('gameid', $GAMEID);
	$smarty->assign('goalieCurrentTeam', -1);
	
	if ($goalieStatsResult && mysql_num_rows($goalieStatsResult) > 0) {
		  $smarty->assign('gameHasGoalieStats', true);
		  $smarty->assign('goaliePlayerID', array ());
		  $smarty->assign('goaliePlayerName', array ());
		  $smarty->assign('goalieTeamID', array ());
		  $smarty->assign('goalieTeamName', array ());
		  $smarty->assign('goalieTeamFGColor', array());
		  $smarty->assign('goalieTeamBGColor', array());		  
		  $smarty->assign('shots', array ());
		  $smarty->assign('goalsagainst', array ());
		  $smarty->assign('goalieTeamNameCheck', array());
		  $checkMinusOne = 0;
		  $checkStartDigit = -1;

            
			while ($goalieStat = mysql_fetch_array($goalieStatsResult, MYSQL_ASSOC)) {
				$playerID = $goalieStat['playerID'];
				$playerName = $goalieStat['playerFName'].' '.$goalieStat['playerLName'];
				$teamID = $goalieStat['teamID'];
				$teamName = $goalieStat['teamName'];				
				$shots = $goalieStat['shots'];
				$ga = $goalieStat['goalsagainst'];
				

				$smarty->append('goaliePlayerID', $playerID);
				$smarty->append('goaliePlayerName', $playerName);
				$smarty->append('goalieTeamID', $teamID);
				$smarty->append('goalieTeamName', $teamName);
				$smarty->append('goalieTeamFGColor', $goalieStat['teamFGColor']);		
				$smarty->append('goalieTeamBGColor', $goalieStat['teamBGColor']);												
				$smarty->append('shots', $shots);
				$smarty->append('goalsagainst', $ga);
				
				if($checkStartDigit > -1) {
					$checkMinusOne++;
					$smarty->append('goalieTeamNameCheck', $teamName);
				}
			 $checkStartDigit++;

			}
			$smarty->append('goalieTeamNameCheck', 'FINISHED');
		}

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/
 
?>
