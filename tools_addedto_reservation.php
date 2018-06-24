<?php
include('lib/connection.php');

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$date_diff = $_SESSION['date_diff'];
$sdate = $_SESSION['start_date'];
$edate = $_SESSION['end_date'];

if($_POST['action']=="Confirm") {
    $_SESSION['tools_removed'] = $_POST['tools_removed'];
    header(REFRESH_TIME . 'url=reservation_summary.php');
}

if (empty($_SESSION['tools_removed'])){
    $_SESSION['final_tools']= $_SESSION['tools_added'];
}else {
    $_SESSION['final_tools'] = array_diff($_SESSION['tools_added'], $_SESSION['tools_removed']);
    if(array_diff($_SESSION['tools_added'], $_SESSION['tools_removed'])==array_diff($_SESSION['tools_removed'],$_SESSION['tools_added'])){
        header(REFRESH_TIME . 'url=make_reservation.php');
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Tools Added to Reservation</title>
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
        <form action="tools_addedto_reservation.php" method="post" enctype="multipart/form-data">
            <div class="title">Tools Added to Reservation</div>


            <fieldset>
                <table>
                    <tr>
                        <td class="heading">Tool ID</td>
                        <td class="heading">Description</td>
                        <td class="heading">Rental Price</td>
                        <td class="heading">Deposit Price</td>
                        <td class="heading">Remove</td>
                    </tr>
                    <?php
                    //                   $tools_added = mysqli_real_escape_string($db, $_POST['tools_added']);
                    if(!empty($_SESSION['tools_added'])) {

                        $query = "SELECT toolID, description, " .
                            "'$date_diff'*0.15*purchase_price AS rental_price, " .
                            "purchase_price*0.4 AS deposit_price " .
                            "FROM tool_outjoin_reservation " .
                            "WHERE (end_date < '$sdate' OR start_date > '$edate' " .
                            "OR (start_date IS NULL AND end_date IS NULL)) " .
                            "AND toolID IN ('" . implode("','", $_SESSION['tools_added']) . "')";

                        $result = mysqli_query($conn, $query);
                        $total_deposit = 0;
                        $total_rental = 0;
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $toolID = urlencode($row['toolID']);
                            print "<tr>";
                            print "<td>" . $row['toolID'] . "</td>";
                            print "<td>" ."<a target='_blank' style=\"font-size: 12px; color: blue; text-transform: none\" href='tool_details_id.php?toolID=$toolID'>".$row['description']."</a></td>";
                            print "<td>" .number_format((float) $row['rental_price'],2). "</td>";
                            $total_rental = $total_rental + $row['rental_price'];
                            print "<td>" . number_format((float)$row['deposit_price'],2). "</td>";
                            $total_deposit = $total_deposit + $row['deposit_price'];
                            print '<td><input type = "checkbox" name = "tools_removed[]" value = '. $row['toolID'].'></td>';
                            print "</tr>";
                        }
                    }
                    ?>
                    <tr>
                        <td><b>Totals</b></td>
                        <td></td>
                        <td><?php print number_format((float)$total_rental,2);
                            $_SESSION['total_rental'] = number_format((float)$total_rental, 2);?></td>
                        <td><?php print number_format((float)$total_deposit,2);
                            $_SESSION['total_deposit'] = number_format((float)$total_deposit, 2);?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name = "action" Value="Confirm"/></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </fieldset>

        </form>
        </div>
        <div class="mainbodySpaceHolder">
        </div>
    </div>
<div> <?php include("lib/error.php"); ?></div>
</body>
</html>

