<?php
/*
 * Created on Sep 23, 2009
 *
 * This is the Team object
 */
 
 class Team {
 	// Team Object Attributes
 	private $teamID;
 	private $teamShortName;
 	private $teamName;
 	private $teamFGColor;
 	private $teamBGColor;
 	
 	// Misc Attributes
 	private $teamFormErrors;
 	private $teamFormSuccess;


	// Constructor
	public function __construct($teamID) {
	    $this->teamID=$teamID;
	    $this->teamFormErrors=array();
	    $this->teamFormSuccess=array();
	    if($this->teamID != 0) {
	    	$this->load_team();
	    }
	}
	
 	private function load_team() {
 		$query = 'SELECT * FROM '.TEAMS.' WHERE teamID='.$this->teamID;
 		
		$result = mysql_query($query)
  			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error()); 
  		
  			if ($result && mysql_num_rows($result) > 0) {	
  				while ($team = mysql_fetch_array($result, MYSQL_ASSOC)) {
  					$this->teamName=$team['teamName'];
  					$this->teamShortName=$team['teamShortName'];
  					$this->teamFGColor=$team['teamFGColor'];
  					$this->teamBGColor=$team['teamBGColor'];					
  				}
  			}
 	}
 	
 	private function update_team() {
 		$query = 'UPDATE '.TEAMS;
 		$query .= ' SET ';
 		$query .= ' teamName = "'.$this->get_teamName().'",';
 		$query .= ' teamShortName = "'.$this->get_teamShortName().'",';
 		$query .= ' teamFGColor = "'.$this->get_teamFGColor().'",'; 		
 		$query .= ' teamBGColor = "'.$this->get_teamBGColor().'"';	 		 		
 		$query .= ' WHERE teamID='.$this->get_teamID();
		
		mysql_query($query)
  					or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  					
  		if(validResult()) {
  			$this->teamFormSuccess[]='Team '.$this->get_teamName().' updated successfully!';
  		} else {
  			$this->teamFormErrors[]='Team '.$this->get_teamName().' NOT updated!  Try again or notify TCSHL.com administrator.';
  		}
 	}
 	
 	private function insert_team() {
		$columns = '`teamName`,`teamShortName`,`teamFGColor`,`teamBGColor`';
				
		$query = 'INSERT INTO '.TEAMS.' ('.$columns.') ';
		$query .= 'VALUES("'.$this->get_teamName().'",';
		$query .= '"'.$this->get_teamShortName().'",';
		$query .= '"'.$this->get_teamFGColor().'",';
		$query .= '"'.$this->get_teamBGColor().'"';
		$query .= ')'; 		
  			
		mysql_query($query)
  					or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  							  					
  		if(validResult()) {
  			$this->teamFormSuccess[]='Team '.$this->get_teamName().' created successfully!';
  		} else {
  			$this->teamFormErrors[]='Team '.$this->get_teamName().' NOT created!  Try again or notify TCSHL.com administrator.';
  		}
 	}
 	
 	private function delete_team() {
		if($this->canDelete()) {		
			$query = 'DELETE FROM '.TEAMS.' WHERE teamID='.$this->get_teamID();
	
			mysql_query($query)
	  					or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	  					
	  		if(validResult()) {
	  			$this->teamFormSuccess[]='Team '.$this->get_teamName().' deleted successfully!';
	  		} else {
	  			$this->teamFormErrors[]='Team '.$this->get_teamName().' NOT deleted!  Try again or notify TCSHL.com administrator.';
	  		}
  		} else {
			$this->teamFormErrors[]='Team '.$this->get_teamName().' CANNOT be deleted as it belongs to a season!';
		}
 	}
 	
 	// Determines if a team can be deleted
 	public function canDelete() {
 		$query = 'SELECT * FROM '.TEAMSOFSEASONS.' WHERE teamID='.$this->get_teamID();
 					
 		$result = mysql_query($query)
	  				or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	  				
	  	if($result && mysql_num_rows($result) > 0) {
	  		return false;
	  	} else {
	  		return true;
	  	}
 	}
 	
 	public function get_teamSeasons() {
 		$query = 'SELECT seasonID FROM '.TEAMSOFSEASONS.' WHERE teamID='.$this->get_teamID();
 		
 		$result = mysql_query($query)
	  				or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	  	
	  	$seasons = '';
		if ($result && mysql_num_rows($result) > 0) {	
			while ($season = mysql_fetch_array($result, MYSQL_ASSOC)) {	
				$seasons .= get_season_name($season['seasonID']).'<br />';
			}
	  	} else {
	  		$seasons = 'Not Assigned';
	  	}
	  	return $seasons;		
 	}
	
	// TeamFormReposts
	public function formReposts($smarty) {
		if ($_POST) {
			if ($_POST['teamName']) {
				$smarty->assign('tn', $_POST['teamName']);
			}
			if ($_POST['teamShortName']) {
				$smarty->assign('tsn', $_POST['teamShortName']);
			}
			$smarty->assign('newTeamFGColorSelect', $this->get_teamColorSelect('teamFGColor', $_POST['teamFGColor']));
			$smarty->assign('newTeamBGColorSelect', $this->get_teamColorSelect('teamBGColor', $_POST['teamBGColor']));
		}	
	}
	
	// TeamFormValidation
	public function formValidation() {
		if ($_POST['teamName']) {
			if (strlen($_POST['teamName']) < 2) {
				$this->teamFormErrors[] = "Team Name must be at least 2 characters long.";
			}
		} else {
			$this->teamFormErrors[] = "Team name is a required field";
		}
		
		return $this->get_teamFormErrors();
	}
	
	//formProcessInsert
	function formProcessInsert() {
		$this->formProcess();
		$this->insert_team();
		return $this->get_teamFormErrors();
		
	}
	
	//formProcessUpdate	
	function formProcessUpdate() {
		$this->formProcess();
		$this->update_team();
		return $this->get_teamFormErrors();		
	}
	
	//formProcessUpdate	
	function formProcessDelete() {
		$this->delete_team();
		return $this->get_teamFormErrors();		
	}	
	
	//formProcess
	private function formProcess() {
		$this->set_teamName($_POST['teamName']);
		$this->set_teamShortName($_POST['teamShortName']);
		$this->set_teamFGColor($_POST['teamFGColor']);
		$this->set_teamBGColor($_POST['teamBGColor']);
	}
	
	public function get_teamColorSelect($inputname, $color) {
		return select_color($inputname,$color);
	}	
	
	
	// Get teamID
	public function get_teamID() {
	    return $this->teamID;
	}
	
	// Get set teamName
	public function set_teamName($teamName) {
	    $this->teamName=$teamName;
	}
	public function get_teamName() {
	    return $this->teamName;
	}
	
	// Get set teamShortName
	public function set_teamShortName($teamShortName) {
	    $this->teamShortName=$teamShortName;
	}
	public function get_teamShortName() {
	    return $this->teamShortName;
	}
	
	// Get set teamFGColor
	public function set_teamFGColor($teamFGColor) {
	    $this->teamFGColor=$teamFGColor;
	}
	public function get_teamFGColor() {
	    return $this->teamFGColor;
	}
	
	// Get set teamBGColor
	public function set_teamBGColor($teamBGColor) {
	    $this->teamBGColor=$teamBGColor;
	}
	public function get_teamBGColor() {
	    return $this->teamBGColor;
	}
	
	// Get $teamFormErrors
	public function get_teamFormErrors() {
		return (array) $this->teamFormErrors;
	}
	
	// Get $teamFormSuccess
	public function get_teamFormSuccess() {
		return (array) $this->teamFormSuccess;
	} 	
 }
?>
