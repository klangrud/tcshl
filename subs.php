<?php
/*
 * Created on Sep 10, 2007
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
$selectedGameId = 0;
$skillLevel = 0;
$day = 0;
$position = '';
$dayColumn = '';
if ((isset($_POST['action'])) && ($_POST['action'] == "Search Subs")) {
    if ($_POST && $_POST['game'] && $_POST['game'] > 0) {
        $selectedGameId = $_POST['game'];
        $smarty->assign('selectGameID', $selectedGameId);
        $smarty->assign('selectGameInfo', getSelectedGameInfo($selectedGameId));
    }
    if ($_POST && $_POST['skill'] && $_POST['skill'] > 0 && $_POST['skill'] < 6) {
        $skillLevel = $_POST['skill'];
        $skillLevelName = get_skill($skillLevel);
        $smarty->assign('skillLevel', $skillLevel);
        $smarty->assign('skillLevelName', $skillLevelName);
    }
    if ($_POST && $_POST['day'] && $_POST['day'] > 0 && $_POST['day'] < 8) {
        $day = $_POST['day'];
        $dayOfWeek = get_day_of_week($day);
        $dayColumn = get_day_column($day);
        $smarty->assign('day', $day);
        $smarty->assign('dayOfWeek', $dayOfWeek);
    }
    /*
    if($_POST && $_POST['pos'] && $_POST['pos'] == 'G' || $_POST['pos'] == 'D' || $_POST['pos'] == 'C' || $_POST['pos'] == 'W' || $_POST['pos'] == 'AF') {
     $position = $_POST['pos'];
     if($position == 'AF') {
       $smarty->assign('positions', 'All Forwards');
     } else if($position == 'W'){
       $smarty->assign('positions', 'Wing');
     } else if($position == 'C'){
       $smarty->assign('positions', 'Center');
     } else if($position == 'D'){
       $smarty->assign('positions', 'Defense');
     } else {
       $smarty->assign('positions', 'Goalie');	
     }
    }
    */
    if ($_POST && $_POST['pos'] && $_POST['pos'] == 'Goalie' || $_POST['pos'] == 'Defense' || $_POST['pos'] == 'Forward') {
        $position = $_POST['pos'];
        if ($position == 'Forward') {
            $smarty->assign('positions', 'Forward');
        } else if ($position == 'Defense') {
            $smarty->assign('positions', 'Defense');
        } else {
            $smarty->assign('positions', 'Goalie');
        }
    }
}
setup_game_select();
setup_subs();
$smarty->assign('page_name', 'Sub Search');
// Build the page
require ('global_begin.php');
$smarty->display('user/subs.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_subs() {
    global $smarty;
    global $SEASON;
    global $selectedGameId;
    global $skillLevel;
    global $day;
    global $dayColumn;
    global $position;
    global $Link;
    // Sub Select for Player without a team
    $noTeamPlayerSubSelect = 'SELECT DISTINCT playerID FROM ' . ROSTERSOFTEAMSOFSEASONS . ' WHERE seasonID=' . $SEASON;
    $subSelectColumns = 'fName,lName,eMail,position,homePhone,workPhone,cellPhone,playerId';
    // Sub Select base query
    $subSelect = 'SELECT ' . $subSelectColumns . ' FROM ' . REGISTRATION . ' WHERE wantToSub=1 AND seasonId=' . $SEASON . ' AND registrationApproved=1 AND drilLeague!=2 AND playerId IN (' . $noTeamPlayerSubSelect . ')';
    //Sub Select filter game
    if ($selectedGameId > 0) {
        $playersAlreadyPlayingArray = players_already_playing();
        $playersAlreadyPlayingString = '';
        foreach ($playersAlreadyPlayingArray as $player) {
            $playersAlreadyPlayingString.= $player . ',';
        }
        $subSelect.= ' AND playerId NOT IN (' . $playersAlreadyPlayingString . '0)';
    }
    // Sub Select filter skill level
    if ($skillLevel != 0) {
        $subSelect.= ' AND skillLevel=' . $skillLevel;
    }
    // Sub Select filter day of week
    if ($day != 0) {
        $subSelect.= ' AND ' . $dayColumn . '=1';
    }
    // Sub Select filter position
    if ($position != '') {
        if ($position == 'AF') {
            $subSelect.= ' AND (position LIKE \'%C%\' OR position LIKE \'%W%\')';
        } else {
            $subSelect.= ' AND position LIKE \'%' . $position . '%\'';
        }
    }
    // Sub Select ORDER BY
    $subSelect.= ' ORDER BY lName';
    $subResult = mysql_query($subSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($subResult && mysql_num_rows($subResult) > 0) {
        $loopID = 0;
        $smarty->assign('loopID', array());
        $smarty->assign('name', array());
        $smarty->assign('eMail', array());
        $smarty->assign('pos', array());
        $smarty->assign('homePhone', array());
        $smarty->assign('workPhone', array());
        $smarty->assign('cellPhone', array());
        $smarty->assign('games_subbed', array());
        while ($sub = mysql_fetch_array($subResult, MYSQL_ASSOC)) {
            $loopID++;
            $subName = $sub['fName'] . ' ' . $sub['lName'];
            if (isset($sub['eMail']) && strlen($sub['eMail']) > 0) {
                $subEmail = $sub['eMail'];
            } else {
                $subEmail = '&nbsp;';
            }
            $subPosition = $sub['position'];
            if (isset($sub['homePhone']) && strlen($sub['homePhone']) > 0) {
                $subHomePhone = $sub['homePhone'];
            } else {
                $subHomePhone = '&nbsp;';
            }
            if (isset($sub['workPhone']) && strlen($sub['workPhone']) > 0) {
                $subWorkPhone = $sub['workPhone'];
            } else {
                $subWorkPhone = '&nbsp;';
            }
            if (isset($sub['cellPhone']) && strlen($sub['cellPhone']) > 0) {
                $subCellPhone = $sub['cellPhone'];
            } else {
                $subCellPhone = '&nbsp;';
            }
            $gamesSubbed = get_subbed_count($sub['playerId']);
            $smarty->append('loopID', $loopID);
            $smarty->append('name', $subName);
            $smarty->append('eMail', $subEmail);
            $smarty->append('pos', $subPosition);
            $smarty->append('homePhone', $subHomePhone);
            $smarty->append('workPhone', $subWorkPhone);
            $smarty->append('cellPhone', $subCellPhone);
            $smarty->append('games_subbed', $gamesSubbed);
        }
    }
}
function get_day_of_week($dayNum) {
    if ($dayNum == 1) {
        return 'Sunday';
    } else if ($dayNum == 2) {
        return 'Monday';
    } else if ($dayNum == 3) {
        return 'Tuesday';
    } else if ($dayNum == 4) {
        return 'Wednesday';
    } else if ($dayNum == 5) {
        return 'Thursday';
    } else if ($dayNum == 6) {
        return 'Friday';
    } else {
        return 'Saturday';
    }
}
function get_day_column($dayNum) {
    if ($dayNum == 1) {
        return 'subSunday';
    } else if ($dayNum == 2) {
        return 'subMonday';
    } else if ($dayNum == 3) {
        return 'subTuesday';
    } else if ($dayNum == 4) {
        return 'subWednesday';
    } else if ($dayNum == 5) {
        return 'subThursday';
    } else if ($dayNum == 6) {
        return 'subFriday';
    } else {
        return 'subSaturday';
    }
}
function get_subbed_count($playerID) {
    global $smarty;
    global $Link;
    global $SEASON;
    $subQuery = 'SELECT teamID FROM ' . ROSTERSOFTEAMSOFSEASONS . ' WHERE playerID=' . $playerID;
    $subQuery2 = 'SELECT gameID FROM ' . GAME . ' WHERE seasonId=' . $SEASON;
    $countSubbedGamesQuery = 'SELECT count(distinct gameID) AS games_subbed FROM ' . PLAYERSTAT . ' WHERE playerID=' . $playerID . ' AND teamID NOT IN (' . $subQuery . ') AND gameID IN (' . $subQuery2 . ')';
    $countSubbedGamesResult = mysql_query($countSubbedGamesQuery, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    $skillName = '';
    $count = 0;
    if ($countSubbedGamesResult && mysql_num_rows($countSubbedGamesResult) > 0) {
        $countResult = mysql_fetch_assoc($countSubbedGamesResult);
        $count = $countResult['games_subbed'];
    }
    return $count;
}
// This returns an array of playerId belong to players who are already playing if filter by game is selected.
function players_already_playing() {
    global $smarty;
    global $Link;
    global $SEASON;
    global $selectedGameId;
    // GET TEAMS IN SELECTED GAME
    $query = 'SELECT gameGuestTeam, gameHomeTeam FROM ' . GAME . ' WHERE gameID=' . $selectedGameId;
    $result = mysql_query($query, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $teams = mysql_fetch_assoc($result);
        $guestTeam = $teams['gameGuestTeam'];
        $homeTeam = $teams['gameHomeTeam'];
    } else {
        $guestTeam = 0;
        $homeTeam = 0;
    }
    // GET ROSTERS OF TEAMS IN SELECTED GAME
    $query = 'SELECT playerID from ' . ROSTERSOFTEAMSOFSEASONS . ' WHERE teamID=' . $guestTeam . ' OR teamID=' . $homeTeam;
    $result = mysql_query($query, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    $rosterArray = null;
    if ($result && mysql_num_rows($result) > 0) {
        $rosterArray = array();
        while ($roster = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $rosterArray[] = $roster['playerID'];
        }
    }
    return $rosterArray;
}
function setup_game_select() {
    global $smarty;
    global $Link;
    global $SEASON;
    $now = time();
    $columns = 'gameID, gameTime, gameGuestTeam, gameHomeTeam';
    $where = ' seasonId=' . $SEASON . ' AND gameTime > ' . $now . ' AND gameGuestTeam != 7 AND gameHomeTeam != 7 AND gameGuestTeam != 14 AND gameHomeTeam != 14';
    $query = 'SELECT ' . $columns . ' FROM ' . GAME . ' WHERE ' . $where . ' ORDER BY gameTime';
    $result = mysql_query($query, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $smarty->assign('gameId', array());
        $smarty->assign('gameDate', array());
        $smarty->assign('gameGuestTeam', array());
        $smarty->assign('gameHomeTeam', array());
        while ($game = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $smarty->append('gameId', $game['gameID']);
            $smarty->append('gameDate', date('D, M j @ g:i a', $game['gameTime']));
            $smarty->append('gameGuestTeam', get_team_name($game['gameGuestTeam']));
            $smarty->append('gameHomeTeam', get_team_name($game['gameHomeTeam']));
        }
    }
}
function getSelectedGameInfo($selectedGameId) {
    global $Link;
    $columns = 'gameID, gameTime, gameGuestTeam, gameHomeTeam';
    $query = 'SELECT ' . $columns . ' FROM ' . GAME . ' WHERE gameId=' . $selectedGameId;
    $result = mysql_query($query, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $game = mysql_fetch_array($result, MYSQL_ASSOC);
        return date('D, M j @ g:i a', $game['gameTime']) . ' - ' . get_team_name($game['gameGuestTeam']) . ' VS ' . get_team_name($game['gameHomeTeam']);
    }
    return null;
}
?>
