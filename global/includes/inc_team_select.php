<?php
$subQuery = 'SELECT teamID FROM ' . TEAMSOFSEASONS . ' WHERE seasonID=' . get_site_variable_value("SEASON") . ' AND teamID != 7 AND teamID != 14';
$select = 'SELECT teamID,teamName FROM ' . TEAMS . ' WHERE teamID IN (' . $subQuery . ')';
$result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
if ($result && mysql_num_rows($result) > 0) {
    $smarty->assign('menuSelectSeasonHasTeams', true);
    $smarty->assign('teamMenuSelectID', array());
    $smarty->assign('teamMenuSelectName', array());
    while ($team = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $teamId = $team['teamID'];
        $teamName = $team['teamName'];
        $smarty->append('teamMenuSelectID', $teamId);
        $smarty->append('teamMenuSelectName', $teamName);
    }
} else {
    $smarty->assign('menuSelectSeasonHasTeams', false);
}
?>