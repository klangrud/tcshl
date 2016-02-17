<?php
/*
 * Created on Sep 21, 2009
 *
 * This is the Teams object.  It returns an array of Team objects.  It accepts an array of
 * teamIDs as arguments.  If none are given then it will return all Teams.
 */
 
 class Teams {
 	private $TeamsArray;
 	function __construct() {
 		$TeamsArray = array();
 	}

    // TeamIDs is an array of TeamIDs to return Team Objects for.  Use 0 to return all.
	public function get_TeamArray($TeamIDs) {
		require_once("com/tcshl/team/Team.php");
		$query = 'SELECT teamID FROM '.TEAMS;
		if($TeamIDs != 0) {
			$query .= ' WHERE teamID IN '.$TeamIDs;
		}
		$query .= ' ORDER BY teamName';
		
		$result = mysql_query($query)
  			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error()); 		
		
		$Team = null;
		if ($result && mysql_num_rows($result) > 0) {	
			while ($team = mysql_fetch_array($result, MYSQL_ASSOC)) {	
				$Team = new Team($team['teamID']);
				$this->TeamArray[] = (object) $Team;
			}
		} else {
			$this->TeamArray = array();
		}
		
		return $this->TeamArray;
	}
 }
?>
