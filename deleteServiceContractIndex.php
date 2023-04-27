<html>

<head>
    <title>Dynamically Add or Remove input fields in PHP with JQuery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <p style="text-align:right; margin-top: 50px; margin-right: 50px;">
        <a href="welcome.php" class="btn btn-primary ml-3">back to main page</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>

    <div class="container">
        <br />
        <br />
        <div class="form-group">
            <form name="add_name" id="add_name" method="post" action="">
                <div class="form-group row">
                    <label for="phonenumber" class="col-sm-3 col-form-label">Enter phone number</label>
                    <div class="col-sm-9">
                        <input type="text" id="phone_num" name="phone_num" required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="contractid" class="col-sm-3 col-form-label">Enter the Contract id</label>
                    <div class="col-sm-9">
                        <input type="text" id="contract_id" name="contract_id" required="required"><br>
                    </div>
                </div>
                <input type="submit" name="save" id="save" class="btn btn-info" value="submit" />
            </form>
            <?php
            include_once 'database.php';

            if (isset($_POST['save']) && isset($_POST['phone_num'])) {

                $contractid = $_POST['contract_id'];
                $contractId = intval($contractid);

                $query = oci_parse($conn, "select contract_id from service_contract where contract_id= :contractId");
                oci_bind_by_name($query, ":contractId", $contractId);
                oci_execute($query, OCI_DEFAULT);

                $nrows = oci_fetch_all($query, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                if ($nrows == 0) {
                    echo '<script type="text/javascript">alert("Enter a valid contract id");</script>';
                }

                if ($nrows != 0) {
                    $name = "";
                    $address = "";
                    $phone_num = $_POST["phone_num"];
                    $query1 = oci_parse($conn, "select name, city_name, state_name,zip_code from customer where phone_num= :phoneNumber");
                    oci_bind_by_name($query1, ":phoneNumber", $phone_num);
                    oci_execute($query1);
                    while (($row = oci_fetch_row($query1)) != false) {
                        $name = $row[0];
                        $city_name = $row[1];
                        $state_name = $row[2];
                        $zip_code = $row[3];
                        $current_date = date("Y-m-d");
                        $query7 = oci_parse($conn, "INSERT INTO del_customer(phone_num,contract_id, name, city_name, 
                        state_name, zip_code, cancel_date)values($phone_num, '$contractId', '$name',
                        '$city_name','$state_name', $zip_code, DATE '$current_date')");
                        oci_execute($query7);
                    }
                    $query3 = oci_parse($conn, "UPDATE service_contract SET status = 'inactive' where contract_id = :contractId");
                    oci_bind_by_name($query3, ":contractId", $contractId);
                    $result2 = oci_execute($query3);
                    if ($result2) {
                        echo "Data deleted Successfully!";
                    }
                }
                oci_close($conn);
            }

            ?>
        </div>
    </div>
</body>

</html>