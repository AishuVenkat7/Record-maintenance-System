<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}

// Include config file
include_once 'database.php';

// Define variables and initialize with empty values
$phone_num = $name = "";
$phone_num_err = $login_err = $name_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["phone_num"]))) {
        $phone_num_err = "Please enter phone number.";
    } else {
        $phone_num = trim($_POST["phone_num"]);
    }

    // Check if username is empty
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter the name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate credentials
    if (empty($phone_num_err) && empty($name_err)) {
        $param_phone_num = trim($_POST["phone_num"]);
        $param_name = trim($_POST["name"]);

        $query = oci_parse($conn, "select * from customer where phone_num= :param_phone_num and name= :paramName");
        oci_bind_by_name($query, ":param_phone_num", $param_phone_num);
        oci_bind_by_name($query, ":paramName", $param_name);
        oci_execute($query);

        $nrows = oci_fetch_all($query, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        echo "nrow " . $nrows;

        if ($nrows == 1) {
            session_start();
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["phone_num"] = $phone_num;

            // Redirect user to welcome page
            header("location: welcome.php");
        } else {
            // phone number doesn't exist, display a generic error message
            $login_err = "Invalid name and phone number";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Enter phone number</label>
                <input type="text" name="phone_num" class="form-control <?php echo (!empty($phone_num_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone_num; ?>" required="required">
                <span class="invalid-feedback"><?php echo $phone_num_err; ?></span>
            </div>
            <div class="form-group">
                <label>Enter name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" required="required">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>

</html>