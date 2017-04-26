<?php
/*
 * Created on Sep 13, 2007
 *
 * This file is not meant to be hit on its own.  It is to be an include only.
*/
setup_draft_info();
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_draft_info() {
    global $smarty;
    global $SEASON;
    global $currentRound;
    global $seasonalTeamsCount;
    global $Link;
    //Select teams
    $teamNameSelect = 'SELECT teamId, teamName FROM ' . TEAMS . ' WHERE teamID IN (SELECT teamID FROM ' . TEAMSOFSEASONS . ' WHERE seasonID=' . $SEASON . ' AND teamID != 7 AND teamID != 14) ORDER BY teamID';
    $teamNameResult = mysql_query($teamNameSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($teamNameResult && mysql_num_rows($teamNameResult) > 0) {
        $teamIdArray = array();
        $smarty->assign('teamId', array());
        $smarty->assign('teamName', array());
        $column = 0;
        $columnNum = array();
        $columnNum[$column] = 0;
        while ($team = mysql_fetch_array($teamNameResult, MYSQL_ASSOC)) {
            $column++;
            $columnNum[$column] = $team['teamId'];
            $teamId = $team['teamId'];
            $teamName = $team['teamName'];
            $smarty->append('teamId', $teamId);
            $smarty->append('teamName', $teamName);
        }
    }
    //Select rounds
    $roundSelect = 'SELECT round FROM ' . DRAFT . ' GROUP BY round';
    $roundResult = mysql_query($roundSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    $rounds = 0;
    if ($roundResult && mysql_num_rows($roundResult) > 0) {
        $smarty->assign('round', array());
        while ($round = mysql_fetch_array($roundResult, MYSQL_ASSOC)) {
            $rounds = $round['round'];
        }
    }
    $smarty->assign('rounds', $rounds);
    //Select players and create table
    $draftDataRows = '';
    for ($rowNum = 1;$rowNum <= $rounds;$rowNum++) {
        $select = 'SELECT playerFName,playerLName,' . DRAFT . '.playerId,teamId,skillLevelChar FROM ' . DRAFT;
        $select.= ' JOIN ' . PLAYER . ' ON ' . DRAFT . '.playerId = ' . PLAYER . '.playerId';
        $select.= ' JOIN ' . SKILLLEVELS . ' ON ' . PLAYER . '.playerSkillLevel = ' . SKILLLEVELS . '.skillLevelID';
        $select.= ' AND round=' . $rowNum;
        $select.= ' AND ' . DRAFT . '.seasonId=' . $SEASON;
        $select.= ' ORDER BY teamId';
        $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if ($result && mysql_num_rows($result) > 0) {
            $column = 0;
            $row = '<tr><td><b>' . $rowNum . '</b></td>';
            while ($player = mysql_fetch_array($result, MYSQL_ASSOC)) {
                $column++;
                while ($columnNum[$column] != $player['teamId']) {
                    $column++;
                    if ((PAGE_TYPE == 'ADMIN') && ($rowNum < $currentRound)) {
                        $row.= '<td>';
                        $row.= '<form method="post" action="draftmode.php">';
                        $row.= '<input type="hidden" name="currentRound" value="' . $rowNum . '" />';
                        $row.= '<input type="hidden" name="team" value="' . $columnNum[$column - 1] . '" />';
                        $row.= getRedraftPlayerForm();
                        $row.= '<input name="action" type="submit" value="Draft Player" />';
                        $row.= '</form>';
                        $row.= '</td>';
                    } else {
                        $row.= '<td>&nbsp;</td>';
                    }
                }
                $row.= '<td>';
                if (PAGE_TYPE == 'ADMIN') {
                    $row.= '<a href="draftmode.php?deletepick=true&seasonId=' . $SEASON . '&playerId=' . $player['playerId'] . '&round=' . $rowNum . '&teamId=' . $player['teamId'] . '"><img class="imglink" src="images/delete.gif" title="Delete this pick" alt="Delete this pick" onclick=\'return showAlert("that you want to delete this draft pick?")\' /></a>';
                }
                $row.= $player['playerFName'] . ' ' . $player['playerLName'] . ' (' . format_initial($player['skillLevelChar']) . ')</td>';
            }
            //This will fill in the remaining table data cells at the end.
            while ($column != (count($columnNum) - 1)) {
                $column++;
                if ((PAGE_TYPE == 'ADMIN') && ($rowNum < $currentRound)) {
                    $row.= '<td>';
                    $row.= '<form method="post" action="draftmode.php">';
                    $row.= '<input type="hidden" name="currentRound" value="' . $rowNum . '" />';
                    $row.= '<input type="hidden" name="team" value="' . $columnNum[$column] . '" />';
                    $row.= getRedraftPlayerForm();
                    $row.= '<input name="action" type="submit" value="Draft Player" />';
                    $row.= '</form>';
                    $row.= '</td>';
                } else {
                    $row.= '<td>&nbsp;</td>';
                }
            }
        } else {
            $row = '<tr>';
        }
        $row.= '</tr>';
        $draftDataRows.= $row;
    } //for
    $smarty->assign('draftDataRows', $draftDataRows);
}
function getRedraftPlayerForm() {
    global $SEASON;
    global $Link;
    $selectRedraftMenu = '<select name="player">';
    $playersSelect = 'SELECT playerID,playerFName,playerLName FROM ' . PLAYER . ' WHERE seasonID=' . $SEASON . ' ORDER BY playerLName';
    $playersResult = mysql_query($playersSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($playersResult && mysql_num_rows($playersResult) > 0) {
        while ($player = mysql_fetch_array($playersResult, MYSQL_ASSOC)) {
            $selectRedraftMenu.= '<option value="' . $player['playerID'] . '">' . $player['playerFName'] . ' ' . $player['playerLName'] . '</option>';
        }
    }
    $selectRedraftMenu.= '</select>';
    return $selectRedraftMenu;
}
?>