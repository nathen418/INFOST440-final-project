<?php # Script 12.1 - login_page.inc.php
// This page prints any errors associated with logging in
// and it creates the entire login page, including the form.

// Include the header:
$page_title = 'Login';
include('header.php');
?>

<!-- Login form -->
<form action="login.php" method="post">
	<section class="vh-100">
		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-8 col-lg-6 col-xl-5">
					<div class="card bg-dark text-white" style="border-radius: 1rem;">
						<div class="card-body p-5 text-center">
							<div class="mb-md-5 mt-md-4 pb-5">
								<h2 class="fw-bold mb-2 text-uppercase">Login</h2>
								<p class="text-white-50 mb-5">Please enter your username and password!</p>

								<div class="form-outline form-white mb-4">
									<input type="email" name="email" class="form-control form-control-lg" maxlength="60" />
									<label class="form-label" for="email">Email</label>
								</div>

								<div class="form-outline form-white mb-4">
									<input type="password" name="pass" class="form-control form-control-lg" maxlength="20">
									<label class="form-label" for="password">Password</label>
								</div>
								<button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
								<?php
								// Print any error messages, if they exist:
								if (isset($errors) && !empty($errors)) {
									echo '<h5>Error!</h5>
									<p class="error">The following error(s) occurred:<br />';
									foreach ($errors as $msg) {
										echo " - $msg<br />\n";
									}
									echo '</p><p>Please try again.</p>';
								}
								?>
							</div>
							<div>
								<p class="mb-0">Don't have an account? <a href="register.php" class="text-white-50 fw-bold">Sign Up</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</form>

<?php include('footer.php'); ?>