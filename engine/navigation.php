<?php


/*
 * Created on Feb 22, 2007
 *
 * navigation.php is responsible for building the projects left nav menu.
 */

$left_nav = '';

build_nav_start();

build_session_nav();

if (isset($_SESSION['site_access']) && $_SESSION['site_access'] >= 3) {
	build_admin_nav();
}

if (isset($_SESSION['site_access']) && $_SESSION['site_access'] >= 2) {
	build_client_nav();
}

build_public_nav();

build_nav_end();

$smarty->assign('LEFT_NAV', $left_nav);

function build_nav_start() {
	global $left_nav;
	$left_nav .= '<div class="left">';

}

function build_session_nav() {
	global $left_nav;

	$left_nav .= '<div class="titleSide">';
	$left_nav .= 'Welcome';
	$left_nav .= '</div>';

	if (isset ($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
		$left_nav .= '<ul><li>' . $_SESSION['firstname'] . '\'s Account</li></ul>';
		$left_nav .= '<div class="button2"><a href="logout.php">Sign Out</a></div>';
	} else {
		$left_nav .= '<div class="button1"><a href="login.php">Sign In</a></div>';
	}
}

function build_admin_nav() {
	global $left_nav;
	$left_nav .= '<div class="titleSide">';
	$left_nav .= 'Admini';
	$left_nav .= '</div>';
	$left_nav .= '<ul>';
	$left_nav .= '<li><a href="index.php?command=admin">Admin Home</a></li>';
	$left_nav .= '</ul>';
}

function build_client_nav() {
	global $left_nav;
	$left_nav .= '<div class="titleSide">';
	$left_nav .= 'Client';
	$left_nav .= '</div>';
	$left_nav .= '<ul>';
	$left_nav .= '<li><a href="index.php?command=employee">Client Home</a></li>';
	$left_nav .= '</ul>';
}

function build_public_nav() {
	//If public nav is needed
}

function build_nav_end() {
	global $left_nav;
	$left_nav .= '</div>';

}
?>
