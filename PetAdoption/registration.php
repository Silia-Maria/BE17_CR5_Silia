<?php
session_start();
if (isset($_SESSION['user']) != "") {
    header("location: home.php");
}
if (isset($_SESSION['adm']) != "") {
    header("location: dashboard.php");
}

require_once "components/db_connect.php";
require_once "components/file_upload.php";

$error = false;
$fname = $lname = $email = $number = $address = $pass  = $picture = "";
$fnameError = $lnameError = $emailError = $numberError = $addressError = $passError = $picError = "";

// comes from Form
if (isset($_POST['btn-register'])) {
    $fname = trim($_POST['fname']);
    $fname = strip_tags($fname);
    $fname = htmlspecialchars($fname);

    $lname = trim($_POST['lname']);
    $lname = strip_tags($lname);
    $lname = htmlspecialchars($lname);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $number = trim($_POST['number']);
    $number = strip_tags($number);
    $number = htmlspecialchars($number);

    $address = trim($_POST['address']);
    $address = strip_tags($address);
    $address = htmlspecialchars($address);

    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $uploadError = "";
    $picture = file_upload($_FILES['picture']);

    // name Validation 
    if (empty($fname) || empty($lname)) {
        $error = true;
        $fnameError = "Please enter your Name and Surname.";
    } else if (strlen($fname) < 3 || strlen($lname) < 3) {
        $error = true;
        $fnameError = "Name and Surname must contain at least 3 Characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)) {
        $error = true;
        $fnameError = "Name and Surname can only contain letters and no space";
    }

    // email Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address.";
    } else {
        // check if Email exists already 
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email already in use.";
        }
    }

    //Number Validation
    if (strlen($number) < 10) {
        $error = true;
        $numberError = "Phone Number must have at least 10 digits.";
    }

    // address Validation 
    if (empty($address)) {
        $error = true;
        $addressError = "Please enter your address.";
    }

    //password Validation 
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter a password.";
    } else if (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must at least contain 6 characters.";
    }

    // password hashing for security
    $password = hash('sha256', $pass);

    // if there is no error
    if (!$error) {
        $query = "INSERT INTO users (first_name, last_name, email, phone_number, address, picture, password) VALUES ('$fname', '$lname', '$email', '$number', '$address', '$picture->fileName','$password')";
        $res = mysqli_query($connect, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now <br> <a href='index.php'>Click Here!</a>.";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : "";
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, please try again.";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : "";
        }
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Sheltered</title>
    <?php require_once "components/style.php" ?>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data" class="mx-auto w-75">
            <h2>Sign Up</h2>
            <?php
            if (isset($errMSG)) {
            ?>
                <div class="alert">
                    <p><?php echo $errMSG; ?></p>
                    <p><?php echo $uploadError; ?></p>
                </div>

            <?php
            }
            ?>
            <!---Name--->
            <div class="mb-4">
                <input type="text" class="w-100 " maxlength="50" name="fname" placeholder="First Name" value="<?php echo $fname ?>">
                <span class="text-danger small"><?php echo $fnameError ?></span>
            </div>

            <div class="mb-4">
                <input type="text" class="w-100 " maxlength="50" name="lname" placeholder="Last Name" value="<?php echo $lname ?>">
                <span class="text-danger small"><?php echo $fnameError ?></span>
            </div>
            <!---Email--->
            <div class="mb-4">
                <input type="email" class="w-100 " name="email" maxlength="40" placeholder="Email Address" value="<?php echo $email ?>">
                <span class="text-danger small"><?php echo $emailError ?></span>
            </div>
            <!---Phone number--->
            <div class="mb-4">
                <input type="text" class="w-100 " name="number" placeholder="Phone Number" maxlength="20" value="<?php echo $number ?>">
                <span class="text-danger small"><?php echo $numberError ?></span>
            </div>
            <!---Address--->
            <div class="mb-4">
                <input type="text" class="w-100 " name="address" placeholder="Address" maxlength="50" value="<?php echo $address ?>">
                <span class="text-danger small"><?php echo $addressError ?></span>
            </div>
            <!--- Picture--->
            <div class="mb-4">
                <input type="file" class="w-100 " name="picture">
                <span class="text-danger small"><?php echo $picError ?></span>
            </div>
            <!--- Password--->
            <div class="mb-4">
                <input type="password" class="w-100 " name="password" maxlength="15" placeholder="Password">
                <span class="text-danger small mb-5"><?php echo $passError ?></span>
            </div>

            <!--Button to register-->
            <button class="btn btn-outline-dark w-100 mb-4" name="btn-register" type="submit">Sign up</button>

            <p class="text-center">Already registered? <a href="index.php">Log in here!</a></p>

        </form>
    </div>

</body>

</html>