<?php
session_start();

include 'lib/connection.php';

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="main_customer.css">
</head>

<body>
<div class="header">
    <ul class="headerList">
        <li><a style="color: blue;">Hello <?php echo $_SESSION['first_name'] ?> !</a></li>
        <li><a href="pickup_reservation.php">Pick-Up reservation</a></li>
        <li><a href="dropoff_reservation.php">drop-off reservation</a></li>
        <li><a href="add_new_tool.php">Add New Tool</a></li>
        <li><a href="generate_report.php">Generate report</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="mainbody">
    <div class="mainbodySpaceHolder">
    </div>
    <div class="mainbodyWrapper2">
        <a class="formTitle">Dropoff Reservation</a><br>
        <li><a></a></li><br>
        <?php
        $sql = "SELECT Reservation.reservationID as rID, Reservation.customer_email as email, Customer.customerID as cID, " .
                "start_date, end_date FROM Reservation, Customer " .
                "WHERE Reservation.customer_email = Customer.email AND Reservation.pickup_clerk_email IS NOT NULL " .
            "AND Reservation.dropoff_clerk_email is NULL;";
        $result = mysqli_query($conn, $sql);
        echo mysqli_error($conn);
        echo "<table border='1'>";
        echo "<tr><th>Reservation ID</th><th>Customer</th><th>Customer ID</th><th>Start Date</th><th>End Date</th></tr>\n";

        while($row = mysqli_fetch_assoc($result)) {   //Creates a loop to loop through results
            $rID = urlencode($row['rID']);
            echo "<tr><td><a style=\"font-size: 12px; color: blue\" href='dropoff_reservation_id.php?rID=$rID'>{$row['rID']}</a></td>";
            echo "<td>{$row['email']}</td><td>{$row['cID']}</td><td>{$row['start_date']}</td><td>{$row['end_date']}</td></tr>";
        }
        echo "</table>";
        ?>
        <li><a></a></li><br>
    </div>
<div>

<div class="mainbody">
        <div class="mainbodyWrapper2">
        <form action="dropoff_reservation_id.php" method="POST">

            <input type="number" name="rID" placeholder="Enter Reservation ID">
            <button style="width: 120px;" type="submit", name="submit">Drop Off</button>
            
        </form>
        </div>
    <div class="mainbodySpaceHolder">
    </div>
</div>
</body>
</html>
