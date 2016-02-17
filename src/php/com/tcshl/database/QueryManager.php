<?php
/*
 * Created on Sep 16, 2009
 *
 * This class will run queries on behalf of the application.  Eventually, I'd like
 * to have this class audit who makes updates.
 * e.g. Updates games, updates stats.
 * 
 */
 
 class QueryManager {
 	private $userID;
 	
 	function __construct($userID) {
 		$this->userID=$userID;
 	}
 	
 	// Runs query and makes entry in audit table
 	function doQuery($query) {
		$result = mysql_query($query)
  			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  			
  		return $result;		
 	}
 	
 	private function doAuditQuery() {
 		
 	}
 }
?>
