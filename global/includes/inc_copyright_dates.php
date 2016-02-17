<?php
	$year = date('Y');
	
	if($year > '2007') {
		$smarty->assign('copyright_dates', '2007 - '.$year);
	}
	else {
		$smarty->assign('copyright_dates', '2007');
	}
?>
