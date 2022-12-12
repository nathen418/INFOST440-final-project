<?php
include('./includes/non_admin_redirect.inc.php');
$page_title = 'Edit Post | bLog';
include('mysqli_connect.php');
$errors = array();

// Redirect user back to the index if no id was provided. e.g. if user typed in the URL manually
if (empty($_GET['id'])) {
    redirect_user();
}
// Get Id from URL path
$id = isset($_GET['id']) ? $_GET['id'] : '';

$query = "SELECT * FROM blogposts WHERE blogpost_id = '$id'";
$results = mysqli_query($dbc, $query);

// Get values from query
while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
    $body = $row['blogpost_body'];
    $title = $row['blogpost_title'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form validation
    $valid_form = true;

    $title = isset($_REQUEST['title']) ?
        mysqli_real_escape_string($dbc, trim($_POST['title'])) : '';

    $body = isset($_REQUEST['body']) ?
        mysqli_real_escape_string($dbc, trim($_POST['body'])) : '';

    if ($title == '') {
        $valid_form = false;
        $errors[] = 'Please input an updated blogpost title!';
    }

    if ($body == '') {
        $valid_form = false;
        $errors[] = 'Please input an updated blogpost body!';
    }

    // Only if form is valid, then send query to MySQL database
    if ($valid_form) {
        $query = "UPDATE blogposts SET blogpost_body = '$body', blogpost_title = '$title' WHERE blogpost_id = '$id'";
        mysqli_query($dbc, $query);
        redirect_user();
    } else {
        $errors[] = "There was an error: " . mysqli_error($dbc);
    }
}
include('header.php');
?>
<br />
<form action="update?id=<?php echo $id; ?>" method="POST">
    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <h2 class="fw-bold mb-2 text-uppercase">Update a Post</h2>
                        <p class="text-white-50">Please fill out the required information to update your post</p>

                        <div class="form-outline form-white mb-4">
                            <label class="form-label" for="title">Change blogpost title:</label>
                            <input type="title" name="title" class="form-control form-control-lg" maxlength="128" value="<?php if (isset($title)) {
                                                                                                                                echo stripcslashes($title);
                                                                                                                            } ?>">
                        </div>

                        <div class="form-outline form-white mb-4">
                            <label class="form-label" for="body">Change blogpost body:</label>
                            <textarea name="body" class="form-control form-control-lg"><?php if (isset($title)) {
                                                                                            echo stripcslashes($body);
                                                                                        } ?></textarea>
                        </div>

                        <button class="btn btn-outline-light btn-lg px-5" type="submit">Post</button>
                        <?php
                        if ($errors) {
                            echo '<p class="error">The following error(s) occurred:<br/>';
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
<?php
include('footer.php');
?>