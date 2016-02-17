<?php
/*
 * Created on Oct 23, 2009
 *
 * This is a Schedule object.  It basically just creates Arrays of Game Objects
 */
 
 class Schedule {
	
	private $today;
	private $GameArray;
 	
 	function __construct() {
 		$this->today = time();
 		$this->GameArray = array();
 	}
 	
 	
 	public function loadUpcomingGames($seasonid,$teamid,$daylimit) {
 		$this->loadSchedule($seasonid,$teamid,'ALL',$daylimit,0);
 	}
 	
 	public function loadTeamsNextGame($seasonid,$teamid) {
 		$this->loadSchedule($seasonid,$teamid,'ALL',0,1);
 	}
 	
 	public function loadSeasonSchedule($seasonid) {
 		$this->loadSeasonTeamSchedule($seasonid,0,0);
 	}
 	
 	public function loadSeasonTeamSchedule($seasonid,$teamid,$daylimit) {
 		$this->loadSeasonTeamTypeSchedule($seasonid,$teamid,'ALL',$daylimit);
 	}
 	
 	public function loadSeasonTeamTypeSchedule($seasonid,$teamid,$type,$daylimit) {
		$this->loadSchedule($seasonid,$teamid,$type,$daylimit,0);
 	}
 	
 	private function loadSchedule($seasonid,$teamid,$type,$daylimit,$resultlimit) {
 		require_once('com/tcshl/game/Game.php');
 		
 		$query = 'SELECT gameID FROM '.GAME.' WHERE seasonId = '.$seasonid;
 		if($teamid > 0)  {
 			$query .= ' AND teamId = '.$teamid;
 		}
 		if($type == 'pre' || $type == 'season' || $type == 'post') {
 			$query .= ' AND gameType = '.$type;
 		}
 		if($daylimit > 0) {
			$query .= ' AND gameTime>='.$this->get_today();
			$query .= ' AND gameTime<='.($this->get_today()+$this->calculateDaySeconds($daylimit));  			
 		}
 		$query .= ' ORDER BY gameTime ASC';
 		if($resultlimit > 0) {
 			$query .= ' LIMIT '.$resultlimit;
 		}
 		
		$result = mysql_query($query)
  			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error()); 
		
		$Game = null;
		if ($result && mysql_num_rows($result) > 0) {	
			while ($game = mysql_fetch_array($result, MYSQL_ASSOC)) {	
				$Game = new Game($game['gameID']);
				$this->GameArray[] = (object) $Game;
			}
		}
 	}
 	
 	private function calculateDaySeconds($days) {
 		return 60*60*24*$days;
 	}
 	
 	public function get_today() {
 		return $this->today;
 	}
 	
 	public function get_GameArray() {
 		return $this->GameArray;
 	} 	
 }
?>
