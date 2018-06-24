<?php
session_start();

include 'lib/connection.php';

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $rID = mysqli_real_escape_string($conn, $_POST['rID']);
    ## echo "got the form rID";
} else {
    $rID = mysqli_real_escape_string($conn, $_REQUEST['rID']);
    ## echo "got the click rID";
}

$rID_error = "";
$name = $number = $cvc = $exp_mon = $exp_yr = "";
$sql = "SELECT Reservation.reservationID, CONCAT(Customer.first_name, ' ', Customer.last_name) AS customer_name, " .
    " Customer.email as customer_email, ReservationSum.price * 0.40 AS deposit, " .
    " ReservationSum.price * 0.15 * ReservationSum.days AS rental  " .
    " FROM Reservation, Customer, (SELECT Reservation.reservationID AS reservationID, " .
    " SUM(Tool.purchase_price) AS price, (Reservation.end_date - Reservation.start_date)  " .
    " AS days FROM Reservation, ToolReservation, Tool WHERE Reservation.reservationID = ToolReservation.reservationID  " .
    " AND ToolReservation.toolID = Tool.toolID GROUP BY Reservation.reservationID) AS ReservationSum WHERE  " .
    " Reservation.customer_email = Customer.email AND Reservation.reservationID = ReservationSum.reservationID   " .
    "  AND Reservation.reservationID = '$rID';";

$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck < 1) {
    ## echo "Record doesn't exit.";
} else {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $customer_name = $row['customer_name'];
    $deposit=$row['deposit'];
    $rental=$row['rental'];
    $customer_email=$row['customer_email'];
}

$sql = "SELECT name, number, cvc, exp_mon, exp_yr FROM CreditCard WHERE email = '$customer_email'; ";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck < 1) {
    $rID_error = "no credit card found";
} else {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $name = $row['name'];
    $number=$row['number'];
    $cvc=$row['cvc'];
    $exp_mon=$row['exp_mon'];
    $exp_yr=$row['exp_yr'];
}

$_SESSION['rID'] = $rID;
$_SESSION['customer_name'] = $customer_name;
$_SESSION['customer_email'] = $customer_email;
$_SESSION['deposit'] = $deposit;
$_SESSION['rental'] = $rental;


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
        <a class="formTitle">Pickup Reservation</a><br>
        <li><a></a></li><br>
        <li><a class = "content" style="font-size: 14px">Reservation ID: <?=$rID?></a></li><br>
        <li><a class = "content">Customer Name: <?=$customer_name?></a></li><br>
        <li><a class = "content">Total Deposit: $<?=number_format((float)$deposit, 2)?></a></li><br>
        <li><a class = "content">Total Rental: $<?=number_format((float)$rental, 2)?></a></li><br>
        <li><a></a></li><br>

            <form action="pickup_reservation_confirmation.php" method="POST">
                <a>Enter Updated Credit Card Information</a><br>
                <input type="text" name="name" value="<?= $name?>" placeholder="Name on Credit Card">
                <input type="text" name="number" value="<?= $number?>" placeholder="Credit Card Number">
                <input type="text" name="cvc" value="<?= $cvc?>" placeholder="CVC"><br>

                <select class="pulldown" name="exp_mon" value="<?= $exp_mon?>">
                    <?php
                    if ($exp_mon == "0") {
                        echo "<option value=\"0\">January</option>";
                    } elseif ($exp_mon == "1") {
                        echo "<option value=\"1\">February</option>";
                    } elseif ($exp_mon == "2") {
                        echo "<option value=\"2\">March</option>";
                    } elseif ($exp_mon == "3") {
                        echo "<option value=\"3\">April</option>";
                    } elseif ($exp_mon == "4") {
                        echo "<option value=\"4\">May</option>";
                    } elseif ($exp_mon == "5") {
                        echo "<option value=\"5\">June</option>";
                    } elseif ($exp_mon == "6") {
                        echo "<option value=\"6\">July</option>";
                    } elseif ($exp_mon == "7") {
                        echo "<option value=\"7\">August</option>";
                    } elseif ($exp_mon == "8") {
                        echo "<option value=\"8\">September</option>";
                    } elseif ($exp_mon == "9") {
                        echo "<option value=\"9\">October</option>";
                    } elseif ($exp_mon == "10") {
                        echo "<option value=\"10\">November</option>";
                    } elseif ($exp_mon == "11") {
                        echo "<option value=\"11\">December</option>";
                    }
                    echo "<option value=\"\">Expiration Month</option>";
                    ?>

                    <option value="0">January</option>
                    <option value="1">February</option>
                    <option value="2">March</option>
                    <option value="3">April</option>
                    <option value="4">May</option>
                    <option value="5">June</option>
                    <option value="6">July</option>
                    <option value="7">August</option>
                    <option value="8">September</option>
                    <option value="9">October</option>
                    <option value="10">November</option>
                    <option value="11">December</option>
                </select>

                <select class="pulldown" name="exp_yr" value="<?= $exp_yr?>">
                    <?php
                    if ($exp_yr != "") {
                        echo "<option value=\"$exp_yr\">" . $exp_yr . "</option>";
                    }
                    echo "<option value=\"\">Expiration Year</option>";
                    ?>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                </select>

                <li><a></a></li><br>
                <button type="submit", name="submit">Confirm Pick Up</button>

            </form>
    </div>
    <div class="mainbodySpaceHolder">
    </div>
</div>
</body>
</html>
