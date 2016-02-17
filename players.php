<?php

/*
 * Created on Aug 29, 2007
 *
*/

// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');

// Set for every page
require ('engine/common.php');

$smarty->assign('page_name', 'Players');

setup_player_list();


// Build the page
require ('global_begin.php');
$smarty->display('admin/players.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/


function setup_player_list() {
	global $smarty;
	global $SEASON;
	$smarty->assign('seasonName', get_season_name($SEASON));
	
	global $Link;
       
   $selectColumns = PLAYER.'.playerID,playerFName,playerLName,playerSkillLevel,'.PLAYER.'.registrationId,'.PLAYER.'.seasonId,position,skillLevelName';
    
	$playersSelect = 'SELECT '.$selectColumns.' FROM '.PLAYER.' JOIN '.REGISTRATION.' ON '.PLAYER.'.registrationId = '.REGISTRATION.'.registrationId JOIN '.SKILLLEVELS.' ON '.SKILLLEVELS.'.skillLevelID = '.PLAYER.'.playerSkillLevel AND '.PLAYER.'.seasonId='.$SEASON.' AND playerFName != "Open" ORDER BY playerSkillLevel,playerLName';
	
	$playersResult = mysql_query($playersSelect, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	
	if ($playersResult && mysql_num_rows($playersResult) > 0) {			

		  $countPlayers=0;
		  $smarty->assign('playerId', array ());
		  $smarty->assign('playerFName', array ());
      $smarty->assign('playerLName', array ());
      $smarty->assign('skillLevelName', array ());
      $smarty->assign('playerPosition', array ());
      $smarty->assign('teams', array ());           
      $smarty->assign('registrationId', array ());
            
			while ($player = mysql_fetch_array($playersResult, MYSQL_ASSOC)) {
				
				$countPlayers++;
				$playerId = $player['playerID'];
				$playerFName = $player['playerFName'];
				$playerLName = $player['playerLName'];
				$skillLevelName = $player['skillLevelName'];
				$playerPosition = $player['position'];
				$teams = get_players_teams($playerId, $playerFName, $playerLName, $SEASON);
				$registrationId = $player['registrationId'];
				
				
				$smarty->append('countPlayers', $countPlayers);
				$smarty->append('playerId', $playerId);
				$smarty->append('playerFName', $playerFName);
        $smarty->append('playerLName', $playerLName);
        $smarty->append('skillLevelName', $skillLevelName);
        $smarty->append('playerPosition', $playerPosition);
        $smarty->append('teams', $teams);
				$smarty->append('registrationId', $registrationId);             

			}
			$smarty->assign('countPlayers', $countPlayers);
		}
	
}

function get_players_teams($playerId, $playerFName, $playerLName, $SEASON) {
	
	global $Link;
	
	$teamsSelect = 'SELECT '.ROSTERSOFTEAMSOFSEASONS.'.teamID,teamName FROM '.ROSTERSOFTEAMSOFSEASONS.' JOIN '.TEAMS.' ON '.TEAMS.'.teamID = '.ROSTERSOFTEAMSOFSEASONS.'.teamID WHERE playerID='.$playerId.' AND seasonID='.$SEASON;

	$teamsResult = mysql_query($teamsSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

	$teamsReturn = '';

	if ($teamsResult && mysql_num_rows($teamsResult) > 0) {			

		  $teamsCount = 0;
            
			while ($team = mysql_fetch_array($teamsResult, MYSQL_ASSOC)) {
				$teamsCount++;
				if($teamsCount > 1) {
					$teamsReturn .= '<br />';
				}
				$teamsReturn .= $team['teamName'].'<a href="removeplayerfromteam.php?seasonID='.$SEASON.'&teamID='.$team['teamID'].'&playerID='.$playerId.'"><img class="imglink" src="images/delete.gif" title="Remove '.$playerFName.' '.$playerLName.' from '.$team['teamName'].'\'s roster" /></a>';
			}
	}
	return $teamsReturn;	
}
?>