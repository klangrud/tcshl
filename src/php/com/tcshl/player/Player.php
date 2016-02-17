<?php
/*
 * Created on Sep 15, 2009
 *
 * This is the Player object.  The object will attempt to load a player into memory, otherwise it creates a new player in memory.
 * Once loaded, that player can be updated or inserted into the database.
 */
 
 class Player {
 	private $playerID;
 	private $playerFName;
 	private $playerLName;
 	private $playerSkillLevel;
 	private $playerRegistrationID;
 	private $playerSeasonID;
 	
 	function __construct($playerID) {
 		$this->playerID=(int)$playerID;
 		if($this->playerID != 0) {
 			$this->load_player();	
 		}
 	}
 	
 	function load_player() {
 		$query = 'SELECT * FROM '.PLAYER.' WHERE playerID='.$this->playerID;
 		
		$result = mysql_query($query)
  			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error()); 
  		
  			if ($result && mysql_num_rows($result) > 0) {	
  				while ($player = mysql_fetch_array($result, MYSQL_ASSOC)) {
  					$this->playerFName=$player['playerFName'];
  					$this->playerLName=$player['playerLName'];
  					$this->playerSkillLevel=$player['playerSkillLevel'];
  					$this->playerRegistrationID=$player['registrationId'];
  					$this->playerSeasonID=$player['seasonId'];
  				}
  			}
 	}
 	
 	function update_player() {
 		$query = 'UPDATE '.PLAYER;
 		$query .= ' SET ';
 		$query .= ' playerFName = "'.$this->get_playerFName().'",';
 		$query .= ' playerLName = "'.$this->get_playerLName().'",';
 		$query .= ' playerSkillLevel = '.$this->get_playerSkillLevel().',';
 		$query .= ' registrationId = '.$this->get_playerRegistrationID().',';
 		$query .= ' seasonId = '.$this->get_playerSeasonID();
 		$query .= ' WHERE playerID='.$this->get_playerID();
 		  			
		$result = mysql_query($query)
  					or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());  			
 	}
 	
 	function insert_player() {
		$columns = '`playerFName`,`playerLName`,`playerSkillLevel`,`registrationId`,`seasonId`';
				
		$query = 'INSERT INTO '.PLAYER.' ('.$columns.') ';
		$query .= 'VALUES("'.$this->get_playerFName().'",';
		$query .= '"'.$this->get_playerLName().'",';
		$query .= ''.$this->get_playerSkillLevel().',';				
		$query .= ''.$this->get_playerRegistrationID().',';
		$query .= ''.$this->get_playerSeasonID();
		$query .= ')'; 		
  			
		$result = mysql_query($query)
  					or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());		
 	} 
 	
 	function delete_player() {
		$query = 'DELETE FROM '.PLAYER.' WHERE playerID='.$this->get_playerID();

		$result = mysql_query($query)
  					or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
 	} 	
 	
 	public function get_playerID() {
 		return $this->playerID;
 	}
 	
 	// Get set playerFName
 	public function set_playerFName($playerFName) {
 		$this->playerFName=$playerFName;
 	}
 	public function get_playerFName() {
 		return $this->playerFName;
 	} 	
 	// Get set playerLName
 	public function set_playerLName($playerLName) {
 		$this->playerLName=$playerLName;
 	}
 	public function get_playerLName() {
 		return $this->playerLName;
 	} 	
 	// Get set playerSkillLevel
 	public function set_playerSkillLevel($playerSkillLevel) {
 		$this->playerSkillLevel=$playerSkillLevel;
 	}
 	public function get_playerSkillLevel() {
 		return $this->playerSkillLevel;
 	} 
 	// Get set playerRegistrationID
 	public function set_playerRegistrationID($playerRegistrationID) {
 		$this->playerRegistrationID=$playerRegistrationID;
 	}
 	public function get_playerRegistrationID() {
 		return $this->playerRegistrationID;
 	}  
 	// Get set playerSeasonID
 	public function set_playerSeasonID($playerSeasonID) {
 		$this->playerSeasonID=$playerSeasonID;
 	}
 	public function get_playerSeasonID() {
 		return $this->playerSeasonID;
 	}
 	// Get player Skill Level in Human Readable
 	public function get_humanReadablePlayerSkillLevel() {
 		require_once("SkillLevel.php");
 		$humanReadableSkillLevel = new SkillLevel($this->playerSkillLevel);
 		return $humanReadableSkillLevel->get_humanReadableSkillLevel();
 	}
 	// Get player Season in Human Readable
 	public function get_humanReadableSeason() {
 		require_once("com/tcshl/global/Season.php");
 		$humanReadableSeason = new Season($this->playerSeasonID);
 		return $humanReadableSeason->get_humanReadableSeason();
 	}
 	// Get player Season IDs played.  Returns Array of SeasonIDs
 	public function get_playerSeasonIDs() {
 		$query = 'SELECT distinct seasonID FROM '.ROSTERSOFTEAMSOFSEASONS.' WHERE playerID='.$this->playerID;
 		
		$result = mysql_query($query)
  			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error()); 
  		
  		$seasonIDs = array();
		if ($result && mysql_num_rows($result) > 0) {	
			while ($season = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$seasonIDs[] = $season['seasonID'];
			}
		} else {
			$seasonIDs = 0;
		}
		return $seasonIDs;		
 	}
 	// Get player Seasons played.  Returns Array of Seasons
 	public function get_playerSeasons() {
 		require_once("com/tcshl/global/Season.php");
 		$humanReadableSeason = null;		
 		
 		$seasonIDs = $this->get_playerSeasonIDs();
 		$seasonNames = array();
 		if($seasonIDs != 0) {
	 		foreach($seasonIDs as $seasonID) {
	 			$humanReadableSeason = new Season($seasonID);
	 			$seasonNames[] = $humanReadableSeason->get_humanReadableSeason();
	 		}
 		} else {
 			$seasonNames[] = 'N/A - Either this player has never been assigned to a roster or they are D.R.I.L. only.';
 		}
 		return $seasonNames;		
 	} 	
 }
?>