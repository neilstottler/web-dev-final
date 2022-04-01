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

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Welcome</title>
	<link rel="stylesheet" href="css/nav-style.css">
	<link rel="stylesheet" href="css/global.css">

<body>

	<div class="Top">
		<div class="rt-container">
			<div class="col-rt-12">
				<div class="Scriptcontent">

					<div id="container">
						<nav>
							<ul>
								<li><a href="index.html">Home</a></li>
								<li><a href="AboutUs.html">About Us</a>
									<!-- First Tier Drop Down -->
									<ul>
										<li><a href="Contact.html">Contact</a></li>
										<!-- <li><a href="#">Tutorials</a></li> -->
									</ul>
								</li>
								<li><a href="YourBudget.html">Your Budget</a>
									<!-- First Tier Drop Down -->
									<ul>
										<li><a href="#">Enter Spending</a></li>
										<li><a href="#">Enter Income</a></li>
										<li><a href="#">See Spending</a>

											<ul>
												<li><a href="WeeklyBudgeting.html">Weekly</a></li>
												<li><a href="MonthlySpending.html">Montlhy</a></li>
												<li><a href="AnnualSpending.html">Annually</a>
													<!-- Third Tier Drop Down -->
													<!-- <ul>
										<li><a href="#">Stuff</a></li>
										<li><a href="#">Things</a></li>
										<li><a href="#">Other Stuff</a></li>
									</ul> -->
												</li>
											</ul>
										</li>
									</ul>
								</li>
								<!-- <li><a href="#">Inspiration</a></li> -->


							</ul>
						</nav>
					</div>


				</div>
			</div>
		</div>
	</div>

	<h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
	<p>
		<a href="reset-password.php">Reset Your Password</a>
		<a href="logout.php">Sign Out of Your Account</a>
		<a href="adddata.php">Add Data</a><br>
	</p>

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
		$userid = $itemname = $itemprice = $datebought = $location = $notes = "";
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
		$query2 = "SELECT * FROM item_table WHERE user_id = " . $userid;
		$result_items = mysqli_query($link, $query2);

		//debugging shit
		if (mysqli_num_rows($result_items) > 0) {
			// output data of each row
			while ($row = mysqli_fetch_assoc($result_items)) {
				echo ('<tr>');
				echo ('<td>' . $row["item_name"] . '</td>');
				echo ('<td>' . $row["price"] . '</td>');
				echo ('<td>' . $row["date_bought"] . '</td>');
				echo ('<td>' . $row["location"] . '</td>');
				echo ('<td>' . $row["notes"] . '</td>');
				echo ('</tr>');
			}
		} else {
			echo "0 results";
		}
		?>
	</table>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		google.charts.load('current', {
			packages: ['corechart', 'line']
		});
		google.charts.setOnLoadCallback(drawBackgroundColor);

		function drawBackgroundColor() {
			var data = new google.visualization.DataTable();
			data.addColumn('number', 'X');
			data.addColumn('number', 'Dogs');

			data.addRows([
				[0, 0],
				[1, 10]
			]);

			var options = {
				hAxis: {
					title: 'Time'
				},
				vAxis: {
					title: 'Popularity'
				},
				backgroundColor: '#f1f8e9'
			};

			var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
	</script>

	<div id="chart_div"></div>


</body>

</html>