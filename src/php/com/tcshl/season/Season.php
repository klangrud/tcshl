<?php
/*
 * Created on Oct 22, 2009
 *
 * This is the Season object
 */
 
 class Season {
 	// Season Object Attributes
 	private $seasonID;
 	private $seasonName;
 	
 	// Misc Attributes
 	private $formErrors;
 	private $formSuccess;


	// Constructor
	public function __construct($seasonID) {
	    $this->seasonID=$seasonID;
	    $this->formErrors=array();
	    $this->formSuccess=array();
	    if($this->seasonID != 0) {
	    	$this->load_season();
	    }
	}
	
 	private function load_season() {
 		$query = 'SELECT * FROM '.SEASONS.' WHERE seasonId='.$this->seasonID;
 		
		$result = mysql_query($query)
  			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error()); 
  		
  			if ($result && mysql_num_rows($result) > 0) {	
  				while ($season = mysql_fetch_array($result, MYSQL_ASSOC)) {
  					$this->seasonName=$season['seasonName'];					
  				}
  			}
 	}
 	
 	private function update_season() {
 		$query = 'UPDATE '.SEASONS;
 		$query .= ' SET ';
 		$query .= ' seasonName = "'.$this->get_seasonName().'"'; 		 		
 		$query .= ' WHERE seasonId='.$this->get_seasonID();
		
		mysql_query($query)
  					or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  					
  		if(validResult()) {
  			$this->formSuccess[]='Season '.$this->get_seasonName().' updated successfully!';
  		} else {
  			$this->formErrors[]='Season '.$this->get_seasonName().' NOT updated!  Try again or notify TCSHL.com administrator.';
  		}
 	}
 	
 	private function insert_season() {
		$columns = '`seasonName`';
				
		$query = 'INSERT INTO '.SEASONS.' ('.$columns.') ';
		$query .= 'VALUES("'.$this->get_seasonName().'"';
		$query .= ')'; 		
  			
		mysql_query($query)
  					or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  							  					
  		if(validResult()) {
  			$this->formSuccess[]='Season '.$this->get_seasonName().' created successfully!';
  		} else {
  			$this->formErrors[]='Season '.$this->get_seasonName().' NOT created!  Try again or notify TCSHL.com administrator.';
  		}
 	}
 	
 	private function delete_season() {
		if($this->canDelete()) {		
			$query = 'DELETE FROM '.SEASONS.' WHERE seasonId='.$this->get_seasonID();
	
			mysql_query($query)
	  					or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	  					
	  		if(validResult()) {
	  			$this->formSuccess[]='SEASON '.$this->get_seasonName().' deleted successfully!';
	  		} else {
	  			$this->formErrors[]='SEASON '.$this->get_seasonName().' NOT deleted!  Try again or notify TCSHL.com administrator.';
	  		}
  		} else {
			$this->formErrors[]='SEASON '.$this->get_seasonName().' CANNOT be deleted as it has at least one game scheduled!';
		}
 	}
 	
 	// Determines if a season can be deleted
 	public function canDelete() {
 		$query = 'SELECT * FROM '.GAME.' WHERE seasonId='.$this->get_seasonID().' LIMIT 1';
 					
 		$result = mysql_query($query)
	  				or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	  				
	  	if($result && mysql_num_rows($result) > 0) {
	  		return false;
	  	} else {
	  		return true;
	  	}
 	}
 	
 	// Returns an array of Team ids
 	public function get_teams() {
 		$query = 'SELECT teamID FROM '.TEAMSOFSEASONS.' WHERE seasonID='.$this->get_seasonID().' AND teamID != 7 AND teamID != 14';
 		
 		$result = mysql_query($query)
	  				or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	  	
	  	$teams = array();
		if ($result && mysql_num_rows($result) > 0) {	
			while ($season = mysql_fetch_array($result, MYSQL_ASSOC)) {	
				$teams[]= $season['teamID'];
			}
	  	} else {
	  		$seasons = 'No Teams Assigned';
	  	}
	  	return $teams;		
 	}
	
	// TeamFormReposts
	public function formReposts($smarty) {
		if ($_POST) {
			if ($_POST['seasonName']) {
				$smarty->assign('sn', $_POST['seasonName']);
			}
		}	
	}
	
	// TeamFormValidation
	public function formValidation() {
		if ($_POST['seasonName']) {
			if (strlen($_POST['seasonName']) < 2) {
				$this->formErrors[] = "Season Name must be at least 2 characters long.";
			}
		} else {
			$this->formErrors[] = "Season name is a required field";
		}
		
		return $this->get_formErrors();
	}
	
	//formProcessInsert
	function formProcessInsert() {
		$this->formProcess();
		$this->insert_season();
		return $this->get_formErrors();
		
	}
	
	//formProcessUpdate	
	function formProcessUpdate() {
		$this->formProcess();
		$this->update_season();
		return $this->get_formErrors();		
	}
	
	//formProcessUpdate	
	function formProcessDelete() {
		$this->delete_season();
		return $this->get_formErrors();		
	}	
	
	//formProcess
	private function formProcess() {
		$this->set_seasonName($_POST['seasonName']);
	}
	
	// Get seasonID
	public function get_seasonID() {
	    return $this->seasonID;
	}
	
	// Get set seasonName
	public function set_seasonName($seasonName) {
	    $this->seasonName=$seasonName;
	}
	public function get_seasonName() {
	    return $this->seasonName;
	}
	
	// Get $formErrors
	public function get_formErrors() {
		return (array) $this->formErrors;
	}
	
	// Get $formSuccess
	public function get_formSuccess() {
		return (array) $this->formSuccess;
	} 	
 }
?>
