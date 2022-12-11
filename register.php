<?php
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Register | bLog';
include('header.php');
$errors = array();
?>
<form action="register.php" method="post">
	<div class="container py-5">
		<div class="row d-flex justify-content-center align-items-center">
			<div class="col-12 col-md-8 col-lg-6 col-xl-5">
				<?php
				// Check for form submission:
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					require('mysqli_connect.php'); // Connect to the db.

					// Check for a first name:
					if (empty($_POST['first_name'])) {
						$errors[] = 'You forgot to enter your first name.';
					} else {
						$fname = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
					}

					// Check for a last name:
					if (empty($_POST['last_name'])) {
						$errors[] = 'You forgot to enter your last name.';
					} else {
						$lname = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
					}

					// Check for an email address:
					if (empty($_POST['email'])) {
						$errors[] = 'You forgot to enter your email address.';
					} else {
						$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
					}

					// Check for a password and match against the confirmed password:
					if (!empty($_POST['pass1'])) {
						if ($_POST['pass1'] != $_POST['pass2']) {
							$errors[] = 'Your password\'s do not match.';
						} else {
							$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
						}
					} else {
						$errors[] = 'You forgot to enter your password.';
					}

					if (empty($errors)) {
						// Register the user in the database...

						// Make the query:
						$query = "INSERT INTO users (first_name, last_name, email, pass) VALUES ('$fname', '$lname', '$email', SHA2('$p',256))";
						$result = @mysqli_query($dbc, $query); // Run the query.
						if ($result) { // If it ran OK.
							mysqli_close($dbc); // Close the database connection.
							$fname = '';
							$lname = '';
							$email = '';
							$p = '';
				?>
							<div class="alert alert-success text-center">
								<p>Account has been created, you can now log in!
							</div>
				<?php
						}
					}
				}
				?>

				<div class="card bg-dark text-white" style="border-radius: 1rem;">
					<div class="card-body px-5 text-center">
						<h2 class="fw-bold mb-2 text-uppercase">Register</h2>
						<p class="text-white-50">Please enter the required information to sign up.</p>

						<div class="form-outline form-white mb-4">
							<label class="form-label" for="first_name">First Name</label>
							<input type="text" name="first_name" class="form-control form-control-lg" maxlength="20" value="<?php if (isset($fname)) echo stripcslashes($fname); ?>">
						</div>

						<div class="form-outline form-white mb-4">
							<label class="form-label" for="last_name">Last Name</label>
							<input type="text" name="last_name" class="form-control form-control-lg" maxlength="40" value="<?php if (isset($lname)) echo stripcslashes($lname); ?>">
						</div>

						<div class="form-outline form-white mb-4">
							<label class="form-label" for="first_name">Email</label>
							<input type="email" name="email" class="form-control form-control-lg" maxlength="60" value="<?php if (isset($email)) echo stripcslashes($email); ?>">
						</div>

						<div class="form-outline form-white mb-4">
							<label class="form-label" for="first_name">Password</label>
							<input type="password" name="pass1" class="form-control form-control-lg" maxlength="20">
						</div>

						<div class="form-outline form-white mb-4">
							<label class="form-label " for="first_name">Confirm Password</label>
							<input type="password" name="pass2" class="form-control form-control-lg" maxlength="20">
						</div>

						<button class="btn btn-outline-light btn-lg px-5" type="submit">Sign Up</button>
						<?php
						if ($errors) {
							echo '<p class="error">The following error(s) occurred:<br />';
							foreach ($errors as $msg) { // Print each error.
								echo " - $msg<br />\n";
							}
							echo '</p><p>Please try again.</p><p><br /></p>';

							mysqli_close($dbc);
						}
						?>
						<p class="mb-0">Already have an account? <a href="login.php" class="text-white-50 fw-bold">Log In</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<?php include('footer.php'); ?>