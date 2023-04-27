<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif;}
    </style>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


    <h2 style="margin-top: 50px; text-align: center;">Record maintenance system</h2>
    <h3 class="my-5" style="text-align: center;">Hello user, <b><?php echo htmlspecialchars($_SESSION["phone_num"]); ?></b></h3>
<div class="container">
    <div class="form-group row">
        <label for="createServiceContract" class="col-sm-3 col-form-label">Create Service Contract</label>
        <div class="col-sm-9">
            <a href="index.php" class="btn btn-primary btn-sm active" 
                role="button" aria-pressed="true">Create Service Contract</a>
        </div>
    </div>
    <div class="form-group row">
        <label for="displayServiceContract" class="col-sm-3 col-form-label">Display a service contract by contract id</label>
        <div class="col-sm-9">
            <a href="ViewContract.php" class="btn btn-primary btn-sm active" 
                role="button" aria-pressed="true">View a single contract</a>
        </div>
    </div>
    <div class="form-group row">
        <label for="displayAllServiceContract" class="col-sm-3 col-form-label">Display all the service contract by phone number</label>
        <div class="col-sm-9">
            <a href="viewAllContract.php" class="btn btn-primary btn-sm active" 
                role="button" aria-pressed="true">View all contract</a>
        </div>
    </div>
    <div class="form-group row">
        <label for="createRepairJob" class="col-sm-3 col-form-label">Create a repair Job</label>
        <div class="col-sm-9">
            <a href="repairJobIndex.php" class="btn btn-primary btn-sm active" 
                role="button" aria-pressed="true">Create Repair job</a>
        </div>
    </div>
    <div class="form-group row">
        <label for="displayAllRepairJob" class="col-sm-3 col-form-label">Display all repair job</label>
        <div class="col-sm-9">
            <a href="displayAllRepairJob.php" class="btn btn-primary btn-sm active" 
                role="button" aria-pressed="true">Display Repair job</a>
        </div>
    </div>  
    <div class="form-group row">
        <label for="generateStatForRJ" class="col-sm-3 col-form-label">Generate Stat for repair job</label>
        <div class="col-sm-9">
            <a href="generateStatByMonth.php" class="btn btn-primary btn-sm active" 
                role="button" aria-pressed="true">Generate repair job Statistics</a>
        </div>
    </div>
    <div class="form-group row">
        <label for="generateStatForSC" class="col-sm-3 col-form-label">Generate Stat for service contract</label>
        <div class="col-sm-9">
            <a href="generateStatForSC.php" class="btn btn-primary btn-sm active" 
                role="button" aria-pressed="true">Generate service contract Statistics</a>
        </div>
    </div>
    <div class="form-group row">
        <label for="generateStatForSC" class="col-sm-3 col-form-label">Delete Service Contract</label>
        <div class="col-sm-9">
            <a href="deleteServiceContractIndex.php" class="btn btn-danger btn-sm active" 
                role="button" aria-pressed="true">Delete Service Contract</a>
        </div>
    </div>
</div>
    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
</body>
</html>