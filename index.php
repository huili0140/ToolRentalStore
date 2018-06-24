<?php
session_start();

include 'lib/connection.php';

$email = $password = "";
$email_error = $password_error = "";

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
     
    
    // Eror Handlers
    if (empty($email)) {
        $email_error = "Please enter the email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format";
    }
    
    if (empty($password)) {
        $password_error = "Please enter the password.";
    } 
    
    if (!empty($email) && !empty($password) && $type == "customer") {
        $sql = "SELECT * FROM customer WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        
        if ($resultCheck < 1) {
            $email_error = "User doesn't exit, please register first.";
            
        } else {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $storedPwd = $row['password'];
            $storedPwdHash = password_hash($storedPwd, PASSWORD_DEFAULT); 
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $pwdCheck = password_verify($password, $storedPwdHash);
            
            if ($pwdCheck == false) {
                    $password_error = "Password incorrect.";
                    

            } elseif ($pwdCheck == true) {
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    header("Location: main_customer.php");
                    
            }
        }
    }
    
    if (!empty($email) && !empty($password) && $type == "clerk") {
        $sql = "SELECT * FROM clerk WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        
        if ($resultCheck < 1) {
            $email_error = "Clerk doesn't exit.";
            
        } else {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $storedPwd = $row['password'];
            $storedPwdHash = password_hash($storedPwd, PASSWORD_DEFAULT); 
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $pwdCheck = password_verify($password, $storedPwdHash);
            
            if ($pwdCheck == false) {
                    $password_error = "Password incorrect.";
                    
            } elseif ($pwdCheck == true) {
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    header("Location: main_clerk.php");
                    
            }
        }
    }
    
}

?>


<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
    <div class="header">
        <ul class="headerList">
            <li><a href="index.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </div>
    
    <div class="mainbody">
        <div class="mainbodySpaceHolder">
        </div>
        
        <div class="mainbodyWrapper2">
            <a>Login Form</a>
            <form action="index.php" method="POST">
                <span><?= $email_error ?></span>
                <input style="width: 90%" type="text" name="email" value="<?= $email?>" placeholder="Email"><br>
                <span><?= $password_error ?></span>
                <input style="width: 90%" type="password" name="password" value="<?= $password?>" placeholder="Password"><br>
                Customer<input type="radio" name="type" value="customer" checked="checked">
                Clerk<input type="radio" name="type" value="clerk"><br>
                <button type="submit", name="submit">Sign in</button>
    
            </form>
            <a></a>
            
        </div>
        <div class="mainbodySpaceHolder">
        </div>
    </div>
</body>
</html>