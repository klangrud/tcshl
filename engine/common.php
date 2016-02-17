<?php

//Set Classpath
require_once('classpath.php');

//Demoronize the $_REQUEST
require_once('request_sanitation.php');

// Set Definitions
require_once('definitions.php');

//Set DB Connection
require_once('database_connect.php');

// Session handling
require('session.php');

// Mobile Device Detection
require('mobile_device.php');

// Page Access Check
require('site_access.php');

// Set up Smarty Template Engine
require('smarty_connect.php');
$smarty = new smarty_connect;

// Build the left nav
require('navigation.php');

// Functions that everypage can user
require_once('functions.php');

// Check for site maintenance
require('maintenancestatus.php');

// Season Getter
require_once('season.php');

// Select menus for forms.
require_once('select_functions.php');

// Set default timezone
require_once('default_timezone.php');

// ReCAPTCHA Library
require_once('recaptchalib.php');

// Send Email Functions
require_once('send_email.php');

?>
