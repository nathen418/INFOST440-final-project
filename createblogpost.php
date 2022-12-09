<?php
// Needed imports to make guestbook work
$page_title = "Make a Post";
include('header.php');
$errors = array();
// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('mysqli_connect.php'); // Connect to the db.

	// Check for a first name:
	if (empty($_POST['title'])) {
		$errors[] = 'You forgot to enter a title for your post.';
	} else {
		$fname = mysqli_real_escape_string($dbc, trim($_POST['title']));
	}

	// Check for a last name:
	if (empty($_POST['body'])) {
		$errors[] = 'You forgot to enter a body for your post.';
	} else {
		$lname = mysqli_real_escape_string($dbc, trim($_POST['body']));
	}
    if (!$errors[0]){
        echo "<script> window.location.assign('index.php'); </script>";
    }
}
?>
<br />
<form action="createblogpost.php" method="POST">
    <section class="vh-100">
        <div class="container py-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <h2 class="fw-bold mb-2 text-uppercase">Write a Blog Post</h2>
                            <p class="text-white-50">Please fill out the required information to post</p>

                            <div class="form-outline form-white mb-4">
                                <label class="form-label" for="title">Title</label>
                                <input type="title" name="title" class="form-control form-control-lg" maxlength="128" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
                            </div>

                            <div class="form-outline form-white mb-4">
                                <label class="form-label" for="body">Post Body</label>
                                <textarea name="body" class="form-control form-control-lg" maxlength="20" value="<?php if (isset($_POST['body'])) echo $_POST['body']; ?>"></textarea>
                            </div>

                            <button class="btn btn-outline-light btn-lg px-5" type="submit">Post</button>
                            <?php
                            if ($errors) {
                                echo '<p class="error">The following error(s) occurred:<br />';
                                foreach ($errors as $msg) { // Print each error.
                                    echo " - $msg<br />\n";
                                }
                                echo '</p><p>Please try again.</p><p><br /></p>';

                                mysqli_close($dbc);
                                exit();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<?php
include('footer.php');
?>