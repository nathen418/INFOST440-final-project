<?php session_start(); ?>
<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="nofollow" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
	<link rel="shortcut icon" href="./resources/logo.png" type="image/x-icon">
	<title><?php echo $page_title; ?></title>
	<meta name="description" content="Slowly reinventing WordPress one poorly coded final project at a time">
	<meta name="keywords" content="Nathen, Nathan">
	<meta name="author" content="Nathen and Nathan">
	<meta property="og:type" content="website">
	<meta property="og:title" content="440 Blog">
	<meta property="og:description" content="The badly designed blog">
	<meta property="theme-color" content="#6761A8">

	<style>
		#sort {
			text-align: center;
		}

		/* Get guestbook cards in center, also make responsive */
		.card {
			width: 90%;
			max-width: 600px;
			margin: 0 auto;
			margin-bottom: 30px;
			box-shadow: 2px 5px 5px lightgray;
			border-radius: 5px;
		}

		.header {
			background-color: #dbd1c4;
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 5px 20px;
			border-radius: 5px 5px 0 0;
		}

		.header h1 {
			font-size: 1.4em;
			margin-right: 20px;
		}

		.header p {
			font-weight: bold;
		}

		.content {
			padding: 5px 20px;
		}

		/* Differentiate date from guestbook comment */
		.content>.date {
			font-style: italic;
			font-size: 0.9em;
			text-align: right;
			color: gray;
		}

		/* Nav bar  */
		#navigation {
			display: flex;
			justify-content: right;
		}

		#navigation ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
		}

		#navigation li {
			float: left;
		}

		#navigation li a {
			display: block;
			padding: 8px;
			background-color: #dddddd;
		}

		.body {
			/* fallback for old browsers */
			background: #6a11cb;
			/* Chrome 10-25, Safari 5.1-6 */
			background: -webkit-linear-gradient(right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
		}
		
		.card {
			box-shadow: none;
		}
	</style>

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
				if ((isset($_SESSION['user_id'])) && (basename($_SERVER['PHP_SELF']) != 'logout.php')) {
					echo '<a href="logout.php">Logout</a>';
				} else {
					echo '<a href="login.php">Login</a>';
				} ?>
			</li>
		</ul>
	</div>
	<div id="content">
		<!-- Start of the page-specific content. -->
		<!-- Script 12.7 - header.html -->