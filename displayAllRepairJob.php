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
                <h2 align="center">View All Repair Details</h2> 
                          <div class="table-responsive">  
                          <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">tracking_number</th>
                                    <th scope="col">item_id</th>
                                    <th scope="col">service_type</th>
                                    <th scope="col">phone_num</th>
                                    <th scope="col">labor_cost</th>
                                    <th scope="col">part_cost</th>
                                    <th scope="col">total_repair_cost</th>
                                    <th scope="col">date_of_service</th>
                                </tr>
                            </thead>

<?php

include_once 'database.php';

// Initialize the session
session_start();

    $phone_number = $_SESSION["phone_num"];

    $query = oci_parse($conn, 'BEGIN display_all_repair_details(:phoneNum, :rc); END;');
    $refcur = oci_new_cursor($conn);
    oci_bind_by_name($query, ":phoneNum", $phone_number);
    oci_bind_by_name($query, ':rc', $refcur, -1, OCI_B_CURSOR);
    oci_execute($query);
    oci_execute($refcur);  

    while ($row = oci_fetch_array($refcur, OCI_ASSOC+OCI_RETURN_NULLS)) {
        print "<tr>\n";
        foreach ($row as $item) {
            print "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
        }
        print "</tr>\n";
    }
    
    oci_free_statement($refcur);
    oci_free_statement($query);
    oci_close($conn);

?>
 </table>  
</div>   
</div>  
</div>  
</body>  
 </html>  