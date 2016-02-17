<?php
/*
 * Created on Sep 11, 2007
 *
 * This file is not meant to be hit on its own.  It is to be an include only.
 */

 if(isset($TEAM) && $TEAM > 0) {
 	//Do nothing
 } else {
 	$TEAM = 'ALL';
 }
 
 $smarty->assign('current_gametype', -1);
 
 $today = time();
 $todayBeginningOfDay = mktime(0,0,0,date('m',$today),date('d',$today),date('Y',$today),-1);
 $todayEndOfDay = mktime(23,59,59,date('m',$today),date('d',$today),date('Y',$today),-1);
 
 
 global $Link;
 
 $scheduleSelectColumns = 'gameID,gameType,gameTime,gameGuestTeam,gameGuestScore,gameHomeTeam,gameHomeScore,gameReferee1,gameReferee2,gameReferee3,postponed,announcementID';
 
 //gameGuestTeam,gameHomeTeam,gameReferee1,gameReferee2,gameReferee3
 
 $scheduleSelect = 'SELECT '.$scheduleSelectColumns.' FROM '.GAME;
 
 $scheduleSelect .= ' WHERE seasonID='.$SEASON;
 
 if($TEAM > 0){
 	$scheduleSelect .= ' AND (gameGuestTeam='.$TEAM.' OR gameHomeTeam='.$TEAM.')';
 }
 $scheduleSelect .= ' ORDER BY gameTime';
 
	$scheduleResult = mysql_query($scheduleSelect, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	$seasonSkedName = '';
	if($TEAM > 0) {
		$seasonSkedName .= get_team_name($TEAM).' ';
	}
	$seasonSkedName .= get_season_name($SEASON);
	
	$smarty->assign('seasonName', $seasonSkedName);
	
	$currentTime = time();
	
	if ($scheduleResult && mysql_num_rows($scheduleResult) > 0) {			

		  $countGames=0;
		  $smarty->assign('gameCount', array ());
		  $smarty->assign('gameToday', array ());
		  $smarty->assign('gameType', array ());
		  $smarty->assign('gameId', array ());
		  $smarty->assign('gameDate', array ());
		  $smarty->assign('gameTime', array ());
      $smarty->assign('gameGuestTeam', array ());
      $smarty->assign('gameGuestScore', array ());
      $smarty->assign('gameHomeTeam', array ());
      $smarty->assign('gameHomeScore', array ());           
      $smarty->assign('gameReferee1', array ());
      $smarty->assign('gameReferee2', array ());
      $smarty->assign('gameReferee3', array ());
      $smarty->assign('postponed', array ());
      $smarty->assign('gameHasStats', array ());        
      $smarty->assign('announcementID', array ());
      $smarty->assign('gameTimeInPast', array());    
            
			while ($game = mysql_fetch_array($scheduleResult, MYSQL_ASSOC)) {
				$countGames++;
				if($todayBeginningOfDay <= $game['gameTime'] && $game['gameTime'] <= $todayEndOfDay) {
					$gameToday = 1;	
				} else {
					$gameToday = 0;	
				}
				$gameId = $game['gameID'];
				$gameType = $game['gameType'];
				$gameDate = date('D, M j',$game['gameTime']);
				$gameTime = date('g:i a', $game['gameTime']);
				$gameGuest = get_team_name($game['gameGuestTeam']);
				if(isset($game['gameGuestScore'])) {
				  $gameGuestScore = $game['gameGuestScore'];
				} else {
					$gameGuestScore = '&nbsp;';
				}
				$gameHome = get_team_name($game['gameHomeTeam']);
				if(isset($game['gameHomeScore'])) {
				  $gameHomeScore = $game['gameHomeScore'];
				} else {
					$gameHomeScore = '&nbsp;';
				}
				$gameRef1 = get_player_name($game['gameReferee1']);
				$gameRef2 = get_player_name($game['gameReferee2']);
				$gameRef3 = get_player_name($game['gameReferee3']);
				$gamePostponed = $game['postponed'];
				
				if(game_has_stats($gameId)) {
					$gameHasStats = true;
				} else {
					$gameHasStats = false;
				}
				
				if($game['announcementID'] > 0) {
					$gameAnnouncementId = $game['announcementID'];
				} else {
					$gameAnnouncementId = 'NA';
				}
	
				if($currentTime > $game['gameTime']) {
					$gameTimeInPast = true;
				} else {
					$gameTimeInPast = false;
				}			

				$smarty->append('gameCount', $countGames);
				$smarty->append('gameToday', $gameToday);
				$smarty->append('gameId', $gameId);
				$smarty->append('gameType', $gameType);
				$smarty->append('gameDate', $gameDate);
				$smarty->append('gameTime', $gameTime);
				$smarty->append('gameGuestTeam', $gameGuest);
        $smarty->append('gameGuestScore', $gameGuestScore);
        $smarty->append('gameHomeTeam', $gameHome);
        $smarty->append('gameHomeScore', $gameHomeScore);
        $smarty->append('gameReferee1', $gameRef1);
				$smarty->append('gameReferee2', $gameRef2);
				$smarty->append('gameReferee3', $gameRef3);
				$smarty->append('postponed', $gamePostponed);
				$smarty->append('gameHasStats', $gameHasStats);
				$smarty->append('announcementID', $gameAnnouncementId);
				$smarty->append('gameTimeInPast', $gameTimeInPast);   

			}
			$smarty->assign('countGames', $countGames);
		}

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

function game_has_stats($gameid) {
	global $Link;
	
	$gStatSelect = 'SELECT count(*) AS count FROM '.GOALIESTAT.' WHERE gameID='.$gameid;
	$pStatSelect = 'SELECT count(*) AS count FROM '.PLAYERSTAT.' WHERE gameID='.$gameid;
	
	$ttlStats = 0;
	
	// Goalie stat count
	$gStatResult = mysql_query($gStatSelect, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  
  if ($gStatResult && mysql_num_rows($gStatResult) > 0) {
			$gStats = mysql_fetch_assoc($gStatResult);
			$ttlStats += $gStats['count'];  	
  }	
  
  // Player stat count
	$pStatResult = mysql_query($pStatSelect, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  		  
  if ($pStatResult && mysql_num_rows($pStatResult) > 0) {
			$pStats = mysql_fetch_assoc($pStatResult);
			$ttlStats += $pStats['count'];  	
  }	
	
	if($ttlStats > 0) {
		return true;
	} else {
		return false;
	}
}

?>
