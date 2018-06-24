<?php
include("lib/connection.php");
$error = "";
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
if(!empty($_POST['tools_added']) && count($_POST['tools_added'])<=10) {
    $_SESSION['tools_added'] = $_POST['tools_added'];
    header(REFRESH_TIME . 'url=tools_addedto_reservation.php');
}
//if $tools_added >10, show error message.
elseif(count($_POST['tools_added'])>10){
    $error = "!---Max number of tools is 10.---!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Make Reservation</title>
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
        <span style="font-weight: bold; color: red;"><?php echo $error; ?></span>
        <form action="make_reservation.php" method="post" enctype="multipart/form-data">
            <div class="title">Make Reservation</div>

            <?php //search_tools.php is also used in check_tool_availability.php ?>
            <?php include("lib/search_tools.php"); ?>

            <form>
                <div class="title">Available Tools For Rent</div>
                <table>
                    <tr>
                        <td class="heading">Tool ID</td>
                        <td class="heading">Description</td>
                        <td class="heading">Rental Price</td>
                        <td class="heading">Deposit Price</td>
                        <td class="heading">Add</td>
                    </tr>
                    <?php
                    if($_POST['action']=="Search"){
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $toolID = urlencode($row['toolID']);
                            print "<tr>";
                            print "<td>" . $row['toolID'] . "</td>";
                            print "<td>" ."<a target='_blank' style=\"font-size: 12px; color: blue; text-transform: none\" href='tool_details_id.php?toolID=$toolID'>".$row['description']."</a></td>";
                            print "<td>" .number_format((float) $row['rental_price'],2). "</td>";
                            print "<td>" . number_format((float)$row['deposit_price'],2). "</td>";
                            print '<td><input type = "checkbox" name = "tools_added[]" value = '. $row['toolID'].'></td>';
                            print "</tr>";
                        }
                    }
                    ?>
                    <tr>
                        <td><input style="background-color: dodgerblue" type="submit" Value="Add To Reservation"/></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>


            </form>
    </div>
    <div class="mainbodySpaceHolder">
    </div>

</div>
<div> <?php include("lib/error.php"); ?></div>
</body>
</html>