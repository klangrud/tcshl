<?php
/*
 * Created on Oct 4, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');

// Set for every page
require ('engine/common.php');

//This page must have a teamid.
if(isset($_GET['teamid']) && $_GET['teamid'] > 0) {
	$TEAM = $_GET['teamid'];
} else if(isset($_POST['teamid']) && $_POST['teamid'] > 0) {
	$TEAM = $_POST['teamid'];
} else {
	header("Location: index.php");
}


/*
 * Season Type. Pre, Season, Post
 */
if(isset($_GET['gametype']) && ($_GET['gametype'] == 'season' || $_GET['gametype'] == 'pre' || $_GET['gametype'] == 'post')) {
	$GAME_TYPE = $_GET['gametype'];
} else if(isset($_POST['gametype']) && ($_POST['gametype'] == 'season' || $_POST['gametype'] == 'pre' || $_POST['gametype'] == 'post')) {
	$GAME_TYPE = $_POST['gametype'];
} else {
	$GAME_TYPE = get_current_game_type();
} 

if($GAME_TYPE == 'pre') {
	$gametype = 'PRE';
} else if($GAME_TYPE == 'season') {
	$gametype = 'REGULAR';
} else if($GAME_TYPE == 'post') {
	$gametype = 'POST';
} else {
	$gametype = '';
}

$smarty->assign('gametype', $gametype);
$smarty->assign('teamid', $TEAM);

/*
 * Sets Stat Type, otherwise it defaults to TEAM.
 * TEAM == Player stats only when they play for respected team.
 * ALL == Player stats of all games they have played in.
 */
if(isset($_GET['stattype']) && ($_GET['stattype'] == 'TEAM' || $_GET['stattype'] == 'ALL')) {
	$STATTYPE = $_GET['stattype'];	
} else if(isset($_POST['stattype']) && ($_POST['stattype'] == 'TEAM' || $_POST['stattype'] == 'ALL')) {
	$STATTYPE = $_POST['stattype'];	
} else {
	$STATTYPE = 'TEAM';
}

//DB Connection

//global $Link;

// Assign page name
$smarty->assign('page_name', get_season_name($SEASON).' '.get_team_name($TEAM));

// Setup Form

// Setup Team Banner
setup_team_colors();

// Setup Team Rep
setup_team_rep();

// Setup Team Record
setup_team_record();

// Setup Team Picture
setup_team_picture();

// Setup Team Roster
setup_team_roster();

// Setup Team Stats
setup_team_stats();

// Setup Team Sponsors
setup_team_sponsors();

// Build the page
require ('global_begin.php');
$smarty->display('public/team.tpl');
require ('global_end.php');


/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

// Setup Form

// Setup Team Banner
function setup_team_colors() {
	global $smarty;
	global $Link;
	global $TEAM;
	
	$select = 'SELECT teamFGColor,teamBGColor FROM '.TEAMS.' WHERE teamID='.$TEAM;
	$result = mysql_query($select, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
	  $team = mysql_fetch_assoc($result);
	  
	  $smarty->assign('teamFGColor', $team['teamFGColor']);
	  $smarty->assign('teamBGColor', $team['teamBGColor']);	
	}
	
}

// Setup Team Rep
function setup_team_rep() {
	global $smarty;
	global $Link;
	global $SEASON;	
	global $TEAM;
	
	$select = 'SELECT teamRep FROM '.TEAMSOFSEASONS.' WHERE teamID='.$TEAM.' AND seasonID='.$SEASON;
	$result = mysql_query($select, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
	  $rep = mysql_fetch_assoc($result);
	  
	  if($rep['teamRep'] > 0) {
	  	$smarty->assign('teamRep', get_player_name($rep['teamRep']));
	  } else {
	  	$smarty->assign('teamRep', 'No Team Rep');
	  }
	}
	
}


// Setup Team Record
function setup_team_record() {
	global $smarty;	
	global $SEASON;
	global $GAME_TYPE;
	global $TEAM;
	global $Link;

  //Global Select Input
	$globalSelect = ' FROM '.GAME;
	$globalSelect .= ' WHERE seasonId='.$SEASON;
	$globalSelect .= ' AND gameType="'.$GAME_TYPE.'"';  

	
	//Guest Record Select
	$gwinsSelect = 'SELECT count(*) as gwins '.$globalSelect.' AND gameGuestScore > gameHomeScore AND gameGuestTeam='.$TEAM;
	$glossesSelect = 'SELECT count(*) as glosses '.$globalSelect.' AND gameGuestScore < gameHomeScore AND gameGuestTeam='.$TEAM;
	$gtiesSelect = 'SELECT count(*) as gties '.$globalSelect.' AND gameGuestScore = gameHomeScore AND gameGuestTeam='.$TEAM;
	$hwinsSelect = 'SELECT count(*) as hwins '.$globalSelect.' AND gameGuestScore < gameHomeScore AND gameHomeTeam='.$TEAM;
	$hlossesSelect = 'SELECT count(*) as hlosses '.$globalSelect.' AND gameGuestScore > gameHomeScore AND gameHomeTeam='.$TEAM;
	$htiesSelect = 'SELECT count(*) as hties '.$globalSelect.' AND gameGuestScore = gameHomeScore AND gameHomeTeam='.$TEAM;

	$totalWins = 0;
	$totalLosses = 0;
	$totalTies = 0;

	//Guest Wins
	$result = mysql_query($gwinsSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
	  $gwin = mysql_fetch_assoc($result);
	  $totalWins += $gwin['gwins'];
	}
	
	//Home Wins
	$result = mysql_query($hwinsSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
	  $hwin = mysql_fetch_assoc($result);
	  $totalWins += $hwin['hwins'];
	}	
	
	//Guest Losses
	$result = mysql_query($glossesSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
	  $gloss = mysql_fetch_assoc($result);
	  $totalLosses += $gloss['glosses'];
	}	
	
	//Home Losses
	$result = mysql_query($hlossesSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
	  $hloss = mysql_fetch_assoc($result);
	  $totalLosses += $hloss['hlosses'];
	}	
	
	//Guest Losses
	$result = mysql_query($gtiesSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
	  $gtie = mysql_fetch_assoc($result);
	  $totalTies += $gtie['gties'];
	}	
	
	//Home Losses
	$result = mysql_query($htiesSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
	  $htie = mysql_fetch_assoc($result);
	  $totalTies += $htie['hties'];
	}		

		//Smartify Team Record
	  $smarty->assign('wins', $totalWins);
	  $smarty->assign('losses', $totalLosses);
	  $smarty->assign('ties', $totalTies);
}

// Setup Team Picture
function setup_team_picture() {
	//TODO: Get this setup.
	global $smarty;
	$smarty->assign('hasTeamPicture', false);
	
}

// Setup Team Roster
function setup_team_roster() {
	global $smarty;	
	global $SEASON;
	global $TEAM;
	global $Link;	
	
	$selectFields = ROSTERSOFTEAMSOFSEASONS.'.playerID,jerseyNumber,CONCAT(playerFName," ",playerLName) AS name';
	$select = 'SELECT '.$selectFields.' FROM '.ROSTERSOFTEAMSOFSEASONS;
	$select .= ' JOIN '.PLAYER.' ON '.ROSTERSOFTEAMSOFSEASONS.'.playerID = '.PLAYER.'.playerID';
	$select .= ' AND '.ROSTERSOFTEAMSOFSEASONS.'.seasonID='.$SEASON;
	$select .= ' AND teamID='.$TEAM;
	$select .= ' ORDER BY jerseyNumber';

	$result = mysql_query($select, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
		  $smarty->assign('playerID', array ());
		  $smarty->assign('jerseyNumber', array ());
		  $smarty->assign('playerName', array ());


			while ($team = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$playerId = $team['playerID'];
				if($team['jerseyNumber'] < 10) {
					$jerseyNumber = "0".$team['jerseyNumber'];
				} else {
				  $jerseyNumber = $team['jerseyNumber'];
				}
				$playerName = $team['name'];

				$smarty->append('playerID', $playerId);
				$smarty->append('jerseyNumber', $jerseyNumber);
				$smarty->append('playerName', $playerName);
			}
		}
}

// Setup Team Stats
function setup_team_stats() {
	global $smarty;	
	global $SEASON;
	global $GAME_TYPE;
	global $TEAM;
	global $Link;
	
	
	//Sub Queries
	$gamesInGameType = 'SELECT gameID FROM '.GAME.' WHERE gameType="'.$GAME_TYPE.'" AND seasonId='.$SEASON.' AND (gameGuestTeam='.$TEAM.' OR gameHomeTeam='.$TEAM.')';
	$roster = 'SELECT playerID FROM '.ROSTERSOFTEAMSOFSEASONS.' WHERE teamID='.$TEAM.' AND seasonID='.$SEASON;
	
	//Player Stats Setup
	$selectFields = PLAYERSTAT.'.playerID,jerseyNumber,CONCAT(playerFName," ",playerLName) AS name,COUNT(*) AS gamesplayed,SUM(goals) AS totalgoals,SUM(assists) AS totalassists,SUM(pim) AS totalpim';
	$select = 'SELECT '.$selectFields.' FROM '.PLAYERSTAT;
	$select .= ' JOIN '.PLAYER.' ON '.PLAYERSTAT.'.playerID = '.PLAYER.'.playerID';
  $select .= ' JOIN '.ROSTERSOFTEAMSOFSEASONS.' ON '.PLAYERSTAT.'.playerID = '.ROSTERSOFTEAMSOFSEASONS.'.playerID';
	$select .= ' WHERE gameID IN ('.$gamesInGameType.')';
	$select .= ' AND '.PLAYERSTAT.'.playerID IN ('.$roster.')';
	$select .= ' AND '.PLAYERSTAT.'.teamID='.$TEAM;
	$select .= ' AND '.ROSTERSOFTEAMSOFSEASONS.'.teamID='.$TEAM;
	$select .= ' GROUP BY '.PLAYERSTAT.'.playerID';
	$select .= ' ORDER BY jerseyNumber';

	$result = mysql_query($select, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
		  $smarty->assign('statPlayerID', array ());
		  $smarty->assign('statJerseyNumber', array ());
		  $smarty->assign('statPlayerName', array ());
		  $smarty->assign('gamesplayed', array ());
		  $smarty->assign('goals', array ());
		  $smarty->assign('assists', array ());
		  $smarty->assign('points', array ());		  
		  $smarty->assign('pim', array ());			  


			while ($stats = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$playerId = $stats['playerID'];
				if($stats['jerseyNumber'] < 10) {
					$jerseyNumber = "0".$stats['jerseyNumber'];
				} else {
				  $jerseyNumber = $stats['jerseyNumber'];
				}
				$playerName = $stats['name'];				
				$gamesplayed = $stats['gamesplayed'];
				$goals = $stats['totalgoals'];
				$assists = $stats['totalassists'];
				$points = $goals + $assists;
				$pim = $stats['totalpim'];				

				$smarty->append('statPlayerID', $playerId);
				$smarty->append('statJerseyNumber', $jerseyNumber);
				$smarty->append('statPlayerName', $playerName);
			  $smarty->append('gamesplayed', $gamesplayed);
			  $smarty->append('goals', $goals);
			  $smarty->append('assists', $assists);
			  $smarty->append('points', $points);		
			  $smarty->append('pim', $pim);	
			}
		}
		

		
		//Goalie Stats Setup	
	$selectFields = GOALIESTAT.'.playerID,jerseyNumber,CONCAT(playerFName," ",playerLName) AS name,COUNT(*) AS gamesplayed,SUM(shots) AS totalshots,SUM(goalsagainst) AS totalga';
	$select = 'SELECT '.$selectFields.' FROM '.GOALIESTAT;
	$select .= ' JOIN '.PLAYER.' ON '.GOALIESTAT.'.playerID = '.PLAYER.'.playerID';
  $select .= ' JOIN '.ROSTERSOFTEAMSOFSEASONS.' ON '.GOALIESTAT.'.playerID = '.ROSTERSOFTEAMSOFSEASONS.'.playerID';
	$select .= ' WHERE gameID IN ('.$gamesInGameType.')';
	$select .= ' AND '.GOALIESTAT.'.playerID IN ('.$roster.')';
	$select .= ' AND '.GOALIESTAT.'.teamID='.$TEAM;
	$select .= ' AND '.ROSTERSOFTEAMSOFSEASONS.'.teamID='.$TEAM;	
	$select .= ' GROUP BY '.GOALIESTAT.'.playerID';
	$select .= ' ORDER BY jerseyNumber';

	$result = mysql_query($select, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
		  $smarty->assign('statGoalieID', array ());
		  $smarty->assign('statGoalieJerseyNumber', array ());
		  $smarty->assign('statGoaliePlayerName', array ());
		  $smarty->assign('goalieGamesplayed', array ());
		  $smarty->assign('ga', array ());
		  $smarty->assign('gaa', array ());
		  $smarty->assign('saves', array ());		  
		  $smarty->assign('pct', array ());		  


			while ($stats = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$playerId = $stats['playerID'];
				if($stats['jerseyNumber'] < 10) {
					$jerseyNumber = "0".$stats['jerseyNumber'];
				} else {
				  $jerseyNumber = $stats['jerseyNumber'];
				}
				$playerName = $stats['name'];				
				$gamesplayed = $stats['gamesplayed'];
				$shots = $stats['totalshots'];
				$ga = $stats['totalga'];
				$gaa = $ga / $gamesplayed;
				$saves = $shots - $ga;
				if($shots == $ga) {
					$pct = 0;
				} else if ($shots > 0 && $ga == 0){
					$pct = 1;
				} else {
				  $pct = 1 - ($ga / $shots);
				}			

				$smarty->append('statGoalieID', $playerId);
				$smarty->append('statGoalieJerseyNumber', $jerseyNumber);
				$smarty->append('statGoaliePlayerName', $playerName);
			  $smarty->append('goalieGamesplayed', $gamesplayed);
			  $smarty->append('ga', $ga);
			  $smarty->append('gaa', number_format($gaa,2));
				$smarty->append('saves', $saves);			  
			  $smarty->append('pct', number_format($pct,3));
			}
		}		
}

// Setup Team Sponsors
function setup_team_sponsors() {
  global $smarty;
	global $Link;
	global $TEAM;
	global $SEASON;
	
  $smarty->assign('SPONSOR_GROUP', 'Team');
  
	$foundSeasonWithSponsors = false;
	$seasonTest = $SEASON;
	
	while(!$foundSeasonWithSponsors) {
		$select = 'SELECT * FROM '.SPONSORSOFSEASONS.' WHERE teamID='.$TEAM.' AND seasonID='.$seasonTest.' LIMIT 1';
		
	    $result = mysql_query($select, $Link);		
		
		if ($result && mysql_num_rows($result) > 0) {	
			$foundSeasonWithSponsors = true;		
		} else {
			$seasonTest--;
			if($seasonTest == 0) {
				$foundSeasonWithSponsors = true;
			}
		}
	}
	
	if($foundSeasonWithSponsors && $seasonTest != 0) {
	  	
  	$selectColumns = 'sponsorID,sponsorName,sponsorLogoWidth, sponsorLogoHeight';
		
		$subQuery = 'SELECT distinct sponsorID FROM '.SPONSORSOFSEASONS.' WHERE teamID='.$TEAM.' AND seasonID='.$seasonTest;
		
		$sponsorsSelect = 'SELECT '.$selectColumns.' FROM '.SPONSORS.' WHERE sponsorID IN ('.$subQuery.') ORDER BY sponsorName';
	
		$sponsorsResult = mysql_query($sponsorsSelect, $Link);
		
		if ($sponsorsResult) {
			if (mysql_num_rows($sponsorsResult) > 0) {			
	
			  $countSponsors=0;
			  $smarty->assign('sponsorID', array ());
			  $smarty->assign('sponsorName', array ());	
			  $smarty->assign('imageSize', array ());			  
	            
				while ($sponsor = mysql_fetch_array($sponsorsResult, MYSQL_ASSOC)) {
					
					$countSponsors++;
					$sponsorId = $sponsor['sponsorID'];
					$sponsorName = $sponsor['sponsorName'];		
					$logoWidth = $sponsor['sponsorLogoWidth'];
					$logoHeight = $sponsor['sponsorLogoHeight'];	
					
					$smarty->append('countSponsors', $countSponsors);
					$smarty->append('sponsorID', $sponsorId);
					$smarty->append('sponsorName', $sponsorName); 
					
					if ($logoWidth > 0) {
						$smarty->append('imageSize', imageSize($logoWidth, $logoHeight, 200));
					} else {
						$smarty->append('imageSize', 0);
					}
	
				}
				$smarty->assign('countSponsors', $countSponsors);
			}
		}
	}  

}
?>
