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
        <a class="formTitle">Customer Report</a><br>
        <li><a></a></li><br>
        <?php
        $sql = "SELECT Customer.customerID as customerID, Customer.first_name as first_name, Customer.middle_name as middle_name," .
            " Customer.last_name as last_name, Customer.email as customer_email, Customer.primary_phone as phone, " .
            " ReservationCount.count as rCount, ToolCount.count as tCount FROM Customer LEFT JOIN " .
            " (SELECT customer_email, COUNT(*) AS count FROM Reservation GROUP BY customer_email) AS ReservationCount " .
            " ON ReservationCount.customer_email = Customer.email LEFT JOIN (SELECT customer_email, COUNT(*) AS count  " .
            " FROM Reservation INNER JOIN ToolReservation ON Reservation.reservationID = ToolReservation.reservationID " .
            " GROUP BY customer_email) AS ToolCount ON Customer.email = ToolCount.customer_email ORDER by ToolCount.count ASC, Customer.last_name;";
        $result = mysqli_query($conn, $sql);
        echo mysqli_error($conn);
        echo "<table border='1'>";
        echo "<tr><th>CID</th><th>Profile</th><th>First Name</th><th>Middle Name</th><th>Last Name</th>";
        echo "<th>Email</th><th>Phone</th><th>Resv Count</th><th>Tool Count</th></tr>\n";

        while($row = mysqli_fetch_assoc($result)) {   //Creates a loop to loop through results
            $customerID = urlencode($row['customerID']);
            $phone1 = str_split($row['phone'], 3)[0];
            $phone2 = str_split($row['phone'], 3)[1];
            $phone3 = str_split($row['phone'], 6)[1];
            echo "<tr><td>{$row['customerID']}</td>";
            echo "<td><a style=\"font-size: 12px; color: blue\" href='customer_details.php?customerID=$customerID'>View</a></td>";
            echo "<td>{$row['first_name']}</td><td>{$row['middle_name']}</td><td>{$row['last_name']}</td>";
            echo "<td>{$row['customer_email']}</td><td>({$phone1}) {$phone2}-{$phone3}</td>";
            echo "<td style=\"text-align:center\">{$row['rCount']}</td><td style=\"text-align:center\">{$row['tCount']}</td></tr>";
        }
        echo "</table>";
        ?>
        <li><a></a></li><br>
    </div>
<div>

<div class="mainbody">
        <div class="mainbodyWrapper2">
        <form action="generate_report.php" method="POST">
            <button style="width: 120px;" type="submit", name="submit">Report Menu</button>
            
        </form>
        </div>
    <div class="mainbodySpaceHolder">
    </div>
</div>
</body>
</html>
