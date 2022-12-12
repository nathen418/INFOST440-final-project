<?php
include('./includes/non_admin_redirect.inc.php');
$page_title = 'Admin Panel | bLog';
include('header.php');
?>

<p class="h2 text-center text-white" style="margin-top:4rem">Admin Panel</p>

<div class="card bg-dark text-white">
	<div class="card-body">
		<h5 class="card-title">Registered Users</h5>
		<p class="card-text">
			<?php
			include 'includes/view_users.inc.php';
			?>
		</p>
	</div>
</div>