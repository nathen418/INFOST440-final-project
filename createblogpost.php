<?php
    // Needed imports to make guestbook work
    include('header.php');
    include('mysqli_connect.php');
?>

<?php
    // Values from comment form
    $fname = isset($_REQUEST['fname']) ? mysqli_real_escape_string($dbc, trim($_POST['fname'])) : '';
    $lname = isset($_REQUEST['lname']) ? mysqli_real_escape_string($dbc, trim($_POST['lname'])) : '';
    $comment = isset($_REQUEST['comment']) ? mysqli_real_escape_string($dbc, trim($_POST['comment'])) : '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Form validation
        $valid_form = true;

        if ($fname == '') {
            $valid_form = false;
            echo "<p>Please fill out 'First Name' field!</p>";
        }

        if ($lname == '') {
            $valid_form = false;
            echo "<p>Please fill out 'Last Name' field!</p>";
        }

        if ($comment == '') {
            $valid_form = false;
            echo "<p>Please leave a comment!</p>";
        }

        // Only if form is valid, then send query to MySQL database
        if ($valid_form) {
            $query = "INSERT INTO guestbook (fname, lname, comment) VALUES ('$fname', '$lname', '$comment')";
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
<form action="comment.php" method="post">
    <fieldset>
        <legend>Please enter your guestbook entry:</legend>
        <p>
            <label for="fname">First Name: </label>
            <input type="text" name="fname" id="fname" value="<?php
                if (isset($fname)) {
                    echo stripcslashes($fname);
                }
            ?>">
        </p>
        <p>
            <label for="lname">Last Name: </label>
            <input type="text" name="lname" id="lname" value="<?php
                if (isset($lname)) {
                    echo stripcslashes($lname);
                }
            ?>">
        </p>
        <p>
            <label for="comment">Please enter a comment: </label><br />
            <textarea name="comment" id="comment" cols="40" rows="5"><?php
                if (isset($comment)) {
                    echo stripcslashes($comment);
                }
            ?></textarea>
        </p>

        <input type="submit" value="Submit">
    </fieldset>

</form>
<?php
    include('footer.php');
?>