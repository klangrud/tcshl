<?php
/*
 * Created on Sep 27, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 if(isset($GAMEID) && $GAMEID > 0) {
 	//Do nothing
 } else {
 	$GAMEID = 'ALL';
 } 
 
 if(isset($GAMETYPE) && $GAMETYPE > 0) {
 	//Do nothing
 } else {
 	$GAMETYPE = get_gametype();
 } 
 
 if(isset($PLAYERID) && $PLAYERID > 0) {
 	//Do nothing
 } else {
 	$PLAYERID = 'ALL';
 }
 
 
 global $Link;
 
 $playerStatsSelectColumns = 'goals,assists,pim';
 
 $playerStatsSelect = 'SELECT '.$playerStatsSelectColumns.' FROM '.PLAYERSTAT;
 
 $playerStatsSelect .= ' WHERE gameID > 0'; 
 
 if($GAMEID == 'ALL') {
 	$gamesSelect = 'SELECT gameID FROM '.GAME.' WHERE seasonID='.$SEASON.' AND gameType="'.$GAMETYPE.'"';
 	$playerStatsSelect .= ' AND gameID NOT IN ('.$gamesSelect.')';
 }
 
 if($PLAYERID > 0) {
 	$playerStatsSelect .= ' AND playerID='.$PLAYERID;
 } 
 
 if($TEAM > 0){
 	$scheduleSelect .= ' AND (gameGuestTeam='.$TEAM.' OR gameHomeTeam='.$TEAM.')';
 }
 $scheduleSelect .= ' ORDER BY gameTime';
 
	$scheduleResult = mysql_query($scheduleSelect, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	$seasonSkedName = '';
	if($TEAM > 0) {
		$seasonSkedName .= get_sked_team_name($TEAM).' ';
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
		  $smarty->assign('gameTime', array ());
      $smarty->assign('gameGuestTeam', array ());
      $smarty->assign('gameGuestScore', array ());
      $smarty->assign('gameHomeTeam', array ());
      $smarty->assign('gameHomeScore', array ());           
      $smarty->assign('gameReferee1', array ());
      $smarty->assign('gameReferee2', array ());
      $smarty->assign('gameReferee3', array ());
      $smarty->assign('postponed', array ());           
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
				$gameTime = date('D, M j, \'y g:i a',$game['gameTime']);
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
				$smarty->append('gameTime', $gameTime);
				$smarty->append('gameGuestTeam', $gameGuest);
        		$smarty->append('gameGuestScore', $gameGuestScore);
        		$smarty->append('gameHomeTeam', $gameHome);
        		$smarty->append('gameHomeScore', $gameHomeScore);
        		$smarty->append('gameReferee1', $gameRef1);
				$smarty->append('gameReferee2', $gameRef2);
				$smarty->append('gameReferee3', $gameRef3);
				$smarty->append('postponed', $gamePostponed);
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
 
?>
