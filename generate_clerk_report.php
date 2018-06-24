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
        <a class="formTitle">Clerk Report</a><br>
        <li><a></a></li><br>
        <?php
        $sql = "SELECT Clerk.clerkID as clerkID, first_name, middle_name, last_name, Clerk.email as clerkEmail, hire_date, " .
            "coalesce(Pickup.pickup_count, 0) as pickup_count, coalesce(Dropoff.dropoff_count, 0) as dropoff_count," .
            "(coalesce(Pickup.pickup_count,0)+coalesce(Dropoff.dropoff_count,0)) AS total_count FROM Clerk LEFT JOIN " .
            " (SELECT pickup_clerk_email, COUNT(*) AS pickup_count FROM Reservation GROUP BY pickup_clerk_email) AS Pickup " .
            " ON Pickup.pickup_clerk_email = Clerk.email LEFT JOIN (SELECT dropoff_clerk_email, COUNT(*) AS dropoff_count " .
            " FROM Reservation GROUP BY dropoff_clerk_email) AS Dropoff ON Clerk.email= Dropoff.dropoff_clerk_email  " .
            " ORDER BY total_count DESC;";
        $result = mysqli_query($conn, $sql);
        echo mysqli_error($conn);
        echo "<table border='1'>";
        echo "<tr><th>Clerk ID</th>";
        echo "<th>First Name</th>";
        echo "<th>Middle Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Email</th>";
        echo "<th>Hire Date</th>";
        echo "<th>Pickup Count</th>";
        echo "<th>Dropoff Count</th>";
        echo "<th>Total</th></tr>\n";

        while($row = mysqli_fetch_assoc($result)) {   //Creates a loop to loop through results
            //$rID = urlencode($row['rID']);
            echo "<tr><td>{$row['clerkID']}</td>";
            echo "<td>{$row['first_name']}</td>";
            echo "<td>{$row['middle_name']}</td>";
            echo "<td>{$row['last_name']}</td>";
            echo "<td>{$row['clerkEmail']}</td>";
            echo "<td>{$row['hire_date']}</td>";
            echo "<td style=\"text-align:center\">{$row['pickup_count']}</td>";
            echo "<td style=\"text-align:center\">{$row['dropoff_count']}</td>";
            echo "<td style=\"text-align:center\">{$row['total_count']}</td></tr>";
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
