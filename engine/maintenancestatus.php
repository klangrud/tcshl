<?php
/*
 * Created on Sep 4, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 if(isset($_GET['maintenance']) && $_GET['maintenance'] > 0) {
 	 // Do Nothing
 } else {
 	if(site_under_maintenance()) {
 		header("Location: maintenance.php?maintenance=1");
 	}
 }
 
 
 function site_under_maintenance() {
 	global $Link;
 	
 	$maintenance = get_site_variable_value("MAINTENANCE");
 	
  if($maintenance > 0) {
  	return true;
  }	else {
  	return false;
  }
 }
?>
