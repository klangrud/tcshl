<?php
/*
 *This file will define all of the global variables.  Including database names and such.
 */

/*
 * Project Variables
 */
  define('DOMAIN_NAME', "@domain.name@");
  define('PROJECT_NAME', "@project@");
  define('ENVIRONMENT', "@environment@");
/*
 * Database
 */
 define('DBHOST', "@dbhost@");
 define('DBUSER', "@dbuser@");
 define('DBPASS', "@dbpass@");
 define('DBNAME', "@dbname@");
 
/*
 * Database Table Names
 */
 define('ANNOUNCEMENTS', "announcements");
 define('AUDIT', "audit"); 
 define('AWARDS', "awards"); 
 define('BOARDMEMBER', "boardmember");  
 define('DRAFT', "draft");
 define('DST', "dst"); 
 define('GAME', "game");
 define('GOALIESTAT', "goaliestat");
 define('MARQUEE', "marquee"); 
 define('PAYMENTDATES', "paymentdates");
 define('PAYMENTDATESALT', "paymentdatesalt");
 define('PAYMENTPLANONE', "paymentplanone");
 define('PAYMENTPLANTWO', "paymentplantwo"); 
 define('PAYMENTPLANTHREE', "paymentplanthree");  
 define('PAYMENTPLANFOUR', "paymentplanfour"); 
 define('PLAYER', "player");
 define('PLAYERSTAT', "playerstat"); 
 define('REFEREESOFSEASONS', "refereesofseasons"); 
 define('REGISTRATION', "registration");
 define('ROSTERSOFTEAMSOFSEASONS', "rostersofteamsofseasons");
 define('SEASONS', "seasons"); 
 define('SKILLLEVELS', "skilllevels");
 define('SPONSORS', "sponsors"); 
 define('SPONSORSOFSEASONS', "sponsorsofseasons");  
 define('TEAMS', "teams");
 define('TEAMSOFSEASONS', "teamsofseasons");
 define('USER', "registereduser");
 define('VARIABLES', "variables"); 

 /*
  * Variables
  */
define('ONE_DAY', 60*60*24); // One Day in Seconds (s*m*h)
define('TEN_DAYS', 60*60*24*10); // Ten Days in Seconds (s*m*h*d)
define('SESSION_TIMEOUT', 60*15); // Seconds (s*m)
define('LONG_SESSION_TIMEOUT', 60*60*24*365*10);  // About ten years (s*m*h*d*Y)

/*
 * Email
 */
 define('VERIFICATION_EMAIL_SENDER', 'administrator@tcshl.com');
 define('VERIFICATION_EMAIL_SUBJECT', 'TCSHL.COM Account Verification');
 define('REG_EMAIL_SUBJECT', 'TCSHL League Registration Notification');
 define('RESET_PASSWORD_EMAIL_SUBJECT', 'TCSHL.COM Account Password Reset');
 
 define('ADMIN_EMAIL', 'administrator@tcshl.com');
 define('BOARD_EMAIL', 'board@tcshl.com');
 define('PAYMENT_EMAIL', 'payment@tcshl.com');
 define('REF_EMAIL', 'referees@tcshl.com');
 define('REG_EMAIL', 'registration@tcshl.com');
 define('REP_EMAIL', 'teamreps@tcshl.com');
 define('SITEREG_EMAIL', 'siteregistration@tcshl.com'); 
 define('STATS_EMAIL', 'stats@tcshl.com');
 define('TCSHL_EMAIL', 'tcshl@tcshl.com'); 
 //define('WEBMASTER_EMAIL', 'kurt.langrud@tcshl.com'); 
 define('WEBMASTER_EMAIL', 'klangrud@gmail.com'); 
 
/*
 * Recaptcha
 */
 
 // Prod
 define('RECAPTCHA_PUBLIC_KEY','6LcdssYSAAAAAPewzICWJAtPJSN3EW2HiXkBOuBS');
 define('RECAPTCHA_PRIVATE_KEY','6LcdssYSAAAAAGjLWB1U0N8urtI50eM3IU6Mr0KL');
 
 // Test
 //define('RECAPTCHA_PUBLIC_KEY','6LdzBscSAAAAAGqlWV_D5b1FMdxXVwysADlBjWR2');
 //define('RECAPTCHA_PRIVATE_KEY','6LdzBscSAAAAAFrlij8uTJ0JMNKQK12qwDgzYT6K');
?>
