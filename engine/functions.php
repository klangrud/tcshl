<?php
/*
 * Adds a <br /> to \n in large text database fields
 */
 function format_paragraph($Paragraph) {
 	return str_replace("\n", '<br />', $Paragraph);
 }
 
/*
 * Change selected.  This function helps with reposts of select menus.
 */
function change_selected($menu, $select_value) {
	$find_string = "value=\"$select_value\"";
	$replace_string = "value=\"$select_value\" selected";
	return str_ireplace($find_string, $replace_string, $menu);
}


/*
 * Get Month
 */
function get_month($unix_timestamp) {
	$thisDateComponent = getdate($unix_timestamp);
	$month = $thisDateComponent['mon'];
	return $month;
}

/*
 * Get Day
 */
function get_day($unix_timestamp) {
	$thisDateComponent = getdate($unix_timestamp);
	$day = $thisDateComponent['mday'];	
	return $day;
}

/*
 * Get Year
 */
function get_year($unix_timestamp) {
	$thisDateComponent = getdate($unix_timestamp);
	$year = $thisDateComponent['year'];	
	return $year;
}

/*
 * Validates an email address
 */
function validate_email($email) {
	return (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email));
}
 
/*
 * Formats Text to be stored in Database.
 * Use for blogs.  Use format_trim for small entrys, like name.
 */
function format_text($original_text = "") {
	$formatted_text = trim($original_text);
	//$formatted_text = str_replace("'", "\'", $formatted_text);
	$formatted_text = str_replace('"', '\"', $formatted_text);
	return $formatted_text;
}

/*
 * Formats Text to be stored in Database.
 * Use for blogs.  Use format_trim for small entrys, like name.
 */
function format_singlequotes($original_text = "") {
	$formatted_text = trim($original_text);
	$formatted_text = str_replace("'", "\'", $formatted_text);
	//$formatted_text = str_replace('"', '\"', $formatted_text);
	return $formatted_text;
}


/*
 * Formats Text to be stored in Database.
 * Use for blogs.  Use format_trim for small entrys, like name.
 */
function format_doublequotes($original_text = "") {
	$formatted_text = trim($original_text);
	//$formatted_text = str_replace("'", "\'", $formatted_text);
	$formatted_text = str_replace('"', '\"', $formatted_text);
	return $formatted_text;
}


/*
 * Formats Text to be stored in Database.
 * Uppercases text, for small text fields like name.
 * Can also be used on one letter fields like middle initial.
 */
function format_uppercase_text($original_text = "") {
	$formatted_text = trim($original_text);
	$formatted_text = strtolower($formatted_text);
	$formatted_text = ucfirst($formatted_text);
	// Edge case.
	$test_string = strtolower($formatted_text);
	if(substr($test_string, 0, (2 - strlen($test_string))) == "mc") {
		$formatted_text = strtolower($formatted_text);
		$first_part = substr($formatted_text, 0, (2 - strlen($formatted_text)));
		$second_part = substr($formatted_text, 2, (strlen($formatted_text) - 2));
		$first_part = ucfirst($first_part);
		$second_part = ucfirst($second_part);
		$formatted_text = $first_part.$second_part;
	}
	return $formatted_text;
}

/*
 * Trim values.  This can be used by reposts, or before putting into database.
 * Use for small text entrys, like username, where text doesn't need uppercased.
 * Use format_text for blogs.
 */
function format_trim($original_text = "") {
	$formatted_text = trim($original_text);
	return $formatted_text;
}

/*
 * This will return the first letter of a string.  This is good if you want the
 * initials of someone's name.
 */
function format_initial($original_text = "") {
	$formatted_text = substr($original_text, 0,1);
	return $formatted_text;
}


/*
 * This will return the first $n letters of a string.  This is good for cutting
 * down the body of announcements.
 */
function format_body($original_text = "", $n = "") {
	$formatted_text = substr($original_text, 0,$n);
	return $formatted_text;
}

/*
 * Validate Text.  Checks that there are no bad charaters.
 * e.g. A firstname does not contain ' or "
 */
function valid_text($original_text = "") {
	$isValid = true;
	if(stristr($original_text, "'") == true) {
		$isValid = false;
	}
	return $isValid;

}

/*
 * Success handling
 */
function handle_success($success_array = '') {
	global $smarty;
	$smarty->assign('success', array());
	foreach ($success_array as $success) {
		$smarty->append('success', $success);
	}
}

/*
 * Error handling
 */
function handle_errors($errors = '') {
	global $smarty;
	$smarty->assign('errors', array());
	foreach ($errors as $error) {
		$smarty->append('errors', $error);
	}
}


 //function to resize an image and return the new width and height - imageSize
 function imageSize($width, $height, $targetWidth) 
    { 
    if($targetWidth >= $width) {
    	$targetWidth = $width;
    } else {
    	$percentage = ($targetWidth / $width); 
    	$height = round($height * $percentage);
    } 
    return "width='$targetWidth' height='$height'"; 
 }
      
/*
 * Validate Email Domain Name
 */
function valid_domain($email = "") {
	$domain = stristr($email, '@');
	$domain = substr($domain, 1, strlen($domain));
	if (!strcmp($domain, VALID_DOMAIN) == 0) {
		return false;
	}
	return true;
}

/*
 * Get Season Name
 */
 function get_season_name($seasonId = "") {
	$seasonName = "";
	
	global $Link;
	
	$seasonSelect = 'SELECT seasonName FROM '.SEASONS.' WHERE seasonId='.$seasonId;
	
	$seasonResult = mysql_query($seasonSelect, $Link);
	
	if ($seasonResult) {
		if (mysql_num_rows($seasonResult) > 0) {
			$season = mysql_fetch_assoc($seasonResult);
			$seasonName = $season['seasonName'];
		}
	}
	//
	return $seasonName;
}

/*
 * Get Team Name
 */
 function get_team_name($teamId = "") {
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
 * Setup Team Candidates
 */
function setup_team_candidates() {
	global $smarty;
	global $SEASON;	
	global $Link;
	
	$teamsSelect = 'SELECT '.TEAMSOFSEASONS.'.teamID,teamName FROM '.TEAMSOFSEASONS.' JOIN '.TEAMS.' ON '.TEAMSOFSEASONS.'.teamID = '.TEAMS.'.teamID WHERE seasonID='.$SEASON.' AND '.TEAMSOFSEASONS.'.teamID != 7 AND '.TEAMSOFSEASONS.'.teamID != 14 ORDER BY teamName';
	
	$teamsResult = mysql_query($teamsSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
		if ($teamsResult && mysql_num_rows($teamsResult) > 0) {			
		  $smarty->assign('teamCandidateId', array ());
		  $smarty->assign('teamCandidateName', array ());
            
			while ($team = mysql_fetch_array($teamsResult, MYSQL_ASSOC)) {
				$teamId = $team['teamID'];
				$teamName = $team['teamName'];

				$smarty->append('teamCandidateId', $teamId);
				$smarty->append('teamCandidateName', $teamName);         

			}
		}
	
}

/*
 * Get Player Name
 */
 function get_player_name($pId) {
	$pName = "";
	
	global $Link;
	
	$pSelect = 'SELECT playerFName,playerLName FROM '.PLAYER.' WHERE playerID='.$pId;
	
	$pResult = mysql_query($pSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($pResult && mysql_num_rows($pResult) > 0) {
		$p = mysql_fetch_assoc($pResult);
		$pName = $p['playerFName'].' '.$p['playerLName'];
	}
	

	return $pName; 	
 }


function get_skill($skillNum) {	
	global $Link;
	
	$skillSelect = 'SELECT skillLevelName FROM '.SKILLLEVELS.' WHERE skillLevelID='.$skillNum;
	
	$skillResult = mysql_query($skillSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	$skillName = '';
	
	if ($skillResult && mysql_num_rows($skillResult) > 0) {
	  $skill = mysql_fetch_assoc($skillResult);
	  $skillName = $skill['skillLevelName'];
	}
	return $skillName;
}

/*
 * Get current game type - This way if they choose standings, it will get the
 * last games game type.
 * global Vars: $SEASON, $Link
 */
function get_current_game_type() {
	global $SEASON;
	
	global $Link;
	
	$gameType = 'pre';
	$currentTime = time();
	
	$gameTypeSelect = 'SELECT gameType,gameTime from '.GAME.' WHERE seasonId='.$SEASON.' ORDER BY gameTime';
	
	$gameTypeResult = mysql_query($gameTypeSelect, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  		
	if ($gameTypeResult && mysql_num_rows($gameTypeResult) > 0) {             
			while ($game = mysql_fetch_array($gameTypeResult, MYSQL_ASSOC)) {					
				if($currentTime > $game['gameTime']) {
					$gameType = $game['gameType'];
				}
			}
	}
	
	return $gameType;
	
}

/*
 * Inserts a registration ID into the proper payment plan table
 */
function insert_player_into_payment_table($registrationID, $paymentPlan) {
	global $Link;
	global $SEASON;
	
	$insert = 'INSERT INTO ';
	if($paymentPlan == 1) {
		$insert .= PAYMENTPLANONE;
	} else if($paymentPlan == 2) {
		$insert .= PAYMENTPLANTWO;
	} else if($paymentPlan == 3) {
		$insert .= PAYMENTPLANTHREE;
	} else if($paymentPlan == 4) {
		$insert .= PAYMENTPLANFOUR;
	}
	$insert .= ' (`registrationID`) VALUES('.$registrationID.')';
	
	$result = mysql_query($insert, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());	
}

/*
 * Checks that a registration ID is actually in a payment plan table
 */
function idCheck_paymentDB($checkID, $paymentPlan) {
	global $Link;
	
	$select = 'SELECT registrationID FROM ';
	if($paymentPlan == 1) {
		$select .= PAYMENTPLANONE;
	} else if($paymentPlan == 2) {
		$select .= PAYMENTPLANTWO;
	} else if($paymentPlan == 3) {
		$select .= PAYMENTPLANTHREE;
	} else if($paymentPlan == 4) {
		$select .= PAYMENTPLANFOUR;
	} else {
		// No payment plan passed in.  Return false.
		return false;
	}
	
	$select .= ' WHERE registrationID='.$checkID;
	
 	$result = mysql_query($select, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  		
	if ($result && mysql_num_rows($result) > 0) {
	  return true;
	} else {
		return false;
	}
}

/*
 * Get Player Name
 */
 function get_registrant_name($rId) {
	$rName = "";
	
	global $Link;
	
	$select = 'SELECT fName,lName FROM '.REGISTRATION.' WHERE registrationId='.$rId;
	
	$result = mysql_query($select, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
		$r = mysql_fetch_assoc($result);
		$rName = $r['fName'].' '.$r['lName'];
	}
	
	return $rName; 	
 }

/*
 * Pass in Variable name (e.g. "SEASON")
 * Returns the value of a variable in the DB table "VARIABLES"
 */
function get_site_variable_value($variable) {
 	global $Link;
 	
 	$select = 'SELECT value FROM '.VARIABLES.' WHERE variable="'.$variable.'"';
 	
 	$result = mysql_query($select, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  		
	if ($result && mysql_num_rows($result) > 0) {
	  $variable = mysql_fetch_assoc($result);	  
	  return $variable['value'];
	} else {
		return undef;
	}
}

/*
 * Pass site Marquee
 * Returns the site marquee
 */
function get_site_marquee() {
 	global $Link;
 	
 	$select = 'SELECT marquee FROM '.MARQUEE;
 	
 	$result = mysql_query($select, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  		
	if ($result && mysql_num_rows($result) > 0) {
	  $marquee = mysql_fetch_assoc($result);	  
	  return $marquee['marquee'];
	} else {
		return "";
	}
}

/*
 * Get registered users initials
 */
function get_site_user_initials($userid) {
	global $Link;
	
	$select = 'SELECT firstName, lastName FROM '.USER.' WHERE userID='.$userid;
	
	$result = mysql_query($select, $Link)
	  or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	  
	if ($result && mysql_num_rows($result) > 0) {
	  $name = mysql_fetch_assoc($result);
	  $fInt = format_initial($name['firstName']);
	  $lInt = format_initial($name['lastName']);  
	  return $fInt.$lInt;
	} else {
		return 'NA';
	}
}


/*
 * Offset server timestamp for database input.  Because the datbase
 * lives on MST (Mountain Standard Time), we need to offset our timestamps
 * by subtracting two or one hour when we select them from the db.
 */
 function epoch_offset($orig_epoch) {
 	if(ENVIRONMENT == "prod") {
 		return $orig_epoch + get_epoch_seconds_offset();
 	} else {
 		return $orig_epoch;
 	}
 }
 
 /*
 * Return offset from Central Time to MST, eg. CST or CDT
 */
 function get_epoch_seconds_offset() {
  $seconds = 3600;
	
	global $Link;

	$epochCurrentServerTime = time();
	
	$currentServerYear = date('Y', $epochCurrentServerTime);
	$yearDSTSelect = 'SELECT * FROM '.DST.' WHERE year='.$currentServerYear;

	$yearDSTResult = mysql_query($yearDSTSelect, $Link);
	
	if ($yearDSTResult && mysql_num_rows($yearDSTResult) > 0) {
			$dst = mysql_fetch_assoc($yearDSTResult);
			$dstStartDateEpoch = ts_mysql_to_epoch($dst['startDate']);
			$dstEndDateEpoch = ts_mysql_to_epoch($dst['endDate']);
			
			$hoursOffset = 1;
			
			// DST is going on if the following is true.
			if($epochCurrentServerTime >= $dstStartDateEpoch && $epochCurrentServerTime < $dstEndDateEpoch) {
				$hoursOffset = 2;
			}
			
			return $seconds * $hoursOffset;
	}	
		
	
	return $seconds;
 }
 
 /*
  * Convert mysql timestamp to epoch.  Feed it based off this example: 2007-03-11 00:00:00
  * where it goes year-month-day hour:minute:seconds
  */  
  function ts_mysql_to_epoch($ts = "") {
		$year = substr($ts, 0,4);
		$mon = substr($ts,5,2);
		$day = substr($ts,8,2);
		$hour = substr($ts,11,2);
		$min = substr($ts,14,2);
		$sec = substr($ts,17,2);		
		return mktime($hour,$min,$sec,$mon,$day,$year,-1);
  }
  
	// Determines if a valid result was returned from the database.
 	function validResult() {
		if (mysql_affected_rows() > 0) {
			return true;
		} else {
			return false;
		} 		
 	} 
 	
 	/*
 	 * Takes a string and turns it into HEX.  Good way of hiding email addresses from webbots.
 	 */
function strToHex($string)
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= '%'.dechex(ord($string[$i]));
    }
    return $hex;
}

/*
 * Setup other seasons.  This is used to setup seasons with team links at the bottom of the schedule and roster pages.
 */
 
function setup_other_seasons($TYPE) {
 	global $SEASON;
 	global $smarty;
 	global $Link;
	require_once('com/tcshl/season/Season.php');
	require_once('com/tcshl/season/Seasons.php'); 	
 	
 	if(isset($TYPE) && $TYPE != 'ROSTER' || $TYPE != 'SCHEDULE') {
 		$TYPE = 'SCHEDULE';	
 	}
 	
 	if($TYPE == 'ROSTER') {
 		$query = 'SELECT DISTINCT seasonID FROM '.TEAMSOFSEASONS.' WHERE seasonID != '.$SEASON;
 	} else {
 		$query = 'SELECT DISTINCT seasonId FROM '.GAME.' WHERE seasonId != '.$SEASON;
 	}

	$result = mysql_query($query, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
		if ($result && mysql_num_rows($result) > 0) {			
		  $seasonArray = array();
            
			while ($season = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if($TYPE == 'ROSTER') {
					$seasonArray[]= $season['seasonID'];
				} else {
					$seasonArray[]= $season['seasonId'];
				}
			}
		}
	
	// Build list of other seasons
	$Seasons = new Seasons();
	$SeasonsArray = $Seasons->get_SeasonArray($seasonArray,'DESC');
	
	require_once('com/tcshl/team/Team.php');
	
	if(count($SeasonsArray) > 0) {
		$smarty->assign('otherSeasonID', array ());
		$smarty->assign('otherSeasonName', array ());
		$smarty->assign('otherSeasonTeamsID', array ());
		$smarty->assign('otherSeasonTeamsName', array());
		foreach($SeasonsArray as $Season) {
			$smarty->append('otherSeasonID', $Season->get_seasonID());
			$smarty->append('otherSeasonName', $Season->get_seasonName());
			$otherSeasonTeamsID_Array = array();
			$otherSeasonTeamsName_Array = array();	
			foreach($Season->get_teams() as $TeamID) {
				$CurrentTeam = new Team($TeamID);
				$otherSeasonTeamsID_Array[] = $CurrentTeam->get_teamID();
				$otherSeasonTeamsName_Array[] = $CurrentTeam->get_teamName();
			}
			$smarty->append('otherSeasonTeamsID',$otherSeasonTeamsID_Array);
			$smarty->append('otherSeasonTeamsName', $otherSeasonTeamsName_Array);
		}	
	 }
}
?>