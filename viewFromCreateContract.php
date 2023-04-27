<html>

<head>
    <title>Dynamically Add or Remove input fields in PHP with JQuery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

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


                    function do_fetch($contractId, $refcur)
                    {
                        $nrows = oci_fetch_all($refcur, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

                        if ($nrows == 0) {
                            echo '<script type="text/javascript">alert("Enter a valid contract id");</script>';
                        }

                        foreach ($res as $col) {
                            echo "<tr>\n";
                            foreach ($col as $item) {
                                echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                            }
                            echo "</tr>\n";
                        }
                    }

                    if (isset($_POST['save'])) {
                        $contractId = $_POST['contract_id'];

                        $stid = oci_parse($conn, 'BEGIN get_contract_by_id(:contractId, :rc); END;');
                        $refcur = oci_new_cursor($conn);
                        oci_bind_by_name($stid, ":contractId", $contractId);
                        oci_bind_by_name($stid, ':rc', $refcur, -1, OCI_B_CURSOR);
                        oci_execute($stid);
                        oci_execute($refcur);
                        do_fetch($contractId, $refcur);
                        oci_free_statement($refcur);
                        oci_free_statement($stid);
                        oci_close($conn);
                    }

                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>