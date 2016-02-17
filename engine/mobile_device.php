<?php
/*
 * Created on Oct 23, 2009
 *
 * Determine mobile device and redirect
 */

 /*
  *  So the first time someone starts a new session we want to check their User Agent.  If
  * it is a mobile device, we will redirect them to the mobile index page just once.  Then
  * it is up to them what they decide to view.  Whether it be mobile content or regular.
  */
 if(!isset($_SESSION['mobilechecked'])) {
 	if(isMobileDevice()) {
 		$_SESSION['mobilechecked']='true';
 		header("Location: mobileindex.php");
 	} else {
		// We want to persist it.
		$_SESSION['mobilechecked']='true';
 	}
 }
  
 function isMobileDevice() {
 	require('mobile_device_detect.php');
 	
 	//iPhones,Android,Opera Mini,Blackberry,Palm OS, Windows Mobile, Return TRUE, NA
 	return mobile_device_detect(true,true,true,true,true,true,false,false);
 }
?>
