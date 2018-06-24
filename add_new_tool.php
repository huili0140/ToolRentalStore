<?php
session_start();
include 'lib/connection.php';

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$type = $power_source = $sub_type = $n_acc = "";
$sub_option = $purchase_price = $manufac = $width = $length = $weight = "";
$min_rpm_rating = $max_rpm_rating = $amp_rating =$volt_rating = "";

$adjustable_clutch = $min_torque_rating = $max_torque_rating = $blade_size = "";
$dust_bag = $tank_size = $pressure_rating = $motor_rating = $drum_size = $power_rating = "";

$acc_quantity_1 = $acc_description_1 = $battery_type_1 = "";
$acc_quantity_2 = $acc_description_2 = $battery_type_2 = "";
$acc_quantity_3 = $acc_description_3 = $battery_type_3 = "";

$success = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $power_source = mysqli_real_escape_string($conn, $_POST['power_source']);
    $sub_type = mysqli_real_escape_string($conn, $_POST['sub_type']);
    $sub_option = mysqli_real_escape_string($conn, $_POST['sub_option']);
    $purchase_price = mysqli_real_escape_string($conn, $_POST['purchase_price']);
    $manufac = mysqli_real_escape_string($conn, $_POST['manufac']);
    $width = mysqli_real_escape_string($conn, $_POST['width']);
    $length = mysqli_real_escape_string($conn, $_POST['length']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $n_acc = mysqli_real_escape_string($conn, $_POST['n_acc']);

    $min_rpm_rating = mysqli_real_escape_string($conn, $_POST['min_rpm_rating']);
    $max_rpm_rating = mysqli_real_escape_string($conn, $_POST['max_rpm_rating']);
    $amp_rating = mysqli_real_escape_string($conn, $_POST['amp_rating']);
    $volt_rating = mysqli_real_escape_string($conn, $_POST['volt_rating']);

    $adjustable_clutch = mysqli_real_escape_string($conn, $_POST['adjustable_clutch']);
    $min_torque_rating = mysqli_real_escape_string($conn, $_POST['min_torque_rating']);
    $max_torque_rating = mysqli_real_escape_string($conn, $_POST['max_torque_rating']);
    $blade_size = mysqli_real_escape_string($conn, $_POST['blade_size']);

    $dust_bag = mysqli_real_escape_string($conn, $_POST['dust_bag']);
    $tank_size = mysqli_real_escape_string($conn, $_POST['tank_size']);
    $pressure_rating = mysqli_real_escape_string($conn, $_POST['pressure_rating']);
    $motor_rating = mysqli_real_escape_string($conn, $_POST['motor_rating']);
    $drum_size = mysqli_real_escape_string($conn, $_POST['drum_size']);
    $power_rating = mysqli_real_escape_string($conn, $_POST['power_rating']);

    $acc_quantity_1 = mysqli_real_escape_string($conn, $_POST['acc_quantity_1']);
    $acc_description_1 = mysqli_real_escape_string($conn, $_POST['acc_description_1']);
    $battery_type_1 = mysqli_real_escape_string($conn, $_POST['battery_type_1']);

    $acc_quantity_2 = mysqli_real_escape_string($conn, $_POST['acc_quantity_2']);
    $acc_description_2 = mysqli_real_escape_string($conn, $_POST['acc_description_2']);
    $battery_type_2 = mysqli_real_escape_string($conn, $_POST['battery_type_2']);

    $acc_quantity_3 = mysqli_real_escape_string($conn, $_POST['acc_quantity_3']);
    $acc_description_3 = mysqli_real_escape_string($conn, $_POST['acc_description_3']);
    $battery_type_3 = mysqli_real_escape_string($conn, $_POST['battery_type_3']);

    $new_tID == "";

    if ($type == "Power" && $power_source != "" && $sub_type != "" && $sub_option != "" && $n_acc != "" && $volt_rating != "" && $amp_rating != "" && $min_rpm_rating != "" && $max_rpm_rating != "" ) {
        $sql = "INSERT INTO Tool (purchase_price, power_source, category, sub_type, sub_option, width_diameter, length, weight, manufacturer, status) " .
            "VALUES ('$purchase_price', '$power_source', '$type', '$sub_type', '$sub_option', '$width', '$length', '$weight', '$manufac', 'Available');";
        mysqli_query($conn, $sql);
        // echo mysqli_error($conn);
        $new_tID = mysqli_insert_id($conn);


        $sql="UPDATE tool SET description = IF(power_source='Manual', CONCAT(sub_option, ' ', sub_type), " .
            " CONCAT(power_source, ' ', sub_option, ' ', sub_type)) where toolID = '$new_tID';";
        mysqli_query($conn, $sql);
        // echo mysqli_error($conn);

        if ($type == "Power" && $sub_type== "Drill") {


            $sql = "insert into PowerDrill (toolID, adjustable_clutch, min_torque_rating, max_torque_rating, volt_rating, amp_rating, " .
                " min_rpm_rating, max_rpm_rating) VALUES ('$new_tID', '$adjustable_clutch', '$min_torque_rating', '$max_torque_rating', " .
                "'$volt_rating', '$amp_rating', '$min_rpm_rating', '$max_rpm_rating');";
            mysqli_query($conn, $sql);
            // echo mysqli_error($conn);

        } elseif ($type == "Power" && $sub_type== "Saw") {
            $sql = "INSERT INTO PowerSaw (toolID, blade_size, volt_rating, amp_rating, min_rpm_rating, max_rpm_rating) VALUES " .
                "('$new_tID', '$blade_size', '$volt_rating', '$amp_rating', '$min_rpm_rating', '$max_rpm_rating'); ";
            mysqli_query($conn, $sql);
            // echo mysqli_error($conn);

        } elseif ($type == "Power" && $sub_type== "Sander") {
            $sql = "INSERT INTO PowerSander (toolID, dust_bag, volt_rating, amp_rating, min_rpm_rating, max_rpm_rating) VALUES " .
                "('$new_tID', '$dust_bag', '$volt_rating', '$amp_rating', '$min_rpm_rating', '$max_rpm_rating'); ";
            mysqli_query($conn, $sql);
            // echo mysqli_error($conn);

        } elseif ($type == "Power" && $sub_type== "Air Compressor") {
            $sql = "INSERT INTO PowerAirCompressor (toolID, tank_size, pressure_rating, volt_rating, amp_rating, min_rpm_rating, " .
                "max_rpm_rating) VALUES ('$new_tID', '$tank_size', '$pressure_rating', '$volt_rating', '$amp_rating', '$min_rpm_rating', '$max_rpm_rating'); ";
            mysqli_query($conn, $sql);
            // echo mysqli_error($conn);

        } elseif ($type == "Power" && $sub_type== "Mixer") {
            $sql = "INSERT INTO PowerMixer (toolID, motor_rating, drum_size, volt_rating, amp_rating, min_rpm_rating, max_rpm_rating) " .
                "VALUES ('$new_tID', '$motor_rating', '$drum_size', '$volt_rating', '$amp_rating', '$min_rpm_rating', '$max_rpm_rating'); ";
            mysqli_query($conn, $sql);
            // echo mysqli_error($conn);

        } elseif ($type == "Power" && $sub_type== "Generator") {
            $sql = "INSERT INTO PowerGenerator (toolID, power_rating, volt_rating, amp_rating, min_rpm_rating, max_rpm_rating) " .
                " VALUES ('$new_tID', '$power_rating', '$volt_rating', '$amp_rating', '$min_rpm_rating', '$max_rpm_rating');  ";
            mysqli_query($conn, $sql);
            // echo mysqli_error($conn);
        }

        if ($acc_description_1 != "" || $acc_quantity_1 != "" || $battery_type_1 != "") {
            $sql = "INSERT INTO Accessory (acc_quantity, acc_description, battery_type) " .
                "VALUES ('$acc_quantity_1', '$acc_description_1', '$battery_type_1'); ";
            mysqli_query($conn, $sql);
            // echo mysqli_error($conn);

            $new_aID = mysqli_insert_id($conn);
            $sql = "INSERT INTO ToolAccessory (toolID, accessoryID) VALUES ('$new_tID', '$new_aID'); ";
            mysqli_query($conn, $sql);
            // echo mysqli_error($conn);
        }

                if ($acc_description_1 != "" || $acc_quantity_1 != "" || $battery_type_1 != "") {
                    $sql = "INSERT INTO Accessory (acc_quantity, acc_description, battery_type) " .
                        "VALUES ('$acc_quantity_2', '$acc_description_2', '$battery_type_2'); ";
                    mysqli_query($conn, $sql);
                    // echo mysqli_error($conn);

                    $new_aID = mysqli_insert_id($conn);
                    $sql = "INSERT INTO ToolAccessory (toolID, accessoryID) VALUES ('$new_tID', '$new_aID'); ";
                    mysqli_query($conn, $sql);
                    // echo mysqli_error($conn);
                }

                        if ($acc_description_1 != "" || $acc_quantity_1 != "" || $battery_type_1 != "") {
                            $sql = "INSERT INTO Accessory (acc_quantity, acc_description, battery_type) " .
                                "VALUES ('$acc_quantity_3', '$acc_description_3', '$battery_type_3'); ";
                            mysqli_query($conn, $sql);
                            // echo mysqli_error($conn);

                            $new_aID = mysqli_insert_id($conn);
                            $sql = "INSERT INTO ToolAccessory (toolID, accessoryID) VALUES ('$new_tID', '$new_aID'); ";
                            mysqli_query($conn, $sql);
                            // echo mysqli_error($conn);
                        }

        if ($new_tID != "" && $n_acc != "" && $volt_rating != "" && $amp_rating != "" && $min_rpm_rating != "" && $max_rpm_rating != "") {
            $success = "New tool successfully added. ";
        }
    }

    if ($type != "" &&  $type != "Power" && $power_source != "" && $sub_type != "" && $sub_option != "" && $purchase_price != "") {
        $sql = "INSERT INTO Tool (purchase_price, power_source, category, sub_type, sub_option, width_diameter, length, weight, manufacturer, status) " .
            "VALUES ('$purchase_price', '$power_source', '$type', '$sub_type', '$sub_option', '$width', '$length', '$weight', '$manufac', 'Available');";
        mysqli_query($conn, $sql);
        // echo mysqli_error($conn);
        $new_tID = mysqli_insert_id($conn);


        $sql = "UPDATE tool SET description = IF(power_source='Manual', CONCAT(sub_option, ' ', sub_type), " .
            " CONCAT(power_source, ' ', sub_option, ' ', sub_type)) where toolID = '$new_tID';";
        mysqli_query($conn, $sql);
        // echo mysqli_error($conn);

        $success = "New tool successfully added. ";
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
        <a class="formTitle">Add Tool</a><br>
        <li><a></a></li><br>
        <form action="add_new_tool.php" method="POST">
            <div><a class="primaryPhone">Type</a>

            <input type="radio" onchange="this.form.submit()" name="type" value="Hand"
                <?php if(isset($_POST['type']) && $_POST['type'] == 'Hand') echo ' checked="checked"'?>>Hand Tool
            <input type="radio" onchange="this.form.submit()" name="type" value="Garden"
                <?php if(isset($_POST['type']) && $_POST['type'] == 'Garden') echo ' checked="checked"'?>>Garden Tool
            <input type="radio" onchange="this.form.submit()" name="type" value="Ladder"
                <?php if(isset($_POST['type']) && $_POST['type'] == 'Ladder') echo ' checked="checked"'?>>Ladder
            <input type="radio" onchange="this.form.submit()" name="type" value="Power"
                <?php if(isset($_POST['type']) && $_POST['type'] == 'Power') echo ' checked="checked"'?>>Power Tool
            </div>

            <div>
                <div class="cell3">
                    <label class="primaryPhone">Power Source</label>
                <select onchange="this.form.submit()" name="power_source" required>
                <option selected disabled>Power Source</option>
                    <?php
                    $query = "SELECT DISTINCT power_source FROM tool WHERE category = '$type'";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo '<option value = '. '"'. $row['power_source'].'"';
                        if(isset($_POST['power_source']) && $_POST['power_source']==$row['power_source']) echo " selected = \"true\"";
                        echo '>'. $row['power_source'] . '</option>';
                    }
                    ?>
                </select>
                </div>

                <div class="cell3"><label class="primaryPhone">Sub-Type</label>
                <select onchange="this.form.submit()" name="sub_type" required>
                <option selected disabled>Sub-Type</option>
                <?php
                $query = "SELECT DISTINCT sub_type FROM tool WHERE category = '$type'".
                    "AND power_source = '$power_source'";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo '<option value = '. '"'. $row['sub_type'].'"';
                    if(isset($_POST['sub_type']) && $_POST['sub_type']==$row['sub_type']) echo " selected = \"true\"";
                    echo '>'. $row['sub_type'] . '</option>';
                }
                ?>
                </select></div>

                <div class="cell3"><label class="primaryPhone">Sub-Option</label>
                <select onchange="this.form.submit()" name="sub_option" required>
                <option selected disabled>Sub-Option</option>
                <?php
                $query = "SELECT DISTINCT sub_option FROM tool WHERE category = '$type'".
                    "AND power_source = '$power_source' and sub_type = '$sub_type'";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo '<option value = '. '"'. $row['sub_option'].'"';
                    if(isset($_POST['sub_option']) && $_POST['sub_option']==$row['sub_option']) echo " selected = \"true\"";
                    echo '>'. $row['sub_option'] . '</option>';
                }
                ?>
                </select></div>


            </div>

            <div>
                <div class="cell3"><label class="primaryPhone">Purchase Price ($)</label>
                    <input type="text" name="purchase_price" value="<?= $purchase_price?>" required></div>
                <div class="cell3"><label class="primaryPhone">Manufacturer</label>
                    <input type="text" name="manufac" value="<?= $manufac?>"  required></div>
                <div class="cell3"><label class="primaryPhone">Weight (lbs)    </label>
                    <input type="text" name="weight" value="<?= $weight?>"  required></div>
            </div>
            <div>
                <div class="cell3"><label class="primaryPhone">Width (inches)  </label>
                    <input type="text" name="width" value="<?= $width?>"  required></div>
                <div class="cell3"><label class="primaryPhone">Length (feet)</label>
                    <input type="text" name="length" value="<?= $length?>"  required></div>
                <?php
                if ($type == "Power") {
                    echo '<div class="cell3"><label class="primaryPhone">Number of Accessories</label>';
                    echo '<select onchange="this.form.submit()" name="n_acc" required>';
                    echo '<option selected disabled>Number of Accessories</option>';
                    $arr = array(0, 1, 2, 3);
                    foreach ($arr as &$value) {
                        echo '<option value = ' . '"' . $value . '"';
                        if (isset($_POST['n_acc']) && $_POST['n_acc'] == $value) echo " selected = \"true\"";
                        echo '>' . $value . '</option>';
                    }
                    echo '</select></div>';
                }
                ?>

            </div>

            <?php
            if ($type == "Power" && $n_acc != "") {


                echo '<li><a></a></li><br>';
                echo '<li><a>Power Tools Only</a></li><br>';
                echo '<div>';
                echo '<div class="cell3"><label class="primaryPhone">Volt Rating</label>';
                echo '<input type="text" name="volt_rating" value="'.$volt_rating.'" required></div>';
                echo '<div class="cell3"><label class="primaryPhone">Amp Rating</label>';
                echo '<input type="text" name="amp_rating" value="'.$amp_rating.'" required></div>';
                echo '</div>';
                echo '<div>';
                echo '<div class="cell3"><label class="primaryPhone">Minimum RPM Rating</label>';
                echo '<input type="text" name="min_rpm_rating" value="'.$min_rpm_rating.'" required></div>';
                echo '<div class="cell3"><label class="primaryPhone">Maximum RPM Rating</label>';
                echo '<input type="text" name="max_rpm_rating" value="'.$max_rpm_rating.'" required></div>';
                echo '</div>';

                if ($sub_type == "Drill") {
                    echo '<div>';
                    echo '<div class="cell3"><label class="primaryPhone">Adjustable Clutch</label>';
                    echo '<input type="text" name="adjustable_clutch" value="'.$adjustable_clutch.'" required></div>';
                    echo '<div class="cell3"><label class="primaryPhone">Minimum Torque Rating</label>';
                    echo '<input type="text" name="min_torque_rating" value="'.$min_torque_rating.'" required></div>';
                    echo '<div class="cell3"><label class="primaryPhone">Maximum Torque Rating</label>';
                    echo '<input type="text" name="max_torque_rating" value="'.$max_torque_rating.'" required></div>';
                    echo '</div>';
                } elseif ($sub_type == "Saw") {
                    echo '<div>';
                    echo '<div class="cell3"><label class="primaryPhone">Blade Size</label>';
                    echo '<input type="text" name="blade_size" value="'.$blade_size.'" required></div>';

                    echo '</div>';

                } elseif ($sub_type == "Sander") {
                    echo '<div>';
                    echo '<div class="cell3"><label class="primaryPhone">Dust Bag</label>';
                    echo '<input type="text" name="dust_bag" value="'.$dust_bag.'" required></div>';

                    echo '</div>';
                } elseif ($sub_type == "Air Compressor") {
                    echo '<div>';
                    echo '<div class="cell3"><label class="primaryPhone">Tank Size</label>';
                    echo '<input type="text" name="tank_size" value="'.$tank_size.'" required></div>';
                    echo '<div class="cell3"><label class="primaryPhone">Pressure Rating</label>';
                    echo '<input type="text" name="pressure_rating" value="'.$pressure_rating.'" required></div>';
                    echo '</div>';
                } elseif ($sub_type == "Mixer") {
                    echo '<div>';
                    echo '<div class="cell3"><label class="primaryPhone">Drum Size</label>';
                    echo '<input type="text" name="drum_size" value="'.$drum_size.'" required></div>';
                    echo '<div class="cell3"><label class="primaryPhone">Motor Rating</label>';
                    echo '<input type="text" name="motor_rating" value="'.$motor_rating.'" required></div>';
                    echo '</div>';

                } elseif ($sub_type == "Generator") {
                    echo '<div>';
                    echo '<div class="cell3"><label class="primaryPhone">Power Rating</label>';
                    echo '<input type="text" name="power_rating" value="'.$power_rating.'" required></div>';

                    echo '</div>';
                }

                echo '<li><a></a></li><br>';
                echo '<li><a>Accessories</a></li><br>';


                if ($n_acc == 1 || $n_acc == 2 || $n_acc == 3) {
                    echo '<div>';
                    echo '<div class="cell3"><label class="primaryPhone">Accessory Quantity</label>';
                    echo '<input type="text" name="acc_quantity_1" value="'.$acc_quantity_1.'"></div>';
                    echo '<div class="cell3"><label class="primaryPhone">Accessory Description</label>';
                    echo '<input type="text" name="acc_description_1" value="'.$acc_description_1.'"></div>';
                    echo '<div class="cell3"><label class="primaryPhone">Battery Type</label>';
                    echo '<input type="text" name="battery_type_1" value="'.$battery_type_1.'"></div>';
                    echo '</div>';

                }

                if ($n_acc == 2 || $n_acc == 3) {
                    echo '<div>';
                    echo '<div class="cell3"><label class="primaryPhone">Accessory Quantity</label>';
                    echo '<input type="text" name="acc_quantity_2" value="'.$acc_quantity_2.'"></div>';
                    echo '<div class="cell3"><label class="primaryPhone">Accessory Description</label>';
                    echo '<input type="text" name="acc_description_2" value="'.$acc_description_2.'"></div>';
                    echo '<div class="cell3"><label class="primaryPhone">Battery Type</label>';
                    echo '<input type="text" name="battery_type_2" value="'.$battery_type_2.'"></div>';
                    echo '</div>';
                }

                if ($n_acc == 3) {
                    echo '<div>';
                    echo '<div class="cell3"><label class="primaryPhone">Accessory Quantity</label>';
                    echo '<input type="text" name="acc_quantity_3" value="'.$acc_quantity_3.'"></div>';
                    echo '<div class="cell3"><label class="primaryPhone">Accessory Description</label>';
                    echo '<input type="text" name="acc_description_3" value="'.$acc_description_3.'"></div>';
                    echo '<div class="cell3"><label class="primaryPhone">Battery Type</label>';
                    echo '<input type="text" name="battery_type_3" value="'.$battery_type_3.'"></div>';
                    echo '</div>';
                }
            }

            ?>
            <li><a></a></li><br>
            <input style="background-color: dodgerblue; width: 100px" type="submit" Value="Confirm"/>
            <div class="success"><?= $success ?></div>

        </form>
        <li><a></a></li><br>
    </div>
    <div class="mainbodySpaceHolder">
    </div>
</div>
</body>
</html>
