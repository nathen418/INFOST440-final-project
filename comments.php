<?php
$page_title = "View Post | bLog";
include('header.php');
include('mysqli_connect.php');

//Get whatever information you need from either GET, SESSION, or POST
$blogid = mysqli_real_escape_string($dbc, trim($_GET['blogpost_id']));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valid_form = true;

    $comment = isset($_REQUEST['comment']) ? 
        mysqli_real_escape_string($dbc, trim($_POST['comment'])) : '';

    if ($comment == '') {
        $valid_form = false;
    }

    if ($valid_form) {
        $id = $_SESSION['user_id'];
        $query = "INSERT INTO comments (blogpost_id, user_id, comment_body) VALUES ('$blogid', '$id', '$comment')";
        $results = mysqli_query($dbc, $query);
    }
}

$blogpostQuery = "SELECT * FROM blogposts WHERE blogpost_id = $blogid";
$blogpostResult = mysqli_query($dbc, $blogpostQuery);

//Your SQL Query
$queryComments = "SELECT * FROM comments JOIN users USING (user_id) WHERE blogpost_id = $blogid";
$commentResult = mysqli_query($dbc, $queryComments);

while ($row = mysqli_fetch_array($blogpostResult, MYSQLI_ASSOC)) {
?>
<p class="h2 text-center text-white" style="margin-top:4rem">View & Add Comments</p>

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
        <form style="margin-top:2rem" action=<?php echo "comments.php?blogpost_id=" . $blogid; ?> method="post">
            <label class="form-label" for="comment">New Comment</label>
            <div class="form-outline form-white mb-4">
                <textarea name="comment" id="comment" class="form-control form-control-lg" maxlength="1024" value="<?php if (isset($_POST['comment'])) echo $_POST['comment']; ?>"></textarea>
            </div>
            <input class="btn btn-primary" type="submit" value="Add Comment">
        <form>

<?php
}
?>
</div>
</div>


<div id="comments-container" class="card bg-dark text-white">
    <h2>Comments:</h2>
<?php
//Your loop to display everything
while ($row = mysqli_fetch_array($commentResult, MYSQLI_ASSOC)) {
?>
    <div class="card bg-dark text-white">
        <div class="card-body">
            <!-- Change user_id to have their first name -->
            <h5 class="card-title"><?php echo $row['first_name']; ?></h5>
            <p class="card-text"><?php echo $row['comment_body']; ?></p>

            <?php
                if (isset($_SESSION['user_id']) && ($_SESSION['is_admin'] == 1 || $_SESSION['user_id'] == $row['user_id'])) {
            ?>

                <!-- Make these buttons functional -->
                <a href=<?php ?> class="btn btn-warning">Edit</a>
                <a href=<?php ?> class="btn btn-danger">Delete</a>
            <?php
                }
            ?>
        </div>
    </div>
<?php
}
?>
</div>
