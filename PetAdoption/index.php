<?php
session_start();

require_once "components/db_connect.php";

if (isset($_SESSION['user']) != "") {
    header("location: home.php");
    exit;
}

if (isset($_SESSION['adm']) != "") {
    header("location: dashboard.php");
    exit;
}
$error = false;
$email = $password = $emailError = $passError = "";

if (isset($_POST['btn-login'])) {
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email address.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address.";
    }
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }

    // no error continue to login!
    if (!$error) {
        $password = hash('sha256', $pass);
        $sql = "SELECT * FROM users WHERE email='$email' AND password = '$password'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            if ($row['status'] == 'adm') {
                $_SESSION['adm'] = $row['user_id'];
                header("location: dashboard.php");
            } else {
                $_SESSION['user'] = $row['user_id'];
                header("location: home.php");
            }
        } else {
            $errMSG = "Incorrect Credentials, Try again...";
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
    <title>Login - Sheltered </title>
    <?php require_once "components/style.php"; ?>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class="mx-auto w-75" autocomplete="off">

            <h2>Login</h2>
            <?php
            if (isset($errMSG)) {
                echo $errMSG;
            }
            ?>
            <!--Email-->
            <div class="mb-4">
                <input type="text" autocomplete="off" class="w-100" name="email" placeholder="Email Address" value="<?php echo $email ?>">
                <span class="text-danger small"><?php echo $emailError ?></span>
            </div>
            <!--Password-->
            <div class="mb-4">
                <input type="password" autocomplete="off" class="w-100 mb-5" name="password" placeholder="Password">
                <span class="text-danger small"><?php echo $passError ?></span>
            </div>
            <!--Button Login-->
            <button class="btn btn-outline-dark w-100 mb-4" name="btn-login" type="submit">Sign up</button>
            <p class="text-center">Not registered yet? <a href="registration.php">Click here!</a></p>

        </form>
    </div>

</body>

</html>