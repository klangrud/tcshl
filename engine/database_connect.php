<?php
require ("com/tcshl/database/Connection.php");
$DatabaseConnection = new Connection(DBHOST, DBUSER, DBPASS, DBNAME);
$Link = $DatabaseConnection->get_databaseLink();
?>