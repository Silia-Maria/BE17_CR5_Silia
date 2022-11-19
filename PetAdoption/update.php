<?php
session_start();
require_once "components/db_connect.php";
require_once "components/file_upload.php";

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: index.php");
    exit;
}

$backBtn = "";
//user
if (isset($_SESSION['user'])) {
    $backBtn = "home.php";
}

//adm
if (isset($_SESSION['adm'])) {
    $backBtn = "dashboard.php";
}

//fetch and populate form
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE user_id={$id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $fname = $data['first_name'];
        $lname = $data['last_name'];
        $email = $data['email'];
        $number = $data['phone_number'];
        $address = $data['address'];
        $picture = $data['picture'];
    }
}

//update
$class = 'd-none';
if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $number = $data['phone_number'];
    $address = $data['address'];
    $user_id = $_POST['id'];
    $uplpoadError = "";
    $pictureArray = file_upload($_FILES['picture']);
    $picture = $pictureArray->fileName;
    if ($pictureArray->error === 0) {
        ($_POST['picture'] == "user.jpg") ?: unlink("pictures/{$_POST['picture']}");
        $sql = "UPDATE users SET first_name='$fname', last_name='$lname', email='$email', phone_number='$number', address='$address', picture='$pictureArray->fileName' WHERE user_id = {$user_id}";
    } else {
        $sql = "UPDATE users SET first_name='$fname', last_name='$lname', email='$email', phone_number='$number', address='$address' WHERE user_id = {$user_id}";
    }

    if (mysqli_query($connect, $sql) === TRUE) {
        $icon = "<i class='fa-regular fa-circle-check text-success icon-alert'></i>";
        $message = "<div> Your Profile was successfully updated!</div>";
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : "";
        header("refresh:3;url=update.php?id={$id}");
    } else {
        $icon = "<i class='fa-regular fa-circle-xmark text-danger'></i>";
        $message = "Error while updating your Profile. Please try again.. <br>" . mysqli_connect_error();
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : "";
        header("refresh:3;url=update.php?id={$id}");
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
    <title>Update Profile - Shelterd</title>
    <?php require_once "components/style.php" ?>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!------------------
    Nav Bar
-------------------->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-paw me-3"></i>Sheltered</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            </div>

            <p class="nav-item"><a href="logout.php?logout" class="nav-link">Logout<i class="fa-solid fa-arrow-right-from-bracket ms-2"></i></a></p>
        </div>
    </nav>

    <!------------------
   Hero
-------------------->
    <div class="dashboard-hero">
        <div class="dashboard-text">
            <img src="pictures/<?php echo $picture ?>" alt="" width='150' height='150' class="dashboard-pic">
            <h3 class="mt-3"><?php echo $fname . " " . $lname ?></h3>
        </div>
    </div>

    <!------------------
Form
-------------------->
    <div class="container my-5">
        <form method="post" enctype="multipart/form-data" class="mx-auto w-75">

            <!---Name--->
            <div class="mb-4">
                <input type="text" class="w-100 " maxlength="50" name="fname" placeholder="First Name" value="<?php echo $fname ?>">

            </div>

            <div class="mb-4">
                <input type="text" class="w-100 " maxlength="50" name="lname" placeholder="Last Name" value="<?php echo $lname ?>">

            </div>
            <!---Email--->
            <div class="mb-4">
                <input type="email" class="w-100 " name="email" maxlength="40" placeholder="Email Address" value="<?php echo $email ?>">

            </div>
            <!---Phone number--->
            <div class="mb-4">
                <input type="text" class="w-100 " name="number" placeholder="Phone Number" maxlength="20" value="<?php echo $number ?>">

            </div>
            <!---Address--->
            <div class="mb-4">
                <input type="text" class="w-100 " name="address" placeholder="Address" maxlength="50" value="<?php echo $address ?>">

            </div>
            <!--- Picture--->
            <div class="mb-4">
                <input type="file" class="w-100 " name="picture">
            </div>



            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="hidden" name="picture" value="<?php echo $picture ?>">

            <a href="<?php echo $backBtn ?>"><button class="btn btn-outline-dark w-100 me-5 mb-3" type='button'>Go Back</button></a>

            <button type='submit' name="submit" class="btn btn-outline-dark w-100">Save Changes</button>
        </form>


    </div>

</body>

</html>