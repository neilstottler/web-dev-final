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

	<script>
		//my stuff
		const graphprice = [];
		const graphdate = [];
	</script>

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

	<article class="center-block">
		<h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
		<p>
			<a href="reset-password.php">Reset Your Password</a>
			<a href="logout.php">Sign Out of Your Account</a>
			<a href="adddata.php">Add Data</a><br>
		</p>
		<style>
			table, th, td {
				border: 1px solid;
			}
		</style>
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
			$query2 = "SELECT * FROM item_table WHERE user_id = " .$userid. " ORDER BY date_bought ASC";
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
</body>

</html>