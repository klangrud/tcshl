<?php
/*
 * Created on Sep 16, 2009
 *
 * This is the Players object.  It returns an array of Player objects.  It accepts an array of
 * playerIDs as arguments.  If none are given then it will return all Players.
 */
 
 class Players {
 	private $PlayerArray;
 	
 	function __construct() {
 		$PlayerArray = array();
 	}

    // PlayerIDs is an array of playerIDs to return Player Objects for.  Use 0 to return all.
	public function get_PlayerArray($PlayerIDs) {
		require_once("Player.php");
		$query = 'SELECT playerID FROM '.PLAYER;
		if($PlayerIDs != 0) {
			$query .= ' WHERE playerID IN '.$PlayerIDs;
		}
		$query .= ' ORDER BY playerLName';
		
		$result = mysql_query($query)
  			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error()); 		
		
		$Player = null;
		if ($result && mysql_num_rows($result) > 0) {	
			while ($player = mysql_fetch_array($result, MYSQL_ASSOC)) {	
				$Player = new Player($player['playerID']);
				$this->PlayerArray[] = (object) $Player;
			}
		}
		
		return $this->PlayerArray;
	}
 }
?>
