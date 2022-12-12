<?php
require('includes/non_admin_redirect.inc.php');
require('mysqli_connect.php');

// Redirect user back to the index if no id was provided. e.g. if user typed in the URL manually
if (empty($_GET['id'])) {
    redirect_user();
}
// Get the ID from the URL path
$delete_id = isset($_GET['id']) ? $_GET['id'] : '';
// Make the query
$query = "SELECT * FROM blogposts WHERE blogpost_id = '$delete_id'";
$result = mysqli_query($dbc, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_REQUEST['cancelbtn'])) {
        // Delete the blogpost and delete all the comments associated with it
        $delete = "DELETE FROM blogposts WHERE blogpost_id = '$delete_id'";
        $deleteComments = "DELETE FROM comments WHERE blogpost_id = '$delete_id'";
        $commemtResults = mysqli_query($dbc, $deleteComments);
        $results = mysqli_query($dbc, $delete);
        // Set the session message to let the user know if it was deleted successfully
        $_SESSION['message'] = "Blog post successfully deleted!";
    } else {
        redirect_user();
    }
}
$page_title = 'Delete Post | bLog';
include('header.php');


while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
?>
    <form action="<?php echo "delete?id=" . $delete_id; ?>" method="POST">
        <!-- Create a container where the cards will live -->
        <div class="container py-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo '<div class="alert alert-success text-center">' . $_SESSION['message'] . '</div>';
                        $_SESSION['message'] = null;
                    ?>
                        <!-- Make a card that takes the user back to the home page if the deletion was successful -->
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <h2 class="fw-bold mb-2 text-uppercase">Return Home?</h2>
                                <a href="index.php" class="btn btn-success">Go to Home</a>

                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <!-- Show the default card where the user hasn't selected the confirm delete button -->
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <h2 class="fw-bold mb-2 text-uppercase">Delete Blog Post</h2>
                                <p class="text-white-50">Are you sure you want to delete this post?</p>

                                <div class="form-outline form-white mb-4">
                                    <h5>Title</h5>
                                    <p class="text-white-50"><?php echo $row['blogpost_title']; ?></p>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <h5>Post Body</h5>
                                    <p class="text-white-50"><?php echo $row['blogpost_body']; ?></p>
                                </div>

                                <button class="btn btn-outline-danger btn-lg px-5" type="submit">Delete</button>
                                <button class="btn btn-outline-light btn-lg px-5" name="cancelbtn" type="submit">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </form>
<?php
}
include('footer.php');
?>