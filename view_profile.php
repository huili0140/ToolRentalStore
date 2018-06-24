<?php
session_start();

include 'lib/connection.php';

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}


$query =
    "SELECT email, first_name, last_name, home_phone, work_phone, cell_phone, street_address, city, state, zip ".
    "FROM customer ".
    "WHERE email ='{$_SESSION['email']}'";


$result = mysqli_query($conn, $query);

if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $home_phone = "(".substr($row['home_phone'],0,3).") ".substr($row['home_phone'],3,3).
        "-".substr($row['home_phone'],6,4);
    $work_phone = "(".substr($row['work_phone'],0,3).") ".substr($row['work_phone'],3,3).
        "-".substr($row['work_phone'],6,4);
    $cell_phone = "(".substr($row['cell_phone'],0,3).") ".substr($row['cell_phone'],3,3).
        "-".substr($row['cell_phone'],6,4);
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
    <div class="mainbodySpaceHolder">
    </div>
    <div class="mainbodyWrapper2">
        <span><?=$error ?></span>

        <div class = "title_name"><?php print $row['first_name'] . ' ' . $row['last_name']; ?></div>
        <div class="profile_section">
            <div class="subtitle">Customer Info</div>
            <table>
                <tr>
                    <td class="item_label">E-mail:</td>
                    <td>
                        <?php print $row['email'];?>
                    </td>
                </tr>
                <tr>
                    <td class="item_label">Home Phone:</td>
                    <td>
                        <?php print $home_phone;?>
                    </td>
                </tr>
                <tr>
                    <td class="item_label">Work Phone:</td>
                    <td>
                        <?php print $work_phone;?>
                    </td>
                </tr>

                <tr>
                    <td class="item_label">Cell Phone</td>
                    <td>
                        <?php print $cell_phone;?>
                    </td>
                </tr>

                <tr>
                    <td class="item_label">Address</td>
                    <td>
                        <?php print $row['street_address'].','.$row['city'].' '.$row['state'].' '.$row['zip'] ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class = "profile_section"><div class="subtitle">Reservations</div></div>
        <table>
            <tr>
                <td class="heading">Rsv ID</td>
                <td class="heading">Tools</td>
                <td class="heading">Start Date</td>
                <td class="heading">End Date</td>
                <td class="heading">Pick-up Clerk</td>
                <td class="heading">Drop-off Clerk</td>
                <td class="heading"># of Days</td>
                <td class="heading">Total Deposit Price</td>
                <td class="heading">Total Rental Price</td>
            </tr>

            <?php
            $query = "SELECT Reservation.reservationID, GROUP_CONCAT(description) AS tool_list, ".
                "start_date, end_date , pickup_clerk_email, " .
                "dropoff_clerk_email, DATEDIFF(end_date, start_date) AS days, ".
                "SUM(purchase_price*0.4) AS deposit_price, ".
                "SUM(purchase_price*0.15*DATEDIFF(end_date, start_date)) AS rental_price ".
                "FROM Tool INNER JOIN ToolReservation ON Tool.toolID=ToolReservation.toolID ".
                "INNER JOIN Reservation ON ToolReservation.reservationID = Reservation.reservationID ".
                "WHERE Reservation.customer_email = '{$_SESSION['email']}' ".
                "GROUP BY Reservation.reservationID";
            $result = mysqli_query($conn, $query);




            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                print "<tr>";
                print "<td>" . $row['reservationID'] . "</td>";
                print "<td>" . str_replace(',', '<br/>',  $row['tool_list'])."</td>";
                print "<td>" . $row['start_date'] . "</td>";
                print "<td>" . $row['end_date'] . "</td>";
                print "<td>" . $row['pickup_clerk_email'] . "</td>";
                print "<td>" . $row['dropoff_clerk_email'] . "</td>";
                print "<td>" . $row['days'] . "</td>";
                print "<td>" .number_format((float) $row['deposit_price'],2) . "</td>";
                print "<td>" . number_format((float)$row['rental_price'],2) . "</td>";
                print "</tr>";
            }
            ?>
        </table>


    </div>
    <div class="mainbodySpaceHolder">
    </div>
</div>

</div>



</body>
</html>
