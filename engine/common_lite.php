<?php

// This is a lighter setup than common.php.  This is meant more for pages that
// may only need a classpath and connection to the database.

//Set Classpath
require_once('classpath.php');

//Demoronize the $_REQUEST
require_once('request_sanitation.php');

// Set Definitions
require_once('definitions.php');

//Set DB Connection
require_once('database_connect.php');

// Set default timezone
require_once('default_timezone.php');

?>