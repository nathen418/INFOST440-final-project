<?php
require('includes/non_admin_redirect.inc.php');
require('mysqli_connect.php');

$delete_id = isset($_GET['id']) ? $_GET['id'] : '';

$query = "SELECT * FROM blogposts WHERE blogpost_id = '$delete_id'";
$result = mysqli_query($dbc, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_REQUEST['cancelbtn'])) {
        $delete = "DELETE FROM blogposts WHERE blogpost_id = '$delete_id'";
        $results = mysqli_query($dbc, $delete);
        $_SESSION['message'] = "Blog post successfully deleted!";
    } else {
        redirect_user();
    }
}
$page_title = 'Delete Post | bLog';
include('header.php');

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
?>
<form action="<?php echo "delete.php?id=" . $delete_id; ?>" method="POST">
    <section class="vh-100">
        <div class="container py-5">
            <?php
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-success text-center">' . $_SESSION['message'] . '</div>';
                    $_SESSION['message'] = null;
                }
            ?>
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
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
                </div>
            </div>
        </div>
    </section>
</form>
<?php
}
include('footer.php');
?>
