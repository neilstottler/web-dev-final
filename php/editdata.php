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

<article class="center-block">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <style>
        table,
        th,
        td {
            border: 1px solid;
        }
    </style>
    <table>
        <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Price</th>
            <th>Date Bought</th>
            <th>Location</th>
            <th>Additional Notes</th>
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
            echo ('<form action="php/processedit.php" method="post" id="edit_data">');


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
                echo ('<td id="itemid" class="editable">
                <input type="text" id="itemid_box" name="itemid_box[]" value=' . $itemid . '  readonly="readonly">
                </td>');

                echo ('<td id="itemname" class="editable">
                <input type="text" id="itemname_box" name="item_name_box[]" value="' . $itemname . ' ">
                </td>');

                echo ('<td id="price" class="editable">
                <input type="text" id="price_box" name="price_box[]" value="' . $itemprice . '">
                </td>');

                echo ('<td id="datebought" class="editable">
                <input type="date" id="date_box" name="date_box[]" value="' . $datebought . '">
                </td>');

                echo ('<td id="location" class="editable">
                <input type="text" id="location_box" name="location_box[]" value="' . $location . '">
                </td>');

                echo ('<td id="notes" class="editable">
                <input type="text" id="notes_box" name="notes_box[]" value="' . $notes . '">
                </td>');
                echo ('</tr>');
            }
        } else {
            echo "0 results";
        }

        echo ('<input type="submit" class="btn btn-primary" value="Submit"><br>');
        echo ('</form>');


        ?>
    </table>
</article>