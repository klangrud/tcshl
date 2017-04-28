<?php
/*
 * Created on Sep 16, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
*/
class Season {
    private $seasonID;
    function __construct($seasonID) {
        $this->seasonID = (int)$seasonID;
    }
    public function get_humanReadableSeason() {
        $query = 'SELECT seasonName FROM ' . SEASONS . ' WHERE seasonId=' . $this->seasonID;
        $result = mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if ($result && mysql_num_rows($result) > 0) {
            $season = mysql_fetch_assoc($result);
            return $season['seasonName'];
        } else {
            return 'Season Unknown';
        }
    }
}
?>
