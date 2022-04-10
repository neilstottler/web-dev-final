<?php
//this is our config file so I can put this on github without creds
require_once "../config.php";

session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: php/login.php");
    exit;
}
?>


<?php
//variables
$result_items = $itemid = $userid = $itemname = $itemprice = $datebought = $location = $notes = "";

//this is a required item so we can count it
$arrLength = count($_POST["date_box"]);

    //run through all the entries
for ($i = 0; $i < $arrLength; $i++) {

    //setting values for mysql
    $itemid = $_POST["itemid_box"][$i];
    $itemname = $_POST["item_name_box"][$i];
    $itemprice = $_POST["price_box"][$i];
    $datebought = $_POST["date_box"][$i];
    $location = $_POST["location_box"][$i];
    $notes = $_POST["notes_box"][$i];

    $sql = 'UPDATE item_table SET item_name = "' . $itemname . '", price = "' . $itemprice . '", date_bought = "' . $datebought . '", location = "' . $location . '",  notes = "' . $notes . '" WHERE item_id='. $itemid ;

    $result_items = mysqli_query($link, $sql);
}

if (mysqli_query($link, $sql)) {
  echo "Record updated successfully. <br>";
  header('Location: php/viewdata.php');
} else {
  echo "Error updating record: " . mysqli_error($link) . "<br>";
}

?>