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
<html>
<style>
    table,
    th,
    td {
        border: 1px solid;
    }
    .delete .delete_box {
        text-align: center !important;
        vertical-align: middle !important;
    }
</style>

<body>
    <article class="center-block">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>

        <p>
            <a href="reset-password.php">Reset Your Password</a>
            <a href="logout.php">Sign Out of Your Account</a>
            <a href="adddata.php">Add Data</a>
            <a href="viewdata.php">View Data</a>
            <a href="editdata.php">Edit Data</a>
        </p>

        <table>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Date Bought</th>
                <th>Location</th>
                <th>Additional Notes</th>
                <th>Delete Entry</th>
            </tr>
            <?php


            //define variables
            $jsdate = $jsprice = $itemid = $userid = $itemname = $itemprice = $datebought = $location = $notes = "";
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

                //echo htmlspecialchars($_SERVER["PHP_SELF"]);
                echo ('<form action="php/processdelete.php" method="post" id="delete_data">');

                $count = 0;
                while ($row = mysqli_fetch_assoc($result_items)) {
                    //spit values in. just in case jank.
                    $itemid = $row["item_id"];
                    $itemname = $row["item_name"];
                    $itemprice = $row["price"];
                    $datebought = $row["date_bought"];
                    $location = $row["location"];
                    $notes = $row["notes"];

                    //fuck around n find out
                    echo ('<tr>');

                    //this doesnt like 'disabled' for some reason
                    echo ('<td id="itemid">
                    <input type="text" id="itemid_box" name="itemid_box[]" value=' . $itemid . '  readonly="readonly">
                    </td>');

                    echo ('<td id="itemname">
                    <input type="text" id="itemname_box" name="item_name_box[]" value="' . $itemname . '" disabled>
                    </td>');

                    echo ('<td id="price">
                    <input type="text" id="price_box" name="price_box[]" value="' . $itemprice . '" disabled>
                    </td>');

                    echo ('<td id="datebought">
                    <input type="date" id="date_box" name="date_box[]" value="' . $datebought . '" disabled>
                    </td>');

                    echo ('<td id="location">
                    <input type="text" id="location_box" name="location_box[]" value="' . $location . '" disabled>
                    </td>');

                    echo ('<td id="notes">
                    <input type="text" id="notes_box" name="notes_box[]" value="' . $notes . '" disabled>
                    </td>');

                    echo ('<td id="delete">
                    <input type="checkbox" id="delete_box" name="delete_box[]" value='.$count.'>
                    </td>');
                    echo ('</tr>');
                    $count++;
                }
            } else {
                echo "0 results";
            }

            echo ('<input type="submit" class="btn btn-primary" value="Submit"><br>');
            echo ('</form>');

            ?>
        </table>
    </article>
</body>

</html>