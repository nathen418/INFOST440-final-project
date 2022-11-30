<?php session_start(); ?>
<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" rel="stylesheet">
<link rel="shortcut icon" href="./resources/logo.png" type="image/x-icon">
<title><?php echo $page_title; ?></title>
<meta name="description" content="Slowly reinventing WordPress one poorly coded final project at a time">
<meta name="keywords" content="Nathen, Nathan">
<meta name="author" content="Nathen and Nathan">
<meta property="og:type" content="website">
<meta property="og:title" content="440 Blog">
<meta property="og:description" content="The badly designed blog">
<meta property="theme-color" content="#6761A8">
</head>
<body>
	<div id="navigation">
		<ul>
			<li><a href="index.php">Home Page</a></li>
			<li><a href="register.php">Register</a></li>
			<li><a href="view_users.php">View Users</a></li>
			<li><a href="password.php">Change Password</a></li>
			<li>
				<?php // Create a login/logout link:
					if ( (isset($_SESSION['user_id'])) && (basename($_SERVER['PHP_SELF']) != 'logout.php') ) {
						echo '<a href="logout.php">Logout</a>';
					} else {
						echo '<a href="login.php">Login</a>';
				}?>
			</li>
		</ul>
	</div>
	<div id="content"><!-- Start of the page-specific content. -->
<!-- Script 12.7 - header.html -->