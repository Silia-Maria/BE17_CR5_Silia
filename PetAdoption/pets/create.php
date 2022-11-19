<?php
session_start();
require_once "../components/db_connect.php";

if (isset($_SESSION['user']) != "") {
    header("location: ../home.php");
    exit;
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: ../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload - Sheltered</title>
    <?php require_once "../components/style.php"; ?>
    <link rel="stylesheet" href="../style.css">
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

            <p class="nav-item"><a href="../logout.php?logout" class="nav-link">Logout<i class="fa-solid fa-arrow-right-from-bracket ms-2"></i></a></p>
        </div>
    </nav>

    <!------------------
   Hero
-------------------->
    <div class="dashboard-hero">
        <div class="dashboard-text">
            <h1>New Pets <br> looking for a loving Home...</h1>
        </div>
    </div>

    <!------------------
   Form to upload new Pets
-------------------->

    <div class="container my-5">
        <form action="actions/a_create.php" method="post" enctype="multipart/form-data" class="mx-auto w-75">


            <div class="d-flex mb-3">
                <input name='name' type="text" placeholder="Name" class="w-50 me-5">
                <input name='age' type="number" placeholder="Age" class="w-50">
            </div>
            <div class="d-flex mb-3">
                <input name='size' type="number" placeholder="size in cm" class="w-50 me-5">

                <input name='breed' type="text" placeholder="Breed if known" class="w-50">
            </div>

            <div class="d-flex mb-3">
                <input name='location' type="text" placeholder="location" class="w-50 me-5">
                <select name="vaccination" class="w-50">
                    <option value="null" selected>Vaccineted?</option>
                    <option value="yes">yes</option>
                    <option value="no">no</option>
                </select>
            </div>

            <div class="d-flex mb-5">
                <input type="file" name="picture" class="w-50 me-5">
                <input type="text" name="description" placeholder="Description" class="w-50">
            </div>
            <!--Button to upload or go back-->
            <a href="../dashboard.php"><button class="btn btn-outline-dark w-100 me-5 mb-3" type='button'>Go Back</button></a>

            <button type='submit' class="btn btn-outline-dark w-100">Upload Pet</button>
        </form>


    </div>


</body>

</html>