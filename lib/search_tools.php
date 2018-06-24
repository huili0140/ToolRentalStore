<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sdate_create = date_create($_POST['sdate']);
    $edate_create = date_create($_POST['edate']);
    $sdate = mysqli_real_escape_string($conn, $_POST['sdate']);
    $edate = mysqli_real_escape_string($conn, $_POST['edate']);
    $csearch = mysqli_real_escape_string($conn, $_POST['csearch']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $power_source = mysqli_real_escape_string($conn, $_POST['power_source']);
    $sub_type = mysqli_real_escape_string($conn, $_POST['sub_type']);
    $date_diff = date_diff($sdate_create, $edate_create) ->d;
    $_SESSION['date_diff'] = $date_diff;
    $_SESSION['start_date'] = $sdate;
    $_SESSION['end_date'] = $edate;
}
?>


<fieldset>
    <table>
        <tr>
            <td><div class="login_form_row">
                    <label class="login_label">Start Date:</label>
                    <input type="date" name="sdate"  required
                        <?php if(isset($_POST['sdate'])) echo 'value="'. $_POST['sdate'] .'""'?>/></div></td>
            <td><div class="login_form_row">
                    <label class="login_label">End Date:</label>
                    <input type="date" onchange="this.form.submit()" name="edate"  required
                        <?php if(isset($_POST['edate'])) echo 'value="'. $_POST['edate'] .'""'?>/></div></td>
            <td><div style="float: right"  class="login_form_row">
                    <label class="login_label">Custom Search:</label>
                    <input type="text" name="csearch"
                        <?php if(isset($_POST['csearch'])) echo 'value="'. $_POST['csearch'] .'""'?>/></div>

                    <input style="background-color: dodgerblue; float: right" type="submit" name = "action" Value="Search"/></td>
        </tr>
    </table>
    <table>
        <tr>
            <td>
                <input type="radio" onchange="this.form.submit()" name="type" value="all"
                    <?php if(!isset($_POST['type']) || (isset($_POST['type']) && $_POST['type'] == 'all')) echo ' checked="checked"'?>>All Tools
                <input type="radio" onchange="this.form.submit()" name="type" value="Hand"
                    <?php if(isset($_POST['type']) && $_POST['type'] == 'Hand') echo ' checked="checked"'?>>Hand Tool
                <input type="radio" onchange="this.form.submit()" name="type" value="Garden"
                    <?php if(isset($_POST['type']) && $_POST['type'] == 'Garden') echo ' checked="checked"'?>>Garden Tool
                <input type="radio" onchange="this.form.submit()" name="type" value="Ladder"
                    <?php if(isset($_POST['type']) && $_POST['type'] == 'Ladder') echo ' checked="checked"'?>>Ladder
                <input type="radio" onchange="this.form.submit()" name="type" value="Power"
                    <?php if(isset($_POST['type']) && $_POST['type'] == 'Power') echo ' checked="checked"'?>>Power Tool
            </td>
            <td>
                <select onchange="this.form.submit()" name="power_source">
                    <option selected value ="all_power_source">Power Source</option>
                    <option value="Manual"
                        <?php if(isset($_POST['power_source']) && $_POST['power_source'] == 'Manual') echo ' selected="true"'?>>Manual</option>
                    <option value="Electric"
                        <?php if(isset($_POST['power_source']) && $_POST['power_source'] == 'Electric') echo ' selected="true"'?>>A/C Corded</option>
                    <option value="Cordless"
                        <?php if(isset($_POST['power_source']) && $_POST['power_source'] == 'Cordless') echo ' selected="true"'?>>D/C Cordless</option>
                    <option value="Gas"
                        <?php if(isset($_POST['power_source']) && $_POST['power_source'] == 'Gas') echo ' selected="true"'?>>Gas</option>
                </select>
            </td>
            <td>
                <select name="sub_type">
                    <option selected value = "all_sub_type">Sub-Type</option>
                    <?php
                    if ($type == 'all') {
                        $query = "SELECT DISTINCT sub_type FROM tool ".
                            "WHERE power_source = '$power_source' ".
                            "ORDER BY sub_type ASC";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            echo '<option value = '. '"'. $row['sub_type'].'"';
                            if(isset($_POST['sub_type']) && $_POST['sub_type']==$row['sub_type']) echo " selected = \"true\"";
                            echo '>'. $row['sub_type'] . '</option>';
                        }
                    }
                    else {$query = "SELECT DISTINCT sub_type FROM tool WHERE category = '$type'".
                        "AND power_source = '$power_source'";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            echo '<option value = '. '"'. $row['sub_type'].'"';
                            if(isset($_POST['sub_type']) && $_POST['sub_type']==$row['sub_type']) echo " selected = \"true\"";
                            echo '>'. $row['sub_type'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </td></tr>
    </table>
</fieldset>
<?php
if ($sdate>=$edate && isset($_POST['edate'])){
    array_push($error_msg, "End date should be later than start date.");
}
if($_POST['action']=="Search" && $_POST['type']=="all" && $_POST['power_source']=="all_power_source" && $_POST['sub_type']="all_sub_type"){
    $query ="SELECT distinct toolID, description, ".
        "'$date_diff'*0.15*purchase_price AS rental_price, ".
        "purchase_price*0.4 AS deposit_price ".
        "FROM tool_outjoin_reservation ".
        "WHERE (end_date < '$sdate' OR start_date > '$edate' ".
        "OR (start_date IS NULL AND end_date IS NULL)) ".
        "AND description LIKE '%{$csearch}%'";
}
elseif($_POST['action']=="Search" && $_POST['type']!="all" && $_POST['power_source']=="all_power_source" && $_POST['sub_type']="all_sub_type"){
    $query ="SELECT distinct toolID, description, ".
        "'$date_diff'*0.15*purchase_price AS rental_price, ".
        "purchase_price*0.4 AS deposit_price ".
        "FROM tool_outjoin_reservation ".
        "WHERE (end_date < '$sdate' OR start_date > '$edate' ".
        "OR (start_date IS NULL AND end_date IS NULL)) ".
        "AND category ='$type' ".
        "AND description LIKE '%{$csearch}%'";
}
elseif($_POST['action']=="Search" && $_POST['type']=="all" && $_POST['power_source']!="all_power_source" && $_POST['sub_type']!="all_sub_type"){
    $query ="SELECT distinct toolID, description, ".
        "'$date_diff'*0.15*purchase_price AS rental_price, ".
        "purchase_price*0.4 AS deposit_price ".
        "FROM tool_outjoin_reservation ".
        "WHERE (end_date < '$sdate' OR start_date > '$edate' ".
        "OR (start_date IS NULL AND end_date IS NULL)) ".
        "AND power_source = '$power_source' ".
        "AND sub_type = '$sub_type' ".
        "AND description LIKE '%{$csearch}%'";
}elseif($_POST['action']=="Search" && $_POST['type']!="all" && $_POST['power_source']!="all_power_source" && $_POST['sub_type']!="all_sub_type"){
    $query ="SELECT distinct toolID, description, ".
        "'$date_diff'*0.15*purchase_price AS rental_price, ".
        "purchase_price*0.4 AS deposit_price ".
        "FROM tool_outjoin_reservation ".
        "WHERE (end_date < '$sdate' OR start_date > '$edate' ".
        "OR (start_date IS NULL AND end_date IS NULL)) ".
        "AND category = '$type' ".
        "AND power_source = '$power_source' ".
        "AND sub_type = '$sub_type' ".
        "AND description LIKE '%{$csearch}%'";
}
elseif($_POST['action']=="Search" && $_POST['type']=="all" && $_POST['power_source']!="all_power_source" && $_POST['sub_type']=="all_sub_type"){
    $query ="SELECT distinct toolID, description, ".
        "'$date_diff'*0.15*purchase_price AS rental_price, ".
        "purchase_price*0.4 AS deposit_price ".
        "FROM tool_outjoin_reservation ".
        "WHERE (end_date < '$sdate' OR start_date > '$edate' ".
        "OR (start_date IS NULL AND end_date IS NULL)) ".
        "AND power_source = '$power_source' ".
        "AND description LIKE '%{$csearch}%'";
}
elseif($_POST['action']=="Search" && $_POST['type']!="all" && $_POST['power_source']!="all_power_source" && $_POST['sub_type']=="all_sub_type"){
    $query ="SELECT distinct toolID, description, ".
        "'$date_diff'*0.15*purchase_price AS rental_price, ".
        "purchase_price*0.4 AS deposit_price ".
        "FROM tool_outjoin_reservation ".
        "WHERE (end_date < '$sdate' OR start_date > '$edate' ".
        "OR (start_date IS NULL AND end_date IS NULL)) ".
        "AND category = '$type' ".
        "AND power_source = '$power_source' ".
        "AND description LIKE '%{$csearch}%'";
}

$result = mysqli_query($conn, $query);
?>
