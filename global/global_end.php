<?php
require_once ('includes/inc_copyright_dates.php');
//Closes the DB Connection - This is now done in Connection.php as part
//of that objects destructor.
//$DatabaseConnection->close_databaseLink();
$smarty->display('global/global_end.tpl');
?>
