<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Service Contract</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ margin-top: 30px; width: 600px; padding: 20px; }
    </style>
    </head>
  <body>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

  <p style="text-align:right; margin-top: 50px; margin-right: 50px;">
        <a href="welcome.php" class="btn btn-primary ml-3">back to main page</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>

<div class="wrapper">
    <h4>Create Repair Service</h4>
<form name="add_form" id="add_form" method="post" action="createRepairJob.php"> 
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="name" name="name" placeholder="name">
        </div>
    </div>
    <div class="form-group row">
        <label for="phoneNum" class="col-sm-3 col-form-label">Phone number</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="phone_num" name="phone_num" placeholder="phone number">
        </div>
    </div>
    <div class="form-group row">
        <label for="city" class="col-sm-3 col-form-label">City</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="city" name="city" placeholder="city">
        </div>
    </div>
    <div class="form-group row">
        <label for="city" class="col-sm-3 col-form-label">Machine Id</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="item_id" name="item_id" placeholder="item id">
        </div>
    </div>
    <div class="form-group row">
        <label for="service_type" class="col-sm-3 col-form-label">Service Type</label>
        <div class="form-group col-sm-9">
            <select class="custom-select" id="service_type" name="service_type">
                <option selected>Choose...</option>
                <option value="hardware">hardware</option>
                <option value="software">Software</option>
                <option value="peripheral">Peripheral</option>
            </select>
        </div>
    </div>
  <input type="submit" name="save" id="save" class="btn btn-success" value="Submit" /> 
</form>
</div> 

<div>
    <div id="displayDataTable"> </div>
</div>

<script>

$(document).ready(function(){  

    function displayData(rno1){
        var display = "true";
        $.ajax({
            url:'displayRepair.php',
            type:'post',
            data:{
                displaySend: display,
                rno: rno1
            },
            success:function(data, status){
                 console.log("response ",data);
                 $("#displayDataTable").html(data);
             }
        });
    }
   
    $("#add_form").submit(function(e){
        e.preventDefault();
        $("#save").val('Submitting...');
        $.ajax({
            url:'createRepairJob.php',
            type:'post',
            dataType: 'json',
            data:$(this).serialize(),
            success:function(response){
                 console.log("response ");
                 console.log(response.rno);
                 $("#save").val('Submit');
                 $("#add_form")[0].reset();
                 displayData(response.rno);
             },
            error: function(xhr, status, error) {
                // Handle errors here
                console.log("error");
                console.log(error);
            console.log(xhr.responseText);
            }
        });

    });

}); 
</script>
</body>
</html>