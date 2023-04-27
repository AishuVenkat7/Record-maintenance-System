<?php
// Include config file
include_once 'database.php';

// Define variables and initialize with empty values
$phone_num = $name = $city_name = $state_name = $zip_code = "";
$phone_num_err = $zip_code_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Validate zip_code
    if (empty(trim($_POST["zip_code"]))) {
        $zip_code_err = "Please enter a zip code.";
    } elseif (!preg_match('/^[0-9]{10}+$/', trim($_POST["zip_code"]))) {
        $zip_code_err = "zip code can only numbers.";
    }

    // Validate phone_num
    if (empty(trim($_POST["phone_num"]))) {
        $phone_num_err = "Please enter a phone number.";
    } elseif (!preg_match('/^[0-9]{10}+$/', trim($_POST["phone_num"]))) {
        $phone_num_err = "phone_num can only contain letters, numbers, and underscores.";
    } else {

        $param_phone_num = trim($_POST["phone_num"]);
        $query = oci_parse($conn, "select phone_num from customer where phone_num= :param_phone_num");
        oci_bind_by_name($query, ":param_phone_num", $param_phone_num);
        oci_execute($query, OCI_DEFAULT);

        $nrows = oci_fetch_all($query, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        echo "$nrows rows fetched<br>\n";

        if ($nrows == 1) {
            $phone_num_err = "This phone_num is already taken.";
        } else {
            $phone_num = trim($_POST["phone_num"]);
        }
    }

    // Check input errors before inserting in database
    if (empty($phone_num_err)) {

        echo "name";
        $name = $_POST['name'];
        $city_name = $_POST['city_name'];
        $state_name = $_POST['state_name'];
        $zip_code = $_POST['zip_code'];
        echo $name;
        $query = oci_parse($conn, "INSERT INTO customer(phone_num,name,city_name,state_name,zip_code) 
	    values ('$phone_num','$name','$city_name','$state_name','$zip_code')");

        if (oci_execute($query)) {
            // Redirect to login page
            header("location: login.php");
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Enter phone number</label>
                <input type="text" name="phone_num" class="form-control <?php echo (!empty($phone_num_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone_num; ?>">
                <span class="invalid-feedback"><?php echo $phone_num_err; ?></span>
            </div>
            <div class="form-group">
                <label>Enter Name</label>
                <input type="text" id="name" placeholder="name" name="name" class="form-control" value="<?php echo $name; ?>" required="required">
            </div>
            <div class="form-group">
                <label>Enter city name</label>
                <input type="text" id="city_name" name="city_name" placeholder="city name" class="form-control" value="<?php echo $city_name; ?>" required="required">
            </div>
            <div class="form-group">
                <label>Enter state name</label>
                <input type="text" id="state_name" name="state_name" placeholder="state name" class="form-control" value="<?php echo $state_name; ?>" required="required">
            </div>
            <div class="form-group">
                <label>Enter zip code</label>
                <input type="text" id="zip_code" name="zip_code" placeholder="zip code" class="form-control <?php echo (!empty($zip_code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $zip_code; ?>" required="required">
                <span class="invalid-feedback"><?php echo $zip_code_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Sign Up">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>

</html>