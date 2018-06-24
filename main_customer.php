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
            <li><a href="view_profile.php">View Profile</a></li>
            <li><a href="make_reservation.php">Make Reservation</a></li>
            <li><a href="check_tool_availability.php">Check Tool Availability</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    
    <div class="mainbody">
        <div class="mainbodySpaceHolder">
        </div>
            <div class="mainbodyWrapper1">
            <a class="formTitle">Main Menu</a><br>
                <li><a></a></li><br>
                <li><a href="view_profile.php">View Profile</a></li><br>
                <li><a href="make_reservation.php">Make Reservation</a></li><br>
                <li><a href="check_tool_availability.php">Check Tool Availability</a></li><br>
                <li><a href="logout.php">Logout</a></li><br>
                <li><a></a></li><br>
            </div>
        <div class="mainbodySpaceHolder">
        </div>
    </div>
</body>
</html>