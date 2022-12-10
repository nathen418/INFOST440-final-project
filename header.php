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
		}
	</style>

</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded-bottom ">
		<div class="container-fluid">
			<a class="navbar-brand mt-2 mt-lg-0" href="#">
				<img src="resources/logo.png" height="32" alt="bLog Logo" loading="lazy" />
			</a>
			<a class="navbar-brand" href="index.php">bLog</a>
			<button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fas fa-bars"></i>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="index.php">Home</a>
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
		</div>
	</nav>
	<div id="content">