<?php
/*
 * Created on Sep 19, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');

// Set for every page
require ('engine/common.php');

$gameid = 0;
$gameTime = 0;
$gameTimeTitleFormat = 0;
$gameGuest = 0;
$gameHome = 0;
$gameGuestName = '';
$gameHomeName = '';
$gameOption = '';
$newGameTime = -1;
$announcementBeginDate = 0;
$announcementEndDate = 0;

$MONTH_SELECTED = 0;
$DAY_SELECTED = 0;
$YEAR_SELECTED = 0;
$HOUR_SELECTED = 0;
$MINUTE_SELECTED = 0;
$AMPM_SELECTED = 0;

if($_GET || $_POST) {
	if(isset($_GET['gameid']) && $_GET['gameid'] > 0) {
		$gameid = $_GET['gameid'];
	} else if(isset($_POST['gameid']) && $_POST['gameid'] > 0) {
		$gameid = $_POST['gameid'];
	} else {
		header("Location: gamemanager.php");
	}	
}

set_game_current_status();
set_game_info_selects();

if(isset($_GET['rescheduleGame']) && $_GET['rescheduleGame'] == 1) {
	$smarty->assign('rescheduleGame', 1);
	$gameOption = 'Rescheduling';
} else {
	$gameOption = 'Postponement';
}

if ((isset ($_POST['sendcorrespondence'])) && ($_POST['sendcorrespondence'] == "YES")) {
	$sendcorrespondence = 'YES';
} else {
	$sendcorrespondence = 'NO';
}

if ((isset ($_POST['action'])) && ($_POST['action'] == "Postpone Game")) {
	process_postponement();
	header("Location: gamemanager.php");
}

if ((isset ($_POST['action'])) && ($_POST['action'] == "Reschedule Game")) {
	process_rescheduling();
	header("Location: gamemanager.php");
}

$smarty->assign('page_name', 'Manage Game '.$gameOption);

$smarty->assign('gameid', $gameid);

// Build the page
require ('global_begin.php');
$smarty->display('admin/managepostponement.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/ 

/*
 * This function checks to see a games current status.  It can be gameOn,
 * postponed or past.  If it is gameOn, then the admin user will have the option
 * to postpone the game.  If it is postponed then the admin user will have the
 * option to reschedule the game.  If it is past, then the game is in the past
 * the game cannot be postponed.
 */
function set_game_current_status()  {
	global $smarty;
	global $gameid;
	global $gameTime;
	global $gameTimeTitleFormat;
	global $gameGuest;
	global $gameHome;
	global $gameGuestName;
	global $gameHomeName;		
	global $gameOption;
	global $MONTH_SELECTED;
	global $DAY_SELECTED;
	global $YEAR_SELECTED;
	global $HOUR_SELECTED;
	global $MINUTE_SELECTED;
	global $AMPM_SELECTED;
	
	global $Link;
	
	$statusQuery = 'SELECT gameTime,gameGuestTeam,gameGuestScore,gameHomeTeam,gameHomeScore,postponed from '.GAME.' WHERE gameID='.$gameid;
	
	$statusResult = mysql_query($statusQuery, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
	if ($statusResult && mysql_num_rows($statusResult) > 0) {
	  $status = mysql_fetch_assoc($statusResult);
	  
	  $currentTime = time();
	  if($currentTime <= $status['gameTime']) {
	  	if($status['postponed'] == 1) {
	  		$smarty->assign('gamePostponed', 1);
	  		$gameOption = 'Rescheduling';
	  	} else {
	  		$smarty->assign('gameOn', 1);
	  	}
	  } else if($status['gameGuestScore'] >= 0 && $status['gameHomeScore'] >= 0){
	  	$smarty->assign('gamePastButNoScore', 1);
	  }
	  
	  $gameGuest = $status['gameGuestTeam'];
	  $gameHome = $status['gameHomeTeam'];
	  $gameGuestName = get_this_games_team_name($status['gameGuestTeam']);
	  $gameHomeName = get_this_games_team_name($status['gameHomeTeam']);	  
	  $gameTime = date('l, F j, Y \a\t g:i A', $status['gameTime']);
	  $gameTimeTitleFormat = date('n.j.y', $status['gameTime']);
		$MONTH_SELECTED = date('m', $status['gameTime']);
		$DAY_SELECTED = date('d', $status['gameTime']);
		$YEAR_SELECTED = date('Y', $status['gameTime']);
		$HOUR_SELECTED = date('h', $status['gameTime']);
		$MINUTE_SELECTED = date('i', $status['gameTime']);
		$AMPM_SELECTED = date('A', $status['gameTime']);
	  $smarty->assign('gameTime', $gameTime);
	  $smarty->assign('guestTeam', $gameGuestName);
	  $smarty->assign('homeTeam', $gameHomeName);
	}	
		
}

/*
 * Set game info selects
 */
function set_game_info_selects() {
	global $smarty;
	global $MONTH_SELECTED;
	global $DAY_SELECTED;
	global $YEAR_SELECTED;
	global $HOUR_SELECTED;
	global $MINUTE_SELECTED;
	global $AMPM_SELECTED;
	
	$smarty->assign('monthSelect', select_month('1'));
	$smarty->assign('daySelect', select_day('1'));
	$smarty->assign('yearSelect', select_year('1'));
	$smarty->assign('hourSelect', select_hour('1'));
	$smarty->assign('minuteSelect', select_minute('1'));
	$smarty->assign('ampmSelect', select_ampm('1'));
}

/*
 * Get Team Name
 */
 function get_this_games_team_name($teamId) {
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

/*
 * Process postponement
 */
function process_postponement() {
	global $gameTime;
	global $gameTimeTitleFormat;
	global $gameGuestName;
	global $gameHomeName;
	global $sendcorrespondence;
	
	$emailAddresses = get_addresses();
	$subject = 'POSTPONED '.$gameTimeTitleFormat.' - '.$gameGuestName.' vs '.$gameHomeName;	
	$messageBody = 'The TCSHL would like to inform you that the game between';
	$messageBody .= ' '.$gameGuestName.' and '.$gameHomeName.' which was originally';
	$messageBody .= ' going to be played on '.$gameTime.' has been postponed.';
	$messageBody .= ' Information will be provided once this game has been rescheduled.';
	
	if(isset($_POST['emailbody']) && strlen($_POST['emailbody']) > 0) {
		$messageBody .= 'Additional Notes: '.$_POST['emailbody'];
	}
	
	$messageBody .= '~TCSHL Board.';
	
	//Set game postponed to 1
	set_game_postponed();
	
	if($sendcorrespondence == 'YES') {
		//Create announcement in database
		set_announcement($subject,$messageBody);
		
		//Send out email to recipients.
		send_email($subject,$messageBody);
	}
	
	
	
}

/*
 * Process rescheduling
 */
function process_rescheduling() {
	/*
	 * TODO: This entire function will have to be looked at.  Might have to
	 * run through the reschedule code before the message is generated in order
	 * to get the new schedule time.
	 */
	
	global $gameTime;
	global $newGameTime;	
	global $gameTimeTitleFormat;
	global $gameGuestName;
	global $gameHomeName;
	global $sendcorrespondence;

	// Reschedule game.  Done before the message is generated to get updated game time.
	set_game_reschedule();
	
	$emailAddresses = get_addresses();
	$subject = 'RESCHEDULED '.$gameTimeTitleFormat.' - '.$gameGuestName.' vs '.$gameHomeName;	
	$messageBody = 'The TCSHL would like to inform you that the game between';
	$messageBody .= ' '.$gameGuestName.' and '.$gameHomeName.' which was originally';
	$messageBody .= ' going to be played on '.$gameTime.' has been rescheduled';
	$messageBody .= ' for '.date('l, F j, Y \a\t g:i A', $newGameTime).'.';
	$messageBody .= ' Please check with your team rep if you have any further questions.';
	
	if(isset($_POST['emailbody']) && strlen($_POST['emailbody']) > 0) {
		$messageBody .= 'Additional Notes: '.$_POST['emailbody'];
	}
	
	$messageBody .= ' ~TCSHL Board.';
	
	if($sendcorrespondence == 'YES') {
		//Create announcement in database
		set_announcement($subject,$messageBody);
		
		//Send out email to recipients.
		send_email($subject,$messageBody);
	}	
}

function get_addresses() {
	global $SEASON;
	global $gameid;
	global $gameGuest;
	global $gameHome;	
	
	$emailAddresses = '';
	
	
	global $Link;
	
	$guestTeamSelect = 'SELECT playerID FROM '.ROSTERSOFTEAMSOFSEASONS.' WHERE teamID='.$gameGuest.' AND seasonID='.$SEASON;
	$homeTeamSelect = 'SELECT playerID FROM '.ROSTERSOFTEAMSOFSEASONS.' WHERE teamID='.$gameHome.' AND seasonID='.$SEASON;
	$ref1Select = 'SELECT gameReferee1 FROM '.GAME.' WHERE gameID='.$gameid;	
	$ref2Select = 'SELECT gameReferee2 FROM '.GAME.' WHERE gameID='.$gameid;
	$ref3Select = 'SELECT gameReferee3 FROM '.GAME.' WHERE gameID='.$gameid;
	
	$addressSelect = 'SELECT eMail FROM '.REGISTRATION;
	$addressSelect .= ' WHERE (playerId IN ('.$guestTeamSelect.')';
	$addressSelect .= ' OR playerId IN ('.$homeTeamSelect.')';
	$addressSelect .= ' OR playerId IN ('.$ref1Select.')';
	$addressSelect .= ' OR playerId IN ('.$ref2Select.'))';
	//$addressSelect .= ' OR playerId IN ('.$ref3Select.'))';
	$addressSelect .= ' AND eMail IS NOT NULL';
	$addressSelect .= ' GROUP BY eMail';

//echo $addressSelect; die;

	$addressResult = mysql_query($addressSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	
	if ($addressResult && mysql_num_rows($addressResult) > 0) {            
			while ($person = mysql_fetch_array($addressResult, MYSQL_ASSOC)) {
				if(strlen($person['eMail']) > 0) {
				  $emailAddresses .= $person['eMail'].',';
				}
			}
		}
		
		
	
	$emailAddresses .= 'administrator@tcshl.com';
		
	return $emailAddresses;
}

/*
 * Set Game to postponed
 */
function set_game_postponed() {
	global $gameid;	
	
	
	global $Link;
	
	$gameUpdate = 'UPDATE '.GAME.' SET postponed=1 WHERE gameID='.$gameid;
	
	$gameResult = mysql_query($gameUpdate, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
			
 }

/*
 * Reschedule Game
 */
function set_game_reschedule() {
	global $gameid;	
	global $newGameTime;
	
	
	global $Link;
	
	$hour = $_POST['hour'];
	if($_POST['ampm'] == "PM") {
		$hour = $hour + 12;
	}
	
	$newGameTime = mktime($hour,$_POST['minute'],0,$_POST['month'],$_POST['day'],$_POST['year'],-1);
	
	
	$addGameUpdate = 'UPDATE '.GAME.' SET `gameTime` = '.$newGameTime.',`postponed`=0 WHERE gameID='.$gameid;

	$addGameUpdateResult = mysql_query($addGameUpdate, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

		
 }

/*
 * Determine Start and End Dates for announcement
 */
function set_start_end_announce_dates() {
	global $gameid;	
  global $newGameTime;
  global $announcementBeginDate;
	global $announcementEndDate;
	
	
	global $Link;
	
	if($newGameTime < 0) {
		$select = 'SELECT gameTime FROM '.GAME.' WHERE gameID='.$gameid;
		$result = mysql_query($select, $Link)
		  or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());	
		
		if ($result && mysql_num_rows($result) > 0) {            
				while ($game = mysql_fetch_array($result, MYSQL_ASSOC)) {
					  $gameTime = $game['gameTime'];
				}
			}
	}
	
	//If postponed, we will run announcement at most two weeks before game time.
	if ((isset ($_POST['action'])) && ($_POST['action'] == "Postpone Game")) {
	  $announcementBeginDate = $gameTime - (60*60*24*14);
	  //End time will be 60 seconds * 60 minutes == 1 hour
	  $announcementEndDate = $gameTime + (60*60);	
	}
	
	//If rescheduled we will run up until new gametime or four weeks before
	if ((isset ($_POST['action'])) && ($_POST['action'] == "Reschedule Game")) {
		if($newGameTime > 0) {
		  $announcementBeginDate = $newGameTime - (60*60*24*28);
			//End time will be 60 seconds * 60 minutes == 1 hour
			$announcementEndDate = $newGameTime + (60*60);			  
		} else {
			$announcementBeginDate = $gameTime - (60*60*24*28);
			//End time will be 60 seconds * 60 minutes == 1 hour
			$announcementEndDate = $gameTime + (60*60);				
		}
	}
}

/*
 * Set Announcement
 */
function set_announcement($announceSubject = "", $announceBody = "") {
	global $gameid;	
  global $newGameTime;
  global $announcementBeginDate;
	global $announcementEndDate;
	
	
	global $Link;
	
	$announceStatusSelect = 'SELECT announcementID FROM '.GAME.' WHERE gameID='.$gameid;
	
	$latestGameAnnouncementID = -1;
	
	$announceStatusResult = mysql_query($announceStatusSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
		if ($announceStatusResult && mysql_num_rows($announceStatusResult) > 0) {            
	  		$announce = mysql_fetch_assoc($announceStatusResult);
	  		if($announce['announcementID'] > 0) {
	  			$latestGameAnnouncementID = $announce['announcementID'];
	  		}
		}
		
	
	// Decide Announcement Start and End Dates
	set_start_end_announce_dates();
	
	// Create announcement
	$setAnnounceSelect = 'INSERT INTO '.ANNOUNCEMENTS.' (`announceTitle`,`announcement`,`announceBeginDate`,`announceEndDate`,`userID`) VALUES("'.$announceSubject.'","'.$announceBody.'",'.$announcementBeginDate.','.$announcementEndDate.','.$_SESSION['userid'].')';

	$setAnnounceResult = mysql_query($setAnnounceSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());


	//Update current game with new announcement id.
	if($setAnnounceResult)	{
		$announceId = mysql_insert_id();
		
		$setAnnounceIdSQL = 'UPDATE '.GAME.' SET announcementID='.$announceId.' WHERE gameID='.$gameid;

		$setAnnounceIdResult = mysql_query($setAnnounceIdSQL, $Link)
			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

	}
		
	//Delete old announcement if there is one.  Otherwise, we are done.
	if($latestGameAnnouncementID > 0) {
		$oldAnnounceDelete = 'DELETE FROM '.ANNOUNCEMENTS.' WHERE announceId='.$latestGameAnnouncementID;
	
		$oldAnnounceDeleteResult = mysql_query($oldAnnounceDelete, $Link)
			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());	
	}
	

 }

/*
 * Send email
 */
function send_email($emailSubject = "", $emailBody = "") {
 	// Note these emails need to be Blind Carbon Coby
 	$emailAddresses = get_addresses();
 	 	
	$headers = "From: ".TCSHL_EMAIL . "\n";
	$headers .= "Bcc: $emailAddresses" . "\n";
 	
	//Send email
	mail('', $emailSubject, $emailBody, $headers);
 }
 

?>
