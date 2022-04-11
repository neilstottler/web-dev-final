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

<?php
//variables
$result_items = $item_id = $itemid = $checkbox = "";

//this is a required item so we can count it
$itemid = $_POST["itemid_box"];

$checkbox = $_POST["delete_box"];

//DELETE FROM item_table WHERE item_id = 'x'
for($i =0; $i<count($checkbox); $i++){
	$item_id = $itemid[$checkbox[$i]];
	//echo($checkbox[$i]." checkbox i <br>");
	//echo($itemid[$checkbox[$i]]. " item id i <br>");
	$sql = 'DELETE FROM item_table WHERE item_id = "'.  $item_id .'"';
	$result_items = mysqli_query($link, $sql);
}

if (mysqli_query($link, $sql)) {
  echo "Record updated successfully. <br>";
  header('Location: ../viewdata.php');
} else {
  echo "Error updating record: " . mysqli_error($link) . "<br>";
}

?>