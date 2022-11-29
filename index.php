<?php
//Create Session
session_start();
//header
$page_title = 'Home';
include('header.php');

//If a user name is entered display login message
	if (isset($_SESSION['first_name'])) {
		echo "You currently logged in as {$_SESSION['first_name']}. Welcome to our website!";
}


//header
include('footer.php');
?>