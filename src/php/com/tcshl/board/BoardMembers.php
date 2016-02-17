<?php
/*
 * Created on Sep 21, 2009
 *
 * This is the Board Members object.  It returns an array of Board Members objects.  It accepts an array of
 * boardMemberIDs as arguments.  If none are given then it will return all Board Members.
 */
 
 class BoardMembers {
 	private $BoardMembersArray;
 	function __construct() {
 		$BoardMembersArray = array();
 	}

    // BoardMemberIDs is an array of BoardMemberIDs to return BoardMember Objects for.  Use 0 to return all.
	public function get_BoardMemberArray($BoardMemberIDs) {
		require_once("com/tcshl/board/BoardMember.php");
		$query = 'SELECT boardMemberID FROM '.BOARDMEMBER;
		if($BoardMemberIDs != 0) {
			$query .= ' WHERE boardMemberID IN '.$BoardMemberIDs;
		}
		$query .= ' ORDER BY boardMemberLastName';
		
		$result = mysql_query($query)
  			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error()); 		
		
		$BoardMember = null;
		if ($result && mysql_num_rows($result) > 0) {	
			while ($boardMember = mysql_fetch_array($result, MYSQL_ASSOC)) {	
				$BoardMember = new BoardMember($boardMember['boardMemberID']);
				$this->BoardMemberArray[] = (object) $BoardMember;
			}
		} else {
			$this->BoardMemberArray = array();
		}
		
		return $this->BoardMemberArray;
	}
 }
?>
