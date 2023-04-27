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
                        <label for="displayAllRepairJob" class="col-sm-2 col-form-label">Enter the month</label>
                        <div class="col-sm-10">
                            <input type="text" id="month" name="month" required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="displayAllRepairJob" class="col-sm-2 col-form-label">Enter the year</label>
                        <div class="col-sm-10">
                            <input type="text" id="year" name="year" required="required"><br>
                        </div>
                    </div>
                    <input type="submit" name="save" id="save" class="btn btn-info" value="submit" /> 
                </form>
                <h2 align="center">View Revenue</h2> 
                          <div class="table-responsive">  
                               <table class="table table-bordered table-hover">  
                               <thead class="thead-dark">
                                    <tr>
                                    <th scope="col">month</th>
                                    <th scope="col">year</th>
                                    <th scope="col">total revenue</th>
                                    </tr>
                                </thead>
                                   
<?php
include_once 'database.php';


function do_fetch($refcur)
{
    $nrows = oci_fetch_all($refcur, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

    if($nrows == 0){
             echo '<script type="text/javascript">alert("no data is present for this month and year");</script>';
         }

    foreach ($res as $col) {
        echo "<tr>\n";
        foreach ($col as $item) {
        echo "<td>".($item !== null ? htmlentities($item, ENT_QUOTES) : "")."</td>\n";
        }
        echo "</tr>\n";
    }

}

    
if(isset($_POST['save']))
{	 

    $month = $_POST['month'];    
	$year = $_POST['year'];

    $stmt = oci_parse($conn, 'BEGIN :result := get_total_revenue_per_month(:month, :year); END;');
    $result = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":month", $month);
    oci_bind_by_name($stmt, ":year", $year);
    oci_bind_by_name($stmt, ':result', $result, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($result);
    do_fetch($result);
    oci_free_statement($stmt);
    oci_close($conn);

}

?>
 </table>  
</div>   
</div>  
</div>  
</body>  
 </html>  