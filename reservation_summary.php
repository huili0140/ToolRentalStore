<?php
include('lib/connection.php');

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$date_diff = $_SESSION['date_diff'];
$sdate = $_SESSION['start_date'];
$edate = $_SESSION['end_date'];



$sqlemail = mysqli_real_escape_string($conn, $_SESSION['email']);
$sqlsdate = mysqli_real_escape_string($conn, $sdate);
$sqledate = mysqli_real_escape_string($conn, $edate);

$query = "SELECT toolID, description, " .
    "'$date_diff'*0.15*purchase_price AS rental_price, " .
    "purchase_price*0.4 AS deposit_price " .
    "FROM tool_outjoin_reservation " .
    "WHERE (end_date < '$sdate' OR start_date > '$edate' " .
    "OR (start_date IS NULL AND end_date IS NULL)) " .
    "AND toolID IN ('" . implode("','", $_SESSION['final_tools']) . "')";
$result = mysqli_query($conn, $query);

$total_deposit = 0;
$total_rental = 0;

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $total_rental = $total_rental + $row['rental_price'];
    $total_deposit = $total_deposit + $row['deposit_price'];
}
$_SESSION['total_rental'] = number_format((float)$total_rental, 2);
$_SESSION['total_deposit'] = number_format((float)$total_deposit, 2);
?>

<!DOCTYPE html>
<html>
<head>
    <title>
        <?php if(!isset($_POST['action'])){print "Reservation Summary";}
        elseif($_POST['action']=="Submit"){print "Reservation Confirmation";} ?></title>
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
        <form action="reservation_summary.php" method="post" enctype="multipart/form-data">
            <div class="title"><?php if(!isset($_POST['action'])){print "Reservation Summary";}
                elseif($_POST['action']=="Submit"){print "Reservation Confirmation";} ?></div>

            <fieldset>
                <table>
                    <tr><td class = "heading">Reservation Dates: <?php print $sdate . ' --- '. $edate?><br>
                            Number of Days Rented: <?php print $date_diff?><br>
                            Total Deposit Price: <?php print $_SESSION['total_deposit']?><br>
                            Total Rental Price:<?php print $_SESSION['total_rental']?><br>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <div class="title">Tools</div>
                <table>
                    <tr>
                        <td class="heading">Tool ID</td>
                        <td class="heading">Description</td>
                        <td class="heading">Rental Price</td>
                        <td class="heading">Deposit Price</td>
                    </tr>
                    <?php


                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $toolID = urlencode($row['toolID']);
                        print "<tr>";
                        print "<td>" . $row['toolID'] . "</td>";
                        print "<td>" ."<a target='_blank' style=\"font-size: 12px; color: blue; text-transform: none\" href='tool_details_id.php?toolID=$toolID'>".$row['description']."</a></td>";
                        print "<td>" .number_format((float) $row['rental_price'],2). "</td>";
                        print "<td>" . number_format((float)$row['deposit_price'],2). "</td>";
                        print "</tr>";
                    }
                    ?>
                    <tr>
                        <td><b>Totals</b></td>
                        <td></td>
                        <td><?php print $_SESSION['total_rental'];?></td>
                        <td><?php print $_SESSION['total_deposit'];?></td>
                        <td></td>
                    </tr>

                    <tr>

                            <?php if(!isset($_POST['action'])){print
                                '<td><input type = "submit" name = "action" value = "Submit"></td>'.
                                '<td><input type = "submit" name = "action" Value = "Reset"></td>';}
                            ?>


                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                </table>
            </fieldset>

        </form>
        <?php
        if ($_POST['action']=="Submit") {
            $query = "INSERT INTO reservation (customer_email, start_date, end_date) " .
                "VALUES ('$sqlemail', '$sqlsdate', '$sqledate')";
            $result = mysqli_query($conn, $query);

            $query = "SET @lastid = LAST_INSERT_ID();";
            $result = mysqli_query($conn, $query);

            foreach($_SESSION['final_tools'] as $toolID) {
                $query = "INSERT INTO toolreservation (toolID, reservationID) " .
                    "VALUES ('$toolID', @lastid)";
                $result = mysqli_query($conn, $query);
            }


            array_push($query_msg, "Reservation Created. Thanks for your business!");
        }
        if ($_POST['action']=="Reset" ) {
            $_POST = array();
            header(REFRESH_TIME . 'url=make_reservation.php');
        }
        ?>
    </div>
    <div class="mainbodySpaceHolder">
    </div>
</div>
<div> <?php include("lib/error.php"); ?></div>
</body>
</html>

