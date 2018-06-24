<?php
include('lib/connection.php');
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Check Tool Availability</title>
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
        <form action="check_tool_availability.php" method="post" enctype="multipart/form-data">
            <div class="title">Check Tool Availability</div>
            <?php include("lib/search_tools.php"); ?>
        </form>

        <fieldset>
            <table>
                <tr>
                    <td class="heading">Tool ID</td>
                    <td class="heading">Description</td>
                    <td class="heading">Rental Price</td>
                    <td class="heading">Deposit Price</td>
                </tr>

                <?php
                if($_POST['action']=="Search") {
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $toolID = urlencode($row['toolID']);
                        print "<tr>";
                        print "<td>" . $row['toolID'] . "</td>";
                        print "<td>" ."<a target='_blank' style=\"font-size: 12px; color: blue\" href='tool_details_id.php?toolID=$toolID'>".$row['description'] . "</a></td>";
                        print "<td>" . number_format((float)$row['rental_price'], 2) . "</td>";
                        print "<td>" . number_format((float)$row['deposit_price'], 2) . "</td>";
                        print "</tr>";
                    }
                }
                ?>
            </table>
        </fieldset>
    </div>
    <div class="mainbodySpaceHolder">
    </div>
</div>

<div> <?php include("lib/error.php"); ?></div>
</body>
</html>