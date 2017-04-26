<?php
/*
 * Created on Sep 16, 2009
 *
 * This is the Game object.
*/
class Game {
    private $seasonID;
    private $gameID;
    private $gameType;
    private $gameTime;
    private $gameGuestTeam;
    private $gameGuestScore;
    private $gameHomeTeam;
    private $gameHomeScore;
    private $gameReferee1;
    private $gameReferee2;
    private $gameReferee3;
    private $postponed;
    private $announcementID;
    // Misc Attributes
    private $formErrors;
    private $formSuccess;
    function __construct($gameID) {
        $this->gameID = $gameID;
        if ($this->gameID != 0) {
            $this->load_game();
        }
    }
    function load_game() {
        $query = 'SELECT * FROM ' . GAME . ' WHERE gameID=' . $this->gameID;
        $result = mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if ($result && mysql_num_rows($result) > 0) {
            $game = mysql_fetch_array($result, MYSQL_ASSOC);
            $this->seasonID = $game['seasonId'];
            $this->gameID = $game['gameID'];
            $this->gameType = $game['gameType'];
            $this->gameTime = $game['gameTime'];
            $this->gameGuestTeam = $game['gameGuestTeam'];
            $this->gameGuestScore = $game['gameGuestScore'];
            $this->gameHomeTeam = $game['gameHomeTeam'];
            $this->gameHomeScore = $game['gameHomeScore'];
            $this->gameReferee1 = $game['gameReferee1'];
            $this->gameReferee2 = $game['gameReferee2'];
            $this->gameReferee3 = $game['gameReferee3'];
            $this->postponed = $game['postponed'];
            $this->announcementID = $game['announcementID'];
        }
    }
    function update_game() {
        $query = 'UPDATE ' . GAME;
        $query.= ' SET ';
        $query.= ' seasonId = "' . $this->get_seasonID() . '",';
        $query.= ' gameType = "' . $this->get_gameType() . '",';
        $query.= ' gameTime = "' . $this->get_gameTime() . '",';
        $query.= ' gameGuestTeam = "' . $this->get_gameGuestTeam() . '"';
        $query.= ' gameGuestScore = "' . $this->get_gameGuestScore() . '",';
        $query.= ' gameHomeTeam = "' . $this->get_gameHomeTeam() . '",';
        $query.= ' gameHomeScore = "' . $this->get_gameHomeScore() . '",';
        $query.= ' gameReferee1 = "' . $this->get_gameReferee1() . '",';
        $query.= ' gameReferee2 = "' . $this->get_gameReferee2() . '",';
        $query.= ' gameReferee3 = "' . $this->get_gameReferee3() . '"';
        $query.= ' postponed = "' . $this->get_postponed() . '",';
        $query.= ' announcementID = "' . $this->get_announcementID() . '"';
        $query.= ' WHERE gameID=' . $this->get_gameID();
        mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if (validResult()) {
            $this->formSuccess[] = 'Game updated successfully!';
        } else {
            $this->formErrors[] = 'Game NOT updated!  Try again or notify TCSHL.com administrator.';
        }
    }
    function insert_game() {
        $columns = '`seasonId`,`gameType`,`gameTime`,`gameGuestTeam`,`gameHomeTeam`,`gameReferee1`,`gameReferee2`,`gameReferee3`,`postponed`';
        $query = 'INSERT INTO ' . PLAYER . ' (' . $columns . ') ';
        $query.= 'VALUES("' . $this->get_seasonID() . '",';
        $query.= '"' . $this->get_gameType() . '",';
        $query.= '' . $this->get_gameTime() . ',';
        $query.= '' . $this->get_gameGuestTeam() . ',';
        $query.= '' . $this->get_gameHomeTeam() . ',';
        $query.= '' . $this->get_gameReferee1() . ',';
        $query.= '' . $this->get_gameReferee2() . ',';
        $query.= '' . $this->get_gameReferee3() . ',';
        $query.= '' . $this->get_postponed();
        $query.= ')';
        mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if (validResult()) {
            $this->formSuccess[] = 'Game created successfully!';
        } else {
            $this->formErrors[] = 'Game NOT created!  Try again or notify TCSHL.com administrator.';
        }
    }
    function delete_game() {
        $query = 'DELETE FROM ' . GAME . ' WHERE gameID=' . $this->get_gameID();
        mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if (validResult()) {
            $this->formSuccess[] = 'Game deleted successfully!';
        } else {
            $this->formErrors[] = 'Game NOT deleted!  Try again or notify TCSHL.com administrator.';
        }
    }
    // Get Human Readable Team Names
    public function get_gameGuestTeamHumanReadable() {
        return $this->get_gameTeamHumanReadable($this->get_gameGuestTeam());
    }
    public function get_gameHomeTeamHumanReadable() {
        return $this->get_gameTeamHumanReadable($this->get_gameHomeTeam());
    }
    private function get_gameTeamHumanReadable($teamid) {
        $query = 'SELECT teamName FROM ' . TEAMS . ' WHERE teamID = ' . $teamid;
        $result = mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if ($result && mysql_num_rows($result) > 0) {
            $team = mysql_fetch_array($result, MYSQL_ASSOC);
            return $team['teamName'];
        } else {
            return 'Unknown';
        }
    }
    // Get Human Readable Team Short Names
    public function get_gameGuestTeamShortHumanReadable() {
        return $this->get_gameTeamShortHumanReadable($this->get_gameGuestTeam());
    }
    public function get_gameHomeTeamShortHumanReadable() {
        return $this->get_gameTeamShortHumanReadable($this->get_gameHomeTeam());
    }
    private function get_gameTeamShortHumanReadable($teamid) {
        $query = 'SELECT teamShortName FROM ' . TEAMS . ' WHERE teamID = ' . $teamid;
        $result = mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if ($result && mysql_num_rows($result) > 0) {
            $team = mysql_fetch_array($result, MYSQL_ASSOC);
            return $team['teamShortName'];
        } else {
            return 'Unknown';
        }
    }
    // Get Human Readable Ref Names
    public function get_gameReferee1HumanReadable() {
        return $this->get_gameRefereeHumanReadable($this->get_gameReferee1());
    }
    public function get_gameReferee2HumanReadable() {
        return $this->get_gameRefereeHumanReadable($this->get_gameReferee2());
    }
    public function get_gameReferee3HumanReadable() {
        return $this->get_gameRefereeHumanReadable($this->get_gameReferee3());
    }
    private function get_gameRefereeHumanReadable($refid) {
        $query = 'SELECT playerFName, playerLName FROM ' . PLAYER . ' WHERE playerID = ' . $refid;
        $result = mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if ($result && mysql_num_rows($result) > 0) {
            $ref = mysql_fetch_array($result, MYSQL_ASSOC);
            return $ref['playerFName'] . ' ' . $ref['playerLName'];
        } else {
            return 0;
        }
    }
    // Get set seasonID
    public function set_seasonID($seasonID) {
        $this->seasonID = $seasonID;
    }
    public function get_seasonID() {
        return $this->seasonID;
    }
    // Get set gameID
    public function set_gameID($gameID) {
        $this->gameID = $gameID;
    }
    public function get_gameID() {
        return $this->gameID;
    }
    // Get set gameType
    public function set_gameType($gameType) {
        $this->gameType = $gameType;
    }
    public function get_gameType() {
        return $this->gameType;
    }
    // Get set gameTime
    public function set_gameTime($gameTime) {
        $this->gameTime = $gameTime;
    }
    public function get_gameTime() {
        return $this->gameTime;
    }
    // Get set gameGuestTeam
    public function set_gameGuestTeam($gameGuestTeam) {
        $this->gameGuestTeam = $gameGuestTeam;
    }
    public function get_gameGuestTeam() {
        return $this->gameGuestTeam;
    }
    // Get set gameGuestScore
    public function set_gameGuestScore($gameGuestScore) {
        $this->gameGuestScore = $gameGuestScore;
    }
    public function get_gameGuestScore() {
        return $this->gameGuestScore;
    }
    // Get set gameHomeTeam
    public function set_gameHomeTeam($gameHomeTeam) {
        $this->gameHomeTeam = $gameHomeTeam;
    }
    public function get_gameHomeTeam() {
        return $this->gameHomeTeam;
    }
    // Get set gameHomeScore
    public function set_gameHomeScore($gameHomeScore) {
        $this->gameHomeScore = $gameHomeScore;
    }
    public function get_gameHomeScore() {
        return $this->gameHomeScore;
    }
    // Get set gameReferee1
    public function set_gameReferee1($gameReferee1) {
        $this->gameReferee1 = $gameReferee1;
    }
    public function get_gameReferee1() {
        return $this->gameReferee1;
    }
    // Get set gameReferee2
    public function set_gameReferee2($gameReferee2) {
        $this->gameReferee2 = $gameReferee2;
    }
    public function get_gameReferee2() {
        return $this->gameReferee2;
    }
    // Get set gameReferee3
    public function set_gameReferee3($gameReferee3) {
        $this->gameReferee3 = $gameReferee3;
    }
    public function get_gameReferee3() {
        return $this->gameReferee3;
    }
    // Get set postponed
    public function set_postponed($postponed) {
        $this->postponed = $postponed;
    }
    public function get_postponed() {
        return $this->postponed;
    }
    // Get set announcementID
    public function set_announcementID($announcementID) {
        $this->announcementID = $announcementID;
    }
    public function get_announcementID() {
        return $this->announcementID;
    }
    // Get $formErrors
    public function get_formErrors() {
        return (array)$this->formErrors;
    }
    // Get $formSuccess
    public function get_formSuccess() {
        return (array)$this->formSuccess;
    }
}
?>



