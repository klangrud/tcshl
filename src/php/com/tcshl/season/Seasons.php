<?php
/*
 * Created on Oct 22, 2009
 *
 * This is the Seasons object.  It returns an array of Season objects.  It accepts an array of
 * seasonIDs as arguments.  If none are given then it will return all Seasons.
 */
 
 class Seasons {
 	private $SeasonsArray;
 	function __construct() {
 		$SeasonsArray = array();
 	}

    // SeasonIDs is an array of SeasonIDs to return Season Objects for.  Use 0 to return all.
	public function get_SeasonArray($SeasonIDs,$Sort) {
		require_once("com/tcshl/season/Season.php");
				
		$query = 'SELECT seasonId FROM '.SEASONS;
		if($SeasonIDs != 0) {
			foreach($SeasonIDs as $index => $seasonID) {
				$seasonIdArray[$index]="'".$seasonID."'";
			}			
			// build a string of comma-separated seasonIDs
			$seasonIdString=implode(',', $seasonIdArray);
					
			$query .= ' WHERE seasonID IN ('.$seasonIdString.')';
		}
		$query .= ' ORDER BY seasonName '.$Sort;
		
		$result = mysql_query($query)
  			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error()); 		
		
		$Season = null;
		if ($result && mysql_num_rows($result) > 0) {	
			while ($season = mysql_fetch_array($result, MYSQL_ASSOC)) {	
				$Season = new Season($season['seasonId']);
				$this->SeasonArray[] = (object) $Season;
			}
		} else {
			$this->SeasonArray = array();
		}
		
		return $this->SeasonArray;
	}
 }
?>
