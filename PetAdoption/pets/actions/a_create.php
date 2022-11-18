<?php
session_start();
if (isset($_SESSION['user']) != "") {
    header("location: ../../home.php");
    exit;
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: ../../index.php");
    exit;
}

require_once "../../components/db_connect.php";
require_once "../../components/file_upload.php";

if ($_POST) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $age = $_POST['age'];
    $description = $_POST['description'];
    $vaccination = $_POST['vaccination'];
    $size = $_POST['size'];
    $breed = $_POST['breed'];

    $uploadError = "";
    $picture = file_upload($_FILES['picture'], 'pet');

    $sql = "INSERT INTO pets (name, picture, location, age, description, size, vaccination, breed) VALUES ('$name', '$picture->fileName', '$location', $age, '$description', $size, '$vaccination', '$breed')";

    if (mysqli_query($connect, $sql) == TRUE) {
        $icon = "<i class='fa-regular fa-circle-check text-success icon-alert'></i>";
        $message = "<div>New Pet:  <em>$name </em> <br>was successfully uploaded and is ready to find a new Home!</div>";
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : "";
    } else {
        $icon = "<i class='fa-regular fa-circle-xmark text-danger'></i>";
        $message = "Error while creating record. Please try again.. <br>" . $connect->error;
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : "";
    }
    mysqli_close($connect);
} else {
    header("Location: ../error.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload - Shelterd</title>
    <?php require_once "../../components/style.php" ?>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>

    <!------------------
    Nav Bar
-------------------->
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sheltered</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            </div>

            <p> <a href="../../logout.php?logout">Logout</a></p>

        </div>
    </nav>


    <!------------------
Alert
-------------------->

    <div class="container mt-5">
        <div class="w-50 mx-auto border rounded text-center p-5">
            <div class="mb-4"><?php echo $icon ?></div>
            <h5><?php echo $message ?></h5>
            <a href="../../dashboard.php"><button class="btn btn-outline-dark mt-3">Go Back</button></a>
        </div>

    </div>

</body>

</html>