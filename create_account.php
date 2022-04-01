<?php 

//this is our config file so I can put this on github without creds
require_once "config.php";

$username = $password = $email = $confirm_password = "";
$username_err = $password_err = $email_err = $confirm_password_err = "";

// make sure it's a post
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // validation of username
    if(empty(trim($_POST['username']))){
        $username_err = "Please enter a username.";

    //check the username for special characters
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    
    //we can do this thing now
    } else {

        //sql query to check if username is already taken
        $sql = "SELECT username FROM accounts where username = ?";

        if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters
            /*
            Self note: the s represents the number of variables in the sql query
            */
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                //check if the username already exists in the system.
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong.";
            }

            /*
            TODO:
                Need to check for existing emails
            */




            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    //validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    //validate email
    if(empty(trim($_POST["email"]))){
        $confirm_email_err = "Enter an email.";
    } else {
        $email = trim($_POST["email"]);
    }

    //validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    //check out inputs
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){

        //sql insert statement
        $sql = "INSERT INTO accounts (username, email, password) VALUES (?, ?, ?)";
       
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);

}



?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/nav-style.css">
	    <link rel="stylesheet" href="css/global.css">
        <title>Sign Up</title>
    </head>
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
            <h2>Sign Up</h2>
            <p>Please enter your information below.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                
                <!--username-->
                <label>Username</label><br>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>"><br>
                <span><?php echo $username_err; ?></span>

                <!--email-->
                <label>Email</label><br>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>"><br>
                <span><?php echo $email_err; ?></span>

                <!--password-->
                <label>Password</label><br>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>"><br>
                <span><?php echo $password_err; ?></span>

                <!--confirm password-->
                <label>Confirm Password</label><br>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>"><br>
                <span><?php echo $confirm_password_err; ?></span>

                <input type="submit" value="Submit">
                <input type="reset" value="Reset">

                <p>Already have an account? <a href="login.php">Login here</a>.</p>

            </form>

        </article>
    </body>
</html>