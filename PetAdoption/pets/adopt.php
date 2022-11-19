<?php
session_start();
if (isset($_SESSION['adm']) != "") {
    header("location: ../dashboard.php");
    exit;
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: ../index.php");
    exit;
}
require_once "../components/db_connect.php";

// Select all from pets
if ($_POST) {
    $pet_id = $_POST['pet_id'];
    $query = "SELECT * FROM pets WHERE pet_id = {$pet_id}";
    $pet_res = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($pet_res);
    $name = $data['name'];
    $age = $data['age'];
    $picture = $data['picture'];
    $location = $data['location'];
    $description = $data['description'];
    $size = $data['size'];
    $vaccination = $data['vaccination'];
    $breed = $data['breed'];
    $status = $data['status'];
}

//user 
$query_user = "SELECT * FROM users WHERE user_id = {$_SESSION['user']}";
$user_res = mysqli_query($connect, $query_user);
$data_user = mysqli_fetch_assoc($user_res);
$fname = $data_user['first_name'];
$lname = $data_user['last_name'];
$picture_user = $data_user['picture'];
$email = $data_user['email'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt - Sheltered</title>
    <?php require_once "../components/style.php"; ?>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <!------------------
    Nav Bar
-------------------->
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php"><i class="fa-solid fa-paw me-3"></i>Sheltered</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">

            </div>

            <img src="pictures/<?= $row['picture'] ?>" class="nav-pic me-2" alt="">
            <p class="me-4 my-auto"> <a href="../update.php?id=<?php echo $_SESSION['user'] ?>">Welcome <?= $row['first_name'] ?></a></p>

            <p class="nav-item my-auto"><a href="../logout.php?logout" class="nav-link">Logout<i class="fa-solid fa-arrow-right-from-bracket ms-2"></i></a></p>
        </div>
    </nav>


    <!------------------
   Hero
-------------------->
    <div class="dashboard-hero">
        <div class="dashboard-text">
            <h1>You almost did it!</h1>
            <h2>Only one more click to adopt cute <?= $name ?></h2>
        </div>
    </div>

    <!------------------
 Form
-------------------->

    <div class="container my-5">

        <div class="row ms-auto ">
            <img class='col-6' style='height: 60vh;' src="../pictures/<?= $picture ?>" alt="">
            <div class="col-6 align-self-end">
                <p> Please select the date you would like to come and pick up your new Friend!</p>
                <form action="actions/a_adopt.php" method="post">
                    <input type="date" name="adoption_date" class="w-100" />
                    <input type='hidden' name='pet_id' value='<?php echo $pet_id ?>' />
                    <input type="hidden" name='new_status' value="Adopted">
                    <button type='submit' name='submit' class='btn btn-outline-dark mt-3 w-100'>adopt!</button>
                </form>
            </div>

        </div>

    </div>

</body>

</html>