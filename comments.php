<?php
$page_title = "View Post | bLog";

include('mysqli_connect.php');
include('includes/login_functions.inc.php');
// Get whatever information you need from either GET, SESSION, or POST
$blogid = mysqli_real_escape_string($dbc, trim($_GET['blogpost_id']));
$updateid = isset($_GET['update_id']) ? mysqli_real_escape_string($dbc, trim($_GET['update_id'])) : '';
$deleteid = isset($_GET['delete_id']) ? mysqli_real_escape_string($dbc, trim($_GET['delete_id'])) : '';

session_start();
// Delete comment check
if (isset($_GET['delete_id'])) {
    // Gets user id of comment to be deleted

    $query = "SELECT user_id FROM comments WHERE comment_id = '$deleteid'";
    $result = mysqli_query($dbc, $query);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $row['user_id'] || $_SESSION['is_admin'] == 1)) {
            // Only the author of the comment or admin can delete
            $deleteQuery = "DELETE FROM comments WHERE comment_id = '$deleteid'";
            mysqli_query($dbc, $deleteQuery);
            $_SESSION['message'] = 'delete';
        } else {
            // Otherwise they get redirected to the original blogpost page
            $_SESSION['message'] = false;
            redirect_user('comments?blogpost_id=' . $blogid);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_REQUEST['commentbtn'])) {
        $valid_form = true;

        $comment = isset($_REQUEST['comment']) ?
            mysqli_real_escape_string($dbc, trim($_POST['comment'])) : '';

        if ($comment == '') {
            $_SESSION['message'] = 'empty';
            $valid_form = false;
        }

        if ($valid_form) {
            $id = $_SESSION['user_id'];
            $_SESSION['message'] = 'add';
            $query = "INSERT INTO comments (blogpost_id, user_id, comment_body) VALUES ('$blogid', '$id', '$comment')";
            $results = mysqli_query($dbc, $query);
        }
    } else if (isset($_REQUEST['cancelbtn'])) {
        redirect_user('comments?blogpost_id=' . $blogid);
    } else {
        $valid_form = true;

        $update = isset($_REQUEST['update']) ?
            mysqli_real_escape_string($dbc, trim($_POST['update'])) : '';

        $updateid = $_REQUEST['id'];

        if ($update == '') {
            $_SESSION['message'] = 'empty';
            $valid_form = false;
        }

        if ($valid_form) {
            $_SESSION['message'] = 'edit';
            $query = "UPDATE comments SET comment_body = '$update' WHERE comment_id = '$updateid'";
            mysqli_query($dbc, $query);
            $updateid = '';
        }
    }
}

include('header.php');
$blogpostQuery = "SELECT * FROM blogposts WHERE blogpost_id = $blogid";
$blogpostResult = mysqli_query($dbc, $blogpostQuery);

//Your SQL Query
$queryComments = "SELECT * FROM comments JOIN users USING (user_id) WHERE blogpost_id = $blogid";
$commentResult = mysqli_query($dbc, $queryComments);

while ($row = mysqli_fetch_array($blogpostResult, MYSQLI_ASSOC)) {
?>
    <p class="h2 text-center text-white" style="margin-top:4rem">View & Add Comments</p>

    <?php
    // Prints messages to give user feedback on actions
    if (isset($_SESSION['message'])) {
        switch ($_SESSION['message']) {
            case 'add':
                echo '<div class="alert alert-success text-center">Comment successfully added!</div>';
                break;
            case 'edit':
                echo '<div class="alert alert-success text-center">Comment successfully edited!</div>';
                break;
            case 'delete':
                echo '<div class="alert alert-success text-center">Comment successfully deleted!</div>';
                break;
            case 'empty':
                echo '<div class="alert alert-danger text-center">Your comment cannot be empty!</div>';
                break;
            default:
                echo '<div class="alert alert-danger text-center">You do not have permission for this action!</div>';
        }
        // Empty message so message does not reappear
        $_SESSION['message'] = null;
    }
    ?>

    <div class="card bg-dark text-white">
        <div class="card-body">
            <h5 class="card-title"><?php echo $row['blogpost_title']; ?> | ID <?php echo $row['blogpost_id']; ?></h5>
            <p class="card-text"><?php echo $row['blogpost_body']; ?></p>
            <p class="card-text">Timestamp: <?php echo $row['blogpost_timestamp']; ?></p>
        <?php
    }
    if (isset($_SESSION['user_id'])) {
        // Form not visible if user is not logged in
        ?>
            <form style="margin-top:2rem" action=<?php echo "comments?blogpost_id=" . $blogid; ?> method="post">
                <label class="form-label" for="comment">New Comment</label>
                <div class="form-outline form-white mb-4">
                    <textarea name="comment" id="comment" class="form-control form-control-lg" maxlength="1024"><?php if (isset($_POST['comment'])) echo $_POST['comment']; ?></textarea>
                </div>
                <input class="btn btn-primary" name="commentbtn" type="submit" value="Add Comment">
            <form>
            <?php
            }
                ?>
        </div>
    </div>

    <div id="comments-container" class="text-light">
        <h2 class="text-center">Comments:</h2>
        <?php
        //Your loop to display everything
        while ($row = mysqli_fetch_array($commentResult, MYSQLI_ASSOC)) {
        ?>
            <div class="card bg-dark text-white p-1">
                <div class="card-body">
                    <?php
                    if (
                        isset($_SESSION['user_id']) && isset($updateid) && $row['comment_id'] == $updateid &&
                        ($_SESSION['is_admin'] == 1 || $_SESSION['user_id'] == $row['user_id'])
                    ) {
                    ?>
                        <form style="margin-top:2rem" action=<?php echo "comments?blogpost_id=" . $row['blogpost_id']; ?> method="post">
                            <label class="form-label" for="update">Edit Comment</label>
                            <div class="form-outline form-white mb-4">
                                <input style="display: none;" name="id" value="<?php echo $row['comment_id'] ?>">
                                <textarea name="update" id="update" class="form-control form-control-lg" maxlength="1024"><?php echo $row['comment_body']; ?></textarea> <!-- This is not sticky on purpose so as to make spam posting comments harder -->
                            </div>
                            <input class="btn btn-primary" type="submit" value="Edit Comment">
                            <button class="btn btn-danger" name="cancelbtn">Cancel</button>
                            <form>
                            <?php
                        } else {
                            ?>
                                <h5 class="card-title"><?php echo $row['first_name'];
                                                        if ($row['is_admin'] == 1) echo '  <span style="color: red;">(Admin)</span>'; ?></h5>
                                <p class="card-text"><?php echo $row['comment_body']; ?></p>

                                <?php
                                if (isset($_SESSION['user_id']) && ($_SESSION['is_admin'] == 1 || $_SESSION['user_id'] == $row['user_id'])) {
                                ?>
                                    <a href=<?php echo "comments?blogpost_id=" . $row['blogpost_id'] . "&update_id=" . $row['comment_id']; ?> class="btn btn-warning">Edit</a>
                                    <a href=<?php echo "comments?blogpost_id=" . $row['blogpost_id'] . "&delete_id=" . $row['comment_id']; ?> class="btn btn-danger">Delete</a>
                                <?php
                                }
                                ?>
                </div>
            </div>
    <?php
                        }
                    }
    ?>
    </div>