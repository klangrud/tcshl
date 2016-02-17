<?php
/*
 * Created on Mar 29, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 1);
define('PAGE_TYPE', 'USER');

// Set for every page
require ('engine/common.php');

$userPlayerID = 0;
if(isset($_SESSION['playerid']) & $_SESSION['playerid'] > 0) {
  $userPlayerID = $_SESSION['playerid'];
}
if($userPlayerID > 0) {
  setup_player_stats();
  setup_goalie_stats();
}

$smarty->assign('SEASON_ID', $SEASON);
$smarty->assign('SEASON_NAME', get_season_name($SEASON));

$smarty->assign('page_name', 'User Homepage');
// Build the page
require ('global_begin.php');
if ($_SESSION['site_access'] == 2)
{
	$smarty->display('user/includes/inc_admin_links.tpl');
} else if($_SESSION['site_access'] == 1)
{
	$smarty->display('user/account.tpl');
}

require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/ 

function setup_player_stats() {
global $smarty;
global $userPlayerID;
global $Link;


 $playerStatsSelectColumns = SEASONS.'.seasonId, seasonName, COUNT(*) AS GAMES_PLAYED, SUM(goals) AS GOALS, SUM(assists) AS ASSISTS, SUM(pim) AS PIM';
 
 $playerStatsSelect = 'SELECT '.$playerStatsSelectColumns.' FROM '.PLAYERSTAT;
 
 $playerStatsSelect .= ' JOIN '.GAME.' ON '.PLAYERSTAT.'.gameID = '.GAME.'.gameID';
 
 $playerStatsSelect .= ' JOIN '.SEASONS.' ON '.GAME.'.seasonId = '.SEASONS.'.seasonId'; 
 
 $playerStatsSelect .= ' WHERE playerID = '.$userPlayerID;
 
 $playerStatsSelect .= ' GROUP BY '.GAME.'.seasonId';
 
 $playerStatsResult = mysql_query($playerStatsSelect, $Link)
   or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	
	if ($playerStatsResult && mysql_num_rows($playerStatsResult) > 0) {
		  $smarty->assign('UserHasPlayerStats', true);
		  $smarty->assign('seasonID', array ());	
		  $smarty->assign('season_name', array ());		  
		  $smarty->assign('games_played', array ());
		  $smarty->assign('goals', array ());
		  $smarty->assign('assists', array ());	
		  $smarty->assign('pim', array ());	
		  $smarty->assign('pts', array ());
		  
		  $totalGP = 0;
		  $totalGoals = 0;
		  $totalAssists = 0;
		  $totalPoints = 0;		  
		  $totalPIMs = 0;

			while ($stats = mysql_fetch_array($playerStatsResult, MYSQL_ASSOC)) {

				$seasonId = $stats['seasonId'];
				$seasonName = $stats['seasonName'];
				$gp = $stats['GAMES_PLAYED'];
				$goals = $stats['GOALS'];
				$assists = $stats['ASSISTS'];
				$pts = $goals + $assists;				
				$pim = $stats['PIM'];		
				
				$smarty->append('seasonID', $seasonId);	
				$smarty->append('seasonName', $seasonName);	
				$smarty->append('games_played', $gp);				
				$smarty->append('goals', $goals);
				$smarty->append('assists', $assists);
				$smarty->append('pts', $pts);
				$smarty->append('pim', $pim);

				
				$totalGP += $gp;
		    $totalGoals += $goals;
		    $totalAssists += $assists;
		    $totalPoints += $pts;		    
		    $totalPIMs += $pim;


			}
		  $smarty->assign('totalGP', $totalGP);
		  $smarty->assign('totalGoals', $totalGoals);
		  $smarty->assign('totalAssists', $totalAssists);
		  $smarty->assign('totalPoints', $totalPoints);	
		  $smarty->assign('totalPIMs', $totalPIMs);		
		}


}

function setup_goalie_stats() {
global $smarty;
global $userPlayerID;
global $Link;


 $goalieStatsSelectColumns = SEASONS.'.seasonId, seasonName, COUNT(*) AS GAMES_PLAYED, SUM(shots) AS SHOTS_FACED, SUM(goalsagainst) AS GOALS_AGAINST';
 
 $goalieStatsSelect = 'SELECT '.$goalieStatsSelectColumns.' FROM '.GOALIESTAT;
 
 $goalieStatsSelect .= ' JOIN '.GAME.' ON '.GOALIESTAT.'.gameID = '.GAME.'.gameID';
 
 $goalieStatsSelect .= ' JOIN '.SEASONS.' ON '.GAME.'.seasonId = '.SEASONS.'.seasonId'; 
 
 $goalieStatsSelect .= ' WHERE playerID = '.$userPlayerID;
 
 $goalieStatsSelect .= ' GROUP BY '.GAME.'.seasonId';
 
 $goalieStatsResult = mysql_query($goalieStatsSelect, $Link)
   or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	
	if ($goalieStatsResult && mysql_num_rows($goalieStatsResult) > 0) {
		  $smarty->assign('UserHasGoalieStats', true);
		  $smarty->assign('seasonID', array ());	
		  $smarty->assign('season_name', array ());		  
		  $smarty->assign('games_played', array ());
		  $smarty->assign('ga', array ());
		  $smarty->assign('gaa', array ());		  
		  $smarty->assign('saves', array ());
		  $smarty->assign('pct', array ());		  
		  
		  $totalGP = 0;
		  $totalGoalsAgainst = 0;
		  $overallGoalsAgainstAverage = 0;
		  $totalSaves = 0;
		  $totalShots = 0;	  
		  $overallSavePercentage = 0;

			while ($stats = mysql_fetch_array($goalieStatsResult, MYSQL_ASSOC)) {

				$seasonId = $stats['seasonId'];
				$seasonName = $stats['seasonName'];
				$gp = $stats['GAMES_PLAYED'];
				$ga = $stats['GOALS_AGAINST'];			
				$gaa = $ga / $gp;				
				$shots = $stats['SHOTS_FACED'];
				$saves = $shots - $ga;				
						
				if($shots == $ga) {
					$pct = 0;
				} else if ($shots > 0 && $ga == 0){
					$pct = 1;
				} else {
				  $pct = 1 - ($ga / $shots);
				}
				
				$smarty->append('seasonID', $seasonId);	
				$smarty->append('seasonName', $seasonName);	
				$smarty->append('games_played', $gp);
			  $smarty->append('ga', $ga);
			  $smarty->append('gaa', number_format($gaa,2));
				$smarty->append('saves', $saves);			  
			  $smarty->append('pct', number_format($pct,3));

				
			  $totalGP += $gp;
			  $totalGoalsAgainst += $ga;
			  $totalSaves += $saves;
			  $totalShots += $shots;
			}

			$overallGoalsAgainstAverage = $totalGoalsAgainst / $totalGP;
					
			if($totalShots == $totalGoalsAgainst) {
				$overallSavePercentage = 0;
			} else if ($totalShots > 0 && $totalGoalsAgainst == 0){
				$overallSavePercentage = 1;
			} else {
			  $overallSavePercentage = 1 - ($totalGoalsAgainst / $totalShots);
			}		  
		  
		  $smarty->assign('totalGP', $totalGP);
		  $smarty->assign('totalGoalsAgainst', $totalGoalsAgainst);
		  $smarty->assign('overallGAA', number_format($overallGoalsAgainstAverage,2));
		  $smarty->assign('totalSaves', $totalSaves);	
		  $smarty->assign('overallSavePercentage', number_format($overallSavePercentage,3));		
		}


}
 
?>
