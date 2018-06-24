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
        <div class="mainbodyWrapper1">
            <a class="formTitle">Main Menu</a><br>
            <li><a></a></li><br>
            <li><a href="pickup_reservation.php">Pick-Up reservation</a></li><br>
            <li><a href="dropoff_reservation.php">drop-off reservation</a></li><br>
            <li><a href="add_new_tool.php">Add New Tool</a></li><br>
            <li><a href="generate_report.php">Generate report</a></li><br>
            <li><a href="logout.php">Logout</a></li>
            <li><a></a></li><br>
        </div>
    <div class="mainbodySpaceHolder">
    </div>
</div>
</body>
</html>