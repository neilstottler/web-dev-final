<?php
//this is our config file so I can put this on github without creds
require_once "config.php";

session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login.php");
	exit;
}
?>

<script>
	//my stuff
	const graphprice = [];
	const graphdate = [];
</script>

<style>
	table,
	th,
	td {
		border: 1px solid;
	}
</style>
<article class="center-block">
	<table>
		<tr>
			<th>Item Name</th>
			<th>Price</th>
			<th>Date Bought</th>
			<th>Location</th>
			<th>Additional Notes</th>
		</tr>
		<?php
		//define variables
		$jsdate = $jsprice = $userid = $itemname = $itemprice = $datebought = $location = $notes = "";
		$itemname_err = $itemprice_err = $datebought_err = $location_err = $notes_err = "";
		$username = $_SESSION["username"];

		//userid query
		$query = "SELECT user_id FROM accounts where username = '" . $username . "'";
		$result_id = mysqli_query($link, $query);

		//grab user ID from object thing and store it
		if (mysqli_num_rows($result_id) > 0) {
			// output data of each row
			while ($row = mysqli_fetch_assoc($result_id)) {
				$userid = $row["user_id"];
			}
		} else {
			echo "0 results";
		}

		//query DB for that specific
		$query2 = "SELECT * FROM item_table WHERE user_id = " . $userid . " ORDER BY date_bought ASC";
		$result_items = mysqli_query($link, $query2);

		//debugging shit
		if (mysqli_num_rows($result_items) > 0) {
			// output data of each row
			while ($row = mysqli_fetch_assoc($result_items)) {
				echo ('<tr>');
				echo ('<td id="itemname">' . $row["item_name"] . '</td>');
				echo ('<td id="price">' . $row["price"] . '</td>');
				echo ('<td id="datebought">' . $row["date_bought"] . '</td>');
				echo ('<td id="location">' . $row["location"] . '</td>');
				echo ('<td id="notes">' . $row["notes"] . '</td>');
				echo ('</tr>');

				//convert php vars into JS vars
				echo ("
					<script>
						graphprice.push(" . $row["price"] . ");
						graphdate.push(" . json_encode($row["date_bought"]) . ");
			
					</script>
				");
			}
		} else {
			echo "0 results";
		}

		?>
	</table>

	<!-- scripts for table -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="js/linechart.js"></script>
	<script type="text/javascript" src="js/calendar.js"></script>

	<!-- graph stuff -->
	<br>
	<button id="change">Click to change the format</button>
	<div id="chart_div"></div>

	<div id="calendar_basic" style="width: 1000px; height: 450px;"></div>


</article>