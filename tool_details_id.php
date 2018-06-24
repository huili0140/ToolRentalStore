<?php

session_start();

include 'lib/connection.php';

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$toolID = mysqli_real_escape_string($conn, $_REQUEST['toolID']);
$query = "SELECT Tool.toolID, category, description, ".
    "power_source, sub_type, sub_option, width_diameter, length, weight, manufacturer, ".
    "purchase_price*0.4 AS deposit_price, ".
    "purchase_price*0.15 AS rental_price, ".
    "GROUP_CONCAT(acc_description) AS accessories ".
    "FROM Tool LEFT OUTER JOIN ToolAccessory ON Tool.toolID = ToolAccessory.toolID ".
    "LEFT OUTER JOIN Accessory ON ToolAccessory.accessoryID = Accessory.accessoryID ".
    "WHERE Tool.toolID = '$toolID' ".
    "GROUP BY Tool.toolID";

$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck >= 1) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $tool_type = $row['category']." Tool";
    $short_description=$row['description'];
    $deposit_price=number_format($row['deposit_price'],2);
    $rental_price=number_format($row['rental_price']*$_SESSION['date_diff'],2);
    $acc_description = $row['acc_description'];
    $battery_type= $row['battery_type'];
    $accessories = $row['accessories'];
    $full_description=$row['width_diameter']. " inch by ".$row['length']. " inch, ".$row['weight']." lbs, ".
        $row['description']. " by ".$row['manufacturer'];
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>
    <link rel="stylesheet" type="text/css" href="generic_customer.css">
</head>

<body>
<div class="header">
    <ul class="headerList">
        <li><a style="color: blue;">Hello <?php echo $_SESSION['first_name'] ?> !</a></li>
        <li><a href="view_profile.php">View Profile</a></li>
        <li><a href="make_reservation.php">Make Reservation</a></li>
        <li><a href="check_tool_availability.php">Check Tool Availability</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="mainbody">
    <div class="mainbodySpaceHolder"></div>
    <div class="mainbodyWrapper2">
        <div class = "title_name">Tool Details</div>
        <fieldset>
            <table>
                <tr>
                    <td style="font-weight: bold;">Tool ID:</td>
                </tr>
                <tr><td>
                        <?php echo $toolID; ?>
                        <br><br></td></tr>
                <tr><td style="font-weight: bold;">Tool Type:</td></tr>
                <tr><td>
                        <?php echo $tool_type; ?>
                        <br><br></td></tr>
                <tr>
                    <td style="font-weight: bold;">Short Description:</td>
                </tr>
                <tr><td>
                        <?php echo $short_description; ?>
                        <br><br></td></tr>
                <tr>
                    <td style="font-weight: bold;">Full Description:</td>
                </tr>
                <tr><td>
                        <?php echo $full_description; ?>
                        <br><br></td></tr>
                <tr>
                    <td style="font-weight: bold;">Deposit Price:</td>
                </tr>
                <tr><td>
                        <?php echo "\$ ". $deposit_price; ?>
                        <br><br></td></tr>
                <tr>
                    <td style="font-weight: bold;">Rental Price:</td>
                </tr>
                <tr><td>
                        <?php echo "\$ ". $rental_price; ?>
                        <br><br></td></tr>
                <tr>
                    <td style="font-weight: bold;">Accessories:</td>
                </tr>
                <tr><td>
                        <?php echo str_replace(',', '<br/>',  $accessories); ?>
                        <br><br></td></tr>
            </table>
        </fieldset>

    </div>
    <div class="mainbodySpaceHolder">
    </div>
</div>
</body>
</html>