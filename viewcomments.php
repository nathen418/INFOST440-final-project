<?php
    $page_title = "View Comments";
    include('header.php');
    include('mysqli_connect.php');

    //Get whatever information you need from either GET, SESSION, or POST
    $blogid = mysqli_real_escape_string($dbc, trim($_GET['blogpost_id']));

    $blogpostQuery = "SELECT * FROM blogposts WHERE blogpost_id = $blogid";
    $blogpostResult = mysqli_query($dbc, $blogpostQuery);

    //Your SQL Query
    $queryComments = "SELECT * FROM comments WHERE blogpost_id = $blogid";
    $commentResult = mysqli_query($dbc, $queryComments);

    while ($row = mysqli_fetch_array($blogpostResult, MYSQLI_ASSOC)) {
?>

<div class="card">
	<div class="header">
		<h1><?php echo $row['blogpost_title']; ?></h1>
	</div>
	<div class="blogpost_content">
		<p class="body"><?php echo $row['blogpost_body']; ?></p>
		<p class="timestamp"><?php echo $row['blogpost_timestamp']; ?></p>
	</div>
</div>

<!-- Need to hide if user is not logged in -->
<p>Add Comment</p>
<form action=<?php echo "viewcomments.php?blogpost_id=" . $blogid;?> method="post">
    <textarea name="comment" id="comment" cols="40" rows="5"></textarea><br />
    <input type="submit" value="Add Comment">
<form>

<?php
    }
    //Your loop to display everything
    while ($row = mysqli_fetch_array($commentResult, MYSQLI_ASSOC)) {
?>

<?php
}

?>