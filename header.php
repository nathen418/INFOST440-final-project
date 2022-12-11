<?php session_start(); ?>
<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="shortcut icon" href="./resources/logo.png" type="image/x-icon">
	<title><?php echo $page_title; ?></title>
	<meta name="description" content="Slowly reinventing WordPress one poorly coded final project at a time">
	<meta name="keywords" content="Nathen, Nathan">
	<meta name="author" content="Nathen and Nathan">
	<meta property="og:type" content="website">
	<meta property="og:title" content="bLog">
	<meta property="og:description" content="The badly designed blog">
	<meta property="theme-color" content="#6761A8">

	<style>
		#sort {
			text-align: center;
		}

		.content {
			padding: 5px 20px;
		}

		body {
			background: #6a11cb;
			background: -webkit-linear-gradient(right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
		}

		.card {
			margin: 0 auto;
			float: none;
			margin-bottom: 10px;
			box-shadow: none;
			width: 100%;
			max-width: 600px;
		}

		#comments-container h2 {
			margin: 1rem 1rem;
		}

		#comments-container .card {
			border: none;
			border-bottom: 2px solid gray;
			margin-bottom: 1rem
		}

		#comments-container .card:last-of-type {
			border: none;
		}

		.alert p {
			margin: 0.5rem;
		}

		.alert {
			width: 100%;
			max-width: 600px;
		}

		#pages-container {
			width: 100%;
			max-width: 600px;
			margin: 0 auto;
		}
	</style>

</head>

<body>
	<nav class="navbar navbar-expand navbar-dark bg-dark rounded-bottom sticky-top">
		<div class="container-fluid">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<a class="navbar-brand" href="index.php">
					<img src="resources/logo.png" height="32" alt="bLog Logo" loading="lazy" />
				</a>
				<a class="navbar-brand" href="index.php">bLog</a>
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="index.php">Home</a>
				</li>
				<?php
				if (isset($_SESSION['user_id']) && $_SESSION['is_admin'] == 1) {
				?>
					<li class="nav-item">
						<a class="nav-link" href="post.php">Post</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="admin.php">Admin Panel</a>
					</li>
				<?php }
				// Create a login/logout link:
				if ((isset($_SESSION['user_id'])) && (basename($_SERVER['PHP_SELF']) != 'logout.php')) { ?>
					<li class="nav-item">
						<a class="nav-link" href="logout.php">Logout</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="password.php">Change Password</a>
					</li>
				<?php } else { ?>
					<li class="nav-item">
						<a class="nav-link" href="login.php">Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="register.php">Register</a>
					</li>
				<?php } ?>
				<li class="nav-item">
					<a class="nav-link" href=""><?php echo @$_SESSION['first_name']; ?></a>
				</li>
			</ul>
		</div>
	</nav>
	<div id="content">