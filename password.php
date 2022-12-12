<?php # Script 9.7 - password.php
// This page lets a user change their password.

$page_title = 'Change Password | bLog';
include('./includes/non_admin_redirect.inc.php');
$errors = array();

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('mysqli_connect.php'); // Connect to the db.

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

	// Check for the current password:
	if (empty($_POST['pass'])) {
		$errors[] = 'You forgot to enter your current password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($_POST['pass']));
	}

	// Check for a new password and match 
	// against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your new password did not match the confirmed password.';
		} else {
			$np = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'You forgot to enter your new password.';
	}

	if (empty($errors)) { // If everything's OK.

		// Check that they've entered the right email address/password combination:
		$query = "SELECT user_id FROM users WHERE (email='$email' AND pass=SHA2('$p',256) )";
		$result = @mysqli_query($dbc, $query);
		$num = @mysqli_num_rows($result);
		if ($num == 1) { // Match was made.

			// Get the user_id:
			$row = mysqli_fetch_array($result, MYSQLI_NUM);

			// Make the UPDATE query:
			$query = "UPDATE users SET pass=SHA2('$np',256) WHERE user_id=$row[0]";
			$result = @mysqli_query($dbc, $query);

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Print a message.
				redirect_user();
			} else { // If it did not run OK.

				// Public message:
				$errors[] = 'Your password could not be changed due to a system error. We apologize for any inconvenience.';

			}
		} else { // Invalid email address/password combination.
			$errors[] = 'The email address and password do not match those on file.';
		}
	}
	include('header.php');
} // End of the main Submit conditional.
?>
<form action="password" method="post">
	<div class="container py-5">
		<div class="row d-flex justify-content-center align-items-center">
			<div class="col-12 col-md-8 col-lg-6 col-xl-5">
				<div class="card bg-dark text-white" style="border-radius: 1rem;">
					<div class="card-body p-5 text-center">
						<h2 class="fw-bold mb-2 text-uppercase">Change Password</h2>
						<p class="text-white-50 mb-5">Please enter the required information to change your password</p>

						<div class="form-outline form-white mb-4">
							<label class="form-label" for="first_name">Email</label>
							<input type="text" name="email" class="form-control form-control-lg" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
						</div>

						<div class="form-outline form-white mb-4">
							<label class="form-label" for="pass">Old Password</label>
							<input type="password" name="pass" class="form-control form-control-lg" maxlength="20" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>">
						</div>

						<div class="form-outline form-white mb-4">
							<label class="form-label" for="pass1">New Password</label>
							<input type="password" name="pass1" class="form-control form-control-lg" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>">
						</div>

						<div class="form-outline form-white mb-4">
							<label class="form-label" for="pass2">Confirm Password</label>
							<input type="password" name="pass2" class="form-control form-control-lg" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>">
						</div>

						<button class="btn btn-outline-light btn-lg px-5" type="submit">Change Password</button>
						<?php
						if ($errors) {
							echo '<p class="error">The following error(s) occurred:<br />';
							foreach ($errors as $msg) { // Print each error.
								echo " - $msg<br />\n";
							}
							echo '</p><p>Please try again.</p>';

							mysqli_close($dbc);
							exit();
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<?php include('footer.php'); ?>