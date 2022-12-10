<?php
    include('./includes/login_functions.inc.php');
    // if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    //     redirect_user();
    // }
    $page_title = 'Edit Post | bLog';
    include('header.php');
    include('mysqli_connect.php');
?>

<?php
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
            echo "<p>Please input an updated blogpost title!</p>";
        }

        if ($body == '') {
            $valid_form = false;
            echo "<p>Please input an updated blogpost title!</p>";
        }

        // Only if form is valid, then send query to MySQL database
        if ($valid_form) {
            $query = "UPDATE blogposts SET blogpost_body = '$body', blogpost_title = '$title' 
                WHERE blogpost_id = '$id'";
            $results = mysqli_query($dbc, $query);

            if ($results) {
                echo "It worked! The SQL query was run!";
            } else {
                echo "There was an error: " . mysqli_error($dbc);
            }
        }
    }
?>
<br />
<form action="update.php?id=<?php echo $id; ?>" method="post">
    <fieldset>
        <legend>Update blogpost here:</legend>

        <p>
            <label for="title">Change blogpost title:</label><br />
            <input type="text" name="title" id="title" value="<?php 
                if (isset($title)) {
                    echo stripcslashes($title);
                }
            ?>">
        </p>

        <p>
            <label for="body">Change blogpost body: </label><br />
            <textarea name="body" id="body" cols="40" rows="5"><?php
                if (isset($body)) {
                    echo stripcslashes($body);
                }
            ?></textarea>
        </p>

        <input type="submit" value="Submit">
    </fieldset>

</form>
<?php
    include('footer.php');
?>