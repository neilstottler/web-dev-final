<?php

//this is our config file so I can put this on github without creds
require_once "config.php";

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
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

    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site. Add Data.</h1>
    <p>
        <a href="reset-password.php">Reset Your Password</a>
        <a href="logout.php">Sign Out of Your Account</a><br>
		<a href="viewdata.php">View Data</a><br>
    </p>

	<!-- add that data -->
	<?php 
	
	//define variables
	$userid = $itemname = $itemprice = $datebought = $location = $notes = NULL;
	$itemname_err = $itemprice_err = $datebought_err = $location_err = $notes_err = "";
	$username = $_SESSION["username"];

	//get the user ID
	$sql = "SELECT user_id FROM accounts where username ='" . $username . "'";
	$result = mysqli_query($link, $sql);

	//store user id
	if (mysqli_num_rows($result) > 0) {
		//this is dumb
		while($row = mysqli_fetch_assoc($result)) {
			$userid = $row["user_id"]; 
		}
	}

	//make sure it's a post to begin with
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		$itemname = trim($_POST["itemname"]);
		$itemprice = trim($_POST["itemprice"]);
		$datebought = trim($_POST["datebought"]);
		$location = trim($_POST["location"]);
		$notes = trim($_POST["notes"]);
		
		//validate the things we only care about
		//item name
		if(empty(trim($_POST["itemname"]))) {
			$itemname_err = "Enter an item name.";
		} else {
			$itemname = trim($_POST["itemname"]);
		}

		//item price
		if(empty(trim($_POST["itemprice"]))) {
			$itemprice_err = "Enter an item price.";
		} else {
			$itemprice = trim($_POST["itemprice"]);
		}

		//date bought
		if(empty(trim($_POST["datebought"]))) {
			$datebought_err = "Enter the date the item was bought on.";
		} else {
			$datebought = trim($_POST["datebought"]);
		}

		//location
		if(empty(trim($_POST["location"]))) {
			//this is literally here so if someone doesnt enter data its blank and inserts fine
			$location = "";
		}

		//notes
		if(empty(trim($_POST["notes"]))) {
			//this is literally here so if someone doesnt enter data its blank and inserts fine
			$notes = "";
		}


		//if valid inputs
		if(empty($itemname_err) && empty($itemprice_err) && empty($datebought_err)) {
			$sql = "INSERT INTO item_table (user_id, item_name, price, date_bought, location, notes) VALUES (?, ?, ?, ?, ?, ?)";
			
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "isisss", $userid, $itemname, $itemprice, $datebought, $location, $notes);
				
				
				if(mysqli_stmt_execute($stmt)){
					// Redirect to view data page
					header("location: viewdata.php");
				} else{
					echo "Oops! Something went wrong.";
				}
				
				mysqli_stmt_close($stmt);
			}
		}
		mysqli_close($link);
	}
	?>
	
	<!-- user_id item_name price date_bought location notes -->
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Item Name</label><br>
        <input type="text" name="itemname" class="form-control <?php echo (!empty($itemname_err)) ? 'is-invalid' : ''; ?>"><br>
        <span><?php echo $itemname_err; ?></span><br>     
        
        <label>Price</label><br>
        <input type="number" name="itemprice" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"><br>
        <span><?php echo $itemprice_err; ?></span><br>  

		<label>Date Bought</label><br>
        <input type="date" name="datebought" class="form-control <?php echo (!empty($datebought_err)) ? 'is-invalid' : ''; ?>"><br>
        <span><?php echo $datebought_err; ?></span><br>  

		<label>Location</label><br>
        <input type="text" name="location" class="form-control <?php echo (!empty($location_err)) ? 'is-invalid' : ''; ?>"><br>
        <span><?php echo $location_err; ?></span><br>  

		<label>Additional Notes</label><br>
        <input type="text" name="notes" class="form-control <?php echo (!empty($notes_err)) ? 'is-invalid' : ''; ?>"><br>
        <span><?php echo $notes_err; ?></span><br>  

        <input type="submit" class="btn btn-primary" value="Submit"><br>  
    </form>
</body>
</html>