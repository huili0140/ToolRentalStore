<?php
session_start();

include 'lib/connection.php';

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $exp_mon = mysqli_real_escape_string($conn, $_POST['exp_mon']);
    $exp_yr = mysqli_real_escape_string($conn, $_POST['exp_yr']);
    $cvc = mysqli_real_escape_string($conn, $_POST['cvc']);
}

## update credit card
$customer_email = $_SESSION['customer_email'];
$sql = "UPDATE CreditCard SET name = '$name', number = '$number', cvc = '$cvc', " .
    "exp_mon = '$exp_mon', exp_yr = '$exp_yr' WHERE email = '$customer_email'; ";

mysqli_query($conn, $sql);

if (mysqli_affected_rows($conn) == -1) {
    echo $customer_email;
    echo $exp_yr;
    echo "not able to update";
}
echo mysqli_error($conn);

## update reservation
$email = $_SESSION['email'];
$rID = $_SESSION['rID'];
$sql = "UPDATE Reservation SET Reservation.pickup_clerk_email = '$email' WHERE Reservation.reservationID = '$rID'; ";
mysqli_query($conn, $sql);
echo mysqli_error($conn);

$sql = "SELECT start_date, end_date FROM Reservation WHERE reservationID = '$rID'; ";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck < 1) {
    $rID_error = "no reservation record found";
} else {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $start_date =$row['start_date'];
    $end_date =$row['end_date'];
}

$status = "Rented";
$sql = "UPDATE Tool SET Tool.status = '$status' WHERE Tool.toolID IN " .
    "(SELECT ToolReservation.toolID FROM ToolReservation, Reservation " .
    "WHERE ToolReservation.reservationID = Reservation.reservationID AND Reservation.reservationID = '$rID'); ";
mysqli_query($conn, $sql);
$nrow = mysqli_affected_rows($conn);
echo "Update affected number of rows:" . $nrow;
echo mysqli_error($conn);


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
        <li><a class = "content" style="font-size: 16px">Rental Contact</a></li><br>
        <li><a class = "content">Pickup Clerk: <?=$_SESSION['first_name']." ".$_SESSION['last_name']?></a></li><br>
        <li><a class = "content">Customer Name: <?=$_SESSION['customer_name']?></a></li><br>
        <li><a class = "content">Credit Card #: <?php
                $n1 = str_split($number, 4)[0];
                $n2 = str_split($number, 4)[1];
                $n3 = str_split($number, 4)[2];
                $n4 = str_split($number, 4)[3];
                echo "{$n1}-{$n2}-{$n3}-{$n4}";
                ?></a></li><br>
        <li><a class = "content">Start Date: <?=$start_date?></a></li><br>
        <li><a class = "content">End Date: <?=$end_date?></a></li><br>
        <li><a></a></li><br>
        <?php
        $tID = "";
        $sql = "SELECT Tool.toolID as tID, description, purchase_price*0.4 AS deposit_price, " .
            "purchase_price*0.15*(end_date-start_date) AS rental_price FROM Tool, ToolReservation, Reservation " .
            "WHERE Reservation.reservationID = ToolReservation.reservationID AND ToolReservation.toolID = Tool.toolID " .
            "AND Reservation.reservationID =  '$rID'; ";
        $result = mysqli_query($conn, $sql);
        echo mysqli_error($conn);
        echo "<table border='1'>";
        echo "<tr><th>Tool ID</th><th>Tool Name</th><th>Deposite Price</th><th>Rental Price</th></tr>\n";

        while($row = mysqli_fetch_assoc($result)) {   //Creates a loop to loop through results
            $tID = urlencode($row['tID']);
            $tDeposite = number_format((float)$row['deposit_price'], 2);
            $tRental = number_format((float)$row['rental_price'], 2);
            echo "<tr><td>{$row['tID']}</td>";
            echo "<td><a style=\"font-size: 12px; color: blue; text-transform: none\" href='tool_details.php?toolID=$tID'>{$row['description']}</a></td>";
            echo "<td>\${$tDeposite}</td>";
            echo "<td>\${$tRental}</td></tr>";
        }
        $deposit = number_format((float)$_SESSION['deposit'], 2);
        $rental = number_format((float)$_SESSION['rental'], 2);
        echo "<tr><td>Totals</td><td></td><td>\$$deposit</td><td>\$$rental</td></tr>";
        echo "</table>";
        ?>
        <li><a></a></li><br>
        <div class="signature">
        <a class="formTitle">Signatures</a><br>
        <li><a></a></li><br>
        <li><a>Signature:_______________________________________________________________________</a><a>                    </a><a>Date:_____________________________</a></li><br>
        <li><a>Pickup Clerk: <?=$_SESSION['first_name']." ".$_SESSION['last_name']?></a></li><br>
        <li><a></a></li><br>
        <li><a>Signature:_______________________________________________________________________</a><a>                    </a><a>Date:_____________________________</a></li><br>
        <li><a>Customer: <?=$_SESSION['customer_name']?></a></li><br>
        <li><a></a></li><br>
        </div>
    </div>
    <div class="mainbodySpaceHolder">
    </div>
</div>
</body>
</html>
