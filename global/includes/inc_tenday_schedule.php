<?php
/*
 * Created on Oct 31, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 $smarty->assign('current_gamedate', -1);

 $today = time();
 $todayBeginningOfDay = mktime(0,0,0,date('m',$today),date('d',$today),date('Y',$today),-1);
 $todayEndOfDay = mktime(23,59,59,date('m',$today),date('d',$today),date('Y',$today),-1);
 
 $tomorrow = $today + ONE_DAY;
 $tomorrowBeginningOfDay = mktime(0,0,0,date('m',$tomorrow),date('d',$tomorrow),date('Y',$tomorrow),-1);
 $tomorrowEndOfDay = mktime(23,59,59,date('m',$tomorrow),date('d',$tomorrow),date('Y',$tomorrow),-1);
 
 $tendays = $today + TEN_DAYS;
 
 global $Link;
 
 $scheduleSelectColumns = 'gameID,gameTime,gameGuestTeam,gameHomeTeam,gameReferee1,gameReferee2,gameReferee3,postponed,announcementID';
 
 //gameGuestTeam,gameHomeTeam,gameReferee1,gameReferee2,gameReferee3
 
 $scheduleSelect = 'SELECT '.$scheduleSelectColumns.' FROM '.GAME; 
 $scheduleSelect .= ' WHERE gameTime>='.$today;
 $scheduleSelect .= ' AND gameTime<='.$tendays; 
 $scheduleSelect .= ' AND seasonID='.$SEASON;
 $scheduleSelect .= ' ORDER BY gameTime';
 
 
	$scheduleResult = mysql_query($scheduleSelect, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	
	if ($scheduleResult && mysql_num_rows($scheduleResult) > 0) {
		  $smarty->assign('gameId', array ());
		  $smarty->assign('gameDateLabel', array ());
		  $smarty->assign('gameDate', array ());
		  $smarty->assign('gameTime', array ());
      $smarty->assign('gameGuestTeam', array ());
      $smarty->assign('gameHomeTeam', array ());          
      $smarty->assign('gameReferee1', array ());
      $smarty->assign('gameReferee2', array ());
      $smarty->assign('gameReferee3', array ());
      $smarty->assign('postponed', array ());       
      $smarty->assign('announcementID', array ());  
            
			while ($game = mysql_fetch_array($scheduleResult, MYSQL_ASSOC)) {		
				$gameId = $game['gameID'];
				$gameDate = date('D, M jS',$game['gameTime']);
				$gameTime = date('g:i a', $game['gameTime']);
				$gameGuest = get_team_name($game['gameGuestTeam']);
				$gameHome = get_team_name($game['gameHomeTeam']);
				$gameRef1 = get_player_name($game['gameReferee1']);
				$gameRef2 = get_player_name($game['gameReferee2']);
				$gameRef3 = get_player_name($game['gameReferee3']);
				$gamePostponed = $game['postponed'];
				
				if($game['announcementID'] > 0) {
					$gameAnnouncementId = $game['announcementID'];
				} else {
					$gameAnnouncementId = 'NA';
				}
	
				$gameDateLabel = '';
				if($todayBeginningOfDay <= $game['gameTime'] && $game['gameTime'] <= $todayEndOfDay) {
					$gameDateLabel .= 'Today';	
				} else if($tomorrowBeginningOfDay <= $game['gameTime'] && $game['gameTime'] <= $tomorrowEndOfDay)  {
					$gameDateLabel .= 'Tomorrow';
				} else {
					$gameDateLabel .= $gameDate;
				}	


				$smarty->append('gameId', $gameId);
				$smarty->append('gameDateLabel', $gameDateLabel);
				$smarty->append('gameDate', $gameDate);
				$smarty->append('gameTime', $gameTime);
        		$smarty->append('gameGuestTeam', $gameGuest);
        		$smarty->append('gameHomeTeam', $gameHome);
        		$smarty->append('gameReferee1', $gameRef1);
				$smarty->append('gameReferee2', $gameRef2);
				$smarty->append('gameReferee3', $gameRef3);
				$smarty->append('postponed', $gamePostponed);
				$smarty->append('announcementID', $gameAnnouncementId);
			}
		}

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/
?>
