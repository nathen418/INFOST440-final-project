<?php
	//header
	$page_title = 'Home';
	include('header.php');
	include('mysqli_connect.php');

	//If a user name is entered display login message
	if (isset($_SESSION['first_name'])) {
		echo "You currently logged in as {$_SESSION['first_name']}. Welcome to our website!";
	}
	// Display a list of posts here
	// On each post, there should be a link to view the post and comments, and a link to add a comment. If the user is logged in, there should be a link to edit the post and delete the post if it was made by the logged in user. 

	// Display a few buttons that allow for the posts to be sorted
	// Number of records to show per page:
	$display = 5;
	// Determine how many pages there are...
	if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
		$pages = $_GET['p'];
	} else { // Need to determine.
		// Count the number of records:
		$query = "SELECT COUNT(blogpost_id) FROM blogposts";
		$result = mysqli_query ($dbc, $query);
		$rowPage = mysqli_fetch_array ($result, MYSQLI_NUM);
		$records = $rowPage[0];

		// Calculate the number of pages...
		if ($records > $display) { // More than 1 page.
			$pages = ceil ($records/$display);
		} else {
			$pages = 1;
		}
	}

	// Determine where in the database to start returning results...
	if (isset($_GET['s']) && is_numeric($_GET['s'])) {
		$start = $_GET['s'];
	} else {
		$start = 0;
	}

	// Determine the sort...
	// Default is by registration date.
	$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'date';

	// Determine the sorting order:
	switch ($sort) {
		case 'recent':
			$order_by = 'blogpost_timestamp DESC';
			break;
		case 'oldest':
			$order_by = 'blogpost_timestamp ASC';
			break;
		default:
			$order_by = 'blogpost_timestamp DESC';
			$sort = 'recent';
			break;
	}
?>

<!-- Sort Menu -->
<div id="sort">
	<strong>Sort By: </strong>
	<a href="?sort=recent">Most Recent</a> | 
	<a href="?sort=oldest">Oldest</a>
</div>

<p>Here are the Guestbook Comments!</p>

<?php
	// Fetches all blogposts, then generates cards
	$query = "SELECT * FROM blogposts ORDER BY $order_by LIMIT $start, $display";
	$results = mysqli_query($dbc, $query);

	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
?>

<div class="card">
	<div class="header">
		<h1><?php echo $row['blogpost_title']; ?></h1>
		<p><?php echo $row['blogpost_id']; ?></p>
	</div>
	<div class="blogpost_content">
		<p class="body"><?php echo $row['blogpost_body']; ?></p>
		<p class="timestamp"><?php echo $row['blogpost_timestamp']; ?></p>
		<p>
			<a href=<?php echo "viewcomments.php?blogpost_id=" . $row['blogpost_id']; ?>>View Comments</a> |
			<a href=<?php echo "update.php?id=" . $row['blogpost_id']; ?>>Edit</a> | 
			<a href=<?php echo "delete.php?id=" . $row['blogpost_id']; ?>>Delete</a>
		</p>
	</div>
</div>

<?php
	}

	// Make the links to other pages, if necessary.
	if ($pages > 1) {
		echo '<br /><p>';
		$current_page = ($start/$display) + 1;

		// If it's not the first page, make a Previous button:
		if ($current_page != 1) {
			echo '<a href="?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
		}

		// Make all the numbered pages:
		for ($i = 1; $i <= $pages; $i++) {
			if ($i != $current_page) {
				echo '<a href="?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
			} else {
				echo $i . ' ';
			}
		} // End of FOR loop.

		// If it's not the last page, make a Next button:
		if ($current_page != $pages) {
			echo '<a href="?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
		}

		echo '</p>'; // Close the paragraph.

	} // End of links section.

	include('footer.php');
?>