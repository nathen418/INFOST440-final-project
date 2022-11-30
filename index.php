

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

// Display a list of posts here
// On each post, there should be a link to view the post and comments, and a link to add a comment. If the user is logged in, there should be a link to edit the post and delete the post if it was made by the logged in user. 

// Display a few buttons that allow for the posts to be sorted



//header
include('footer.php');
?>