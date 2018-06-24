<?php
session_start();

include 'lib/connection.php';

$first_name = $middle_name = $last_name = "";
$work_phone = $home_phone = $cell_phone = $primariy_phone = "";
$email = $password = $password_retype = "";
$street = $city = $state = $zip_code = "";
$name = $number = $month = $year = $cvc = "";
$first_name_error = $last_name_error = $email_error = $primary_phone_error = "";
$password_error = $password_retype_error = $success = "";

if (isset($_POST['submit'])) {

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $work_phone = mysqli_real_escape_string($conn, $_POST['work_phone']);
    $home_phone = mysqli_real_escape_string($conn, $_POST['home_phone']);
    $cell_phone = mysqli_real_escape_string($conn, $_POST['cell_phone']);
    $primary_phone = mysqli_real_escape_string($conn, $_POST['primary_phone']);

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password_retype = mysqli_real_escape_string($conn, $_POST['password_retype']);

    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $zip_code = mysqli_real_escape_string($conn, $_POST['zip_code']);

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $month = mysqli_real_escape_string($conn, $_POST['month']);
    $year= mysqli_real_escape_string($conn, $_POST['year']);
    $cvc = mysqli_real_escape_string($conn, $_POST['cvc']);
     
    
    // Error Handlers
    if (empty($first_name)) {
        $first_name_error = "Please enter the first name. ";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
        $first_name_error = "Invalid first name. ";
    }

    if (empty($last_name)) {
        $last_name_error = "Please enter the last name. ";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
        $last_name_error = "Invalid last name. ";
    }

    if (empty($primary_phone)) {
        $primary_phone_error = "Please enter the primary phone number. ";
    } else {
        if (!empty($home_phone) && !preg_match("/^[0-9]*$/", $home_phone)) {
            $primary_phone_error = "Invalid phone number.";
        }
        if (!empty($cell_phone) && !preg_match("/^[0-9]*$/", $cell_phone)) {
            $primary_phone_error = "Invalid phone number.";
        }
        if (!empty($work_phone) && !preg_match("/^[0-9]*$/", $work_phone)) {
            $primary_phone_error = "Invalid phone number.";
        }
        if ($primary_phone == "H") {
            if (empty($home_phone)) {
                $primary_phone_error = "Please enter home phone number. ";
            } else {
                $primary_phone = $home_phone;
            }
        } elseif ($primary_phone == "C") {
            if (empty($cell_phone)) {
                $primary_phone_error = "Please enter cell phone number. ";
            } else {
                $primary_phone = $home_phone;
            }
        } else {
            if (empty($work_phone)) {
                $primary_phone_error = "Please enter work phone number. ";
            } else {
                $primary_phone = $home_phone;
            }
        }
    }



    if (empty($email)) {
        $email_error = "Please enter the email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format. ";
    } else {
        $sql = "SELECT * FROM customer WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            $email_error = "Username exists already. ";
        } else {
            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        }
    }

    if (empty($password)) {
        $password_error = "Please enter the password.";
    }

    if (empty($password_retype)) {
        $password_retype_error = "Please re-enter the password.";
    } elseif ($password != $password_retype) {
        $password_retype_error = "Please re-enter the password. ";
    }


    if ($first_name_error == "" && $last_name_error == "" && $email_error == "" && $password_error == "" && $password_retype_error == "" && $primary_phone_error == "") {
        $sql = "INSERT INTO Customer (email, password, first_name, middle_name, last_name, street_address, city, state, " .
            "zip, primary_phone, home_phone, work_phone, cell_phone) VALUES ('$email', '$password', '$first_name', " .
            "'$middle_name', '$last_name', '$street', '$city', '$state', '$zip_code', '$primary_phone', '$home_phone', " .
            "'$work_phone', '$cell_phone'); ";
        mysqli_query($conn, $sql);
        echo mysqli_error($conn);
        if (mysqli_affected_rows($conn) == -1) {
            echo "not inserted....";
        }

        $sql= "INSERT INTO CreditCard (email, name, number, cvc, exp_mon, exp_yr) " .
            "VALUES ('$email', '$name', '$number', '$cvc', '$month', '$year');";
            mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) == -1) {
            echo "not inserted....";
        }
        $success = "You are successfully registered, please log in. ";

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
        
        <div class="mainbodyWrapper1">
            <a class="formTitle">Customer Registration Form</a>
            <form action="register.php" method="POST">
                <span><?= $first_name_error ?></span>
                <span><?= $last_name_error ?></span>
                <span><?= $primary_phone_error ?></span><br>

                <input type="text" name="first_name" value="<?= $first_name?>" placeholder="First Name">
                <input type="text" name="middle_name" value="<?= $middle_name?>" placeholder="Middle Name">
                <input type="text" name="last_name" value="<?= $last_name?>" placeholder="Last Name"><br>
                <input type="text" name="home_phone" value="<?= $home_phone?>" placeholder="Home Phone">
                <input type="text" name="work_phone" value="<?= $work_phone?>" placeholder="Work Phone">
                <input type="text" name="cell_phone" value="<?= $cell_phone?>" placeholder="Cell Phone"><br>
                
                <a class="primaryPhone">Primary Phone</a>
                Home Phone<input type="radio" name="primary_phone" value="H">
                Work Phone<input type="radio" name="primary_phone" value="W">
                Cell Phone<input type="radio" name="primary_phone" value="C"><br>

                <span><?= $email_error ?></span>
                <span><?= $password_error ?></span>
                <span><?= $password_retype_error ?></span><br>

                <input type="text" name="email" value="<?= $email?>" placeholder="Email Address">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="password_retype" placeholder="Re-type Password"><br>
                
                <input type="text" name="street" value="<?= $street?>" placeholder="Street Address">
                <input type="text" name="city" value="<?= $city?>" placeholder="City">
                <select class="pulldown" name="state" value="<?= $state?>">
                        <option value="" selected disabled hidden>Select a State...</option>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                </select>				
                <input type="text" name="zip_code" value="<?= $zip_code?>" placeholder="Zip Code"><br>
                
                <a>           </a><br>
                <a>Credit Card</a><br>
                <input type="text" name="name" value="<?= $name?>" placeholder="Name on Credit Card">
                <input type="text" name="number" value="<?= $number?>" placeholder="Credit Card Number">
                <input type="text" name="cvc" value="<?= $cvc?>" placeholder="CVC"><br>
                
                <select class="pulldown" name="month" value="<?= $month?>">
                        <option value="">Expiration Month</option>
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
                <select class="pulldown" name="year" value="<?= $year?>">
                        <option value="">Expiration Year</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                </select>
                
                <li><a></a></li><br>                                                                                                                                                                                                                                        
                <button type="submit", name="submit">Register</button>
                <div class="success"><?= $success ?></div>
            </form>
        <a></a>
        </div>
        <div class="mainbodySpaceHolder">
        </div>
    </div>
</body>
</html>