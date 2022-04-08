<?php
//this is our config file so I can put this on github without creds
require_once "../config.php";

session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}
?>

<?php
//variables
$result_items = $itemid = $checkbox = "";

//this is a required item so we can count it
$arrLength = count($_POST["itemid_box"]);

$deleteArray = [];
$itemIdArray = [];

//run through all the entries
for ($i = 0; $i < $arrLength; $i++) {
    array_push($deleteArray, null);

    if (isset($_POST["delete_box"][$i]) != null) {
      array_push($deleteArray, $_POST["delete_box"][$i]);
	  echo("we're at: ". [$i]. "<br>");
    }

	if (isset($_POST["delete_box"][$i]) == null) {
		echo('null');
	}
    array_push($itemIdArray, $_POST["itemid_box"][$i]);

	echo ($deleteArray[$i]. " <br>");
	echo ($itemIdArray[$i]. " <br>");
    //$result_items = mysqli_query($link, $sql);
}

/*
if (mysqli_query($link, $sql)) {
  echo "Record updated successfully. <br>";
  header('Location: ../viewdata.php');
} else {
  echo "Error updating record: " . mysqli_error($link) . "<br>";
}
*/
?>