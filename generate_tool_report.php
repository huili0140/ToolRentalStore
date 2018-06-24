<?php
session_start();

include 'lib/connection.php';

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$category = $key = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $key = mysqli_real_escape_string($conn, $_POST['key']);
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
        <a class="formTitle">Tool Inventory Report</a><br>
        <li><a></a></li><br>
        <form action="generate_tool_report.php" method="POST">
            <a class="primaryPhone">Category</a>
            All Tools<input type="radio" name="category" value="all" <?php if($category == "all") echo ' checked="checked"'?>>
            Hand Tool<input type="radio" name="category" value="Hand" <?php if($category == "Hand") echo ' checked="checked"'?>>
            Garden Tool<input type="radio" name="category" value="Garden" <?php if($category == "Garden") echo ' checked="checked"'?>>
            Ladder<input type="radio" name="category" value="Ladder" <?php if($category == "Ladder") echo ' checked="checked"'?>>
            Power Tool<input type="radio" name="category" value="Power" <?php if($category == "Power") echo ' checked="checked"'?>><br>
            <a class="primaryPhone">Custom Search</a>
            <input type="key" name="key" value="<?= $key?>" placeholder="Enter Keyword">
            <button type="submit", name="submit">Search</button>
        </form>
        <li><a></a></li><br>

        <?php
        if(isset($_POST['category'])) {
            if (isset($_POST['category']) && $category == "all" && $key == "") {
                $sql = "SELECT distinct Tool.toolID as tID, status, ReservationSum.end_date, description, coalesce(ReservationSum.days, 0) * Tool.purchase_price * 0.15 AS rental_profit, " .
                    " (Tool.purchase_price) AS total_cost, (coalesce(ReservationSum.days, 0) * Tool.purchase_price * 0.15 - Tool.purchase_price) AS total_profit" .
                    "  FROM Tool LEFT JOIN (SELECT Tool.toolID, SUM(Reservation.end_date - Reservation.start_date) AS days, " .
                    " MAX(Reservation.end_date) AS end_date FROM Tool, ToolReservation, Reservation WHERE Tool.toolID = ToolReservation.toolID " .
                    " AND ToolReservation.reservationID = Reservation.reservationID GROUP BY Tool.toolID) AS ReservationSum on Tool.toolID = ReservationSum.toolID " .
                    " LEFT JOIN ToolReservation on Tool.toolID = ToolReservation.toolID LEFT JOIN Reservation on ToolReservation.reservationID = Reservation.reservationID ".
                    " ORDER BY total_profit DESC;";
            } elseif (isset($_POST['category']) && $category == "all" && $key != "") {
                $sql = "SELECT distinct Tool.toolID as tID, status, ReservationSum.end_date, description, coalesce(ReservationSum.days, 0) * Tool.purchase_price * 0.15 AS rental_profit, " .
                    " (Tool.purchase_price) AS total_cost, (coalesce(ReservationSum.days, 0) * Tool.purchase_price * 0.15 - Tool.purchase_price) AS total_profit" .
                    "  FROM Tool LEFT JOIN (SELECT Tool.toolID, SUM(Reservation.end_date - Reservation.start_date) AS days, " .
                    " MAX(Reservation.end_date) AS end_date FROM Tool, ToolReservation, Reservation WHERE Tool.toolID = ToolReservation.toolID " .
                    " AND ToolReservation.reservationID = Reservation.reservationID GROUP BY Tool.toolID) AS ReservationSum on Tool.toolID = ReservationSum.toolID " .
                    " LEFT JOIN ToolReservation on Tool.toolID = ToolReservation.toolID LEFT JOIN Reservation on ToolReservation.reservationID = Reservation.reservationID ".
                    " WHERE (Tool.power_source LIKE '$key' OR Tool.sub_type LIKE '$key' OR Tool.sub_option LIKE '$key') " .
                    " ORDER BY total_profit DESC;";
            } elseif (isset($_POST['category']) && $category != "all" && $key == "") {
                $sql = "SELECT distinct Tool.toolID as tID, status, ReservationSum.end_date, description, coalesce(ReservationSum.days, 0) * Tool.purchase_price * 0.15 AS rental_profit, " .
                    " (Tool.purchase_price) AS total_cost, (coalesce(ReservationSum.days, 0) * Tool.purchase_price * 0.15 - Tool.purchase_price) AS total_profit" .
                    " FROM Tool LEFT JOIN (SELECT Tool.toolID, SUM(Reservation.end_date - Reservation.start_date) AS days, " .
                    " MAX(Reservation.end_date) AS end_date FROM Tool, ToolReservation, Reservation WHERE Tool.toolID = ToolReservation.toolID " .
                    " AND ToolReservation.reservationID = Reservation.reservationID GROUP BY Tool.toolID) AS ReservationSum on Tool.toolID = ReservationSum.toolID " .
                    " LEFT JOIN ToolReservation on Tool.toolID = ToolReservation.toolID LEFT JOIN Reservation on ToolReservation.reservationID = Reservation.reservationID ".
                    " WHERE Tool.category = '$category' " .
                    " ORDER BY total_profit DESC;";
            } else {
                $sql = "SELECT distinct Tool.toolID as tID, status, ReservationSum.end_date, description, coalesce(ReservationSum.days, 0) * Tool.purchase_price * 0.15 AS rental_profit, " .
                    " (Tool.purchase_price) AS total_cost, (coalesce(ReservationSum.days, 0) * Tool.purchase_price * 0.15 - Tool.purchase_price) AS total_profit " .
                    " FROM Tool LEFT JOIN (SELECT Tool.toolID, SUM(Reservation.end_date - Reservation.start_date) AS days, " .
                    " MAX(Reservation.end_date) AS end_date FROM Tool, ToolReservation, Reservation WHERE Tool.toolID = ToolReservation.toolID " .
                    " AND ToolReservation.reservationID = Reservation.reservationID GROUP BY Tool.toolID) AS ReservationSum on Tool.toolID = ReservationSum.toolID " .
                    " LEFT JOIN ToolReservation on Tool.toolID = ToolReservation.toolID LEFT JOIN Reservation on ToolReservation.reservationID = Reservation.reservationID ".
                    " WHERE Tool.category = '$category' AND (Tool.power_source LIKE '$key' OR Tool.sub_type LIKE '$key' OR Tool.sub_option LIKE '$key') " .
                    " ORDER BY total_profit DESC;";
            }

            $result = mysqli_query($conn, $sql);

            $row_cnt = mysqli_num_rows($result);
            // echo $row_cnt;
            echo mysqli_error($conn);
            echo "<table border='1'>";
            echo "<tr><th>Tool ID</th><th>Current Status</th><th>Return Date</th>";
            echo "<th>Description</th><th>Rental Profit</th><th>Total Cost</th><th>Total Profit</th></tr>\n";


            while ($row = mysqli_fetch_assoc($result)) {   //Creates a loop to loop through results
                $tID = urlencode($row['tID']);
                $rental_profit = number_format((float)$row['rental_profit'], 2);
                $total_profit = number_format((float)$row['total_profit'], 2);

                echo "<tr><td>{$row['tID']}</td>";
                echo "<td status={$row['status']}>{$row['status']}</td>";
                echo "<td>{$row['end_date']}</td>";
                echo "<td><a style=\"font-size: 12px; color: blue; text-transform: none\" href='tool_details.php?toolID=$tID'>{$row['description']}</a></td>";
                echo "<td>\$ {$rental_profit}</td>";
                echo "<td>\$ {$row['total_cost']}</td>";
                echo "<td>\$ {$total_profit}</td></tr>";
            }
            echo "</table>";
        }
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
