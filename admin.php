<?php
include('./includes/non_admin_redirect.inc.php');
$page_title = 'Admin Panel | bLog';
include('header.php');
?>

<p class="h2 text-center text-white" style="margin-top:4rem">Admin Panel</p>

<div class="card bg-dark text-white" style="width:500px">
	<div class="card-body">
		<h5 class="card-title">Registered Users</h5>
		<p class="card-text">
			<?php
			include 'includes/view_users.inc.php';
			?>
		</p>
		<?php
		if (isset($_SESSION['user_id']) && $_SESSION['is_admin'] == 1) {
		?>
			<a href="" class="btn btn-warning">Edit</a>
			<a href="" class="btn btn-danger">Delete</a>
		<?php
		}
		?>
	</div>
</div>