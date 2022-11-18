<?php
session_start();
if (isset($_SESSION['user']) != "") {
    header("location: ../home.php");
    exit;
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: ../index.php");
    exit;
}

require_once "../components/db_connect.php";

if ($_GET['id']) {
    $pet_id = $_GET['id'];
    $sql = "SELECT * FROM pets WHERE pet_id = {$pet_id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $name = $data['name'];
        $age = $data['age'];
        $picture = $data['picture'];
        $location = $data['location'];
        $description = $data['description'];
        $size = $data['size'];
        $vaccination = $data['vaccination'];
        $breed = $data['breed'];
        $status = $data['status'];
    } else {
        header("location: error.php");
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete - Sheltered</title>
    <?php require_once "../components/style.php"; ?>
    <link rel="stylesheet" href="../style.css">
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

            <p> <a href="../logout.php?logout">Logout</a></p>

        </div>
    </nav>

    <!------------------
   Hero
-------------------->
    <div class="dashboard-hero">
        <div class="dashboard-text">
            <h1>Update Request for: <br> <?php echo $name ?></h1>
            <img src="../pictures/<?php echo $picture ?>" alt="" width='150' height='150' class="dashboard-pic">

        </div>
    </div>

    <!------------------
   Form to update Pets
-------------------->

    <div class="container my-5">
        <form action="actions/a_update.php" method="post" enctype="multipart/form-data" class="mx-auto w-75">


            <div class="d-flex mb-3">
                <input name='name' type="text" placeholder="Name" class="w-50 me-5" value="<?php echo $name ?>">
                <input name='age' type="number" placeholder="Age" class="w-50" value="<?php echo $age ?>">
            </div>
            <div class="d-flex mb-3">
                <input name='size' type="number" placeholder="size in cm" class="w-50 me-5" value="<?php echo $size ?>">

                <input name='breed' type="text" placeholder="Breed if known" class="w-50" value="<?php echo $breed ?>">
            </div>

            <div class="d-flex mb-3">
                <input name='location' type="text" placeholder="location" class="w-50 me-5" value="<?php echo $location ?>">
                <select name="vaccination" class="w-50">
                    <option value="null" selected>Vaccineted?</option>
                    <option value="yes">yes</option>
                    <option value="no">no</option>
                </select>
            </div>

            <div class="d-flex mb-5">
                <input type="file" name="picture" class="w-50 me-5">
                <input type="text" name="description" placeholder="Description" class="w-50" value="<?php echo $description ?>">
            </div>

            <input type="hidden" name="pet_id" value="<?php echo $data['pet_id'] ?>">
            <input type="hidden" name="picture" value="<?php echo $data['picture'] ?>">

            <!--Button to upload or go back-->
            <a href="../dashboard.php"><button class="btn btn-outline-dark w-100 me-5 mb-3" type='button'>Go Back</button></a>

            <button type='submit' class="btn btn-outline-dark w-100">Save Changes</button>
        </form>


    </div>


</body>

</html>