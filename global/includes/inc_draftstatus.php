<?php
/*
 * Created on Sep 12, 2007
 *
 * This file is not meant to be hit on its own.  It is to be an include only.
*/
$seasonalTeamsCount = get_seasonal_teams_count();
$currentRoundDrafts = 0;
$currentRound = get_current_draft_round();
$pageName = get_season_name($SEASON) . ' Season Draft';
$smarty->assign('page_name', $pageName);
$smarty->assign('numTeams', $seasonalTeamsCount);
$smarty->assign('currentRound', $currentRound);
$smarty->assign('currentRoundPicks', $currentRoundDrafts);
$smarty->assign('currentDate', date('l, F j, Y  g:i:s a'));
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function get_seasonal_teams_count() {
    global $smarty;
    global $SEASON;
    $teamsCount = 0;
    $Link = '';
    global $Link;
    $teamCountSelect = 'SELECT COUNT(*) AS count FROM ' . TEAMSOFSEASONS . ' WHERE seasonID=' . $SEASON . ' AND teamID != 7 AND teamID != 14';
    $teamCountResult = mysql_query($teamCountSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($teamCountResult && mysql_num_rows($teamCountResult) > 0) {
        $count = mysql_fetch_assoc($teamCountResult);
        $teamsCount = $count['count'];
    }
    $smarty->assign('seasonTeamCount', $teamsCount);
    return $teamsCount;
}
function get_current_draft_round() {
    global $smarty;
    global $SEASON;
    global $seasonalTeamsCount;
    $maxRound = 1;
    global $currentRoundDrafts;
    $currentRoundDrafts = 0;
    $Link = '';
    global $Link;
    $maxRoundSelect = 'SELECT MAX(round) AS maxround FROM ' . DRAFT . ' WHERE seasonId=' . $SEASON;
    $maxRoundResult = mysql_query($maxRoundSelect, $Link);
    if ($maxRoundResult && mysql_num_rows($maxRoundResult) > 0) {
        $round = mysql_fetch_assoc($maxRoundResult);
        $maxRound = $round['maxround'];
        if (!$maxRound > 0) {
            $maxRound = 1;
        }
    }
    // Determine how many teams have made a draft pick this round.
    $roundDraftsSelect = 'SELECT COUNT(*) AS roundDrafts FROM ' . DRAFT . ' WHERE seasonId=' . $SEASON . ' AND round=' . $maxRound . ' AND teamID != 7 AND teamID != 14';
    $roundDraftsResult = mysql_query($roundDraftsSelect, $Link);
    if ($roundDraftsResult && mysql_num_rows($roundDraftsResult) > 0) {
        $drafts = mysql_fetch_assoc($roundDraftsResult);
        $currentRoundDrafts = $drafts['roundDrafts'];
    }
    if ($seasonalTeamsCount == $currentRoundDrafts) {
        $currentRoundDrafts = 0;
        return $maxRound + 1;
    } else {
        return $maxRound;
    }
}
?>
