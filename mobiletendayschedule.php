<?php
/*
 * Created on Oct 23, 2009
 *
 * Mobile Version of the Ten Day Schedule
*/
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');
require ('engine/common_mobile.php');
$smarty->assign('page_name', 'Upcoming Games');
load_ten_day_schedule();
require ('global_mobile_header.php');
$smarty->display('public/mobile/tendayschedule.tpl');
require ('global_mobile_footer.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function load_ten_day_schedule() {
    require_once ('com/tcshl/game/Schedule.php');
    require_once ('com/tcshl/game/Game.php');
    require_once ('com/tcshl/util/DateFormat.php');
    global $SEASON;
    global $smarty;
    // Build schedule
    $Schedule = new Schedule();
    $Schedule->loadUpcomingGames($SEASON, 0, 10);
    $GameArray = $Schedule->get_GameArray();
    $MobileDateFormat = new DateFormat();
    $MobileTimeFormat = new DateFormat();
    $smarty->assign('current_gamedate', -1);
    if (count($GameArray) > 0) {
        $smarty->assign('gameID', array());
        $smarty->assign('gameType', array());
        $smarty->assign('gameDate', array());
        $smarty->assign('gameTime', array());
        $smarty->assign('gameGuestTeam', array());
        $smarty->assign('gameGuestScore', array());
        $smarty->assign('gameHomeTeam', array());
        $smarty->assign('gameHomeScore', array());
        $smarty->assign('gameReferee1', array());
        $smarty->assign('gameReferee2', array());
        $smarty->assign('gameReferee3', array());
        $smarty->assign('postponed', array());
        $smarty->assign('announcementID', array());
        foreach ($GameArray as $Game) {
            $smarty->append('gameID', $Game->get_gameID());
            $smarty->append('gameType', $Game->get_gameType());
            $smarty->append('gameDate', $MobileDateFormat->formatTimestamp($Game->get_gameTime(), 'MOBILE_DATE_FORMAT'));
            $smarty->append('gameTime', $MobileTimeFormat->formatTimestamp($Game->get_gameTime(), 'MOBILE_TIME_FORMAT'));
            $smarty->append('gameGuestTeam', $Game->get_gameGuestTeamHumanReadable());
            $smarty->append('gameGuestScore', $Game->get_gameGuestScore());
            $smarty->append('gameHomeTeam', $Game->get_gameHomeTeamHumanReadable());
            $smarty->append('gameHomeScore', $Game->get_gameHomeScore());
            $smarty->append('gameReferee1', $Game->get_gameReferee1HumanReadable());
            $smarty->append('gameReferee2', $Game->get_gameReferee2HumanReadable());
            $smarty->append('gameReferee3', $Game->get_gameReferee3HumanReadable());
            $smarty->append('postponed', $Game->get_postponed());
            $smarty->append('announcementID', $Game->get_announcementID());
        }
    }
}
?>
