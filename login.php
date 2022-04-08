<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: viewdata.php");
    exit;
}

//config
require_once "config.php";

//define variables
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Grab what was sent from the form and process it
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    //validate credentials
    if(empty($username_err) && empty($password_err)){
        //db query
        $sql = "SELECT user_id, username, password FROM accounts WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            //define parameters
            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to the page to view data
                            header("location: viewdata.php");
                        } else{
                            // Password is not valid
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }        
    }
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


    <h2>Login</h2>
    <p>Please enter your credentials.</p>

    <?php 
    if(!empty($login_err)){
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
    }        
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Username</label><br>
        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>"><br>
        <span><?php echo $username_err; ?></span>     
        
        <label>Password</label><br>
        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"><br>
        <span><?php echo $password_err; ?></span>

        <input type="submit" class="btn btn-primary" value="Login">

        <p>Don't have an account? <a href="create_account.php">Sign up</a>.</p>
    </form>
    </body>
</html> 