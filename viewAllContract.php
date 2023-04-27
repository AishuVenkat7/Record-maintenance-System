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
            <h2 align="center">View Contract</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">contract id</th>
                            <th scope="col">start date</th>
                            <th scope="col">end date</th>
                            <th scope="col">status</th>
                            <th scope="col">phone number</th>
                            <th scope="col">item_id</th>
                            <th scope="col">make</th>
                            <th scope="col">model</th>
                            <th scope="col">year</th>
                            <th scope="col">Machine type</th>
                            <th scope="col">service type</th>
                            <th scope="col">fees(per month)</th>
                        </tr>
                    </thead>
                    <?php
                    include_once 'database.php';
                    // Initialize the session
                    session_start();

                    function do_fetch($phone_number, $query)
                    {

                        $nrows = oci_fetch_all($query, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

                        if ($nrows == 0) {
                            echo '<script type="text/javascript">alert("Enter a valid phone number");</script>';
                        }

                        foreach ($res as $col) {
                            echo "<tr>\n";
                            foreach ($col as $item) {
                                echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                            }
                            echo "</tr>\n";
                        }
                    }

                    $phone_number = $_SESSION["phone_num"];

                    $stmt = oci_parse($conn, 'BEGIN :result := getAllContract(:phoneNum); END;');
                    $result = oci_new_cursor($conn);
                    oci_bind_by_name($stmt, ":phoneNum", $phone_number);
                    oci_bind_by_name($stmt, ':result', $result, -1, OCI_B_CURSOR);

                    oci_execute($stmt);
                    oci_execute($result);
                    do_fetch($phone_number, $result);
                    oci_free_statement($stmt);
                    oci_close($conn);

                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>