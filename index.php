<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Service Contract</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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


<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="completeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Customer Contract</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="add_form" id="add_form" method="post" action="#"> 
        <div class="modal-body"> 
                <div class="form-group">
                <table class="table table-bordered">  
                    <tr>
                    <td>
                    <label for="end_date">contract start date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                        placeholder="contract start date" required="required">
                    </td>
                    <td>
                    <label for="end_date">contract end date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                        placeholder="contract end date" required="required">
                    </td>
                    </tr>
                </table>
                </div>
                <div class="table-responsive">  
                    <table class="table table-bordered" id="dynamic_field">  
                        <tr>
                            <td>
                                <input type="text" id="item_id" name="item_id[]" placeholder="machine id" required="required">
                            </td>
                            <td>
                                <input type="text" id="make" name="make[]" placeholder="make" required="required">
                            </td>
                            <td>
                                <input type="text" id="model" name="model[]" placeholder="model" required="required">
                            </td>
                            <td>
                                <input type="text" id="year" name="year[]" placeholder="year" required="required">
                            </td>
                            <td>
                                <input type="text" id="machine_tye" name="machine_tye[]" placeholder="machine_type" required="required">
                            </td>
                            <td>
                            <input class="form-check-input" type="checkbox" id="hardware" name="hardware[]" value="h1">
                            <label class="form-check-label" for="hardware">hardware</label>
                            </td>
                            <td>
                            <input class="form-check-input" type="checkbox" id="software" name="software[]" value="s1">
                            <label class="form-check-label" for="software">software</label>
                            </td>
                            <td>
                            <input class="form-check-input" type="checkbox" id="peripheral" name="peripheral[]" value="p1">
                            <label class="form-check-label" for="peripheral">peripheral</label>
                            </td>
                            <td>
                            <button type="button" name="add" id="add" class="btn btn-success btn-xs">+</button>
                            </td>
                        </tr>
                    </table>
                </div>
        </div>
        <div class="modal-footer">
                <input type="submit" name="save" id="save" class="btn btn-success" value="Submit" /> 
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="container my-3">
        <h1 class="text-center">Add or remove contract</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#completeModal">
        Add new contract  
        </button>
</div>

<div>
<div id="displayDataTable"></div>
</div>


<script>

    $(document).ready(function(){  
    var i=1;  

    $('#add').click(function(){  
           i++;   
           $('#dynamic_field').append('<tr id="row'+i+'" class="append_item">'+
                '<td><input type="text" name="item_id[]" placeholder="machine id" required="required"></td>'+
                '<td><input type="text" name="make[]" placeholder="make" required="required"></td>'+
                '<td><input type="text" name="model[]" placeholder="model" required="required"></td>'+
                '<td><input type="text" name="year[]" placeholder="year" required="required"></td>'+
                '<td><input type="text" name="machine_tye[]" placeholder="machine_type" required="required"></td>'+
                '<td><input class="form-check-input" type="checkbox" id="hardware" name="hardware[]" value="h'+i+'">'+
                '<label class="form-check-label" for="hardware">hardware</label></td>'+
                '<td><input class="form-check-input" type="checkbox" id="software" name="software[]" value="s'+i+'">'+
                '<label class="form-check-label" for="software">software</label></td>'+
                '<td><input class="form-check-input" type="checkbox" id="peripheral" name="peripheral[]" value="p'+i+'">'+
                '<label class="form-check-label" for="peripheral">peripheral</label></td>'+
                '<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-xs">x</button>'+
                '</td></tr>');
    });  

    $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
    });  


    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
  
  // Set the initial min attribute of the end date input element to the current date
  endDateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
  
  startDateInput.addEventListener('change', function() {
    // Get the value of the start date input element
    const startDate = new Date(startDateInput.value);
    // Set the min attribute of the end date input element to the start date
    endDateInput.setAttribute('min', startDate.toISOString().split('T')[0]);
    
    // Disable previous end date
    // (30 * 24 * 60 * 60 * 1000)
    const previousEndDate = new Date(endDateInput.value);
    if (previousEndDate < startDate) {
      endDateInput.value = startDateInput.value;
    }
  });


    function displayData(cid1){
        var display = "true";
        $.ajax({
            url:'viewFromCreateContract.php',
            type:'post',
            data:{
                save: display,
                contract_id: cid1
            },
            success:function(data, status){
                 $("#displayDataTable").html(data);
             }
        });
    }

    $("#add_form").submit(function(e){
        e.preventDefault();
        $("#save").val('Submitting...');
        $.ajax({
            url:'createServiceContract.php',
            type:'post',
            dataType: 'json',
            data:$(this).serialize(),
            success:function(response){

                console.log("response ");
                //console.log(response);
                console.log(response.cid);
                 $("#save").val('Submit');
                 $("#add_form")[0].reset();
                 $(".append_item").remove();
                 $("#completeModal").modal('hide');
                 displayData(response.cid);
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