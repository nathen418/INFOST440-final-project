<?php
//header
$page_title = 'Home | bLog';
include('header.php');
include('mysqli_connect.php');
?>
<p class="h2 text-center text-white" style="margin-top:4rem">bLog</p>
<p class="h4 text-center text-white">The less useful version of wordpress</p>
<?php

// Code to handle pagination
$display = 5;
// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
	$pages = $_GET['p'];
} else {
	// Count the number of records:
	$query = "SELECT COUNT(blogpost_id) FROM blogposts";
	$result = mysqli_query($dbc, $query);
	$rowPage = mysqli_fetch_array($result, MYSQLI_NUM);
	$records = $rowPage[0];

	// Calculate the number of pages...
	if ($records > $display) {
		$pages = ceil($records / $display);
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
<div class="text-white" id="sort">
	<strong>Sort By:</strong>
	<a href="?sort=recent" class="btn btn-primary">Newest</a> |
	<a href="?sort=oldest" class="btn btn-primary">Oldest</a>
</div>
<?php

// Fetch all the blogposts
$query = "SELECT * FROM blogposts JOIN users USING (user_id) ORDER BY $order_by LIMIT $start, $display";
$results = mysqli_query($dbc, $query);

// Loop Through the blogposts and create cards for them
while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
?>

	<div class="card bg-dark text-white p-1" , style="margin-top:1rem">
		<div class="card-body">
			<h5 class="card-title"><?php echo $row['blogpost_title']; ?> | By: <?php echo $row['first_name']; ?></h5>
			<p class="card-text"><?php echo $row['blogpost_body']; ?></p>
			<a href=<?php echo "comments.php?blogpost_id=" . $row['blogpost_id']; ?> class="btn btn-success">View Post</a>

			<?php
			if (isset($_SESSION['user_id']) && $_SESSION['is_admin'] == 1) {
			?>
				<!-- Edit and Delete buttons for each posts if admin -->
				<a href=<?php echo "update.php?id=" . $row['blogpost_id']; ?> class="btn btn-warning">Edit</a>
				<a href=<?php echo "delete.php?id=" . $row['blogpost_id']; ?> class="btn btn-danger">Delete</a>
			<?php
			}
			?>
		</div>
	</div>

<?php
}

// Make the links to other pages, if necessary.
if ($pages > 1) {
	echo '<br /><div id="pages-container"><p>';
	$current_page = ($start / $display) + 1;

	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '"><button type="button" class="btn btn-dark">Previous</button></a> ';
	}

	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '"><button type="button" class="btn btn-dark">' . $i . '</button></a> ';
		} else {
			echo '<button type="button" class="btn btn-dark" disabled>' . $i . '</button> ';
		}
	}

	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '"><button type="button" class="btn btn-dark">Next</button></a>';
	}

	echo '</p></div>';

}
include('footer.php');
?>